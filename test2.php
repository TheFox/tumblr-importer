<?php

date_default_timezone_set('Europe/Vienna');

require 'vendor/autoload.php';

$client = new \Guzzle\Http\Client();

$postVars = array('foo' => 'bar2');
$request = $client->post('http://fox21.at/test.php', null, $postVars);

#$request->addPostFields($postVars);
#$request->setBody(http_build_query($postVars));


print "request header: '".$request->getRawHeaders()."'\n";
print "request body: '".$request->getBody()."'\n";

try{
	$response = $request->send();
	print "response body: '".$response->getBody()."'\n";
}
catch(Exception $e){
	print "ERROR: ".$e->getMessage()."\n";
}
