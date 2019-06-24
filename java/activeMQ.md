## ActiveMQ笔记

### Java Queue

```java
Queue
  　 add        增加一个元索                      如果队列已满，则抛出一个IIIegaISlabEepeplian异常
　　 remove   移除并返回队列头部的元素    		如果队列为空，则抛出一个NoSuchElementException异常
   element  返回队列头部的元素             		如果队列为空，则抛出一个NoSuchElementException异常
　　 offer       添加一个元素并返回true           如果队列已满，则返回false
　　 poll         移除并返问队列头部的元素         如果队列为空，则返回null
　　 peek       返回队列头部的元素                如果队列为空，则返回null
　　 put         添加一个元素                     如果队列满，则阻塞
　　 take        移除并返回队列头部的元素          如果队列为空，则阻塞
```

### JMS

+ Java消息服务
+ 是一种规范  许多消息中间件都遵循了这个规范
+ 消息是两台计算机间传送的的数据单位 消息可以非常简单  可以只包含文本字符串也可以更复杂
+ 消息被发送到队列中 消息队列是在消息的传输过程中保存信息的容器 
+ 消息队列的主要特点是异步的  主要目的是减少请求响应时间的解耦
+ 分流   压力分流

### Active简介

+ 多语言客户端支持  PHP PREL PYTHON JAVA C C++ C# RUBY
+ 完全支持JMS1.1协议和J2EE1.4规范
+  对Spring支持很好 可以很好的集成到Spring中去
+ 支持多种传送协议  in-VM TCP UDP SSL JXTA
+ 支持集群

### 术语

+ **Destination**
  + 目的地   JMS provider 负责维护 用于对Message进行管理的对象Message Producer 需要指定Destination才可以发送消息   Message Consumer 需要指定Destination才可以接受消息
+ **Producer**
  + 消息生成者 负责发送消息到目的地  应用接口为 MessageProducer
+ **Consumer**
  + 消息接收者   负责从目的地中接受消息  应用接口欸MessageConsumer
+ **Message**
  + 消息 消息封装一次通信内容 常见的类型呦 StreamMessage  BytesMessage TextMessage
  + ObjectMessage MapMessage
+ **ConnectionFactory**
  + 链接工厂  用于创建链接的工厂
+ **Destination**
  + 链接  用于建立访问ActiveMQ链接的类型 由链接工厂创建
+ **Session**
  + 一次会话 一次持久有效有状态的会话 由链接创建 一个链接可以创建多个会话
+ **Queue &  Topic**
  + Queue 是队列目的地
    + 特点  队列中的消息   默认只能被一个消费者进行处理  处理完毕之后就进行删除
  + Topic 是主体目的地 
    + 特点   会发送给所有消费者进行处理
  + 都是Destination的子接口
+ **PTP**
  + 点到点消息模型
    + 一般使用Queue实现
+ **PUB & SUB**
  + 发布订阅模型
    + 一般使用Topic实现

### 安装ActiveMQ

+ 版本问题
  + 如果使用activeMQ 5.10.x 必须使用jdk1.8+才能正常使用
+ 默认端口
  + 8161
+ 默认用户
  + admin admin
  + user user
+ 主要配置文件
  + activemq.xml
  + jetty.xml
  + jetty-realm.properties
  + users.properties
  + group.properties
+ 服务器
  + activemq默认有一个网络版的控制台 
  + 是个war工程 所以需要部署到Servlet容器中这里采用的是jetty服务器
  + 端口在jetty.xml中设置  jettyport
+ 启动mq
  + 移动到bin目录下 activemq start 即可
  + 关闭 activemq stop
  + 查看状态 activemq  status
  + jps
    + 查看进程
+ 前提
  + 需要安装JDK

### PTP模型

+ 端到端
  + 一般使用queue形式的队列模型

+ 代码操作

  + 消息发送者  自动消费

  + ```java
    package top.liwenxiang.test;
    
    
    import org.apache.activemq.ActiveMQConnectionFactory;
    
    import javax.jms.*;
    
    public class test {
        /**
         * 消息发送者
         * @param datas
         */
        public  void sendMessage(String datas) throws JMSException {
            /**
             * 链接工厂
             */
            ConnectionFactory connectionFactory = null;
            /**
             * 链接
             */
            Connection connection = null;
            /**
             * 目的地
             */
            Destination destination = null;
            /**
             * 会话
             */
            Session session = null;
            /**
             * 消息发送者
             */
            MessageProducer producer = null;
            /**
             * 消息对象
             */
            Message message = null;
    
            //创建链接工厂 链接ActiveMQ服务的链接工厂
            //创建工厂 构造方法有三个参数 分别是用户名  密码   链接地址
            //无参构造  有默认的链接地址  本地连接 localhost
            //单参构造器  五无验证模式的  没有用户的认证
            //三参数构造器  有认证+指定地址
            //61616 默认端口
            connectionFactory =  new ActiveMQConnectionFactory("guest","guest",
                    "tcp://192.168.190.133:61616");
            //通过工厂 创建链接对象
            //创建链接的方法有重载   createConnection（username,password）
            connection = connectionFactory.createConnection();
            connection.start();
            //通过链接对象  创建会话对象
            //创建会话的时候 必须要指定两个参数  用来确定是否自持事务 以及 如何确认消息处理
            //  true 支持事务
            //  false 不支持事务
            //  AUTO_ACKNOWLEDGE  自动确认消息  消费者自动确认 自动处理消息  常用
            //  CLIENT_ACKNOWLEDGE  客户端手动确认 消息的消费者处理后必须手动确认
            //  DUPS_OK_ACKNOWLEDGE   一个消息可以处理多次 可以降低Session的消耗 在可以容忍重复消息时使用 不推荐使用
            session = connection.createSession(false, Session.CLIENT_ACKNOWLEDGE);
            //创建目的地  参数时唯一标识
            destination = session.createQueue("first-mq");
            //创建发送者 指定目的地
            producer = session.createProducer(destination);
            //创建文本消息对象  作为具体数据传输的载体
            message = session.createTextMessage(datas);
            producer.send(message);
            System.out.println("发送消息");
        }
    
    
        public static void main(String[] args) {
            test d = new test();
            try {
                d.sendMessage("firstMq Content");
            } catch (JMSException e) {
                e.printStackTrace();
            }
        }
    }
    ```

  + 消息接受者（消费者）

    + ```java
      package top.liwenxiang.test;
      
      
      
      import org.apache.activemq.ActiveMQConnectionFactory;
      
      import javax.jms.*;
      
      
      public class testConsumer {
      
          static  ConnectionFactory connectionFactory;
          static Connection connection;
          static Session session;
          static Destination destination;
          static MessageConsumer messageConsumer;
          static Message message;
      
          public static void main(String[] args) throws JMSException {
                  /*
                  * ActiveMQ 发送消息
                  **/
                  connectionFactory = new ActiveMQConnectionFactory("guest","guest",
                          "tcp://192.168.190.133:61616");
                  connection = connectionFactory.createConnection();
                  connection.start();
                  session = connection.createSession(false,Session.AUTO_ACKNOWLEDGE);
                  destination = session.createQueue("first-mq");
                   messageConsumer =  session.createConsumer(destination);
                   message = messageConsumer.receive();
                  String text = ((TextMessage) message).getText();
                  System.out.println(text);
          }
      }
      ```

+ 手动消费

  + producer	 

    ```java
    	import javax.jms.Connection;
    import javax.jms.ConnectionFactory;
    import javax.jms.Destination;
    import javax.jms.JMSException;
    import javax.jms.Message;
    import javax.jms.MessageProducer;
    import javax.jms.Session;
    import org.apache.activemq.ActiveMQConnectionFactory;
    public class test01 {
        public static void main(String[] args) throws JMSException {
    		 ConnectionFactory factory;
    		 Connection  conn;
    		 Session session;
    		 Destination des;
    		 MessageProducer producer;
    		 Message  message;
    
        factory = new ActiveMQConnectionFactory("guest","guest","tcp://192.168.190.133:61616");
    	 conn = factory.createConnection();
    	 session = conn.createSession(false, Session.CLIENT_ACKNOWLEDGE);
    	 des = session.createQueue("test-message");
    	 producer = session.createProducer(des);
    	 //发送一百条消息
    	 for(int i = 0 ; i < 100 ; i ++){
    		 Integer data = new Integer(i);
    		 //里面的参数data必须是一个可序列化的类型
    		 message = session.createObjectMessage(data);
    		 producer.send(message);
    	 }
    }
        }
    ```

  + consumer

    ```java
    		import java.io.Serializable;
    
    import javax.jms.Connection;
    import javax.jms.ConnectionFactory;
    import javax.jms.Destination;
    import javax.jms.JMSException;
    import javax.jms.Message;
    import javax.jms.MessageConsumer;
    import javax.jms.MessageListener;
    import javax.jms.ObjectMessage;
    import javax.jms.Session;
    import org.apache.activemq.ActiveMQConnectionFactory;
    public class test03 {
    	 public static void main(String[] args) throws JMSException {
    	      ConnectionFactory factory;
    	      Connection conn;
    	      Destination des;
    	      Session session;
    	      MessageConsumer consumer;
    	      Message message;
    
    	      factory = new ActiveMQConnectionFactory("guest","guest","tcp://192.168.190.133:61616");
    	      conn = factory.createConnection();
    	      conn.start();
    	      session = conn.createSession(false,Session.CLIENT_ACKNOWLEDGE);
    	      des = session.createQueue("one");
    	      consumer = session.createConsumer(des);
    	      //手动消费
              //如果有多个消费者这个会遵循轮询的效果来处理消息
    	      consumer.setMessageListener(new MessageListener() {
    		public void onMessage(Message message) {
    			//确认处理了队列中的消息  就会删除队列中的消息!!!
    			try {
    				message.acknowledge();
    				ObjectMessage objectMessage = (ObjectMessage)message;
    				Object object = objectMessage.getObject();
    				System.out.println(object);
    			} catch (JMSException e) {W
    				e.printStackTrace();
    			}
    		}
    	});
    	 }
    	 }
    ```


### PUB&SUB 模型

+ topic 主题模式

+ 发送者发送消息的时候如果没有消费者 词条消息就作废了 不会缓存下来等待消费者消费

+ 可以有多个消费者接受到同一条消息的内容

  **代码** 

  consumer

  ```java
  import javax.jms.Connection;
  import javax.jms.ConnectionFactory;
  import javax.jms.Destination;
  import javax.jms.JMSException;
  import javax.jms.Message;
  import javax.jms.MessageConsumer;
  import javax.jms.Session;
  import javax.jms.TextMessage;
  import org.apache.activemq.ActiveMQConnectionFactory;
  public class test05 {
  	 public static void main(String[] args) throws JMSException {
  		 ConnectionFactory factory;
  		 Connection  conn;
  		 Session session;
  		 Destination des;
  		 MessageConsumer consumer;
  		 Message  message;
  	 factory = new ActiveMQConnectionFactory("guest","guest","tcp://192.168.190.133:61616");
  	 conn = factory.createConnection();
  	 conn.start();
  	 session = conn.createSession(false, Session.AUTO_ACKNOWLEDGE);
  	 des = session.createTopic("test-topic");
  	 consumer = session.createConsumer(des);
  	 message = consumer.receive();
  	 String str = ((TextMessage)message).getText();
  	 System.out.println(str);
  	 session.close();
  	 conn.close();
   	}
   }
  ```

+ 
  procuder
  ```java
  import javax.jms.Connection;
  import javax.jms.ConnectionFactory;
  import javax.jms.Destination;
  import javax.jms.JMSException;
  import javax.jms.Message;
  import javax.jms.MessageProducer;
  import javax.jms.Session;
  import org.apache.activemq.ActiveMQConnectionFactory;
  public class test06 {
      public static void main(String[] args) throws JMSException {
  		 ConnectionFactory factory;
  		 Connection  conn;
  		 Session session;
  		 Destination des;
  		 MessageProducer producer;
  		 Message  message;
  	 factory = new ActiveMQConnectionFactory("guest","guest","tcp://192.168.190.133:61616");
  	 conn = factory.createConnection();
  	 session = conn.createSession(false, Session.CLIENT_ACKNOWLEDGE);
  	 des = session.createTopic("test-topic");
  	 producer = session.createProducer(des);
  	 message = session.createTextMessage("topic content");
  	 producer.send(message);
  }
  }
  ```
  

### PTP 和 SUB & PUB 的区别

+ 概要
  + PTP 点对点传递
  + PUB SUB 发布订阅模式
+ 有无状态
  + Topic 无状态
  + ptp 有状态 可以存储到DB
+ 完整性保障
  + topic 不能保证发布的每条消息都会被消费者消费掉
  + ptp   能够保证每一次发布的消息都会被消费者消费掉
+ 消息丢失
  + topic 会丢失
  + ptp 不会丢失一般 除非消息超时

### 安全认证

+ 在配置文件中配置如下内容
+ users.properties  是用户配置文件
+ group.properties  是分组配置文件

```xml
<plugins>
     <jaasAuthenticationPlugin configuration="activemq"/>
        <!-- letsconfigureadestinationbasedauthorizationmechanism-->
     <authorizationPlugin>
        <map>
                <authorizationMap>
                  <authorizationEntries>
                    <authorizationEntry topic=">" read="admins" write="admins" admin="admins"/>
                    <authorizationEntry queue=">" read="admins" write="admins" admin="admin"/>
                    <authorizationEntry topic="ActiveMQ.Advisory.>" read="admins" write="admins" admin="admins"/>
                    <authorizationEntry queue="ActiveMQ.Advisory.>" read="admins" write="admins" admin="admins"/>
                  </authorizationEntries>
              </authorizationMap>
       </map>
     </authorizationPlugin>
</plugins>

```

### 持久化

+ 是指对消息数据的存储 持久性

+ 默认的消息是存储在内存中的

+ 当内存容量不足的时候 或ActiveMQ正常关闭的时候 会将内存中未处理的消息持久化到磁盘中去

  + 所有持久化的配置都是在conf/activemq.xml配置文件中 配置 broker标签中
  + 默认是**kahadb**进行持久化存储 是一个文件型数据库 是使用文件+内存保证数据的持久性的 kahadb可以限制每一个数据文件的大小 不代表总计数据容量
    + 特性
      + 日志形式文件存储
      + 支持多种恢复机制
      + 完全支持JMS事务
      + 消息索引以B-Tree结构存储 是在内存中的

  ```xml
  <persistenceAdapter>
      <kahaDB directory="${activemq.data}/kahadb"/>
  </persistenceAdapter>
  ```

  + **JDBC**持久化

    + **在配置文件中配置的数据库链接需要自己手动创建一个数据库名称才可以**

    + 需要在activemq的lib包中导入mysql的驱动包

    + 还需要commons-dbcp的包 但是可能activemq的其他子目录中已经存在了 就不用导入了

    + 等待配置完成之后  在启动activemq的时候就会给你的数据库创建三张表 

      + **activemq_msgs** 用于存储消息，Queue 和 Topic 都存储在这个表中
      + ID：自增的数据库主键 
      + CONTAINER：消息的 Destination 
      + MSGID_PROD：消息发送者客户端的主键
      +  MSG_SEQ：是发送消息的顺序  MSGID_PROD+MSG_SEQ 可以组成 JMS 的 MessageID
      +  EXPIRATION：消息的过期时间，存储的是从 1970-01-01 到现在的毫秒数 
      + MSG：消息本体的 Java 序列化对象的二进制数据 
      + PRIORITY：优先级，从 0-9，数值越大优先级越高
      + **activemq_acks** 用于存储订阅关系。如果是持久化 Topic，订阅者和服务器的订阅关系在 这个表保存  **有可能不会生成  手动创建即可   全部是varchar**  
      + 主要的数据库字段如下：
      +  CONTAINER：消息的 Destination
      +  SUB_DEST：如果是使用 Static 集群，这个字段会有集群其他系统的信息 
      + CLIENT_ID：每个订阅者都必须有一个唯一的客户端 ID 用以区分 
      + SUB_NAME：订阅者名称
      +  SELECTOR：选择器，可以选择只消费满足条件的消息。条件可以用自定义属性实现， 可支持多属性 AND 和 OR 操作
      +  LAST_ACKED_ID：记录消费过的消息的 ID。****
      +  **activemq_lock** 在集群环境中才有用，只有一个 Broker 可以获得消息，称为 Master Broker， 
      + 其他的只能作为备份等待 MasterBroker 不可用，才可能成为下一个 MasterBroker。 这个表用于记录哪个 Broker 是当前的 MasterBroker。 只有在消息必须保证有效，且绝对不能丢失的时候。使用 JDBC 存储策略。 如果消息可以容忍丢失，或使用集群/主备模式保证数据安全的时候，建议使用 levelDB 或 Kahadb。

    + 配置

      ActiveMQ 将数据持久化到数据库中 不指定具体的数据库。 可以使用任意的数据库 中。 本环节中使用 MySQL 数据库。 

      下述文件为 **activemq.xml** 配置文件部分内容。 **不 要 完 全 复 制** 

       首先定义一个 mysql-ds 的 MySQL 数据源，

      然后在 **persistenceAdapte**r 节点中配置 **jdbcPersistenceAdapter** 并且引用刚才定义的数据源。

      **dataSource** 指定持久化数据库的 bean，

      **createTablesOnStartup** 是否在启动的时候创建数 据表，

      默认值是 true，

      这样每次启动都会去创建数据表了

      一般是第一次启动的时候设置为 **true**，

      之后改成 **false**。 

      ```xml
          <broker brokerName="test-broker"persistent="true" xmlns="http://activemq.apache.org/schema/core">
          <!-- 给默认的kanadb注释 换成如下  -->
          <persistenceAdapter>
              <jdbcPersistenceAdapterdataSource="#mysql-ds" createTablesOnStartup="false"/>
          </persistenceAdapter>
          </broker> 
      
      <!-- 配置到broker外面  导入commons-dbcp 可以不导入【子包可能有】  导入mysql驱动包 -->
      <bean id="mysql-ds"class="org.apache.commons.dbcp.BasicDataSource" destroy-method="close">
          
          <propertyname="driverClassName"value="com.mysql.jdbc.Driver"/> 
          
          <propertyname="url" value="jdbc:mysql://localhost/activemq?relaxAutoCommit=true"/> <propertyname="username" value="activemq"/> 
          
          <propertyname="password"value="activemq"/> 
          
          <propertyname="maxActive"value="200"/> 
          
          <propertyname="poolPreparedStatements"value="true"/> 
      </bean>
      
      ```

      配置成功后，需要在数据库中创建对应的 **database**，否则无法访问。表格 ActiveMQ 可 以自动创建。

      

### 指定Procuder目的地

+ send方法可以有两个参数 第一个就是目的地 传入一个目的地对象 
+ 还可以有多个参数可以指定 目的地  消息内容 持久化机制  优先级  超时过期时间
+  producer.send(des,message,DeliveryMode.PERSISTENT,0,1000*10);

### 消息有效期

+ 消息过期后 默认会将过期的消息保存到 死信队列 不持久化的消息不会被保存 直接丢弃
+ 死信队列名称可以配置 死信队列中的消息不可恢复
  + 是在activemq.xml中配置的

### 消息优先级

+ jdbc    0 - 9    越大 优先级越高
+ 配置
  + 在 broker 端，默认是不存储 priority 信息的，我们需要手动开启，修改 activemq.xml 配 置文件，在 broker 标签的子标签 policyEntries 中增加下述配置： 
    + <policy Entryqueue=">" prioritizedMessages="true"/>
  + 强顺序
    + <policy Entryqueue=">" strictOrderDispatch="true"/> 
  + 严格顺序
    + <policyEntry queue=">" prioritizedMessages="true" useCache="false" expireMessagesPeriod="0"queuePrefetch="1"/> 

### Consumer确认机制

+ 如果是CLIENT模式的话一定要手动确认消息
+ 如果不确认消息的话 在consumer关闭的时候就会释放消息  交给其他消费者进行处理

### Spring 整合 ActiveMQ

```xml
<!-- activemq 客户端 -->
<dependency>
    <groupId>org.apache.activemq</groupId>
    <artifactId>activemq-all</artifactId>
    <version>5.11.2</version>
</dependency>
<dependency>
    <groupId>org.apache.activemq</groupId>
    <artifactId>activemq-pool</artifactId>
    <version>5.11.2</version>
</dependency>
<dependency>
    <groupId>org.apache.activemq</groupId>
    <artifactId>activemq-jms-pool</artifactId>
    <version>5.11.2</version>
</dependency>
<!-- 整合需要的 -->
<dependency>
    <groupId>org.apache.xbean</groupId>
    <artifactId>xbean-spring</artifactId>
    <version>4.5</version>
</dependency>
<dependency>
    <groupId>org.springframework</groupId>
    <artifactId>spring-jms</artifactId>
    <version>4.3.7.RELEASE</version>
</dependency>
```

```xml
xmlns="http://www.springframework.org/schema/beans"
       xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
       xmlns:context="http://www.springframework.org/schema/context"
       xmlns:aop="http://www.springframework.org/schema/aop"
       xmlns:tx="http://www.springframework.org/schema/tx"
       xmlns:jms="http://www.springframework.org/schema/jms"
       xmlns:amq="http://activemq.apache.org/schema/core"
       xsi:schemaLocation="http://www.springframework.org/schema/beans
    http://www.springframework.org/schema/beans/spring-beans-4.0.xsd
    http://www.springframework.org/schema/context
    http://www.springframework.org/schema/context/spring-context-4.0.xsd
    http://www.springframework.org/schema/aop
    http://www.springframework.org/schema/aop/spring-aop-4.0.xsd
    http://www.springframework.org/schema/tx
    http://www.springframework.org/schema/tx/spring-tx-4.0.xsd
    http://www.springframework.org/schema/jms
    http://www.springframework.org/schema/jms/spring-jms-4.0.xsd
    http://activemq.apache.org/schema/core
    http://activemq.apache.org/schema/core/activemq-core-5.8.0.xsd"

<!-- Spring activeMQ   producer 配置 -->
<amq:connectionFactory brokerURL="tcp://192.168.190.133:61616"
                       userName="admin"
                       password="admin"
                       id="connectionfactory"
                       />

<bean id="pooledConnectionFactoryBean" class="org.apache.activemq.pool.PooledConnectionFactoryBean">
    <property name="connectionFactory" ref="connectionfactory"/>
    <property name="maxConnections" value="10"/>
</bean>

<bean class="org.springframework.jms.connection.CachingConnectionFactory" id="connectionFactory">
    <property name="targetConnectionFactory" ref="pooledConnectionFactoryBean"/>
    <property name="sessionCacheSize" value="3"/>
</bean>

<!-- JmsTemplate -->
<bean id="template" class="org.springframework.jms.core.JmsTemplate">
    <property name="connectionFactory" ref="connectionFactory"/>
    <property name="defaultDestinationName" value="test-spring"/>
</bean>



<!-- consumer 配置 -->
        <!-- 配置链接工厂 -->
<amq:connectionFactory brokerURL="tcp://192.168.190.133:61616" userName="admin" password="admin" id="connectionFactory"/>

<bean class="org.springframework.jms.connection.CachingConnectionFactory" id="cachingConnectionFactory">
    <property name="targetConnectionFactory" ref="connectionFactory"/>
    <property name="sessionCacheSize" value="3"/>
</bean>

<!-- 监听器    监听器参数
                       acknowledge 消息确认机制
                       container-type 容器类型  默认为
                        DefaultContainerType   SingleContainerType
                       destination-type 目的地类型 使用队列作为目的地
                       connection-factory 链接工厂 spring-jms的链接工厂 必须是spring自主创建的
         -->

<bean id="consumer" class="top.liwenxiang.oa.activemq_spring.test_spring_consumer"/>

<jms:listener-container acknowledge="auto" container-type="default" destination-type="queue" connection-factory="cachingConnectionFactory">
    <jms:listener destination="test-spring" ref="consumer" />
</jms:listener-container>

```

```java
// producer 代码

@Service("activeservice")
public class test_spring {

    @Autowired
    private JmsTemplate template;

    public void setTemplate(JmsTemplate template) {
        this.template = template;
    }

    publi	c void sendMessage(final String str){
        // this.template.setDefaultDestinationName();
        this.template.send(new MessageCreator() {
            @Override
            public Message createMessage(Session session) throws JMSException {
                Message message = session.createTextMessage(str);
                return message;
            }
        });
    }


    public static void main(String[] args) throws JMSException {
        ApplicationContext ac = new ClassPathXmlApplicationContext("applicationContext.xml");
        test_spring activeservice = ac.getBean("activeservice", test_spring.class);
        activeservice.sendMessage("测试Spring整合");
    }
}

// consumer 代码
public class test_spring_consumer implements MessageListener {

    @Override
    public void onMessage(Message message) {
        TextMessage tx = (TextMessage)message;
        try {
            System.out.println(tx.getText());
        } catch (JMSException e) {
            e.printStackTrace();
        }
    }

    public static void main(String[] args) {
        ApplicationContext ac = new ClassPathXmlApplicationContext("applicationContext.xml");
        test_spring_consumer consumer = ac.getBean("consumer", test_spring_consumer.class);
    }
}

```

### ActiveMQ 主从

+ **首先安装zookeeper**
+ **详见pdf配置文档**

