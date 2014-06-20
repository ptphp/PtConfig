
    apt-get update
    apt-get install -y gcc make
    sudo apt-get install -y unzip
    sudo apt-get install -y autoconf
    sudo apt-get install -y libxml2-dev
    sudo apt-get install -y bzip2
    sudo apt-get install -y libcurl3-openssl-dev
    sudo apt-get install -y libcurl4-gnutls-dev
    sudo apt-get install -y libjpeg-dev
    sudo apt-get install -y libpng-dev
    sudo apt-get install -y libxpm-dev
    sudo apt-get install -y libfreetype6-dev
    sudo apt-get install -y libt1-dev
    sudo apt-get install -y libmcrypt-dev
    sudo apt-get install -y libmysql++-dev
    sudo apt-get install -y libxslt1-dev
    sudo apt-get install -y git
    sudo apt-get install -y vim
    update-alternatives --config editor
    
#建立目录

    mkdir -p /opt/ptserver/apache2.4/
    mkdir -p /opt/ptserver/php-5.5.13/etc/conf
    mkdir -p /opt/ptserver/webroot/


#nginx

    sudo apt-get install libpcre3 libpcre3-dev libpcrecpp0 libssl-dev zlib1g-dev
    wget http://nginx.org/download/nginx-1.6.0.tar.gz
    tar xzvf nginx-1.6.0.tar.gz
    cd nginx-1.6.0
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
    cp /opt/ptserver/php-5.5.13/etc/php-fpm.conf.default /opt/ptserver/php-5.5.13/etc/php-fpm.conf
    ln -s /opt/ptserver/php-5.5.13/bin/php /usr/local/bin/php
    
    cp sapi/fpm/init.d.php-fpm /etc/init.d/php-fpm
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


1 . 后端一台 Redis 挂掉后，Twemproxy 能够自动摘除。恢复后，Twemproxy 能够自动识别、恢复并重新加入到 Redis 组中重新使用
2.Redis 挂掉后，后端数据是否丢失依据 Redis 本身的策略配置，与 Twemproxy 基本无关。


无论是 Memcached 还是当前的 Redis，其本身都不具备分布式集群特性，当我们有大量 Redis 或 Memcached 的时候，通常只能通过客户端的一些数据分配算法（比如一致性哈希），来实现集群存储的特性
通过引入一个代理层，可以将其后端的多台 Redis 或 Memcached 实例进行统一管理与分配，使应用程序只需要在 Twemproxy 上进行操作，而不用关心后面具体有多少个真实的 Redis 或 Memcached 存储。

1 根据 Redis 作者的测试结果，在大多数情况下，Twemproxy 的性能相当不错，直接操作 Redis 相比，最多只有20%的性能损失,这对于它带来的好处来说真的是微不足道了，唯一可能还有待改进的是其 MGET 操作的效率，其性能只有直接操作Redis 的 50%。




问题与不足

Twemproxy 由于其自身原理限制，有一些不足之处，如：
不支持针对多个值的操作，比如取sets的子交并补等（MGET 和 DEL 除外）
不支持Redis的事务操作
出错提示还不够完善

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


一个twemproxy可以被配置成多个角色。

详细的配置信息如下：
 
listen
twemproxy监听的端口。可以以ip:port或name:port的形式来书写。
 
hash
可以选择的key值的hash算法：
> one_at_a_time
> md5
> crc16
> crc32(crc32 implementation compatible with libmemcached)
> crc32a(correct crc32 implementation as per the spec)
> fnv1_64
> fnv1a_64
> fnv1_32
> fnv1a_32
> hsieh
> murmur
> jenkins
 
如果没选择，默认是fnv1a_64。
 
hash_tag
hash_tag允许根据key的一个部分来计算key的hash值。hash_tag由两个字符组成，一个是hash_tag的开始，另外一个是hash_tag的结束，在hash_tag的开始和结束之间，是将用于计算key的hash值的部分，计算的结果会用于选择服务器。
 
例如：如果hash_tag被定义为”{}”，那么key值为"user:{user1}:ids"和"user:{user1}:tweets"的hash值都是基于”user1”，最终会被映射到相同的服务器。而"user:user1:ids"将会使用整个key来计算hash，可能会被映射到不同的服务器。
 
distribution
存在ketama、modula和random3种可选的配置。其含义如下：
 
ketama
ketama一致性hash算法，会根据服务器构造出一个hash ring，并为ring上的节点分配hash范围。ketama的优势在于单个节点添加、删除之后，会最大程度上保持整个群集中缓存的key值可以被重用。
 
modula
modula非常简单，就是根据key值的hash值取模，根据取模的结果选择对应的服务器。
 
random
random是无论key值的hash是什么，都随机的选择一个服务器作为key值操作的目标。
 
timeout
单位是毫秒，是连接到server的超时值。默认是永久等待。
 
backlog
监听TCP 的backlog（连接等待队列）的长度，默认是512。
 
preconnect
是一个boolean值，指示twemproxy是否应该预连接pool中的server。默认是false。
redis
是一个boolean值，用来识别到服务器的通讯协议是redis还是memcached。默认是false。
 
server_connections
每个server可以被打开的连接数。默认，每个服务器开一个连接。
 
auto_eject_hosts
是一个boolean值，用于控制twemproxy是否应该根据server的连接状态重建群集。这个连接状态是由server_failure_limit 阀值来控制。
默认是false。
 
server_retry_timeout
单位是毫秒，控制服务器连接的时间间隔，在auto_eject_host被设置为true的时候产生作用。默认是30000 毫秒。
 
server_failure_limit
控制连接服务器的次数，在auto_eject_host被设置为true的时候产生作用。默认是2。
 
servers
一个pool中的服务器的地址、端口和权重的列表，包括一个可选的服务器的名字，如果提供服务器的名字，将会使用它决定server的次序，从而提供对应的一致性hash的hash ring。否则，将使用server被定义的次序。


redis1:
  listen: 0.0.0.0:9999 #使用哪个端口启动Twemproxy
  redis: true #是否是Redis的proxy
  hash: fnv1a_64 #指定具体的hash函数
  distribution: ketama #具体的hash算法
  auto_eject_hosts: true #是否在结点无法响应的时候临时摘除结点
  timeout: 400 #超时时间（毫秒）
  server_retry_timeout: 2000 #重试的时间（毫秒）
  server_failure_limit: 1 #结点故障多少次就算摘除掉
  servers: #下面表示所有的Redis节点（IP:端口号:权重）
   - 127.0.0.1:6379:1
   - 127.0.0.1:6380:1
   - 127.0.0.1:6381:1
   - 127.0.0.1:6382:1
redis2:
  listen:0.0.0.0:10000
  redis: true
  hash: fnv1a_64
  distribution: ketama
  auto_eject_hosts: false
  timeout: 400
  servers:
   - 127.0.0.1:6379:1
   - 127.0.0.1:6380:1
   - 127.0.0.1:6381:1
   - 127.0.0.1:6382:1
alpha:
  listen: 127.0.0.1:22121
  hash: fnv1a_64
  distribution: ketama
  auto_eject_hosts: true
  redis: true
  server_retry_timeout: 2000
  server_failure_limit: 1
  servers:
   - 127.0.0.1:6379:1
   - 127.0.0.1:6378:1
beta:
  listen: 127.0.0.1:22122
  hash: fnv1a_64
  hash_tag: "{}"
  distribution: ketama
  auto_eject_hosts: false
  timeout: 400
  redis: true
  servers:
   - 127.0.0.1:6380:1
   - 127.0.0.1:6381:1


