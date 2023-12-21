<h1>About</h1>
<p>Laravel Rest API for youtube Data API 3 and youtube analytics API</p>
<h1>Routes</h1>
<p>To find the routes you can type : "php artisan route:list"</p>
<h1>Buiding and developement</h1>
Some people will have problems with Curl, if it's your case then : 
<ol>
    <li>you should first install this <a href=" https://curl.se/ca/cacert.pem">SLL certification</a></li>
    <li>Place the cacert.pem file inside your php folder (tested on php 8.1)</li>
    <li>Open php.ini and find this line: ;curl.cainfo and change it to curl.cainfo = "Your php path\cacert.pem"</li>
    <li>Restart laravel in the command line.</li>
</ol>

