@extends('layouts.app')

@section('htmlheader_title')
	Hall Manager
@endsection

@section('htmlheader')
@parent
<style>
th, td{
    text-align: center;
}
tr:nth-child(even) {
    background-color: #f2f2f2;
}
</style>
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

    @if(Auth::user()->hasAnyRole(['admin', 'employee']) ==true )
    <form action="{{route('hallmanager.create')}}" method="post">
    {!! csrf_field() !!}
    <div class="row">
    <div class="col-xs-12">
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Create Hall Managers</h3>
          <div class="box-tools">
            <button type="submit" class="btn btn-primary btn-xs">Create</button>
          </div> 
        </div>
        <div class="box-footer">
          <div class="form-group">
            <input type="text" name="roll_no" placeholder="Enter Roll No..." class="form-control">
          </div>
        </div>
      </div>
    </div>
    </div>
    </form>
    @endif

    <div class="row">
    <div class="col-xs-12">
      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title"><b>Current Hall Managers List</b></h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <div class="box-body no-padding">
          <table class="table table-striped">
            <thead>
            <tr>
              <th>Name</th>
              <th>Department</th>
              <th>Roll No</th>
              <th>Room No</th>
              <th>Phone No</th>
              @if(Auth::user()->hasAnyRole(['admin', 'employee']) ==true )
              <th></th>
              @endif
            </tr>
            </thead>
            <tbody>
            @foreach($hall_managers as $hall_manager)
            <tr>
                <td><a href="{{url('/students/'.$hall_manager->roll_no)}}">{{$hall_manager->first_name}} {{$hall_manager->last_name}}</a></td>
                <td>{{$hall_manager->department}}</td>
                <td>{{$hall_manager->roll_no}}</td>
                <td>{{$hall_manager->room['room_no']}}</td>
                <td>{{$hall_manager->phone_no}}</td>
                @if(Auth::user()->hasAnyRole(['admin', 'employee']) ==true )
                <form method="POST" action="{{route('hallmanager.remove')}}">
                {!! csrf_field() !!}
                <td><input type="hidden" name="hall_manager" value="{{ $hall_manager->roll_no }}"><button type="submit" class="btn btn-danger btn-xs">Remove</button></td>
                @endif
            </tr> 
            @endforeach 
            </tbody>
          </table> 
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
