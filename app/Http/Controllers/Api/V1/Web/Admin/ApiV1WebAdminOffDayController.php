<?php

namespace App\Http\Controllers\Api\V1\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Admin\WebAdminOffDayUpdateStatus;
use App\Models\OffDay;
use App\Services\ServiceImpl\OffDayServiceImpl;
use App\Services\ServiceImpl\OffDayTimeServiceImpl;
use Illuminate\Http\Request;
use RamdanRiawan\ResponseJson;
use RamdanRiawan\Table;

class ApiV1WebAdminOffDayController extends Controller
{
    public function updateStatus(OffDay $offDay, WebAdminOffDayUpdateStatus $request)
    {
        OffDayServiceImpl::updateStatus($offDay, $request->status);

        if ($request->redirectBack) {
            return redirect()->back()->with('success', true);
        }

        return ResponseJson::success(null);
    }


    public function dataTable(Request $request)
    {
         $data = OffDayServiceImpl::findAll(
            length: $request->length,
            start: $request->start,
            columnToSearch: Table::getColumn(new OffDay()),
            columnToSearchRelation: [
                'employee.user' => 'name',
                'off_type' => 'name'
            ],
            search: $request->search['value'],
            andCondition: [
                'date' => request('date'),
                'off_type_id' => request('off_type_id'),
                'status' => request('status'),
            ],
            columnOrderName: $request->order[0]['column'],
            columnOrderDir: $request->order[0]['dir'],
        );

        foreach ($data as $key => $item) {
            $editUrl = url(route('web.admin.offDay.edit', ['offDay' => $item->id]));

            $currentStatus = $item->status;
            $updateStatusUrl = route('api.v1.web.admin.offDay.updateStatus', ['offDay' => $item->id, "redirectBack" => true]);
            $csrf = csrf_field();

            $selectedAgreed = $currentStatus === 'agreed' ? 'selected' : '';
            $selectedWaiting = $currentStatus === 'waiting' ? 'selected' : '';
            $selectedDisagreed = $currentStatus === 'disagreed' ? 'selected' : '';

            $item->statusHtml = <<<EOD
<form method="POST" action="{$updateStatusUrl}" style="display:inline-block;" onchange="this.submit();">
$csrf

    <select name="status">
        <option value="agreed"   $selectedAgreed>🟢Agreed</option>
        <option value="waiting" $selectedWaiting>🟡Waiting</option>
        <option value="disagreed"  $selectedDisagreed>🔴Disagreed</option>
    </select>
</form>
EOD;

            if ($item->isCanEdit) {

                $item->action .= "<a href='$editUrl' class='btn btn-xs btn-info'>Edit</a>&nbsp;";
            }
        }

        $offDayCount = OffDay::count();
        return response()->json([
            'draw' => $request->draw,
            'recordsTotal' => $offDayCount,
            'recordsFiltered' => count($data) ? $offDayCount : count($data),
            'data' => $data
        ]);
    }
}
