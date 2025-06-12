<?php

namespace App\Http\Controllers\Api\V1\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Admin\WebAdminRecapeUpdateStatus;
use App\Models\Recape;
use App\Models\User;
use App\Services\ServiceImpl\RecapeServiceImpl;
use App\Services\ServiceImpl\RecapeTimeServiceImpl;
use App\Services\ServiceImpl\UserServiceImpl;
use Illuminate\Http\Request;
use RamdanRiawan\ResponseJson;

class ApiV1WebAdminRecapeController extends Controller
{
    public function getByUserFromStartDateToEndDate(Request $request)
    {
        $user = UserServiceImpl::findOne($request->get('user_id'));

        if (!$user) {
            return ResponseJson::notFound();
        }

        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $recape = RecapeServiceImpl::createRecape($user, $startDate, $endDate);

        return ResponseJson::success($recape);
    }

    public function updateStatus(Recape $recape, WebAdminRecapeUpdateStatus $request)
    {
        RecapeServiceImpl::updateStatus($recape, $request->status);

        if ($request->redirectBack) {
            return redirect()->back()->with('success', true);
        }

        return ResponseJson::success(null);
    }


    public function dataTable(Request $request)
    {
        $recape = [];

        $user = UserServiceImpl::findAll(
            length: User::count(),
            start: 0,
            columnToSearch: ['name'],
            columnToSearchRelation: [

            ],
            search: $request->search['value'],
            andCondition: [
                'status' => 'active'
            ],
            hasRelations: [
                'user_shift',
                'employee',
            ],
            columnOrderName: 'id',
            columnOrderDir: 'desc',
        );

//        $user = User::has('employee')->where([
//            'status' => 'active',
//            'level' => 'employee',
//        ])->where('name', 'like', '%' . $request->search['value'] . '%')->get();

        $startDate = $request->get('start_date') ?? now()->addDays(-30)->toDateString();
        $endDate = $request->get('end_date') ?? now()->toDateString();

        foreach ($user as $item) {
            $recapeItem = RecapeServiceImpl::createRecape($item, $startDate, $endDate);

            if ($recapeItem) {

                $recape[] = $recapeItem;
            }
        }

        $recapeCount = $user->count();

        return response()->json([
            'draw' => $request->draw,
            'recordsTotal' => $recapeCount,
            'recordsFiltered' => count($recape) ? $recapeCount : count($recape),
            'data' => $recape
        ]);
    }

}
