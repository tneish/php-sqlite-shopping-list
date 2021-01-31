# php-sqlite-shopping-list
Quick and clean shopping lists made for mobile screens

one-shot/
---------
A list for items from multiple shops you typically buy once or very seldom. Items are entered each time they are on the list.
To change the list of shops you will need to edit the sqlite database with e.g. [DB Browser for SQLite](http://sqlitebrowser.org).

recurring/
----------
A list for items you buy often or now and again, e.g. food and groceries. Items are entered once, and saved for next time. Items you bought recently are highlighted (e.g. bread & milk). The order of the items can be changed by dragging them up or down so you can match the layout of your favourite supermarket.
Access <code>delete.html</code> once in a while to clean up unused items.

Quickstart
----------
Put all files in a directory under the htdocs root of a webserver with PHP with the pdo_sqlite extension (uncomment <code>extension=pdo_sqlite</code> in your php.ini file and restart the webserver/php-fpm daemon). 

Make sure the PHP scripts are executable 
<code>chmod +x *.php</code>

Make sure the sqlite file is writable by the web-server or PHP FastCGI processes (e.g user www, group www) depending on your webserver and its configuration. <code>chmod 777 *.sqlite</code> will work in a pinch, but you should narrow write access to only the relevant user or group.
