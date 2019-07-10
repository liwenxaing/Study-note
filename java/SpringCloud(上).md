## SpringCloud 笔记

##### 微服务 父工程 POM

```xml
<?xml version="1.0" encoding="UTF-8"?>
<project xmlns="http://maven.apache.org/POM/4.0.0"
         xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:schemaLocation="http://maven.apache.org/POM/4.0.0 http://maven.apache.org/xsd/maven-4.0.0.xsd">
    <modelVersion>4.0.0</modelVersion>

    <groupId>micro.service</groupId>
    <artifactId>parent</artifactId>
    <version>1.0-SNAPSHOT</version>
    <modules>
        <module>api</module>
        <module>provider8001</module>
        <module>consumer80</module>
    </modules>
    <packaging>pom</packaging>

    <properties>
        <project.build.sourceEncoding>UTF-8</project.build.sourceEncoding>
        <maven.compiler.source>1.8</maven.compiler.source>
        <maven.compiler.target>1.8</maven.compiler.target>
        <junit.version>4.12</junit.version>
        <log4j.version>1.2.17</log4j.version>
        <druid.version>1.1.10</druid.version>
        <spring-boot.version>1.5.19.RELEASE</spring-boot.version>
        <spring-cloud.version>Dalston.SR1</spring-cloud.version>
        <mysql-connector.version>5.1.47</mysql-connector.version>
        <mybatis-starter.version>1.3.3</mybatis-starter.version>
        <logback.version>1.2.3</logback.version>
        <lombok.version>1.18.6</lombok.version>
    </properties>

    <dependencyManagement>
        <dependencies>
            <dependency>
                <groupId>org.springframework.cloud</groupId>
                <artifactId>spring-cloud-dependencies</artifactId>
                <version>${spring-cloud.version}</version>
                <type>pom</type>
                <scope>import</scope>
            </dependency>
            <dependency>
                <groupId>org.springframework.boot</groupId>
                <artifactId>spring-boot-dependencies</artifactId>
                <version>${spring-boot.version}</version>
                <type>pom</type>
                <scope>import</scope>
            </dependency>
            <dependency>
                <groupId>mysql</groupId>
                <artifactId>mysql-connector-java</artifactId>
                <version>${mysql-connector.version}</version>
            </dependency>
            <dependency>
                <groupId>com.alibaba</groupId>
                <artifactId>druid</artifactId>
                <version>${druid.version}</version>
            </dependency>
            <dependency>
                <groupId>org.mybatis.spring.boot</groupId>
                <artifactId>mybatis-spring-boot-starter</artifactId>
                <version>${mybatis-starter.version}</version>
            </dependency>
            <dependency>
                <groupId>log4j</groupId>
                <artifactId>log4j</artifactId>
                <version>${log4j.version}</version>
            </dependency>
            <dependency>
                <groupId>ch.qos.logback</groupId>
                <artifactId>logback-core</artifactId>
                <version>${logback.version}</version>
            </dependency>
            <dependency>
                <groupId>junit</groupId>
                <artifactId>junit</artifactId>
                <version>${junit.version}</version>
                <scope>test</scope>
            </dependency>
        </dependencies>
    </dependencyManagement>

    <build>
        <plugins>
            <plugin>
                <groupId>org.apache.maven.plugins</groupId>
                <artifactId>maven-resources-plugin</artifactId>
                <configuration>
                    <delimiters>
                        <delimit>$</delimit>
                    </delimiters>
                </configuration>
            </plugin>
        </plugins>
    </build>

</project>
```



##### 阿里云Maven镜像 速度极快

```xml
<mirror>
    <id>nexus-aliyun</id>
    <mirrorOf>*</mirrorOf>
    <name>Nexus aliyun</name>
    <url>http://maven.aliyun.com/nexus/content/groups/public</url>
</mirror>
```

放到maven的setting.xml中去

```xml

<settings xmlns="http://maven.apache.org/SETTINGS/1.0.0" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
          xsi:schemaLocation="http://maven.apache.org/SETTINGS/1.0.0 http://maven.apache.org/xsd/settings-1.0.0.xsd">
    <pluginGroups></pluginGroups>
    <proxies></proxies>

    <servers>
    </servers>

    <mirrors>
        <mirror>
            <id>nexus-aliyun</id>
            <mirrorOf>*</mirrorOf>
            <name>Nexus aliyun</name>
            <url>http://maven.aliyun.com/nexus/content/groups/public</url>
        </mirror> 
    </mirrors>

    <profiles>
    </profiles>

    <activeProfiles>
        <activeProfile>nexus</activeProfile>
    </activeProfiles>
</settings> 
```



#### 单体架构

​	将所有的功能,模块都耦合集中在一个应用服务器中 单体架构也叫单体系统 

##### 特点

​	会以一个进程的方式去运行

​	打成一个唯一的jar包或者是war包

##### 优点

​	部署简单

​	项目易于管理

##### 缺点

​	可伸缩性差

​	可靠性差

​	跨语言程度差

​	测试成本高

​	迭代困难 

​	团队协作困难

#### 微服务架构

##### 解释

​	微服务是一种架构风格。提倡将单一应用拆分为多个小模块 进行完全的解耦和 每一个服务运行在自己独立的进程中 服务之间项目配合 相互协调来完成一个完整的系统 一个大型的复杂软件应用，由一个或多个微服务组成。系统中 的各个微服务可被独立部署，各个微服务之间是松耦合的。每个微服务仅关注于完成一件任 务并很好的完成该任务 

##### 优点

​	可伸缩性强

​	可靠性强

​	跨语言程度强

​	测试容易

​	迭代容易 

​	团队协作方便

##### 缺点

​	运维成本高  部署数量较多

​	接口兼容多版本

​	分布式系统的复杂性

​	分布式事务

##### 常见的架构风格

​	面向服务的架构风格(SOA)

​	基于组件的架构风格(EJB)

​	分层的架构风格(MVC)

​	客户端与服务端的架构风格

​	微服务架构风格

#### Mvc

#####解释

​	其实 MVC 架构就是一个单体架构。 

​	代表技术：Struts2、SpringMVC、Spring、Mybatis 等等。

#### Rpc

##### 解释

​	RPC(RemoteProcedureCall)：远程过程调用。他一种通过网络从远程计算机程序上请求 服务，而不需要了解底层网络技术的协议

​	代表技术：Thrift、Hessian 等等

#### Soa

##### 解释

​	SOA(ServiceorientedArchitecture):面向服务架构 ESB(Enterparise Servce Bus):企业服务总线，服务中介。主要是提供了一个服务于服务 之间的交互。 

​	ESB 包含的功能如：负载均衡，流量控制，加密处理，服务的监控，异常处理，监控 告急等等

​	代表技术：Mule、WSO2

#### 微服务

##### 解释

​	微服务就是一个轻量级的服务治理方案。

​	 代表技术：SpringCloud、dubbo 等等

#### 微服务的设计原则

​	**AKF设计原则** **重点**

​	**前后端分离原则**

​	**无状态服务**

​	**RestFul 风格API**

#### SpringCloud

SpringBoot专注于开发一个个体微服务引用 而SpringCloud是提供一整套的微服务治理方案

##### 什么是SpringCloud?

​	分布式微服务架构下的一站式解决方案 是各个微服务技术的集合体 俗称微服务全家桶 是微服务思想的一个落地的实现  是一个服务治理平台，提供了一套完整的微服务组件。包含了：服务注册 与发现、配置中心、消息中心 、负载均衡、数据监控等等。

​	Spring Cloud 是一个微服务框架，相比 Dubbo 等 RPC 框架, Spring Cloud 提 供的全套的分布式系统解决方案

​	Spring Cloud 对微服务基础框架 Netflix 的多个开源组件进行了封装，同时又实现 了和云端平台以及和 Spring Boot 开发框架的集成。 

​	SpringCloud 为微服务架构开发涉及的配置管理，服务治理，熔断机制，智能路由， 微代理，控制总线，一次性 token，全局一致性锁，leader 选举，分布式 session，集 群状态管理等操作提供了一种简单的开发方式。

​	SpringCloud 为开发者提供了快速构建分布式系统的工具，开发者可以快速的启动 服务或构建应用、同时能够快速和云平台资源进行对接。

#####SpringCloud项目的位置

​	Sping Cloud 是 Spring 的一个顶级项目与 Spring Boot、Spring Data 位于同一位
置。

##### SpringCloud 的子项目

**3.1Spring Cloud Config**：配置管理工具，支持使用 Git 存储配置内容，支持应用配置的外部化存储，支持客户端配置信息刷新、加解密配置内容等 3.2Spring Cloud Bus：事件、消息总线，用于在集群（例如，配置变化事件）中 传播状态变化，可与 Spring Cloud Config 联合实现热部署。

**3.3Spring Cloud Netflix**：针对多种 Netflix 组件提供的开发工具包，其中包括 Eureka、Hystrix、Zuul、Archaius 等。

**3.3.1Netflix Eureka**：一个基于 rest 服务的服务治理组件，包括服务注册中心、服务注册与服务发现机制的实现，实现了云端负载均衡和中间层服务器 的故障转移。

**3.3.2NetflixHystrix**：容错管理工具，实现断路器模式，通过控制服务的节点,
从而对延迟和故障提供更强大的容错能力。

**3.3.3Netflix Ribbon**：客户端负载均衡的服务调用组件。

**3.3.4Netflix Feign**：基于 Ribbon 和 Hystrix 的声明式服务调用组件。

**3.3.5Netflix Zuul**：微服务网关，提供动态路由，访问过滤等服务。

**3.3.6Netflix Archaius**：配置管理 API，包含一系列配置管理 API，提供动
态类型化属性、线程安全配置操作、轮询框架、回调机制等功能。

**3.4Spring Cloud for Cloud Foundry**： 通 过 Oauth2 协 议 绑 定 服 务 到 CloudFoundry，CloudFoundry 是 VMware 推出的开源 PaaS 云平台。

**3.5SpringCloud Sleuth**：日志收集工具包，封装了 Dapper,Zipkin 和 HTrace
操作。

**3.6Spring Cloud Data Flow**：大数据操作工具，通过命令行方式操作数据流。

**3.7Spring Cloud Security**：安全工具包，为你的应用程序添加安全控制，主要 是指 OAuth2。

**3.8Spring Cloud Consul**：封装了 Consul 操作，consul 是一个服务发现与配 置工具，与 Docker 容器可以无缝集成。

**3.9Spring Cloud Zookeeper** ： 操 作 Zookeeper 的 工 具 包 ， 用 于 使 用 zookeeper 方式的服务注册和发现。

**3.10Spring Cloud Stream**：数据流操作开发包，封装了与 Redis,Rabbit、 Kafka 等发送接收消息。

**3.11Spring Cloud CLI**：基于 Spring Boot CLI，可以让你以命令行方式快速
建立云组件。

##### SpringCloud 版本说明

常见版本号说明

软件版本号：2.0.2.RELEASE
主版本号。当功能模块有较大更新或者整体架构发生变化时，主版本号会更新 0：

次版本号。次版本表示只是局部的一些变动。 

修改版本号。一般是 bug 的修复或者是小的变动 RELEASE:希腊字母版本号。次版本号用户标注当前版本的软件处于哪个开发阶段

##### 希腊字母版本号

Base：设计阶段。只有相应的设计没有具体的功能实现。

Alpha：软件的初级版本。存在较多的 bug 

Bate：表示相对 alpha 有了很大的进步，消除了严重的 bug，还存在一些潜在的 bug。 

Release：该版本表示最终版。

##### SpringCloud 版本号说明

**为什么 SpringCloud 版本用的是单词而不是数字**

设计的目的是为了更好的管理每个 SpringCloud 的子项目的清单。避免子的版本号与子 项目的版本号混淆。

**版本号单词的定义规则**

采用伦敦的地铁站名称来作为版本号的命名，根据首字母排序，字母顺序靠后的版本号 越大。

一般使用 SR 版本的  意思是正式发布版本

子项目还是正常的数字版本

##### Dubbo 和 SpringCloud区别

+ 通信方式
  + dubbo是根据RPC进行通信  是基于二进制的传输方式 所以说性能和速度要好一些
  + springCloud是根据RestApi进行通信的也是基于HTTP的 所以说想能和速度要慢一些
+ 服务完整性
  + SpringCloud是一套完整的服务解决方案 提供了一站式的微服务集合
  + Dubbo 是一个服务框架 如果需要其他的微服务支持还需要依赖其他技术或者自己研发

##### 交流网址 中国社区

http://springCloud.cn

https://springcloud.cc

### RabbitMQ

####安装RabbitMQ

**首先安装Erlang**

+ Erlang 是一个运行环境  是由瑞典的爱立信公司开发的一个面向并发的运行环境
+ 安装RabbitMQ
+ 安装Web控制面板
+ 添加用户
+ 设置权限

```shell
安装Erlang
由于RabbitMQ依赖Erlang， 所以需要先安装Erlang。
Erlang的安装方式大概有两种：
1. 从Erlang Solution安装(此方式安装的erlang版本较高,和下文教程中rabbitMQ的版本不一致,建议安装高版本的rabbitMQ) 
# 添加erlang solutions源
 $ wget https://packages.erlang-solutions.com/erlang-solutions-1.0-1.noarch.rpm
 $ sudo rpm -Uvh erlang-solutions-1.0-1.noarch.rpm
 
 $ sudo yum install erlang

/* 优先采用 */
2. 从EPEL源安装(此方式安装的Erlang版本可能不是最新的，有时候不能满足RabbitMQ需要的最低版本)


 # 启动EPEL源
 $ sudo yum install epel-release 
 # 安装erlang
 $ sudo yum install erlang 


二、安装RabbitMQ Server
1.安装准备，下载RabbitMQ Server
	wget http://www.rabbitmq.com/releases/rabbitmq-server/v3.5.1/rabbitmq-server-3.5.1-1.noarch.rpm
2.安装RabbitMQ Server
	rpm --import http://www.rabbitmq.com/rabbitmq-signing-key-public.asc
	yum install rabbitmq-server-3.5.1-1.noarch.rpm
	
三、启动RabbitMQ
1.配置为守护进程随系统自动启动，root权限下执行:
	chkconfig rabbitmq-server on
2.启动rabbitMQ服务
	/sbin/service rabbitmq-server start


四、安装Web管理界面插件
1.安装命令
	rabbitmq-plugins enable rabbitmq_management
2.安装成功后会显示如下内容
	The following plugins have been enabled:
	  mochiweb
	  webmachine
	  rabbitmq_web_dispatch
	  amqp_client
	  rabbitmq_management_agent
	  rabbitmq_management
	Plugin configuration has changed. Restart RabbitMQ for changes to take effect.

五、设置RabbitMQ远程ip登录
这里我们以创建个oldlu帐号，密码123456为例，创建一个账号并支持远程ip访问。
1.创建账号
	rabbitmqctl add_user oldlu 123456
2.设置用户角色
	rabbitmqctl  set_user_tags  oldlu  administrator
3.设置用户权限
	rabbitmqctl set_permissions -p "/" oldlu ".*" ".*" ".*"
4.设置完成后可以查看当前用户和角色(需要开启服务)
	rabbitmqctl list_users
	
浏览器输入：serverip:15672。其中serverip是RabbitMQ-Server所在主机的ip。
```

####为什么要使用RabbitMQ消息队列?

+ 同步变异步	
  + 假设一个订单系统 订单成功之后需要发短信 发邮件 等操作 是同步的话就需要等待操作 全部结束之后才返回给用户 就增长的用户的等待时间 如果使用MQ系统的话 我们可以直接将发送短信邮件的业务交给MQ系统去处理 我们接受到订单系统处理之后就直接返回给用户订单成功了
+ 解耦
  + 原本我们的每个模块都是直接耦合的 使用MQ之后 我们的订单服务就只需要请求MQ即可 具体的操作由MQ系统完成 接触我们的订单系统和其他模块的耦合度
+ 流量削峰
  + 在秒杀服务中 我们通过MQ的消息队列 可以对大并发流量进行控制 从而抑制大量的请求涌向服务器 造成服务器宕机

####RabbitMQ 第一个案例

+ rabbitMQ 使用客户端进行链接的时候的监听端口是 5672

##### 第一步  导入  jar

```xml
<dependency>
    <groupId>org.springframework.boot</groupId>
    <artifactId>spring-boot-starter-amqp</artifactId>
</dependency>
```

##### 第二步 配置环境

```properties
spring.rabbitmq.host=192.168.190.140
spring.rabbitmq.port=5672
spring.rabbitmq.username=admin
spring.rabbitmq.password=123456
```

##### 使用

首先需要创建队列

```java
@Configuration
public class RabbitMQConfig {

    @Bean
    public Queue createQueue(){
        return new Queue("hello-rabbitMq");
    };

}
```

创建生产者

```java
import org.springframework.amqp.core.AmqpTemplate;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Component;

import javax.annotation.Resource;

@Component
public class sender {

    @Resource
    private AmqpTemplate rabbitMQTemplate;

    public void send(String msg){
        this.rabbitMQTemplate.convertAndSend("hello-rabbitMq",msg);
    }

}
```

创建消费者

```java
import org.springframework.amqp.rabbit.annotation.RabbitListener;
import org.springframework.stereotype.Component;

@Component
public class consumer {

    @RabbitListener(queues = "hello-rabbitMq")
    public void getMsg(String msg){
        System.out.println("consumer : " + msg);
    }

}
```

然后进行测试

```java
@RunWith(SpringRunner.class)
@SpringBootTest
public class SpringbootMqApplicationTests {

    @Autowired
    private sender sender;

    @Test
    public void contextLoads() {
        this.sender.send("测试消息");
    }

}
```

##### 原理

原理图

![1561428237519](assets/1561428237519.png)

**组件信息**

+ Message
  + 是生产者传输到消费者的数据 中间的传递方式是二进制的形式进行传递 消息包含了消息头和消息体 消息头是由一系列可选的属性组成  例如 路由键(Routing-key)  优先权的设置priority  持久化存储delivery-mode等	
+ Publisher 
  + 消息的生产者。也是一个向交换器发布消息的客户端应用程序。 
+ Consumer
  + 消息的消费者。表示一个从消息队列中取得消息的客户端应用程序
+ Exchange
  + 交换器。用来接收生产者发送的消息并将这些消息路由给服务器中的队列。
  +  三种常用的交换器类型 
    + **direct(发布与订阅 完全匹配)** 
    + **fanout(广播)** 
    + **topic(主题，规则匹配)** 
+ Binding 
  + 绑定。**用于消息队列和交换器之间的关联。一个绑定就是基于路由键将交换器和消息 队列连接起来的路由规则**
+ Queue 
  + 消息队列。用来保存消息直到发送给消费者。它是消息的容器，也是消息的终点。一 个消息可投入一个或多个队列。消息一直在队列里面，等待消费者链接到这个队列将其取 
+ Routing-key  
  + 路由键。RabbitMQ 决定消息该投递到哪个队列的规则。 队列通过路由键绑定到交换器。 消息发送到 MQ 服务器时，消息将拥有一个路由键，即便是空的，RabbitMQ 也会将其 和绑定使用的路由键进行匹配。 如果相匹配，消息将会投递到该队列。 如果不匹配，消息将会进入黑洞
+ Connection 
  + 链接。指 rabbit 服务器和服务建立的 TCP 链接
+ Channel 
  + 信道。
    +  Channel 中文叫做信道，是 TCP 里面的虚拟链接。例如：电缆相当于 TCP，信道是 一个独立光纤束，一条 TCP 连接上创建多条信道是没有问题的。 
    + TCP 一旦打开，就会创建 AMQP 信道。
    + 无论是发布消息、接收消息、订阅队列，这些动作都是通过信道完成的。 
+ Virtual Host
  + 虚拟主机。表示一批交换器，消息队列和相关对象。虚拟主机是共享相同的身份认证 和加密环境的独立服务器域。每个 vhost 本质上就是一个 mini 版的 RabbitMQ 服务器，拥有 自己的队列、交换器、绑定和权限机制。vhost 是 AMQP 概念的基础，必须在链接时指定， RabbitMQ 默认的 vhost 是/ 
+ Borker 
  + 表示消息队列服务器实体。
+ 交换器和队列的关系
  + 交换器是通过路由键和队列绑定在一起的，如果消息拥有的路由键跟队列和交换器的 路由键匹配，那么消息就会被路由到该绑定的队列中。 也就是说，消息到队列的过程中，消息首先会经过交换器，接下来交换器在通过路由 键匹配分发消息到具体的队列中。 路由键可以理解为匹配的规则
+ RabbitMQ 为什么需要信道？为什么不是 TCP 直接通信？
  + TCP 的创建和销毁开销特别大。创建需要 3 次握手，销毁需要 4 次分手。
  + 如果不用信道，那应用程序就会以 TCP 链接 Rabbit，高峰时每秒成千上万条链接 会造成资源巨大的浪费，而且操作系统每秒处理 TCP 链接数也是有限制的，必定造成性能 瓶颈
  + 信道的原理是一条线程一条通道，多条线程多条通道同用一条 TCP 链接。一条 TCP 链接可以容纳无限的信道，即使每秒成千上万的请求也不会成为性能的瓶颈

#####交换器

+ direct [ 发布与订阅 绝对匹配 ]
  + 可以不用在进行Queue的配置了 所以Config文件就不需要了

  + 整体需要的内容有

    +   交换器
    +   路由键
    +   队列名称

  + 生产者只需要知道路由键和交换器即可

  + 消费者需要知道交换器和路由键还有队列名称

  + ![1561446550427](assets/1561446550427.png)

  + 下面开始编写代码

    +   消费者 和  生产者 模块分开  独立部署 更易于管理 和发现 因为链接的都是一个RabbitMQ所以分开模块也没问题

  +   代码实例

      +   配置文件

      +   消费者配置

          +   ```properties
              spring.rabbitmq.host=192.168.190.140
              spring.rabbitmq.port=5672
              spring.rabbitmq.username=admin
              spring.rabbitmq.password=123456
              
              #配置交换器名称
              rabbitmq.config.exchange.name=exchange-info
              #配置info路由键
              rabbitmq.config.info.routing.key=rabbit.config.info.routing.key
              #配置info队列名
              rabbitmq.config.info.queue.name=info
              #配置error路由键
              rabbitmq.config.error.routing.key=rabbitmq.config.error.routing.key
              #配置error对列名
              rabbitmq.config.error.queue.name=error
              ```

      + 生产者配置

        + ```properties
          spring.rabbitmq.host=192.168.190.140
          spring.rabbitmq.port=5672
          spring.rabbitmq.username=admin
          spring.rabbitmq.password=123456
          
          #配置交换器名称
          rabbitmq.config.exchange.name=exchange-info
          #配置info路由键
          rabbitmq.config.info.routing.key=rabbit.config.info.routing.key
          #配置error路由键
          rabbitmq.config.error.routing.key=rabbitmq.config.error.routing.key
          ```

      + 生产者代码

      +    ```java
          package com.rabbitmq.provider;
          
          import org.springframework.amqp.core.AmqpTemplate;
          import org.springframework.beans.factory.annotation.Autowired;
          import org.springframework.beans.factory.annotation.Value;
          import org.springframework.stereotype.Component;
          
          import javax.annotation.Resource;
          
          @Component
          public class provider {
          
              @Resource
              private AmqpTemplate amqpTemplate;
              @Value("${rabbitmq.config.exchange.name}")
              private String exchange;
              @Value("${rabbitmq.config.info.routing.key}")
              private String routingKey;
          
              public void sender(String msg){
                  // 参数一   交换器名称
                  // 参数二   路由键名称
                  // 参数三   消息内容
                  System.out.println("123456789");
                  amqpTemplate.convertAndSend(exchange,routingKey,msg);
              }
          }
          ```

      + 消费者代码

      +   ```java
          // info 日志 操作 队列1
          
          package com.rabbitmq.provider;
          
          import org.springframework.amqp.core.ExchangeTypes;
          import org.springframework.amqp.rabbit.annotation.*;
          import org.springframework.stereotype.Component;
          
          @Component
          @RabbitListener(
              bindings = @QueueBinding(
                  value=@Queue(value = "${rabbitmq.config.info.queue.name}",autoDelete = "true"),
                  exchange = @Exchange(value = "${rabbitmq.config.exchange.name}",type = ExchangeTypes.DIRECT),
                  key = "${rabbitmq.config.info.routing.key}"
              )
          )
          public class consumer {
          
              @RabbitHandler
              public void consumers(String msg){
                  System.out.println("Info : "+ msg);
              }
          
          }
          ```

      +   ```java
          // error 操作 日志 队列2
          
          package com.rabbitmq.provider;
          
          import org.springframework.amqp.core.ExchangeTypes;
          import org.springframework.amqp.rabbit.annotation.*;
          import org.springframework.stereotype.Component;
          
          @Component
          @RabbitListener(
                  bindings = @QueueBinding(
                          value=@Queue(value = "${rabbitmq.config.error.queue.name}",autoDelete = "true"),
                          exchange = @Exchange(value = "${rabbitmq.config.exchange.name}",type = ExchangeTypes.DIRECT),
                          key = "${rabbitmq.config.error.routing.key}"
                  )
          )
          public class consumer_error {
          
                @RabbitHandler
                public void consumers(String msg){
                    System.out.println("error : "+ msg);
                }
          
          }
          ```

      +   测试代码

      +   ```java
          @RunWith(SpringRunner.class)
          @SpringBootTest
          public class ApplicationTests {
          
              @Resource
              private provider provider;
          
              @Test
              public void contextLoads() throws InterruptedException {
                  for(;;){
                      Thread.sleep(1000);
                      provider.sender("Hello direct");
                  }
              }
          
          }
          ```

+ topic  [主题  模糊匹配]

  + 是一个能够进行模糊匹配的队列 不再是想direct那样一个服务对应有一个队列 

  + 可以进行模糊匹配多个服务可以进入同一个队列中也可以进入到不同的队列中

  + 根据路由键进行模糊匹配的操作 例如路由键是  *.log.info          在发送的时候传递路由键product.log.info|order.log.info ........

  + 配置信息

  + ```properties
    # 生产者配置
    spring.rabbitmq.host=192.168.190.140
    spring.rabbitmq.port=5672
    spring.rabbitmq.username=admin
    spring.rabbitmq.password=123456
    
    #配置交换器名称
    rabbitmq.config.exchange.name=exchange-info
    
    #路由键可以配置  也可以写死
    
    
    # 消费者配置
    spring.rabbitmq.host=192.168.190.140
    spring.rabbitmq.port=5672
    spring.rabbitmq.username=admin
    spring.rabbitmq.password=123456
    
    #配置交换器名称
    rabbitmq.config.exchange.name=exchange-info
    
    #info 队列名称
    rabbitmq.config.queue.info=queue.info
    
    
    #路由键可以配置  也可以写死
    
    #error 队列名称
    rabbitmq.config.queue.error=queue.error
    ```

  + 生产者代码

  + ```java
    /**
     *  订单模块
     */
    @Component
    public class orderModule {
        @Autowired
        private AmqpTemplate amqpTemplate;
        @Value("${rabbitmq.config.exchange.name}")
        private String exChangeName;
        public void sender(String msg){
            /**
                 * 这里的路由键是写死的  到时候通过消费者进行模糊匹配
                 */
            this.amqpTemplate.convertAndSend(exChangeName,"orderModule.log.info","order.log.info:" + msg);
            this.amqpTemplate.convertAndSend(exChangeName,"orderModule.log.error","order.log.error:" + msg);
            this.amqpTemplate.convertAndSend(exChangeName,"orderModule.log.debug","order.log.error:"+msg);
        }
    }
    /**
     * 商品模块
     */
    public class productModule {
    
        @Autowired
        private AmqpTemplate amqpTemplate;
    
        @Value("${rabbitmq.config.exchange.name}")
        private String exChangeName;
    
        public void sender(String msg){
            /**
             * 这里的路由键是写死的  到时候通过消费者进行模糊匹配
             */
                                this.amqpTemplate.convertAndSend(exChangeName,"productModule.log.info","order.log.info:" + msg);
                                this.amqpTemplate.convertAndSend(exChangeName,"productModule.log.error","order.log.error:" + msg);
                                this.amqpTemplate.convertAndSend(exChangeName,"productModule.log.debug","order.log.error:"+msg);
                            }
    }
    ```

  + 消费者代码

  + ```java
    // allConsumer 代码
    @RabbitListener(
        bindings = @QueueBinding(
            value = @Queue(value = "${rabbitmq.config.all.queue.name}",autoDelete = "true"),
            exchange = @Exchange(value = "${rabbitmq.config.exchange.name}",type = ExchangeTypes.TOPIC),
            key = "*.log.*"
        )
    )
    @Component
    public class allConsumer {
        @RabbitHandler
        public void consumers(String msg){
            System.out.println(msg);
        }
    }
    // info Consumer
    @RabbitListener(
        bindings = @QueueBinding(
            value = @Queue(value = "${rabbitmq.config.info.queue.name}",autoDelete = "true"),
            exchange = @Exchange(value = "${rabbitmq.config.exchange.name}",type = ExchangeTypes.TOPIC),
            key = "*.log.info"
        )
    )
    public class orderConsumer {
        @RabbitHandler
        public void consumers(String msg){
            System.out.println(msg);
        }
    }
    
    //error Consumer
    
    @RabbitListener(
        bindings = @QueueBinding(
            value = @Queue(value = "${rabbitmq.config.error.queue.name}",autoDelete = "true"),
            exchange = @Exchange(value = "${rabbitmq.config.exchange.name}",type = ExchangeTypes.TOPIC),
            key = "*.log.error"
        )
    )
    public class productConsumer {
        @RabbitHandler
        public void consumers(String msg){
            System.out.println(msg);
        }
    }
    
    
    ```

+ fanout [广播]
  + 没有路由键

  + 可以向所有队列进行广播
  + 有交换器 同一个交换器的所有队列 可以接受到消息
  + 配置文件
    + 生产者

    + ```properties
      spring.rabbitmq.host=192.168.190.140
      spring.rabbitmq.port=5672
      spring.rabbitmq.username=admin
      spring.rabbitmq.password=123456
      
      #配置交换器名称
      rabbitmq.config.exchange.name=exchange-fanout
      ```

    + 消费者

    + ```properties
      spring.rabbitmq.host=192.168.190.140
      spring.rabbitmq.port=5672
      spring.rabbitmq.username=admin
      spring.rabbitmq.password=123456
      
      #配置交换器名称
      rabbitmq.config.exchange.name=exchange-fanout
      #配置sms队列名
      rabbitmq.config.sms.queue.name=sms
      #配置push对列名
      rabbitmq.config.push.queue.name=push
      ```

    + 生产者代码

    + ```java
      @Component
      public class sender {
             @Resource
             private AmqpTemplate amqpTemplate;
             @Value("${rabbitmq.config.exchange.name}")
             private String exchangeName;
             public void senders(String msg){
                  amqpTemplate.convertAndSend(exchangeName,"","数据");
             }
      }
      ```

    + 消费者代码

    + ```java
      // push 队列
      @Component
      @RabbitListener(
              bindings = @QueueBinding(
                      value = @Queue("${rabbitmq.config.sms.queue.name}"),
                      exchange = @Exchange(value = "${rabbitmq.config.exchange.name}",type = ExchangeTypes.FANOUT)
              )
      )
      public class pushConsumer {
               @RabbitHandler
               public void consumers(String msg){
                       System.out.println("push数据了");
               }
      }
      
      // sms 队列
      
      @Component
      @RabbitListener(
              bindings = @QueueBinding(
                      value = @Queue("${rabbitmq.config.push.queue.name}"),
                      exchange = @Exchange(value = "${rabbitmq.config.exchange.name}",type = ExchangeTypes.FANOUT)
              )
      )
      public class smsConsumer {
               @RabbitHandler
               public void consumers(String msg){
                   System.out.println("发送邮件");
               }
      }
      
      ```

    + 测试代码

    + ```java
      @RunWith(SpringRunner.class)
      @SpringBootTest
      public class ApplicationTests {
          @Resource
          private sender sender;
          @Test
          public void contextLoads() {
               this.sender.senders("数据");
          }
      }
      ```

#### 松耦合设计

+ 需要符合开闭原则  添加代码允许  修改代码不允许
+ 使用消息中间件之后呢就不需要再去修改provider中的代码了 只需要让我们新增的功能订阅某一个服务即可
+ 使用fanout方便一些

#### 消息持久化

+ 将@Queue中的autoDelete设置成false就可以进行数据持久化消费了 当我们的消费者宕机后 再次重新连接上 还是会消费我们宕机之间没直接接受消费的消息  RabbitMQ是将数据存在了RabbitMq的内存中去的 如果将值设置成false的话 那么所有消费者断开连接之后 队列也不会被删除 否则反之

+ @exChange中也有autoDelete取值也是true和false 不同的使是意思是是否删除交换器

+ 代码

  + ```java
    @RabbitListener(
        bindings = @QueueBinding(
            value=@Queue(value = "${rabbitmq.config.error.queue.name}",autoDelete = "false"), // 这里重点
            exchange = @Exchange(value = "${rabbitmq.config.exchange.name}",type = ExchangeTypes.DIRECT),
            key = "${rabbitmq.config.error.routing.key}"
        )
    )
    public class consumer_error {
    
        @RabbitHandler
        public void consumers(String msg){
            System.out.println("error : "+ msg);
        }
    
    }
    ```

#### 消息确认机制

+ RabbitMQ 中默认是ACK机制 默认是开启的

+ 是为了保证发送的消息能够被消费者消费

+ 如果RabbitMQ接收不到ACK的反馈信息 那么就会一直重发消息 知道沾满RabbitMQ内存 造成内存泄漏问题

+ 那么就应该来处理这样的问题

  + 使用try catch 来捕获

  + 添加响应的配置来限制重试的次数

    + 配置内容

    + ```properties
      spring.rabbitmq.listener.retry.enabled=true
      spring.rabbitmq.listener.retry.max-attempts=5
      ```

### Eureka

##### 什么是服务注册中心?

+ 服务注册中心是实现服务化管理的核心组件  主要用来存储服务信息 服务注册中心是SOA架构中基础的设施之一

##### 作用?

+ 服务的注册
+ 服务的发现

#####解决了什么问题

+ 服务管理
  + 当服务群体庞大的时候 每一个服务的IP和端口号是记不住的 所以需要服务注册中心来帮助我们解决这个问题
+ 服务与服务之间的依赖关系
  + 一个微服务项目中  每一个服务肯定是有相互依赖的 很少有没有依赖单独完成一个功能的 这些依赖关系可能会非常复杂 那么通过注册中心 我们可以全部注册到注册中心中 然后通过在注册中心中调用具体的服务即可

##### 什么是Eureka注册中心?

+ 是NetFix开发的服务发现组件 本身就是一个服务 不过后来SpringCloud将他集成到了子项目spring-cloud-netfix中 以实现Spring Cloud 的服务注册与发现 同时还提供了 负载均衡 故障转移等能力

###### 三种角色

**Eureka Server **

是一个服务注册发现的平台 整个服务的注册和发现都是在这个服务器完成

**Application Service [ Service Provider ] **

+ 应用服务程序提供方
+ 能够把自身的服务注册到Eureka注册中心中去

**Application Client [ Service Consumer ]**

+ 应用服务调用方
+ 能够调用在Eureka服务器中已经注册过的服务 进行消费

##### 优化服务信息

+ 设置服务的INFO信息展示

+ 导入依赖

+ ```xml
  <dependency>
      <groupId>org.springframework.boot</groupId>
      <artifactId>spring-boot-starter-actuator</artifactId>
  </dependency>
  ```

+ 修改父工程POM

+ ```xml
  <build>
      <finalName>parent</finalName>
      <resources>
          <resource>
              <directory>src/main/resource</directory>
              <filtering>true</filtering>
          </resource>
      </resources>
      <plugins>
          <plugin>
              <groupId>org.apache.maven.plugins</groupId>
              <artifactId>maven-resources-plugin</artifactId>
              <configuration>
                  <delimiters>
                      <delimit>$</delimit>
                  </delimiters>
              </configuration>
          </plugin>
      </plugins>
  </build>
  ```

+ 设置application.yml文件 展示信息

+ ```yml
  info:
     app.name: SpringCloud Study
     domain: http://liwenxiang.top
     module: provider01
     version: 1.0.0
  ```

+ 

#####入门案例

###### 编写 Eureka Server

需要增加的pom依赖

```xml
<dependencyManagement>
    <dependencies>
        <dependency>
            <groupId>org.springframework.cloud</groupId>
            <artifactId>spring-cloud-dependencies</artifactId>
            <version>${spring-cloud.version}</version>
            <type>pom</type>
            <scope>import</scope>
        </dependency>
    </dependencies>
</dependencyManagement>

<!-- 这个是eureka注册中心的服务器依赖 -->
<dependency>
    <groupId>org.springframework.cloud</groupId>
    <artifactId>spring-cloud-starter-netflix-eureka-server</artifactId>
</dependency>

<properties>
    <java.version>1.8</java.version>
    <spring-cloud.version>Edgware.SR6</spring-cloud.version>
</properties>
```
配置项

```properties
spring.application.name=eureka-server
server.port=8761
# 不注册自己 因为自己本身也是一个服务
eureka.client.register-with-eureka=false
# 不获取其他的注册信息  因为自己就是一个服务注册平台 其他的服务在本服务上调用服务
eureka.client.fetch-registry=false
```

启动类

```java
@EnableEurekaServer
@SpringBootApplication
public class EurekaServerApplication {
    public static void main(String[] args) {
            SpringApplication.run(EurekaServerApplication.class, args);
    }
}
```

启动项目之后可以通过访问地址栏localhost:8761进入到Eureka控制面板界面中

#####搭建集群版的Eureka服务

名字规范  application-一般是域名.yml | application.一般是域名.properties

```properties
# 在集群中 下面的两个配置可以不需要了  因为单机版的Euraka是只有自己一个注册中心 集群的模式是有很多个注册中心的 我不注册到自己上面 可以注册到其他的节点上面 所以不会报错  住过加上了也没事 只不过是在Eureka的控制面板中看不到这两个服务而已

# -------------------------

# 不注册自己 因为自己本身也是一个服务
eureka.client.register-with-eureka=false
# 不获取其他的注册信息  因为自己就是一个服务注册平台 其他的服务在本服务上调用服务
eureka.client.fetch-registry=false

# --------------------------

#设置服务注册中心 指向一个注册中心  可以是自己 也可以是其他的注册中心  如果设置了不注册自己 那么就可以这样写自己的机器
#如果设置注册自己 就需要写成其他的节点了
eureka.instance.hostname=eureka2
eureka.client.serviceUrl.defaultZone=http://eureka1:8761/eureka

#模拟另一台机器  就是又一个配置文件了
eureka.instance.hostname=eureka1
eureka.client.serviceUrl.defaultZone=http://eureka2:8761/eureka

# 如果是本地测试  记得修改机器上的hosts文件进行DNS解析映射

```

在搭建集群版的Eureka Server 的时候 需要将hostname设置为本机的域名eureka.client.serviceUrl.defaultZone设置为注册的机器的地址 如果有多个机器中间以 , 隔开 每一个机器的最后必须加上/eureka这个文件夹否则可能不会连通   意思就是 假设你由三台机器  第一台机器需要将注册地址填写 2 和 3 的 2 要有 1 和 3 的 3要有 1 和 2 的  

##### 编写Provuder并注册到注册中心中

+ 需要有 starter-eureka 和   config 两个jar

**这是客户端的**

配置

```properties
spring.application.name=eureka-provider
server.port=8762
# 生产者 分别注册到我们两台Eureka节点中 在本地测试需要在hosts文件中进行映射
eureka.instance.hostname=localhost
eureka:
  client:
    service-url:
      defaultZone: http://localhost:7001/eureka
  	#个性化 服务id
  instance: 
  	instance-id: provider01-8001
  	#显示IP
  	prefer-ip-address: true    
eureka.client.service-url.defaultZone=http://eureka1:8761/eureka,http://eureka2:8762/eureka
```

启动类

```java
@EnableEurekaClient
@SpringBootApplication
public class EurekaServerApplication {
    public static void main(String[] args) {
        SpringApplication.run(EurekaServerApplication.class, args);
    }
}
```

编写服务代码

```java
@RestController
public class UserController {
         @RequestMapping("/getUser")
         public List<User> getUser(){
             List<User> user = new ArrayList<>();
             user.add(new User(1,"lisi",20));
             user.add(new User(2,"wangwu",22));
             user.add(new User(3,"wangwu",26));
             return user;
         }
}
```

##### 编写消费者代码并注册到注册中心

```properties
spring.application.name=eureka-provider
server.port=8762

#消费者 分别注册到我们两台Eureka节点中 在本地测试需要在hosts文件中进行映射 
eureka.client.service-url.defaultZone=http://eureka1:8761/eureka,http://eureka2:8762/eureka
```

调用服务

SpringMvc 中的 Http 请求

```java
@GetMapping("/api")
public String sender(String name){
    RestTemplate restTemplate = new RestTemplate();
    // 规整编码 ---------
    StringHttpMessageConverter stringHttpMessageConverter=new StringHttpMessageConverter(Charset.forName("UTF-8"));
    List<HttpMessageConverter<?>> list=new ArrayList<HttpMessageConverter<?>>();
    list.add(stringHttpMessageConverter);
    restTemplate.setMessageConverters(list);
    ParameterizedTypeReference<String> typeReference = new ParameterizedTypeReference<String>() {};
    // --------------
    ResponseEntity<String> res = restTemplate.exchange("http://www.baidu.com", HttpMethod.GET, null, typeReference);
    return res.getBody();
}	
```

Eureka Consumer 调用 Service  provider 服务

主要是在Service层中调用

```java
@Service
public class UserService {
    
    @Resource
    LoadBalancerClient loadBalancerClient;
    
    public List<User> getUsers(){
        // 获取Provider中提供的服务 根据URL进行获取  里面的参数是服务的名称
        ServiceInstance choose = this.loadBalancerClient.choose("eureka-provider");
        StringBuilder sb = new StringBuilder();
       // 在SpringCloud中服务的调用时通过URL的形式来调用的 
        sb.append("http://").append(choose.getHost()).append(":").append(choose.getPort()).append("/getUser");
        //SpringMvc中的RestTemplate可以进行网络请求
        RestTemplate restTemplate = new RestTemplate();
        ParameterizedTypeReference<List<User>> users = new ParameterizedTypeReference<List<User>>() {};
        ResponseEntity<List<User>> exchange = restTemplate.exchange(sb.toString(), HttpMethod.GET, null, users);
        return exchange.getBody();
    };	
}
```

控制器

```java
@RestController
public class UserController {

          @Resource
           UserService userService;

          @GetMapping("/api")
          public   List<User> sender(String name){
              return this.userService.getUsers();
          }
}
```

##### Eureka 架构图原理

概念性

首先我们需要由一个Eureka集群服务器来作为服务注册的平台

然后呢我们的provider向集群服务中去进行信息的注册 注册完毕之后就相当于在集群服务器中有了这

个服务 并且每隔30秒就会像服务器发送心跳信息 证明这台机器还是活着的 没有宕机

当我们的服务需要下面的时候可以先发送消息给集群服务器 然后集群服务器会将改provider的信息从注册列表中进行删除 以防止我们调用到不存在的服务 但是这里就是一个优雅停机的功能

默认的时候我们可能直接关掉服务 并不会给服务器发送自己下线的通知 所以就导致服务还存在注册列表中

图示

![1561607490312](assets/1561607490312.png)

##### CAP 定理

C  一致性

A  高可用性

P  分区容错性

是指在一个分布式系统中一致性 高可用性 分区容错性不可兼得

##### Zookeeper 和  Eureka 的区别

从CAP定理的角度来对比的话  Zookeeper保留了 CP  Eureka保留了 AP 两者都是保留了分区容错特性

Zookeeper中的C呢时数据一致性的保障 这也是它先天的一个优势  P 呢是通过主从复制的形式来保证的中的数据不会丢失 但是如果数据量过大在进行复制的时候可能就会造成等待时间过长从而放弃了A特性

Eureka呢没有保留数据的一致性而是保留了高可用性和分区容错性 之所以说Eureka具有高可用性是因为Eureka具有自我保护的功能 当一个服务没有在规定时间内发送心跳  那么Eureka就会进入保护状态 不会直接将其删除 那么在一定时间内 该服务又恢复了运作 即还可以正常工作 分区容错性是节点和节点之间传递数据的

Dubbo集成 Zookeeper 支持Dubbo   Eureka 不支持Dubbo

Spring Cloud 集成	Zookeeper 已支持     Eureka已支持

watch支持		    zookeeper是使用监听的方式来监视数据变化的    Eureka是使用轮询的方式来监视数据的变化的

KV服务	         zookeeper 支持数据存储 		Eureka不支持数据存储

使用接口 多语言能力	  zookeeper提供客户端   Eureka是使用Http多语言的

集群监控		 zookeeper不支持			Eureka可以使用Metries来监视集群状态

##### Eureka 比 zookeeper 好在哪里

+ 因此 综上所述 Eureka可以很好的应对网络故障失去部分节点 而zookeeper可能会使整个注册服务瘫痪

 ##### Eureka 自我保护

**自我保护的条件**

一般情况下，微服务在 Eureka 上注册后，会每 30 秒发送心跳包，Eureka 通过心跳来 判断服务时候健康，同时会定期删除超过 90 秒没有发送心跳服务

**有两种情况会导致 Eureka Server 收不到微服务的心跳**

是微服务自身的原因   也就是说的是单点故障

是微服务与 Eureka 之间的网络故障 

考虑到这个区别，Eureka 设置了一个阀值，当判断挂掉的服务的数量超过阀值时， Eureka Server 认为很大程度上出现了网络故障，将不再删除心跳过期的服务

**那么这个阀值是多少呢**

15 分钟之内是否低于 85%； Eureka Server 在运行期间，会统计心跳失败的比例在 15 分钟内是否低于 85% 这种算法叫做 Eureka Server 的自我保护模式。



关闭自我保护

```properties
#关闭自我保护:true 为开启自我保护，false 为关闭自我保护 
eureka.server.enableSelfPreservation=false 
#清理间隔(单位:毫秒，默认是 60*1000)  一分钟  时间到了然后就清理已经故障的节点机器
eureka.server.eviction.interval-timer-in-ms=60000
```

关闭之后在我们关闭的服务之后  服务就不会进行自我保护了

##### 服务的优雅停服

我们需要在我们需要进行优雅停服的服务中呢将客户端的依赖转为服务端的依赖 因为服务端的以来中包括了

- org.springframework.boot:spring-boot-starter-actuator:1.5.21.RELEASE 

这个jar 

**修改配置文件**

```properties
#启用 shutdown 
endpoints.shutdown.enabled=true 
#禁用密码验证   这是Eureka的机制 先关闭密码验证
endpoints.shutdown.sensitive=false
```

##### 使用POST请求访问shutdown接口优雅停服

首先如果需要优雅停服的话需要使用POST请求方法对你需要停服的服务进行请求

可以使用HTTPCLIENT发送请求

在项目中导入HTTPCLIENTUTIL类即可

```java
public static void main(String[] args) { 
	String url ="http://127.0.0.1:9090/shutdown"; 
	//该 url 必须要使用 dopost 方式来发送 
	HttpClientUtil.doPost(url); 
}
```

##### Eureka 的 安全认证

在 EurekaServer 中添加 security 包  只要添加了这个包 就需要设置账号密码了 否则可能进入不到eureka的控制面板

```properties
<dependency>
    <groupId>org.springframework.boot</groupId>
    <artifactId>spring-boot-starter-security</artifactId>
</dependency>
```

修改Eureka的Server配置 增加账号密码

```properties
#开启 http basic 的安全认证
security.basic.enabled=true
security.user.name=user
security.user.password=123456
```

 修改访问集群节点的 url

```properties
# 加入了安全认证 就需要在访问的时候加上账号和密码
eureka.client.serviceUrl.defaultZone=http://user:123456@eureka2:8761/eureka/
```

**修改微服务的配置文件添加访问注册中心的用户名与密码  因为你的一个微服务需要向注册中心进行注册 也是需要账号密码进行链接的 所以也是需要设置的   生产者和消费者都是需要添加账号密码的**

```properties
spring.application.name=eureka-provider server.port=9090

#设置服务注册中心地址，指向另一个注册中心 

eureka.client.serviceUrl.defaultZone=http://user:123456@eureka1:8761/eureka/,http://user:123456@eureka2:8761/eureka/

#启用 
shutdown endpoints.shutdown.enabled=true 

#禁用密码验证 
endpoints.shutdown.sensitive=false
```

### Ribbon

+ SpringCloud Ribbon 是基于NetFilx Ribbon 实现的一套客户端 负载均衡工具
+ 主要功能是提供客户端的软件负载均衡算法 
+ Ribbon 提供一系列完整的配置项 如链接超时 重试等
+ 就是在配置文件中列出Load Balancer 简称LB 后面的所有机器 Ribbbon会基于某种规则（轮询,随机，根据响应时间加权） 去连接这些机器
+ 可以使用Ribbon实现自定义的负载均衡算法
+ 集中式LB  
  + 偏硬件的
  + 例如F5
+ 进程内LB
  + 偏软件内的
  + 例如链接消费者和提供者 根据连接情况自动链接
  + Ribbon就属于进程内的LB 偏向消费方 通过他来获取服务器提供方的地址

##### 配置 依赖

```xml
<dependency>
    <groupId>org.springframework.cloud</groupId>
    <artifactId>spring-cloud-starter-eureka</artifactId>
    <version>1.3.1.RELEASE</version>
</dependency>
<dependency>
    <groupId>org.springframework.cloud</groupId>
    <artifactId>spring-cloud-starter-config</artifactId>
</dependency>
<dependency>
    <groupId>org.springframework.cloud</groupId>
    <artifactId>spring-cloud-starter-ribbon</artifactId>
</dependency>
```

##### 添加注解

+ 在configBean中添加@LoadBalanced注解 注入RestTemplate对象 实现负载均衡 进程内的负载均衡

+ ```java
  @Configuration
  public class ConfigBean {
      @Bean
      @LoadBalanced
      public RestTemplate getRestTemplate(){
          return new RestTemplate();
      }
  }
  ```

+ ```java
  # 我们可以通过服务的名称来请求服务地址 而不需要在通过ip和端口来进程请求 
  private static final String RIBBON_REST_URL_PREFIX = "http://provider-8001";
  ```

+ 启动类中添加 @EnableEurekaClient

##### 负载均衡

+ Ribbon可以通过服务的名称来进行负载均衡 轮询 每一个服务都可以有专属的数据库
+ 所以我们在创建微服务的时候需要将几个服务的服务名称需要设置为一致的
+ 至少两个服务或以上

##### Ribbon 核心组件

![1562213695217](assets/1562213695217.png)

使用

+ RoundRbinRule   轮询
+ RandomRule   随机
+ AvailabilityFilteringRule  会先过滤掉由于多次访问故障而处于断路器跳闸状态的服务 还有并发的链接数量超过阔值的服务  然后对剩余的服务列表按照轮形策略进行访问
+ WeightedResponseTimeRule  根据平均的响应时间计算所有服务的权重 响应时间越快服务权重越大被选中的概率就越高
+ RetryRule  先按照轮询策略获取服务 如果获取失败则在指定时间内会进行重试 获取可用的服务
+ BestAvailableRule  会先过滤掉由于多次访问故障而处于断路器跳闸状态的服务 然后选择一个并发量小的服务
+ ZoneAvoidanceRule  默认规则  符合判断Server所在区域的性能和server的可用性选择服务器

在configBean中配置以下即可

```java
@Configuration
public class ConfigBean {
    @Bean
    @LoadBalanced
    public RestTemplate getRestTemplate(){
        return new RestTemplate();
    }
	
    // 如果需要切换不同的负载均衡策略 那么就可以直接实例化不同的策略类 非常简单
    
    @Bean
    public IRule iRule(){
        //return new RoundRobinRule();
        return new RetryRule();
    }
}
```

##### 自定义Ribbon

+ 修改源码
+ 在启动类中添加@RibbonClient(name=服务名称,configuration=MyRule.class)
+ 注意 自定义的rule不能够和启动类防止在同一个包中或子包中 意思就是不能够放在@ComonentScan扫描的范围内
+ 自定义类需要继承 AbstractLoadBalancerRule 并且在类上标准为配置类   和 @Bean   方法返回值依旧是 IRule
+ https://github.com

### Feign

+ 是一个声明式的WebService客户端 使用Feign能让编写WebService更简单 他的使用方法是定义一个接口然后在上面添加注解 同时也支持JAX-RS标准的注解 Spring Cloud 对 Feign 进行了封装  使其支持了Springmcv标准注解 Feign可以和Eureka和Ribbon组合使用以支持负载均衡 Feign集成了Ribbon

##### feign 的使用

一般来说一个服务可能有很多个消费者 那么这个时候就需要将公共的代码提取出去  所以这里还是放到了一个公共的模块中去  然后使用Feign可以还是像以前一样面向接口编程  Feign会自动的根据名称去Eureka中找对应的服务 不需要在使用restTemplate了     使用就是编写一个接口 加上对应的注解 里面填写对应的服务名称即可   然后在feign客户端启动类添加上对应的注解以及扫描的包即可成功调用服务 在消费者的controller直接注入我们的feign客户端即可  调用里面的方法  就像以前一样 

**公共模块**

​	![1562293199160](assets/1562293199160.png)

**公共消费的服务接口**

```java
// 服务名称  不需要实现类   自动去注册中心请求服务 
@FeignClient("provider-8001")
public interface DeptClientService {
	
    // 这里的路径就是服务提供者的路径  根据服务名称Feign自动去Eureka中心请求服务
    @RequestMapping(value = "/dept/get/{id}",method= RequestMethod.GET)
    public Dept get(@PathVariable("id") Long id);

    @RequestMapping(value = "/dept/list",method= RequestMethod.GET)
    public List<Dept> list();

}
```

**消费者服务**

```java
@RestController
public class DeptConsumerController {

    // 注入我们的公共接口 直接调用service方法即可访问到我么的服务
     @Autowired
     private DeptClientService deptClientService;

    @RequestMapping(value = "/consumer/dept/get/{id}",method = RequestMethod.GET)
    public Dept get(@PathVariable("id") Long id){
        return this.deptClientService.get(id);
    }

    @RequestMapping(value = "/consumer/dept/list",method = RequestMethod.GET)
    public List<Dept> list(){
        return this.deptClientService.list();
    }

}
```

**启动类**

```java
@SpringBootApplication
@EnableEurekaClient
// 这个包就是我们的feign客户端接口所在的包 否则会注入不进去
@EnableFeignClients(basePackages = "com.micro")
public class App80 {
    public static void main(String[] args) {
        SpringApplication.run(App80.class,args);
    }
}
```

##### 在 Feign中使用其他均衡策略

+ 和在Ribbon中使用一样

+ ```java
  @Configuration
  public class myRule {
  
      @Bean
      public IRule iRule(){
          return new RandomRule();
      }
  }
  ```

### Hystrix

+ 主要来解决服务雪崩问题   在生产者中使用
+ 俗话说 我们一个微服务架构的系统 在应对高并发的情况下 先不说 可能A服务调用B服务调用C服务调用D服务最后在D服务这里出现问题了 那么这一整个调用链都在等待D服务进行响应 如果D服务没有响应或者跑出了客户端不理解的异常那么这时候就会造成服务拥堵 雪崩问题 不可用 达不到了高可用的境界 那么Cloud意识到这个问题 推出了Hystrix组件来使用我们的微服务架构进行容错 服务降级 断路等   

##### 服务熔断

+ 就是说添加一个备用响应  等到微服务出现故障之后进行返回

+ 是在服务端的 就是说是提供者方

+ 具体使用

+ POM XML

+ ```xml
  <dependency>
      <groupId>org.springframework.cloud</groupId>
      <artifactId>spring-cloud-starter-hystrix</artifactId>
  </dependency>
  ```

+ ```java
  @RestController
  public class ProductController {
  
      @Autowired
      private ProductService productService;
      
      // 加入注解 指定处理方法 备用响应
      @RequestMapping(value = "/product/getAllType")
      @HystrixCommand(fallbackMethod = "handler")
      public List<Product> findAllType(Integer parentId){
          if (parentId > 5){
              throw new RuntimeException();
          }
          return this.productService.findAllType(parentId);
      }
  
      // 处理方法
      public List<Product>  handler(Integer parentId){
          return Arrays.asList(new Product().setId(parentId).setName("出错误了"));
      }
  }
  ```

+ 启动类

+ ```java
  @SpringBootApplication
  @EnableEurekaClient
  //开启熔断机制
  @EnableCircuitBreaker
  public class App8001_Hystrix {
      public static void main(String[] args) {
          SpringApplication.run(App8001_Hystrix.class,args);
      }
  }
  ```

##### 服务降级

+ 服务降级是在客户端的就是消费方的

+ 是指我们的某一块的服务请求量比较大 我们先暂停某一些服务然后将请求压小 如果还有请求访问关闭掉的服务就给出一个友好的提示

+ 当我们的服务器DOWN掉之后 我们做了服务降级处理 让客户端在服务端不可用时也会获取到提示信息而不会耗死服务器

+ 配合Feign使用

+ 使用方法 

+ 首先在公共的API工程中新建一个DeptClientServiceFallbackFactory类实现FallbackFactory接口 泛型为需要降级的类的方法  返回值为重新new一个目标类

+ 代码

+ ```java
  @Component
  public class DeptClientServiceFallbackFactory implements FallbackFactory<DeptClientService> {
      @Override
      public DeptClientService create(Throwable cause) {
          return new DeptClientService() {
              @Override
              public Dept get(Long id) {
                  return new Dept().setD_name("服务已经关闭");
              }
  
              @Override
              public List<Dept> list() {
                  return null;
              }
          };
      }
  }
  ```

+ ```yml
  feign:
    hystrix:
      enabled: true
  ```

+ ```java
  @Configuration
  public class myRule {
  
      @Bean
      @Scope("prototype")
      public Feign.Builder feignHystrixBuilder() {
          return Feign.builder();
      }
  }
  ```

##### 服务监控

+ 创建一个监控项目 端口9001
+ 访问地址http://localhost:9001/hystrix

+ POM

+ ```xml
  <dependency>
      <groupId>org.springframework.cloud</groupId>
      <artifactId>spring-cloud-starter-hystrix</artifactId>
  </dependency>
  <dependency>
      <groupId>org.springframework.cloud</groupId>
      <artifactId>spring-cloud-starter-hystrix-dashboard</artifactId>
  </dependency>
  ```

+ 启动类

+ ```java
  @SpringBootApplication
  @EnableHystrixDashboard
  public class App_9001 {
      public static void main(String[] args) {
          SpringApplication.run(App_9001.class,args);
      }
  }
  ```

+ yml

+ ```yml
  server:
    port: 9001
  ```

+ 我们可以设置监视的地址进行监控   需要使用了Hystrix组件才能进行监控

+ http://localhost:8002/hystrix.stream   后面的后缀是必须要加的

+ 主要的就是有其中颜色  红色比较危险     

+ 一圈 一线

### Zuul[网关]

+ 包含了对请求的路由和过滤两个基本的功能

+ Zuul也是需要注册到Eureka中的  注册之后就会获取到eureka中的服务信息

+ 后续就是通过zuul对服务进行请求转发操作

+ 使用 POM

+ ```xml
  <dependency>
      <groupId>org.springframework.cloud</groupId>
      <artifactId>spring-cloud-starter-zuul</artifactId>
  </dependency>
  <dependency>
      <groupId>org.springframework.cloud</groupId>
      <artifactId>spring-cloud-starter-eureka</artifactId>
  </dependency>
  ```

+ 启动类

+ ```java
  @SpringBootApplication
  @EnableZuulProxy
  public class App_9999 {
      public static void main(String[] args) {
          SpringApplication.run(App_9999.class,args);
      }
  }
  ```

+ yml

+ ```yml
  server:
    port: 9999
  eureka:
    instance:
      hostname: myzuul.com
      instance-id: zuul
    client:
      service-url:
        defaultZone: http://eureka01.com:7001/eureka,http://eureka02.com:7002/eureka,http://eureka03.com:7003/eureka
  spring:
    application:
      name: zuul-request-9999
  ```

+ 成功访问

+ http://myzuul.com:9999/provider-8001/dept/get/1      通过路由进行访问

  + http://路由域名/服务名称/服务路径/参数	

+ **规则匹配**

  + ```properties
    zuul:
      routes:
        # mydept 是名字随便起   后面的是服务名称
        mydept.serviceId: provider-8001
        # 这是匹配的路径  使用 mydept 代替
        mydept.path: /mydept/**
    ```

  + 但是元素经还是能够访问

    + ```properties
      zuul:
        routes:
          mydept.serviceId: provider-8001
          mydept.path: /mydept/**
        # 使原路径不能访问  
        ignored-services: provider-8001
        # 忽略多个服务名字
        ignored-services: "*"
        # 设置前缀
      ```

+ http://myzuul.com:9999/lwx/mydept/dept/get/2  完整路径

### SpringCloud Config

+ 分布式配置中心

+ 是为微服务提供的一套集中式的外部配置支持 

+ 分为服务端和客户端两部分

  + **服务端**
    + 服务端也称分布式配置中心 他是一个独立的微服务应用 用来链接配置服务器并为客户端提供获取配置信息 加密解密等访问接口
  + **客户端**
    + 客户端则是通过指定的配置中心来管理应用资源以及业务相关的配置内容 并在启动时候从配置中心加载获取配置信息 配置服务器默认采用的是git

+ 作用？

  + 集中管理配置文件
  + 不同环境不同配置
  + 将配置信息以REST接口的形式暴露
  + 当配置发生变化时 服务不需要重启即可感知到服务配置的变化并更新成新的配置

+ ssh-keygen -t rsa -C "2857734156@qq.com"   生成sshkey

+ **使用**

+ 新建一个模块服务

+ POM.xml

+ ```xml
  <dependency>
      <groupId>org.springframework.cloud</groupId>
      <artifactId>spring-cloud-config-server</artifactId>
  </dependency>
  ```

+ 在GITHUB中创建一个仓库用来配置信息  上传yml配置文件内容

+ ```yaml
  spring:
    profiles:
      active:
      - dev
  ---
  spring:
    profiles: dev
    application:
      name: micro-dev-env
  ---
  spring:
    profiles: test
    application:
      name: micro-test-env
  ```

+ yml 文件

+ ```yaml
  server:
    port: 3324
  spring:
    application:
      name: config
    cloud:
      config:
        server:
          git:
            uri: https://github.com/liwenxaing/micro-config
  ```

+ 启动类

+ ```java
  @SpringBootApplication
  @EnableConfigServer
  public class App_3324_Config {
      public static void main(String[] args) {
          SpringApplication.run(App_3324_Config.class,args);
      }
  }
  ```

+ 通过REST风格接口访问

  + http://hostname:port/application-dev.yml
  + http://hostname:port/application-test.yml
  + http://hostname:port/application-pord.yml
  + http://config.com:3324/application/dev/master   这种返回的是JSON字符串

+ 会显示对应的内容

+ **config客户端使用**

+ 创建客户端工程

+ POM

+ ```xml
  <dependency>
      <groupId>org.springframework.cloud</groupId>
      <artifactId>spring-cloud-starter-config</artifactId>
  </dependency>
  <dependency>
      <groupId>org.springframework.boot</groupId>
      <artifactId>spring-boot-starter-web</artifactId>
  </dependency>
  ```

+ 上传客户端配置文件到github仓库

+ 使用 --- 隔开

+ yml内容样例

+ ```yaml
  server: 
    port: 8201
  spring: 
    profiles: dev
    application:
      name: micro-config-client
  eureka: 
    client: 
      service-url: 
        defaultZone: http://eureka-dev.com:7001/eureka/
  ---
  server: 
    port: 8202
  spring: 
    profiles: test
    application:
      name: micro-config-client
  eureka: 
    client: 
      service-url: 
        defaultZone: http://eureka-test.com:7001/eureka/	
  ```

+ 客户端配置文件

+ bootstrap.yml 系统级别配置 优先级更高

+ ```yaml
  spring:
    cloud:
       config:
          # 标识的是github中的配置文件的名称
          name: micro-config-client
          # 标识的是获取什么环境的配置
          profile: test
          # 分支
          label: master
          # 服务端配置地址  通过服务端的配置访问github中的配置信息
          uri: http://config.com:3324
  ```

+ application.yml 配置文件

+ ```yaml
  spring:
    application:
      name: micro-config-client
  ```

+ 启动类																																					

+ ```
  @SpringBootApplication
  public class App_3225_config_client_boot {
      public static void main(String[] args) {
          SpringApplication.run(App_3225_config_client_boot.class,args);
      }
  }
  
  ```


获取配置 在java中可以通过@Value注解获取到配置信息   这个时候我们的服务已经使用这个指定的配置了 所以我们能够获取到配置信息

```java
@RestController
public class MicroClientConfig {

       @Value("${spring.application.name}")
       private String applicationName;

       @Value("${eureka.client.service-url.defaultZone}")
       private String eurekaDefaultZone;

       @Value("${server.port}")
       private String port;

       @RequestMapping("/getConfig")
       public String getConfig(){
           String str = "applicationName"+applicationName+"\teurekaDefaultZone"+eurekaDefaultZone+"\tport"+port;
           System.out.println(str);
           return str;
       }
}
```