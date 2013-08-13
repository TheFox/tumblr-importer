<?php

require 'vendor/autoload.php';

$client = new \Guzzle\Http\Client(null, array('redirect.disable' => true));


var_export($client);


$url = 'http://api.tumblr.com/v2/blog/tianpictures.tumblr.com/post';
$url = 'http://fox21.at/test.php';

$options = array (
	'type' => 'text',
	'text' => 'Hi from API.',
);

$request = $client->post($url, null, $options);

$request->addPostFile($key, $value);

$request->addHeader('X-Foo', 'bar');




var_export($request); print "\n\n\n";

var_export($request->getRawHeaders()); print "\n\n\n";
var_export($request->getBody()); print "\n\n\n";


$response = $request->send();



var_export($response->getBody()); print "\n\n\n";


