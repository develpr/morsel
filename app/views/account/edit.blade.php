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
<div class="row">
    <div class="large-12 small-12 columns">
        <form action="/my-account" method="post" name="login">
            <fieldset>
                <legend>{{Auth::user()->username}}'s Account</legend>
                <input type="hidden" name="_method" value="PUT" />
                <div class="row">
                    <div class="large-12 small-12 columns">
                        <label for="email">Email</label>
                        <input name="email" id="email" type="text" placeholder="Email" value="{{Auth::user()->email}}">
                    </div>
                </div>
                <div class="row">
                    <div class="large-12 small-12 columns">
                        <label for="first_name">First Name</label>
                        <input name="first_name" id="last_name" type="text" placeholder="First Name" value="{{Auth::user()->first_name}}">
                    </div>
                    <div class="large-12 small-12 columns">
                        <label for="last_name">Last Name</label>
                        <input name="last_name" id="last_name" type="text" placeholder="Last Name" value="{{Auth::user()->last_name}}">
                    </div>
                </div>

            </fieldset>
            <fieldset>
                <legend>Change Password</legend>
                <div class="row">
                    <div class="large-12 small-12 columns">
                        <label for="pass">Password</label>
                        <input type="password" id="pass" name="pass" placeholder="Password">
                    </div>
                    <div class="large-12 small-12 columns">
                        <label for="pass">Password Confirmation</label>
                        <input type="password" id="pass_confirmation" name="pass_confirmation" placeholder="Password Confirmation">
                    </div>
                </div>
            </fieldset>
            <div class="row">
                <div class="large-4 small-12 columns">
                    <input class="button small expand" type="submit" value="Save" />
                </div>
            </div>
        </form>
    </div>
</div>
@stop

