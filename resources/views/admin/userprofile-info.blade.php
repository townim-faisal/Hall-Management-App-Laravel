@extends('layouts.app')

@section('htmlheader_title')
	Student Profile
@endsection


@section('main-content')
    <div class="row">
    <div class="col-xs-12">
      <div class="box box-warning">
        <div class="box-header with-border">
          <h3 class="box-title"><b>Student Profile</b></h3>
          @if(Auth::user()->hasAnyRole(['admin', 'employee']) ==true )
          <a href="{{url('/students/'.$user->roll_no.'/edit')}}" class="btn btn-info pull-right">Edit</a>
          @endif
        </div>
        <!-- /.box-header -->
      </div>        
    </div>
    </div>
    <div class="box box-widget widget-user">
      <!-- Add the bg color to the header using any of the bg-* classes -->
      <div class="widget-user-header bg-yellow-active">
        <h3 class="widget-user-username">{{$user->first_name}} {{$user->last_name}}</h3>
        <h5 class="widget-user-desc">{{$user->designation}}</h5>
      </div>
      <div class="widget-user-image">
        @if(isset($user->photo))
        <img class="img-circle" src="{{url('images/users/'.$user->photo)}}" alt="User Avatar" style="height:90px; width:110px;">
        @else
        <img class="img-circle" src="{{asset('/images/profile.jpg')}}" alt="User Avatar" style="height:90px; width:110px;">
        @endif
      </div>
      <div class="box-footer">
        <div class="row">
        <div class="col-sm-6"> 
            <b><i class="fa fa-w fa-user"></i> Father Name: </b>{{$user->father_name}}<br><br>
            <b><i class="fa fa-w fa-user"></i> Mother Name: </b>{{$user->mother_name}}<br><br>
            <b><i class="fa fa-w fa-map-marker"></i> Present Address: </b>{{$user->pres_add}}<br><br>
            <b><i class="fa fa-w fa-map-marker"></i> Permanent Address: </b>{{$user->perm_add}}<br><br>
            <b><i class="fa fa-w fa-phone"></i> Phone No: </b>{{$user->phone_no}}<br><br>           
        </div>  
        <div class="col-sm-6">
            @if($user->roll_no !== null )
            <b><i class="fa fa-w fa-link"></i> Roll No: </b>{{$user->roll_no}}<br><br>
            <b><i class="fa fa-w fa-hand-o-right"></i> Room No: </b>{{$user->room['room_no']}}<br><br>
            @endif
            <b><i class="fa fa-w fa-graduation-cap"></i> Department: </b>{{$user->department}}<br><br>
            @if($user->roll_no == null )
            <b><i class="fa fa-w fa-cog"></i> Hall Designation: </b>{{$user->hall_designation}}<br><br>
            <b><i class="fa fa-w fa-cog"></i> Department Designation: </b>{{$user->department_designation}}<br><br>
            @endif
            <b><i class="fa fa-w fa-envelope"></i> Email: </b>{{$user->email}}<br><br>
            <b><i class="fa fa-w fa-tint"></i> Blood Group: </b>{{$user->blood_group}}<br><br>
        </div>
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
