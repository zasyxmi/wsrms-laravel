<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Device;
use Illuminate\Contracts\View\View;

class DeviceController extends Controller
{
    public function index(): View
    {
        $devices = Device::query()
            ->with(['customer.user'])
            ->withCount('repairRequests')
            ->latest()
            ->paginate(10);

        return view('admin.devices.index', compact('devices'));
    }

    public function show(Device $device): View
    {
        $device->load([
            'customer.user',
            'repairRequests.customer.user',
            'repairRequests.technician.user',
            'repairRequests.invoice',
        ]);

        return view('admin.devices.show', compact('device'));
    }
}