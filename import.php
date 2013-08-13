<?php

if(PHP_SAPI != 'cli') die('ERROR: You must run this script under shell.');

chdir(dirname(__FILE__));

date_default_timezone_set('Europe/Vienna');
declare(ticks = 1);
require 'vendor/autoload.php';

use \Symfony\Component\Yaml\Yaml;

$exit = 0;
function signalHandler($signo){ global $exit; $exit++; if($exit >= 2) exit(); }
pcntl_signal(SIGTERM, 'signalHandler');
pcntl_signal(SIGINT, 'signalHandler');


$paramtersFilePath = 'parameters.yml';
if(!file_exists($paramtersFilePath)){
	die('ERROR: File "'.$paramtersFilePath.'" not found.'."\n");
}

$paramters = Yaml::parse($paramtersFilePath);

if(
	!isset($paramters)
	|| !isset($paramters['tumblr'])
	|| !isset($paramters['tumblr']['consumer_key'])
	|| !isset($paramters['tumblr']['consumer_secret'])
	|| !isset($paramters['tumblr']['token'])
	|| !isset($paramters['tumblr']['token_secret'])
){
	print "ERROR: parameters invalid.\n";
	var_export($paramters); print "\n";
	exit(1);
}

if($paramters['tumblr']['consumer_key'] == 'w' && $paramters['tumblr']['consumer_secret'] == 'x' && $paramters['tumblr']['token'] == 'y' && $paramters['tumblr']['token_secret'] == 'z'){
	
}

$client = new Tumblr\API\Client($paramters['tumblr']['consumer_key'], $paramters['tumblr']['consumer_secret'], $paramters['tumblr']['token'], $paramters['tumblr']['token_secret']);

if(!isset($paramters['tumblr']['blog'])){
	print "You havn't set up a blog name.\nAvailable names are:\n";
	foreach($client->getUserInfo()->user->blogs as $blog){
		print "\t".$blog->name."\n";
	}
	exit(1);
}

#var_export($client);exit();




$options = array('type' => 'quote', 'text' => 'Text '.date('Y/m/d H:i:s'), 'source' => 'Source', 'tags' => 'Test');

$options = array('type' => 'text', 'title' => 'Title '.date('Y/m/d H:i:s'), 'body' => 'Body', 'tags' => 'Test');

$options = array('type' => 'link', 'title' => 'Title '.date('Y/m/d H:i:s'), 'url' => 'http://fox21.at', 'tags' => 'Test');



try{
	$res = $client->createPost($paramters['tumblr']['blog'].'.tumblr.com', $options);
	#$res = $client->createPost($paramters['tumblr']['blog'], $options);
	#var_export($res);
}
catch(Exception $e){
	#var_export($e);
	print "ERROR: ".$e->getMessage()."\n";
	exit(1);
}

