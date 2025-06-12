<?php

namespace App\Http\Controllers\Api\V1\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApiV1WebAdminUserShiftUpdateStatus;
use App\Models\UserShift as UserShift;
use App\Services\ServiceImpl\ShiftServiceImpl;
use App\Services\ServiceImpl\UserServiceImpl;
use App\Services\ServiceImpl\UserShiftServiceImpl;
use App\Services\ServiceImpl\TitleServiceImpl;
use Illuminate\Http\Request;
use RamdanRiawan\ResponseJson;
use RamdanRiawan\Table;

class ApiV1WebAdminUserShiftController extends Controller
{
    public function getUserSelect2(Request $request)
    {
        $data = UserServiceImpl::findAll(
            length: 5,
            start: 0,
            columnToSearch: ['name'],
            columnToSearchRelation: [

            ],
            search: $request->get('q'),
            andCondition: [
            ],
            notInCondition: [

            ],
            notInConditionRelation: [

            ],
            columnOrderName: 'id',
            columnOrderDir: 'desc',
        );

        $userId = UserShift::pluck('user_id')->toArray();

        $data = $data->whereNotIn('id', $userId)->values();

        return [
            'incomplete_results' => true,
            'items' => $data,
            'total_count' => count($data)
        ];
    }

    public function getShiftSelect2(Request $request)
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
            notInCondition: [

            ],
            notInConditionRelation: [

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

        $data = UserShiftServiceImpl::findAll(
            length: $request->length,
            start: $request->start,
            columnToSearch: Table::getColumn(new UserShift()),
            columnToSearchRelation: [
                'user' => 'name',
                'shift' => 'name',
            ],
            search: $request->search['value'],
            andCondition: [
                'shift_id' => request('shift_id'),
            ],
            columnOrderName: $request->order[0]['column'],
            columnOrderDir: $request->order[0]['dir'],
        );

        foreach ($data as $key => $item) {
            $item->user = json_decode(json_encode($item->user));


            $deleteApiUrl = url(route('api.v1.web.admin.userShift.delete', ['userShift' => $item->id, "redirectBack" => false]));
            $editUrl = url(route('web.admin.userShift.edit', ['userShift' => $item->id]));

            if ($item->isCanDelete) {

                $item->action = "<a href='$deleteApiUrl' class='delete-link btn btn-xs btn-danger' data-delete-api-url='$deleteApiUrl'>Delete</a>&nbsp;";
            }

            $item->action .= "<a href='$editUrl' class='btn btn-xs btn-info'>Edit</a>&nbsp;";
        }

        $userShiftCount = UserShift::count();
        return response()->json([
            'draw' => $request->draw,
            'recordsTotal' => $userShiftCount,
            'recordsFiltered' => count($data) ? $userShiftCount : count($data),
            'data' => $data
        ]);
    }

    public function delete(UserShift $userShift, Request $request)
    {
        UserShiftServiceImpl::delete($userShift);

        if ($request->redirectBack) {

            return redirect()->back();
        }

        return ResponseJson::success();
    }

}
