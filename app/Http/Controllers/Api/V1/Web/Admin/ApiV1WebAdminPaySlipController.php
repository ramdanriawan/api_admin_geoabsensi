<?php

namespace App\Http\Controllers\Api\V1\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Admin\WebAdminPaySlipUpdateStatus;
use App\Models\PaySlip;
use App\Services\ServiceImpl\PaySlipServiceImpl;
use App\Services\ServiceImpl\UserServiceImpl;
use Illuminate\Http\Request;
use RamdanRiawan\ResponseJson;
use RamdanRiawan\Table;

class ApiV1WebAdminPaySlipController extends Controller
{

    public function getUserSelect2(Request $request)
    {
        $userId = PaySlip::where([
            'date' => date('Y-m-d'),
        ])->pluck('user_id')->toArray();

        $data = UserServiceImpl::findAll(
            length: $request->length,
            start: $request->start,
            columnToSearch: ['name'],
            columnToSearchRelation: [

            ],
            search: $request->get('q'),
            andCondition: [
            ],
            columnOrderName: 'id',
            columnOrderDir: 'desc',
        );

        $data = $data->whereNotIn('id', $userId)->values();

        return [
            'incomplete_results' => true,
            'items' => $data,
            'total_count' => count($data)
        ];
    }

    public function updateStatus(PaySlip $paySlip, WebAdminPaySlipUpdateStatus $request)
    {
        PaySlipServiceImpl::updateStatus($paySlip, $request->status);

        if ($request->redirectBack) {
            return redirect()->back()->with('success', true);
        }

        return ResponseJson::success(null);
    }


    public function dataTable(Request $request)
    {
        $data = PaySlipServiceImpl::findAll(
            length: $request->length,
            start: $request->start,
            columnToSearch: Table::getColumn(new PaySlip()),
            columnToSearchRelation: [
                'user' => 'name',
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
            $deleteApiUrl = url(route('api.v1.web.admin.paySlip.delete', ['paySlip' => $item->id, "redirectBack" => false]));
            $editUrl = url(route('web.admin.paySlip.edit', ['paySlip' => $item->id]));

            $currentStatus = $item->status;
            $updateStatusUrl = route('api.v1.web.admin.paySlip.updateStatus', ['paySlip' => $item->id, "redirectBack" => true]);
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

            if ($item->isCanDelete) {

                $item->action = "<a href='$deleteApiUrl' class='delete-link btn btn-xs btn-danger' data-delete-api-url='$deleteApiUrl'>Delete</a>&nbsp;";
            }

            if ($item->isCanEdit) {

                $item->action .= "<a href='$editUrl' class='btn btn-xs btn-info'>Edit</a>&nbsp;";
            }
        }

        $paySlipCount = PaySlip::count();
        return response()->json([
            'draw' => $request->draw,
            'recordsTotal' => $paySlipCount,
            'recordsFiltered' => count($data) ? $paySlipCount : count($data),
            'data' => $data
        ]);
    }

    public function delete(PaySlip $paySlip, Request $request)
    {
        PaySlipServiceImpl::delete($paySlip);

        if ($request->redirectBack) {

            return redirect()->back();
        }

        return ResponseJson::success();
    }
}
