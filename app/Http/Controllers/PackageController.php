<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\PackageStoreRequest;
use App\Http\Requests\PackageUpdateRequest;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Package::class);

        $search = $request->get('search', '');

        $packages = Package::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.packages.index', compact('packages', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Package::class);

        return view('app.packages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PackageStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Package::class);

        $validated = $request->validated();

        $package = Package::create($validated);

        return redirect()
            ->route('packages.edit', $package)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Package $package): View
    {
        $this->authorize('view', $package);

        return view('app.packages.show', compact('package'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Package $package): View
    {
        $this->authorize('update', $package);

        return view('app.packages.edit', compact('package'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        PackageUpdateRequest $request,
        Package $package
    ): RedirectResponse {
        $this->authorize('update', $package);

        $validated = $request->validated();

        $package->update($validated);

        return redirect()
            ->route('packages.edit', $package)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Package $package
    ): RedirectResponse {
        $this->authorize('delete', $package);

        $package->delete();

        return redirect()
            ->route('packages.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
