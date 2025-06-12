<?php

namespace App\Http\Controllers\Api\V1\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Admin\WebAdminTripUpdateStatus;
use App\Models\Trip;
use App\Services\ServiceImpl\TripServiceImpl;
use App\Services\ServiceImpl\TripTimeServiceImpl;
use Illuminate\Http\Request;
use RamdanRiawan\ResponseJson;
use RamdanRiawan\Table;

class ApiV1WebAdminTripController extends Controller
{
    public function updateStatus(Trip $trip, WebAdminTripUpdateStatus $request)
    {
        TripServiceImpl::updateStatus($trip, $request->status);

        if ($request->redirectBack) {
            return redirect()->back()->with('success', true);
        }

        return ResponseJson::success(null);
    }


    public function dataTable(Request $request)
    {
        $data = TripServiceImpl::findAll(
            length: 5,
            start: 0,
            columnToSearch: Table::getColumn(new Trip()),
            columnToSearchRelation: [
                'employee.user' => 'name',
                'trip_type' => 'name',
            ],
            search: $request->search['value'],
            andCondition: [
                'date' => request('date'),
                'status' => request('status'),
                'trip_type_id' => request('trip_type_id'),
            ],
            columnOrderName: $request->order[0]['column'],
            columnOrderDir: $request->order[0]['dir'],
        );

        foreach ($data as $key => $item) {
            $editUrl = url(route('web.admin.trip.edit', ['trip' => $item->id]));
            $showUrl = url(route('web.admin.trip.show', ['trip' => $item->id]));

            $currentStatus = $item->status;
            $updateStatusUrl = route('api.v1.web.admin.trip.updateStatus', ['trip' => $item->id, "redirectBack" => true]);
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


            if($item->isCanShow) {
                $item->action .= "<a href='$showUrl' class='btn btn-xs btn-default'>Show</a>&nbsp;";
            }
        }

        $tripCount = Trip::count();
        return response()->json([
            'draw' => $request->draw,
            'recordsTotal' => $tripCount,
            'recordsFiltered' => count($data) ? $tripCount : count($data),
            'data' => $data
        ]);
    }
}
