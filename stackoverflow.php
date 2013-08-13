<?php
	
	require 'vendor/autoload.php';
	
	$consumer_key = 'KEY';
	$consumer_secret = 'SECRET';
	$token = 'TOKEN';
	$token_secret = 'SECRET';
	$blog = 'BLOG';
	
	$client = new Tumblr\API\Client($consumer_key, $consumer_secret, $token, $token_secret);
	
	#$options = array('type' => 'text', 'title' => 'Title', 'body' => 'Body', 'tags' => 'Test');
	$options = array('type' => 'quote', 'text' => 'Text', 'source' => 'Source', 'tags' => 'Test');
	
	try{
		$res = $client->createPost($blog, $options);
	}
	catch(Exception $e){
		print "ERROR: ".$e->getMessage()."\n";
		exit(1);
	}