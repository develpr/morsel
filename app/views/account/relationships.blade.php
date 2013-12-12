@section('title')
My Account
@stop

@section('content')
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
<div class="row relationships recipients">
	<div class="large-12 small-12 columns">
		<h2>Recipients</h2>
		<div class="row callout panel ">
			<div class="large-5 columns">

				<form id="recipient_search" method="get" name="recipient_search" action="{{url('api/v1/users')}}" class="row collapse">
					<label>Username</label>
					<div class="small-10 columns">
						<input name="username" id="username" type="text" placeholder="mybestfriend" />
					</div>
					<div class="small-2 columns">
						<button type="submit" value="submit" style="color:white" href="#" class="button postfix"><i class="fi-page-search"></i></button>
					</div>
				</form>
				<div class="row">
					<ul class="recipient-search-results">
					</ul>
				</div>
			</div>
			<div class="large-7 columns">
				<p>Search by username below to find new recipients for your morse code messages. <strong>If you'd like a friend to send you messages, they'll need to add you as a recipient in their account settings</strong>.</p>
			</div>
		</div>
		<p>These are the users that will receive morsel messages when you create a new message/transmission.</p>
		<div class="row current-recipients">
			@foreach($recipients as $recipient)
			<div class="panel remove large-12 alert small-12 columns">
				<a href="#" data-recipientid="{{$recipient->id}}"><i class="right fi-trash"></i></a>
				<h5 class="left"><span>{{$recipient->first_name}} {{$recipient->last_name}}</span></h5>
			</div>
			@endforeach
		</div>
	</div>
</div>
@stop

@section('scripts')
<script>
	<?php //todo: this really should be done totally different - "remove the truth from the DOM" ?>

	window.appData = {};
	appData.recipients = {};

	var recipientsResourceUri = "{{url('api/v1/recipients')}}";

	$(function(){

		var recipientTemplate = '<div class="panel remove large-12 alert small-12 columns"><a href="#" data-recipientid="{id}"><i class="right fi-trash"></i></a><h5 class="left"><span>{first_name} {last_name}</span></h5></div>';

		$('.recipients').on('click', ' .remove  a', function(event){
			event.preventDefault();

			$(this).parent().remove();

			var request = $.ajax({
				url: recipientsResourceUri + "/" + $(this).data('recipientid'),
				type: "POST",
				data: { "_method": 'DELETE', recipient_id : $(this).data('recipientid') },
				dataType: "json"
			});

			request.done(function( msg ) {

			});

			request.fail(function( jqXHR, textStatus ) {
				alert("There was a problem removing this recipient. Please try again.");
				location.reload();
			});
		});

		$('.recipient-search-results').on('click', '.recipientAdd', function(event){

			event.preventDefault();
			var newRecipientId = $(this).data('recipientid');

			$(this).remove();

			var recipient = appData.recipients[newRecipientId];

			var recipientInfo = recipientTemplate.replace('{id}', recipient.id);
			var recipientInfo = recipientInfo.replace('{first_name}', recipient.first_name);
			var recipientInfo = recipientInfo.replace('{last_name}', recipient.last_name);

			$('.current-recipients').append(recipientInfo);


			var request = $.ajax({
				url: recipientsResourceUri,
				type: "POST",
				data: { new_recipient : $(this).data('recipientid') },
				dataType: "json"
			});

			request.done(function( msg ) {
			});

			request.fail(function( jqXHR, textStatus ) {
				alert("There was a problem - are you sure you aren't trying to add a recipient you've added previously?");
				location.reload();
			});
		});

		$('#recipient_search').on('submit', function(event){
			event.preventDefault();

			$('.recipient-search-results li').remove();
			var request = $.ajax({
				url: $(this).prop('action'),
				type: "GET",
				data: { username : $('#username').val() ? $('#username').val() : 'thisissuchahugehackbutohwellyolo' },
				dataType: "json"
			});

			request.done(function( msg ) {

				if(msg.length == 0){
					$('.recipient-search-results').append("<li><strong><em>No Results Found</em></strong></li>");
				}

				var template = "<li><a href='#' class='recipientAdd' data-recipientid='{recipient-id}'><i class='fi-heart'></i> {first_name} {last_name} (<em>{username}</em>)</a></li>";
				$(msg).each(function(index, item){

					appData.recipients[item.id] = item;

					var result = template.replace("{recipient-id}", item.id);
					result = result.replace("{first_name}", item.first_name);
					result = result.replace("{last_name}", item.last_name);
					result = result.replace("{username}", item.username);

					$('.recipient-search-results').append(result);
				});

			});

			request.fail(function( jqXHR, textStatus ) {
				alert( "Request failed: " + textStatus );
			});
		});
	});
</script>
@stop

