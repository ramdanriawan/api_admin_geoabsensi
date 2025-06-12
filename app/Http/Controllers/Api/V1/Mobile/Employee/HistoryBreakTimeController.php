<?php

namespace App\Http\Controllers\Api\V1\Mobile\Employee;

use App\Http\Controllers\Controller;
use App\Services\ServiceImpl\BreakTimeServiceImpl;
use Illuminate\Http\Request;
use RamdanRiawan\ResponseJson;

class HistoryBreakTimeController extends Controller
{
    //
    public function findAllByCurrentUser(Request $request) {

        $breakTime = BreakTimeServiceImpl::findAllByUserId($request->user(), 0, 50);

        if(empty($breakTime)) {
            return ResponseJson::notFound();
        }

        return ResponseJson::success($breakTime);
    }
}
