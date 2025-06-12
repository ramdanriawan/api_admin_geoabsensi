<?php
namespace App\Http\Controllers\Api\V1\Mobile\Employee;

use App\Http\Controllers\Controller;
use App\Models\Recape;
use App\Services\ServiceImpl\RecapeServiceImpl;
use Illuminate\Http\Request;
use RamdanRiawan\ResponseJson;

class RecapeController extends Controller
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
    public function show(Recape $recape)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Recape $recape)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recape $recape)
    {
        //
    }

    public function findLastByUserId(Request $request)
    {
        $recape = RecapeServiceImpl::createRecape(
            $request->user(),
            now()->addDays(-30)->format("Y-m-d"),
            date("Y-m-d")
        );


        if(!$recape) {
            return ResponseJson::notFound();
        }

        return ResponseJson::success($recape);
    }
}
