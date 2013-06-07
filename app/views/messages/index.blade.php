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
	@foreach($messages as $message)
	<div class="large-4 small-12 columns panel">
		<div class="row">
			<div class="large-1 small-1 columns">
				<h3><a href="/messages/{{$message->id}}">{{$message->id}}</a></h3>
			</div>
			<div class="large-10 small-10 columns">
				<div>{{$message->text}}</div>
				<div>{{str_replace('a',' ',$message->morse)}}</div>
				<div>{{date("F j, Y g:i a", strtotime($message->created_at))}}</div>
			</div>
		</div>

	</div>
	@endforeach
</div>

@stop

@section('scripts')

@stop
