<?php

namespace App\Http\Controllers\Api\V1\Mobile\Employee;

use App\Http\Controllers\Controller;
use App\Models\UserShift;
use App\Services\ServiceImpl\UserShiftServiceImpl;
use Illuminate\Http\Request;
use RamdanRiawan\ResponseJson;

class UserShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function findOneByUserLogin(Request $request) {
        $user = $request->user();

        $userShift = UserShiftServiceImpl::findByUserId($user->id);

        if(!$userShift) {
            return ResponseJson::notFound();
        }

        return ResponseJson::success($userShift);
    }
}
