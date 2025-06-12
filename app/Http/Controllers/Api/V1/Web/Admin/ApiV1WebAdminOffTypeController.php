<?php

namespace App\Http\Controllers\Api\V1\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApiV1WebAdminOffTypeUpdateStatus;
use App\Models\OffType as OffType;
use App\Services\ServiceImpl\ShiftServiceImpl;
use App\Services\ServiceImpl\UserServiceImpl;
use App\Services\ServiceImpl\OffTypeServiceImpl;
use App\Services\ServiceImpl\TitleServiceImpl;
use Illuminate\Http\Request;
use RamdanRiawan\ResponseJson;
use RamdanRiawan\Table;

class ApiV1WebAdminOffTypeController extends Controller
{
    public function dataTable(Request $request)
    {

        $data = OffTypeServiceImpl::findAll(
            length: $request->length,
            start: $request->start,
            columnToSearch: Table::getColumn(new OffType()),
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


            $deleteApiUrl = url(route('api.v1.web.admin.offType.delete', ['offType' => $item->id, "redirectBack" => false]));
            $editUrl = url(route('web.admin.offType.edit', ['offType' => $item->id]));

            if ($item->isCanDelete) {

                $item->action = "<a href='$deleteApiUrl' class='delete-link btn btn-xs btn-danger' data-delete-api-url='$deleteApiUrl'>Delete</a>&nbsp;";
            }

            $item->action .= "<a href='$editUrl' class='btn btn-xs btn-info'>Edit</a>&nbsp;";
        }

        $offTypeCount = OffType::count();
        return response()->json([
            'draw' => $request->draw,
            'recordsTotal' => $offTypeCount,
            'recordsFiltered' => count($data) ? $offTypeCount : count($data),
            'data' => $data
        ]);
    }

    public function delete(OffType $offType, Request $request)
    {
        OffTypeServiceImpl::delete($offType);

        if ($request->redirectBack) {

            return redirect()->back();
        }

        return ResponseJson::success();
    }

}
