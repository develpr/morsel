@section('title')
Message Transmission History
@stop

@section('content')
<div class="row">
	<div class="large-12 columns">
		<h1 class="subheader">Message Transmission History</h1>
	</div>
</div>

<div class="row">
	<div class="large-12 columns">
		@if($errors->any())
		@foreach($errors->getMessages() as $transmission)
		<div data-alert class="alert-box alert">
			{{$transmission[0]}}
			<a href="#" class="close">&times;</a>
		</div>

		@endforeach
		@elseif(Session::get('transmission'))
		<div data-alert class="alert-box success">
			{{Session::get('transmission')}}
			<a href="#" class="close">&times;</a>
		</div>
		@endif
	</div>
</div>
<div class="row">
    <div class="large-6 small-12 columns">
        <h5>Received Messages</h5>
        @foreach($transmissions as $transmission)
        @if($transmission->receiver_id === Auth::user()->id)
        <div class="large-12 small-12 columns panel received">
            <div class="row">
                <div class="large-1 small-1 columns">
                    <h3><a href="/messages/{{$transmission->message->id}}">{{$transmission->message->id}}</a></h3>
                </div>
                <div class="large-9 small-9 columns">
                    <h6>{{$transmission->message->text}} <small>{{str_replace('a',' ',$transmission->message->morse)}}</small></h6>
                    <div>{{date("F j, Y g:i a", strtotime($transmission->message->created_at))}}</div>
                </div>
                <div class="large-2 small-2 columns">
                    @if($transmission->received == true)
                    <i class="general fi-check"></i>
                    @endif
                </div>
            </div>
        </div>
        @else
        <div class="large-12 small-12 columns panel received" style="visibility:hidden;">
            <div class="row">
                <div class="large-1 small-1 columns">
                    <h3><a href="/messages/{{$transmission->message->id}}">{{$transmission->message->id}}</a></h3>
                </div>
                <div class="large-9 small-9 columns">
                    <h6>{{$transmission->message->text}} <small>{{str_replace('a',' ',$transmission->message->morse)}}</small></h6>
                    <div>{{date("F j, Y g:i a", strtotime($transmission->message->created_at))}}</div>
                </div>
                <div class="large-2 small-2 columns">
                    @if($transmission->received == true)
                    <i class="general foundicon-smiley"></i>
                    @endif
                </div>
            </div>
        </div>
        @endif
        @endforeach
    </div>
    <div class="large-6 small-12 columns">
        <h5>Sent Messages</h5>
        @foreach($transmissions as $transmission)
            @if($transmission->sender_id == Auth::user()->id)
            <div class="large-12 small-12 columns panel sent">
                <div class="row">
                    <div class="large-1 small-1 columns">
                        <h3><a href="/messages/{{$transmission->message->id}}">{{$transmission->message->id}}</a></h3>
                    </div>
                    <div class="large-9 small-9 columns">
                        <h6>{{$transmission->message->text}} <small>{{str_replace('a',' ',$transmission->message->morse)}}</small></h6>
                        <div>{{date("F j, Y g:i a", strtotime($transmission->message->created_at))}}</div>
                    </div>
                    <div class="large-2 small-2 columns">
                        @if($transmission->received == true)
                        <i class="general foundicon-smiley"></i>
                        @endif
                    </div>
                </div>
            </div>
            @else
            <div class="large-12 small-12 columns panel sent" style="visibility:hidden;">
                <div class="row">
                    <div class="large-1 small-1 columns">
                        <h3><a href="/messages/{{$transmission->message->id}}">{{$transmission->message->id}}</a></h3>
                    </div>
                    <div class="large-9 small-9 columns">
                        <h6>{{$transmission->message->text}} <small>{{str_replace('a',' ',$transmission->message->morse)}}</small></h6>
                        <div>{{date("F j, Y g:i a", strtotime($transmission->message->created_at))}}</div>
                    </div>
                    <div class="large-2 small-2 columns">
                        @if($transmission->received == true)
                        <i class="general foundicon-smiley"></i>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        @endforeach
    </div>
</div>

@stop

@section('scripts')
<script>
    $(function(){
       $('.panel.sent, .panel.received').css('cursor', 'pointer');
       $('.panel.sent, .panel.received').on('click', function(event){
        window.location = $(this).find('a').attr('href');
       });
    });
</script>
@stop
