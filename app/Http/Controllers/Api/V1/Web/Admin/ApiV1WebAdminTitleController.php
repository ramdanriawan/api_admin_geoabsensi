<?php

namespace App\Http\Controllers\Api\V1\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Title;
use App\Services\ServiceImpl\TitleServiceImpl;
use Illuminate\Http\Request;
use RamdanRiawan\ResponseJson;
use RamdanRiawan\Table;

class ApiV1WebAdminTitleController extends Controller
{
    public function select2(Request $request)
    {
        $data = TitleServiceImpl::findAll(
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


        return [
            'incomplete_results' => true,
            'items' => $data,
            'total_count' => count($data)
        ];
    }

    public function dataTable(Request $request)
    {
        $data = TitleServiceImpl::findAll(
            length: $request->length,
            start: $request->start,
            columnToSearch: Table::getColumn(new Title()),
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

            $deleteApiUrl = url(route('api.v1.web.admin.title.delete', ['title' => $item->id, "redirectBack" => false]));
            $editUrl = url(route('web.admin.title.edit', ['title' => $item->id]));

            if ($item->isCanDelete) {

                $item->action = "<a href='$deleteApiUrl' class='delete-link btn btn-xs btn-danger' data-delete-api-url='$deleteApiUrl'>Delete</a>&nbsp;";
            }

            $item->action .= "<a href='$editUrl' class='btn btn-xs btn-info'>Edit</a>&nbsp;";
        }

        $titleCount = Title::count();
        return response()->json([
            'draw' => $request->draw,
            'recordsTotal' => $titleCount,
            'recordsFiltered' => count($data) ? $titleCount : count($data),
            'data' => $data
        ]);
    }

    public function delete(Title $title, Request $request)
    {
        TitleServiceImpl::delete($title);

        if ($request->redirectBack) {

            return redirect()->back();
        }

        return ResponseJson::success();
    }
}
