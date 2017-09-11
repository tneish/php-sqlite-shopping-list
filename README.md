# php-sqlite-shopping-list
Quick and clean shopping list made for mobile screens

Put all files in a directory under the htdocs root of a webserver with PHP (tested with php-7.0.16 on OpenBSD 6.1 httpd). 

Make sure the PHP scripts are executable (chmod +x *.php).

Make sure the sqlite file is writable by the web-server or PHP FastCGI processes (e.g user www, group www) depending on your webserver and its configuration. "chmod 777 *.sqlite" will work in a pinch, but you should narrow write access to only the relevant user or group.
