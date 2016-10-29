@extends('layouts.app')

@section('htmlheader_title')
	Dashboard
@endsection


@section('main-content')
	@if(Session::has('success'))
	  <div class="row">
	  <div class="col-xs-12">
	      <div class="alert alert-success">
	          <p> {!! Session::get('success') !!} </p>
	      </div>
	  </div>
	  </div>
	@endif

	<div class="container">
		<div class="row">
			<div class="col-md-10">
				<div class="panel panel-default">
					<div class="panel-heading">Home</div>

					<div class="panel-body">
						{{ trans('adminlte_lang::message.logged') }}
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
