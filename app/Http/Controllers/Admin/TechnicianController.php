<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTechnicianRequest;
use App\Http\Requests\Admin\UpdateTechnicianRequest;
use App\Models\SystemNotification;
use App\Models\Technician;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TechnicianController extends Controller
{
    public function index(): View
    {
        $technicians = Technician::query()
            ->with('user')
            ->withCount('repairRequests')
            ->latest()
            ->paginate(10);

        return view('admin.technicians.index', compact('technicians'));
    }

    public function create(): View
    {
        return view('admin.technicians.create');
    }

    public function store(StoreTechnicianRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request): void {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'password' => Hash::make($request->password),
                'role' => 'technician',
            ]);

            Technician::create([
                'user_id' => $user->id,
                'specialization' => $request->specialization,
                'availability_status' => $request->availability_status,
            ]);
        });

        return redirect()
            ->route('admin.technicians.index')
            ->with('success', 'Technician account has been created successfully.');
    }

    public function show(Technician $technician): View
    {
        $technician->load([
            'user',
            'repairRequests.customer.user',
            'repairRequests.device',
            'repairRequests.invoice',
        ]);

        return view('admin.technicians.show', compact('technician'));
    }

    public function edit(Technician $technician): View
    {
        $technician->load('user');

        return view('admin.technicians.edit', compact('technician'));
    }

    public function update(UpdateTechnicianRequest $request, Technician $technician): RedirectResponse
    {
        DB::transaction(function () use ($request, $technician): void {
            $technician->user->update([
                'name' => $request->name,
                'phone_number' => $request->phone_number,
            ]);

            $technician->update([
                'specialization' => $request->specialization,
                'availability_status' => $request->availability_status,
            ]);
        });

        return redirect()
            ->route('admin.technicians.show', $technician)
            ->with('success', 'Technician details have been updated successfully.');
    }

    public function destroy(Technician $technician): RedirectResponse
    {
        if ($technician->repairRequests()->exists()) {
            return redirect()
                ->route('admin.technicians.index')
                ->with('error', 'This technician cannot be deleted because they already have assigned repair tasks.');
        }

        DB::transaction(function () use ($technician): void {
            $user = $technician->user;

            if ($user) {
                SystemNotification::query()
                    ->where('user_id', $user->id)
                    ->delete();
            }

            $technician->delete();

            if ($user) {
                $user->delete();
            }
        });

        return redirect()
            ->route('admin.technicians.index')
            ->with('success', 'Technician account has been deleted successfully.');
    }
}