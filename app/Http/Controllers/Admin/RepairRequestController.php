<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AssignTechnicianRequest;
use App\Mail\RepairRequestApprovedMail;
use App\Models\RepairRequest;
use App\Models\SystemNotification;
use App\Models\Technician;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class RepairRequestController extends Controller
{
    public function index(): View
    {
        $repairRequests = RepairRequest::query()
            ->with(['customer.user', 'device', 'technician.user'])
            ->latest()
            ->paginate(10);

        return view('admin.repair-requests.index', compact('repairRequests'));
    }

    public function show(RepairRequest $repairRequest): View
    {
        $repairRequest->load([
        'customer.user',
        'device',
        'technician.user',
        'repairSpareParts.sparePart',
        'invoice',
    ]);
    
        return view('admin.repair-requests.show', compact('repairRequest'));
    }

    public function approve(RepairRequest $repairRequest): RedirectResponse
    {
        if ($repairRequest->status !== 'submitted') {
            return redirect()
                ->route('admin.repair-requests.show', $repairRequest)
                ->with('error', 'Only submitted repair requests can be approved.');
        }

        $assignedTechnician = null;

        DB::transaction(function () use ($repairRequest, &$assignedTechnician): void {
            $repairRequest->loadMissing(['customer.user', 'device']);
            $assignedTechnician = $this->findBestTechnicianForRequest($repairRequest);

            if ($assignedTechnician) {
                $repairRequest->update([
                    'technician_id' => $assignedTechnician->id,
                    'status' => 'assigned',
                ]);

                SystemNotification::create([
                    'user_id' => $repairRequest->customer->user_id,
                    'title' => 'Repair Request Approved',
                    'message' => 'Your repair request has been approved and assigned to ' . $assignedTechnician->user->name . '. Please bring your device to the workshop for physical diagnosis.',
                    'type' => 'success',
                ]);

                SystemNotification::create([
                    'user_id' => $assignedTechnician->user_id,
                    'title' => 'New Repair Task Assigned',
                    'message' => 'Repair request ' . $repairRequest->repair_code . ' has been assigned to you.',
                    'type' => 'info',
                ]);

                return;
            }

            $repairRequest->update([
                'status' => 'approved',
            ]);

            SystemNotification::create([
                'user_id' => $repairRequest->customer->user_id,
                'title' => 'Repair Request Approved',
                'message' => 'Your repair request has been approved. Please bring your device to the workshop for physical diagnosis.',
                'type' => 'info',
            ]);
        });

        $this->sendApprovalEmail($repairRequest);

        if (! $assignedTechnician) {
            return redirect()
                ->route('admin.repair-requests.show', $repairRequest)
                ->with('error', 'Repair request approved, but no available technician matched the device type. Please assign manually.');
        }

        return redirect()
            ->route('admin.repair-requests.show', $repairRequest)
            ->with('success', 'Repair request approved and automatically assigned to ' . $assignedTechnician->user->name . '.');
    }

    public function reject(RepairRequest $repairRequest): RedirectResponse
    {
        if ($repairRequest->status !== 'submitted') {
            return redirect()
                ->route('admin.repair-requests.show', $repairRequest)
                ->with('error', 'Only submitted repair requests can be rejected.');
        }

        $repairRequest->update([
            'status' => 'rejected',
        ]);

        SystemNotification::create([
            'user_id' => $repairRequest->customer->user_id,
            'title' => 'Repair Request Rejected',
            'message' => 'Your repair request ' . $repairRequest->repair_code . ' has been rejected by the admin.',
            'type' => 'danger',
        ]);

        return redirect()
            ->route('admin.repair-requests.show', $repairRequest)
            ->with('success', 'Repair request has been rejected successfully.');
    }

    public function assignForm(RepairRequest $repairRequest): View|RedirectResponse
    {
        if (! in_array($repairRequest->status, ['approved', 'assigned'], true)) {
            return redirect()
                ->route('admin.repair-requests.show', $repairRequest)
                ->with('error', 'Only approved or assigned repair requests can be assigned to a technician.');
        }

        $repairRequest->load(['customer.user', 'device', 'technician.user']);

        $technicians = Technician::query()
            ->with('user')
            ->where('availability_status', 'available')
            ->get();

        return view('admin.repair-requests.assign', compact('repairRequest', 'technicians'));
    }

    public function assign(AssignTechnicianRequest $request, RepairRequest $repairRequest): RedirectResponse
    {
        if (! in_array($repairRequest->status, ['approved', 'assigned'], true)) {
            return redirect()
                ->route('admin.repair-requests.show', $repairRequest)
                ->with('error', 'Only approved or assigned repair requests can be assigned to a technician.');
        }

        $repairRequest->update([
            'technician_id' => $request->technician_id,
            'status' => 'assigned',
        ]);

        $repairRequest->load(['customer.user', 'technician.user']);

        SystemNotification::create([
            'user_id' => $repairRequest->customer->user_id,
            'title' => 'Technician Assigned',
            'message' => 'A technician has been assigned to your repair request ' . $repairRequest->repair_code . '.',
            'type' => 'info',
        ]);

        SystemNotification::create([
            'user_id' => $repairRequest->technician->user_id,
            'title' => 'New Repair Task Assigned',
            'message' => 'Repair request ' . $repairRequest->repair_code . ' has been assigned to you.',
            'type' => 'info',
        ]);

        return redirect()
            ->route('admin.repair-requests.show', $repairRequest)
            ->with('success', 'Technician has been assigned successfully.');
    }

    /**
     * Final step of the workflow: admin confirms the customer has physically
     * collected the repaired device. This is the ONLY place the repair
     * status is allowed to become 'completed'.
     */
    public function confirmPickup(RepairRequest $repairRequest): RedirectResponse
    {
        if ($repairRequest->status !== 'ready_for_pickup') {
            return redirect()
                ->route('admin.repair-requests.show', $repairRequest)
                ->with('error', 'This repair request is not ready for pickup confirmation yet.');
        }

        $repairRequest->update([
            'status' => 'completed',
            'completed_date' => now()->toDateString(),
        ]);

        SystemNotification::create([
            'user_id' => $repairRequest->customer->user_id,
            'title' => 'Device Collected',
            'message' => 'Thank you for collecting your device for repair request ' . $repairRequest->repair_code . '. This repair is now marked as completed.',
            'type' => 'success',
        ]);

        return redirect()
            ->route('admin.repair-requests.show', $repairRequest)
            ->with('success', 'Repair request has been marked as completed after device collection.');
    }

    private function findBestTechnicianForRequest(RepairRequest $repairRequest): ?Technician
    {
        $deviceType = $repairRequest->device?->device_type;

        if (! $deviceType) {
            return null;
        }

        return Technician::query()
            ->with('user')
            ->where('specialization', $deviceType)
            ->where('availability_status', 'available')
            ->withCount([
                'repairRequests as active_repair_requests_count' => function ($query): void {
                    $query->whereNotIn('status', [
                        'repair_completed',
                        'waiting_payment',
                        'paid',
                        'ready_for_pickup',
                        'completed',
                        'rejected',
                        'cancelled',
                        'unable_to_repair',
                    ]);
                },
            ])
            ->orderBy('active_repair_requests_count')
            ->orderBy('id')
            ->first();
    }

    private function sendApprovalEmail(RepairRequest $repairRequest): void
    {
        $repairRequest->loadMissing(['customer.user', 'device', 'technician.user']);

        try {
            Mail::to($repairRequest->customer->user->email)
                ->send(new RepairRequestApprovedMail($repairRequest));
        } catch (Throwable $exception) {
            Log::warning('Repair request approval email failed to send.', [
                'repair_request_id' => $repairRequest->id,
                'error' => $exception->getMessage(),
            ]);
        }
    }
}
