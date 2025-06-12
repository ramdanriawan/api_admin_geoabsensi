<?php

namespace App\Http\Controllers\Api\V1\Mobile\Employee;

use App\Http\Controllers\Controller;
use App\Services\ServiceImpl\TripServiceImpl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RamdanRiawan\ResponseJson;

class TripController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $data = TripServiceImpl::findAll();

        return ResponseJson::success($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // kalau seandainya sudah ada maka ga bisa
        $trip = TripServiceImpl::findByEmployeeId($request->user()->id);

        if($trip) {
            if($trip->isWaiting) {

                return ResponseJson::exist();
            }
        }

        // validasi
        $validator = Validator::make($request->all(), [
            'trip_type_id' => 'required|exists:trip_types,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'picture' => 'required|image'
        ]);

        if($validator->fails()) {
            return ResponseJson::badRequest($validator->failed());
        }

        // pengecekan status apakah sudah pernah diadd tapi belum di acc
        $trip = TripServiceImpl::findByEmployeeIdAndStatus($request->user()->employee->id, 'waiting');

        if($trip) {
            return ResponseJson::exist();
        }

        $trip = TripServiceImpl::store(
            $request->user()->employee->id,
            $request->trip_type_id,
            $request->start_date,
            $request->end_date,
            $request->lat,
            $request->lng,
            $request->file('picture'),
        );

        return ResponseJson::success($trip);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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

    public function findLastByUserId(Request $request) {
        $trip = TripServiceImpl::findLastByUserId($request->user()->id);

        if(!$trip) {
            return ResponseJson::notFound();
        }

        return ResponseJson::success($trip);
    }
}
