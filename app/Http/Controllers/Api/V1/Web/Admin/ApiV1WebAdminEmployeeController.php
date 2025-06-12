<?php

namespace App\Http\Controllers\Api\V1\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApiV1WebAdminEmployeeUpdateStatus;
use App\Models\Employee as Employee;
use App\Services\ServiceImpl\EmployeeServiceImpl;
use App\Services\ServiceImpl\TitleServiceImpl;
use Illuminate\Http\Request;
use RamdanRiawan\ResponseJson;
use RamdanRiawan\Table;

class ApiV1WebAdminEmployeeController extends Controller
{

    public function dataTable(Request $request)
    {

        $data = EmployeeServiceImpl::findAll(
            length: $request->length,
            start: $request->start,
            columnToSearch: Table::getColumn(new Employee()),
            columnToSearchRelation: [
                'user' => 'name',
                'title' => 'name',
            ],
            search: $request->search['value'],
            andCondition: [
                'title_id' => optional(TitleServiceImpl::findByName($request->get('title')))->id,
            ],
            columnOrderName: $request->order[0]['column'],
            columnOrderDir: $request->order[0]['dir'],
        );

        foreach ($data as $key => $item) {
            $item->user = json_decode(json_encode($item->user));


            $deleteApiUrl = url(route('api.v1.web.admin.employee.delete', ['employee' => $item->id, "redirectBack" => false]));
            $editUrl = url(route('web.admin.employee.edit', ['employee' => $item->id]));

            if ($item->isCanDelete) {

                $item->action = "<a href='$deleteApiUrl' class='delete-link btn btn-xs btn-danger' data-delete-api-url='$deleteApiUrl'>Delete</a>&nbsp;";
            }

            $item->action .= "<a href='$editUrl' class='btn btn-xs btn-info'>Edit</a>&nbsp;";
        }

        $employeeCount = Employee::count();
        return response()->json([
            'draw' => $request->draw,
            'recordsTotal' => $employeeCount,
            'recordsFiltered' => count($data) ? $employeeCount : count($data),
            'data' => $data
        ]);
    }

    public function delete(Employee $employee, Request $request)
    {
        EmployeeServiceImpl::delete($employee);

        if ($request->redirectBack) {

            return redirect()->back();
        }

        return ResponseJson::success();
    }

}
