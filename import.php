<?php

if(PHP_SAPI != 'cli') die('ERROR: You must run this script under shell.');

chdir(dirname(__FILE__));

declare(ticks = 1);
require 'vendor/autoload.php';

use Symfony\Component\Yaml\Yaml;

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
	|| !isset($paramters['tumblr']['secret'])
){
	print "ERROR: parameters invalid.\n";
	var_export($paramters); print "\n";
	exit(1);
}

if($paramters['tumblr']['consumer_key'] == 'w' && $paramters['tumblr']['consumer_secret'] == 'x' && $paramters['tumblr']['token'] == 'y' && $paramters['tumblr']['secret'] == 'z'){
	
}
