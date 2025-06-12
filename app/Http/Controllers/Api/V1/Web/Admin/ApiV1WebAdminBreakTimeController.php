<?php

namespace App\Http\Controllers\Api\V1\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\BreakTime;
use App\Services\ServiceImpl\BreakTimeServiceImpl;
use App\Services\ServiceImpl\BreakTimeTimeServiceImpl;
use Illuminate\Http\Request;
use RamdanRiawan\ResponseJson;

class ApiV1WebAdminBreakTimeController extends Controller
{
    public function dataTable(Request $request)
    {
        $data = BreakTimeServiceImpl::findAll(
            length: $request->length,
            start: $request->start,
            columnToSearch: [
                'id',
                'attendance_id',
                'start_time',
                'end_time',
                'date',
                'duration_in_minutes',
                'break_type',
                'status',
            ],
            columnToSearchRelation: [
                'attendance.user' => 'name'
            ],
            search: $request->search['value'],
            andCondition: [
                'break_type' => $request->get('break_type'),
                'date' => $request->get('date'),
            ],
            columnOrderName: $request->order[0]['column'],
            columnOrderDir: $request->order[0]['dir'],
        );

        foreach ($data as $key => $item) {
            $editUrl = url(route('web.admin.breakTime.edit', ['breakTime' => $item->id]));

            if ($item->isCanEdit) {

                $item->action .= "<a href='$editUrl' class='btn btn-xs btn-info'>Edit</a>&nbsp;";
            }
        }

        $breakTimeCount = BreakTime::count();
        return response()->json([
            'draw' => $request->draw,
            'recordsTotal' => $breakTimeCount,
            'recordsFiltered' => count($data) ? $breakTimeCount : count($data),
            'data' => $data
        ]);
    }
}
