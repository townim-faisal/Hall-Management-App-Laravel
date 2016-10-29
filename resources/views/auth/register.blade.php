@extends('layouts.auth')

@section('htmlheader_title')
    My Hall - Register
@endsection

@section('content')

    <body class="hold-transition register-page">
    <div class="register-box">
        <div class="register-logo">
            <p><b>My HALL</b></p>
        </div>

        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> {{ trans('adminlte_lang::message.someproblems') }}<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="register-box-body">
            <p class="login-box-msg">{{ trans('adminlte_lang::message.registermember') }}</p>
            <form action="{{ url('/register') }}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="Unique Name/Roll No" name="name" value="{{ old('name') }}"/>
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                {{-- <div class="form-group has-feedback">
                    <input type="email" class="form-control" placeholder="{{ trans('adminlte_lang::message.email') }}" name="email" value="{{ old('email') }}"/>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div> --}}
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" placeholder="{{ trans('adminlte_lang::message.password') }}" name="password"/>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" placeholder="{{ trans('adminlte_lang::message.retrypepassword') }}" name="password_confirmation"/>
                    <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <label class="">Select User Role</label>
                    <select class="form-control role" name="role"> 
                        <option value="student">Student</option> 
                        @if(Auth::user()->hasAnyRole('admin') == true)
                        <option value="admin">Admin</option> 
                        <option value="employee">Employee</option> 
                        @endif             
                    </select>
                </div>
                <div class="form-group has-feedback room">
                    <label class="">Select Room</label>
                    <select class="form-control room_no" name="room_no"> 
                        @foreach($rooms as $room)          
                          <option value="{{$room->id}}">{{$room->room_no}}</option>         
                        @endforeach            
                    </select>
                </div>
                <div class="row">
                    {{-- <div class="col-xs-1">
                        <label>
                            <div class="checkbox_register icheck">
                                <label>
                                    <input type="checkbox" name="terms">
                                </label>
                            </div>
                        </label>
                    </div><!-- /.col -->
                    <div class="col-xs-6">
                        <div class="form-group">
                            <button type="button" class="btn btn-block btn-flat" data-toggle="modal" data-target="#termsModal">{{ trans('adminlte_lang::message.terms') }}</button>
                        </div>
                    </div> --}}<!-- /.col -->
                    <div class="col-xs-4 pull-left">
                        <a href="{{route('dashboard')}}" class="btn btn-primary btn-block btn-flat"><i class="fa fa-arrow-left"></i> Back</a>
                    </div>
                    <div class="col-xs-4 pull-right">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">{{ trans('adminlte_lang::message.register') }}</button>
                    </div><!-- /.col -->
                </div>
            </form>

            {{-- @include('auth.partials.social_login') --}}

            {{-- <a href="{{ url('/login') }}" class="text-center">{{ trans('adminlte_lang::message.membreship') }}</a> --}}
        </div><!-- /.form-box -->
    </div><!-- /.register-box -->
    <footer class="footer">
    <center>
        <strong>
        Copyright &copy; <a href="#">My Hall</a>. Created By <a href="#">Townim Faisal</a>
        </strong>
    </center>
    </footer> 

    @include('layouts.partials.scripts_auth') 

    @include('auth.terms')

    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
            $('.room').show();
            /*$(".role").find("option[value='student']").select(function(){
                $('.room').show();
            });*/
            $('.role').change(function(){
                if($('option:selected').val() == 'student') $('.room').show();
                if($('option:selected').val() !== 'student') $('.room').hide();
            });
        });
    </script>
</body>

@endsection
