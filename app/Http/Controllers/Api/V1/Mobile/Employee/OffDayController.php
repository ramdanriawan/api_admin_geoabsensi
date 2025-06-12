<?php
namespace App\Http\Controllers\Api\V1\Mobile\Employee;

use App\Http\Controllers\Controller;
use App\Services\ServiceImpl\EmployeeOffDayServiceImpl;
use App\Services\ServiceImpl\OffDayServiceImpl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RamdanRiawan\ResponseJson;

class OffDayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $data = OffDayServiceImpl::findAll();

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
        $offDay = OffDayServiceImpl::findByEmployeeId($request->user()->id);

        if ($offDay) {
            if ($offDay->isWaiting) {

                return ResponseJson::exist();
            }
        }

        // validasi
        $validator = Validator::make($request->all(), [
            'start_date' => 'required|date|before:end_date',
            'end_date'   => 'required|date|after:start_date',
        ]);

        if ($validator->fails()) {
            return ResponseJson::badRequest($validator->failed());
        }

        // pengecekan quota
        $employee       = $request->user()->employee;
        $employeeOffDay = EmployeeOffDayServiceImpl::findByEmployeeAndTypeId($employee->id, $request->off_type_id);

        if (! $employeeOffDay) {
            return ResponseJson::notFound();
        }

        if (! $employeeOffDay->quota) {
            return ResponseJson::badRequest('quota exceeded');
        }

        // pengecekan status apakah sudah pernah diadd tapi belum di acc
        $offDay = OffDayServiceImpl::findByEmployeeIdAndStatus($request->user()->employee->id, 'waiting');

        if ($offDay) {
            return ResponseJson::exist();
        }

        $offDay = OffDayServiceImpl::store(
            $request->user()->employee->id,
            $request->off_type_id,
            $request->start_date,
            $request->end_date
        );

        return ResponseJson::success($offDay);
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

    public function findLastByUserId(Request $request)
    {
        $offDay = OffDayServiceImpl::findLastByUserId($request->user()->id);

        if (! $offDay) {
            return ResponseJson::notFound();
        }

        return ResponseJson::success($offDay);
    }
}
