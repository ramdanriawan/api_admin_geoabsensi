<?php

namespace App\Http\Controllers\Api\V1\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Admin\WebAdminUserUpdateStatus;
use App\Models\Employee;
use App\Models\User as User;
use App\Services\ServiceImpl\UserServiceImpl;
use Illuminate\Http\Request;
use RamdanRiawan\ResponseJson;
use RamdanRiawan\Table;

class ApiV1WebAdminUserController extends Controller
{
    public function select2(Request $request)
    {
        $data = UserServiceImpl::findAll(
            length: 5,
            start: 0,
            columnToSearch: ['name'],
            columnToSearchRelation: [

            ],
            search: $request->get('q'),
            andCondition: [
            ],
            columnOrderName: 'id',
            columnOrderDir: 'desc',
        );

        $employeeUserId = Employee::pluck('user_id')->toArray();

        $data = $data->whereNotIn('id', $employeeUserId)->values();

        return [
            'incomplete_results' => true,
            'items' => $data,
            'total_count' => count($data)
        ];
    }

    public function updateStatus(User $user, WebAdminUserUpdateStatus $request)
    {
        UserServiceImpl::updateStatus($user, $request->status);

        if ($request->redirectBack) {
            return redirect()->back()->with('success', true);
        }

        return ResponseJson::success(null);
    }

    public function dataTable(Request $request)
    {
        $data = UserServiceImpl::findAll(
            length: $request->length,
            start: $request->start,
            columnToSearch: Table::getColumn(new User()),
            columnToSearchRelation: [

            ],
            search: $request->search['value'],
            andCondition: [
                'status' => request('status'),
                'level' => request('level'),
            ],
            columnOrderName: $request->order[0]['column'],
            columnOrderDir: $request->order[0]['dir'],
        );

        foreach ($data as $item) {
            $item = UserServiceImpl::addAllAttributes($item);

            $deleteApiUrl = url(route('api.v1.web.admin.user.delete', ['user' => $item->id, "redirectBack" => false]));
            $editUrl = url(route('web.admin.user.edit', ['user' => $item->id]));

            $currentStatus = $item->status;
            $updateStatusUrl = route('api.v1.web.admin.user.updateStatus', ['user' => $item->id, "redirectBack" => true]);
            $csrf = csrf_field();

            $selectedActive = $currentStatus === 'active' ? 'selected' : '';
            $selectedInactive = $currentStatus === 'inactive' ? 'selected' : '';
            $selectedBlocked = $currentStatus === 'blocked' ? 'selected' : '';

            if ($item->level != 'admin') {

                $item->status = <<<EOD
<form method="POST" action="{$updateStatusUrl}" style="display:inline-block;" onchange="this.submit();">
$csrf

    <select name="status">
        <option value="active"   $selectedActive>🟢 Active</option>
        <option value="inactive" $selectedInactive>🟡 Inactive</option>
        <option value="blocked"  $selectedBlocked>🔴 Blocked</option>
    </select>
</form>
EOD;
            }

            if ($item->isCanDelete) {

                $item->action = "<a href='$deleteApiUrl' class='delete-link btn btn-xs btn-danger' data-delete-api-url='$deleteApiUrl'>Delete</a>&nbsp;";
            }

            $item->action .= "<a href='$editUrl' class='btn btn-xs btn-info'>Edit</a>&nbsp;";
        }


        $userCount = User::count();
        return response()->json([
            'draw' => $request->draw,
            'recordsTotal' => $userCount,
            'recordsFiltered' => count($data) ? $userCount : count($data),
            'data' => $data
        ]);
    }

    public function delete(User $user, Request $request)
    {
        $result = UserServiceImpl::delete($user);

        if(!$result){
            return ResponseJson::badRequest();
        }

        if ($request->redirectBack) {

            return redirect()->back();
        }

        return ResponseJson::success();
    }

}
