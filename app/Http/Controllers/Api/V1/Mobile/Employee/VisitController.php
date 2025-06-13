<?php
namespace App\Http\Controllers\Api\V1\Mobile\Employee;

use App\Http\Controllers\Controller;
use App\Models\Visit;
use App\Services\ServiceImpl\VisitServiceImpl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RamdanRiawan\ResponseJson;

class VisitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return ResponseJson::success(Visit::all());
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
        $Validator = Validator::make($request->all(), [
            'visit_type_id' => 'required|numeric|exists:visit_types,id',
            'lat'           => 'required|numeric',
            'lng'           => 'required|numeric',
            'picture'       => 'required|image',
        ]);

        if ($Validator->fails()) {
            return ResponseJson::badRequest($Validator->failed());
        }

        // cek apakah previouse visitnya kecepetan
        $visit = VisitServiceImpl::findByUserId($request->user()->id);

        if($visit?->isTooFaster){
            return ResponseJson::badRequest("visits are too fast");
        }

        $attendance = VisitServiceImpl::store(
            $request->user(), $request->file('picture'),
            $request->lat, $request->lng,
            $request->visit_type_id
        );

        return ResponseJson::success($attendance);
    }

    /**
     * Display the specified resource.
     */
    public function show(Visit $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Visit $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Visit $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Visit $attendance)
    {
        //
    }

    public function findByUserId(Request $request)
    {
        $attendance = VisitServiceImpl::findByUserId($request->user()->id);

        if (! $attendance) {
            return ResponseJson::notFound();
        }

        return ResponseJson::success($attendance);
    }

}
