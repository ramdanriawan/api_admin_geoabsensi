<?php

namespace App\Http\Controllers\Api\V1\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Services\ServiceImpl\OrganizationServiceImpl;
use Illuminate\Http\Request;
use RamdanRiawan\ResponseJson;
use RamdanRiawan\Table;

class ApiV1WebAdminOrganizationController extends Controller
{

    public function dataTable(Request $request)
    {
        $data = OrganizationServiceImpl::findAll(
            length: $request->length,
            start: $request->start,
            columnToSearch: Table::getColumn(new Organization()),
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

            $deleteApiUrl = url(route('api.v1.web.admin.organization.delete', ['organization' => $item->id, "redirectBack" => false]));
            $editUrl = url(route('web.admin.organization.edit', ['organization' => $item->id]));

            if ($item->isCanDelete) {

                $item->action = "<a href='$deleteApiUrl' class='delete-link btn btn-xs btn-danger' data-delete-api-url='$deleteApiUrl'>Delete</a>&nbsp;";
            }

            $item->action .= "<a href='$editUrl' class='btn btn-xs btn-info'>Edit</a>&nbsp;";
        }

        $organizationCount = Organization::count();
        return response()->json([
            'draw' => $request->draw,
            'recordsTotal' => $organizationCount,
            'recordsFiltered' => count($data) ? $organizationCount : count($data),
            'data' => $data
        ]);
    }

    public function delete(Organization $organization, Request $request)
    {
        OrganizationServiceImpl::delete($organization);

        if ($request->redirectBack) {

            return redirect()->back();
        }

        return ResponseJson::success();
    }
}
