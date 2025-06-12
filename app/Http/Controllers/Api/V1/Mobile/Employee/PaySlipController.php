<?php

namespace App\Http\Controllers\Api\V1\Mobile\Employee;

use App\Http\Controllers\Controller;
use App\Models\PaySlip;
use App\Services\ServiceImpl\PaySlipServiceImpl;
use Illuminate\Http\Request;
use RamdanRiawan\ResponseJson;

class PaySlipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $paySlip = PaySlipServiceImpl::findAll();

        return ResponseJson::success($paySlip);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PaySlip $paySlip)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PaySlip $paySlip)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaySlip $paySlip)
    {
        //
    }

    public function findLastByUserId(Request $request) {
        $paySlip = PaySlipServiceImpl::findLastByUserId($request->user()->id);

        if(!$paySlip) {
            return ResponseJson::notFound();
        }

        return ResponseJson::success($paySlip);
    }

    public function findOneById(Request $request, int $id) {
        $paySlip = PaySlipServiceImpl::findOneById($id);


        if(!$paySlip) {
            return ResponseJson::notFound();
        }

        return ResponseJson::success($paySlip);
    }
}
