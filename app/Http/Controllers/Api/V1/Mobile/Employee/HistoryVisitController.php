<?php

namespace App\Http\Controllers\Api\V1\Mobile\Employee;

use App\Http\Controllers\Controller;
use App\Services\ServiceImpl\VisitServiceImpl;
use Illuminate\Http\Request;
use RamdanRiawan\ResponseJson;

class HistoryVisitController extends Controller
{
    //
    public function findAllByCurrentUser(Request $request) {
        $overTime = VisitServiceImpl::findAllByUserId($request->user(), 0, 50);

        if(empty($overTime)) {
            return ResponseJson::notFound();
        }

        return ResponseJson::success($overTime);
    }
}
