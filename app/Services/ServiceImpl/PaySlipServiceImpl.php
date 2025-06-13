<?php

namespace App\Services\ServiceImpl;

use App\Models\Dtos\PaySlipStoreDto;
use App\Models\Dtos\PaySlipUpdateDto;
use App\Models\PaySlip;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use RamdanRiawan\Accounting;
use RamdanRiawan\DateTime;

class PaySlipServiceImpl
{
    private static $withRelations = ['user'];
    private static $withCount = [];
    public static $columnOrder = [
        'id',
        'user_id',
        'date',
        'period_start',
        'period_end',
        'basic_salary',
        'meal_allowance',
        'transport_allowance',
        'overtime_pay',
        'bonus',
        'total_earnings',
        'deduction_bpjs_kesehatan',
        'deduction_bpjs_ketenagakerjaan',
        'deduction_pph21',
        'deduction_late_or_leave',
        'total_deductions',
        'net_salary',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    private static function addAllAttributes(PaySlip|Model $item)
    {

        $item->periodStartHuman = DateTime::getDetail("Y-m-d", $item->period_start)['month_year_human'];
        $item->periodEndHuman = DateTime::getDetail("Y-m-d", $item->period_end)['month_year_human'];
        $item->basicSalaryString = Accounting::formatRupiah($item->basic_salary);
        $item->mealAllowanceString = Accounting::formatRupiah($item->meal_allowance);
        $item->transportallowanceString = Accounting::formatRupiah($item->transport_allowance);
        $item->overTimePayString = Accounting::formatRupiah($item->overTime_pay);
        $item->bonusString = Accounting::formatRupiah($item->bonus);
        $item->totalEarningsString = Accounting::formatRupiah($item->total_earnings);
        $item->deductionBpjsKesehatanString = Accounting::formatRupiah($item->deduction_bpjs_kesehatan);
        $item->deductionBpjsKetenagaKerjaanString = Accounting::formatRupiah($item->deduction_bpjs_ketenagakerjaan);
        $item->deductionPph21String = Accounting::formatRupiah($item->deduction_pph21);
        $item->deductionLateOrLeaveString = Accounting::formatRupiah($item->deduction_late_or_leave);
        $item->totalDeductionString = Accounting::formatRupiah($item->total_deductions);
        $item->netSalaryString = Accounting::formatRupiah($item->net_salary);

        $item->attendanceSummary = [
            "present_days" => 20,
            "not_present_days" => 1,
            "off_days" => 2,
            "sick_days" => 1,
            "late_count" => 3,
            "overTime_hours" => 3,
            "visit_counts" => 3,
            "trip_counts" => 2,
        ];

        $item->approvedBy = "HR. Yanti";
        $item->approvedAt = DateTime::getDetail("Y-m-d", date("Y-m-d"));

        $item->note = $item->note ?: "";


        $item->created_at_human = Carbon::parse($item->created_at)->diffForHumans();
        $item->updated_at_human = Carbon::parse($item->updated_at)->diffForHumans();
        $item->deleted_at_human = Carbon::parse($item->deleted_at)->diffForHumans();

        $item->dateDateTime = DateTime::getDetail("Y-m-d", $item->date);

        $item->createdAtDateTime = DateTime::getDetail('Y-m-d H:i:s', $item->created_at);
        $item->updatedAtDateTime = DateTime::getDetail('Y-m-d H:i:s', $item->updated_at);
        $item->deletedAtDateTime = DateTime::getDetail('Y-m-d H:i:s', $item->deleted_at);

        $item->periodStartDateTime = DateTime::getDetail('Y-m-d', $item->period_start);
        $item->periodEndDateTime = DateTime::getDetail('Y-m-d', $item->period_end);


        $item->isCanDelete = false;
        $item->isCanEdit = true;

        return $item;
    }

    public static function findAll(
        $length = 10,
        $start = 0,
        $columnToSearch = [

        ],
        $columnToSearchRelation = [

        ],
        $search = '',
        $andCondition = [],
        $columnOrderName = 'id',
        $columnOrderDir = 'desc',
        $notInCondition = [

        ],
        $notInConditionRelation = [

        ],
        $hasRelations = [
        ]
    )
    {
        if (empty($search) && !$start) {

            $data = PaySlip::limit($length);
        } else {

            $data = PaySlip::limit($length)->offset($start);
        }

        $data->with(self::$withRelations);
        $data->withCount(self::$withCount);
        $data->when($search, function ($query) use ($columnToSearch, $columnToSearchRelation, $search) {
            $query->where(function ($query) use ($columnToSearch, $columnToSearchRelation, $search) {
                foreach ($columnToSearch as $key => $value) {
                    $query->orWhere($value, 'like', '%' . $search . '%');
                }

                foreach ($columnToSearchRelation as $key => $value) {
                    $query->orWhereHas($key, function ($query) use ($value, $search) {
                        $query->where($value, 'like', '%' . $search . '%');
                    });
                }
            });
        });

        foreach ($andCondition as $key => $item) {
            $data->when($item, function ($query) use ($key, $item) {
                $query->where($key, $item);
            });
        }

        foreach ($notInCondition as $key => $item) {
            $data->whereNotIn($key, $item);
        }

        foreach ($notInConditionRelation as $key => $item) {
            $data->whereHas($key, function ($query) use ($key, $item) {
                foreach ($item as $key => $value) {
                    $query->whereNotIn($key, $value);
                }
            });
        }

        foreach ($hasRelations as $key => $item) {

            $data->has($item);
        }

        $data->orderBy(self::$columnOrder[$columnOrderName] ?? $columnOrderName, $columnOrderDir);
        $data = $data->get();

        foreach ($data as $item) {
            $item = self::addAllAttributes($item);
        }

        return $data;
    }

    public static function findLastByUserId($id)
    {
        $paySlip = PaySlip::with(['user.employee.title'])->orderByDesc('id')->where(['user_id' => $id])->first();
        if (!$paySlip) {
            return null;
        }

        $paySlip = self::addAllAttributes($paySlip);

        return $paySlip;
    }

    public static function findOneById($id)
    {
        $paySlip = PaySlip::with(['user.employee.title'])->orderByDesc('id')->where(['id' => $id])->first();
        if (!$paySlip) {
            return null;
        }

        $paySlip = self::addAllAttributes($paySlip);

        return $paySlip;
    }


    public static function updateStatus(PaySlip $paySlip, $status)
    {
        $paySlip->update([
            'status' => $status,
        ]);

        $paySlip = self::addAllAttributes($paySlip);

        return $paySlip;
    }

    public static function delete(PaySlip $paySlip)
    {

        DB::transaction(function () use ($paySlip) {

            $paySlip->delete();
        });
    }

    public static function store(PaySlipStoreDto $paySlipStoreDto)
    {
        $paySlip = PaySlip::updateOrCreate([
            'user_id' => $paySlipStoreDto->getUserId(),
            'period_start' => $paySlipStoreDto->getPeriodStart(),
            'period_end' => $paySlipStoreDto->getPeriodEnd(),
        ], [
            'date' => date("Y-m-d"),
            'basic_salary' => $paySlipStoreDto->getBasicSalary(),
            'meal_allowance' => $paySlipStoreDto->getMealAllowance(),
            'transport_allowance' => $paySlipStoreDto->getTransportAllowance(),
            'overtime_pay' => $paySlipStoreDto->getOverTimePay(),
            'bonus' => $paySlipStoreDto->getBonus(),
            'deduction_bpjs_kesehatan' => $paySlipStoreDto->getDeductionBpjsKesehatan(),
            'deduction_bpjs_ketenagakerjaan' => $paySlipStoreDto->getDeductionBpjsKetenagakerjaan(),
            'deduction_pph21' => $paySlipStoreDto->getDeductionPph21(),
            'deduction_late_or_leave' => $paySlipStoreDto->getDeductionLateOrLeave(),
            'note' => $paySlipStoreDto->getNote(),
            'status' => $paySlipStoreDto->getStatus(),
        ]);

        $paySlip = PaySlip::find($paySlip->id);

        $paySlip = self::addAllAttributes($paySlip);

        return $paySlip;
    }


    public static function update(PaySlipUpdateDto $paySlipUpdateDto)
    {
        $paySlip = PaySlip::updateOrCreate([
            'id' => $paySlipUpdateDto->getId(),
        ], [
            'period_end' => $paySlipUpdateDto->getPeriodEnd(),
            'period_start' => $paySlipUpdateDto->getPeriodStart(),
            'user_id' => $paySlipUpdateDto->getUserId(),
            'date' => date("Y-m-d"),
            'basic_salary' => $paySlipUpdateDto->getBasicSalary(),
            'meal_allowance' => $paySlipUpdateDto->getMealAllowance(),
            'transport_allowance' => $paySlipUpdateDto->getTransportAllowance(),
            'overtime_pay' => $paySlipUpdateDto->getOverTimePay(),
            'bonus' => $paySlipUpdateDto->getBonus(),
            'deduction_bpjs_kesehatan' => $paySlipUpdateDto->getDeductionBpjsKesehatan(),
            'deduction_bpjs_ketenagakerjaan' => $paySlipUpdateDto->getDeductionBpjsKetenagakerjaan(),
            'deduction_pph21' => $paySlipUpdateDto->getDeductionPph21(),
            'deduction_late_or_leave' => $paySlipUpdateDto->getDeductionLateOrLeave(),
            'note' => $paySlipUpdateDto->getNote(),
            'status' => $paySlipUpdateDto->getStatus(),
        ]);

        $paySlip = PaySlip::find($paySlip->id);

        $paySlip = self::addAllAttributes($paySlip);

        return $paySlip;
    }
}
