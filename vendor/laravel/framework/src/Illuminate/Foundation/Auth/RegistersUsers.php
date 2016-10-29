<?php

namespace Illuminate\Foundation\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

trait RegistersUsers
{
    use RedirectsUsers;

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {   
        $rooms = DB::table('rooms')->get();
        return view('auth.register', compact('rooms'));
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }
}
