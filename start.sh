#!/bin/bash
# 创建/root/lnmp/etc/nginx/conf.d/ 文件夹
directory_conf="/root/lnmp/etc/nginx/conf.d/"
if [[ -d $directory_conf  ]];then
	echo "$directory_conf exist,nothing do"
else
	echo "$directory_conf not exist,create it"
	mkdir -p $directory_conf
fi

# 创建/root/lnmp/var/nginx/www/html/ 文件夹
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

# 给lnmp加入权限
chmod -R 777 /root/lnmp

# 构建docker-compose
docker-compose build
# 后台运行docker-compose
docker-compose up -d
