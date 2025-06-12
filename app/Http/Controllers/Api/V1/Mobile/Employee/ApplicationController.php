<?php
namespace App\Http\Controllers\Api\V1\Mobile\Employee;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Organization;
use RamdanRiawan\DateTime;
use RamdanRiawan\ResponseJson;

class ApplicationController extends Controller
{
    public function info()
    {
        $data = [];

        $data['organization'] = Organization::orderByDesc('updated_at')->where(['is_active' => true])->first();

        $data['datetime'] = DateTime::getDetail();

        $data['application'] = Application::with(['platforms', 'locales'])->where(['is_active' => true])->first();

        return ResponseJson::success($data);
    }
}
