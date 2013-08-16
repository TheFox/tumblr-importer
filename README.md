# Install
1. [Register application](http://www.tumblr.com/oauth/apps) on Tumblr.
1. Click on _Explore API_ and grant your application to access your Tumblr account to get the _Token_ and the _Token Secret_.
1. Create `parameters.yml` file with your keys and tokens vom step 2.
	
	Template (see `parameters-tpl.yml`):
	
		tumblr:
		    consumer_key: 
		    consumer_secret: 
		    token: 
		    token_secret: 
		    blog: 
	
	Example:
	
		tumblr:
		    consumer_key: ylThIsIsOnlyAFaketADKThIsIsOnlyAFake1j3NlCBjPY3SI
		    consumer_secret: 5qThIsIsOnlyAFakeHHoMgThIsIsOnlyAFakeW
		    token: mThIsIsOnlyAFakeqmRdTYFDThIsIsOnlyAFakeck
		    token_secret: vDlMllCvThIsIsOnlyAFake2rrEThIsIsOnlyAFakeeYijk
		    blog: thefox21
	
	`blog` is the name of your blog the posts will be created.

1. Install [Composer](http://getcomposer.org/) Packages.

	Run the following command in your shell:
	
		composer update

1. Create a `posts.txt` file.
1. Run `php import.php` in your shell.

# posts.txt
Create a `posts.txt` file in the same directory as `import.php`. There are only _queued_ _quote_ posts possible.

### Format

	Text
	Text # Tag1
	Text # Tag1,Tag2
	Text - Source
	Text - Source # Tag1,Tag2
	This is my Hello World example. # HelloWorld,Hello World
	This is my Hello World #example. # HelloWorld

Each line is one post.

# --no-clear
You can pass `--no-clear` through the arguments of `import.php` to leave `posts.txt` with the original content:

	php import.php --no-clear

Otherwise `posts.txt` will be cleared after `import.php` is executed.

# Tumblr API v2 documentation
[http://www.tumblr.com/docs/en/api/v2](http://www.tumblr.com/docs/en/api/v2)
