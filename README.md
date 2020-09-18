#### 简介
- docker-compose 一键搭建LNMP平台，并集成了一个《发货100》的php项目
- nginx版本号：1.18.0
- mysql版本号：5.7
- php版本号：7.2-fpm

<br>

#### 项目运行的条件
- 安装docker
- 安装docker-compose
  - curl -L "https://github.com/docker/compose/releases/download/1.27.3/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
  - chmod +x /usr/local/bin/docker-compose
 - centos7，需要拥有root权限
 - 运行项目：bash start.sh
 - 项目会在后台直接运行
 
 <br>
 
#### docker-compse的内容
- 项目会自动生成两个目录：
  - /root/lnmp/var/nginx/www/html
  - /root/lnmp/etc/nginx/conf.d
- nginx
  - 端口占用了80
  - volumes有两个：
    - /root/lnmp/var/nginx/www/html:/var/www/html
    - /root/lnmp/etc/nginx/conf.d:/etc/nginx/conf.d
- php
  - 端口占用了9000
  - volumes有1个：
    - /root/lnmp/var/nginx/www/html:/var/www/html
- mysql
  - 端口占用了3306
  - root的密码为1234
  - mysql的host地址为:mysql

<br>

#### 文件结构:
- default.conf：存放nginx的配置信息  
- docker-compose.yml：构建docker-compose的yml文件
- php：构建php的dockerfile文件夹
- start.sh：自动运行
- t2：《发货100》的源码

<br>

#### 发货100的运行
- url:宿主机的ip/t2/install
- 数据库的host为mysql
- 其他应该很简单，就不填写了
