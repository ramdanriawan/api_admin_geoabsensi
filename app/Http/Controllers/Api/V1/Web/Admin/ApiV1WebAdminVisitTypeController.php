<?php

namespace App\Http\Controllers\Api\V1\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApiV1WebAdminVisitTypeUpdateStatus;
use App\Models\VisitType as VisitType;
use App\Services\ServiceImpl\ShiftServiceImpl;
use App\Services\ServiceImpl\UserServiceImpl;
use App\Services\ServiceImpl\VisitTypeServiceImpl;
use App\Services\ServiceImpl\TitleServiceImpl;
use Illuminate\Http\Request;
use RamdanRiawan\ResponseJson;
use RamdanRiawan\Table;

class ApiV1WebAdminVisitTypeController extends Controller
{
    public function dataTable(Request $request)
    {

        $data = VisitTypeServiceImpl::findAll(
            length: $request->length,
            start: $request->start,
            columnToSearch: Table::getColumn(new VisitType()),
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


            $deleteApiUrl = url(route('api.v1.web.admin.visitType.delete', ['visitType' => $item->id, "redirectBack" => false]));
            $editUrl = url(route('web.admin.visitType.edit', ['visitType' => $item->id]));

            if ($item->isCanDelete) {

                $item->action = "<a href='$deleteApiUrl' class='delete-link btn btn-xs btn-danger' data-delete-api-url='$deleteApiUrl'>Delete</a>&nbsp;";
            }

            $item->action .= "<a href='$editUrl' class='btn btn-xs btn-info'>Edit</a>&nbsp;";
        }

        $visitTypeCount = VisitType::count();
        return response()->json([
            'draw' => $request->draw,
            'recordsTotal' => $visitTypeCount,
            'recordsFiltered' => count($data) ? $visitTypeCount : count($data),
            'data' => $data
        ]);
    }

    public function delete(VisitType $visitType, Request $request)
    {
        VisitTypeServiceImpl::delete($visitType);

        if ($request->redirectBack) {

            return redirect()->back();
        }

        return ResponseJson::success();
    }

}
