@extends('layouts.app')

@section('htmlheader_title')
	Edit Student Profile
@endsection


@section('main-content')
  @if (count($errors) > 0)
  <div class="row">
  <div class="col-xs-12">
      <div class="alert alert-danger">
      <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
      </ul>
      </div>
  </div>    
  </div>
  @endif

  @if(Session::has('success'))
  <div class="row">
  <div class="col-xs-12">
      <div class="alert alert-success">
          <p> {!! Session::get('success') !!} </p>
      </div>
  </div>
  </div>
  @endif

  <div class="row">
  <div class="col-xs-12">
    <div class="box box-warning">
      <div class="box-header with-border">
        <h3 class="box-title"><b>Student Profile</b></h3>
        <a href="{{url('/students/'.$user->roll_no)}}" class="btn btn-info pull-right">Back</a>
      </div>
      <!-- /.box-header -->
      <!-- form start -->

      <form action="" method="post" enctype="multipart/form-data">
      {!! csrf_field() !!}
        <div class="box-body">
        <div class="col-md-6">
          <div class="form-group">
            <label for="">First Name</label> 
            <input type="hidden" class="form-control" name="user_id" value="{{$user->user_id}}">
            <input type="text" class="form-control" name="first_name" value="{{$user->first_name}}">
          </div>
          <div class="form-group">
            <label for="">Last Name</label>
            <input type="text" class="form-control" name="last_name" value="{{$user->last_name}}">
          </div>
          <div class="form-group">
            <label for="">Father Name</label>
            <input type="text" class="form-control" name="father_name" value="{{$user->father_name}}">
          </div>
          <div class="form-group">
            <label for="">Mother Name</label>
            <input type="text" class="form-control" name="mother_name" value="{{$user->mother_name}}">
          </div>
          <div class="form-group">
            <label for="">Permanent Address</label> 
            <input type="text" class="form-control" name="permanent_add" value="{{$user->perm_add}}">
          </div>
          <div class="form-group">
            <label for="">Present Address</label>
            <input type="text" class="form-control" name="present_add" value="{{$user->pres_add}}">
          </div>
          <div class="form-group">
            <label for="">Email</label>
            <input type="email" class="form-control" name="email" value="{{$user->email}}">
          </div>       
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="">Department</label> <i> Note: Enter department name like EEE, CSE, Physics</i>
            <input type="text" class="form-control" name="department" value="{{$user->department}}">
          </div>  
          @if($user->roll_no == null )
          <div class="form-group">
            <label for="">Hall Designation</label>
            <input type="text" class="form-control" name="hall_designation" value="{{$user->hall_designation}}">
          </div>
          <div class="form-group">
            <label for="">Department Designation</label>
            <input type="text" class="form-control" name="department_designation" value="{{$user->department_designation}}">
          </div>
          @endif
          @if($user->roll_no !== null )
          <div class="form-group">
            <label for="">Roll No</label>
            <input type="text" class="form-control" name="roll_no" value="{{$user->roll_no}}" disabled>
            <input type="hidden" class="form-control" name="roll_no" value="{{$user->roll_no}}">
          </div>
          <div class="form-group">
            <label>Room No</label>
            <select class="form-control" name="room_no">
            @foreach($rooms as $room)          
              <option value="{{$room->id}}" @if($user->room['room_no'] == $room->room_no) selected @endif>{{$room->room_no}}</option>         
            @endforeach
            </select>
          </div>
          @endif
          <div class="form-group">
            <label for="">Phone No</label>
            <input type="text" class="form-control" name="phone_no" value="{{$user->phone_no}}">
          </div>
          <div class="form-group">
            <label for="">Blood Group</label>
            <select class="form-control" name="blood_group">        
                <option value="AB+" @if($user->blood_group == 'AB+') selected @endif>AB+</option>  
                <option value="AB-" @if($user->blood_group == 'AB-') selected @endif>AB-</option>   
                <option value="B+" @if($user->blood_group == 'B+') selected @endif>B+</option>   
                <option value="B-" @if($user->blood_group == 'B-') selected @endif>B-</option>   
                <option value="A+" @if($user->blood_group == 'A+') selected @endif>A+</option> 
                <option value="A-" @if($user->blood_group == 'A-') selected @endif>A+</option>  
                <option value="O+" @if($user->blood_group == 'O+') selected @endif>O+</option>   
                <option value="O-" @if($user->blood_group == 'O-') selected @endif>O-</option>           
            </select>
          </div>
          {{-- <div class="form-group">
            <label for="">Image</label>
            <input type="file" name="photo"></input>
          </div> --}}
        </div>  
        </div>
        <div class="box-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>  
    </div>        
  </div>
  </div>
@endsection

@section('scripts')
@parent
<script type="text/javascript">
(function($) {
$(document).ready(function(){
    var current_time = new Date();
    var token = "{{Session::token()}}";
});   
})(jQuery);
</script>
@endsection
