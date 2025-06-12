<?php

namespace App\Http\Controllers\Api\V1\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Services\ServiceImpl\ApplicationServiceImpl;
use Illuminate\Http\Request;
use RamdanRiawan\ResponseJson;
use RamdanRiawan\Table;

class ApiV1WebAdminApplicationController extends Controller
{
    public function dataTable(Request $request)
    {
        $data = ApplicationServiceImpl::findAll(
            length: 5,
            start: 0,
            columnToSearch: Table::getColumn(new Application()),
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

            $deleteApiUrl = url(route('api.v1.web.admin.application.delete', ['application' => $item->id, "redirectBack" => false]));
            $editUrl = url(route('web.admin.application.edit', ['application' => $item->id]));

            if ($item->isCanDelete) {

                $item->action = "<a href='$deleteApiUrl' class='delete-link btn btn-xs btn-danger' data-delete-api-url='$deleteApiUrl'>Delete</a>&nbsp;";
            }

            $item->action .= "<a href='$editUrl' class='btn btn-xs btn-info'>Edit</a>&nbsp;";
        }

        $applicationCount = Application::count();
        return response()->json([
            'draw' => $request->draw,
            'recordsTotal' => $applicationCount,
            'recordsFiltered' => count($data) ? $applicationCount : count($data),
            'data' => $data
        ]);
    }

    public function delete(Application $application, Request $request)
    {
        ApplicationServiceImpl::delete($application);

        if ($request->redirectBack) {

            return redirect()->back();
        }

        return ResponseJson::success();
    }
}
