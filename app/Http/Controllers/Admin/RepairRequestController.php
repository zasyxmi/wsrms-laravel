<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AssignTechnicianRequest;
use App\Models\RepairRequest;
use App\Models\SystemNotification;
use App\Models\Technician;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

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

        $repairRequest->update([
            'status' => 'approved',
        ]);

        SystemNotification::create([
            'user_id' => $repairRequest->customer->user_id,
            'title' => 'Repair Request Approved',
            'message' => 'Your repair request ' . $repairRequest->repair_code . ' has been approved by the admin.',
            'type' => 'success',
        ]);

        return redirect()
            ->route('admin.repair-requests.show', $repairRequest)
            ->with('success', 'Repair request has been approved successfully.');
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
        if ($repairRequest->status !== 'approved') {
            return redirect()
                ->route('admin.repair-requests.show', $repairRequest)
                ->with('error', 'Only approved repair requests can be assigned to a technician.');
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
        if ($repairRequest->status !== 'approved') {
            return redirect()
                ->route('admin.repair-requests.show', $repairRequest)
                ->with('error', 'Only approved repair requests can be assigned to a technician.');
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
}