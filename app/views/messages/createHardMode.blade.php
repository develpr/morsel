@section('title')
Create a Message
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
<div class="row">
    <div class="large-12 small-12 columns">
        <h4>
            everybody tap your message
        </h4>
        <p>
            <small>(to the turn of the <strong>Cha Cha Slide</strong>)</small>
        </p>
        <blockquote>tap tap tap tap tap tap tap tap tap tap tap tap tap tap tap<cite>DJ Casper</cite></blockquote>
        <p>
            When you are done, click submit, and your message will be transmitted and decoded.
        </p>
    </div>
</div>
<div class="row">
    <div class="large-12 small-12 columns">
        <form action="/messages/create" method="post" name="create-message">
			<div class="row">
				<div class="large-12 small-12 columns">
					<input class="button small expand" style="margin-bottom:0;" type="submit" value="Send" />
				</div>
			</div>
			<div id="key" style="width:100%; height:20em; background-color:#444;"></div>
            <input type="hidden" name="raw" id="raw" />
            <div class="row">
                <div class="large-12 small-12 columns">
                    <input class="button small expand" type="submit" value="Send" />
                </div>
            </div>
        </form>
    </div>
</div>
@stop

@section('scripts')
<script>
    var started = false;
    var starttime = 0;
    var endtime = 0;
    var diff = 0;
    $(function () {
        $('#key').on('touchstart mousedown', function (event) {
            endtime = new Date();
            diff = endtime-starttime;
            if(diff < 250141482)
                $('#raw').val($('#raw').val() + "a1b"+ diff + "");

            starttime = new Date();
            event.preventDefault();
            $(this).css('background', '#eee');
        });

        $('#key').on('touchend mouseup', function (event) {
            endtime = new Date();
            diff = endtime-starttime;
            $('#raw').val($('#raw').val() + "a0b" + diff + "");
            starttime = new Date();
            event.preventDefault();
            $(this).css('background', '#444');
        });
    });
</script>
@stop

