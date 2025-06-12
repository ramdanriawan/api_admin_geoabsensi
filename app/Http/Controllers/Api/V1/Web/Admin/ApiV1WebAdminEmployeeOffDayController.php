<?php

namespace App\Http\Controllers\Api\V1\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApiV1WebAdminEmployeeUpdateStatus;
use App\Models\Employee as Employee;
use App\Models\EmployeeOffDay;
use App\Models\OffType;
use App\Services\ServiceImpl\EmployeeOffDayServiceImpl;
use App\Services\ServiceImpl\EmployeeServiceImpl;
use App\Services\ServiceImpl\OffTypeServiceImpl;
use App\Services\ServiceImpl\TitleServiceImpl;
use App\Services\ServiceImpl\UserServiceImpl;
use Illuminate\Http\Request;
use RamdanRiawan\ResponseJson;
use RamdanRiawan\Table;

class ApiV1WebAdminEmployeeOffDayController extends Controller
{

    public function getEmployeeSelect2(Request $request)
    {
        $data = EmployeeServiceImpl::findAll(
            length: 5,
            start: 0,
            columnToSearch: Table::getColumn(new Employee()),
            columnToSearchRelation: [
                'user' => 'name'
            ],
            search: $request->get('q'),
            andCondition: [

            ],
            notInCondition: [

            ],
            notInConditionRelation: [
            ],
            columnOrderName: 'id',
            columnOrderDir: 'desc',
        );

        return [
            'incomplete_results' => true,
            'items' => $data,
            'total_count' => count($data)
        ];
    }

    public function getOffTypeSelect2(Request $request)
    {
        $data = OffTypeServiceImpl::findAll(
            length: 5,
            start: 0,
            columnToSearch: Table::getColumn(new OffType()),
            columnToSearchRelation: [
                'user' => 'name'
            ],
            search: $request->get('q'),
            andCondition: [

            ],
            notInCondition: [

            ],
            notInConditionRelation: [
            ],
            columnOrderName: 'id',
            columnOrderDir: 'desc',
        );

        return [
            'incomplete_results' => true,
            'items' => $data,
            'total_count' => count($data)
        ];
    }

    public function dataTable(Request $request)
    {

        $data = EmployeeOffDayServiceImpl::findAll(
            length: $request->length,
            start: $request->start,
            columnToSearch: Table::getColumn(new EmployeeOffDay()),
            columnToSearchRelation: [
                'employee.user' => 'name',
                'off_type' => 'name',
            ],
            search: $request->search['value'],
            andCondition: [
                'off_type_id' => request('off_type_id'),
            ],
            columnOrderName: $request->order[0]['column'],
            columnOrderDir: $request->order[0]['dir'],
        );

        foreach ($data as $key => $item) {
            $item->user = json_decode(json_encode($item->user));


            $deleteApiUrl = url(route('api.v1.web.admin.employeeOffDay.delete', ['employeeOffDay' => $item->id, "redirectBack" => false]));
            $editUrl = url(route('web.admin.employeeOffDay.edit', ['employeeOffDay' => $item->id]));

            if ($item->isCanDelete) {

                $item->action = "<a href='$deleteApiUrl' class='delete-link btn btn-xs btn-danger' data-delete-api-url='$deleteApiUrl'>Delete</a>&nbsp;";
            }

            $item->action .= "<a href='$editUrl' class='btn btn-xs btn-info'>Edit</a>&nbsp;";
        }

        $employeeOffDayCount = Employee::count();
        return response()->json([
            'draw' => $request->draw,
            'recordsTotal' => $employeeOffDayCount,
            'recordsFiltered' => count($data) ? $employeeOffDayCount : count($data),
            'data' => $data
        ]);
    }

    public function delete(EmployeeOffDay $employeeOffDay, Request $request)
    {
        EmployeeOffDayServiceImpl::delete($employeeOffDay);

        if ($request->redirectBack) {

            return redirect()->back();
        }

        return ResponseJson::success();
    }

}
