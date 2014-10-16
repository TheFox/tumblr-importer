# Tumblr Importer
Import posts from a text file. One line per post.

## Install
1. [Register application](http://www.tumblr.com/oauth/apps) on Tumblr.
2. Click on _Explore API_ and grant your application to access your Tumblr account to get the _Token_ and the _Token Secret_.
3. Create `parameters.yml` file with your keys and tokens vom step 2.
	
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

4. Install [Composer](http://getcomposer.org/) Packages.

	Run the following command in your shell:
	
		composer update

5. Create a `posts.txt` file.
6. Run `php import.php` in your shell.

## posts.txt
Create a `posts.txt` file in the same directory as `import.php`. There are (up to now) only _queued_ _quote_ posts possible.

#### Format

	Text
	Text # Tag1
	Text # Tag1,Tag2
	Text - Source
	Text - Source # Tag1,Tag2
	This is my Hello World example. # HelloWorld,Hello World
	This is my Hello World #example. # HelloWorld

Each line is one post.

## --no-clear
You can pass `--no-clear` through the arguments of `import.php` to leave `posts.txt` with the original content:

	php import.php --no-clear

Otherwise `posts.txt` will be cleared after `import.php` is executed.

## Tumblr API v2 documentation
<http://www.tumblr.com/docs/en/api/v2>

## License
Copyright (C) 2013 Christian Mayer <http://fox21.at>

This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details. You should have received a copy of the GNU General Public License along with this program. If not, see <http://www.gnu.org/licenses/>.
