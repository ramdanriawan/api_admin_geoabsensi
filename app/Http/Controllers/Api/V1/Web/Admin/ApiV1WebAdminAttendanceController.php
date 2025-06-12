<?php

namespace App\Http\Controllers\Api\V1\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Services\ServiceImpl\AttendanceServiceImpl;
use Illuminate\Http\Request;
use RamdanRiawan\ResponseJson;
use RamdanRiawan\Table;
class ApiV1WebAdminAttendanceController extends Controller
{

    public function dataTable(Request $request)
    {
        $data = AttendanceServiceImpl::findAll(
            length: $request->length,
            start: $request->start,
            columnToSearch: Table::getColumn(new Attendance()),
            columnToSearchRelation: [
                'user' => 'name',
            ],
            search: $request->search['value'],
            andCondition: [
                'status' => request('status'),
                'date' => request('date'),
            ],
            columnOrderName: $request->order[0]['column'],
            columnOrderDir: $request->order[0]['dir'],
        );

        foreach ($data as $key => $item) {
            $item->user = json_decode(json_encode($item->user));

            $editUrl = url(route('web.admin.attendance.edit', ['attendance' => $item->id]));
            $showUrl = url(route('web.admin.attendance.show', ['attendance' => $item->id]));

            if ($item->isCanDelete) {

                $item->action = "<a href='$deleteApiUrl' class='delete-link btn btn-xs btn-danger' data-delete-api-url='$deleteApiUrl'>Delete</a>&nbsp;";
            }

            if ($item->isCanEdit) {

                $item->action .= "<a href='$editUrl' class='btn btn-xs btn-info'>Edit</a>&nbsp;";
            }

            if($item->isCanShow) {
                $item->action .= "<a href='$showUrl' class='btn btn-xs btn-default'>Show</a>&nbsp;";
            }
        }

        $attendanceCount = Attendance::count();
        return response()->json([
            'draw' => $request->draw,
            'recordsTotal' => $attendanceCount,
            'recordsFiltered' => count($data) ? $attendanceCount : count($data),
            'data' => $data
        ]);
    }
}
