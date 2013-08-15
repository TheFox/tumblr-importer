# Install
1. [Register application](http://www.tumblr.com/oauth/apps) on Tumblr.
1. Click on _Explore API_ and grant your application to access your Tumblr account to get the _Token_ and the _Token Secret_.
1. Create _parameters.yml_ file with your keys and tokens vom step 2.
	
	Template (parameters-tpl.yml):
	
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

1. Install [Composer](http://getcomposer.org/) Packages.

	Run the following command in your shell:
	
		composer update

# Tumblr API v2 documentation
[http://www.tumblr.com/docs/en/api/v2](http://www.tumblr.com/docs/en/api/v2)
