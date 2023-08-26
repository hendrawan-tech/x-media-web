<?php

namespace App\Http\Controllers;

use App\Models\App;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\AppStoreRequest;
use App\Http\Requests\AppUpdateRequest;
use Illuminate\Support\Facades\Storage;

class AppController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', App::class);

        $search = $request->get('search', '');

        $apps = App::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.apps.index', compact('apps', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', App::class);

        return view('app.apps.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AppStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', App::class);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $app = App::create($validated);

        return redirect()
            ->route('apps.edit', $app)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, App $app): View
    {
        $this->authorize('view', $app);

        return view('app.apps.show', compact('app'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, App $app): View
    {
        $this->authorize('update', $app);

        return view('app.apps.edit', compact('app'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        AppUpdateRequest $request,
        App $app
    ): RedirectResponse {
        $this->authorize('update', $app);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            if ($app->image) {
                Storage::delete($app->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        $app->update($validated);

        return redirect()
            ->route('apps.edit', $app)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, App $app): RedirectResponse
    {
        $this->authorize('delete', $app);

        if ($app->image) {
            Storage::delete($app->image);
        }

        $app->delete();

        return redirect()
            ->route('apps.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
