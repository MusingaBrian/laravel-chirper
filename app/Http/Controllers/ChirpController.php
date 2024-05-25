<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;

class ChirpController extends Controller
{

    public function index(): View
    {

        return View('chirps.index', [
            'chirps' => Chirp::with('user')->latest()->get(),
        ]);
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:255'
        ]);

        $request->user()->chirps()->create($validated);

        return redirect(route('chirps.index'));
    }


    public function show(Chirp $chirp)
    {
        //
    }


    public function edit(Chirp $chirp): View
    {
        Gate::authorize('update', $chirp);

        return view('chirps.edit', [
            'chirp' => $chirp,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chirp $chirp): RedirectResponse
    {
        Gate::authorize('update', $chirp);

        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);

        $chirp->update($validated);

        return redirect(route('chirps.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp)
    {
        //
    }
}
