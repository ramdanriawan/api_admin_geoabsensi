<?php

namespace App\Http\Controllers\Api\V1\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Admin\WebAdminVisitUpdateStatus;
use App\Models\Visit;
use App\Services\ServiceImpl\VisitServiceImpl;
use App\Services\ServiceImpl\VisitTimeServiceImpl;
use Illuminate\Http\Request;
use RamdanRiawan\ResponseJson;
use RamdanRiawan\Table;

class ApiV1WebAdminVisitController extends Controller
{
    public function updateStatus(Visit $visit, WebAdminVisitUpdateStatus $request)
    {
        VisitServiceImpl::updateStatus($visit, $request->status);

        if ($request->redirectBack) {
            return redirect()->back()->with('success', true);
        }

        return ResponseJson::success(null);
    }


    public function dataTable(Request $request)
    {
        $data = VisitServiceImpl::findAll(
            length: 5,
            start: 0,
            columnToSearch: Table::getColumn(new Visit()),
            columnToSearchRelation: [
                'user' => 'name',
                'visit_type' => 'name'
            ],
            search: $request->search['value'],
            andCondition: [
                'visit_type_id' => request('visit_type_id'),
                'date' => request('date'),
            ],
            columnOrderName: $request->order[0]['column'],
            columnOrderDir: $request->order[0]['dir'],
        );

        foreach ($data as $key => $item) {
            $editUrl = url(route('web.admin.visit.edit', ['visit' => $item->id]));
            $showUrl = url(route('web.admin.visit.show', ['visit' => $item->id]));

            if ($item->isCanEdit) {

                $item->action .= "<a href='$editUrl' class='btn btn-xs btn-info'>Edit</a>&nbsp;";
            }

            if ($item->isCanShow) {
                $item->action .= "<a href='$showUrl' class='btn btn-xs btn-default'>Show</a>&nbsp;";
            }
        }

        $visitCount = Visit::count();
        return response()->json([
            'draw' => $request->draw,
            'recordsTotal' => $visitCount,
            'recordsFiltered' => count($data) ? $visitCount : count($data),
            'data' => $data
        ]);
    }
}
