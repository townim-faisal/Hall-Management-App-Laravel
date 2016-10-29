@extends('layouts.app')

@section('htmlheader_title')
	Settings - Access Control
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
          <h3 class="box-title"><b>Access Control List</b></h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <div class="box-body no-padding">
          <table class="table table-striped">
            <thead>
            <tr>
              <th>User Name/Roll No</th>
              <th>Student</th>
              <th>Employee</th>
              <th>Admin</th>
              <th></th>
              <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
            <tr id="{{ $user->name }}">
              <form action="{{route('settings.acl')}}" method="post">
              {!! csrf_field() !!}
              <td>{{ $user->name }} <input type="hidden" name="name" value="{{ $user->name }}"></td>
              <td><input type="checkbox" {{ $user->hasRole('student') ? 'checked' : '' }} name="role_student" value="student"></td>
              <td><input type="checkbox" {{ $user->hasRole('employee') ? 'checked' : '' }} name="role_employee" value="employee"></td>
              <td><input type="checkbox" {{ $user->hasRole('admin') ? 'checked' : '' }} name="role_admin" value="admin"></td>
              <td><button class="btn btn-primary btn-xs assign" type="submit">Assign Roles</button></td>
              </form>
              <form method="POST" action="{{route('settings.acl')}}" class="delete">
              {{method_field('DELETE')}}
              {!! csrf_field() !!}
              <td><button type="submit" class="btn btn-danger btn-xs">Delete</button> <input type="hidden" name="name" value="{{ $user->name }}"></td>
              </form>
            </tr>  
            @endforeach
            </tbody>
          </table> 
        </div>
      </div>          
    </div>
    </div>
    <center>
    {{ $users->links() }}
    </center>
@endsection

@section('scripts')
@parent
<script type="text/javascript">
(function($) {
$(document).ready(function(){
    var token = "{{Session::token()}}";
    var name = $("input[name='name']").val();
    $(".delete").on('submit', function(event){
      console.log(12);
      var x = confirm("Are you sure you want to delete this user?");
      if (x) {
          return true;
      }else {
        event.preventDefault();
        return false;
      }
    });
    /*$('.delete').click(function(){     
      $.ajax({
        url : "",
        method: "delete",
        dataType: "json",
        data: {
          name : name,
          _token : token
        } 
      }).done(function(response){
        $('.alert-success').show();
        $('.alert-success').append('<p>'+response.delete+'</p>');
        $('tr#'+name).remove();
      });

    });
    $('.assign').click(function(){
      $.ajax({
        url : "",
        method: "post",
        dataType: "json",
        data: {
          name : name,
          role : $("input[name='role_employee']:checked").val(),
          _token : token
        } 
      }).done(function(response){
        $('.alert-success').show();
        $('.alert-success').append('<p>'+response.success+'</p>');

      });

    });*/
});   
})(jQuery);
</script>
@endsection
