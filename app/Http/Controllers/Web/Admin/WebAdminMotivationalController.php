<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Admin\WebAdminMotivationalStoreRequest;
use App\Http\Requests\Web\Admin\WebAdminMotivationalUpdateRequest;
use App\Models\Dtos\MotivationalStoreDto;
use App\Models\Dtos\MotivationalUpdateDto;
use App\Models\Motivational;
use App\Services\ServiceImpl\MotivationalServiceImpl;

class WebAdminMotivationalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('web.admin.motivational.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        return view('web.admin.motivational.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WebAdminMotivationalStoreRequest $request)
    {
        //
        MotivationalServiceImpl::store(
            MotivationalStoreDto::fromJson($request->all())
        );

        return redirect()->route('web.admin.motivational.index')->with('success', true);
    }

    /**
     * Display the specified resource.
     */
    public function show(Motivational $motivational)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Motivational $motivational)
    {
        //

        return view('web.admin.motivational.edit', compact('motivational'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WebAdminMotivationalUpdateRequest $request, Motivational $motivational)
    {
        //
        MotivationalServiceImpl::update(
            MotivationalUpdateDto::fromJson([
                "id" => $motivational->id,
                ...$request->all()
            ]),
        );

        return redirect()->route('web.admin.motivational.index')->with('success', true);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Motivational $motivational)
    {
        //

        MotivationalServiceImpl::delete($motivational);

        return redirect()->route('web.admin.motivational.index')->with('success', true);
    }
}
