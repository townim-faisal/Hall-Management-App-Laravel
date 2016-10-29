<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Role;
//use DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_student = Role::where('name', 'student')->first();
        $role_admin = Role::where('name', 'admin')->first();
        $role_employee = Role::where('name', 'employee')->first();

        $user1 = new User();
        $user1->name = '1101053';
        $user1->password = bcrypt('123456');
        $user1->save();
        $last_user_id = DB::table('users')->latest()->value('id');
        DB::table('user_infos')->insert(['user_id' => $last_user_id, 'room_id' => 1, 'roll_no' => 1101053]);
        $user1->roles()->attach($role_student);

        $user2 = new User();
        $user2->name = '1101052';
        $user2->password = bcrypt('123456');
        $user2->save();
        $last_user_id = DB::table('users')->latest()->value('id');
        DB::table('user_infos')->insert(['user_id' => $last_user_id, 'room_id' => 1, 'roll_no' => 1101052]);
        $user2->roles()->attach($role_student);

        $user2 = new User();
        $user2->name = 'employee';
        $user2->password = bcrypt('123456');
        $user2->save();
        $last_user_id = DB::table('users')->latest()->value('id');
        DB::table('user_infos')->insert(['user_id' => $last_user_id]);
        $user2->roles()->attach($role_employee);

        $admin = new User();
        $admin->name = 'admin';
        $admin->password = bcrypt('123456');
        $admin->save();
        $last_user_id = DB::table('users')->latest()->value('id');
        DB::table('user_infos')->insert(['user_id' => $last_user_id]);
        $admin->roles()->attach($role_admin);
    }
}
