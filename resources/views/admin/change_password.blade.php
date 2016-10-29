@extends('layouts.app')

@section('htmlheader_title')
	Change Password
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
  <div class="col-xs-6 col-xs-offset-3">
    <div class="box box-warning">
      <div class="box-header with-border">
        <h3 class="box-title"><b>Change Password</b></h3>
      </div>
      <!-- /.box-header -->
      <!-- form start -->

      <form action="" method="post" enctype="multipart/form-data">
      {!! csrf_field() !!}
        <div class="box-body">
          <div class="form-group">
            <label for="">New Pasword</label> 
            <input type="hidden" class="form-control" name="user_id" value="{{Auth::user()->id}}">
            <input type="hidden" class="form-control" name="user_name" value="{{Auth::user()->name}}">
            <input type="password" class="form-control" name="new_password" value="">
          </div>
          <div class="form-group">
            <label for="">Re-type New Password</label>
            <input type="password" class="form-control" name="new_password_confirmation" value="">
          </div>
        </div>
        <div class="box-footer">
          <button type="submit" class="btn btn-primary pull-right">Submit</button>
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
