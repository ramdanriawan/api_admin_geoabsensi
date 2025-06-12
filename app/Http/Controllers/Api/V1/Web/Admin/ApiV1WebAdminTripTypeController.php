<?php

namespace App\Http\Controllers\Api\V1\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApiV1WebAdminTripTypeUpdateStatus;
use App\Models\TripType as TripType;
use App\Services\ServiceImpl\ShiftServiceImpl;
use App\Services\ServiceImpl\UserServiceImpl;
use App\Services\ServiceImpl\TripTypeServiceImpl;
use App\Services\ServiceImpl\TitleServiceImpl;
use Illuminate\Http\Request;
use RamdanRiawan\ResponseJson;
use RamdanRiawan\Table;

class ApiV1WebAdminTripTypeController extends Controller
{
    public function dataTable(Request $request)
    {

        $data = TripTypeServiceImpl::findAll(
            length: $request->length,
            start: $request->start,
            columnToSearch: Table::getColumn(new TripType()),
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


            $deleteApiUrl = url(route('api.v1.web.admin.tripType.delete', ['tripType' => $item->id, "redirectBack" => false]));
            $editUrl = url(route('web.admin.tripType.edit', ['tripType' => $item->id]));

            if ($item->isCanDelete) {

                $item->action = "<a href='$deleteApiUrl' class='delete-link btn btn-xs btn-danger' data-delete-api-url='$deleteApiUrl'>Delete</a>&nbsp;";
            }

            $item->action .= "<a href='$editUrl' class='btn btn-xs btn-info'>Edit</a>&nbsp;";
        }

        $tripTypeCount = TripType::count();
        return response()->json([
            'draw' => $request->draw,
            'recordsTotal' => $tripTypeCount,
            'recordsFiltered' => count($data) ? $tripTypeCount : count($data),
            'data' => $data
        ]);
    }

    public function delete(TripType $tripType, Request $request)
    {
        TripTypeServiceImpl::delete($tripType);

        if ($request->redirectBack) {

            return redirect()->back();
        }

        return ResponseJson::success();
    }

}
