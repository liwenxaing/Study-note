## Spring4笔记
### Spring 约束

   <?xml version="1.0" encoding="UTF-8" ?>
   <beans xmlns="http://www.springframework.org/schema/beans"
          xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
          xmlns:c="http://www.springframework.org/schema/c"
          xmlns:context="http://www.springframework.org/schema/context"
          xsi:schemaLocation="http://www.springframework.org/schema/beans
          http://www.springframework.org/schema/beans/spring-beans.xsd">
### aop 约束
   <?xml version="1.0" encoding="UTF-8"?>
   <beans xmlns="http://www.springframework.org/schema/beans"
          xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
          xmlns:aop="http://www.springframework.org/schema/aop"
          xmlns:tx="http://www.springframework.org/schema/tx"
          xsi:schemaLocation="
               http://www.springframework.org/schema/beans http://www.springframework.org/schema/beans/spring-beans.xsd
               http://www.springframework.org/schema/tx http://www.springframework.org/schema/tx/spring-tx.xsd
               http://www.springframework.org/schema/aop http://www.springframework.org/schema/aop/spring-aop.xsd">          
### 继承回顾
   + 继承的是成员变量和方法
   + 方法是继承的访问权限  空间没有增加
   + 属性其实是拷贝了一份到子类里里面 空间增加了
### 回顾
   + 一个空对象的堆内存中占 8 个字节 不存在成员变量的时候 例如  Object o = new Object()
   + 在例如如果多加了一个int类型的成员变量那么占得内存就是12个字节 因为一个int占四个字节
### Spring概述
   + 是管理整个应用的  是大管家
   + 为了解决企业应用开发而产生的
   + Spring的核心是控制反转(IOC)和面向切面编程(AOP)
   + 简单来说Spring是一个分层的Java SE / EE full-stack(一站式)轻量级开发框架
   + Spring 的主要作用就是为代码解耦 降低代码间的耦合度
   + 根据功能不同 将一个系统中的代码分为主业务逻辑 系统业务逻辑      
### Spring 面试三句话
   + Spring是一个容器
   + 目的是为了降低代码之间的耦合度
   + 根据不同的代码使用IOC和AOP两种技术进行解耦
      + 主业务逻辑
         + 代码之间联系紧密 有具体的应用场景 复用性相对较低
      + 系统业务逻辑
         + 没有具体的应用场景  复用性较强 
### Spring 特点
   + 非侵入式
      + Spring框架的API不会在业务逻辑上出现 及业务逻辑是POJO(plain oid java object) 由于业务逻辑中没有Spring的API 所以业务逻辑可以从Spring
        框架快速移动到其他框架 基于环境无关  
   + 容器
      + Spring作为一个容器 可以管理对象的生命周期 对象与对象之间的依赖关系可以通过配置文件 来定义对象 以及设置和其他对象的依赖关系
   + Ioc （控制反转）
      + 即创建被调用者的实例不是由调用者完成的 而是由Spring容器完成 注入调用者
      + 当应用了 IOC 一个对象依赖的其他的对象会通过别动的形式传递进来而不是这个对象自己创建或者查找依赖对象
      + 所以：**不是对象从容器中查找依赖 二十容器在对象初始化的时候不等对象请求就主动将依赖传递给它**   
   + AOP （面向切面编程）
      + 是一种编程思想 是面向对象编程的补充 允许通过分离应用的业务逻辑与系统服务进行开发
### Spring 与 IOC
   + IOC 是一种概念 是一种解决方案 是一种思想 实现方式有很多
     + 常用的实现方式有依赖查找 和 依赖注入
        + 依赖查找
        + 依赖注入 最优的解耦方式
            + Spring 采用的就是依赖注入
### Spring 容器配置文件开头约束(applicationContext.xml)
   ```
      <?xml version="1.0" encoding="UTF-8" ?>
      <beans xmlns="http://www.springframework.org/schema/beans"
             xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
             xsi:schemaLocation="http://www.springframework.org/schema/beans
             http://www.springframework.org/schema/beans/spring-beans.xsd">
      </beans>
   ```
#### Spring 容器实例 ApplicationContext interface  
     从类路径加载Spring配置  
     ApplicationContext app = new ClassPathXmlApplicationContext();
     Animal animla = app.getBean("myService");
     从当前项目根路径或者盘符根路径加载Spring配置
     ApplicationContext app = new FileSystemXmlApplicationContext();
     Animal animal = app.getBean("myService");
     从类路径加载Spring配置  
     BeanFactory bf = new XmlBeanFactory(new ClassPathResource("applicationContext.xml"))
     Animal animal = bf.getBean("myService");
###  ApplicationContext 与  beanFactory 的区别
```MD
+ ApplicationContext在创建容器进行初始化的时候 会将其中的所有bean对象进行创建
   + 缺点 : 占用系统资源
   + 优点 : 响应速度快
+ BeanFactory  在创建容器初始化的时候并不会创建bean对象 而是在真正获取时创建
   + 缺点 ： 相对来说 响应速度慢
   + 有点 ： 不多占用系统资源
```
### bean对象的装配 与 注入
   1. 默认装配
       1. 1. 当我们调用getBean的时候系统会先去寻找创建对象的无参构造器 所以说我们创建构造器的时候如果创建了有参构造器那么就要创建一个无参构造
   2. 动态工厂Bean
       2. 1. 在配置文件中首先注册 动态工厂
             ```  <bean id="factory" class="com.liwenxiang.factory.ServiceFactory"/> ```
             在 注册动态工厂bean  
             ``` <bean id="myService" factory-bean="factory" factory-method="getAnimalImplFactory"/> ```
   3.  静态工厂bean
       3. 1. 注册方式 
             ``` <bean id="myService"  class="com.liwenxiang.Service.ServiceFactory" factory-method="getAnimalImpl"/>  ```  
   4.  Bean的作用域(scope)
       4. 1.  singleton 单例设计模式
              + 是默认值 在Spring容器初始化的时候就会创建其中的bean对象 但是构造器只执行一次  无论同一个bean创建多少次都是相等的
       4. 2.  prototype 原型设计模式
              + 这个模式就是 原型设计模式 在Spring容器初始化的时候不会创建其中的bean对象 而是在访问的时候创建bean对象 各自都有各自的引用
       4. 3.  request
              + 每一次请求都会创建一个bean对象
       4. 4.  session
              + 每一次的会话都会创建一个新的bean对象
   5. Bean后处理器 
       5. 1. 新建一个class实现BeanPostProcessor接口
       5. 2. 在applicationContext.xml中注册这个类  不注册也不会报错
       5. 3. 实现其中的两个方法分别的都是在bean对象初始化之前和之后进行执行的
   6. Bean后处理器的应用
       6. 1. 增强方法  使用代理 动态 JDK Proxy 代理
             ```  JAVA
              public Object postProcessAfterInitialization(Object bean, String beanName) throws BeansException {
                    System.out.println("执行初始化后的after方法");
                         if ("myService".equals(beanName)){
                 Animal a  = (Animal)Proxy.newProxyInstance(bean.getClass().getClassLoader(), bean.getClass().getInterfaces(),
                                     new InvocationHandler() {
                                         @Override
                                         public Object invoke(Object proxy, Method method, Object[] args) throws Throwable {
                                             Object o = method.invoke(bean,args);
                                             return ((String)o).toUpperCase();
                                         }
                                     }
                             );
                             return a;
                         }
                         return bean;
                     }  
             ```
   7. Bean的自定义生命周期始末
       7. 1. 在ServiceImpl中创建两个方法
             setUp   teraDown
       7. 2. 在applicationContext.xml中进行配置到当前bean对象的标签上加入 init-method="setUp" destroy-method="teraDown"
       7. 3. 在执行destroy方法有两个条件     
             + 必须关闭容器 那么 ApplicationContext 本身没有close方法 但是他的实现类  ClassPathXmlApplicationContext 具有
               close方法 所以说 强转一下就好了
             + 当前的bean需要时singleton的   
   8. Bean 的生命周期 11 个
       + 执行无参数构造器
       + 执行setter 需要注入
       + 获取到bean的id
       + 获取到beanFactory容器
       + 执行 before 方法
       + Bean初始化完毕了
       + 初始化完毕之后
       + 执行after方法
       + 执行业务方法
       + 实现接口的销毁之前
       + 销毁之前  
   9. id 和 name 的区别
       + 没区别  
### DI 依赖注入       
   10. 基于XML的DI(依赖注入)
     + 设值注入
          + 通过Set方法进行设值
          +
     + 基本数据类型
          + 通过value属性就可以注入值
          + 通过value属性就可以注入值
     + 域属性 或 引用数据类型
          + 需要通过 ref 属性来获取到改bean的id来设值
          + 需要通过 ref 属性来获取到改bean的id来设值
     + 基本数据类型例子
          ```  XML
               <bean id="School" class="service.School">
                   <property name="name" value="清华大学"/>
               </bean>
          ```
       - 域属性 引用类型例子
          ```XML
               <bean id="School" class="service.School">
                    <property name="name" value="清华大学"/>
               </bean>
               
               <bean id="Student" class="service.Student">
                     <property name="name" value="张三"/>
                     <property name="school" ref="School"/>
                </bean>
          ```
     + 构造注入
          + 通过构造器设值
          + 一般不适用的
          + 例子
            - 通过下标设置
              <constructor-arg index="0" value="张三"/>
              <constructor-arg index="1" ref="school"/>
            - 通过参数顺序设置
               <constructor-arg  value="张三"/>
               <constructor-arg  ref="school"/>
            - 通过name设置
               <constructor-arg name="name"   value="张三"/>
               <constructor-arg name="school" ref="school"/>

     + 命名空间注入
       + 还是通过调用set方法 
       + 引入 xmlns:p="http://www.springframework.org/schema/p"
       + <bean id="student" class="beans.Student" p:name="张三" p:school-ref="school"/>

     + 命名空间构造注入
        + 引入 xmlns:c="http://www.springframework.org/schema/c"
        + <bean id="student" class="beans.Student" c:name="张三" c:school-ref="school"/>

     + 集合属性注入
        ```XML
        <bean id="mySome" class="beans.Some">
            
            数组注入
            <property name="myString">
                <array>
                    <value>中国</value>
                    <value>北京</value>
                </array>
            </property>
            
            List集合注入 
            <property name="myList">
                <list>
                    <value> 第一个List </value>
                    <value> 第二个List </value>
                    <value> 第三个List </value>
                </list>
            </property>
        
            Set集合注入
            <property name="mySet">
                <set>
                    <value> 第一个Set </value>
                    <value> 第二个Set </value>
                    <value> 第三个Set </value>
                </set>
            </property>
            
            Map集合注入 
            <property name="myMap">
                <map>
                    <entry key="mapOne" value="1"/>
                    <entry key="mapTwo" value="2"/>
                </map>
            </property>
        
            **自定义对象引用类型注入**
            <property name="mySchool">
                <array>
                    <ref bean="school1"/>
                    <ref bean="school2"/>
                </array>
            </property>
        
            **Properties文件注入**
            <property name="myProperties">
                <props>
                    <prop key="onep"> 第一个 </prop>
                    <prop key="twop"> 第二个 </prop>
                </props>
            </property>
        
            </bean>
        
        ```

        

        集合属性简写方式注入
        + 数组 List集合 Set集合 可以简写成
          +  <bean id="mySome" class="top.liwenxiang.Entry">
                <property name="myList" value="one,two,three"></property>
                </bean>
          + <bean id="mySome" class="top.liwenxiang.Entry">
                <property name="myArray" value="one,two,three"></property>
            </bean>
          + 如果是引用类型数组的话 如果值为一个那么就可以简写 使用ref 否则就不行   

     + 域属性的自动注入
        + 设置bean对象的 autowire="byName" 会从容器中查找与实体类的域属性同名的Bean的id,并将该Bean对象自动注入给该域属性
        + 设置bean对象的 autowire="byType" 会从容器中查找与实体类符合 is-a 关系的bean 并将改Bean对象自动注入给该域属性 与 id 无关      

     + 基于SPEL的注入
        + SPEL  Spring Expression Language     
        + Spring El 表达式语言 
        + \#{T(Java.lang.Math).random * 50} 可以使用静态方法
        + \#{myPerson.panme} 可以调用其他bean的方法 但是那个bean需要有get方法
        + \#{myPerson.computAge()} 可以调用其他bean的方法
        + \#{myPerson.page > 25 ? 25 : myPerson.page } 可以使用三目运算符    

     + 内部bean注入
        + <property name="mySchool">
             <array>
                 <!-- 内部bean  不再写ref="xxx" 或者ref标签 -->
                 <bean  class="beans.School">
                     <property name="name"  value="李文祥啊飒飒大大撒旦"/>
                 </bean>
                  <ref bean="school2"/>
             </array>
         </property>   

     + 同类抽象bean
        + 解决同Bean的代码冗余问题 使其可以继承  方便修改 减少内存的占用
        + 通过给parent的那个Bean设置abstract = true 外部就不可以获取到这个bean了
        + 因为获取它没有意义 他只是抽离出来的公共部分 并不是完全的bean 也没有完全注入所有属性  

     + 异类抽象bean
        + 和同类抽象bean一样  都是为了解决冗余问题 
        + 只不过是解决的不同bean之间的冗余关系
        + 代码只是反了反 
        + 了解即可

     + 多个配置文件  同等关系
        + 设置多个配置文件的引入方式
          - 可以使用数组
          - 可以使用ApplicationContext提供的重载构造器传入多个资源字符串
          - 使用通配符 * 即可引入所有配置和文件  方便
          - 例如  spring-base.xml  spring-beans.xml
          - 引入  "spring-*.xml"  即可

     + 多个配置文件 包含关系
        + 在配置文件内加入  <import resource="资源文件位置"/>
        + 在使用通配符的时候尽量不要让总的配置文件名称格式和子配置文件格式一样
        + 因为可能在引入配置文件的时候会将自己也引入到自己里面 就报错了
   + 组件扫描仪 使用DI 注解式注入
       + 引入约束
          +  xmlns:context="http://www.springframework.org/schema/context"
          +  http://www.springframework.org/schema/context
             http://www.springframework.org/schema/context/spring-context-4.0.xsd
       + 放在和实体类一个包下
       + 然后通过配置这个容器的 <context:component-scan base-package="beans"/> 制定扫描的包以及子包
       + 就可以使用注解来注入了
   + 注解
       + @Repository  作用在Dao的实现类
       + @Controller  作用在SpringMvc的处理器上
       + @Component   生命当前bean被Spring处理
       + @Service     作用在Service的实现类上
       + @Scope       bean的作用域  默认是 singleton  可以设置为 prototype 
       + @Value       为当前属性注入值 
       + @autowired   byType 的自动域注解注入  即改包下需要有一个实体类的component为你写的属性名一致
       + @Qualifier('mySchool')  byName 的自动域注解注入  需要和@autowired一同出现
       + @Resource(name="mySchool")  JSR-250 的byName方式
       + @Resource                   JSR-250 的byType方式
   + XML 的 优先级要高于 注解
       + XML 格式更利于后期的维护
       + XML 格式不会再次编译
       + 如果使用注解式开发 需要把实体类的Set方法预留 
###使用Spring的Junit进行测试
       + 首先在测试的类上面加上注解
       + 需要使用Spring的test.jar
         @RunWith(SpringJUnit4ClassRunner.class)
         必须要放置在类路径下
         @ContextConfiguration(locations = "classpath:ApplicationContext.xml")
       + 容器会在内部自动创建好  我们直接使用我们的bean对象即可      
### AOP 面向切面编程
   + 切面
       + 是对OOP的补充
       + 底层采用的就是动态代理  采用了 JDK 动态代理 和 CGLIB动态代理
       + AOP 是从动态角度考虑程序的运行过程
       + OOP 是从静态角度考虑程序的结构
       + 是一种思想 是一种解决方案
       + Spring 实现了这种思想
   + AOP 编程术语
       + 切面 
          - 泛指交叉业务逻辑
          - 就是将交叉业务逻辑 织入到主业务逻辑中去
       + 织入
          - 织入是指将切面代码插入到目标对象的过程
       + 连接点
          - 指可以被切面织入的方法  通常业务接口中的方法都是连接点
       + 切入点
          - 指切面具体织入的方法 否则就是连接点
          - 被final修饰的方法是不能作为连接点和切入点的 因为最终的是不能被修改的 不能被增强的
       + 目标对象
          - 指的就是我们需要增强的对象
       + 通知
          - 通知是切面的一种实现可以完成简单织入功能
          - 切入点定义切入的位置
          - 通知定义切入的时间
       + 顾问
          - 顾问是切面的另一种实现
          - 能够将通知以更为复杂的形式织入到目标对象中
          - 是将通知包装为更复杂切面的装配器
   + AOP 环境搭建 
       + 导入aop jar包
       + 导入aop联盟jar包
   + **通知**
       + 里面的切面都是实现了固定的接口
       + 前置通知（在目标方法执行之前先执行）
         + <!-- 注册目标对象 -->
           <bean id="target" class="serviceimpl.ISomeServiceImpl"/>
           <!-- 注册切面 前置通知 -->
           <bean id="qm" class="serviceimpl.MethodBeforeAdvice"/>
           <!-- 注册代理 测试类获取的也是代理的id -->
           <bean id="myproxy" class="org.springframework.aop.framework.ProxyFactoryBean">
             <property name="targetName"  value="target"/>
             <property name="interceptorNames" value="qm"/>
           </bean>
       + 后置通知
       + 能够获取目标方法的返回值 但是不能修改它
       + <!-- 注册目标对象 -->
          <bean id="target" class="serviceimpl.ISomeServiceImpl"/>
          <!-- 注册切面 后置通知 -->
          <bean id="qm" class="serviceimpl.AfterReturningAdvice"/>
          <!-- 注册代理 测试类获取的也是代理的id -->
          <bean id="myproxy" class="org.springframework.aop.framework.ProxyFactoryBean">
            <property name="targetName"  value="target"/>
            <property name="interceptorNames" value="qm"/>
          </bean>
       + 环绕通知
            + 环绕通知  可以在方法前后执行  参数就是那个方法  可以有返回值 可以修改 
            <!-- 注册目标对象 -->
            <bean id="target" class="serviceimpl.ISomeServiceImpl"/>
            <!-- 注册切面 环绕通知 -->
            <bean id="qm" class="serviceimpl.Methodinterctor"/>
            <!-- 注册代理 -->
            <bean id="myproxy" class="org.springframework.aop.framework.ProxyFactoryBean">
                <property name="targetName"  value="target"/>
                <property name="interceptorNames" value="qm"/>
            </bean>
       + 异常通知 
          + 异常通知 在方法发生异常的时候会调用会执行
           <!-- 注册目标对象 -->
           <bean id="target" class="serviceimpl.ISomeServiceImpl"/>
           <!-- 注册切面 环绕通知 -->
           <bean id="qm" class="serviceimpl.ThorwsAdvice"/>
           <!-- 注册代理 -->
           <bean id="myproxy" class="org.springframework.aop.framework.ProxyFactoryBean">
             <property name="targetName"  value="target"/>
             <property name="interceptorNames" value="qm"/>
           </bean>  
   + 抛出异常  和  捕获异常的区别
       +  抛出的异常是和JVM关联这的
       +  捕获的异常与外界没有关系 
   + 顾问
       + 顾问 是 Spring 中的另一种切面实现方式
       + 通知不可以制定其中的某一个连接嗲作为切入点 那么顾问就可以
       + 顾问包含了通知 所以在使用的时候需要拿到通知的引用
       + 例子
           <!-- 注册目标对象 -->
           <bean id="target" class="serviceimpl.ISomeServiceImpl"/>
           <!-- 注册切面 后置通知 -->
           <bean id="qm" class="serviceimpl.myAfterReturningAdvice"/>
           <!--  顾问  以名字的方式选择连接点去切入 -->
           <bean id="gw" class="org.springframework.aop.support.NameMatchMethodPointcutAdvisor">
                  <!--  指定通知  -->
                  <property name="advice" ref="qm"/>
                  <!--  指定需要切入的连接点  -->
                  <property name="mappedName" value="doLast"  />
                  <!--  指定多个需要切入的连接点  -->
                  <property name="mappedNames" value="doLast,doFirst"  />
                  <!--  使用通配符 寻找共同点  -->
                  <property name="mappedNames" value="*t*"  />
           </bean>
           <!-- 注册代理 -->
           <bean id="myproxy" class="org.springframework.aop.framework.ProxyFactoryBean">
               <property name="targetName"  value="target"/>
                <!--  在这里使用顾问的id  -->
               <property name="interceptorNames" value="gw"/>
           </bean>
   + 自动代理生成器
       + 解决问题
          - 现在的是我们每一次新建一个目标对象都要新建一个代理对象
          - 会使得我们的配置文件变非常臃肿
          - 我们用户其实想操作的是我们的目标对象  但是却是操作的代理对象
       + 注意使用 自动代理需要使用顾问
       + 通过修改代理bean即可实现自动代理
          -    <!-- 注册目标对象 -->
              <bean id="target" class="serviceimpl.ISomeServiceImpl"/>
              <bean id="target2" class="serviceimpl.ISomeServiceImpl"/>
              <!-- 注册切面 后置通知 -->
              <bean id="qm" class="serviceimpl.myAfterReturningAdvice"/>
              <!--  顾问  以名字的方式选择连接点去切入 -->
              <bean id="gw" class="org.springframework.aop.support.NameMatchMethodPointcutAdvisor">
                     <property name="advice" ref="qm"/>
                     指定单个连接点为切入点
                     <property name="mappedName" value="doLast"/>
                     指定多个连接点为切入点
                     <property name="mappedNames" value="doLast,doFirst"/>
              </bean>
              <!-- 注册默认自动生成代理器 -->
              <bean class="org.springframework.aop.framework.autoproxy.DefaultAdvisorAutoProxyCreator"/> 
   + Bean名称自动代理生成器
       +  默认的代理生成器存在两个问题  不能够选择要增强的目标对象  不能够选择切面类型 只能够用通知
       +  那么bean名称自动代理生成器就可以解决这两个问题
       +    <!-- 注册目标对象 -->
           <bean id="target" class="serviceimpl.ISomeServiceImpl"/>
           <!-- 注册切面 后置通知 -->
           <bean id="qm" class="serviceimpl.myAfterReturningAdvice"/>
           <!--  顾问  以名字的方式选择连接点去切入 -->
           <bean id="gw" class="org.springframework.aop.support.NameMatchMethodPointcutAdvisor">
                  <property name="advice" ref="qm"/>
                  <property name="mappedNames" value="doLast"/>
           </bean>
           <!-- 注册名称自动生成代理器 -->
           <bean class="org.springframework.aop.framework.autoproxy.BeanNameAutoProxyCreator">
             <property name="beanNames" value="target"/>
             <property name="interceptorNames" value="gw"/>
           </bean>  
   + AspectJ 
       + 是一个面向切面框架 实现了AOP的思想
       + 是一个比较小的框架 和 Spring 没关系
       + 和 Spring中实现 Aop 有点相似
       + Spring 和 AspectJ 都实现了AOP
       + 以后就是使用这个框架来使用AOP了
       + 在Spring环境下使用AspectJ对AOP进行编程
       + 通知类型
          -  前置通知
          -  后置通知
          -  环绕通知
          -  异常通知
          -  最终通知
   + AspectJ 基于注解的AOP实现
       + 使用 在配置文件中 首先注册切面类  在注册目标对象  在使用标签注册动态代理
       + 在切面类上面试用@Aspect声明切面类
       + 在切面类中的方法上使用@before("execution(* *..ISomeService.*(..))")声明前置通知
       + 在切面类中的方法上使用@AfterReturning("execution(* *..ISomeService.*(..))")声明后置通知 
          - 可以接受到方法的返回值但是不能修改
       + 在切面类中的方法上使用@Around("execution(* *..ISomeService.*(..))")声明环绕通知  
          - 里面的参数可以传入 ProceedingJoinPoint ppj  通过 ppj.proceed()  获取到我们的方法
          - 如果有返回值我们可以接受一个返回值  修改方法返回类型 即可返回 并且可以修改
       + 在切面类中的方法上使用@AfterThrowing("execution("* *..ISomeService.*(..)")")声明异常通知
          - 可以通过 throwing="ex" 获取到返回的异常错误信息
       > 代码
       
          ```JAVA
             @Before("execution(* *..ISomeService*.doFirst(..))")
            public void before(){
                System.out.println("前置方法");
            }
          
            @Before("execution(* *..ISomeService*.doFirst(..))")
            public void before(JoinPoint jp){
              System.out.println("前置方法" + jp);
            }
          
            // result 是返回值内容
            @AfterReturning(value = "execution(* *..ISomeService*.doFirst(..))",returning = "result")
            public void afterReturning(Object result){
                System.out.println("后置方法");
            }
          
            // 环绕通知
           @Around("execution(* *..ISomeService.*(..))")
            public Object myAround(ProceedingJoinPoint pjp) throws Throwable {
               System.out.println("执行环绕通知前");
               Object result = pjp.proceed();
               System.out.println("执行环绕通知后");
               return result;
            }
          
            // 异常通知
            @AfterThrowing(value = "execution(* *..ISomeService.*(..))",throwing = "ex")
           public void myThrow(Exception ex){
                System.out.println("执行异常通知方法 ex = " + ex);
           }
          
             // 最终通知
           @After(value = "execution(* *..ISomeService.*(..))")
           public void myAfter(){
             System.out.println("执行最终通知方法");
           }
          ```
   + 配置
            <!-- 注册切面 -->
           <bean id="mySome" class="top.liwenxiang.beans.Studnet"/>
           <!-- 注册目标对象 -->
           <bean id="target" class="top.liwenxiang.beans.ISomeServiceImpl"/>
           <bean id="target2" class="top.liwenxiang.beans.ISomeServiceImpl2"/>
           <!-- 注册代理  使用注解方式 -->
           <aop:aspectj-autoproxy/>              
   + AspectJ 表达式
        1、execution(): 表达式主体。
        2、第一个\*号：表示返回类型，*号表示所有的类型。
        3、包名：表示需要拦截的包名，后面的两个句点表示当前包和当前包的所有子包，com.sample.service.impl包、子孙包下所有类的方法。
        4、第二个*号：表示类名，*号表示所有的类。
        5、*(..):最后这个星号表示方法名，*号表示所有的方法，后面括弧里面表示方法的参数，两个句点表示任何参数。
   + 定义切入点
       + 切入点可以重用
         @Pointcut("execution(* *..ISomeService.*(..))")
         public void myPointCut(){ }  
       + 其他的通知在使用的时候 直接将次方法名放到他的注解value里即可
       + 例如
         @AfterReturning("execution(* *..ISomeService.*(..))")
         public void myAfterReturning(){ // 操作 }
         修改为 
         @AfterReturning("myPointCut()")
         public void myAfterReturning(){ // 操作 }
   + 基于XML的AOP实现
       + <!-- 注册切面 -->
         \<bean id="mySome" class="top.liwenxiang.beans.Studnet"/>
         <!-- 注册目标对象 -->
         \<bean id="target" class="top.liwenxiang.beans.ISomeServiceImpl"/>
          <!-- aop 配置  XML 形式 -->
          <aop:config>
             <!-- 定义切入点 重用 -->
             <aop:pointcut id="PointCut" expression="execution(* \*..ISomeService\*.*(..))"/>
             <aop:aspect ref="mySome">
                  <!-- 前置方法 -->
                  <aop:before method="before" pointcut-ref="PointCut"/>
                  <!-- 后置通知  里面参数可以使用全类名  切入点   和 返回值  里面的返回参数要和 切面中的方法一致 -->
                  <aop:after-returning method="afterReturning(java.lang.Object)" pointcut-ref="PointCut" returning="result"/>
                  <!-- 环绕通知 -->
                  <aop:around method="myAround" pointcut-ref="PointCut"/>
                  <!-- 异常通知 -->
                  <aop:after-throwing method="myThrow" pointcut-ref="PointCut" throwing="ex"/>
                  <!-- 最终通知 -->
                  <aop:after method="myAfter" pointcut-ref="PointCut"/>
             \</aop:aspect\>
          \</aop:config\>
### Spring 和 Dao
   + 在以前我们的dao都是直接new出来了

   + 那么在现在我们就需要通过注入的方式来设置DaoImpl

   + 进行解耦

   + **Spring Jdbc**
      + Spring jdbc 为我们提供了很多增删改查的方法
      + 我们必须继承JdbcDaoSupport这个抽象类
      + 在我们的DaoImpl中继承
      + 继承之后可以得到   this.getJdbcTemplate().update 进行操作

   + 使用
      4. 
          <!-- 注册数据源    Spring   内置的连接池-->
          <bean id="dataSource" class="org.springframework.jdbc.datasource.DriverManagerDataSource">
             <property name="driverClassName" value="com.mysql.jdbc.Driver"/>
              <property name="url" value="jdbc:mysql:///student"/>
              <property name="username" value="root"/>
              <property name="password" value="root"/>
          </bean>
          4.
          <!-- dbcp 的数据源 -->
          <bean id="dataSource" class="org.apache.commons.dbcp.BasicDataSource">
              <property name="driverClassName" value="com.mysql.jdbc.Driver"/>
              <property name="url" value="jdbc:mysql:///student"/>
              <property name="username" value="root"/>
              <property name="password" value="root"/>
          </bean>
          4.
          <!-- c3p0 的数据源 -->
          <bean id="dataSource" class="com.mchange.v2.c3p0.ComboPooledDataSource">
              <property name="driverClass" value="com.mysql.jdbc.Driver"/>
              <property name="jdbcUrl" value="jdbc:mysql:///student"/>
              <property name="user" value="root"/>
              <property name="password" value="root"/>
          </bean>
          3.
          <!-- 注册jdbcTemplate -->
          <bean id="jdbcTemplate" class="org.springframework.jdbc.core.JdbcTemplate">
                 <property name="dataSource" ref="dataSource"/>
          </bean>
          2.
          <!-- 注册daoImpl -->
          <bean id="studentDao" class="daoimpl.IStudentDaoImpl">
               <property name="jdbcTemplate" ref="jdbcTemplate"/>
          </bean>
          <!-- 给Dao注入DataSource就不需要注册JdbcTemplate了 在JdbcDaoSupport内部有判断
               会判断模板是否为空 并且判断是否不是同一个数据源 满足一个条件就会自动帮助我们创建
               一个模板 并且初始化配置   **如果这样配置 就不用在配置jdbcTemplate了**
               直接跳到第四步
            -->
           <bean id="studentDao" class="daoimpl.IStudentDaoImpl">
                   <property name="dataSource" ref="dataSource"/>
           </bean>  

          1. <!-- 注册service -->

          <bean id="studentService" class="serviceImpl.IStudentServiceImpl">
                <property name="idao" ref="studentDao"/>
          </bean>   

   + c3p0 数据源配置项有很多
      + 关于效率 优化的
      + 在网上搜一下  就会出来

   + 从 .properties 文件 读取DB四要素
      + 方式1
         - 使用bean方式   类路径下

            ```XML
            <bean class="org.springframework.beans.factory.config.PropertyPlaceholderConfigurer">
                         <property name="location" value="classpath:jdbc.properties"/>
            </bean>
            
            ```

      + 方式2
         - 需要约束
           xmlns:context="http://www.springframework.org/schema/context
           http://www.springframework.org/schema/context
           http://www.springframework.org/schema/context/spring-context-4.0.xsd

         - 使用context方式 类路径下

            ```XML
            <context:property-placeholder location="classpath:jdbc.properties"/>
            ```
      + 使用
         - 在数据源的value中可以使用${yourConfigName}来获取值      

   + Spring Jdbc 的 模板
      +

      ```JAVA
      package daoimpl;
      import beans.Student;
      import dao.IStudentDao;
      import org.springframework.jdbc.core.BeanPropertyRowMapper;
      import org.springframework.jdbc.core.RowMapper;
      import org.springframework.jdbc.core.support.JdbcDaoSupport;
      import java.sql.ResultSet;
      import java.sql.SQLException;
      import java.util.List;
      import java.util.Map;
      public class IStudentDaoImpl extends JdbcDaoSupport implements IStudentDao {
          // 增加数据
          public void insertStudent(Student student) {
              String sql = "INSERT INTO student (name,age) VALUES (?,?);";
              this.getJdbcTemplate().update(sql,student.getName(),student.getAge());
          }
      
          // 删除数据
          public int deleteById(int id) {
              String sql = "DELETE FROM student WHERE id = ?";
              return this.getJdbcTemplate().update(sql, id);
          }
          public void updateStudent(Student student) {
              String sql = "UPDATE student SET name = ?,age = ? WHERE id = ?";
              this.getJdbcTemplate().update(sql,student.getName(),student.getAge(),student.getId());
      
          }
      
          public List<String> selectAllStudentsNames() {
              String sql = "SELECT name FROM s";
              List<String> list = this.getJdbcTemplate().queryForList(sql,String.class);
              return list;
          }
      
          public String selectStudentNameById(int id) {
              String sql = "SELECT name FROM student WHERE id = ?";
              return this.getJdbcTemplate().queryForObject(sql,String.class,id);
          } 
      
          // 返回集合需要使用人rowMap并且方法是query方法
          public List<Student> selectAllStudents() {
              String sql = "SELECT id,name,age FROM student";
              RowMapper<Student> rowMapper = new RowMapper<Student>() {
                  public Student mapRow(ResultSet resultSet, int i) throws SQLException {
                      System.out.println(i);
                      Student s = new Student();
                      s.setId(resultSet.getInt("id"));
                      s.setName( resultSet.getString("name"));
                      s.setAge(resultSet.getInt("age"));
                      return s;
                  }
              };
      
              List<Student> students = this.getJdbcTemplate().query(sql,rowMapper);
              return students;
      
          }
      
          // 返回单个实体类的话 也是要使用rowMap 不过 调用的方法可以是 queryForObject(sql,class<?> c,object... args)
          public Student selectStudentById(int id) {
              String sql = "SELECT id,name,age FROM student WHERE id = ? ";
              RowMapper<Student> mapper = new RowMapper<Student>() {
                  public Student mapRow(ResultSet resultSet, int i) throws SQLException {
                      System.out.println(i);
                      Student s = new Student();
                      s.setId(resultSet.getInt("id"));
                      s.setName(resultSet.getString("name"));
                      s.setAge(resultSet.getInt("age"));
                      return s;
                  }
      
              };
      
              Student s = this.getJdbcTemplate().queryForObject(sql,mapper,id);
              return  s;
          }
      
      }
      
      ```

      
### Spring 事务管理器 

+ 确保表的引擎是 innerdb
+ 确保运行在同一线程
+ 确保配置了事务管理器
+ 确保入口方法是public的修饰
+ 确保注册了事务通知 AspectsJ 和 Spring注解两种形式

   + Spring 的 回滚方式
     + Spring 的默认回滚方式
        - 发生运行时异常回滚 发生受查时异常提交 不过 对于受查异常 程序员可以手工设置其回滚方式
        **注意: 因为运行时异常严重 所以必须要回滚 受查异常相对不严重 可以通过一些方式进行处理 所有就是提交了**
     + 事务管理器接口 PlatformTransactionManager   下面是两个实现类
        - DataSourceTransactionManager   使用jdbc或iBatis进行持久化数据时使用
        - HibernateTransactionManager    使用Hibernate进行数据持久化时使用

   + 将事务从Dao层提升到Service层 因为在我们的业务逻辑中也有这样的需求 遵守事务的原子性

   + Spring 的事务代理工厂

     ```xml
     - <bean id="dataSource" class="com.mchange.v2.c3p0.ComboPooledDataSource">
         <property name="driverClass" value="com.mysql.jdbc.Driver"/>
         <property name="jdbcUrl" value="jdbc:mysql:///student"/>
         <property name="user" value="root"/>
         <property name="password" value="root"/>
         - </bean>
     
     <!-- 注册事务管理器 -->
     <bean id="myTransactionManager"  class="org.springframework.jdbc.datasource.DataSourceTransactionManager">
         <!-- 引用数据源 -->
         <property name="dataSource" ref="dataSource"/>
     </bean>
     
     <!-- 生成事务代理对象 -->
     <bean id="myProxyTransactionManager" class="org.springframework.transaction.interceptor.TransactionProxyFactoryBean">
         <!--  引用事务管理器  -->
         <property name="transactionManager" ref="myTransactionManager"/>
         <!-- 目标对象 就是我们的service层 -->
         <property name="target" ref="myService"/>
         <property name="transactionAttributes">
             <props>
                 <!-- 这里的key时service层里面的方法  这里的意思是值 所有以open开头的方法 -->
                 <prop key="open*">
                     ISOLATION_DEFAULT,PROPAGATION_REQUIRED
                 </prop>
                 <!-- - 代表发生异常时回滚 这时的异常时受查异常 -->
                 <!-- + 代表发生异常时提交 这时的异常时运行时异常 -->
                 <!-- 这里的意思是指名字为buyStork的方法 发生指定异常后回滚 -->
                 <prop key="buyStork">
                     ISOLATION_DEFAULT,PROPAGATION_REQUIRED, -BuyStorkException
                 </prop>
             </props>
         </property>
     </bean>
     
     ```

     


​        

         + 缺点： 不能调用目标对象  只能调用代理对象
         + 缺点： 一个目标对象就要重新配置一遍事务代理  

   + Spring的事务注解管理事务
         ```JAVA
        - <bean id="dataSource" class="com.mchange.v2.c3p0.ComboPooledDataSource">
              <property name="driverClass" value="com.mysql.jdbc.Driver"/>
              <property name="jdbcUrl" value="jdbc:mysql:///student"/>
              <property name="user" value="root"/>
              <property name="password" value="root"/>
        - </bean>
        <!-- 注册事务管理器 -->
        
        <bean id="myTransactionManager"class="org.springframework.jdbc.datasource.DataSourceTransactionManager">
                   <!-- 引用数据源 -->
                <property name="dataSource" ref="dataSource"/>
        </bean>
           <!-- 注入事务管理器  使用注解方式 -->
          <tx:annotation-driven transaction-manager="myTransactionManager"/>
        
        
        // 这里是serviceA里面的方法
        
           @Transactional(isolation = Isolation.DEFAULT,propagation = Propagation.REQUIRED)
            public void aa(){
                }
        
        // 这里是serviceB里面的方法
        
        @Transactional(isolation = Isolation.DEFAULT,propagation = Propagation.REQUIRED)
        public void bb(){
        
        }
        
        // 带回滚serviceC 持有A B 的dao 的引用并将serviceA serviceB 的事务方法联系到一块 所以这个service是多出来的 在测试的时候直接调用这个方法即可传入两个方法需要的参数并添加注解事务指定自定义异常的类型
        
        @Transactional(isolation = Isolation.DEFAULT,propagation = Propagation.REQUIRED,rollbackFor = Exception.class)
        public void cc(){
        	 
        }
        
         ```

        

         + 最后外面调用的是Service的id也就是调用的是目标对象  

   + AspectJ 的AOP事务配置管理 
         + 加入约束
            -  xmlns:tx="http://www.springframework.org/schema/tx"
              http://www.springframework.org/schema/tx http://www.springframework.org/schema/tx/spring-tx.xsd    
```xml
<bean id="dataSource" class="com.mchange.v2.c3p0.ComboPooledDataSource">
    <property name="driverClass" value="com.mysql.jdbc.Driver"/>
    <property name="jdbcUrl" value="jdbc:mysql:///student"/>
    <property name="user" value="root"/>
    <property name="password" value="root"/>
</bean> 
<!-- 注册事务管理器 -->
<bean id="myTransactionManager"  class="org.springframework.jdbc.datasource.DataSourceTransactionManager">
    <!-- 引用数据源 -->
    <property name="dataSource" ref="dataSource"/>
</bean>
<!-- 注册事务通知 -->
<tx:advice id="txAdive" transaction-manager="myTransactionManager">
       <tx:attributes>
        <!-- 执行事务方法 -->
        <tx:method name="open*" isolation="DEFAULT" propagation="REQUIRED"/>
        <tx:method name="buyStork" isolation="DEFAULT" propagation="REQUIRED" rollback-for="Exception"/>
        <tx:attributes>
    <tx:advice>
        <!-- AOP 配置 -->
        <aop:config>
            <!-- 这里是指定切入点 -->
            <aop:pointcut id="pointCut" expression="execution(* ..service..*(..))"/>
            <aop:advisor advice-ref="txAdive" pointcut-ref="pointCut"/>
        </aop:config>  

```





​    + Spring 与 Mybatis
          + 需要更多的mybatis-spring的jar包
          + 在整合的时候在mybatis的主配置文件中不需要在配置数据源以及事务管理器了
          + 一般配置一下mapper和别名或者settings即可
          + Mybatis.xml 主配置文件内容

           ```xml
<?xml version="1.0" encoding="UTF-8" ?>
<!DOCTYPE configuration PUBLIC "-//mybatis.org//DTD Config 3.0//EN" "http://mybatis.org/dtd/mybatis-3-config.dtd">
<!-- 主配置文件 根标签 -->
<configuration>
    <!-- 设置支持log4j2 -->
    <settings>
        <setting name="logImpl" value="LOG4J"/>
    </settings>
    <!-- 别名 在映射文件中写 parameterType 的时候可以直接写简单类名 -->
    <typeAliases>
        <package name="beans"/>
    </typeAliases>
    <!-- 注册映射文件 -->
    <mappers>
        <!-- 属性 url 是放置在机器上的绝对路径的时候用这个 -->
        <package name="dao"/>
    </mappers>
</configuration> 

           ```



​          +  Spring 配置文件内容

```xml
<?xml version="1.0" encoding="UTF-8" ?>
<beans xmlns="http://www.springframework.org/schema/beans"
       xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
       xmlns:aop="http://www.springframework.org/schema/aop"
       xmlns:tx="http://www.springframework.org/schema/tx"
       xmlns:context="http://www.springframework.org/schema/context"
       xsi:schemaLocation="
                           http://www.springframework.org/schema/context
                           http://www.springframework.org/schema/context/spring-context-4.0.xsd
                           http://www.springframework.org/schema/beans http://www.springframework.org/schema/beans/spring-beans.xsd
                           http://www.springframework.org/schema/tx http://www.springframework.org/schema/tx/spring-tx.xsd
                           http://www.springframework.org/schema/aop http://www.springframework.org/schema/aop/spring-aop.xsd">

```

​        



​                      **引入外部 properties 文件**

                    ```xml
<context:property-placeholder location="classpath:jdbc.properties"/>

注册DataSource c3p0

<bean id="dataSource" class="com.mchange.v2.c3p0.ComboPooledDataSource">

    <property name="driverClass" value="${jdbc.driver}"/>
    
    <property name="jdbcUrl" value="${jdbc.url}"/>
    
    <property name="user" value="${jdbc.username}"/>
    
    <property name="password" value="${jdbc.password}"/>

</bean>

生成sqlSessionFactory对象 

<bean id="mySQLSessionFactory" class="org.mybatis.spring.SqlSessionFactoryBean">

    <property name="dataSource" ref="dataSource"/>
    
    <property name="configLocation" value="classpath:Mybatis.xml"/>

</bean>

生成Dao的代理对象

<bean id="myStudentDao" class="org.mybatis.spring.mapper.MapperFactoryBean">

    <property name="sqlSessionFactory" ref="mySQLSessionFactory"/>
    
    // 代理的是哪一个Dao
    
    <property name="mapperInterface" value="dao.IStudentDao"/>

</bean>

注册Service

<bean id="myIStudentService" class="serviceImpl.IStudentServiceImpl">

    <property name="idao" ref="myStudentDao"/>

</bean>

</beans> 

                    ```



```java
- 注意 Receiver+class+org.mybatis.spring.transaction.SpringManagedTransaction+does+not+define

            - 出现这个错误的原因主要是spring-mybatis和mybatis版本不匹配，产生冲突的原因；

              我测试的时候mybatis和spring-mybatis的版本分别为：3.4.1和1.1.1会出现此错误，

              经过再三测试3.3.1和1.1.1；3.4.1和1.3.1没有错误。

          + 那么以上的配置方式还存在一个问题 那就是我们有多个Dao的时候要写多个代理

          + 我们可以吧Dao的代理对象修改一下将   

```



          ```xml
<bean id="myStudentDao" class="org.mybatis.spring.mapper.MapperFactoryBean">

    <property name="sqlSessionFactory" ref="mySQLSessionFactory"/>
    
    // 代理的是哪一个Dao
    
    <property name="mapperInterface" value="dao.IStudentDao"/>

</bean>

<!-- 注册Service -->

<bean id="myIStudentService" class="serviceImpl.IStudentServiceImpl">

    <property name="idao" ref="myStudentDao"/>

</bean>

          ```



​           **改成**

          ```xml
<!-- 生成Dao的代理对象 -->

<bean class="org.mybatis.spring.mapper.MapperScannerConfigurer">

    <property name="sqlSessionFactoryBeanName" value="mySQLSessionFactory"/>
    
    <property name="basePackage" value="dao"/>

</bean>

<!-- 注册Service -->

<bean id="myIStudentService" class="serviceImpl.IStudentServiceImpl">

    <!-- 
    
                    这里的Dao的注入需要使用ref属性
    
                    若Dao的接口名字前两个大写字母是大写 则这里的值为接口的简单类名
    
                    若Dao的接口的名字的首字母是大写第二个字母是小写 则这里的值为简单类名 但是首字母小写
    
                 -->
    
    <property name="idao" ref="IStudentDao"/>

</bean>  

          ```



### Sping 和 Web

+ 不能将Spring容器直接创建在Servlet里 因为每一个请求就会创建一个容器 创建一个容器就会初始化容器中的所有对象

+ 占用内存开销  占用CPU内存

+ 解决办法

  +  使用ServletContext的监听器
  +  ServletContextListener
  +  将ApplicatonContext对象容器存储到域属性空间中 setAttribute
  +  获取 getAttribute
  +  这个listener不用我们创建 Spring已经帮我们创建好了
  +  直接用
  +  **ContextLoaderListener**

+ 使用第一步

  + 在web.xml中配置listener  

  + 在ServletContext对象创建后就创建ApplicationContext容器

  + 然后将ApplicationContext容器放置到application的域属性中

    ```xml
    - <listener>
      -  <listener-class> 
        - org.springframework.web.context.ContextLoaderListener
      -  </listener-class>
    - </listener>
    ```

    

+ 使用第二步

  + 在使用的Servlet中获取到ApplicationContext对象

    ```java
    - String acKey = WebApplicationContext.ROOT_WEB_APPLICATION_CONTEXT_ATTRIBUTE
    - ApplicationContext ac = (ApplicationContext)this.getServletContext().getAttribute(acKey);
    ```

    **另一种获取方式  使用一个工具类**

    ```java
    - WebApplicationContext ac  = WebApplicationContextUtils.getRequiredWebApplicationContext(getServletContext())
    - ac.getBean("xxx")
    ```

  + 获取到的就是ApplicationContext容器

+ 使用第三步

  +  有可能会报错 提示让给applicationContext.xml放到WEB_INF文件夹下 如果提示就放到下面即可 并且名字必须是applicationContext.xml

+ 修改 指定配置文件位置  修改ContextLoaderListener类的默认配置文件位置

  ```xml
  - <context-param>
    - <param-name>contextConfigLocation</param-name>
    - <param-value>classpath:spring.xml</param-value>
  - </context-param>
  ```

  