<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;
use App\Role;
use App\UserInfo;
use App\Room;
use Auth;
use DB;

class AdminController extends Controller
{   
    //get all students according to room number and floor no
    public function getStudents(Request $request)
    {   
        //dd();
        $floor_no = isset($request->floor) ? $request->floor : 1 ;
        $next_floor = $floor_no+1;
        $prev_floor = $floor_no-1;
        
        $rooms = Room::where('floor_no', $floor_no)->get();
        return view('admin.student-infos' , compact('rooms', 'next_floor', 'prev_floor', 'floor_no'));
    }

    //delete student from student info list
    public function deleteStudents(Request $request)
    {   
        $user = User::where('id', $request->user_id)->first();
        $user->delete();
        return back()->with(['success' => 'Successfully student with roll no '.$request->roll_no.' is deleted']);
    }

    //get a single student's profile
    public function getSingleStudent($roll)
    {
        $user = UserInfo::where('roll_no', $roll)->firstOrFail();
        return view('admin.userprofile-info' , compact('user'));
    }

    //get view of edit single student profile
    public function getEditSingleStudent($roll)
    {   //dd(UserInfo::where('roll_no', 1101031)->first());
        //dd(DB::table('users')->latest()->value('id'));
        $user = UserInfo::where('roll_no', $roll)->firstOrFail();
        $rooms = Room::all();
        return view('admin.userprofile-edit', compact('user', 'rooms'));
    }

    //post data for editing single student profile
    public function postEditSingleStudent(Request $request)
    {
        $validation = [
            'room_no'  => 'required',
        ];

        $user = UserInfo::where('roll_no', $request->roll_no)->firstOrFail();
        if($request->photo !== null) {
            $validation['photo']  = 'required|image|max:50|mimes:jpeg';
            $imageName = $request->user_id.'.'.$request->file('photo')->getClientOriginalExtension();
            $request->file('photo')->move(
                base_path() . '/public/images/users/', $imageName
            );
            $user->photo = $imageName; 
        }
        //dd($this->validate($request, $validation));
        $this->validate($request, $validation);
      
        //dd($user->create($request->all()));
        $user->user_id = $request->user_id;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->father_name = $request->father_name;
        $user->mother_name = $request->mother_name;
        $user->department = $request->department;
        $user->perm_add = $request->permanent_add;
        $user->pres_add = $request->present_add;
        $user->phone_no = $request->phone_no;
        $user->room_id = $request->room_no;
        $user->roll_no = $request->roll_no;
        $user->email = $request->email;
        $user->blood_group = $request->blood_group;

        $user->save();
        return back()->with(['success' => 'Successfully Updated']);
    }
 
    //search student by roll number and find in which room he lives
    public function searchStudent(Request $request)
    {   
        //dd($request->roll_no);
        $student = UserInfo::where('roll_no', $request->roll_no)->first();
        
        if($student !== null) {
            $student_room = $student->room['room_no'];
            return response()->json(['success' => $request->roll_no. ' lives in room no '.$student_room,]);
        } else {
            return response()->json(['success' => $request->roll_no. ' is either not a boarder of Shah hall or not a valid roll no']);
        }
    }

    //create hall manager for current month
    public function postHallManager(Request $request)
    {   
        $this->validate($request, [
            'roll_no' => 'required|integer'
        ]);

        $hall_manager = UserInfo::where('roll_no' , $request->roll_no)->first();
        
        if($hall_manager !== null){
            $hall_manager->hall_manager = true;
            $hall_manager->save();
            return back()->with(['success' => 'Successfully make roll no '.$request->roll_no.' as a Hall Manager for current month']);
        } else {
            return back()->with(['success' => $request->roll_no. ' is not a boarder of Shah hall']);
        }
    }

    //remove a student from hall manager post
    public function removeHallManager(Request $request)
    {   
        $hall_manager = UserInfo::where('roll_no' , $request->hall_manager)->first();
        $hall_manager->hall_manager = false;
        $hall_manager->save();
        return back()->with(['success' => 'Successfully remove roll no '.$request->hall_manager.' form Hall Manager post']);
    }

    //view hall summary
    public function getHallSummary(Request $request)
    {   
        $floor_no = isset($request->floor) ? $request->floor : 1 ;
        $next_floor = $floor_no+1;
        $prev_floor = $floor_no-1;
        
        $rooms = Room::where('floor_no', $floor_no)->get();
        return view('admin.hall_summary', compact('rooms', 'next_floor', 'prev_floor', 'floor_no'));
    }

    //post max persons in every room 
    public function postHallSummary(Request $request)
    {
        $this->validate($request, [
            'maximum_persons' => 'required|integer'
        ]);

        $room = Room::where('id', $request->room_id)->firstOrFail();
        $room->max_persons = $request->maximum_persons;
        $room->save();

        return back()->with(["success" => "Successfully sets room's maximum persons."]);
    }

    //only for admin to change other users password
    public function getChangeUserPassword()
    {   
        return view('admin.change_user_password');
    }

    //only for admin to change other users password
    public function postChangeUserPassword(Request $request)
    {
        $this->validate($request, [
            'new_password' => 'required|min:6|confirmed'
        ]); 

        $user = User::where('name', $request->user_name)->firstOrfail();
        $user->password = bcrypt($request->new_password);
        $user->save();

        return back()->with(["success" => $request->user_name. "'s password is changed"]);
    }

    //only for admin to assign roles to users
    public function getAssignRoles()
    {   
        $users = User::paginate(50);
        return view('admin.acl-settings', compact('users'));
    }

    //only for admin to assign roles to users
    public function postAssignRoles(Request $request)
    {   
        //dd($request->all());
        $user = User::where('name', $request->name)->first();
        $user->roles()->detach();

        if($request->role_student) {
            $user->roles()->attach(Role::where('name', 'student')->first());
        }

        if($request->role_admin) {
            $user->roles()->attach(Role::where('name', 'admin')->first());
        }

        if($request->role_employee) {
            $user->roles()->attach(Role::where('name', 'employee')->first());
        }

        return back()->with(['success' => 'Successfully Updated User\'s Role']);
    }

    //only for admin to delete user
    public function deleteUser(Request $request)
    {   //dd($request->all());
        $user = User::where('name', $request->name)->first();
        $user->delete();

        return back()->with(['success' => 'Successfully User '.$request->name.' is deleted']);
    }
}
