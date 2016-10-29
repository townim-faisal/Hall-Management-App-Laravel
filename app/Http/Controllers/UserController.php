<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;
use App\User;
use App\UserInfo;
use App\Room;

class UserController extends Controller
{
    //view after login a user
    public function index()
    {   
    	return view('dashboard');
    }

    //view the login user profile
    public function getProfile()
    {   
        $user = UserInfo::where('user_id', Auth::user()->id)->first();
        //dd();
        return view('profile', compact('user'));
    }

    //view the login user's profile edit view
    public function getEditProfile()
    {
    	$rooms = Room::all();
        $user = UserInfo::where('user_id', Auth::user()->id)->first();
        return view('profile-edit', compact('rooms', 'user'));
    }

    //post user his own profile data
    public function postEditProfile(Request $request)
    {   //dd($request->all());
        $validation = [
            'first_name'  => 'required|min:3',
            'last_name'  => 'required|min:3',
            'father_name'  => 'required',
            'mother_name'  => 'required',
            'department'  => 'required',
            'permanent_add'  => 'required',
            'present_add'  => 'required',
            'phone_no'  => 'required|max:11',
            'email'     => 'required|email',
            'blood_group'  => 'required',
            'photo'  => 'required|image|max:50|mimes:jpeg',
        ];

        $user = UserInfo::findOrFail(Auth::user()->id);

        if(Auth::user()->hasAnyRole(['admin', 'employee']) == true) {
            $validation['hall_designation']  = 'required';
            $validation['department_designation']  = 'required';
            $user->hall_designation = $request->hall_designation;
            $user->department_designation = $request->department_designation;
        }

        $this->validate($request, $validation);

        $imageName = Auth::user()->id.'.'.$request->file('photo')->getClientOriginalExtension();
        $request->file('photo')->move(
            base_path() . '/public/images/users/', $imageName
        );
       
        $user->user_id = Auth::user()->id;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->father_name = $request->father_name;
        $user->mother_name = $request->mother_name;
        $user->department = $request->department;
        $user->perm_add = $request->permanent_add;
        $user->pres_add = $request->present_add;
        $user->phone_no = $request->phone_no;
        $user->email = $request->email;
        $user->blood_group = $request->blood_group;
        $user->photo = $imageName;       

        $user->save();

    	return back()->with(['success' => 'Successfully Updated']);
    }

    //user can view who are the employees in hall
    public function getEmployees()
    {   
        $employees = UserInfo::whereNull('room_id')->get();
        //dd($employees);
        return view('admin.employee-infos', compact('employees'));
    }

    //user can view who are the hall manager for current month
    public function getHallManager()
    {
        $hall_managers = UserInfo::where('hall_manager', true)->get();
        return view('admin.hall-manager-infos', compact('hall_managers'));
    }

    //user can view change password page
    public function getChangePassword()
    {
        $user = Auth::user()->id;
        return view('admin.change_password');
    }

    //user can post his changed password
    public function postChangePassword(Request $request)
    {
        $this->validate($request, [
            'new_password' => 'required|min:6|confirmed'
        ]);   

        $user = User::findOrFail($request->user_id);
        //dd($user);
        $user->name = $request->user_name;
        $user->password = bcrypt($request->new_password);
        $user->save();

        return back()->with(['success' => 'Your password is changed']);

    }

}
