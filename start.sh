#!/bin/bash
# 定义各种变量
mysql_port=$(cat config | grep mysql_port | awk -F "=" '{print $2}')
php_port=$(cat config | grep php_port | awk -F "=" '{print $2}')
nginx_port=$(cat config | grep nginx_port | awk -F "=" '{print $2}')
directory_conf=$(cat config | grep directory_conf | awk -F "=" '{print $2}')
directory_html=$(cat config | grep directory_html | awk -F "=" '{print $2}')

# 创建directory_conf 文件夹
if [[ -d $directory_conf  ]];then
	echo "$directory_conf exist,nothing do"
else
	echo "$directory_conf not exist,create it"
	mkdir -p $directory_conf
fi

# 创建directory_html文件夹
directory_html="/root/lnmp/var/nginx/www/html"
if [[ -d $directory_html ]];then
	echo "$directory_html exist,nothing do"
else
	echo "$directory_html not exist,create it"
	mkdir -p $directory_html
fi

# 复制default.conf 文件到conf文件夹上
# 复制t2文件夹到html文件夹上
cp -f default.conf $directory_conf
cp -rf t2 $directory_html

# 给两个文件夹加入权限
chmod -R 777 $directory_html
chmod -R 777 $directory_conf

# 根据配置文件，修改docker-compose的端口和volumes
sed -i "s#[0-9]*:3306#$mysql_port:3306#g" docker-compose.yml
sed -i "s#[0-9]*:9000#$php_port:9000#g" docker-compose.yml
sed -i "s#[0-9]*:80#$nginx_port:80#g" docker-compose.yml
sed -i "s#\S*:/var/www/html#$directory_html:/var/www/html#g" docker-compose.yml
sed -i "s#\S*:/etc/nginx/conf.d#$directory_conf:/etc/nginx/conf.d#g" docker-compose.yml



# 构建docker-compose
docker-compose build
# 后台运行docker-compose
docker-compose up -d
