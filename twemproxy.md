

1 . ���һ̨ Redis �ҵ���Twemproxy �ܹ��Զ�ժ�����ָ���Twemproxy �ܹ��Զ�ʶ�𡢻ָ������¼��뵽 Redis ��������ʹ��
2.Redis �ҵ��󣬺�������Ƿ�ʧ���� Redis ����Ĳ������ã��� Twemproxy �����޹ء�


������ Memcached ���ǵ�ǰ�� Redis���䱾�����߱��ֲ�ʽ��Ⱥ���ԣ��������д��� Redis �� Memcached ��ʱ��ͨ��ֻ��ͨ���ͻ��˵�һЩ���ݷ����㷨������һ���Թ�ϣ������ʵ�ּ�Ⱥ�洢������
ͨ������һ������㣬���Խ����˵Ķ�̨ Redis �� Memcached ʵ������ͳһ��������䣬ʹӦ�ó���ֻ��Ҫ�� Twemproxy �Ͻ��в����������ù��ĺ�������ж��ٸ���ʵ�� Redis �� Memcached �洢��

1 ���� Redis ���ߵĲ��Խ�����ڴ��������£�Twemproxy �������൱����ֱ�Ӳ��� Redis ��ȣ����ֻ��20%��������ʧ,������������ĺô���˵�����΢������ˣ�Ψһ���ܻ��д��Ľ������� MGET ������Ч�ʣ�������ֻ��ֱ�Ӳ���Redis �� 50%��




�����벻��

Twemproxy ����������ԭ�����ƣ���һЩ����֮�����磺
��֧����Զ��ֵ�Ĳ���������ȡsets���ӽ������ȣ�MGET �� DEL ���⣩
��֧��Redis���������
������ʾ����������



nutcracker�÷�������ѡ��
Usage: nutcracker [-?hVdDt] [-v verbosity level] [-o output file]
[-c conf file] [-s stats port] [-a stats addr]
[-i stats interval] [-p pid file] [-m mbuf size]
Options:
-h, �Chelp                        : �鿴�����ĵ�����ʾ����ѡ��
-V, �Cversion                   : �鿴nutcracker�汾
-t, �Ctest-conf                  : �������ýű�����ȷ��
-d, �Cdaemonize              : ���ػ���������
-D, �Cdescribe-stats         : ��ӡ״̬����
-v, �Cverbosity=N            : ������־���� (default: 5, min: 0, max: 11)
-o, �Coutput=S                 : ������־���·����Ĭ��Ϊ��׼������� (default: stderr)
-c, �Cconf-file=S               : ָ�������ļ�·�� (default: conf/nutcracker.yml)
-s, �Cstats-port=N            : ����״̬��ض˿ڣ�Ĭ��22222 (default: 22222)
-a, �Cstats-addr=S            : ����״̬���IP��Ĭ��0.0.0.0 (default: 0.0.0.0)
-i, �Cstats-interval=N       : ����״̬�ۺϼ�� (default: 30000 msec)
-p, �Cpid-file=S                 : ָ������pid�ļ�·����Ĭ�Ϲر� (default: off)
-m, �Cmbuf-size=N          : ����mbuf���С����bytes��λ (default: 16384 bytes)





һ��twemproxy���Ա����óɶ����ɫ��

��ϸ��������Ϣ���£�
 
listen
twemproxy�����Ķ˿ڡ�������ip:port��name:port����ʽ����д��
 
hash
����ѡ���keyֵ��hash�㷨��
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
 
���ûѡ��Ĭ����fnv1a_64��
 
hash_tag
hash_tag�������key��һ������������key��hashֵ��hash_tag�������ַ���ɣ�һ����hash_tag�Ŀ�ʼ������һ����hash_tag�Ľ�������hash_tag�Ŀ�ʼ�ͽ���֮�䣬�ǽ����ڼ���key��hashֵ�Ĳ��֣�����Ľ��������ѡ���������
 
���磺���hash_tag������Ϊ��{}������ôkeyֵΪ"user:{user1}:ids"��"user:{user1}:tweets"��hashֵ���ǻ��ڡ�user1�������ջᱻӳ�䵽��ͬ�ķ���������"user:user1:ids"����ʹ������key������hash�����ܻᱻӳ�䵽��ͬ�ķ�������
 
distribution
����ketama��modula��random3�ֿ�ѡ�����á��京�����£�
 
ketama
ketamaһ����hash�㷨������ݷ����������һ��hash ring����Ϊring�ϵĽڵ����hash��Χ��ketama���������ڵ����ڵ���ӡ�ɾ��֮�󣬻����̶��ϱ�������Ⱥ���л����keyֵ���Ա����á�
 
modula
modula�ǳ��򵥣����Ǹ���keyֵ��hashֵȡģ������ȡģ�Ľ��ѡ���Ӧ�ķ�������
 
random
random������keyֵ��hash��ʲô���������ѡ��һ����������Ϊkeyֵ������Ŀ�ꡣ
 
timeout
��λ�Ǻ��룬�����ӵ�server�ĳ�ʱֵ��Ĭ�������õȴ���
 
backlog
����TCP ��backlog�����ӵȴ����У��ĳ��ȣ�Ĭ����512��
 
preconnect
��һ��booleanֵ��ָʾtwemproxy�Ƿ�Ӧ��Ԥ����pool�е�server��Ĭ����false��
redis
��һ��booleanֵ������ʶ�𵽷�������ͨѶЭ����redis����memcached��Ĭ����false��
 
server_connections
ÿ��server���Ա��򿪵���������Ĭ�ϣ�ÿ����������һ�����ӡ�
 
auto_eject_hosts
��һ��booleanֵ�����ڿ���twemproxy�Ƿ�Ӧ�ø���server������״̬�ؽ�Ⱥ�����������״̬����server_failure_limit ��ֵ�����ơ�
Ĭ����false��
 
server_retry_timeout
��λ�Ǻ��룬���Ʒ��������ӵ�ʱ��������auto_eject_host������Ϊtrue��ʱ��������á�Ĭ����30000 ���롣
 
server_failure_limit
�������ӷ������Ĵ�������auto_eject_host������Ϊtrue��ʱ��������á�Ĭ����2��
 
servers
һ��pool�еķ������ĵ�ַ���˿ں�Ȩ�ص��б�����һ����ѡ�ķ����������֣�����ṩ�����������֣�����ʹ��������server�Ĵ��򣬴Ӷ��ṩ��Ӧ��һ����hash��hash ring�����򣬽�ʹ��server������Ĵ���


redis1:
  listen: 0.0.0.0:9999 #ʹ���ĸ��˿�����Twemproxy
  redis: true #�Ƿ���Redis��proxy
  hash: fnv1a_64 #ָ�������hash����
  distribution: ketama #�����hash�㷨
  auto_eject_hosts: true #�Ƿ��ڽ���޷���Ӧ��ʱ����ʱժ�����
  timeout: 400 #��ʱʱ�䣨���룩
  server_retry_timeout: 2000 #���Ե�ʱ�䣨���룩
  server_failure_limit: 1 #�����϶��ٴξ���ժ����
  servers: #�����ʾ���е�Redis�ڵ㣨IP:�˿ں�:Ȩ�أ�
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