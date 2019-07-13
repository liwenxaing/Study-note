

## Redis笔记

## 简介

+ 是一个key-value的NoSql数据库
+ 键可以包含 String hash list链表 set集合 zset有序集合这些数据集合都支持pop/push add/remove redis支持各种不同的方式排序 为了保证效率 数据都是缓存在内存中 它也可以周期性的将数据写入到磁盘中或者文件里
+ 优点
  + 对数据高并发读写
  + 对海量数据的高效率存储和访问
  + 对数据的可扩展性和高可用性
+ 缺点
  + 无法做到太复杂的关系型数据库模型
+ 默认将数据库分为16份   是逻辑划分 并不是物理划分

##非关系型数据库的特点

+ 数据模型比较简单
+ 需要灵活性更强的IT系统
+ 对数据库的要求性能较高
+ 不需要高度的数据一致性
+ 对于给定key 比较容易映射复杂值的环境

## 安装

**LINXU 压缩包方式 **

- 上传tar.gz压缩包
- 进行解压
- cd redis-x.x.x 目录下 make 编译
- 使用 redis-server 启动 默认是前台启动 会占用当前线程  默认占用 6379 端口
- 使用redis-server 可以指定配置文件位置   redis-server   /usr/local/tmp/redis/redis.conf
- 后台启动不占用当前线程 可以去配置文件里面进行配置  redis.conf
- 使用 redis-cli 进行连接客户端
- quit 退出客户端
- 关闭redis服务 
  - 使用 kill -9  进程号
  - 使用 redis-cli  [-a  password] shutdown

## 数据可靠性

+ 由于redis数据是在内存中存储的所以在当机器down机之后再启动数据就没了
+ 就需要数据的持久化
+ redis 提供了两种形式进行数据的持久化
  + RDB (不稳定)
    + 定时将数据dump到磁盘上 
  + AOF (稳定)
    + 是将redis的操作日志以追加的形式写入到文件中

## 持久化机制

+ RDB   一般不使用
  + save 900 1   在900秒内有一个key变化就写入到硬盘中
  + save  300  10   在300秒内 有10个key变化就写入到磁盘中
  + save   60   10000  
+ AOF   一般使用这种形式
  + 由于RDB方式是每隔一段时间做一次 所以可能发生意外down的情况就会丢失最后一次快照的所有数据
  + AOF 方式比快照方式有更好的持久化性  是因为redis在每一次接受到写命令时都写到文件中
  + 常用配置
    + appendonly yes   开启aof模式
    + appendfsync always    常用的形式  收到写命令 就将数据写到磁盘中  效率最慢  但是保证完全的持久化
    + appendfaync  everysec   默认的形式   效果折中    每隔一秒写入磁盘一次
    + appendfaync   no      完全依赖os   性能最好   持久化没保证

## 常用命令

**String**

+ get   key     获取
+ set key value 
+ setrange email 5 replace   替换email的第五个文本以后的内容为文本replace
+ getset   key   changechun   先获取到以前的旧值 在设置新值
+ setex   key   time   value 设置一个值加上过期时间
+ setnx   key   value   如果key已经存在就不设置了
+ mset  k1  v1 k2 v2 k3 v3  批量设置
+ mget   k1 k2 k3    批量获取 
+ del key    删除
+ incr key 1  自增一
+ decr  key  1  自减1
+ incrby  key  2  步长  

**Hash**

+ hset myHash name liwenxiang	   设置一个值
	 hget myHash name	                    获取到一个值
+ hmget   name age sex                    获取到多个值
+ hmset  myHash name 123 age 123 gender 1       设置多个值
+ hdel  myHash  name                                   
+ hexists myHash name  
+ hlen myHash            
+ hkeys myHash       
+ hvals   myHash        
+ hgetall  返回hash里面的所有key和value         

**list链表**

+ 有序的集合

+ lpush  类似栈   先进后出   在链表前面添加一个元素

+ rpush   队列     先进先出    在链表后面添加一个元素

+ lpop    在链表前面移除一个元素 并且返回这个移除的元素

+ rpop   在链表后面移除一个元素 并且返回这个移除的元素

+ lindex  获取到链表中的指定下标的元素

+ lrange   查看指定范围内的值   一般是 0 -1 查看全部

+ Blpop删除，并获得该列表中的第一元素，或阻塞，直到有一个可用

+ Brpop删除，并获得该列表中的最后一个元素，或阻塞，直到有一个可用

+ Brpoplpush

+ Lindex获取一个元素，通过其索引列表

+ Linsert在列表中的另一个元素之前或之后插入一个元素

+ Llen获得队列(List)的长度

+ Lpop从队列的左边出队一个元素

+ Lpush从队列的左边入队一个或多个元素

+ Lpushx当队列存在时，从队到左边入队一个元素

+ Lrange从列表中获取指定返回的元素

+ Lrem从列表中删除元素

+ Lset设置队列里面一个元素的值

+ Ltrim修剪到指定范围内的清单

+ Rpop从队列的右边出队一个元素

+ Rpoplpush删除列表中的最后一个元素，将其追加到另一个列表

+ Rpush从队列的右边入队一个元素

+ Rpushx从队列的右边入队一个元素，仅队列存在时有效

+ Redis支持php、python、c等接口

  应用场景：

  Redis list的应用场景非常多，也是Redis最重要的数据结构之一，比如twitter的关注列表，粉丝列表等都可以用Redis的list结构来实现。

  Lists 就是链表，相信略有数据结构知识的人都应该能理解其结构。使用Lists结构，我们可以轻松地实现最新消息排行等功能。

  Lists的另一个应用就是消息队列，

  可以利用Lists的PUSH操作，将任务存在Lists中，然后工作线程再用POP操作将任务取出进行执行。Redis还提供了操作Lists中某一段的api，你可以直接查询，删除Lists中某一段的元素。

  如果需要还可以用redis的Sorted-Sets数据结构来做优先队列.可以给每条消息加上一个唯一的序号。这里就不详细介绍了。

**set**

+ 没有顺序的set  基于hashTable实现 可以支持交集 并集 差集 取数据
+ sadd  在集合中存储一个数据
+ scard  返回set集合中的个数 
+ smembers    获取到集合中的所有数据
+ spop     随机移除一个元素并且返回
+ srem key value  删除集合中指定元素
+ sinter  set1  set2   取交集    重叠的部分
+ sunion set1 set2   返回一个集合的全部成员，该集合是所有给定集合的并集 
+ sdiff    set1 set2     返回所有给定 key 与第一个 key 的差集   减去重叠的部分

**zset**

+ 有序的set

+ zadd zset1  1  one   添加一个元素
+ zcard zset1  获取到当前集合中的个数
+ zcount   zset1  0  1   获取到指定区间的个数
+ zrank  zset1  one   返回指定元素的索引
+ zrem  zset1  one  删除一个元素
+ zrange zset1 1 -1  返回一个指定范围内的值
+ zscore zset1  one  返回一个元素的数值

## 高级命令

+ keys  *  |  keys  nam   查看一存储的键有哪些 通配
+ exists    key    判断是否存在某一个key
+ select   0    选择一个数据库   默认是选择的第0个数据库
+ move   name  2     将当前数据库中的name移动到第二个数据库中 
+ rename   name name1    给一个key重新换一个名字
+ echo   123    打印命令
+ flushdb   清空数据库
+ dbsize   查看数据库中有几个key
+ info  查看当前数据库的信息
+ flushdb 清空当前数据库
+ flushAll 清空所有数据库
+ ttl  key 查看当前值得有效时间
+ expire  key   10    设置过期时间  

## 安全性

+ 可以给数据库设置密码
+ 在配置文件里  设置  requirepass    123456
+ 在进行修改数据的时候  使用  auth   123456  进行认证
+ 还有一种方式是在  使用客户端的使用进行登录
  + 可以使用   redis-cli  -a  123456   这种形式记性登录

## 配置文件

+ daemonize no  守护进程  是否开启后台启动模式
+ port 6379       占用的端口号
+ logfile ""        日志文件
+ databases 16    数据库个数 默认 16
	 dir ./	     启动的日志信息 或者是持久化文件 包括rdb aof 的存储目录
+ appendonly no    是否开启aof模式 默认不开启
+ appendfilename "appendonly.aof" aof文件名称

## 主从复制

+ master 是主服务器
+ slave   是从服务器
+ 主服务器可读可写    从服务器只可读
+ 在客户端创建一个redis实例 的话 会自动帮助你进行负载均衡  除非你实例化一个redis实例 指定链接某一个服务器
+ 主服务 和 从服务器 的数据会同步  
+ 配置信息  实现主从复制
  + redis.conf 
    + slaveof  masterip   masterport
      + 例子     192.168.190.138   6379
  + 如果有密码的话就需要在加一步配置

## 事务

+ redis中的事务比较简单  基本上不用  没有回滚   了解即可
+ multi    开启事务
+ exec  结束事务
+ 在开启事务之后之后的操作就都会进入等待队列...........  等待调用exec就会统一执行
+ 发生错误之后 其他的还是会执行  没啥用处 基本不用

## 发布与订阅

+ 使用subscribe进行订阅监听
  + subscribe频道名称      这是订阅频道   会等待发布者发布信息
  + publish   频道名称    发布内容

## 集群搭建

+ 最少六台机器

+ 三台master(主)三台slave(从)

+ 在redis的同级目录创建一个redis-cluster文件夹

+ 搭建好在次启动就不需要搭建了 就已经成功了

+ 每一个集群间的数据是相通的  采用插槽的形式存储数据

+ 主节点可读可写 从节点只可读

+ 需要安装ruby

  + yum install ruby
  + yum install rubygems
  + gem install  redis

+ 然后使用一台机器模仿6台机器

  + 在redis-cluster文件夹下面分别创建7001 7002 7003 7004 7005 7006 文件夹
  + 将src下面的redis.conf配置文件copy一份到700*文件夹下面

+ 开启后台进程

  + **daemonize yes**

+ 修改配置文件内容

  + ```java
    port  700*                                       //端口7000,7002,7003        
    bind 本机ip                                       //默认ip为127.0.0.1 需要改为其他节点机器可访问的ip 0.0.0.0 即可 否则创建集群时无法访问对应的端口，无法创建集群
    daemonize    yes                               //redis后台运行
    pidfile  /var/run/redis_7000.pid          //pidfile文件对应7000,7001,7002
    cluster-enabled  yes                           //开启集群  把注释#去掉
    cluster-config-file  nodes_7000.conf   //集群的配置  配置文件首次启动自动生成 7000,7001,7002
    cluster-node-timeout  15000                //请求超时  默认15秒，可自行设置
    appendonly  yes                           //aof日志开启  有需要就开启，它会每次写操作都记录一条日志　
    可以修改一下dir数据存储位置 对应以下
    启动集群服务器 检测是否启动成功
    ```

![1557676449954](assets/1557676449954.png)



![1557676401671](assets/1557676401671.png)

开启集群

使用

​	./redis-trib.rb create --replicas 1  192.168.190.138:7001 192.168.190.138:7002 192.168.190.138:7003 192.168.190.138:7004 192.168.190.138:7005 192.168.190.138:7006

报错提示 ruby 版本 过低的话  

yum -y install ruby ruby-devel rubygems rpm-build 

ruby -v 

yum install centos-release-scl-rh　 

yum install rh-ruby24  -y 

scl enable rh-ruby24 bash 

ruby -v 

链接成功

![1557678492732](assets/1557678492732.png)

![1557678504273](assets/1557678504273.png)

./redis-cli -c -h 192.168.190.138 -p 700*  进入到客户端 和普通的不一样 -c 代表是集群模式  -h  ip  -p 端口

./redis-cli -c -h 192.168.190.138 -p 700* shutdown    关闭redis服务



如果再次启动启动出错的话 就删除掉每一个集群机器下面的节点配置文件 重新创建集群 删除掉的话就不是集群了

![1557717633598](assets/1557717633598.png)

+ cluster nodes   查看集群

## Java操作Redis集群

+ 基础用法

+ ```java
  package redisdemo;
  
  import java.util.HashMap;
  import java.util.List;
  import java.util.Map;
  import java.util.Map.Entry;
  import java.util.Scanner;
  import java.util.Set;
  import java.util.UUID;
  
  import org.junit.After;
  import org.junit.Before;
  import org.junit.Test;
  
  import com.alibaba.fastjson.JSON;
  import com.alibaba.fastjson.TypeReference;
  
  import redis.clients.jedis.Jedis;
  import redis.clients.jedis.JedisPubSub;
  
  public class demo02 {
  
      private Jedis j; 
  
      @Before
      public void before() {
          j = new Jedis("192.168.190.138",6379);
      }
  
      @Test
      public void String_incrBy(){
          j.incrBy("volumn",5);
          String str = j.get("volumn");
          System.out.println(str);
      }
  
      @Test
      public void Hash_hset_hget() {
          //		 Long hsetnx = j.hsetnx("myHash","name","lwx");
          //		 Long hsetnx2 = j.hsetnx("myHash","age","18");
          //		 Long hsetnx3 = j.hsetnx("myHash","gender","0");
          //		 System.out.println(hsetnx+"-"+hsetnx2+"-"+hsetnx3);
          Map<String,User> map = new HashMap<String,User>();
  
          for(int i=0; i < 100000; i++) {
              String uid3 = UUID.randomUUID().toString();
              map.put(uid3,new User(uid3,"lwx"+i,""+i,""+i));
          }
  
          String mapStr = JSON.toJSONString(map);
  
          j.set("SYS_USER_TABLE",mapStr);
  
  
          String string = j.get("SYS_USER_TABLE");
  
          Map<String,User> parseObject1 = JSON.parseObject(string,new TypeReference<HashMap<String,User>>() {});
  
          System.out.println(parseObject1.size());
      }
  
  
      @Test
      public void test() {
          Long lo = System.currentTimeMillis();
          for(int i = 0 ; i < 10000 ; i++) {
              j.set(""+i,JSON.toJSONString(new User(UUID.randomUUID().toString(),UUID.randomUUID().toString(),UUID.randomUUID().toString(),UUID.randomUUID().toString())));
          }
          Long loend = System.currentTimeMillis();
          System.out.println((loend-lo)+"ms");
      }
  
      @Test
      public void get() {
          Long lo = System.currentTimeMillis();
          for(int i = 0 ; i < 10000 ; i++) {
              String string = j.get(""+i);
              System.out.println(string);
          }
          Long loend = System.currentTimeMillis();
          System.out.println((loend-lo)+"ms");
      }
  
      @Test
      public void del() {
          String flushDB = j.flushDB();
          System.out.println(flushDB);
          Set<String> keys = j.keys("*");
          System.out.println(keys);
          for (String string : keys) {
              System.out.println(string);	
          }
      }
  
  
      @Test
      public void hashMap() {
          Map<String, String> map = new HashMap();
          map.put("userName", "jack");
          map.put("password", "123");
          map.put("age", "12");
          // 将map存入redis中
          j.hmset("myMap", map);
  
          // 取出redis中的map进行遍历
          Map<String, String> userMap = j.hgetAll("myMap");
          for (Map.Entry<String, String> item : userMap.entrySet()) {
              System.out.println(item.getKey() + " : " + item.getValue());
          }
      }
  
      @Test
      public void hashMap1() {
          Map<String, String> map = new HashMap<String,String>();
          map.put("1", JSON.toJSONString(new User("1","2","3","4")));
          map.put("2", JSON.toJSONString(new User("1","2","3","4")));
          map.put("3", JSON.toJSONString(new User("1","2","3","4")));
          // 将map存入redis中
          String hmset = j.hmset("SYS_USER_TABLE", map);
  
          Map<String, String> hgetAll = j.hgetAll("SYS_USER_TABLE");
  
          for(Entry<String,String> str : hgetAll.entrySet()) {
              System.out.println(str.getKey() + ":"+ JSON.parseObject(str.getValue(),User.class).getName());
          }
      }
  
      @Test
      public void list() {
          Long lpush = j.lpush("list1","list1Value");
          System.out.println(lpush);
          String lindex = j.lindex("list1",0);
          System.out.println(lindex);
  
          List<String> lrange = j.lrange("list1", 0,-1);
          System.out.println(lrange.size());
      }
  
      @Test
      public void set() throws InterruptedException {
  
  
          DIY diy = new DIY();
  
  
          j.subscribe(diy,"CCTV");
  
  
  
      }
  
      @Test
      public void set123() throws InterruptedException {
          Long publish = j.publish("CCTV","CCTV频道开播了。。。。。");
          System.out.println(publish);
  
      }
  
      @Test
      public void set1() throws InterruptedException {
          DIY diy = new DIY();
          j.subscribe(diy,"CCTV");
          Thread.sleep(10000);
          diy.unsubscribe();
      }
  
      @After
      public void close() {
          j.close();
      }
  }
  
  class DIY extends JedisPubSub{
  
      @Override
      public void onUnsubscribe(String channel, int subscribedChannels) {
          System.out.println("取消订阅。。。。。。。。");
          super.onUnsubscribe(channel, subscribedChannels);
      }
  
      @Override
      public void onMessage(String channel, String message) {
          System.out.println("收到通道:" + channel + "- 消息:"+message);
          super.onMessage(channel, message);
      }
  }
  
  ```

+ 发布与订阅

+ ```java
  package redis.one.demo;
  
  import redis.clients.jedis.Jedis;
  import redis.clients.jedis.JedisPubSub;
  
  public class redis_one {
      final static String MasterIp = "192.168.190.138";
      final static Integer port = 6379;
      public static void main(String[] args) throws InterruptedException {
           Jedis j = new Jedis(MasterIp,port);
  
              /**
               * 订阅
               */
              listener list = new listener();
              j.subscribe(list,"CCTV");
  
  
      }
  }
  
  class listener extends JedisPubSub{
      @Override
      public void onMessage(String channel, String message) {
          System.out.println("频道："+channel+"--"+"消息："+message);
          super.onMessage(channel, message);
      }
  
      @Override
      public void unsubscribe(String... channels) {
          System.out.println("取消订阅："+channels);
          super.unsubscribe(channels);
      }
  }
  
  class aaa{
      final static String MasterIp = "192.168.190.138";
      final static Integer port = 6379;
      public static void main(String[] args) throws InterruptedException {
          Jedis j = new Jedis(MasterIp,port);
  
          /**
           * 发布
           */
          listener list = new listener();
          j.publish("CCTV","1234568789");
  
      }
  }
  
  ```

+ HostAndPort

+ JedisPoolConfig

+ JedisCluster

+ jedis

+ 集群

+ ```java
      /**
       * 设置节点的ip和端口
       */
      Set<HostAndPort> jedisHostAndPort = new HashSet<>();
      jedisHostAndPort.add(new HostAndPort("192.168.190.138",7001));
      jedisHostAndPort.add(new HostAndPort("192.168.190.138",7002));
      jedisHostAndPort.add(new HostAndPort("192.168.190.138",7003));
      jedisHostAndPort.add(new HostAndPort("192.168.190.138",7004));
      jedisHostAndPort.add(new HostAndPort("192.168.190.138",7005));
      jedisHostAndPort.add(new HostAndPort("192.168.190.138",7006));
  
      /**
       * 使用连接池 设置配置
       */
      JedisPoolConfig poolConfig = new JedisPoolConfig();
      poolConfig.setMaxTotal(100);
      poolConfig.setMaxIdle(20);
      poolConfig.setMaxWaitMillis(-1);
      poolConfig.setTestOnBorrow(true);
  
      /**
       * 获取到集群对象
       */
      JedisCluster jc = new JedisCluster(jedisHostAndPort,1000,10, poolConfig);
  
      /**
       * 操作
       */
      jc.set("gender","woman");
      jc.close();
  ```
  + 整合Spring

  + ```xml
    <?xml version="1.0" encoding="UTF-8"?>
    <beans xmlns="http://www.springframework.org/schema/beans"
           xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:p="http://www.springframework.org/schema/p"
           xmlns:context="http://www.springframework.org/schema/context"
           xmlns:jee="http://www.springframework.org/schema/jee" xmlns:tx="http://www.springframework.org/schema/tx"
           xmlns:aop="http://www.springframework.org/schema/aop"
           xsi:schemaLocation="
                http://www.springframework.org/schema/beans http://www.springframework.org/schema/beans/spring-beans.xsd
                http://www.springframework.org/schema/context http://www.springframework.org/schema/context/spring-context.xsd">
    
        <context:property-placeholder location="classpath:redis.properties" />
        <context:component-scan base-package="redis.one.demo">
        </context:component-scan>
    
        <bean id="jedisPoolConfig" class="redis.clients.jedis.JedisPoolConfig">
            <!--  最大空闲个数  -->
            <property name="maxIdle" value="${redis.maxIdle}" />
            <!--  总连接池数量  -->
            <property name="maxTotal" value="${redis.maxActive}" />
            <!--  最大等待时间  -->
            <property name="maxWaitMillis" value="${redis.maxWait}" />
            <!--    -->
            <property name="testOnBorrow" value="${redis.testOnBorrow}" />
        </bean>
    
        <bean id="hostport1" class="redis.clients.jedis.HostAndPort">
            <constructor-arg name="host" value="192.168.190.138" />
            <constructor-arg name="port" value="7001" />
        </bean>
        <bean id="hostport2" class="redis.clients.jedis.HostAndPort">
            <constructor-arg name="host" value="192.168.190.138" />
            <constructor-arg name="port" value="7002" />
        </bean>
        <bean id="hostport3" class="redis.clients.jedis.HostAndPort">
            <constructor-arg name="host" value="192.168.190.138" />
            <constructor-arg name="port" value="7003" />
        </bean>
        <bean id="hostport4" class="redis.clients.jedis.HostAndPort">
            <constructor-arg name="host" value="192.168.190.138" />
            <constructor-arg name="port" value="7004" />
        </bean>
        <bean id="hostport5" class="redis.clients.jedis.HostAndPort">
            <constructor-arg name="host" value="192.168.190.138" />
            <constructor-arg name="port" value="7005" />
        </bean>
        <bean id="hostport6" class="redis.clients.jedis.HostAndPort">
            <constructor-arg name="host" value="192.168.190.138" />
            <constructor-arg name="port" value="7006" />
        </bean>
    
        <bean id="redisCluster" class="redis.clients.jedis.JedisCluster">
            <constructor-arg name="nodes">
                <set>
                    <ref bean="hostport1" />
                    <ref bean="hostport2" />
                    <ref bean="hostport3" />
                    <ref bean="hostport4" />
                    <ref bean="hostport5" />
                    <ref bean="hostport6" />
                </set>
            </constructor-arg>
            <constructor-arg name="timeout" value="6000" />
            <constructor-arg name="poolConfig" ref="jedisPoolConfig"/>
        </bean>
    </beans>
    ```

  + ```java
    package com.x.test;
    
    import org.springframework.context.ApplicationContext;
    import org.springframework.context.support.ClassPathXmlApplicationContext;
    
    import redis.clients.jedis.JedisCluster;
    
    public class ClusterTest {
    
        public static JedisCluster jedisCluster;
    
        public void set(String key, String value) {
            jedisCluster.set(key, value);
        }
    
        public static void main(String[] args) {
    
            ApplicationContext ac =  new ClassPathXmlApplicationContext("classpath:/applicationContext-cluster.xml");
            jedisCluster = (JedisCluster)ac.getBean("redisCluster");
    
            /* for (int i=0; i<100; i++) {
            	jedisCluster.set("name" + i, "value" + i);
            }*/
    
            System.out.println(jedisCluster.get("name4"));
        }
    }
    
    ```

##架构简单思路

+ 先划分各个模块
+ 不要从技术的角度出发
+ 适当的在某一些地方有难点 可以提出一些技术

## 面试题 - 如何处理高并发请求呢

+ 在前台可以使用一台nginx服务器 队请求进行流量的分发 然后可以在整几台nginx服务器对应不同的模块进行处理
+ 主要的是还要尽量减少前台的http请求 利用http缓存 或者说长连接
+ 对静态资源进行压缩 或者使用CDN加速静态资源的访问
+ 在后端才是比较重要的 因为最后访问的都是那么一台数据库服务器 这时候就需要对数据库进行一些处理 比如 分库分表 进行拆分  也可以将一些能够存储的数据存储到redis缓存中
+ 还有就是代码层面 多加一些判断 或者使用并发容器等等.........
+ 使用高性能的数据库集群服务器
+ 编写优质的sql语句
+ 分布式部署 负载均衡 分发流量 进行清洗
