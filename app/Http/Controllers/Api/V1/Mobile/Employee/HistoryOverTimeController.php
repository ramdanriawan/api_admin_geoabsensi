<?php

namespace App\Http\Controllers\Api\V1\Mobile\Employee;

use App\Http\Controllers\Controller;
use App\Services\ServiceImpl\OverTimeServiceImpl;
use Illuminate\Http\Request;
use RamdanRiawan\ResponseJson;

class HistoryOverTimeController extends Controller
{
    //
    public function findAllByCurrentUser(Request $request) {
        $overTime = OverTimeServiceImpl::findAllByUserId($request->user(), 0, 50);

        if(empty($overTime)) {
            return ResponseJson::notFound();
        }

        return ResponseJson::success($overTime);
    }
}
