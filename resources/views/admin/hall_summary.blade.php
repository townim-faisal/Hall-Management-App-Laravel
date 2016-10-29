@extends('layouts.app')

@section('htmlheader_title')
  Hall Summary
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
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Students List</h3>
          <div class="box-tools">
            <ul class="pagination pagination-sm no-margin pull-right">
              @if($prev_floor > 0)
              <li><a href="{{route('hall.summary'). "?floor=". $prev_floor }}">«</a></li>
              @endif
              <li><a href="{{route('hall.summary'). "?floor=1"}}">1</a></li>
              <li><a href="{{route('hall.summary'). "?floor=2"}}">2</a></li>
              <li><a href="{{route('hall.summary'). "?floor=3"}}">3</a></li>
              <li><a href="{{route('hall.summary'). "?floor=4"}}">4</a></li>
              <li><a href="{{route('hall.summary'). "?floor=5"}}">5</a></li>
              @if($next_floor < 6)
              <li><a href="{{route('hall.summary'). "?floor=". $next_floor}}">»</a></li>
              @endif
            </ul>
          </div> 
        </div>
        <div class="box-body no-padding">
          <table class="table table-striped">
            <thead>
            <tr>
              <th>Room</th>
              <th>Current Student No</th>
              <th>Short Of Students</th>
              <th>Max. Students</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($rooms as $room)
            <tr>
              <td>Room {{$room->room_no}}</td>
              <td>{{Auth::user()->studentInfo($room->id)->count()}}</td>
              <td>{{($room->max_persons) - (Auth::user()->studentInfo($room->id)->count())}}</td>
              <form action="{{route('hall.summary')}}" method="post">
              {!! csrf_field() !!}
              <td><input type="text" name="maximum_persons" value="{{$room->max_persons}}"> </td>
              <td><input type="hidden" name="room_id" value="{{$room->id}}"> <button type="submit" class="btn btn-primary btn-xs">Submit</button></td>
              </form>
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
    var token = "{{Session::token()}}";
    var name = $("input[name='name']").val();

});   
})(jQuery);
</script>
@endsection
