<?php

$DEBUG = 0;
$TAGS_BAD_CHARS = array(' ', '.', ',');

if(PHP_SAPI != 'cli') die('ERROR: You must run this script under shell.');

chdir(dirname(__FILE__));

date_default_timezone_set('Europe/Vienna');
declare(ticks = 1);
require 'vendor/autoload.php';

use \Symfony\Component\Yaml\Yaml;

$exit = 0;
if(function_exists('pcntl_signal')){
	function signalHandler($signo){ global $exit; $exit++; if($exit >= 2) exit(); }
	pcntl_signal(SIGTERM, 'signalHandler');
	pcntl_signal(SIGINT, 'signalHandler');
}

$argPostsNoClear = false;
$argc = count($argv);
for($argn = 1; $argn < $argc; $argn++){
	$arg = $argv[$argn];
	if($arg == '--no-clear'){
		$argPostsNoClear = true;
	}
}


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


$client = new Tumblr\API\Client($paramters['tumblr']['consumer_key'], $paramters['tumblr']['consumer_secret'], $paramters['tumblr']['token'], $paramters['tumblr']['token_secret']);

if(!isset($paramters['tumblr']['blog'])){
	print "You havn't set up a blog name.\nAvailable names are:\n";
	foreach($client->getUserInfo()->user->blogs as $blog){
		print "\t".$blog->name."\n";
	}
	exit(1);
}


$options = array(
	'type' => 'quote',
	#'quote' => 'Text',
	#'source' => 'Source',
	#'tags' => 'Tag',
	'state' => 'queue',
);


$lines = 0;
$successfull = 0;
$errors = 0;


$fh = fopen('posts.txt', 'r');
while(!feof($fh)){
	
	$lines++;
	
	$row = fgets($fh);
	$row = str_replace("\n", '', $row);
	$row = str_replace("\r", '', $row);
	
	#print "row '".$row."' '$text' \n";
	
	
	$text = $row;
	$source = '';
	$tagsstr = '';
	
	$pos = strrpos($row, ' - ');
	if($pos !== false){
		$text = substr($row, 0, $pos);
		$source = substr($row, $pos + 3);
		
		#print "\t source pos: $pos\n";
		#print "\t substr '$source'\n";
		
		$pos = strrpos($source, '#');
		if($pos !== false){
			
			$tagsstr = substr($source, $pos + 1);
			$source = substr($source, 0, $pos);
			
			
			#print "\t tag pos: $pos '$source' '$tagsstr'\n";
		}
		
	}
	else{
		$pos = strrpos($row, '#');
		if($pos !== false){
			$text = substr($row, 0, $pos);
			$tagsstr = substr($row, $pos + 1);
		}
	}
	
	$text = trim($text);
	$source = trim($source);
	$tagsstr = trim($tagsstr);
	
	if($text){
		
		$tagsstrItems = preg_split('/,/', strtolower($tagsstr));
		
		if(strpos($text, '#') !== false){
			$tags = preg_split('/#/', $text);
			array_shift($tags);
			
			$tagsUse = array();
			foreach($tags as $tag){
				foreach($TAGS_BAD_CHARS as $badChar){
					$pos = strpos($tag, $badChar);
					if($pos !== false){
						$tag = substr($tag, 0, $pos);
					}
				}
				
				if(!in_array(strtolower($tag), $tagsstrItems)){
					$tag = str_replace('_', ' ', $tag);
					$tagsUse[] = $tag;
				}
			}
			
			$text = str_replace('#', '', $text);
			$tagsstr .= ','.join(',', $tagsUse);
		}
		
		$options['quote'] = $text;
		if($source){
			$options['source'] = $source;
		}
		if($tagsstr){
			$options['tags'] = $tagsstr;
		}
		
		
		print "post '$text' | '$source' | '$tagsstr' ... ";
		
		try{
			$res = false;
			if(!$DEBUG){
				$res = $client->createPost($paramters['tumblr']['blog'], $options);
			}
			print 'done: ';
			if($res){
				$successfull++;
				print $res->id;
			}
			else{
				$errors++;
				print 'failed';
			}
		}
		catch(Exception $e){
			print 'ERROR: '.$e->getMessage();
			$errors++;
		}
		print "\n";
	}
	else{
		$errors++;
	}
	
	#sleep(1);
	
	if($exit) break;
}
fclose($fh);

if(!$argPostsNoClear){
	$fh = fopen('posts.txt', 'w');
	fclose($fh);
}

print "\nlines: ".$lines."\nsuccessfull: ".$successfull."\nerrors: ".$errors."\n";

exit($errors);


