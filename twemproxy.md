

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