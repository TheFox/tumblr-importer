<?php

date_default_timezone_set('Europe/Vienna');

require 'vendor/autoload.php';
use \Symfony\Component\Yaml\Yaml;



$client = new \Guzzle\Http\Client(null, array('redirect.disable' => true));

$paramtersFilePath = 'parameters.yml';
$paramters = Yaml::parse($paramtersFilePath);



$url = 'http://api.tumblr.com/v2/blog/tianpictures.tumblr.com/post';
$url = 'http://api.tumblr.com/v2/blog/thefox21.tumblr.com/post';
#$url = 'http://fox21.at/test.php';

$options = array(
	'base-hostname' => 'thefox21.tumblr.com',
	'api_key' => $paramters['tumblr']['consumer_key'],
	'type' => 'text',
	'title' => 'Tumblr API',
	'body' => 'Hello World from Tumblr API.',
	'tags' => 'Tumblr,API,HelloWorld,Hello World,PHP',
);

$request = $client->post($url, null, $options);

#$request->addPostFields(array('xkey' => 'xvalue'));

#$request->addHeader('Authorization', 'OAuth oauth_version="1.0",oauth_nonce="0c790f0caa1cb7c6d3db1b50f2cdeaa9",oauth_timestamp="1376386639",oauth_consumer_key="yltADKRXgFb69SC6qRjFFCGs5qUDxfyXLgULi1j3NlCBjPY3SI",oauth_token="mCaKaV1XKU7tNi9yM2D6h9LyWLs474jApmMz1hFMqmRdTYFDck",oauth_signature_method="HMAC-SHA1",oauth_signature="KDbGV9Q%2FlNnYHw7OTjL8OIoUCxc%3D"');


$signatureMethod = new \Eher\OAuth\HmacSha1();


$consumer = new \Eher\OAuth\Consumer($paramters['tumblr']['consumer_key'], $paramters['tumblr']['consumer_secret']);
$token = new \Eher\OAuth\Token($paramters['tumblr']['token'], $paramters['tumblr']['token_secret']);

$oauth = \Eher\OAuth\Request::from_consumer_and_token($consumer, $token, 'POST', $url, $options);
$oauth->sign_request($signatureMethod, $consumer, $token);
$authHeader = $oauth->to_header();
$pieces = explode(' ', $authHeader, 2);
$authString = $pieces[1];

$request->addHeader('Authorization', $authString);


#$request->setBody('type=text&title=title222&body=body333');
#$request->setBody(http_build_query($options));


#print "auth '$authString'\n";

#var_export($request); print "\n\n\n";


#print "request header: '".$request->getRawHeaders()."'\n";
#print "request body: '".$request->getBody()."'\n";

try{
	$response = $request->send();

	#print "response body: '".$response->getBody()."'\n";

}
catch(Exception $e){
	print "ERROR: ".$e->getMessage()."\n";
}
