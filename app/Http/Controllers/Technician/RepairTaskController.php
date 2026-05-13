<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;
use App\Models\RepairRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Technician\UpdateDiagnosisRequest;
use App\Models\SystemNotification;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Technician\StoreRepairSparePartRequest;
use App\Models\RepairSparePart;
use App\Models\SparePart;
use Illuminate\Support\Facades\DB;
use App\Models\User;



class RepairTaskController extends Controller
{
    public function index(): View
    {
        $technician = Auth::user()->technician;

        $repairRequests = RepairRequest::query()
            ->with(['customer.user', 'device'])
            ->where('technician_id', $technician->id)
            ->latest()
            ->paginate(10);

        return view('technician.repair-tasks.index', compact('repairRequests'));
    }

    public function show(RepairRequest $repairRequest): View
    {
        $technician = Auth::user()->technician;

        abort_if($repairRequest->technician_id !== $technician->id, 403, 'Unauthorized access.');

        $repairRequest->load(['customer.user', 'device', 'repairSpareParts.sparePart']);

        $spareParts = SparePart::query()
            ->where('stock_quantity', '>', 0)
            ->orderBy('part_name')
            ->get();

        return view('technician.repair-tasks.show', compact('repairRequest', 'spareParts'));
    }
    public function updateDiagnosis(UpdateDiagnosisRequest $request, RepairRequest $repairRequest): RedirectResponse
    {
        $technician = Auth::user()->technician;

        abort_if($repairRequest->technician_id !== $technician->id, 403, 'Unauthorized access.');

        if (in_array($repairRequest->status, ['completed', 'unable_to_repair'], true)) {
            return redirect()
                ->route('technician.repair-tasks.show', $repairRequest)
                ->with('error', 'Diagnosis cannot be updated because this repair task has already been closed.');
        }

        $repairRequest->update([
            'diagnosis_result' => $request->diagnosis_result,
            'repair_notes' => $request->repair_notes,
            'status' => $request->status,
        ]);

        SystemNotification::create([
            'user_id' => $repairRequest->customer->user_id,
            'title' => 'Repair Diagnosis Updated',
            'message' => 'The diagnosis for repair request ' . $repairRequest->repair_code . ' has been updated.',
            'type' => 'info',
        ]);

        return redirect()
            ->route('technician.repair-tasks.show', $repairRequest)
            ->with('success', 'Diagnosis has been updated successfully.');
    }
    public function storeSparePart(StoreRepairSparePartRequest $request, RepairRequest $repairRequest): RedirectResponse
    {
        $technician = Auth::user()->technician;

        abort_if($repairRequest->technician_id !== $technician->id, 403, 'Unauthorized access.');

        if (in_array($repairRequest->status, ['completed', 'unable_to_repair'], true)) {
            return redirect()
                ->route('technician.repair-tasks.show', $repairRequest)
                ->with('error', 'Spare parts cannot be recorded because this repair task has already been closed.');
        }

        $sparePart = SparePart::findOrFail($request->spare_part_id);

        if ($sparePart->stock_quantity < $request->quantity_used) {
            return redirect()
                ->route('technician.repair-tasks.show', $repairRequest)
                ->with('error', 'Insufficient stock for the selected spare part.');
        }

        DB::transaction(function () use ($request, $repairRequest, $sparePart): void {
            $subtotal = $sparePart->unit_price * $request->quantity_used;

            RepairSparePart::create([
                'repair_request_id' => $repairRequest->id,
                'spare_part_id' => $sparePart->id,
                'quantity_used' => $request->quantity_used,
                'unit_price' => $sparePart->unit_price,
                'subtotal' => $subtotal,
            ]);

            $sparePart->decrement('stock_quantity', $request->quantity_used);

            SystemNotification::create([
                'user_id' => $repairRequest->customer->user_id,
                'title' => 'Spare Part Recorded',
                'message' => 'A spare part has been recorded for your repair request ' . $repairRequest->repair_code . '.',
                'type' => 'info',
            ]);
        });

        return redirect()
            ->route('technician.repair-tasks.show', $repairRequest)
            ->with('success', 'Spare part usage has been recorded successfully.');
    }

    public function markCompleted(RepairRequest $repairRequest): RedirectResponse
    {
        $technician = Auth::user()->technician;

        abort_if($repairRequest->technician_id !== $technician->id, 403, 'Unauthorized access.');

        if (in_array($repairRequest->status, ['completed', 'unable_to_repair', 'rejected'], true)) {
            return redirect()
                ->route('technician.repair-tasks.show', $repairRequest)
                ->with('error', 'This repair task cannot be marked as completed.');
        }

        $repairRequest->update([
            'status' => 'completed',
            'completed_date' => now()->toDateString(),
        ]);

        SystemNotification::create([
            'user_id' => $repairRequest->customer->user_id,
            'title' => 'Repair Completed',
            'message' => 'Your repair request ' . $repairRequest->repair_code . ' has been completed. Please wait for the invoice from admin.',
            'type' => 'success',
        ]);

        $admins = User::query()
            ->where('role', 'admin')
            ->get();

        foreach ($admins as $admin) {
            SystemNotification::create([
                'user_id' => $admin->id,
                'title' => 'Repair Ready for Invoice',
                'message' => 'Repair request ' . $repairRequest->repair_code . ' has been completed by the technician and is ready for invoice generation.',
                'type' => 'info',
            ]);
        }

        return redirect()
            ->route('technician.repair-tasks.show', $repairRequest)
            ->with('success', 'Repair task has been marked as completed successfully.');
    }

}