@section('title')
Morsel Test
@stop

@section('content')
<div class="row">
    <div class="large-12 columns">
        <h1>Welcome to <span class="morsel">Morsel</span></h1>
		<hr>
    </div>
</div>

<div class="row">
    <div class="large-12 small-12 columns">
        <h3 class="subheader">
            What is <span class="morsel">Morsel</span>?
        </h3>
    </div>
</div>
<div class="row">
	<div class="large-4 small-12 columns">
		<img src="/images/telegraphsmall.png" alt="Morsel" />
	</div>
	<div class="large-8 small-12 columns">
		<p>
			<span class="morsel"><a href="http://www.github.com/develpr/morsel">Morsel</a></span> is a simple <a href="http://en.wikipedia.org/wiki/Representational_state_transfer">RESTful</a> API (aka HTTP API) and web interface for communicating via <a href="http://en.wikipedia.org/wiki/Morse_code">Morse Code</a>. The API was created with simple devices in mind, such as an Arduino powered networked connected Morse Code key/sounder.
		</p>
		<p>
			In fact, <span class="morsel">Morsel</span> comes with a <a href="http://www.github.com/develpr/morseling">sample sketch for Arduino</a> which will hopefully help to get you started so you can get connected with <span class="morsel">Morsel</span> as quickly as possible.
		</p>
		<p>
			If you prefer or perhaps aren't near your <a target="_blank" href="http://www.physicalapi.com">physical</a> device, once <a href="/account">logging in or creating an account</a> you can create a message via <a href="messages/create">text</a> or even by <a href="messages/create-hard-mode">tapping</a>.
		</p>
	</div>
</div>
<div class="row">
	<div class="large-12 small-12 columns">
		<hr />
	</div>
	<div class="large-12 small-12 columns">
		<h3 class="subheader">The API</h3>
	</div>
</div>
<div class="row">
	<div class="large-12 small-12 columns">
		<p>The <span class="morsel">Morsel</span> API is very simple, and allows for a number of different interactions. <a href="/docs">Check out the docs</a> for all of the details, but here is a quick example to give you an idea.</p>
	</div>
</div>
<div class="row">
	<div class="large-6 small-12 columns">
		<h6>This<sup><em>*</em></sup>:</h6>

		<pre class="php">
// create curl resource
$ch = curl_init();

// we will get the most recent transmission we have not yet receieved/read
curl_setopt($ch, CURLOPT_URL, "http://morsel.develpr.com/api/v1/transmissions?received=0");

//return the transfer as a string
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// $output contains the output string
$output = curl_exec($ch);
var_dump($output);

// close curl resource to free up system resources
curl_close($ch);
		</pre>
		<br />
		<p>
			<em><sup>*</sup> For authentication an <a href="/docs/#authentication">Auth</a> header is required, which is a user id as well as a simple HMAC "signature."</em> We've tried not to go overboard (for instance use a less complex MD5 hash) with security to make the API accessible even to simple devices, while still offering some security.
		</p>
	</div>
	<div class="large-6 small-12 columns">
		<h6>Will yeild:</h6>

<pre class="js">
[
   {
	  "id":"1",
	  "message_id":"1",
	  "receiver_id":"2",
	  "sender_id":"1",
	  "received":"0",
	  "created_at":"2013-06-15 08:07:36",
	  "updated_at":"2013-06-15 08:07:36",
	  "deleted_at":null,
	  "message":{
		 "id":"1",
		 "user_id":"1",
		 "method":"intervals",
		 "raw":"a0b291a1b300a0b93a1b341a0b223",
		 "morse":"-.-",
		 "array":[
			{
			   "key":false,
			   "time":"291"
			},
			{
			   "key":true,
			   "time":"300"
			},
			{
			   "key":false,
			   "time":"93"
			},
			{
			   "key":true,
			   "time":"341"
			},
			{
			   "key":false,
			   "time":"223"
			}
		 ],
		 "text":"K",
		 "created_at":"2013-06-15 08:07:36",
		 "updated_at":"2013-06-15 08:07:36",
		 "deleted_at":null
	  }
   }
]
		</pre>
	</div>
</div>

@stop

@section('scripts')
<script type="text/javascript" src="{{URL::to('javascripts/vendor/jquery.snippet.min.js')}}"></script>
<script>
	$(function(){
	$("pre.js").snippet("javascript",{style:"acid",transparent:false,showNum:false});
	$("pre.php").snippet("php",{style:"acid" +
		"",transparent:false,showNum:true});
	});

</script>
@stop