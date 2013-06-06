@section('title')
Message History
@stop

@section('content')
<div class="row">
	<div class="large-12 columns">
		<h1 class="subheader">Message History</h1>
	</div>
</div>

<div class="row">
	<div class="large-12 columns">
		@if($errors->any())
		@foreach($errors->getMessages() as $message)
		<div data-alert class="alert-box alert">
			{{$message[0]}}
			<a href="#" class="close">&times;</a>
		</div>

		@endforeach
		@elseif(Session::get('message'))
		<div data-alert class="alert-box success">
			{{Session::get('message')}}
			<a href="#" class="close">&times;</a>
		</div>
		@endif
	</div>
</div>
<div class="row">
	<div class="large-6 small-12 columns">
		<span class="bar-graph" >

		</span>
	</div>
	<div class="large-6 small-12 columns panel">

	</div>
</div>
@stop

@section('scripts')

@stop
