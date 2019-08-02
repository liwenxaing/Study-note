## WebService

### 简述

+ WebService是一个基于Web的服务 服务器端整出一些资源让客户端访问
+ 是一个跨语言 跨平台的规范
+ 多个跨平台 跨语言的应用间的通信整合方案
+ 能够在不同语言之间进行通信
+ 跨语言调用
+ 跨平台调用
+ 远程调用
+ HTTP  +  XML

### 什么时候使用WebService?

+ 同一家公司的新旧应用之间
+ 不同公司的应用之间  合作  例如 淘宝和物流公司交换数据
+ 一些提供数据的的聚合应用

### 术语

+ WSDL
  + webService 定义语言
  + 就相当于文档的解释说明   
  + 可以通过wsdl文档生成webService客户端代码  从而进行接口调用访问
+ SOAP
  + HTTP + XML  简单对象访问协议  来进行webService接口的访问和数据的传输
+ SEI
  + WebService终端的接口服务
  + 一般来说一个服务都会有服务端和客户端 那么服务端就回去先定义这个东西
+ CXF
  + 一个WebService的框架客户端
+ 规范
  + JAX-WS
  + JAX-RS
  + JAXM
+ Soa
  + WebService 是SOA的一种实现

### 开发

+ 可以使用JDK进行开发
  + 生成客户端代码 使用jdk的工具  wximport即可
  + 移动到生成代码的位置
    + 进入CMD执行命令ws import -keep wsdl文档路径
      + 路径例如  http://localhost:8080/webservice?wsdl
      + 路径例如   E://webservice/aaa.wsdl
+ 可以使用CXF进行开发

### WSDL

+ 文档结构

![1564340773448](assets/1564340773448.png)

### JAX-WS

+ **服务端  注重的是流程不是代码**

+ 基于CXF的实现

+ 传输的数据是xml格式的

+ ```XML
  <dependencies>
    <!-- JAX-WS -->
    <dependency>
      <groupId>org.apache.cxf</groupId>
      <artifactId>cxf-rt-frontend-jaxws</artifactId>
      <version>3.0.1</version>
    </dependency>
    <dependency>
      <groupId>org.apache.cxf</groupId>
      <artifactId>cxf-rt-transports-http-jetty</artifactId>
      <version>3.0.1</version>
    </dependency>
    <dependency>
      <groupId>org.slf4j</groupId>
      <artifactId>slf4j-log4j12</artifactId>
      <version>1.6.1</version>
    </dependency>
    <dependency>
      <groupId>junit</groupId>
      <artifactId>junit</artifactId>
      <version>4.12</version>
    </dependency>
  </dependencies>
  ```

+ ```java
  package com.ws.service;
  
  import javax.jws.WebService;
  
  @WebService
  public interface HelloService {
      /**
       *  sayHello 方法
       */
      public String sayHello(String name);
  }
  ```

+ ```java
  package com.wx.service.impl;
  
  import com.ws.service.HelloService;
  
  public class HelloServiceImpl implements HelloService {
      /**
       * sayHello 方法
       */
      @Override
      public String sayHello(String name) {
          return name + ",Welcome to LWX !!!";
      }
  }
  ```

+ ```java
  import com.wx.service.impl.HelloServiceImpl;
  import org.apache.cxf.jaxws.JaxWsServerFactoryBean;
  
  public class publish {
      public static void main(String[] args) {
          // 设置发布的工厂
          JaxWsServerFactoryBean jaxWsServiceFactoryBean = new JaxWsServerFactoryBean();
          // 设置地址
          jaxWsServiceFactoryBean.setAddress("http://localhost:8000/ws/hello");
  		// 设置日志输入输出拦截器
          jaxWsServiceFactoryBean.getInInterceptors().add(new LoggingInInterceptor());
          jaxWsServiceFactoryBean.getOutInterceptors().add(new LoggingOutInterceptor());
          // 设置服务类
          jaxWsServiceFactoryBean.setServiceBean(new HelloServiceImpl());
          // 发布服务
          jaxWsServiceFactoryBean.create();
  
          System.out.println("发布成功..........监听8000端口");
      }
  }
  ```

+ **客户端调用**

+ 注意：HelloService 就是我们的接口的位置也就是说放置的类的包名 在server和client都是要一致的

+ ```java
  package com.ws;
  
  import com.ws.service.HelloService;
  import org.apache.cxf.jaxws.JaxWsProxyFactoryBean;
  import org.junit.Test;
  
  /**
   * Unit test for simple App.
   */
  public class AppTest 
  {
      /**
       * Rigorous Test :-)
       */
      @Test
      public void shouldAnswerWithTrue()
      {
          // 接口访问地址 http://localhost:8000/ws/hello
  
          // 创建代理对象
          JaxWsProxyFactoryBean jaxWsProxyFactoryBean = new JaxWsProxyFactoryBean();
  
          // 设置远程服务端访问地址
          jaxWsProxyFactoryBean.setAddress("http://localhost:8000/ws/hello");
  
          // 设置接口类型
          jaxWsProxyFactoryBean.setServiceClass(HelloService.class);
  
          // 对接口生成代理对象
          HelloService helloService = jaxWsProxyFactoryBean.create(HelloService.class);
  
          System.out.println(helloService.getClass());
  
          String con = helloService.sayHello("Jet");
  
          System.out.println(con);
      }
  }
  ```

### JAX-RS

+ 基于CXF的实现

+ result风格的接口更加的简洁  利于浏览器缓存  更具有层次感

+ resutl API 是一种风格不是一种规范

+ POST PUT DELETE GET

+ **服务端代码实现**

+ MAVEN 依赖

+ ```xml
  <dependencies>
      <!-- JAX-WS -->
      <dependency>
          <groupId>org.apache.cxf</groupId>
          <artifactId>cxf-rt-frontend-jaxrs</artifactId>
          <version>3.0.1</version>
      </dependency>
      <dependency>
          <groupId>org.apache.cxf</groupId>
          <artifactId>cxf-rt-rs-client</artifactId>
          <version>3.0.1</version>
      </dependency>
      <dependency>
          <groupId>org.apache.cxf</groupId>
          <artifactId>cxf-rt-rs-extension-providers</artifactId>
          <version>3.0.1</version>
      </dependency>
      <dependency>
          <groupId>org.codehaus.jettison</groupId>
          <artifactId>jettison</artifactId>
          <version>1.3.7</version>
      </dependency>
      <dependency>
          <groupId>org.apache.cxf</groupId>
          <artifactId>cxf-rt-transports-http-jetty</artifactId>
          <version>3.0.1</version>
      </dependency>
      <dependency>
          <groupId>org.slf4j</groupId>
          <artifactId>slf4j-log4j12</artifactId>
          <version>1.6.1</version>
      </dependency>
      <dependency>
          <groupId>junit</groupId>
          <artifactId>junit</artifactId>
          <version>4.12</version>
      </dependency>
  </dependencies>
  ```

+ 服务端代码

  + 