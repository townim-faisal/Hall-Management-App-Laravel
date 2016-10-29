@extends('layouts.app')

@section('htmlheader_title')
	Hall Staffs List
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

    <div class="row">
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><b>Provosts List</b></h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <div class="box-body no-padding">
          <table class="table table-striped">
            <thead>
            <tr>
              <th>Name</th>
              <th>Hall Designation</th>
              <th>Department</th>
              <th>Department Designation</th>
              <th>Phone No</th>
            </tr>
            </thead>
            <tbody>
            @foreach($employees as $employee)
            @if($employee->checkRole() == 'admin')
            <tr>
                <td>{{$employee->first_name}} {{$employee->last_name}}</td>
                <td>{{$employee->hall_designation}}</td>
                <td>{{$employee->department}}</td>
                <td>{{$employee->department_designation}}</td>
                <td>{{$employee->phone_no}}</td>
            </tr> 
            @endif
            @endforeach 
            </tbody>
          </table> 
        </div>
      </div>          
    </div>
    </div>

    <div class="row">
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><b>Hall Staffs List</b></h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <div class="box-body no-padding">
          <table class="table table-striped">
            <thead>
            <tr>
              <th>Name</th>
              <th>Hall Designation</th>
              <th>Department</th>
              <th>Department Designation</th>
              <th>Phone No</th>
            </tr>
            </thead>
            <tbody>
            @foreach($employees as $employee)
            @if($employee->checkRole() == 'employee')
            <tr>
                <td>{{$employee->first_name}} {{$employee->last_name}}</td>
                <td>{{$employee->hall_designation}}</td>
                <td>{{$employee->department}}</td>
                <td>{{$employee->department_designation}}</td>
                <td>{{$employee->phone_no}}</td>
            </tr> 
            @endif
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
