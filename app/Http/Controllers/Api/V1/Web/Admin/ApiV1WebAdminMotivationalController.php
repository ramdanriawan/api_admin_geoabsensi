<?php

namespace App\Http\Controllers\Api\V1\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Motivational;
use App\Services\ServiceImpl\MotivationalServiceImpl;
use Illuminate\Http\Request;
use RamdanRiawan\ResponseJson;
use RamdanRiawan\Table;

class ApiV1WebAdminMotivationalController extends Controller
{
    public function dataTable(Request $request)
    {
        $data = MotivationalServiceImpl::findAll(
            length: $request->length,
            start: $request->start,
            columnToSearch: Table::getColumn(new Motivational()),
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

            $deleteApiUrl = url(route('api.v1.web.admin.motivational.delete', ['motivational' => $item->id, "redirectBack" => false]));
            $editUrl = url(route('web.admin.motivational.edit', ['motivational' => $item->id]));

            if ($item->isCanDelete) {

                $item->action = "<a href='$deleteApiUrl' class='delete-link btn btn-xs btn-danger' data-delete-api-url='$deleteApiUrl'>Delete</a>&nbsp;";
            }

            $item->action .= "<a href='$editUrl' class='btn btn-xs btn-info'>Edit</a>&nbsp;";
        }

        $motivationalCount = Motivational::count();
        return response()->json([
            'draw' => $request->draw,
            'recordsTotal' => $motivationalCount,
            'recordsFiltered' => count($data) ? $motivationalCount : count($data),
            'data' => $data
        ]);
    }

    public function delete(Motivational $motivational, Request $request)
    {
        MotivationalServiceImpl::delete($motivational);

        if ($request->redirectBack) {

            return redirect()->back();
        }

        return ResponseJson::success();
    }
}
