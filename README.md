
    apt-get update
    apt-get install -y gcc make unzip autoconf libxml2-dev bzip2 libcurl3-openssl-dev libcurl4-gnutls-dev libjpeg-dev
    apt-get install -y libpng-dev libxpm-dev libfreetype6-dev libt1-dev libmcrypt-dev libmysql++-dev libxslt1-dev
    apt-get install -y git vim
    apt-get install libpcre3 libpcre3-dev libpcrecpp0 libssl-dev zlib1g-dev
    update-alternatives --config editor
    
#查看系统允许的最大连接数

    ulimit -a | grep open
    ulimit -n 65535
    
#建立目录

    mkdir -p /opt/ptserver/php-5.5.13/etc/conf
    mkdir -p /opt/ptserver/webroot/

#安装

    mkdir /opt
    
    mkdir -p /var/log/nginx
    
    wget https://raw.githubusercontent.com/ptphp/PtConfig/master/init.d_nginx -O /etc/init.d/nginx
    chmod +x /etc/init.d/nginx
    update-rc.d nginx defaults
    service nginx start
    
    ln -s /opt/ptserver/php-5.5.13/bin/php /usr/local/bin/php
    groupadd nobody
    wget https://raw.githubusercontent.com/ptphp/PtConfig/master/init.d_php5-fpm -O /etc/init.d/php-fpm
    chmod +x /etc/init.d/php-fpm
    update-rc.d php-fpm defaults
    service php-fpm start
    
    mkdir -p /var/log/redis/
    mkdir -p /var/lib/redis
    mkdir -p /var/run/redis
    
    ln -s /opt/ptserver/redis-2.8.11/bin/redis-server /usr/local/bin/redis-server
    ln -s /opt/ptserver/redis-2.8.11/bin/redis-cli /usr/local/bin/redis-cli
    
    
    useradd redis
    groupadd redis
    wget https://raw.githubusercontent.com/ptphp/PtConfig/master/init.d_redis-server -O /etc/init.d/redis-server
    
    chmod +x /etc/init.d/redis-server
    sudo update-rc.d redis-server defaults
    
    echo 'vm.overcommit_memory = 1' > /etc/sysctl.conf
    sysctl vm.overcommit_memory=1
    
    service redis-server start


---------------------------------------------------------------

#nginx

    wget http://nginx.org/download/nginx-1.6.0.tar.gz
    tar xzvf nginx-1.6.0.tar.gz
    cd nginx-1.6.0
    mkdir -p /var/log/nginx
    
    ./configure --prefix=/opt/ptserver/nginx-1.6.0 \
        --with-http_ssl_module \
        --with-http_stub_status_module \
        --with-http_realip_module \
        --with-http_gzip_static_module
    
输出：

    nginx path prefix: "/opt/ptserver/nginx-1.6.0"
    nginx binary file: "/opt/ptserver/nginx-1.6.0/sbin/nginx"
    nginx configuration prefix: "/opt/ptserver/nginx-1.6.0/conf"
    nginx configuration file: "/opt/ptserver/nginx-1.6.0/conf/nginx.conf"
    nginx pid file: "/opt/ptserver/nginx-1.6.0/logs/nginx.pid"
    nginx error log file: "/opt/ptserver/nginx-1.6.0/logs/error.log"
    nginx http access log file: "/opt/ptserver/nginx-1.6.0/logs/access.log"
    nginx http client request body temporary files: "client_body_temp"
    nginx http proxy temporary files: "proxy_temp"
    nginx http fastcgi temporary files: "fastcgi_temp"
    nginx http uwsgi temporary files: "uwsgi_temp"
    nginx http scgi temporary files: "scgi_temp"
 
 
编译

    make
    make install
    
    mkdir -p /var/log/nginx/

    mv /opt/ptserver/nginx-1.6.0/conf/nginx.conf /opt/ptserver/nginx-1.6.0/conf/nginx.conf_bak
    wget https://raw.githubusercontent.com/ptphp/PtConfig/master/config_nginx.conf -O /opt/ptserver/nginx-1.6.0/conf/nginx.conf
    mkdir -p /opt/ptserver/etc/nginx/vhosts
    wget https://raw.githubusercontent.com/ptphp/PtConfig/master/config_nginx_vhosts.conf -O   /opt/ptserver/etc/nginx/vhosts/default.conf
    wget https://raw.githubusercontent.com/ptphp/PtConfig/master/init.d_nginx -O /etc/init.d/nginx
    sudo chmod +x /etc/init.d/nginx
    sudo update-rc.d nginx defaults
    
    update-rc.d -f nginx remove
    
#mongodb
    
    mkdir -p /opt/ptserver/mongodb-2.6.2/
    wget http://fastdl.mongodb.org/linux/mongodb-linux-x86_64-2.6.2.tgz
    tar zxvf mongodb-linux-x86_64-2.6.2.tgz
    cd mongodb-linux-x86_64-2.6.2
    cp -R -n mongodb-linux-x86_64-2.6.2/ /opt/ptserver/mongodb-2.6.2/
    mkdir -p /var/mongo/data
    
    wget https://raw.githubusercontent.com/ptphp/PtConfig/master/init.d_mongod -O /etc/init.d/mongod 
    chmod +x /etc/init.d/mongod    
    update-rc.d mongod defaults
    
    /opt/ptserver/mongodb-2.6.2/bin/mongod --dbpath /var/mongo/data

#php
    
    cd /opt/soft
    wget http://mirrors.sohu.com/php/php-5.5.13.tar.gz -O php-5.5.13.tar.gz
    tar xzvf php-5.5.13.tar.gz
    cd php-5.5.13
    ./configure --prefix=/opt/ptserver/php-5.5.13 \
       --with-config-file-path=/opt/ptserver/php-5.5.13/etc/ \
       --with-config-file-scan-dir=/opt/ptserver/php-5.5.13/etc/conf \
       --with-iconv-dir \
       --with-gettext \
       --enable-calendar \
       --enable-exif \
       --enable-wddx \
       --with-pear \
       --with-xsl \
       --with-zlib \
       --enable-xml \
       --disable-rpath \
       --enable-bcmath \
       --enable-shmop \
       --enable-sysvsem \
       --enable-inline-optimization \
       --with-curl \
       --enable-mbregex \
       --enable-fpm \
       --enable-mbstring \
       --with-gd \
       --with-jpeg-dir \
       --with-png-dir \
       --with-xpm-dir \
       --with-t1lib \
       --with-mcrypt \
       --with-mysql=mysqlnd \
       --with-mysqli=mysqlnd \
       --enable-pdo \
       --with-pdo-mysql=mysqlnd \
       --with-freetype-dir \
       --enable-gd-native-ttf \
       --with-openssl \
       --with-mhash \
       --enable-pcntl \
       --enable-sockets \
       --with-xmlrpc \
       --enable-zip \
       --enable-soap \
       --enable-opcache \
       --enable-sysvmsg \
       --enable-embed \
       --enable-maintainer-zts
       
    make clean
    make
    make install
    cp php.ini-production /opt/ptserver/php-5.5.13/etc/php.ini
    wget https://raw.githubusercontent.com/ptphp/PtConfig/master/config_php-fpm.conf -O /opt/ptserver/php-5.5.13/etc/php-fpm.conf
    
    ln -s /opt/ptserver/php-5.5.13/bin/php /usr/local/bin/php
    wget https://raw.githubusercontent.com/ptphp/PtConfig/master/init.d_php5-fpm -O /etc/init.d/php-fpm
    chmod +x /etc/init.d/php-fpm
    update-rc.d php-fpm defaults
    
    groupadd nobody
    
测试

    /opt/ptserver/php-5.5.13/sbin/php-fpm -t
    /opt/ptserver/php-5.5.13/sbin/php-fpm -c /opt/ptserver/php-5.5.13/etc/php.ini -y /opt/ptserver/php-5.5.13/etc/php-fpm.conf -t
    
    
启动php-fpm

    /opt/ptserver/php-5.5.13/sbin/php-fpm
    /opt/ptserver/php-5.5.13/sbin/php-fpm -c /opt/ptserver/php-5.5.13/etc/php.ini -y /opt/ptserver/php-5.5.13/etc/php-fpm.conf
    ps -aux | grep php
    
关闭php-fpm

    kill -INT `cat /opt/ptserver/php-5.5.13/var/run/php-fpm.pid`

重启php-fpm

    kill -USR2 `cat /opt/ptserver/php-5.5.13/var/run/php-fpm.pid`
    /opt/ptserver/php/php-5.5.13/bin/pecl install ZendOpache-beta
    
    
安装扩展

    /opt/ptserver/php-5.5.13/bin/pecl install pthreads
    echo 'extension = "pthreads.so"' > /opt/ptserver/php-5.5.13/etc/conf/pthreads.ini
    php --ini
    
    /opt/ptserver/php-5.5.13/bin/pecl install redis
    echo 'extension = "redis.so"' > /opt/ptserver/php-5.5.13/etc/conf/redis.ini
    
    /opt/ptserver/php-5.5.13/bin/pecl install memcache
    echo 'extension = "memcache.so"' > /opt/ptserver/php-5.5.13/etc/conf/memcache.ini
    
    /opt/ptserver/php-5.5.13/bin/pecl install mongo
    echo 'extension = "mongo.so"' > /opt/ptserver/php-5.5.13/etc/conf/mongo.ini
    
    /opt/ptserver/php-5.5.13/bin/pecl install riak
    echo 'extension = "riak.so"' > /opt/ptserver/php-5.5.13/etc/conf/riak.ini
    
    
    echo 'zend_extension_ts =opcache.so' > /opt/ptserver/php-5.5.13/etc/conf/opcache.ini
    
    php -S 0.0.0.0:80 -t /opt/ptserver/webroot

#redis-server

    mkdir -p /var/log/redis/
    mkdir -p /var/lib/redis
    mkdir -p /var/run/redis
    mkdir -p /opt/soft/
    mkdir -p /opt/ptserver/redis-2.8.11/bin
    cd /opt/soft/
    wget http://download.redis.io/releases/redis-2.8.11.tar.gz
    tar xzf redis-2.8.11.tar.gz
    cd redis-2.8.11
    make
    make test
    wget https://raw.githubusercontent.com/ptphp/PtConfig/master/config_redis.conf -O /opt/ptserver/redis-2.8.11/redis.conf
    cp src/redis-server /opt/ptserver/redis-2.8.11/bin
    cp src/redis-cli /opt/ptserver/redis-2.8.11/bin
    cp src/redis-benchmark /opt/ptserver/redis-2.8.11/bin
    
    ln -s /opt/ptserver/redis-2.8.11/bin/redis-server /usr/local/bin/redis-server
    ln -s /opt/ptserver/redis-2.8.11/bin/redis-cli /usr/local/bin/redis-cli
    
    
    useradd redis
    groupadd redis
    
    wget https://raw.githubusercontent.com/ptphp/PtConfig/master/init.d_redis-server -O /etc/init.d/redis-server
    
    chmod +x /etc/init.d/redis-server
    sudo update-rc.d redis-server defaults
    
    echo 'vm.overcommit_memory = 1' > /etc/sysctl.conf
    sysctl vm.overcommit_memory=1
    
    redis-server /opt/ptserver/redis-2.8.11/redis.conf
    
    redis-server /opt/ptserver/redis-2.8.11/6380.conf
    
    redis-cli shutdown

#twemproxy

    apt-get install automake
    apt-get install libtool
    apt-get install git
    mkdir /opt/ptserver/twemproxy
    git clone git://github.com/twitter/twemproxy.git
    cd twemproxy
    autoreconf -fvi
    ./configure --prefix=/opt/ptserver/twemproxy --enable-debug=log
    make -j 8
    make install

    cd /opt/ptserver/twemproxy
    sbin/nutcracker -h
    mkdir run conf
    vim conf/nutcracker.yml

nutcracker.yml
    
    alpha:
        listen: 127.0.0.1:22221
        hash: fnv1a_64
        distribution: ketama
        auto_eject_hosts: true
        redis: true
        server_retry_timeout: 2000
        server_failure_limit: 1
        servers:
            - 127.0.0.1:6379:1

启动：

    sbin/nutcracker -t conf/nutcracker.yml
    sbin/nutcracker -d -c conf/nutcracker.yml -p run/redisproxy.pid -o run/redisproxy.log

    killall nutcracker 

nutcracker用法与命令选项

    Usage: nutcracker [-?hVdDt] [-v verbosity level] [-o output file]
    [-c conf file] [-s stats port] [-a stats addr]
    [-i stats interval] [-p pid file] [-m mbuf size]
    Options:
    -h, –help                        : 查看帮助文档，显示命令选项
    -V, –version                   : 查看nutcracker版本
    -t, –test-conf                  : 测试配置脚本的正确性
    -d, –daemonize              : 以守护进程运行
    -D, –describe-stats         : 打印状态描述
    -v, –verbosity=N            : 设置日志级别 (default: 5, min: 0, max: 11)
    -o, –output=S                 : 设置日志输出路径，默认为标准错误输出 (default: stderr)
    -c, –conf-file=S               : 指定配置文件路径 (default: conf/nutcracker.yml)
    -s, –stats-port=N            : 设置状态监控端口，默认22222 (default: 22222)
    -a, –stats-addr=S            : 设置状态监控IP，默认0.0.0.0 (default: 0.0.0.0)
    -i, –stats-interval=N       : 设置状态聚合间隔 (default: 30000 msec)
    -p, –pid-file=S                 : 指定进程pid文件路径，默认关闭 (default: off)
    -m, –mbuf-size=N          : 设置mbuf块大小，以bytes单位 (default: 16384 bytes)




