<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Role;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;

use DB;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'roles']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|unique:users|max:255',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $role_student = Role::where('name', $data['role'])->first();

        $user = User::create([
            'name' => $data['name'],
            'password' => bcrypt($data['password'])
        ]);
        $user->roles()->attach($role_student);
        
        return $user;
    }

    //override method
    public function showRegistrationForm()
    {   
        $rooms = DB::table('rooms')->get();
        return view('auth.register', compact('rooms'));
    }

    public function register(Request $request)
    {
        //dd($request->role);

        $this->validator($request->all())->validate();

        $this->create($request->all());
        //dd($request->role);
        if($request->role == 'student'){
            $last_user_id = DB::table('users')->latest()->value('id');
            DB::table('user_infos')->insert(
                ['user_id' => $last_user_id, 'room_id' => $request->room_no, 'roll_no' => $request->name]
            );
        } else {
            $last_user_id = DB::table('users')->latest()->value('id');
            DB::table('user_infos')->insert(
                ['user_id' => $last_user_id]
            );
        }
        return redirect($this->redirectPath())->with(['success' => 'Successfully Registered']);
    }
}
