@section('title')
Morsel Test
@stop

@section('content')
<div class="row">
    <div class="large-12 columns">
        <h1>Morsel Test</h1>
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
        <form action="/account/login" method="post" name="login">
            <fieldset>
                <legend>Login</legend>
                <div class="row">
                    <div class="large-12 small-12 columns">
                        <label>Username</label>
                        <input name="user[username]" type="text" placeholder="Username">
                    </div>
                    <div class="large-12 small-12 columns">
                        <label>Password</label>
                        <input name="user[password]"  type="password" placeholder="Password">
                    </div>
                </div>
                <div class="row">
                    <div class="large-4 small-12 columns">
                        <input class="button small expand" type="submit" value="Login" />
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
    <div class="large-6 small-12 columns">
        <form action="/account/register" method="post" name="login">
            <fieldset>
                <legend>Register</legend>
                <div class="row">
                    <div class="large-12 small-12 columns">
                        <label for="username">Username</label>
                        <input name="username" id="username" type="text" placeholder="Username" value="{{Input::old('username')}}">
                    </div>
                    <div class="large-12 small-12 columns">
                        <label for="email">Email</label>
                        <input name="email" id="email" type="text" placeholder="Email" value="{{Input::old('email')}}">
                    </div>
                </div>
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
                <div class="row">
                    <div class="large-12 small-12 columns">
                        <label for="first_name">First Name</label>
                        <input name="first_name" id="last_name" type="text" placeholder="First Name" value="{{Input::old('first_name')}}">
                    </div>
                    <div class="large-12 small-12 columns">
                        <label for="last_name">Last Name</label>
                        <input name="last_name" id="last_name" type="text" placeholder="Last Name" value="{{Input::old('first_name')}}">
                    </div>
                </div>
                <div class="row">
                    <div class="large-4 small-12 columns">
                        <input class="button small expand" type="submit" value="Register" />
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>
@stop
