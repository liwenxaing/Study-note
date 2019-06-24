## SpringBoot 笔记

### 什么是SPringBoot

SpringBoot是在Spring的基础之上产生的(确切的说是在Spring4.0的版本的基础之上)， 其中“Boot”的意思就是“引导”，意在简化开发模式，是开发者能够快速的开发出基于 Spring 的应用。SpringBoot 含有一个内嵌的 web 容器。我们开发的 web 应用不需要作为 war 包部署到 web 容器中，而是作为一个 jar 包，在启动时根据 web 服务器的配置进行加载。

###SpringBoot 解决了什么？

SpringBoot 使配置简单

SpringBoot 使编码加单

SpringBoot 使部署简单

SpringBoot 使监控简

###SpringBoot HelloWorld

+ SpringBoot 已经帮助我们集成了 很多环境 我们已经不许在进行像Spring那样多的配置 可以很轻松的运行起来一个Web项目

+ SpringBoot 启动模块[集成了SpringMvc]和测试模块

  ```xml
  <dependency>
      <groupId>org.springframework.boot</groupId>
      <artifactId>spring-boot-starter-web</artifactId>
  </dependency>
  
  <dependency>
      <groupId>org.springframework.boot</groupId>
      <artifactId>spring-boot-starter-test</artifactId>
      <scope>test</scope>
  </dependency>
  ```

+ SpringBoot 启动类编写

  ```java
  @SpringBootApplication
  public class Hello{
      public static void main(String[] args){
          // 运行就跑起来了
          SpringApplication.run(Hello.class,args);
      }
  }
  ```

+ 注意的问题

  + 启动类的位置不要放在与controller包的自子包中 不要放在不同的包中
  + 放在controller的上一级包中
  + 因为启动的时候是从当前包开始扫描的就是Application所处的位置 和controller同级刚好扫描到

### 修改版本

+ 可以直接在pom.xml中加入properties
+ 里面的标签是jar包名称.version可以设置自己想要的版本
+ 注意兼容问题

### 全局配置文件 

##### 自定义配置属性

```java
msg=hello World
// 配置项引用
hello=${msg} liwenxiang

public class tests {
       @Value("${msg}")
       private String name;
	   
	   // 多级自定义属性引用
	   @Value("${hello.msg}")
       private String name;
}
```

##### 随机值 和 随机端口

+ 只会在启动的时候随机生成一次

```
server.port=${random.int[1024,9999]}
num=${random.int}
```

### yml 配置文件

+ 层级分明
+ 语法类似JSON
+ 树装结构
+ 子级和 父级要有层级关系 缩进 不要用Tab要使用空格
+ key: value 的形式  : 后面要有一个空格

### LogBack

+ 也是一个日志记录工具
+ 性能要比log4j高
+ 功能更丰富 支持打印日志到数据库 和 本地
+ SpringBoot 默认已经集成了这个日志工具

### 多环境配置

+ 我们可以将配置文件分为多个不同环境的配置文件 这样在切换环境的时候就显得比较容易了

+ 我们可以将其项目达成jar包 通过java -jar 命令来完成启动 并且通过 --spring.profiles.active=dev 就是你的-{profileName} 就能够启动成功

+ 在IDE中配置

+ ```properties
  # application.properties
  
  spring.profiles.active=prod
  ```

+ ```properties
  # application-dev.properties
  
  spring.datasource.driver-class-name=com.mysql.jdbc.Driver
  spring.datasource.url=jdbc:mysql://localhost:3307/test?characterEncoding=utf-8&useUnicode=true&useJDBCCompliantTimezoneShift=true&useLegacyDatetimeCode=false&serverTimezone=UTC
  spring.datasource.username=root
  spring.datasource.password=root
  spring.datasource.type=com.alibaba.druid.pool.DruidDataSource
  spring.jpa.hibernate.ddl-auto=update
  spring.jpa.show-sql=true
  msg=hello World
  hello=${msg} liwenxiang
  server.port=8888
  
  ```

+ ```properties
  # application-pord.properties
  
  spring.datasource.driver-class-name=com.mysql.jdbc.Driver
  spring.datasource.url=jdbc:mysql://localhost:3307/test?characterEncoding=utf-8&useUnicode=true&useJDBCCompliantTimezoneShift=true&useLegacyDatetimeCode=false&serverTimezone=UTC
  spring.datasource.username=root
  spring.datasource.password=root
  spring.datasource.type=com.alibaba.druid.pool.DruidDataSource
  spring.jpa.hibernate.ddl-auto=update
  spring.jpa.show-sql=true
  msg=hello World
  hello=${msg} liwenxiang
  server.port=8088
  
  ```

### SpringBoot 核心注解

@SpringBootApplication：代表是 SpringBoot 的启动类。

 @SpringBootConfiguration：通过 bean 对象来获取配置信息 

@Configuration：通过对 bean 对象的操作替代 spring 中 xml 文件 

@EnableAutoConfiguration：完成一些初始化环境的配置。 @ComponentScan：来完成 spring 的组件扫描。替代之前我们在 xml 文件中配置组件扫描的 配置<context:component-scanpacage=”....”> 

@RestController:1,表示一个 Controller。2，表示当前这个 Controller 下的所有的方法都会以 json 格式的数据响应

### 监控SpringBoot的健康状况

##### Actuator

+ 导入需要的jar包

+ 关闭安全限制  

+ 启动即可    会有很多Mapper 后面有路径 我们可以直接访问这些路径进行一个访问

  Maven 依赖

  ```xml
  <!-- https://mvnrepository.com/artifact/org.springframework.boot/spring-boot-starter-actuator -->
  <dependency>
      <groupId>org.springframework.boot</groupId>
      <artifactId>spring-boot-starter-actuator</artifactId>
  </dependency>
  ```

###SpringBoot 整合 web层技术

#### 整合Servlet

+ 第一种方式 注解的形式
  + 通过在Servlet上面添加WebServlet注解即可
  + 在启动类中加上ServletComponentScan注解进行扫描WebServlet注解

   **代码**

```java
@WebServlet(name="FirstServlet",urlPatterns = "/first")
public class FirstServlet extends HttpServlet {

    @Override
    protected void doGet(HttpServletRequest req, HttpServletResponse resp) throws ServletException, IOException {
        System.out.println("进到了这里!!!");
    }

    @Override
    protected void doPost(HttpServletRequest req, HttpServletResponse resp) throws ServletException, IOException {
        doGet(req,resp);
    }
}
```

```java
@SpringBootApplication
// 加上这个注解就回去扫描webServlet
@ServletComponentScan
public class ServletApplication {

    public static void main(String[] args) {
        SpringApplication.run(ServletApplication.class,args);
    }

}
```

第二种方式 注解的形式

- 无需注解 通过在启动类中编写方法进行Servlet的注册

**代码**

```java
public class SecondServlet extends HttpServlet {
    @Override
    protected void doGet(HttpServletRequest req, HttpServletResponse resp) throws ServletException, IOException {
        super.doGet(req, resp);
        System.out.println("进到了这里!!!");
    }
}
```

```java
@SpringBootApplication
public class SecondServletApplication {

    public static void main(String[] args) {
        SpringApplication.run(SecondServletApplication.class,args);
    }

    @Bean
    public ServletRegistrationBean resisterServlet(){
        // 这个类是Servlet注册Bean   接受一个Servlet实例
        ServletRegistrationBean registrationBean = new ServletRegistrationBean(new SecondServlet());
        // 添加一个路径
        registrationBean.addUrlMappings("/second");
        // 返回这个Servlet
        return registrationBean;
    }

}
```

####整合Filter

+ 编写Filter
+ 注解形式

```java
@WebFilter(filterName="FilrstFilter",urlPatterns = {"/first","*.do"})
public class FilrstFilter implements Filter {
    @Override
    public void doFilter(ServletRequest servletRequest, ServletResponse servletResponse, FilterChain filterChain) throws IOException, ServletException {
        System.out.println("进入Filter");
        filterChain.doFilter(servletRequest,servletResponse);
        System.out.println("离开Filter");
    }
}
```

+ 启动类

```java
@SpringBootApplication
// 加上这个注解就回去扫描webServlet
@ServletComponentScan
public class ServletApplication {

    public static void main(String[] args) {
        SpringApplication.run(ServletApplication.class,args);
    }

}
```

+ 方法形式

```java
public class SecondServlet extends HttpServlet {
    @Override
    protected void doGet(HttpServletRequest req, HttpServletResponse resp) throws ServletException, IOException {
        super.doGet(req, resp);
        System.out.println("进到了这里!!!");
    }
}
```

```java
@SpringBootApplication
public class FilterApplication {

    public static void main(String[] args) {
        SpringApplication.run(FilterApplication.class,args);
    }

    // 注册Filter
    public FilterRegistrationBean getFilterRegistrationBean(){
        FilterRegistrationBean filterRegistrationBean = new FilterRegistrationBean(new SecondFilter());
        filterRegistrationBean.addUrlPatterns("/first");
        return filterRegistrationBean;
    }

    // 注册Servlet
    public ServletRegistrationBean getServletRegistrationBean(){
        ServletRegistrationBean servletRegistrationBean = new ServletRegistrationBean(new SecondServlet());
        servletRegistrationBean.addUrlMappings("/first");
        return servletRegistrationBean;
    }

}
```

#### 整合Listener

+ 注解形式

```java
@WebListener
public class ServletContextListenerFirst implements ServletContextListener {

    @Override
    public void contextInitialized(ServletContextEvent sce) {
        System.out.println("监听器初始化。。。。");
    }

    @Override
    public void contextDestroyed(ServletContextEvent sce) {

    }
}
```

```java
@SpringBootApplication
@ServletComponentScan
public class ListenerApplication {
    public static void main(String[] args) {
        SpringApplication.run(ListenerApplication.class,args);
    }
}
```

#### 访问静态资源

+ 默认访问static文件夹下的内容
+ 名字必须是static
+ 下面可以创建各种静态资源文件夹进行访问
+ 例如static/a.png
+ 访问    localhost:8080/.a.png  即可

#### 文件上传

+ 控制器

```java
@RestController
public class FileUploadController {
     @RequestMapping("/fileUploadController")
     public Map<String,Object> fileupload(@RequestParam("filename") MultipartFile filename) throws IOException {
            Map<String,Object> map = new HashMap<>();
            map.put("name",filename.getOriginalFilename());
            map.put("size", filename.getSize());
            map.put("msg","ok");
            filename.transferTo(new File("upload/up.png"));
            return map;
     }
}
```

```properties
# 配置
# 单个文件的上传大小限制
spring.http.multipart.max-file-size=200MB
# 总上传大小配置
spring.http.multipart.max-request-size=200MB
```

```java
// 启动类
@SpringBootApplication
public class FileUploadApplication {
    public static void main(String[] args) {
        SpringApplication.run(FileUploadApplication.class,args);
    }
}
```

### SpringBoot 整合 视图层技术

#### JSP

+ 不推荐使用
+ maven 依赖

```xml
<dependency>
    <groupId>org.springframework.boot</groupId>
    <artifactId>spring-boot-starter-test</artifactId>
    <scope>test</scope>
</dependency>
<dependency>
    <groupId>javax.servlet</groupId>
    <artifactId>jstl</artifactId>
</dependency>
```

#### Freemarker

+ maven 依赖

```xml&#39;
<dependency>
    <groupId>org.springframework.boot</groupId>
    <artifactId>spring-boot-starter-freemarker</artifactId>
</dependency>
```

+ 编写模板文件
  + 必须放在resources文件夹下面的templates文件夹下
  + 后缀名为 ftl
+ Controller

```java
package com.liwenxiang.springboot.demo01.controller;

import com.liwenxiang.springboot.demo01.pojo.User;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.RequestMapping;

import java.util.ArrayList;
import java.util.List;

@Controller
public class FreemarkerController {

    @RequestMapping("/showUser")
    public String getUser(Model model){
        List<User> list = new ArrayList<>();
        list.add(new User(20,"张三",20));
        list.add(new User(21,"李四",22));
        list.add(new User(22,"王五",25));
        model.addAttribute("list",list);
        // 模板文件的名字
        return "index";
    }
}
```

```html
<!DOCTYPE html>
<html lang="html">

<head>
    <meta charset="UTF-8"/>
     <title> Freemarker </title>
 </head>
<body>
<table border="1" cellspacing="0" cellpadding="0" width="50%" align="center">
    <!-- 遍历 -->
    <#list list as user>
          <tr>
              <th>${user.id}</th>
              <th>${user.name}</th>
              <th>${user.age}</th>
          </tr>
    </#list>
</table>
</body>
</html>
```

+ 启动器

```java
@SpringBootApplication
public class FreemarkerApplication {
    public static void main(String[] args) {
        SpringApplication.run(FreemarkerApplication.class,args);
    }
}
```

#### Thymeleaf[常用]

+ maven 依赖
+ 会多出三个jar
+ 也需要将模板文件放到templates文件夹下面 该文件夹是安全的是无法通过外接直接访问的
+ 后缀名是html

```xml
<dependency>
    <groupId>org.springframework.boot</groupId>
    <artifactId>spring-boot-starter-thymeleaf</artifactId>
</dependency>
```

+ 3.0.2之前的版本对于HTML的解析比较严格 标签不能没有结束标签 否则就会报错的
+ idea 引入约束 可以提示      xmlns:th="http://www.thymeleaf.org"

#####String 操作

**输出显示**

th:text="hello"   代表输出一个文本内容

th:text="${msg}"    解析我们传递的域属性变量

th:value="${msg}"   一般作用在input输入框上面 可以直接设置输入框的值

th:field="${xxx}"   做数据回显使用

th:text="${#strings.isEmpty(msg)}"   判断是否为空   true false

th:text="${#strings.contains(msg,'T')}"  判断是否包含某一个字符或者字符串  true false

th:text="${#strings.startsWith(msg,'T')}"  判断是否以一个字符或者字符串开头  true false

th:text="${#strings.length(msg)}"  返回长度

th:text="${#strings.endsWith(msg,'T')}"   判断是否以某一个字符结尾

th:text="${#strings.toUpperCase(msg)}"  转换为大写

th:text=“${#strings.toLowerCase(msg)}”  转换为小写

th:text="${#strings.substring(msg,13,16)}"  截取字符串

th:errors="${obj.name}"  获取到错误信息

##### Date 操作

th:text="${#dates.format(date,'yyy/MM/dd')}"   如果不传递格式的话默认会取当前浏览器的语言进行格式化

th:text="${#dates.year(date)}"   取年

th:text="${#dates.month(date)}"   取月份

th:text="${#dates.day(date)}"  取日

#####判断操作

th:if="${msg} == '男'"

th:if="${#strings.substring(msg,0,2)} == 'Th'"

th:switch="${msg}"

​	th:case="123"

##### 迭代遍历

list

```html
<table border="1">
     <!--/*@thymesVar id="list" type="ch"*/-->
     <tr th:each="user,var : ${list}">
           <td th:text="${user}"></td>
           <td th:text="${var.count}"></td>
           <td th:text="${var.size}"></td>
           <td th:text="${var.index}"></td>
           <td th:text="${var.odd}"></td>
           <td th:text="${var.even}"></td>
           <td th:text="${var.first}"></td>
           <td th:text="${var.last}"></td>
     </tr>
</table>
```

map

```html
<table border="1">
     <!--/*@thymesVar id="map" type="ch"*/-->
     <tr th:each="maps : ${map}">
         <td th:each="m : ${maps}" th:text="${m.value}"></td>
         <td th:each="m : ${maps}" th:text="${m.value}"></td>
         <td th:each="m : ${maps}" th:text="${m.value}"></td>
     </tr>
</table>
```

##### 域对象取值

HttpServletRequest

​	th:text="${#httpServletRequest.getAttribute('msg')}"

HttpSession

​	${session.sessionMsg}

ServletContext

​	 ${application.app}

```html
Request:<span th:text="${#httpServletRequest.getAttribute('msg')}"></span>
Session:<span th:text="${session.session}"></span>
Application:<span th:text="${application.app}"></span>
```

##### URL 表达式

th:href="@{}"

th:src="@{}"

基础语法  @{}

绝对路径  

th:href="@{http://www.baidu.com}"

相对路径  

**相对于项目的根**

th:href="@{/show}"

th:href="@{/show(name=1,age=18)}"

th:href="@{/show/1/2}"

```html
<a th:href="@{/show(name=liwenxiang)}">show</a>
```

**相对于服务器的根**

th:href="@{~/project2/show}"

```html
<a th:href="@{~/project2/show(name=liwenxiang)}">show</a>
```

### SpringBoot 整合持久层技术

###### mybatis

Maven依赖

```xml
<dependency>
    <groupId>org.mybatis.spring.boot</groupId>
    <artifactId>mybatis-spring-boot-starter</artifactId>
    <version>1.3.2</version>
</dependency>

<dependency>
    <groupId>mysql</groupId>
    <artifactId>mysql-connector-java</artifactId>
</dependency>

<dependency>
    <groupId>com.alibaba</groupId>
    <artifactId>druid</artifactId>
    <version>1.0.26</version>
</dependency>
```

数据源配置

```properties
spring.datasource.driver-class-name=com.mysql.jdbc.Driver
spring.datasource.url=jdbc:mysql://47.94.144.235:3306/baoluo_crm?characterEncoding=utf-8&useUnicode=true&useJDBCCompliantTimezoneShift=true&useLegacyDatetimeCode=false&serverTimezone=UTC
spring.datasource.username=root
spring.datasource.password=root
spring.datasource.type=com.alibaba.druid.pool.DruidDataSource
mybatis.type-aliases-package=com.liwenxiang.demo.demo02.pojo
mybatis.mapper-locations=classpath:mapper-xml/*.xml
```

启动器

```java
@SpringBootApplication
@MapperScan("com.liwenxiang.demo.demo02.mapper")
public class Demo02Application {
    public static void main(String[] args) {
        SpringApplication.run(Demo02Application.class, args);
    }
}
```

**其他操作照常即可**

######整合 增删改查

```java
package com.liwenxiang.demo.demo02.controller;

import com.liwenxiang.demo.demo02.pojo.Users;
import com.liwenxiang.demo.demo02.service.UsersService;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.RequestMapping;

import javax.annotation.Resource;
import java.util.List;

@Controller
public class UsersController {

    @Resource
    UsersService usersService;

    @RequestMapping("/")
    public String index(){
        return "index";
    }


    @RequestMapping("/addUser")
    public String add(Users users){
        if (null != users && null != users.getAge() && null != users.getName()){
             usersService.insertUser(users);
        }
        return "forward:/list";
    }

    @RequestMapping("/list")
    public String list(Model model){
        List<Users> users = usersService.selectUsers();
        model.addAttribute("users",users);
        return "list";
    };

    @RequestMapping("/del")
    public String del(Integer id){
        usersService.delUser(id);
        return "redirect:/list";
    };

    @RequestMapping("/findOne")
    public String findOne(Integer id,Model model){
        Users byIdUser = usersService.findByIdUser(id);
        model.addAttribute("user",byIdUser);
        return "update";
    };

    @RequestMapping("/update")
    public String update(Users users){
        System.out.println(users);
        Integer integer = usersService.updateUsers(users);
        return "redirect:/list";
    };
}
```

```xml
<?xml version="1.0" encoding="utf-8" ?>
<!DOCTYPE mapper
        PUBLIC "-//mybatis.org//DTD Mapper 3.0//EN" "http://mybatis.org/dtd/mybatis-3-mapper.dtd">
<mapper namespace="com.liwenxiang.demo.demo02.mapper.UsersMapper">

          <insert parameterType="com.liwenxiang.demo.demo02.pojo.Users" id="insertUser">
              INSERT INTO test (name,age) VALUES (#{name},#{age})
          </insert>

          <select id="findByIdUser"  resultType="Users">
              SELECT * FROM test WHERE id = #{id}
          </select>

          <update id="updateUsers" parameterType="Users">
              UPDATE test SET name=#{name},age=#{age} WHERE id = #{id}
          </update>

          <select id="selectUsers" resultType="Users">
              SELECT * FROM test
          </select>

            <delete id="delUser">
               DELETE FROM test WHERE id = #{id}
            </delete>
</mapper>
```

```java
package com.liwenxiang.demo.demo02.mapper;

import com.liwenxiang.demo.demo02.pojo.Users;
import org.springframework.stereotype.Component;

import java.util.List;

@Component
public interface UsersMapper {

     Integer insertUser(Users user);

     List<Users>  selectUsers();

     Users findByIdUser(Integer id);

     Integer updateUsers(Users users);

     Integer delUser(Integer id);
}
```

```java
package com.liwenxiang.demo.demo02.service.impl;

import com.liwenxiang.demo.demo02.mapper.UsersMapper;
import com.liwenxiang.demo.demo02.pojo.Users;
import com.liwenxiang.demo.demo02.service.UsersService;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import javax.annotation.Resource;
import java.util.List;

@Service
@Transactional
public class UsersServiceImpl implements UsersService {

    @Resource
    UsersMapper usersMapper;

    @Override
    public Integer insertUser(Users user) {
        return usersMapper.insertUser(user);
    }

    @Override
    public List<Users> selectUsers() {
        return usersMapper.selectUsers();
    }

    @Override
    public Users findByIdUser(Integer id) {
        return usersMapper.findByIdUser(id);
    }

    @Override
    public Integer updateUsers(Users users) {
        return usersMapper.updateUsers(users);
    }

    @Override
    public Integer delUser(Integer id) {
        return usersMapper.delUser(id);
    }
}
```

```java
public interface UsersService {

    Integer insertUser(Users user);

    List<Users> selectUsers();

    Users findByIdUser(Integer id);

    Integer updateUsers(Users users);

    Integer delUser(Integer id);

}
```

### 异常处理

##### 定制错误页面

SpringBoot默认会在static文件夹下面找404.html

我们可以在static下面新建一个文件夹error在下面创建404.html或者500.html

在页面中可以通过 ${exception} 来获取到错误信息  这种方式可以跳转到指定的错误页面

**一个页面**

全部跳转到一个错误页面的话  直接在  templates 下面创建error.html 即可   名字必须是error 获取错误信息和上面一样

##### @ExceptionHandler(value={})

注解异常 接受一个数组 里面传递异常参数的Class对象

@ExceptionHandler(value={NullPointerException.class})

public ModelAndView exception(Exception exception){

​		ModelAndView model = new ModelAndView();

​		model.addObject("error",e.toString());

​	        模板路径

​		model.setViewName("error1");

​		return mv;

}

```java
@ExceptionHandler(value = {ArithmeticException.class})
public ModelAndView execption(Exception ex){
    ModelAndView modelAndView = new ModelAndView();
    modelAndView.addObject("error",ex.toString());
    modelAndView.setViewName("error");
    return modelAndView;
}
```

#####@ControllerAdvice + @ ExceptionHandler

可复用的异常 这样我们就不需要在每一个控制器里面都写异常处理了  我们通过新创建一个类在类上面注解@ControllerAdvice然后在类里面正常编写@ExceptionHandler即可

```java
package com.liwenxiang.demo.demo02.globalException;


import org.springframework.web.bind.annotation.ControllerAdvice;
import org.springframework.web.bind.annotation.ExceptionHandler;
import org.springframework.web.servlet.ModelAndView;

@ControllerAdvice
public class ExceptionGlobal {

    @ExceptionHandler(value = {ArithmeticException.class})
    public ModelAndView execption(Exception ex){
        ModelAndView modelAndView = new ModelAndView();
        modelAndView.addObject("error",ex.toString());
        modelAndView.setViewName("error");
        return modelAndView;
    }

    @ExceptionHandler(value = {NullPointerException.class})
    public ModelAndView NullPointerException(Exception ex){
        ModelAndView modelAndView = new ModelAndView();
        modelAndView.addObject("error",ex.toString());
        modelAndView.setViewName("error");
        return modelAndView;
    }
    
    // 可以返回一个JSON串
     @ExceptionHandler(value = {NullPointerException.class})
    @ResponseBody
    public Map<String,Object> NullPointerException(Exception ex){
       Map<String,Object> map = new HashMap<Sring,Object>();
        return modelAndView;
    }
    
}
```



##### SimpleMappingExceptionResolver

是对第三种的简化  但是不能够传递异常对象

```java
package com.liwenxiang.demo.demo02.globalException;

import org.springframework.context.annotation.Configuration;
import org.springframework.web.servlet.handler.SimpleMappingExceptionResolver;

import java.util.Properties;

@Configuration
public class global {
	
    // 加上这个注解  SpringBoot会在启动前对这个类进行处理 Configuration
    @Bean
    public SimpleMappingExceptionResolver simpleMappingExceptionResolver(){
        SimpleMappingExceptionResolver simpleMappingExceptionResolver = new SimpleMappingExceptionResolver();
        Properties properties = new Properties();
        properties.put("java.lang.NullPointerException","error");
        simpleMappingExceptionResolver.setExceptionMappings(properties);
        return simpleMappingExceptionResolver;
    }

}
```

##### HandlerExceptionResolver

```java
package com.liwenxiang.demo.demo02.globalException;

import org.apache.ibatis.jdbc.Null;
import org.springframework.context.annotation.Bean;
import org.springframework.context.annotation.Configuration;
import org.springframework.web.servlet.HandlerExceptionResolver;
import org.springframework.web.servlet.ModelAndView;
import org.springframework.web.servlet.handler.SimpleMappingExceptionResolver;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import java.util.Properties;

@Configuration
public class global implements HandlerExceptionResolver {
    
    @Override
    public ModelAndView resolveException(HttpServletRequest httpServletRequest, HttpServletResponse httpServletResponse, Object o, Exception e) {
        ModelAndView modelAndView = new ModelAndView();
        if (e instanceof NullPointerException){
               modelAndView.setViewName("error1");
        }else if (e instanceof ArithmeticException){
               modelAndView.setViewName("error2");
        }
         modelAndView.addObject("error",e.toString());
        return modelAndView;
    }
}
```

###数据校验

+ 使用的使hibernate-validate框架进行校验
+ SpringBoot默认已经集成了  我们不用再需要导入jar
+ 使用
+ 我们可以在实体类中加上验证的注解
+ @NotBlank(messag="xxx")  判断是否为null琥珀这是否是一个空串 取出 前后空格
+ @NotEmpty(message="xxx") 判断是否是null或者空船 不会去除首尾空格
+ @Max(value=15)   最大值
+ @Min(values=2)   最小值
+ @Email  验证邮箱
+ @Length(min=2,max=6)  验证长度
+ @Pattern()  正则匹配
+ 在控制器中我们需要在验证的方法中的实体类前面加上@Valid注解  并且在后面的参数中注入一个BindingResult result  对象
+ 里面可以有 hasError()方法 进行判断  如果返回true就是有错误信息 我们返回到进入到此控制器的页面中
+ 在页面中我们可以通过 th:error="${users.name}" 获取到错误信息  实际上在进行跳转的时候 SpringMvc默认包装了一个ModelAndView对像 这个对象的key就是实体类的名字 默认是  可以使用@ModelAttribute("name") 进行修改  那么在页面中就通过这个key获取直接.属性名称即可
+ 我们需要在验证经过的任意一个方法中加上我们验证的实体类  否则就会报错 找不到某一个key

```java
public class Users {
    private Integer id;
    @NotBlank
    private String  name;
    @Min(value = 1)
    private Integer age;
    public Users(Integer id, String name, Integer age) {
        this.id = id;
        this.name = name;
        this.age = age;
    }
    public Users() {
    }
    public Integer getId() {
        return id;
    }
    public void setId(Integer id) {
        this.id = id;
    }
    public String getName() {
        return name;
    }
    public void setName(String name) {
        this.name = name;
    }
    public Integer getAge() {
        return age;
    }
    public void setAge(Integer age) {
        this.age = age;
    }
    @Override
    public String toString() {
        return "Users{" +
                "id=" + id +
                ", name='" + name + '\'' +
                ", age=" + age +
                '}';
    }
}
```

```java
//都需要加上验证的实体  否则获取不到key
@RequestMapping("/validate")
public String validate(Users users){
    return "validate";
};
@RequestMapping("/validate")
public String validate(Users users){
    return "validate";
};
// 可以通过ModelAttribute注解来自定义
@RequestMapping("/validated")
public String validated(@ModelAttribute("myName") @Valid Users users, BindingResult result){
    if (result.hasErrors()){
        return "validate";
    }
    return "list";
};
```

```html
<form  th:action="@{/validated}" method="post">
    用户名: <input type="text" name="name"/><font th:errors="${users.name}" color="red"></font>
    年龄: <input type="number" name="age"/><font th:errors="${users.age}" color="red"></font>
    <input type="submit"/>
</form>
```

### 单元测试

+ 在maven的Test包下面

```java
@RunWith(SpringRunner.class)
@SpringBootTest
public class Demo02ApplicationTests {

    @Test
    public void contextLoads() {
        System.out.println("Test.........");
    }

}
```

###SpringBoot 缓存技术

**SpringBoot整合Ehcache**

配置

 maven 依赖

 ```xml
<!-- https://mvnrepository.com/artifact/org.springframework.boot/spring-boot-starter-cache -->
<dependency>
    <groupId>org.springframework.boot</groupId>
    <artifactId>spring-boot-starter-cache</artifactId>
    <version>2.1.3.RELEASE</version>
</dependency>

<!-- https://mvnrepository.com/artifact/net.sf.ehcache/ehcache -->
<dependency>
    <groupId>net.sf.ehcache</groupId>
    <artifactId>ehcache</artifactId>
    <version>2.10.4</version>
</dependency>
 ```

ehcache.xml 配置文件

```xml
<ehcache xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:noNamespaceSchemaLocation="http://ehcache.org/ehcache.xsd">
    <diskStore path="java.io.tmpdir"/>
    <!-- ehcache默认的缓存策略 -->
    <!-- maxElementsInMemory 最多在内存中缓存多少对象 -->
    <!-- eternal 是否需要持久化  -->
    <!-- timeToIdleSeconds 访问一个对象要多长时间 超过了 ehcache 删除这个对象 单位是秒  -->
    <!-- timeToLiveSeconds 一个对象存活要多长时间 超过了 ehcache 删除这个对象 单位是秒  -->
    <defaultCache
            maxElementsInMemory="10000"
            eternal="false"
            timeToIdleSeconds="120"
            timeToLiveSeconds="120"
            maxElementsOnDisk="10000000"
            diskExpiryThreadIntervalSeconds="120"
            memoryStoreEvictionPolicy="LRU">
        <persistence strategy="localTempSwap"/>
    </defaultCache>
    <!-- 自定义缓存策略  可以出现多个  但是需要加上一个name  如果有多个cache name的值不能相同-->
    <cache name="users"
           maxElementsInMemory="10000"
           eternal="false"
           timeToIdleSeconds="120"
           timeToLiveSeconds="120"
           maxElementsOnDisk="10000000"
           diskExpiryThreadIntervalSeconds="120"
           memoryStoreEvictionPolicy="LRU">
        <persistence strategy="localTempSwap"/>
    </cache>
</ehcache>
```

告诉SpringBoot我们使用ehcache缓存

```properties
spring.cache.ehcache.config=classpath:ehcache.xml
```

修改启动类 加上@EnableCaching注解启动缓存

```java
@SpringBootApplication
@EnableCaching
public class Demo03Application {
    public static void main(String[] args) {
        SpringApplication.run(Demo03Application.class, args);
    }
}
```

使用

我们需要在需要缓存的对象上面加上@Cacheable注解标明该方法需要缓存  但是要求缓存的对象实现Serialize序列化接口  因为Ehcache支持将数据缓存到磁盘中

我们如果直接写@Cacheable的话会使用ehcache的默认缓存策略 但是我们可以自己指定缓存策略 在里面有一个value属性 我们可以通过这个value属性指定我们在ehcache配置文件中配置的自定义缓存策略的name的值即可

**代码**

```java
@Service
public class UsersServiceImpl implements UsersService {
    @Override
    @Cacheable(value = "users")  必须加value
    public List<Users> findAllUsersInfo() {
        List<Users> users = new ArrayList<>();
        users.add(new Users(1,BigDecimal.valueOf(132),"pick"));
        return users;
    }
    
 	@CacheEvict(value="users",allEntries=true) 必须加value
    public Integer insertTestData(Test test) {
		users.insertData(test);	
    }
}
```

```
@SpringBootApplication
@EnableCaching
public class Demo03Application {

    public static void main(String[] args) {
        SpringApplication.run(Demo03Application.class, args);
    }

}
```

**@Cacheable**

就是将我们的方法返回值放入到缓存中做缓存

value=""  这个属性可以是我们取选择我们的自定义缓存策略

key=""      ehcache 在缓存中读取数据的时候默认都是通过这个key标识的  如果缓存中没有对应要查询的key那么就回去数据库进行检索   默认的key是我们的实体类的变量名 #users  如果我们需要修改key的话需要这么修改  #users.pageSize 这样就可以进行修改 前面必须加上一个#  如果去查询的时候key还能够检索到 那么就不会取数据库进行查询  就相当是一个标识 为每一个对象产生一个标识

**@CacheEvict(value="users",allEntries=true)**

这个注解的作用是清楚缓存 一般作用在添加的操作上面   如果我们在添加的时候不清楚缓存可能会造成查询出来的数据和数据库的实际数据不一致的问题      value还是缓存策略 一般和缓存的策略一样  

**SpringBoot整合 SpringData Redis**

+ 安装Redis
+ 由于Redis是使用C语言编写的 那么在安装的时候就需要GCC编译器
+ yum install gcc-c++   
+ 或者是
+ yum install -y gcc g++ gcc-c++ make
+ 如果make还是报错就使用  make MALLOC=libc  命令
+ 然后使用   make PREFIX=/usr/local/redis install   即可
+ 使用客户端工具进行链接  需要关闭Linux防火墙

##### Spring Data Redis 

+ 是SpringData下的一个模块 目的是为了简化对redis的操作

+ maven 依赖

+ ```xml
  <!-- https://mvnrepository.com/artifact/org.springframework.boot/spring-boot-starter-data-redis -->
  <dependency>
      <groupId>org.springframework.boot</groupId>
      <artifactId>spring-boot-starter-data-redis</artifactId>
      <version>2.1.3.RELEASE</version>
  </dependency>
  ```

+  配置  JedisPoolConfig

+ 配置文件  非常的重要

+ **String**

+ ```java
  package com.liwenxiang.springboot.redis.demo03.config;
  
  import org.springframework.context.annotation.Bean;
  import org.springframework.context.annotation.Configuration;
  import org.springframework.data.redis.connection.jedis.JedisConnectionFactory;
  import org.springframework.data.redis.core.RedisTemplate;
  import org.springframework.data.redis.serializer.StringRedisSerializer;
  import redis.clients.jedis.JedisPoolConfig;
  
  @Configuration
  public class RedisConfigPool {
  
       @Bean
       public JedisPoolConfig jedisPoolConfig(){
  
           JedisPoolConfig jedisPoolConfig = new JedisPoolConfig();
           // 最大空闲数
           jedisPoolConfig.setMaxIdle(10);
           // 最小空闲数
           jedisPoolConfig.setMinIdle(5);
           // 最大链接数
           jedisPoolConfig.setMaxTotal(100);
  
           return jedisPoolConfig;
       }
  
       @Bean
       public JedisConnectionFactory jedisConnectionFactory(JedisPoolConfig poolConfig){
             JedisConnectionFactory factory = new JedisConnectionFactory();
             factory.setPoolConfig(poolConfig);
             factory.setHostName("192.168.190.139");
             factory.setPort(6379);
             factory.setPassword("123456");
             return factory;
       }
  
      // RedisTemplate<String,Object> 是 SpringData 提供的一个操作Redis的模板
       @Bean
       public RedisTemplate<String,Object> redisTemplate(JedisConnectionFactory jedisConnectionFactory){
           RedisTemplate<String,Object> template = new RedisTemplate<>();
           template.setConnectionFactory(jedisConnectionFactory);
           // 序列化的意思好比就是我们以后需要给数据库中存储对象 不可能将java对象直接添加进去吧 所以SpringData给我们提供了一些序列化的类 帮助我们完成这个操作  自动的会进行转换  那么下面的这个是Strinf的序列化串
           // 这个是序列化key  
           template.setKeySerializer(new StringRedisSerializer());
           // 序列化Value   
           template.setValueSerializer(new StringRedisSerializer());
           return template;
       }
  
  }
  ```

  ```java
  // 测试使用
  @RunWith(SpringRunner.class)
  @SpringBootTest()
  public class Demo03ApplicationTests {
  
          @Resource
           TestService testService;
  
          @Resource
           RedisTemplate<String,Object> template;
  
           @Test
          public void test(){
               List<com.liwenxiang.springboot.redis.demo03.pojo.Test> allTestInfo = testService.findAllTestInfo();
               for (com.liwenxiang.springboot.redis.demo03.pojo.Test test : allTestInfo) {
                   System.out.println(test);
               }
           }
  
           @Test
           public void test1(){
               // 设置值
               template.opsForValue().set("name","liWenXiAng");
               // 设置过期时间
               template.expire("name",20, TimeUnit.SECONDS);
               // 获取值
               String name = (String) template.opsForValue().get("name");
               System.out.println(name);
           }
  
  }
  ```



##### 提取Redis链接信息

+ 我们现在配置的redis链接池信息 还有redis的配置信息 都是在一个类中配置的 但是以后项目上线的时候可能用的redis服务器是不一样的 这样总不能去修改源代码吧  一般我们都是将其写到配置文件中去

+ 提取

  + 获取的时候通过 @ConfigurationProperties(prefix="spring.redis.pool")   这个注解加载方法上面或者类上面  前缀是我们自己起的名字  后面的必须要和SpringBoot需要的属性一致 例如 MaxIdle 就是 max-idle

  + 配置信息

  + ```java
    @Configuration
    public class RedisConfigPool {
    
         @Bean
         @ConfigurationProperties(prefix = "spring.redis.jedis.pool")
         public JedisPoolConfig jedisPoolConfig(){
    
             JedisPoolConfig jedisPoolConfig = new JedisPoolConfig();
             // 最大空闲数
    //         jedisPoolConfig.setMaxIdle(10);
             // 最小空闲数
    //         jedisPoolConfig.setMinIdle(5);
             // 最大链接数
    //         jedisPoolConfig.setMaxTotal(100);
    
             return jedisPoolConfig;
         }
    
         @Bean
         @ConfigurationProperties(prefix = "spring.redis")
         public JedisConnectionFactory jedisConnectionFactory(JedisPoolConfig poolConfig){
               JedisConnectionFactory factory = new JedisConnectionFactory();
               factory.setPoolConfig(poolConfig);
    //           factory.setHostName("192.168.190.139");
    //           factory.setPort(6379);
    //           factory.setPassword("123456");
               return factory;
         }
    
         @Bean
         public RedisTemplate<String,Object> redisTemplate(JedisConnectionFactory jedisConnectionFactory){
             RedisTemplate<String,Object> template = new RedisTemplate<>();
             template.setConnectionFactory(jedisConnectionFactory);
             template.setKeySerializer(new StringRedisSerializer());
             template.setValueSerializer(new StringRedisSerializer());
             return template;
         }
    
    }
    ```

  + ```properties
    # 后面的-前后的内容必须要和需要的设置的属性名字一样单词之间用-隔开 因为Spring就是根据他的属性名去注入的
    spring.redis.jedis.pool.min-idle=5
    spring.redis.jedis.pool.max-idle=10
    spring.redis.jedis.pool.max-total=20
    spring.redis.host-name=192.168.190.139
    spring.redis.port=6379
    spring.redis.password=123456
    ```

##### Spring Data Redis 存取对象

+ 首先这种存储的方式比存储JSON要占用空间差不多大五倍  视情况而定 但是这种序列化到redis数据中的信息是看不出来的 是乱码的 安全一些  

+ 序列化为对对象要求我们的实体类实现Serialize接口 

+ 在进行设置值之前进行一个value的序列化器的改变

+ 如果是对象的话我们使用JDK的序列化器  new JdkSerializationRedisSerializer();

+ ```java
  @Test
  public void user(){
       com.liwenxiang.springboot.redis.demo03.pojo.Test t = new com.liwenxiang.springboot.redis.demo03.pojo.Test(1, "liwenxiang",1);
       this.template.setValueSerializer(new JdkSerializationRedisSerializer());
       this.template.opsForValue().set("tests",t);
       System.out.println("成功");
   }
  
  @Test
  public void tests(){
      this.template.setValueSerializer(new JdkSerializationRedisSerializer());
      com.liwenxiang.springboot.redis.demo03.pojo.Test t = (com.liwenxiang.springboot.redis.demo03.pojo.Test) this.template.opsForValue().get("tests");
      System.out.println("成功");
      System.out.println(t);
  }
  ```

SpringDataRedis 存储Json对象

+ 相对于存储对象来说 步骤都是一样的差不多 还有的就是序列化器不一样我们可以使用jackson2这个序列化器或者Genernate这个序列化器

+ ```java
  @Test
  public void user(){
       com.liwenxiang.springboot.redis.demo03.pojo.Test t = new com.liwenxiang.springboot.redis.demo03.pojo.Test(1, "liwenxiang",1);
       this.template.setValueSerializer(new Jackson2JsonRedisSerializer<>(com.liwenxiang.springboot.redis.demo03.pojo.Test.class));
       this.template.opsForValue().set("tests",t);
       System.out.println("成功");
   }
  
  @Test
  public void tests(){
      this.template.setValueSerializer(new Jackson2JsonRedisSerializer<>(com.liwenxiang.springboot.redis.demo03.pojo.Test.class));
      com.liwenxiang.springboot.redis.demo03.pojo.Test t = (com.liwenxiang.springboot.redis.demo03.pojo.Test) this.template.opsForValue().get("tests");
      System.out.println("成功");
      System.out.println(t);
  }
  ```

+ 需要注意的使 在存储的时候和获取的时候的序列化器要一致

+ JSON的时候需要传递要序列化的对象的class对象

### SpringBoot 定时任务

##### Scheduled 定时任务器

+ 这个是Spring3.0之后自带的一个定时任务器  相对来说比较简单 如果我们的系统中的定时任务比较简单 那就可以使用这个

+ maven 依赖  添加如下依赖即可

+ ```properties
  <dependency>
      <groupId>org.springframework</groupId>
      <artifactId>spring-context-support</artifactId>
  </dependency>
  ```

+ 创建一个定时任务包 然后创建一个类 加上@Component注解 标识被Spring管理 然后就开始编写方法 在方法中上加上@Scheduled(corn="0/2 * * * * * ?") 注解 加上这个注解就代表的使这是一个定时任务方法

+ 代码

+ 启动类  

+ ```java
  @SpringBootApplication
  @EnableCaching
  // 重要加上这个注解 开启定时任务
  @EnableScheduling
  @MapperScan("com.liwenxiang.springboot.redis.demo03.dao")
  public class Demo03Application {
  
      public static void main(String[] args) {
          SpringApplication.run(Demo03Application.class, args);
      }
  
  }
  ```

```java
package com.liwenxiang.springboot.redis.demo03.Scheduled;

import org.springframework.scheduling.annotation.Scheduled;
import org.springframework.stereotype.Component;

@Component
public class Scheduleds {
		
      @Scheduled(cron = "0/2 * * * * ?")
      public void ScheduledMethod(){
            System.out.println(123);
      }

}
```

+ cron 表达式
+ 这是一个日期的表达式  一般有两种形式  一个是7个选项 一个是6个选项 一般使用6个的
+ Cron 有如下两种语法格式：
  （1） Seconds Minutes Hours Day Month Week Year
  （2）Seconds Minutes Hours Day Month Week
+ corn从左到右（用空格隔开）：秒 分 小时 月份中的日期 月份 星期中的日期（一般使用? 标识一个占位） 年份
  + 二、各字段的含义
    位置 时间域名 允许值 允许的特殊字符
    1 	秒 		0-59	 		, - * /
    2 	分钟 	0-59	 		, - * /
    3 	小时 	0-23 			, - * /
    4 	日 		1-31 			, - * / L W C
    5 	月 		1-12 			, - * /
    6 	星期 	1-7 ,			 - * ? / L C #
    7 	年(可选)  1970-2099		 , - * /

```txt
Cron 表达式的时间字段除允许设置数值外，还可使用一些特殊的字符，提供列表、范围、通配符等功 能，细说如下

●星号(*)：可用在所有字段中，表示对应时间域的每一个时刻，例如，*在分钟字段时，表示“每分钟”； 
●问号（?）：该字符只在日期和星期字段中使用，它通常指定为“无意义的值”，相当于占位符；
●减号(-)：表达一个范围，如在小时字段中使用“10-12”，则表示从 10 到 12 点，即 10,11,12；
●逗号(,)：表达一个列表值，如在星期字段中使用“MON,WED,FRI”，则表示星期一，星期三和星期五;
●斜杠(/)：x/y 表达一个等步长序列，x 为起始值，y 为增量步长值。如在分钟字段中使用 0/15，则 表示为 0,15,30和 45 秒，而 5/15 在分钟字段中表示 5,20,35,50，你也可以使用*/y，它等同于 0/y
●L：该字符只在日期和星期字段中使用，代表“Last”的意思，但它在两个字段中意思不同。L 在日期 字段中，表示这个月份的最后一天，如一月的 31 号，非闰年二月的 28 号；如果 L 用在星期中，则表示星 期六，等同于 7。但是，如果 L 出现在星期字段里，而且在前面有一个数值 X，则表示“这个月的最后 X 天”， 例如，6L 表示该月的最后星期五； 
●W：该字符只能出现在日期字段里，是对前导日期的修饰，表示离该日期最近的工作日。例如 15W 表示离该月 15 号最近的工作日，如果该月 15 号是星期六，则匹配 14 号星期五；如果 15 日是星期日， 则匹配 16 号星期一；如果 15 号是星期二，那结果就是 15 号星期二。但必须注意关联的匹配日期不能够 跨月，如你指定 1W，如果 1 号是星期六，结果匹配的是 3 号星期一，而非上个月最后的那天。W 字符串 只能指定单一日期，而不能指定日期范围； 
●LW组合：在日期字段可以组合使用 LW，它的意思是当月的最后一个工作日；
●井号(#)：该字符只能在星期字段中使用，表示当月某个工作日。如 6#3 表示当月的第三个星期五(6 表示星期五，#3 表示当前的第三个)，而 4#5 表示当月的第五个星期三，假设当月没有第五个星期三， 忽略不触发； 
● C：该字符只在日期和星期字段中使用，代表“Calendar”的意思。它的意思是计划所关联的日期， 如果日期没有被关联，则相当于日历中所有日期。例如 5C 在日期字段中就相当于日历 5 日以后的第一天。 1C 在星期字段中相当于星期日后的第一天。 
Cron 表达式对特殊字符的大小写不敏感，对代表星期的缩写英文大小写也不敏感。

例子: @Scheduled(cron = "0 0 1 1 1 ?")//每年一月的一号的 1:00:00 执行一次

@Scheduled(cron = "0 0 1 1 1,6 ?") //一月和六月的一号的 1:00:00 执行一次

@Scheduled(cron = "0 0 1 1 1,4,7,10 ?") //每个季度的第一个月的一号的 1:00:00 执行一次

@Scheduled(cron = "0 0 1 1 * ?")//每月一号 1:00:00 执行一次

@Scheduled(cron="0 0 1 * * *") //每天凌晨 1 点执行一次

@Scheduled(cron="0 0 0 * * *") //每天凌晨 0 点执行一次

```

##### Quartz 框架

+ maven 依赖

+ ```xml
  <dependency>
      <groupId>org.springframework</groupId>
      <artifactId>spring-context-support</artifactId>
  </dependency>
  <!-- Sprng tx 坐标 -->
  <dependency>
      <groupId>org.springframework</groupId>
      <artifactId>spring-tx</artifactId>
  </dependency>
  <!-- https://mvnrepository.com/artifact/org.quartz-scheduler/quartz -->
  <dependency>
      <groupId>org.quartz-scheduler</groupId>
      <artifactId>quartz</artifactId>
      <version>2.3.0</version>
  </dependency>
  ```

+ 是一个任务调度框架

+ 就是解决了我们什么时候需要执行什么操作

+ 使用

+ ```java
  import org.quartz.JobBuilder;
  import org.quartz.JobDetail;
  import org.quartz.Scheduler;
  import org.quartz.SchedulerException;
  import org.quartz.SimpleScheduleBuilder;
  import org.quartz.Trigger;
  import org.quartz.TriggerBuilder;
  import org.quartz.impl.StdSchedulerFactory;
  
  public class QuartzMain {
  
  	public static void main(String[] args) throws Exception {
  
  		// 1.创建Job对象：你要做什么事？  这个Class对象就是你实现JOb接口的那个类
  		JobDetail job = JobBuilder.newJob(QuartzDemo.class).build();
  
  		/**
  		 * 简单的trigger触发时间：通过Quartz提供一个方法来完成简单的重复调用 cron
  		 * Trigger：按照Cron的表达式来给定触发的时间
  		 */
  		// 2.创建Trigger对象：在什么时间做？
            // 这儿提供了12个方法  可以酌情选择
  		/*Trigger trigger = TriggerBuilder.newTrigger().withSchedule(SimpleScheduleBuilder.repeatSecondlyForever())
  				.build();*/
  		
  		
  		Trigger trigger = TriggerBuilder.newTrigger().withSchedule(CronScheduleBuilder.cronSchedule("0/2 * * * * ?"))
  				.build();
  
  		// 3.创建Scheduler对象：在什么时间做什么事？
  		Scheduler scheduler = StdSchedulerFactory.getDefaultScheduler();
  		scheduler.scheduleJob(job, trigger);
  		
  		//启动
  		scheduler.start();
  	}
  
  }
  ```

+ ```java
  import java.util.Date;
  import org.quartz.Job;
  import org.quartz.JobExecutionContext;
  import org.quartz.JobExecutionException;
  /**
   * 定义任务类
   *
   *
   */
  public class QuartzDemo implements Job {
  
  	/**
  	 * 任务被触发时所执行的方法
  	 */
  	public void execute(JobExecutionContext arg0) throws JobExecutionException {
  		System.out.println("Execute...."+new Date());
  	}
  
  }
  
  ```

+ Job 中注入对象  SpringBoot 整合 Quartz

  + 启动类中需要开始@EnableScheduling注解

  + 我们直接通过Spring的自动注入会出现异常 出现的使NULL异常  是不是很奇怪

  + 其实我们的Job是通过AdpaterJobFactory创建的里面有一个createJobInstance方法 在内部是通过反射创建的对象没有走Spring 所以造成没有注入就是null了

  + 我们可以通过自己继承一下AdpaterJobFactory 重写里面的createJobInstance解决这个问题  看代码

  + **编写一个 MyAdaptableJobFactory 解决该问题**

  + ```java
    @Component("myAdaptableJobFactory")
    public class MyAdaptableJobFactory extends AdaptableJobFactory {
        //AutowireCapableBeanFactory 可以将一个对象添加到 SpringIOC 容器中， 并且完成该对象注入 	 
        @Autowired 
        private AutowireCapableBeanFactory autowireCapableBeanFactory;
        /** * 该方法需要将实例化的任务对象手动的添加到 springIOC 容器中并且完成对象的注入*/ 
        @Override
        protected Object createJobInstance(TriggerFiredBundle bundle) throws Exception { 
            Object obj = super.createJobInstance(bundle); 
            //将 obj 对象添加 Spring IOC 容器中，并完成注入    
            this.autowireCapableBeanFactory.autowireBean(obj); return obj;
        }
                                                                                                }
    ```

  + 修改 QuartzConfig 类

  + ```java
    /** * Quartz 配置类 * * */ 
    @Configuration 
    public class QuartzConfig {
        /** * 1.创建 Job 对象 */ 
        @Bean 
        public JobDetailFactoryBean jobDetailFactoryBean(){
            JobDetailFactoryBean factory = new JobDetailFactoryBean();
                  //关联我们自己的 Job 类                     
                factory.setJobClass(QuartzDemo.class); 
                return factory;
           }
        /** * 2.创建 Trigger 对象 * 简单的 Trigger*/
    
        @Bean
        public SimpleTriggerFactoryBean simpleTriggerFactoryBean(JobDetailFactoryBean jobDetailFactoryBean){ 
            SimpleTriggerFactoryBean factory = new SimpleTriggerFactoryBean(); 
            //关联 JobDetail 对象 
            factory.setJobDetail(jobDetailFactoryBean.getObject());
            //该参数表示一个执行的毫秒数
            factory.setRepeatInterval(2000); 
            //重复次数 
            factory.setRepeatCount(5); return factory;
        }
        
        
        /** * Cron Trigger */
        @Bean public CronTriggerFactoryBean cronTriggerFactoryBean(JobDetailFactoryBean jobDetailFactoryBean){ 
            CronTriggerFactoryBean factory = new CronTriggerFactoryBean(); 
            factory.setJobDetail(jobDetailFactoryBean.getObject());
            //设置触发时间 
            factory.setCronExpression("0/2 * * * * ?"); return factory; 
        }
        
        
        /** * 3.创建 Scheduler 对象 */
        @Bean 
        public SchedulerFactoryBean schedulerFactoryBean(CronTriggerFactoryBean cronTriggerFactoryBean,MyAdaptableJobFactory myAdaptableJobFactory){ 
            //myAdaptableJobFactory 就是们创建的继承的类 注入对象时才有
            
            SchedulerFactoryBean factory = new SchedulerFactoryBean();
    
            //关联 trigger
            factory.setTriggers(cronTriggerFactoryBean.getObject());
            // 使用我们自己创建的Adpater  注入对象时才是用的
            factory.setJobFactory(myAdaptableJobFactory); 
            
            return factory;
        }
    }
    ```

  + 代码虽然所但都是固化

  + 定义任务类

  + ```java
    import java.util.Date;
    import org.quartz.Job;
    import org.quartz.JobExecutionContext;
    import org.quartz.JobExecutionException;
    /**
     * 定义任务类
     *
     *
     */
    public class QuartzDemo implements Job {
    
        @Resource
        UsersService userService;
        
    	/**
    	 * 任务被触发时所执行的方法
    	 */
    	public void execute(JobExecutionContext arg0) throws JobExecutionException {
    		System.out.println("Execute...."+new Date());
    	}
    }
    ```

###Spring Data JPA

+ 是SpringData中的一个模块 用来操作数据库 简化了操作数据库的代码

+ maven 依赖

+ ```xml
  <dependency>
      <groupId>mysql</groupId>
      <artifactId>mysql-connector-java</artifactId>
  </dependency>
  
  <dependency>
      <groupId>com.alibaba</groupId>
      <artifactId>druid</artifactId>
      <version>1.0.26</version>
  </dependency>
  
  <dependency>
      <groupId>org.springframework.boot</groupId>
      <artifactId>spring-boot-starter-data-jpa</artifactId>
  </dependency>
  ```

+ peoperties 配置文件

+ ```properties
  spring.datasource.driver-class-name=com.mysql.jdbc.Driver
  spring.datasource.url=jdbc:mysql://localhost:3307/test?characterEncoding=utf-8&useUnicode=true&useJDBCCompliantTimezoneShift=true&useLegacyDatetimeCode=false&serverTimezone=UTC
  spring.datasource.username=root
  spring.datasource.password=root
  spring.datasource.type=com.alibaba.druid.pool.DruidDataSource
  # 正向工程
  spring.jpa.hibernate.ddl-auto=update
  # 显示SQL语句
  spring.jpa.show-sql=true
  ```

+ 基本整合

  + **Dao**

    + ```java
      package com.liwenxiang.quartz.demo04.repository;
      
      import com.liwenxiang.quartz.demo04.bean.Test;
      import org.springframework.data.jpa.repository.JpaRepository;
      // 通过继承JpaRepository<实体类,主键类型>得到通用的CURD方法
      public interface TestRepository extends JpaRepository<Test,Integer> {
      }
      ```

  + **实体类**

    + ```java
      package com.liwenxiang.quartz.demo04.bean;
      
      import org.hibernate.service.spi.Startable;
      
      import javax.persistence.*;
      // 意思是标识这是一个实体类
      @Entity
      // 操作的table的名字
      @Table(name="test")
      public class Test {
          // iD
            @Id
          // 主键策略  
          @GeneratedValue(strategy= GenerationType.IDENTITY)
          // 对应数据库中的列  
          @Column(name="id")
            private Integer id;
            @Column(name="name")
            private String name;
            @Column(name="age")
            private Integer age;
      
          public Test(String name, Integer age) {
              this.name = name;
              this.age = age;
          }
      
          public Test() {
          }
      
          @Override
          public String toString() {
              return "Test{" +
                      "id=" + id +
                      ", name='" + name + '\'' +
                      ", age=" + age +
                      '}';
          }
      
          public Integer getId() {
              return id;
          }
      
          public void setId(Integer id) {
              this.id = id;
          }
      
          public String getName() {
              return name;
          }
      
          public void setName(String name) {
              this.name = name;
          }
      
          public Integer getAge() {
              return age;
          }
      
          public void setAge(Integer age) {
              this.age = age;
          }
      }
      
      ```

  + **测试**

    + ```java
      @RunWith(SpringRunner.class)
      @SpringBootTest
      public class Demo04ApplicationTests {
          @Resource
          TestRepository testRepository;
      
          @Test
          public void contextLoads() {
              com.liwenxiang.quartz.demo04.bean.Test  t = new com.liwenxiang.quartz.demo04.bean.Test ();
              t.setName("lwx");
              t.setAge(100);
              // save 方法是保存的方法
              com.liwenxiang.quartz.demo04.bean.Test save = this.testRepository.save(t);
              System.out.println(save);
          }
      }
      ```

    #### Spring Data JPA 的使用

    + 提供了五个常用关键核心接口
    + Repository
    + JpaRepository
    + CrudRepository
    + PagingAndSortingRepository
    + JpaSpecificationExecutor

  + Repository 使用

    + 提供了两重查询方式

      + 基于方法命名的查询方式
      + 基于注解@Query的查询方式 还支持更新

    + 查询的方法名一般都以findBy+属性名(开头要大写)+[Is|Equals] 表示是等于的中括号是可选的

    + 条件查询并且的关系  findBy+属性名(开头要大写的)+And+属性名(开头要大写)

    + 条件查询或的关系     findBy+属性名(开头要大写的)+Or+属性名(开头要大写)

    + 条件查询之模糊查询单字段  findBy+属性名(开头要大写的)+Like  但是在查询的时候传递参数要加上通配符  也可以直接使用提供好的 StartingWith 或 endingWith

      + 例如  findByNameStartingWith  ||  findByNameEndingWith

    + 练习

      + ```java
        package com.liwenxiang.quartz.demo04.repository;
        
        import com.liwenxiang.quartz.demo04.bean.Test;
        import org.springframework.data.repository.Repository;
        
        import java.util.List;
        
        public interface TestRespositoryDemo extends Repository<Test,Integer> {
        
            /**
             * 以方法命令的形式去查询
             */
            List<Test> findByName(String name);
        
            List<Test> findByNameAndAge(String name,Integer age);
        
            List<Test> findByNameIn(String... names);
        
            List<Test> findByNameStartingWith(String name);
        
            List<Test> findByNameEndingWith(String name);
        
            List<Test> findByNameLike(String name);
        
            List<Test> findDistinctByAge(Integer age);
        
            List<Test> findAll();
        
            List<Test> findFirstByAge(Integer age);
        }
        
        ```

      + ```java
        package com.liwenxiang.quartz.demo04;
        
        import com.liwenxiang.quartz.demo04.repository.TestRepository;
        import com.liwenxiang.quartz.demo04.repository.TestRespositoryDemo;
        import org.junit.Test;
        import org.junit.runner.RunWith;
        import org.springframework.boot.test.context.SpringBootTest;
        import org.springframework.test.context.junit4.SpringRunner;
        
        import javax.annotation.Resource;
        import java.util.List;
        
        @RunWith(SpringRunner.class)
        @SpringBootTest
        public class Demo04ApplicationTests {
        
            @Resource
            TestRepository testRepository;
        
            @Resource
            TestRespositoryDemo testRepositoryDemo;
        
            @Test
            public void contextLoads() {
                com.liwenxiang.quartz.demo04.bean.Test  t = new com.liwenxiang.quartz.demo04.bean.Test ();
                t.setName("lwx");
                t.setAge(100);
                com.liwenxiang.quartz.demo04.bean.Test save = this.testRepository.save(t);
                System.out.println(save);
            }
        
            @Test
            public void context(){
                List<com.liwenxiang.quartz.demo04.bean.Test> res = testRepositoryDemo.findByName("张三");
                for (com.liwenxiang.quartz.demo04.bean.Test re : res) {
                    System.out.println(re);
                }
            }
        
            @Test
            public void context01(){
                List<com.liwenxiang.quartz.demo04.bean.Test> res = testRepositoryDemo.findByNameAndAge("张三",20);
                for (com.liwenxiang.quartz.demo04.bean.Test re : res) {
                    System.out.println(re);
                }
            }
        
            @Test
            public void context02(){
                List<com.liwenxiang.quartz.demo04.bean.Test> res = testRepositoryDemo.findByNameIn("张三","王五s");
                for (com.liwenxiang.quartz.demo04.bean.Test re : res) {
                    System.out.println(re);
                }
            }
        
        
            @Test
            public void context03(){
                List<com.liwenxiang.quartz.demo04.bean.Test> res = testRepositoryDemo.findByNameStartingWith("张");
                for (com.liwenxiang.quartz.demo04.bean.Test re : res) {
                    System.out.println(re);
                }
            }
        
            @Test
            public void context04(){
                List<com.liwenxiang.quartz.demo04.bean.Test> res = testRepositoryDemo.findByNameEndingWith("s");
                for (com.liwenxiang.quartz.demo04.bean.Test re : res) {
                    System.out.println(re);
                }
            }
        
            @Test
            public void context05(){
                String str = "s";
                List<com.liwenxiang.quartz.demo04.bean.Test> res = testRepositoryDemo.findByNameLike("%"+str+"%");
                for (com.liwenxiang.quartz.demo04.bean.Test re : res) {
                    System.out.println(re);
                }
            }
        
            @Test
            public void context06(){
                List<com.liwenxiang.quartz.demo04.bean.Test> res = testRepositoryDemo.findDistinctByAge(20);
                for (com.liwenxiang.quartz.demo04.bean.Test re : res) {
                    System.out.println(re);
                }
            }
        
            @Test
            public void context07(){
                List<com.liwenxiang.quartz.demo04.bean.Test> res = testRepositoryDemo.findAll();
                for (com.liwenxiang.quartz.demo04.bean.Test re : res) {
                    System.out.println(re);
                }
            }
        
            @Test
            public void context08(){
                List<com.liwenxiang.quartz.demo04.bean.Test> res = testRepositoryDemo.findFirstByAge(20);
                for (com.liwenxiang.quartz.demo04.bean.Test re : res) {
                    System.out.println(re);
                }
            }
        }
        ```

      + @Query 注解方式

      + ```java
        @Query(value = "select * from test where name = ? ",nativeQuery = true)
        List<Test> querySelectTestInfoAll(String name);
        
        @Query(value = "update test set name = ? where id = ? ",nativeQuery = true)
        @Modifying
        Integer update(String name,Integer id);
        ```

      + ```java
        
        @Test
        public void context09(){
            List<com.liwenxiang.quartz.demo04.bean.Test> res = testRepositoryDemo.querySelectTestInfoAll("张三");
            for (com.liwenxiang.quartz.demo04.bean.Test re : res) {
                System.out.println(re);
            }
        }
        
        @Test
        @Transactional
        @Rollback(false)
        public void context10(){
            Integer res = testRepositoryDemo.update("97654321",2);
            System.out.println(res);
        }
        ```

      + 修改的话 如果事务标签和Test一块使用是默认会回滚的 还有我们的@Query执行需要在事务的环境下运行

    + **CrudRepository**

      + 继承了Repository接口

      + 提供了很多的增删改查方法 可以直接使用

      + 里面已经加上了事务操作 

      + ```java
        public interface TestCrudRepositoryDemo extends CrudRepository<Test,Integer> {
        
        }
        ```

      + ```java
        @Test
            public void repositoryDemo(){
                com.liwenxiang.quartz.demo04.bean.Test y = new com.liwenxiang.quartz.demo04.bean.Test();
                y.setName("l2");
                y.setAge(50);
                y.setId(20);
                com.liwenxiang.quartz.demo04.bean.Test save = testCrudRepositoryDemo.save(y);
                System.out.println(save);
            }
        
            @Test
            public void repositoryDemo01(){
                testCrudRepositoryDemo.deleteById(20);
            }
        
            @Test
            public void contextLoads() {
                com.liwenxiang.quartz.demo04.bean.Test  t = new com.liwenxiang.quartz.demo04.bean.Test ();
                t.setName("lwx");
                t.setAge(100);
                com.liwenxiang.quartz.demo04.bean.Test save = this.testRepository.save(t);
                System.out.println(save);
            }
        
        ```

    + **PagingAndSortingRepository**

      + 继承了 CrudRepository

      + 提供了两个排序和分页的方法 只能够对查询所有进行一个分页 不能够对有条件的分页

      + ```java
        public interface TestPagingRepository extends PagingAndSortingRepository<Test,Integer> {
        
        }
        ```

      + ```java
            @Test
            public void pagingRepositorySort(){
                 Sort.Order o = new Sort.Order(Sort.Direction.DESC,"id");
                 Sort sort = new Sort(o);
                 List<com.liwenxiang.quartz.demo04.bean.Test> all = (List<com.liwenxiang.quartz.demo04.bean.Test>)testPagingRepository.findAll(sort);
                 for (com.liwenxiang.quartz.demo04.bean.Test test : all) {
                     System.out.println(test);
                 }
            }
        
            @Test
            public void pagingAbleTestDemo(){
        
                int cur = 3 - 1;
        
                Pageable pageable = new PageRequest(cur,2);
        
                Page<com.liwenxiang.quartz.demo04.bean.Test> all = testPagingRepository.findAll(pageable);
        
                for (com.liwenxiang.quartz.demo04.bean.Test test : all) {
                    System.out.println(test);
                }
            }
        
            @Test
            public void pagingAbleTestSortDemo(){
                Sort.Order o = new Sort.Order(Sort.Direction.DESC,"id");
                Sort sort = new Sort(o);
                int cur = 3 - 1;
                Pageable pageable = new PageRequest(cur,2,sort);
                Page<com.liwenxiang.quartz.demo04.bean.Test> all = testPagingRepository.findAll(pageable);
                for (com.liwenxiang.quartz.demo04.bean.Test test : all) {
                    System.out.println(test);
                }
            }
        ```

      + **JpaRepository**

        + 这个接口继承了PagingAndSortRepository接口
        + 在实际开发中使用的比较多 因为已经有很多方法了
        + 并且对返回的类型做了处理 更符合我们的期望

      + **JpaSpecificationRepository**

        + 是单独存在的  没有继承其他的接口

        + 一般和jpaRepository一块使用  就一个泛型 就是实体类类型

        + ```java
          public interface TestRepository extends JpaRepository<Test,Integer>, JpaSpecificationExecutor<Test> {
          
          }
          ```

        + ```java
          @RunWith(SpringRunner.class)
          @SpringBootTest
          public class test2 {
          
              @Resource
              TestRepository testRepository;
          
              @Test
              public void test01(){
                  /**
                     * 多条件的查询  JapSpecificationRepository 是单独存在的
                     */
                  Specification<com.liwenxiang.quartz.demo04.bean.Test> sp = new Specification<com.liwenxiang.quartz.demo04.bean.Test>() {
                      /**
                         * Root 是包装了当前实体的属性
                         * CriteriaQuery 是sql语句的一些操作内容
                         * CriteriaBuilder 是查询的一些条件
                         * @param root
                         * @param criteriaQuery
                         * @param criteriaBuilder
                         * @return
                         */
                      @Override
                      public Predicate toPredicate(Root<com.liwenxiang.quartz.demo04.bean.Test> root, CriteriaQuery<?> criteriaQuery,
                                                   CriteriaBuilder criteriaBuilder) {
                          Predicate p1 = criteriaBuilder.equal(root.get("name"), "张无");
                          Predicate p2 = criteriaBuilder.equal(root.get("age"),201);
                          return criteriaBuilder.or(criteriaBuilder.and(p1,p2),criteriaBuilder.equal(root.get("age"),1));
                      }
                  };
          
                  List<com.liwenxiang.quartz.demo04.bean.Test> all = this.testRepository.findAll(sp);
                  for (com.liwenxiang.quartz.demo04.bean.Test test : all) {
                      System.out.println(test);
                  }
              }
          
          
              @Test
              public void test02(){
                  /**
                   * 多条件的查询  JapSpecificationRepository 是单独存在的
                   */
                  Specification<com.liwenxiang.quartz.demo04.bean.Test> sp = new Specification<com.liwenxiang.quartz.demo04.bean.Test>() {
                      /**
                       * Root 是包装了当前实体的属性
                       * CriteriaQuery 是sql语句的一些操作内容
                       * CriteriaBuilder 是查询的一些条件
                       * @param root
                       * @param criteriaQuery
                       * @param criteriaBuilder
                       * @return
                       */
                      //2.多表查询
                      /*Join<ImTeacher,ImStudent> join = root.join("imStudent", JoinType.INNER);
          
                      Path<String> exp3 = join.get("name"); 
          
                      return cb.like(exp3, "%jy%");*/
          
                      
                      @Override
                      public Predicate toPredicate(Root<com.liwenxiang.quartz.demo04.bean.Test> root, CriteriaQuery<?> criteriaQuery,
                                                   CriteriaBuilder criteriaBuilder) {
                          Predicate age = criteriaBuilder.between(root.get("age"), 1, 100);
                          Predicate equal = criteriaBuilder.equal(root.get("name"), "王五s");
                          Predicate equal1 = criteriaBuilder.equal(root.get("name"), "测试");
                          Predicate equal2 = criteriaBuilder.equal(root.get("name"), "lisi");
                          return criteriaBuilder.or(equal1,equal2,criteriaBuilder.and(age,equal));
                      }
                  };
          
                  Sort sort = new Sort(new Sort.Order(Sort.Direction.DESC,"id"));
                  Pageable pageable = new PageRequest(1,2,sort);
                  Page<com.liwenxiang.quartz.demo04.bean.Test> all = this.testRepository.findAll(sp,pageable);
                  for (com.liwenxiang.quartz.demo04.bean.Test test : all) {
                      System.out.println(test);
                  }
              }
          
          }
          ```


### 热部署

+ springLoader

  + 只能对后台代码进行部署

+ DevTools

  + 重新部署的方式

  + CTRL + SHIFT + A --> 查找 make project automatically --> 选中  

  + CTRL + SHIFT + A --> 查找 Registry --> 找到并勾选 compiler.automake.allow.when.app.running  

  + idea  maven 开启热部署

  + ```xml
    <build>
        <plugins>
            <plugin>
                <groupId>org.springframework.boot</groupId>
                <artifactId>spring-boot-maven-plugin</artifactId>
                <configuration>
                    <fork>true</fork>
                </configuration>
            </plugin>
        </plugins>
    </build>
    ```

  + 引入依赖即可

     ```xml
      <dependency>
        <groupId>org.springframework.boot</groupId>
        <artifactId>spring-boot-devtools</artifactId>
        <version>2.0.4.RELEASE</version>
        <optional>true</optional>
      </dependency>
     ```

  

  ### WebSocket 学习

  + TOMCAT7 支持了WebSocket协议 在之后的版本都可以使用Websocket

  + 使用 首先需要一个配置对象 可以扫描到链接的对象会话的个数

  + 首先需要创建一个类 取实现ServerApplicationConfig接口 重写里面的两个方法 然后我们如果使用注解的话就是在Annotation那个方法里返回那个set即可

  + ```java
    package com.liwenxiang.config;
    
    import javax.websocket.Endpoint;
    import javax.websocket.server.ServerApplicationConfig;
    import javax.websocket.server.ServerEndpointConfig;
    import java.util.Set;
    
    public class socket_config implements ServerApplicationConfig {
    
        @Override
        public Set<ServerEndpointConfig> getEndpointConfigs(Set<Class<? extends Endpoint>> set) {
            return null;
        }
    
        @Override
        public Set<Class<?>> getAnnotatedEndpointClasses(Set<Class<?>> set) {
            return set;
        }
    }
    ```

  + 具体的监听路径 创建一个会话

  + ```java
    @ServerEndpoint("/chat")
    public class chat_logic {
    
          private Set<Session> sessions = new HashSet<>();
          private String username;
          private List<String> names = new ArrayList<>();
    
          @OnOpen
          public void open(Session session) throws UnsupportedEncodingException {
                String username = URLDecoder.decode(session.getQueryString().split("=")[1],"utf-8");
                this.names.add(username);
                this.sessions.add(session);
                String msg = "欢迎"+username+"进入";
                message message = new message();
                message.setMsg(msg);
                message.setNames(names);
                this.broadcast(this.sessions,message.toJson());
          }
    
          public void broadcast(Set<Session> sessions,String msg){
                for (Iterator iterator = sessions.iterator(); iterator.hasNext();){
                    try {
                        Session session  = (Session) iterator.next();
                        session.getBasicRemote().sendText(msg);
                    } catch (IOException e) {
                        e.printStackTrace();
                    }
                }
          };
    }
    ```

+ 里面有onOpen注解onMessage注解onClose注解 里面都接受一个Session会话 但是onMessage方法多接受一个消息参数是String类型的

```java
@OnMessage
public void message(Session session,String message){

}
```

前端页面

```javascript
window.onload=function (ev) {
     var ws = null;
     var con = document.getElementById("con");
     var username = "${sessionScope.username}";
     var target = "ws://localhost:8088/webSocket01_war/chat?username="+username;

     if ("WebSocket" in window){
         ws = new WebSocket(target);
     }else if ("MozWebSocket" in window) {
         ws= new MozWebSocket(target);
     }else{
         con.innerHTML = "<span style='color:red;'>您的浏览器不支持 webSocket</span>";
     }

     ws.onopen = function () {
          console.log("打开链接")
     };

     ws.onmessage=function (ev) {
          console.log(ev.data);
          var obj =JSON.parse(ev.data);
          var date  = new Date(Number(obj.date));
          con.innerHTML += date.getFullYear() + " - " + date.getMonth() + " - " + date.getMinutes() + "<br/>";
          con.innerHTML += obj.msg + "<br/>";
     }
};
```

### SpringBoot 工具类中获取到Spirng管理的对象 

+ 使用工具类继承 ApplicationContextAware

+ 重写方法  在成员变量添加一个ApplicationContext对象

+ 必须加上@Component

  ```java
  package com.lwx.sso_test.demo.util;
  
  import lombok.Getter;
  import lombok.Setter;
  import org.springframework.beans.BeansException;
  import org.springframework.beans.factory.annotation.Autowired;
  import org.springframework.beans.factory.annotation.Value;
  import org.springframework.context.ApplicationContext;
  import org.springframework.context.ApplicationContextAware;
  import org.springframework.context.annotation.Bean;
  import org.springframework.data.redis.core.RedisTemplate;
  import org.springframework.data.redis.serializer.StringRedisSerializer;
  import org.springframework.stereotype.Component;
  import org.thymeleaf.spring5.context.SpringContextUtils;
  
  import javax.annotation.Resource;
  
  @Component
  public class SpringContainer implements ApplicationContextAware {
  
      private static ApplicationContext applicationContext;
  
      @Override
      public void setApplicationContext(ApplicationContext applicationContext) throws BeansException {
          if(SpringContainer.applicationContext == null) {
              SpringContainer.applicationContext = applicationContext;
          }
      }
  
      //获取applicationContext
      public static ApplicationContext getApplicationContext() {
          return applicationContext;
      }
  
      //通过name获取 Bean.
      public static Object getBean(String name){
          return getApplicationContext().getBean(name);
      }
  
      //通过class获取Bean.
      public static <T> T getBean(Class<T> clazz){
          return getApplicationContext().getBean(clazz);
      }
  
      //通过name,以及Clazz返回指定的Bean
      public static <T> T getBean(String name,Class<T> clazz){
          return getApplicationContext().getBean(name, clazz);
      }
  }
  
  ```

  

### SpringBoot集成ActiveMQ

+ 注意  RabbitMQ 会占用ActiveMQ的端口 所以不要部署在同一台机器上

+ 带入Maven依赖

  + ```xml
    <dependency>
        <groupId>org.springframework.boot</groupId>
        <artifactId>spring-boot-starter-activemq</artifactId>
    </dependency>
    <dependency>
        <groupId>org.apache.activemq</groupId>
        <artifactId>activemq-pool</artifactId>
    </dependency>
    ```

  + ```java
    package com.lwx.sso_test.demo.config;
    
    import org.apache.activemq.ActiveMQConnectionFactory;
    import org.springframework.boot.context.properties.ConfigurationProperties;
    import org.springframework.context.annotation.Bean;
    import org.springframework.context.annotation.Configuration;
    import org.springframework.jms.core.JmsMessagingTemplate;
    import org.springframework.jms.core.JmsTemplate;
    
    import javax.jms.ConnectionFactory;
    
    @Configuration
    public class ActiveMQConfig {
    
        @Bean
        @ConfigurationProperties("spring.activemq")
        public ConnectionFactory connectionFactory(){
            ActiveMQConnectionFactory connectionFactory = new ActiveMQConnectionFactory();
    //        connectionFactory.setBrokerURL("tcp://192.168.190.141:61616");
    //        connectionFactory.setUserName("admin");
    //        connectionFactory.setPassword("admin");
            return connectionFactory;
        }
        @Bean
        public JmsTemplate genJmsTemplate(){
            return new JmsTemplate(connectionFactory());
        }
        @Bean
        public JmsMessagingTemplate jmsMessageTemplate(){
            return new JmsMessagingTemplate(connectionFactory());
    
        }
    }
    ```

  + ```properties
      activemq:
         broker-url: tcp://192.168.190.141:61616
         user-name: admin
         password: admin
         pool:
            enabled: true
            max-connections: 50
            idle-timeout: 30000
         in-memory: true
         
      ```
    #spring.activemq.broker-url=failover:(tcp://localhost:61616,tcp://localhost:61617)
    ```
  
  + ```java
    
    @Component
    public class JMSProducer {
    
          @Resource
          public JmsTemplate jmsTemplate;
    
          public void sendMessage(Destination destination, String message) {
                System.out.println(jmsTemplate);
                this.jmsTemplate.convertAndSend(destination,message);
          }
    
    }
    ```

  + ```java
    @Component
    public class JMSConsumer {
    
           private final static Logger logger = LoggerFactory.getLogger(JMSConsumer.class);
    
            @JmsListener(destination = "springboot.queue.test")
            public void receiveQueue(String msg) {
                logger.info("接收到消息：{}",msg);
            }
    }
    ```

+ ```java
  @Test
  public void test() throws InterruptedException {
      Destination destination =  new ActiveMQQueue("first");
      for (int i = 0 ; i < 10; i++){
          Thread.sleep(200);
          jmsProducer.sendMessage(destination, JSON.toJSONString(new Users()));
      }
  }
  ```

+ 发送接收 Topic 类型的 消息

  + 增加如下配置

  + 注意增加了该配置就会监听不到Queue的 所以需要注意 下来开始解决这个问题

  + ```properties
    spring.jms.pub-sub-domain=true
    ```

