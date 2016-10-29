<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class UserInfo extends Model
{
    //
    protected $fillable = ['department_designation', 'hall_designation', 'first_name', 'last_name', 'father_name', 'mother_name', 'department', 'perm_add', 'pres_add', 'phone_no', 'blood_group', 'photo', 'roll_no'];


    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function room()
    {
    	return $this->belongsTo('App\Room');
    }

    //check the user's role
    public function checkRole()
    {
        $user_id = $this->user['id'];
        $role_id = DB::table('user_role')->where('user_id', $user_id)->value('role_id');
        $role_name = DB::table('roles')->where('id', $role_id)->value('name');
        return $role_name;
    }
}
