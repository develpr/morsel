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
        <form action="/messages/create" method="post" name="create-message">
            <fieldset>
                <legend>Create a new message for (insert name of mate if they exist)</legend>
                <input type="hidden" name="_method" value="POST" />
                <div class="row">
                    <div class="large-12 small-12 columns">
                        <label for="text">Your message</label>
                        <input name="text" id="text" type="text" placeholder="Your message" value="">
                    </div>
                </div>
            </fieldset>
            <div class="row">
                <div class="large-4 small-12 columns">
                    <input class="button small expand" type="submit" value="Send" />
                </div>
            </div>
        </form>
    </div>
</div>
@stop

