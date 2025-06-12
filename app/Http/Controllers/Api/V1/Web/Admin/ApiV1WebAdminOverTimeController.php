<?php

namespace App\Http\Controllers\Api\V1\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Admin\WebAdminOverTimeUpdateStatus;
use App\Models\OverTime;
use App\Services\ServiceImpl\OverTimeServiceImpl;
use App\Services\ServiceImpl\OverTimeTimeServiceImpl;
use Illuminate\Http\Request;
use RamdanRiawan\ResponseJson;
use RamdanRiawan\Table;

class ApiV1WebAdminOverTimeController extends Controller
{
    public function updateStatus(OverTime $overTime, WebAdminOverTimeUpdateStatus $request)
    {
        OverTimeServiceImpl::updateStatus($overTime, $request->status);

        if ($request->redirectBack) {
            return redirect()->back()->with('success', true);
        }

        return ResponseJson::success(null);
    }


    public function dataTable(Request $request)
    {
        $data = OverTimeServiceImpl::findAll(
            length: $request->length,
            start: $request->start,
            columnToSearch: Table::getColumn(new OverTime()),
            columnToSearchRelation: [
                'attendance.user' => 'name',
            ],
            search: $request->search['value'],
            andCondition: [
                'date' => request('date'),
                'status' => request('status'),
            ],
            columnOrderName: $request->order[0]['column'],
            columnOrderDir: $request->order[0]['dir'],
        );

        foreach ($data as $key => $item) {
            $editUrl = url(route('web.admin.overTime.edit', ['overTime' => $item->id]));


            $currentStatus = $item->status;
            $updateStatusUrl = route('api.v1.web.admin.overTime.updateStatus', ['overTime' => $item->id, "redirectBack" => true]);
            $csrf = csrf_field();

            $selectedAgreed = $currentStatus === 'agreed' ? 'selected' : '';
            $selectedWaiting = $currentStatus === 'waiting' ? 'selected' : '';
            $selectedDisagreed = $currentStatus === 'disagreed' ? 'selected' : '';


                $item->statusHtml = <<<EOD
<form method="POST" action="{$updateStatusUrl}" style="display:inline-block;" onchange="this.submit();">
$csrf

    <select name="status">
        <option value="agreed"   $selectedAgreed>🟢 Agreed</option>
        <option value="waiting" $selectedWaiting>🟡 Waiting</option>
        <option value="disagreed"  $selectedDisagreed>🔴 Disagreed</option>
    </select>
</form>
EOD;
            if ($item->isCanEdit) {

                $item->action .= "<a href='$editUrl' class='btn btn-xs btn-info'>Edit</a>&nbsp;";
            }
        }

        $overTimeCount = OverTime::count();
        return response()->json([
            'draw' => $request->draw,
            'recordsTotal' => $overTimeCount,
            'recordsFiltered' => count($data) ? $overTimeCount : count($data),
            'data' => $data
        ]);
    }
}
