<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
	<script src="{{URL::to('js/vendor/custom.modernizr.js')}}"></script>
    <meta charset='utf-8' />
    <meta content='IE=edge,chrome=1' http-equiv='X-UA-Compatible' />
    <meta content='width=device-width' name='viewport' />
    <title>@yield('title')</title>
    <link type="text/css" href="http://fonts.googleapis.com/css?family=Iceland" media="screen" rel="stylesheet" />
    <link rel="stylesheet" href="{{URL::to('stylesheets/app.css')}}" />
    <link rel="stylesheet" href="{{URL::to('stylesheets/foundation-icons.css')}}" />
    <link rel="stylesheet" href="{{URL::to('stylesheets/main.css')}}" />
    @yield('styles')
    <link rel="icon" type="image/png" href="/images/morsel_logo.png" />
</head>
<body>
<header>
	<nav class='top-bar' data-topbar="">
		<ul class='title-area'>
			<li class='name'>
				<h1>
					<a href='/'>
						<img class='left morsel-logo' src='/images/morsel_logo.png' />
						<span class="morsel">&nbsp;Morsel</span>
					</a>
				</h1>
			</li>
			<li class='toggle-topbar menu-icon'>
				<a href='#'>
                    <span>
                      Menu
                    </span>
				</a>
			</li>
		</ul>
		<section class='top-bar-section'>
			<ul class='right'>
				@if(Auth::check())
				<li class='divider'></li>
				<li class='has-dropdown'>
					<a href='/transmissions'>
						Messages
					</a>
					<ul class='dropdown'>
						<li>
							<a href='/transmissions'>
								Transmission History
							</a>
						</li>
						<li>
							<a href='/messages/create'>
								New Message (easy mode)
							</a>
						</li>
						<li>
							<a href='/messages/create-hard-mode'>
								New Message (hard mode)
							</a>
						</li>
					</ul>
				</li>
				<li class='divider'></li>
				<li class='has-dropdown'>
					<a href='#'>
						Account
					</a>
					<ul class='dropdown'>
						<li>
							<a href='/my-account'>
								Account Settings
							</a>
						</li>
						<li>
							<a href='/relationships'>
								Sender/Recipient Relationships
							</a>
						</li>

					</ul>
				</li>
				<li class='divider'></li>
				<li>
					<a href='/logout'>
						Logout
					</a>
				</li>
				@else
				<li>
					<a href='/account'>
						Register or Login
					</a>
				</li>
				@endif
			</ul>
		</section>
	</nav>
</header>

<div class='row spacer'>
    <div class='small-6 large-centered columns'>
    	
    </div>
</div>
<section class='main' role='main'>

@yield('content')

</section>

<footer></footer>
<script type="text/javascript" src="{{URL::to('js/vendor/jquery.js')}}"></script>
<script type="text/javascript" src="{{URL::to('js/foundation.min.js')}}"></script>
@yield('scripts')
<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	ga('create', 'UA-10817444-23', 'develpr.com');
	ga('send', 'pageview');

</script>
<script>
	$(function(){
		$('.morsel').hover(function(){
			$(this).html('-- --- .-. ... . .-..');
		}, function(){
			$(this).html('Morsel');
		})
	});

	$(document).foundation();

</script>

</body>
</html>