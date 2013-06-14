@section('title')
Morsel Test
@stop

@section('content')
<div class="row">
    <div class="large-12 columns">
        <h1>Morsel API</h1>
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
    	<p>
			You can login, or you can not login. Or, for now, you can try something like
    	</p>
		<p>
			<a href="/messages/1/info" >View Message 1</a>
			<br />
			<a href="/messages/2/info" >View Message 2</a>
			<br />
			<a href="/messages/3/info" >View Message 3</a>
			<br />
			<a href="/messages/4/info" >View Message 4</a>
			<br />
			<a href="/messages/5/info" >View Message 5</a>
			<br />
			<a href="/messages/6/info" >View Message 6</a>
		</p>

    </div>
</div>
@stop
