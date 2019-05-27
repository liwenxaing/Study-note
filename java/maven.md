# Maven 笔记

## 下载地址 添加依赖

https://mvnrepository.com/

##服务于Java的自动化构建工具

+ 一个web动态项目最后真正运行的使编译后的结果 并不是源文件
+ 工程只是一个开发环境
+ JRE 只是一个运行时环境
+ 可以自动加载Jar包 不需要手动下载

## 构建过程中的各个环节

+ 清理
+ 编译
+ 测试
+ 报告 
+ 打包  动态web工程打包成 war 包 Java工程打包成jar包
+ 安装
+ 部署

## 安装Maven

+ Maven 是 java写的 也需要运行在 JVM上
+ 配置环境变量 
  + M2_HOME     Maven 的安装路径
  + PATH               Maven的安装路径+bin
  + mvn -version   查看版本


## Maven的核心概念

+ 约定的目录结构
+ POM
+ 坐标
+ 依赖
+ 仓库
+ 生命周期/插件/目标
+ 继承
+ 聚合

## 创建Maven第一个工程

+ 创建约定的目录结构
  + 根目录          工程名
  + src目录        源码目录
  + pom.xml     核心配置文件
  + main目录     存放主程序
  + test目录       存放测试程序
  + java目录      存放java源代码
  + resource目录   存放框架配置文件 .xml .properties
+ 为什么要遵守约定?
  + Maven想要编译源文件 那么必须知道源文件在哪 如果遵守了约定Maven就可以根据已有的约定找到我们的源文件代码在哪里

## Mvn 常用命令

+ mvn clean   清理
+ mvn  compile  编译主程序
+ mvn test-compile  编译测试程序
+ mvn  test  执行测试
+ mvn  package  打包 jar 或者 war
+ mvn install 安装到本地仓库 方便使用
+ mvn site 生成站点
+ mvn deploy  自动部署   一般不使用

## Maven 包管理

+ 当我们编译程序的时候 maven会先去当前的本地仓库查找是否有需要的插件 如果没有的话如果本机联网了那么就会去外网的Maven的中央仓库进行下载 如果没有网络 那么就会构建失败
+ 本地仓库的默认位置 C:User\系统中当前用户的家目录\.m2\respository
+ 修改本地默认仓库的位置
  + 找到 Maven解压目录\conf\settings.xml
  + 在settings.xml文件中找到标签 localRespository
  + 将<localRespository> /path/to/local/repo </localRespository> 标签从注释中取出
  + 将标签内容修改成你自己的本地仓库目录即可

## Maven命令用法

+ mvn compile    编译测试程序  生成target目录
+ mvn  package    把主程序打包成jar包  这里可以根据pom.xml文件配置   生成日志文件  

## POM 

+ project object model   项目对象模型

+ pom是对于Maven的核心配置文件 重要程度就相当于web.xml对于动态Web项目的重要程度一样

+ modelVersion：pom文件的模型版本 

+ group id：com.公司名.项目名

  artifact id：功能模块名

+ packaging：项目打包的后缀，war是web项目发布用的，默认为jar 

+ version:     artifact模块的版本 

+ name和url：相当于项目描述，可删除 

+ group id + artifact id +version :项目在仓库中的坐标

+ dependency：引入资源jar包到本地仓库，要引入更多资源就在<dependencies>中继续增加<dependency> 

+ scope：作用范围，test指该jar包仅在maven测试时使用，发布时会忽略这个包。需要发布的jar包可以忽略这一配置 

+ build：项目构建时的配置 

+ finalName：在浏览器中的访问路径，如果将它改成helloworld，再执行maven--update，这时运行项目的访问路径是 http://localhost:8080/helloworld/   而不是项目名的  http://localhost:8080/test

+  plugins：插件，之前篇章已经说过，第一个插件是用来设置java版本为1.7，第二个插件是我刚加的，用来设置编码为utf-8 

+ ```xml
  <build>
  	<finalName>helloworld</finalName>
  	<plugins>
  		<plugin>
  			<groupId>org.apache.maven.plugins</groupId>
  			<artifactId>maven-compiler-plugin</artifactId>
  			<version>3.5.1</version>
  			<configuration>
  				<source>1.7</source>
  				<target>1.7</target>
  			</configuration>
  		</plugin>
  		<plugin>
  			<groupId>org.apache.maven.plugins</groupId>
  			<artifactId>maven-resources-plugin</artifactId>
  			<version>3.0.1</version>
  			<configuration>
  				<encoding>UTF-8</encoding>
  			</configuration>
  		</plugin>
  	</plugins>
  ```


## 坐标

+ groupid	: 公司的域名倒序 + 项目名
+ artifactid : 模块名称
+ version : 版本

## 仓库

+ 存储用到的jar包
+ 分为本地仓库和远程仓库
+ 远程仓库又分为私服,中央仓库,中央仓库镜像

## 依赖

+ Maven 解析依赖的时候会到本地仓库中查找被依赖的jar包
  + 对于我们自己开发的Maven工程 使用install命令安装后就可以进入仓库
  + mvn install  将自己的jar包打包到本地仓库  使得其他项目可以依赖
+ 作用域范围
  + compiler
    + 对主程序是否有效    **有效**
    + 对测试程序是否有效    **有效**
    + 是否参与打包       **参与**
    + 是否参与部署       **参与**
  + test
    + 对主程序是否有效    **无效**
    + 对测试程序是否有效   **有效**
    + 是否参与打包       **不参与**
    + 是否参与部署    **不参与**
  + provided
    + 对主程序是否有效   **有效**
    + 对测试程序是否有效  **有效**
    + 是否参与打包       **不参与**
    + 是否参与部署    **不参与**

## 生命周期

+ 每一次执行命令 都是从头执行的

## 在eclipse中使用maven

+ installations 制定Maven的核心程序的位置
+ 设置Usersettings  指定conf/setting.xml的位置   进而获取到本地仓库的地址
+ 执行Maven命令的时候可以右键pom.xml选择run as - 选择命令    build...  可以输入命令   compiler  ---   package ......

## 依赖的传递性

+ 当我们添加一个依赖的时候  这个包所依赖的jar包就会被顺带着的加载进来

+ 好处 ： 可以传递的依赖不必在每一个模块工程中都重复声明 在 当前项目的模块中的最后的一个模块中依赖一次即可
+ 注意 ： 非compiler的范围的依赖不能够进行传递  所以在各个工程中 如果有需要就得重复声明

## 依赖的排除

+ 需要设置依赖排除的场合

  + 不稳定的jar包 不希望加入当前工程

  + 依赖排除的设置方式 在当前jar包依赖的dependency中加入以下配置

    + ```xml
      <exclusions>
           <exclusion>
               <artifactId>junit</artifactId>
               <groupId>junit</groupId>
           </exclusion>
      </exclusions>
      ```

## 依赖的原则

+ 作用  解决模块工程之间的jar包冲突问题
+ 情景1 ： 验证路径最短者优先
+ 情景2 ： 验证路径时先声明者优先
  + 先声明这是指dependency标签的声明顺序

## 统一管理依赖版本号

+ 使用properties标签内部的自定义标签声明自己所需要的版本号  修改的时候只需要修改这一个地方即可使用的时候使用使用${自定义标签名称即可}  其实properties中的自定义标签在哪里都可以用
+ <properties>   <version.spring> 1.0.0 </version.spring>  </properties>
+ <version> ${version.spring} </version>

## 继承

+ 现状 

  + 由于test范围的依赖不能传递 所以会分散在各个模块中  很容易造成版本不一致

+ 需求

  + 统一管理各个模块工程中对junit依赖的版本

+ 解决思路

  + 将 junit依赖统一提取到父工程中  在子工程中声明junit依赖的时候不指定版本 以父工程中统一设定的为准,同时也便于修改

+ 操作步骤

  + 创建一个Maven工程作为父工程 	**注意:打包方式为POM**

  + 在子工程中声明对父工程的引用

  + 将子工程中与父工程中的坐标相同内容删除

  + 在父工程中统一junit依赖

  + 在子工程中删除junit依赖的版本号部分

  + 子工程内容

  + ```xml
    <?xml version="1.0" encoding="UTF-8"?>
    <project xmlns="http://maven.apache.org/POM/4.0.0"
             xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
             xsi:schemaLocation="http://maven.apache.org/POM/4.0.0 http://maven.apache.org/xsd/maven-4.0.0.xsd">
        
        <!-- 指定父工程 -->
        <parent>
                <!-- 父工程名称 -->
            <artifactId>Parent</artifactId>
               <!-- 父工程唯一标识  -->
            <groupId>top.liwenxiang.maven</groupId>
                  <!-- 版本号 -->
            <version>1.0-SNAPSHOT</version>
        </parent>
        <modelVersion>4.0.0</modelVersion>
        <dependencies>
            <!-- 版本号可以省略 由父工程进行管理 -->
            <dependency>
                <groupId>junit</groupId>
                <artifactId>junit</artifactId>
            </dependency>
            <dependency>
                <groupId>top.liwenxiang.maven</groupId>
                <artifactId>child1</artifactId>
                <version>1.0-SNAPSHOT</version>
            </dependency>
        </dependencies>
    
        <artifactId>child2</artifactId>
    
    
    </project>
    ```

+ 父工程内容

+ ```xml
  <?xml version="1.0" encoding="UTF-8"?>
  <project xmlns="http://maven.apache.org/POM/4.0.0"
           xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
           xsi:schemaLocation="http://maven.apache.org/POM/4.0.0 http://maven.apache.org/xsd/maven-4.0.0.xsd">
      <modelVersion>4.0.0</modelVersion>
      <packaging>pom</packaging>
  
      <!-- 子模块  -->
      <modules>
          <module>child1</module>
          <module>child2</module>
      </modules>
  
      <groupId>top.liwenxiang.maven</groupId>
      <artifactId>Parent</artifactId>
      <version>1.0-SNAPSHOT</version>
      
      <!-- 指定需要统一管理的依赖  -->
      <dependencyManagement>
           <dependencies>
               <dependency>
                   <groupId>junit</groupId>
                   <artifactId>junit</artifactId>
                   <version>4.12</version>
                   <scope>test</scope>
               </dependency>
           </dependencies>
      </dependencyManagement>
  
  </project>
  ```

## 配置读到src/main/java的配置文件  如果不配置的话在使用MybatisMapper的时候可能会找不到配置的映射文件除非放到resource文件夹下和Mybatis-config.xml一块才能找到还有一种方法就是加入以下配置

```xml
<build>  
    <resources>  
        <resource>  
            <directory>src/main/java</directory>  
            <includes>  
                <include>**/*.xml</include>  
            </includes>  
        </resource>  
    </resources>  
</build> 
```

## 聚合

+ 安装子工程时 要先安装父工程 否则会安装失败
+ 一键安装各个模块工程
  + 配置方式  在总工程中配置  比如 父工程中 
    + modules > module

```xml
<!--Jackson required包-->
<dependency>
    <groupId>com.fasterxml.jackson.core</groupId>
    <artifactId>jackson-core</artifactId>
    <version>2.5.0</version>
</dependency>
<dependency>
    <groupId>com.fasterxml.jackson.core</groupId>
    <artifactId>jackson-databind</artifactId>
    <version>2.5.0</version>
</dependency>
<dependency>
    <groupId>com.fasterxml.jackson.core</groupId>
    <artifactId>jackson-annotations</artifactId>
    <version>2.5.0</version>
</dependency>
<dependency>
  <groupId>junit</groupId>
  <artifactId>junit</artifactId>
  <version>4.11</version>
  <scope>test</scope>
</dependency>
<dependency>
  <groupId>javax.servlet</groupId>
  <artifactId>javax.servlet-api</artifactId>
  <version>3.1.0</version>
</dependency>
<dependency>
  <groupId>javax.servlet.jsp</groupId>
  <artifactId>jsp-api</artifactId>
  <version>2.1</version>
  <scope>provided</scope>
</dependency>
<dependency>
    <groupId>org.mybatis</groupId>
    <artifactId>mybatis</artifactId>
    <version>3.4.6</version>
    <scope>compile</scope>
</dependency>
<dependency>
    <groupId>org.apache.logging.log4j</groupId>
    <artifactId>log4j-core</artifactId>
    <version>2.6.2</version>
</dependency>
<dependency>
    <groupId>org.apache.logging.log4j</groupId>
    <artifactId>log4j-api</artifactId>
     <version>2.6.2</version>
</dependency>
<dependency>
    <groupId>mysql</groupId>
    <artifactId>mysql-connector-java</artifactId>
    <version>5.1.47</version>
</dependency>
<!--SpringMVC-->
<dependency>
    <groupId>org.springframework</groupId>
    <artifactId>spring-core</artifactId>
    <version>${spring.version}</version>
</dependency>

<dependency>
    <groupId>org.mybatis</groupId>
    <artifactId>mybatis</artifactId>
    <version>3.4.1</version>
</dependency>

<!-- mybatis/spring包 -->
<dependency>
    <groupId>org.mybatis</groupId>
    <artifactId>mybatis-spring</artifactId>
    <version>1.3.1</version>
</dependency>

<dependency>
    <groupId>org.springframework</groupId>
    <artifactId>spring-beans</artifactId>
    <version>${spring.version}</version>
</dependency>

<dependency>
    <groupId>org.springframework</groupId>
    <artifactId>spring-context</artifactId>
    <version>${spring.version}</version>
</dependency>

<dependency>
    <groupId>org.springframework</groupId>
    <artifactId>spring-tx</artifactId>
    <version>${spring.version}</version>
</dependency>

<dependency>
    <groupId>org.springframework</groupId>
    <artifactId>spring-web</artifactId>
    <version>${spring.version}</version>
</dependency>

<dependency>
    <groupId>org.springframework</groupId>
    <artifactId>spring-webmvc</artifactId>
    <version>${spring.version}</version>
</dependency>

<dependency>
    <groupId>org.springframework</groupId>
    <artifactId>spring-test</artifactId>
    <version>${spring.version}</version>
</dependency>

 <dependency>
     <groupId>commons-dbcp</groupId>
     <artifactId>commons-dbcp</artifactId>
     <version>1.4</version>
 </dependency>

<dependency>
<groupId>c3p0</groupId>
<artifactId>c3p0</artifactId>
<version>0.9.1.2</version>
</dependency>

<!-- redis -->
<dependency>
    <groupId>biz.paluch.redis</groupId>
    <artifactId>lettuce</artifactId>
    <version>4.3.2.Final</version>
</dependency>

<dependency>
    <groupId>org.springframework.data</groupId>
    <artifactId>spring-data-redis</artifactId>
    <version>1.8.3.RELEASE</version>
</dependency>

<!-- memcached
<dependency>
    <groupId>com.whalin</groupId>
    <artifactId>Memcached-Java-Client</artifactId>
    <version>3.0.2</version>
</dependency>
-->
<dependency>
    <groupId>memcached_client</groupId>
    <artifactId>java_memcached_client</artifactId>
    <version>3.0.2</version>
</dependency>

<!-- httpClient -->
<dependency>
    <groupId>org.apache.httpcomponents</groupId>
    <artifactId>httpclient</artifactId>
    <version>4.5.2</version>
</dependency>
<dependency>
    <groupId>commons-httpclient</groupId>
    <artifactId>commons-httpclient</artifactId>
    <version>3.1</version>
</dependency>

<!-- appche common lang -->
<dependency>
    <groupId>org.apache.commons</groupId>
    <artifactId>commons-lang3</artifactId>
    <version>3.4</version>
</dependency>

<dependency>
    <groupId>org.apache.commons</groupId>
    <artifactId>commons-collections4</artifactId>
    <version>4.1</version>
</dependency>

<dependency>
    <groupId>commons-io</groupId>
    <artifactId>commons-io</artifactId>
    <version>2.4</version>
</dependency>

<dependency>
    <groupId>commons-beanutils</groupId>
    <artifactId>commons-beanutils</artifactId>
    <version>1.9.2</version>
</dependency>

<dependency>
    <groupId>cglib</groupId>
    <artifactId>cglib-nodep</artifactId>
    <version>3.2.2</version>
</dependency>


<dependency>
    <groupId>dom4j</groupId>
    <artifactId>dom4j</artifactId>
    <version>1.6.1</version>
</dependency>


<!-- AOP -->
<dependency>
    <groupId>org.aspectj</groupId>
    <artifactId>aspectjweaver</artifactId>
    <version>1.7.4</version>
</dependency>

<!-- Validator -->
<dependency>
    <groupId>org.hibernate</groupId>
    <artifactId>hibernate-validator</artifactId>
    <version>5.2.4.Final</version>
</dependency>

<!--添加 FreeMarker-->
<dependency>
    <groupId>org.freemarker</groupId>
    <artifactId>freemarker</artifactId>
    <version>2.3.19</version>
</dependency>

<!-- ui.freemarker -->
<dependency>
    <groupId>org.springframework</groupId>
    <artifactId>spring-context-support</artifactId>
    <version>3.2.4.RELEASE</version>
</dependency>

<!-- joda time -->
<dependency>
    <groupId>joda-time</groupId>
    <artifactId>joda-time</artifactId>
    <version>2.4</version>
</dependency>

<dependency>
    <groupId>org.apache.commons</groupId>
    <artifactId>commons-math3</artifactId>
    <version>3.6</version>
</dependency>
<dependency>
    <groupId>com.alibaba</groupId>
    <artifactId>fastjson</artifactId>
    <version>1.2.41</version>
</dependency>
<!-- gson -->
<dependency>
    <groupId>com.google.code.gson</groupId>
    <artifactId>gson</artifactId>
    <version>2.7</version>
</dependency>

<dependency>
    <groupId>org.aspectj</groupId>
    <artifactId>aspectjrt</artifactId>
    <version>1.8.9</version>
</dependency>
<!-- https://mvnrepository.com/artifact/org.aspectj/aspectjtools -->
<dependency>
    <groupId>org.aspectj</groupId>
    <artifactId>aspectjtools</artifactId>
    <version>1.8.9</version>
</dependency>
<dependency>
    <groupId>org.aspectj</groupId>
    <artifactId>aspectjweaver</artifactId>
    <version>1.7.4</version>
</dependency>

<dependency>
    <groupId>com.alibaba</groupId>
    <artifactId>fastjson</artifactId>
    <version>1.2.32</version>
</dependency>

<!-- file upload -->
<dependency>
    <groupId>commons-fileupload</groupId>
    <artifactId>commons-fileupload</artifactId>
    <version>1.3.2</version>
</dependency>

<!-- pinyin4j -->
<dependency>
    <groupId>com.belerweb</groupId>
    <artifactId>pinyin4j</artifactId>
    <version>2.5.0</version>
</dependency>

<dependency>
    <groupId>com.lvmama.config</groupId>
    <artifactId>lvmama-config</artifactId>
    <version>1.0.3</version>
</dependency>
<dependency>
    <groupId>org.redisson</groupId>
    <artifactId>redisson</artifactId>
    <version>2.6.0</version>
<exclusions>
<exclusion>
    <groupId>io.netty</groupId>
    <artifactId>netty-transport-native-epoll</artifactId>
    </exclusion>
<exclusion>
    <groupId>io.netty</groupId>
    <artifactId>netty-common</artifactId>
    </exclusion>
<exclusion>
    <groupId>io.netty</groupId>
    <artifactId>netty-codec</artifactId>
    </exclusion>
<exclusion>
    <groupId>io.netty</groupId>
    <artifactId>netty-buffer</artifactId>
</exclusion>
<exclusion>
    <groupId>io.netty</groupId>
    <artifactId>netty-transport</artifactId>
</exclusion>
<exclusion>
    <groupId>io.netty</groupId>
    <artifactId>netty-handler</artifactId>
</exclusion>
</exclusions>
<dependency>
<groupId>org.hibernate.validator</groupId>
<artifactId>hibernate-validator</artifactId>
<version>6.0.13.Final</version>
</dependency>
```
## 搭建私服

- Nexus Repository OSS

- 下载OSS: https://www.sonatype.com/download-oss-sonatype 
  ，现在是3.0以上版本，下载 [安装 ](http://www.liuhaihua.cn/archives/tag/%e5%ae%89%e8%a3%85)或解压，到bin目录下：

  1. 在像Linux这样的类Unix平台上使用命令： ./nexus run
  2. 在Windows中，使用命令： nexus.exe /run

  [启动过程 ](http://www.liuhaihua.cn/archives/tag/starting-procedure)：

  ![自己搭建Maven服务器私服](D:/%E7%AC%94%E8%AE%B0/%E7%AC%94%E8%AE%B0/java/assets/mymaven.png)

  1. 打开浏览器并输入URL： http://localhost:8081/ 
     将显示Nexus Repository Manager欢迎屏幕。

  2. 在NXRM欢迎屏幕右上角上，单击“ **登录signin”** 
     。将显示“登录”弹出框。

  3. 输入默认用户名，即“ **admin** 
     ”和默认密码，即“ **admin123”** 
     。

  4. 单击“ **登录”** 
     。登录对话框已关闭，您已登录NXRM。

  5. ### 项目配置

     现在我们可以为自己项目建立一个仓库，比如名为my-repository，找到创建仓库的按钮：

     ![自己搭建Maven服务器私服](D:/%E7%AC%94%E8%AE%B0/%E7%AC%94%E8%AE%B0/java/assets/createrepo.png)

     进去后，选择maven2(hosted)，如果你像做 [互联网 ](http://www.liuhaihua.cn/archives/tag/%e4%ba%92%e8%81%94%e7%bd%91)上仓库的 [缓存 ](http://www.liuhaihua.cn/archives/tag/%e7%bc%93%e5%ad%98)代理，就选择maven2(proxy)，hosted就是自己的私库。

     名字输入 my-repository，其他可以默认，最下面一行选择Allow redeploy，这样可以反复试验，保存即可。

     创建好后，可以在仓库列表中看到我们的仓库名称为my-repository，点按进入：

     ![自己搭建Maven服务器私服](D:/%E7%AC%94%E8%AE%B0/%E7%AC%94%E8%AE%B0/java/assets/oss1.png)

     注意我们的仓库URL是：

     ```
     http://127.0.0.1:8081/repository/my-release/
     ```

     这样在我们项目中的pom.xml可以配置这个地址发布了：

     ```
     <!-- 打包发布 -->
     <distributionManagement>
         <repository>
             <id>my-release</id><!--这个ID需要与你的release仓库的Repository ID一致-->
             <url>http://127.0.0.1:8081/repository/my-release/</url>
         </repository>
     
     </distributionManagement>
     ```

     当然访问这个地址需要用户名和密码。

     下一步设置用户名和密码，首先创建一个角色，比如testRole：

     ![自己搭建Maven服务器私服](D:/%E7%AC%94%E8%AE%B0/%E7%AC%94%E8%AE%B0/java/assets/oss2.png)

     这里给与testRole的权限我们选择的是nx-all，熟悉之后，可以进行详细的 [定制 ](http://www.liuhaihua.cn/archives/tag/private)。

     然后选择右边users，创建本地用户，角色role选择我们建立的testRole。注意记住用户名和密码，需要在maven的 settings.xml中配置：

     <server>

     <id>my-release</id>

     <username>test</username>

     <password>test</password><!–这个密码就是你设置的密码–>

     </server>

     这里my-release就是我们的仓库名称，用户和密码是创建本地用户你设置的。

     pom.xml文件最后是这样：

     ```xml
     <?xml version="1.0" encoding="UTF-8"?>
     <project xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
              xmlns="http://maven.apache.org/POM/4.0.0"
              xsi:schemaLocation="http://maven.apache.org/POM/4.0.0 http://maven.apache.org/xsd/maven-4.0.0.xsd">
         <modelVersion>4.0.0</modelVersion>
     
         <groupId>com.example</groupId>
         <artifactId>wwww</artifactId>
         <version>1.0</version>
     
         <!-- 打包发布 -->
         <distributionManagement>
             <repository>
                 <id>my-release</id><!--这个ID需要与你的release仓库的Repository ID一致-->
                 <url>http://127.0.0.1:8081/repository/my-release/</url>
             </repository>
     
         </distributionManagement>
     
     </project>
     ```

     ### 发布配置

     现在可以在项目中运行mvn clean deploy发布了，在 Idea执行deploy之后控制台输出如下：

     [INFO] — maven-deploy- [plugin ](http://www.liuhaihua.cn/archives/tag/plugin):2.7:deploy (default-deploy) @ wwww —

     Uploading: http://127.0.0.1:8081/repository/my-release/com/example/wwww/1.0/wwww-1.0.jar

     Uploaded: http://127.0.0.1:8081/repository/my-release/com/example/wwww/1.0/wwww-1.0.jar (3 KB at 11.0 KB/sec)

     Uploading: http://127.0.0.1:8081/repository/my-release/com/example/wwww/1.0/wwww-1.0.pom

     Uploaded: http://127.0.0.1:8081/repository/my-release/com/example/wwww/1.0/wwww-1.0.pom (917 B at 7.6 KB/sec)

     Downloading: http://127.0.0.1:8081/repository/my-release/com/example/wwww/maven-metadata.xml

     Downloaded: http://127.0.0.1:8081/repository/my-release/com/example/wwww/maven-metadata.xml (291 B at 3.2 KB/sec)

     Uploading: http://127.0.0.1:8081/repository/my-release/com/example/wwww/maven-metadata.xml

     Uploaded: http://127.0.0.1:8081/repository/my-release/com/example/wwww/maven-metadata.xml (291 B at 3.3 KB/sec)

     [INFO] ————————————————————————

     [INFO] B [UI ](http://www.liuhaihua.cn/archives/tag/ui)LD SUCCESS

     最后到http://127.0.0.1:8081/确认：