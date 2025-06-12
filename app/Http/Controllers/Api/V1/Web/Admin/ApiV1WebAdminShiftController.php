<?php

namespace App\Http\Controllers\Api\V1\Web\Admin;

use App\Http\Controllers\Api\V1\Mobile\Employee\UserShiftController;
use App\Http\Controllers\Controller;
use App\Models\Shift;
use App\Services\ServiceImpl\ShiftServiceImpl;
use Illuminate\Http\Request;
use RamdanRiawan\ResponseJson;
use RamdanRiawan\Table;

class ApiV1WebAdminShiftController extends Controller
{
    public function select2(Request $request)
    {
        $data = ShiftServiceImpl::findAll(
            length: 5,
            start: 0,
            columnToSearch: ['name'],
            columnToSearchRelation: [

            ],
            search: $request->get('q'),
            andCondition: [
            ],
            columnOrderName: 'id',
            columnOrderDir: 'desc',
        );

        return [
            'incomplete_results' => true,
            'items' => $data,
            'total_count' => count($data)
        ];
    }

    public function dataTable(Request $request)
    {
        $data = ShiftServiceImpl::findAll(
            length: $request->length,
            start: $request->start,
            columnToSearch: Table::getColumn(new Shift()),
            columnToSearchRelation: [

            ],
            search: $request->search['value'],
            andCondition: [
            ],
            columnOrderName: $request->order[0]['column'],
            columnOrderDir: $request->order[0]['dir'],
        );

        foreach ($data as $key => $item) {
            $item->user = json_decode(json_encode($item->user));

            $deleteApiUrl = url(route('api.v1.web.admin.shift.delete', ['shift' => $item->id, "redirectBack" => false]));
            $editUrl = url(route('web.admin.shift.edit', ['shift' => $item->id]));

            if ($item->isCanDelete) {

                $item->action = "<a href='$deleteApiUrl' class='delete-link btn btn-xs btn-danger' data-delete-api-url='$deleteApiUrl'>Delete</a>&nbsp;";
            }

            $item->action .= "<a href='$editUrl' class='btn btn-xs btn-info'>Edit</a>&nbsp;";
        }

        $shiftCount = Shift::count();
        return response()->json([
            'draw' => $request->draw,
            'recordsTotal' => $shiftCount,
            'recordsFiltered' => count($data) ? $shiftCount : count($data),
            'data' => $data
        ]);
    }

    public function delete(Shift $shift, Request $request)
    {
        ShiftServiceImpl::delete($shift);

        if ($request->redirectBack) {

            return redirect()->back();
        }

        return ResponseJson::success();
    }
}
