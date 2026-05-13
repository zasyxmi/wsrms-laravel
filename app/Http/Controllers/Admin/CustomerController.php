<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Contracts\View\View;

class CustomerController extends Controller
{
    public function index(): View
    {
        $customers = Customer::query()
            ->with('user')
            ->latest()
            ->paginate(10);

        return view('admin.customers.index', compact('customers'));
    }

    public function show(Customer $customer): View
    {
        $customer->load([
            'user',
            'devices',
            'repairRequests.device',
            'repairRequests.technician.user',
            'repairRequests.invoice',
        ]);

        return view('admin.customers.show', compact('customer'));
    }
}