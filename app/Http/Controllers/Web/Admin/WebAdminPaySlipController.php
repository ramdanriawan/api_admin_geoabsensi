<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Admin\WebAdminPaySlipStoreRequest;
use App\Http\Requests\Web\Admin\WebAdminPaySlipUpdateRequest;
use App\Models\Dtos\PaySlipStoreDto;
use App\Models\Dtos\PaySlipUpdateDto;
use App\Models\PaySlip;
use App\Services\ServiceImpl\PaySlipServiceImpl;

class WebAdminPayslipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        return view('web.admin.paySlip.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        return view('web.admin.paySlip.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WebAdminPaySlipStoreRequest $request)
    {
        //
        PaySlipServiceImpl::store(PaySlipStoreDto::fromJson($request->all()));

        return redirect()->route('web.admin.paySlip.index')->with('success', true);
    }

    /**
     * Display the specified resource.
     */
    public function show(PaySlip $paySlip)
    {
        //

        return view('web.admin.paySlip.show', compact('paySlip'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaySlip $paySlip)
    {
        //

        return view('web.admin.paySlip.edit', compact('paySlip'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WebAdminPaySlipUpdateRequest $request, PaySlip $paySlip)
    {
        //
        PaySlipServiceImpl::update(PaySlipUpdateDto::fromJson($request->all()));

        return redirect()->route('web.admin.paySlip.index')->with('success', true);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaySlip $paySlip)
    {
        //
    }
}
