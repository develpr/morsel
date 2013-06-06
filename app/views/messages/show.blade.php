@section('title')
Morsel Test
@stop

@section('content')
<div class="row">
	<div class="large-12 columns">
		<h1 class="subheader">Message #{{$message->id}} Info</h1>
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
			@if($times !== false)
			<?php echo implode(',',$times); ?>
			@endif
		</span>
	</div>
	<div class="large-6 small-12 columns panel">
		<h6>Message info</h6>
		<table>
			<tr>
				<td>Message</td>
				<td>{{$message->text}}</td>
			</tr>
		</table>
	</div>
</div>
@stop

@section('scripts')
<script type="text/javascript" src="{{URL::to('javascripts/jquery.peity.min.js')}}"></script>
<script>

	$.fn.peity.defaults.bar = {
		colours: ["#4d89f9"],
		delimiter: ",",
		height: 206,
		max: null,
		min: 0,
		spacing: 10,
		width: "100%"
	}

	//colors
	//9, 89, 101
	//191, 117, 48
	$(".bar-graph").peity("bar", {
		colours: function(_, i, all) {

			if(i % 2 == 0)
				return "rgb(9, 89, 101)";
			else
				return "rgb(191, 117, 48)";

		}
	});

</script>
@stop
