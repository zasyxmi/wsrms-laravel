<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SparePart;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\SparePartRequest;


class SparePartController extends Controller
{
    public function index(): View
    {
        $spareParts = SparePart::query()
            ->latest()
            ->paginate(10);

        return view('admin.spare-parts.index', compact('spareParts'));
    }

    public function create(): View
    {
        return view('admin.spare-parts.create');
    }

    public function store(SparePartRequest $request): RedirectResponse
{
    SparePart::create($request->validated());

    return redirect()
        ->route('admin.spare-parts.index')
        ->with('success', 'Spare part has been added successfully.');
}

    public function show(SparePart $sparePart): View
    {
        return view('admin.spare-parts.show', compact('sparePart'));
    }

    public function edit(SparePart $sparePart): View
    {
        return view('admin.spare-parts.edit', compact('sparePart'));
    }

    public function update(SparePartRequest $request, SparePart $sparePart): RedirectResponse
{
    $sparePart->update($request->validated());

    return redirect()
        ->route('admin.spare-parts.index')
        ->with('success', 'Spare part has been updated successfully.');
}

    public function destroy(SparePart $sparePart): RedirectResponse
{
    if ($sparePart->repairSpareParts()->exists()) {
        return redirect()
            ->route('admin.spare-parts.index')
            ->with('error', 'This spare part cannot be deleted because it has been used in a repair record.');
    }

    $sparePart->delete();

    return redirect()
        ->route('admin.spare-parts.index')
        ->with('success', 'Spare part has been deleted successfully.');
}
}