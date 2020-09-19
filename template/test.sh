#!/bin/bash
mysql_port=$(cat config | grep mysql_port | awk -F "=" '{print $2}')
php_port=$(cat config | grep php_port | awk -F "=" '{print $2}')
nginx_port=$(cat config | grep nginx_port | awk -F "=" '{print $2}')
directory_conf=$(cat config | grep directory_conf | awk -F "=" '{print $2}')
directory_html=$(cat config | grep directory_html | awk -F "=" '{print $2}')

sed -i "s#[0-9]*:3306#$mysql_port:3306#g" docker-compose.yml
sed -i "s#[0-9]*:9000#$php_port:9000#g" docker-compose.yml
sed -i "s#[0-9]*:80#$nginx_port:80#g" docker-compose.yml
sed -i "s#\S*:/var/www/html#$directory_html:/var/www/html#g" docker-compose.yml
sed -i "s#\S*:/etc/nginx/conf.d#$directory_conf:/etc/nginx/conf.d#g" docker-compose.yml


#echo $mysql_port
#echo $php_port
#echo $nginx_port
#echo $directory_conf
#echo $directory_html
