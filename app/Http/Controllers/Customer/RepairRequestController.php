<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\StoreRepairRequestRequest;
use App\Models\Device;
use App\Models\RepairRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RepairRequestController extends Controller
{
    public function index(): View
    {
        $customer = Auth::user()->customer;

        $repairRequests = RepairRequest::query()
            ->with(['device', 'technician.user'])
            ->where('customer_id', $customer->id)
            ->latest()
            ->paginate(10);

        return view('customer.repair-requests.index', compact('repairRequests'));
    }

    public function show(RepairRequest $repairRequest): View
    {
        $customer = Auth::user()->customer;

        abort_if($repairRequest->customer_id !== $customer->id, 403, 'Unauthorized access.');

        $repairRequest->load(['device', 'technician.user', 'invoice']);

        return view('customer.repair-requests.show', compact('repairRequest'));
    }

    public function create(): View
    {
        return view('customer.repair-requests.create');
    }

    public function store(StoreRepairRequestRequest $request): RedirectResponse
    {
        $customer = Auth::user()->customer;

        if (! $customer) {
            return redirect()
                ->route('dashboard')
                ->with('error', 'Customer profile was not found.');
        }

        DB::transaction(function () use ($request, $customer): void {
            $device = Device::create([
                'customer_id' => $customer->id,
                'device_type' => $request->device_type,
                'brand' => $request->brand,
                'model' => $request->model,
                'serial_number' => $request->serial_number,
            ]);

            RepairRequest::create([
                'repair_code' => $this->generateRepairCode(),
                'customer_id' => $customer->id,
                'device_id' => $device->id,
                'issue_description' => $request->issue_description,
                'preferred_contact_method' => $request->preferred_contact_method,
                'status' => 'submitted',
                'request_date' => now()->toDateString(),
            ]);
        });

        return redirect()
            ->route('dashboard')
            ->with('success', 'Repair request has been submitted successfully.');
    }

    private function generateRepairCode(): string
    {
        $latestRepairRequest = RepairRequest::query()->latest('id')->first();
        $nextNumber = $latestRepairRequest ? $latestRepairRequest->id + 1 : 1;

        return 'RR' . str_pad((string) $nextNumber, 3, '0', STR_PAD_LEFT);
    }
}