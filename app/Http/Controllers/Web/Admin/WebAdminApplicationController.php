<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Admin\WebAdminApplicationStoreRequest;
use App\Models\Application;
use App\Models\Dtos\ApplicationStoreDto;
use App\Models\Dtos\ApplicationUpdateDto;
use App\Services\ServiceImpl\ApplicationServiceImpl;
use Illuminate\Http\Request;

class WebAdminApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        return view('web.admin.application.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        return view('web.admin.application.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WebAdminApplicationStoreRequest $request)
    {
        //
        ApplicationServiceImpl::store(ApplicationStoreDto::fromJson($request->all()));

        return redirect()->route('web.admin.application.index')->with(['success' => true]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Application $application)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Application $application)
    {
        //

        return view('web.admin.application.edit', compact('application'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Application $application)
    {
        //

        ApplicationServiceImpl::update(ApplicationUpdateDto::fromJson($request->all()));

        return redirect()->route('web.admin.application.index')->with(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Application $application)
    {
        //
    }
}
