<?php

namespace Database\Seeders;

use App\Services\ServiceImpl\UserServiceImpl;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::firstOrCreate(['name' => 'admin']);

        $permissions = [
            'web.admin.user.index',
            'web.admin.user.create',
            'web.admin.user.store',
            'web.admin.user.show',
            'web.admin.user.edit',
            'web.admin.user.update',
            'web.admin.user.delete',
            'web.admin.user.updateStatus',

            'web.admin.employee.index',
            'web.admin.employee.create',
            'web.admin.employee.store',
            'web.admin.employee.show',
            'web.admin.employee.edit',
            'web.admin.employee.update',
            'web.admin.employee.delete',
            'web.admin.employee.updateStatus',

            'web.admin.employeeOffDay.index',
            'web.admin.employeeOffDay.create',
            'web.admin.employeeOffDay.store',
            'web.admin.employeeOffDay.show',
            'web.admin.employeeOffDay.edit',
            'web.admin.employeeOffDay.update',
            'web.admin.employeeOffDay.delete',
            'web.admin.employeeOffDay.updateStatus',


            'web.admin.title.index',
            'web.admin.title.create',
            'web.admin.title.store',
            'web.admin.title.show',
            'web.admin.title.edit',
            'web.admin.title.update',
            'web.admin.title.delete',
            'web.admin.title.updateStatus',


            'web.admin.application.index',
            'web.admin.application.create',
            'web.admin.application.store',
            'web.admin.application.show',
            'web.admin.application.edit',
            'web.admin.application.update',
            'web.admin.application.delete',
            'web.admin.application.updateStatus',


            'web.admin.organization.index',
            'web.admin.organization.create',
            'web.admin.organization.store',
            'web.admin.organization.show',
            'web.admin.organization.edit',
            'web.admin.organization.update',
            'web.admin.organization.delete',
            'web.admin.organization.updateStatus',


            'web.admin.shift.index',
            'web.admin.shift.create',
            'web.admin.shift.store',
            'web.admin.shift.show',
            'web.admin.shift.edit',
            'web.admin.shift.update',
            'web.admin.shift.delete',
            'web.admin.shift.updateStatus',

            'web.admin.userShift.index',
            'web.admin.userShift.create',
            'web.admin.userShift.store',
            'web.admin.userShift.show',
            'web.admin.userShift.edit',
            'web.admin.userShift.update',
            'web.admin.userShift.delete',
            'web.admin.userShift.updateStatus',


            'web.admin.motivational.index',
            'web.admin.motivational.create',
            'web.admin.motivational.store',
            'web.admin.motivational.show',
            'web.admin.motivational.edit',
            'web.admin.motivational.update',
            'web.admin.motivational.delete',
            'web.admin.motivational.updateStatus',


            'web.admin.attendance.index',
            'web.admin.attendance.create',
            'web.admin.attendance.store',
            'web.admin.attendance.show',
            'web.admin.attendance.edit',
            'web.admin.attendance.update',
            'web.admin.attendance.delete',
            'web.admin.attendance.updateStatus',


            'web.admin.breakTime.index',
            'web.admin.breakTime.create',
            'web.admin.breakTime.store',
            'web.admin.breakTime.show',
            'web.admin.breakTime.edit',
            'web.admin.breakTime.update',
            'web.admin.breakTime.delete',
            'web.admin.breakTime.updateStatus',


            'web.admin.overTime.index',
            'web.admin.overTime.create',
            'web.admin.overTime.store',
            'web.admin.overTime.show',
            'web.admin.overTime.edit',
            'web.admin.overTime.update',
            'web.admin.overTime.delete',
            'web.admin.overTime.updateStatus',


            'web.admin.trip.index',
            'web.admin.trip.create',
            'web.admin.trip.store',
            'web.admin.trip.show',
            'web.admin.trip.edit',
            'web.admin.trip.update',
            'web.admin.trip.delete',
            'web.admin.trip.updateStatus',


            'web.admin.visitType.index',
            'web.admin.visitType.create',
            'web.admin.visitType.store',
            'web.admin.visitType.show',
            'web.admin.visitType.edit',
            'web.admin.visitType.update',
            'web.admin.visitType.delete',
            'web.admin.visitType.updateStatus',


            'web.admin.visit.index',
            'web.admin.visit.create',
            'web.admin.visit.store',
            'web.admin.visit.show',
            'web.admin.visit.edit',
            'web.admin.visit.update',
            'web.admin.visit.delete',
            'web.admin.visit.updateStatus',


            'web.admin.paySlip.index',
            'web.admin.paySlip.create',
            'web.admin.paySlip.store',
            'web.admin.paySlip.show',
            'web.admin.paySlip.edit',
            'web.admin.paySlip.update',
            'web.admin.paySlip.delete',
            'web.admin.paySlip.updateStatus',


            'web.admin.recape.index',
            'web.admin.recape.create',
            'web.admin.recape.store',
            'web.admin.recape.show',
            'web.admin.recape.edit',
            'web.admin.recape.update',
            'web.admin.recape.delete',
            'web.admin.recape.updateStatus',


            'web.admin.tripType.index',
            'web.admin.tripType.create',
            'web.admin.tripType.store',
            'web.admin.tripType.show',
            'web.admin.tripType.edit',
            'web.admin.tripType.update',
            'web.admin.tripType.delete',
            'web.admin.tripType.updateStatus',

            'web.admin.trip.index',
            'web.admin.trip.create',
            'web.admin.trip.store',
            'web.admin.trip.show',
            'web.admin.trip.edit',
            'web.admin.trip.update',
            'web.admin.trip.delete',
            'web.admin.trip.updateStatus',


            'web.admin.offType.index',
            'web.admin.offType.create',
            'web.admin.offType.store',
            'web.admin.offType.show',
            'web.admin.offType.edit',
            'web.admin.offType.update',
            'web.admin.offType.delete',
            'web.admin.offType.updateStatus',


            'web.admin.offDay.index',
            'web.admin.offDay.create',
            'web.admin.offDay.store',
            'web.admin.offDay.show',
            'web.admin.offDay.edit',
            'web.admin.offDay.update',
            'web.admin.offDay.delete',
            'web.admin.offDay.updateStatus',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $role->syncPermissions($permissions);

        // atur usernya supaya bisa punya permission itu
        $user = UserServiceImpl::findAdmin();

        $user->assignRole($role);
    }
}
