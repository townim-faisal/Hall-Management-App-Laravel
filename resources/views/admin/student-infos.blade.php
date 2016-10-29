@extends('layouts.app')

@section('htmlheader_title')
	Students List
@endsection

@section('htmlheader')
@parent
@section('htmlheader')
@parent
<style>
td{
    text-align: center;
}
/*tr:nth-child(even) {
    background-color: #f2f2f2;
}*/
</style>
@endsection
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
      <div class="alert alert-success search-success">
          <p></p>
      </div>
    </div>
    </div>

    <div class="row">
    <div class="col-xs-12">
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Students List</h3>
          <div class="box-tools">
            <ul class="pagination pagination-sm no-margin pull-right">
              @if($prev_floor > 0)
              <li><a href="{{route('students.info'). "?floor=". $prev_floor }}">«</a></li>
              @endif
              <li><a href="{{route('students.info'). "?floor=1"}}">1</a></li>
              <li><a href="{{route('students.info'). "?floor=2"}}">2</a></li>
              <li><a href="{{route('students.info'). "?floor=3"}}">3</a></li>
              <li><a href="{{route('students.info'). "?floor=4"}}">4</a></li>
              <li><a href="{{route('students.info'). "?floor=5"}}">5</a></li>
              @if($next_floor < 6)
              <li><a href="{{route('students.info'). "?floor=". $next_floor}}">»</a></li>
              @endif
            </ul>
          </div> 
        </div>
        <div class="box-footer">
          <div class="input-group">
            {!! csrf_field() !!}
            <input type="text" name="search" placeholder="Search by Roll No to see in which room he lives ..." class="form-control">
            <span class="input-group-btn">
              <button type="button" class="btn btn-default btn-flat search"><i class="fa fa-search" aria-hidden="true"></i></button>
            </span>
          </div>
        </div>
      </div>
    </div>
    </div>

    <div class="row">
    @foreach($rooms as $room)
    <div class="col-xs-12 col-md-4">
      <div class="box box-primary">
        <div class="box-header with-border">
          <b data-room="{{$room->id}}" id="{{$room->id}}">Room {{$room->room_no}}</b>
           @if(Auth::user()->hasAnyRole(['admin', 'employee']) ==true && ($room->max_persons) > (Auth::user()->studentInfo($room->id)->count()))
          <span data-toggle="tooltip" title="" class="badge bg-yellow pull-right" data-original-title="{{($room->max_persons) - (Auth::user()->studentInfo($room->id)->count())}} persons are short">{{($room->max_persons) - (Auth::user()->studentInfo($room->id)->count())}}</span>
          @endif
        </div>    
        <div class="box-body with-border">
          <table class="table table-striped">  
          <tbody>
          @foreach($students = Auth::user()->studentInfo($room->id) as $student)
          @if(Auth::user()->hasAnyRole(['admin', 'employee']) ==true )
          <tr>
          <td>
          <form method="POST" action="{{route('students.info')}}" class="delete">
          {{method_field('DELETE')}}
          {!! csrf_field() !!}
          <a href="{{url('/students/'.$student->roll_no)}}">{{$student->roll_no}}</a>
          </td>
          <td>
          {{$student->first_name}} {{$student->last_name}}
          </td>
          <td>
          <button type="submit" class="btn btn-danger btn-xs">Delete</button> 
          <input type="hidden" name="user_id" value="{{ $student->user_id }}"> 
          <input type="hidden" name="roll_no" value="{{ $student->roll_no }}">
          </td>
          </form>
          </tr>
          @else
          <tr>
          <td>
          <a href="{{url('/students/'.$student->roll_no)}}" style="margin-right:20px;">{{$student->roll_no}}</a>
          </td>
          <td>
          {{$student->first_name}} {{$student->last_name}}
          </td>
          </tr>
          @endif
          @endforeach
          </tbody>
          </table>
        </div>
      </div>          
    </div>
    @endforeach
    </div>
@endsection

@section('scripts')
@parent
<script type="text/javascript">
(function($) {
$(document).ready(function(){
    $('.search-success').hide();    
    var token = "{{Session::token()}}";

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

    $('.search').click(function(){
      var roll_no = $("input[name='search']").val();
      console.log(roll_no);
      $.ajax({
        url : "{{route('students.search')}}",
        method: "get",
        dataType: "json",
        data: {
          roll_no: roll_no,
          _token : token
        } 
      }).done(function(response){
        $('.search-success').show();
        $('.search-success').append('<p>'+response.success+'</p>');
      });

    });
});   
})(jQuery);
</script>
@endsection
