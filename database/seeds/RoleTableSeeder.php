<?php

use Illuminate\Database\Seeder;

use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_student = new Role();
        $role_student->name = 'student';
        $role_student->description = 'A student';
        $role_student->save();

        $role_employee = new Role();
        $role_employee->name = 'employee';
        $role_employee->description = 'An employee';
        $role_employee->save();


        $role_admin = new Role();
        $role_admin->name = 'admin';
        $role_admin->description = 'An Admin';
        $role_admin->save();
    }
}
