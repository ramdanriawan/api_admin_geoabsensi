<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\WebAdminRecapeStoreRequest;
use App\Http\Requests\WebAdminRecapeUpdateRequest;
use App\Models\Recape;
use Illuminate\Http\Request;

class WebAdminRecapeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        return view('web.admin.recape.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        return view('web.admin.recape.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WebAdminRecapeStoreRequest $request)
    {
        //

        return redirect()->route('web.admin.recape.index')->with('success', true);
    }

    /**
     * Display the specified resource.
     */
    public function show(Recape $recape)
    {
        //

        return view('web.admin.recape.show', compact('recape'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Recape $recape)
    {
        //

        return view('web.admin.recape.edit', compact('recape'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WebAdminRecapeUpdateRequest $request, Recape $recape)
    {
        //

        return redirect()->route('web.admin.recape.index')->with('success', true);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recape $recape)
    {
        //
    }
}
