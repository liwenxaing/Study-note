# Java笔记

# IDEA 快捷键

+ psvm  生成 main
+ sout    快速输出
+ fori      快速生成for
+ foreach  快速生成each
+ item.for  
+ item.fori
+ item.forr
+ **java 工程导出jar包**
  + file - project Structure - Artifacts - + - JAR - From module with ... - 选择工程 设置主类 -  工具栏 build - build artifacts  - 选择刚设置的项目 - build 即可导出到输出路径 

## 三大版本

+ JavaSe
+ JavaEe  主流 发展最好
+ JavaMe

## 特性

+ 跨平台/可移植性
+ 安全性
+ 面向对象
+ 简单性
+ 高性能
+ 分布式

## Java 获取编译后的最终目录或文件的绝对路径

```java
proper.class.getClass().getResource("/proper.class").getPath()
```

## Java 动态编译

```java
JavaCompiler compiler = ToolProvider.getSystemJavaCompiler();
int isSuccess = compiler.run(null, null, null,"d:/A.java");
System.out.println(isSuccess == 0 ? "编译成功" : "编译失败");
Runtime run = Runtime.getRuntime();
try {
    Process process = run.exec("java -cp d:/ A");
    InputStream is = process.getInputStream();
    BufferedReader br = new BufferedReader(new InputStreamReader(is));
    String str = "";
    while((str = br.readLine()) != null) {
        System.out.println(str);
    }
} catch (IOException e) {
    e.printStackTrace();
}

```



## 运行机制

1. 编写java源代码
2. 编译为class字节码文件
3. 通过类加载器装载字节码文件
4. 通过字节码校验器
5. 解释器解释字节码文件
6. 运行到系统平台

**JRE 包含了 JVM**

## 变量类型

+ int 4字节
+ double 8字节
+ float 4字节
+ long 8 字节
+ short 2字节
+ byte 1字节    -128 - 127
+ boolean 1位
+ char 2字节

## 进制

+ 015 8进制
+ 0x15 16进制
+ 0b1101 2进制
+ 150 10进制

## 精度比较运算

+ float | double 运算是不精确的
+ 如过想要精确那就使用 java.math.BigDecimal类许算
+ BigDecimal big = BigDecimal.valueOf(0.1);

## 位运算

+ 左 << 乘  移1位表示乘2 效率较高
+ 右 >> 除  移一位表示除于2 效率较高

## 垃圾回收

+ 在java中有专业的垃圾回收机制进行垃圾回收
+ 当发现存在无用对象 就会回收掉无用对象所占用的内存空间
+ 相关算法
  + 引用计数法
    + 缺点 :   循环引用可达对象
  + 引用可达法
+ 分代的垃圾回收机制
  + 年轻代    新对象
    + 当年轻代存放满的时候会进行一次计算  清理掉无用对象
    + 然后将剩下的对象存放到survivor区  
  + 年老代    老对象
    + 当年老代满的时候会触发 Full GC 全面清理 比较耗性能
  + 持久代  - 永生

## == 和 equals

+ ==	
  + 如果是基本数据类型  那就直接比较值
  + 如果是引用数据类型就比较地址
+ equals
  + 会先比较是不是同一个对象
  + 如果是String类里面的equals如果不是同一个类那就开始比较值是否相等
  + equals我们还可以重写 进行自定义的比较

## 自定义异常

+ 如果是普通异常 继承Exception就行
+ 如果是 IO 异常的话 继承 IOExcption
+ 编写一个无参构造
+ 编写一个有参构造传入一个参数String message 调用super(message)
+ 在使用的时候就可以用直接抛出 抛出之后 调用者就需要捕获

## Java 排序  treeSet

+ 可以在使用的时候直接排序
+ 其他的集合 需要借助 集合 工具类进行排序

```java
import java.util.Comparator;
import java.util.Iterator;
import java.util.TreeSet;

public class sort {
    public static void main(String[] args) {
        TreeSet<Programmer> tree = new TreeSet<Programmer>(
                new Comparator<Programmer>(){
                    @Override
                    public int compare(Programmer o1, Programmer o2) {
                        return o1.getHandsome() - o2.getHandsome();
                    }
                }
        );

        Programmer p1 = new Programmer("lee",100);
        Programmer p2 = new Programmer("Will",600);
        Programmer p3 = new Programmer("jick",40);

        tree.add(p1);
        tree.add(p2);
        tree.add(p3);

        Iterator<Programmer> it = tree.iterator();
        while(it.hasNext()){
            Programmer item = it.next();
            System.out.println(item.getName() + "--" + item.getHandsome());
        }

    }
}

class Programmer {
    private String name;
    private int handsome;

    public Programmer(String name, int handsome) {
        this.name = name;
        this.handsome = handsome;
    }

    public Programmer() {
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public int getHandsome() {
        return handsome;
    }

    public void setHandsome(int handsome) {
        this.handsome = handsome;
    }

}

```

## HashMap 和 HashTable 的区别

```
/**
 *  HashTable 线程安全 效率低下
 *  HashMap  线程不安全  效率较高
 *  HashTable 父类是  Dictionary HashMap 父类是  AbstractMap
 *  null HashTable 键与值不能null  HashMap 键可以有一个null 值可以有多个 null
 */
```

## 设计模式

### 单例设计模式

+ 一个类只能有一个实例
+ 私有构造器
+ 创建静态属性
+ 创建静态方法
+ 懒汉式
+ 饿汉式
+ 内部静态类模式

### 装饰设计模式

+ 扩展功能
+ 得到需要扩展的类的引用 进行扩展 可以设置个属性类型为需要扩展的类

### 静态代理设计模式

+ 必须实现同一个接口
+ 必须有真实角色
+ 必须有代理角色
  + 要持有真实角色的权限
  + 代替真实角色去做某些事

```java
package top.liwenxiang.stream;

public class dl {
    public static void main(String[] args) {
        /*
         * 只允许得到一个实例
         */
        Person p1 = Person.getPerson();
        Person p2= Person.getPerson();
        Person p3 = Person.getPerson();
        Animal a1 = Animal.getAnimal();
        Animal a2 = Animal.getAnimal();
        Animal a3 = Animal.getAnimal();

        System.out.println("单例 ： " + (p1 == p2));
        System.out.println("单例 ： " + (p2 == p3));
        System.out.println("单例 ： " + (a1 == a2));
        System.out.println("单例 ： " + (a2 == a3));


        horn h = new horn();
        h.say();
        /*
         * 扩音器装饰了 音响 使其声音更大
         */
        Loudspeaker ls = new Loudspeaker(h);
        ls.say();

        /*
         *  衣服装饰了人
         */
        personal p = new personal();
        System.out.println("身高" + p.getHeight() + "颜值" + p.getLevel_of_appearance());
        clothes c = new clothes(p,"200cm","100");
        System.out.println("身高" + p.getHeight() + "颜值" + p.getLevel_of_appearance());
        
        /* 静态代理模式 */
        //真实角色
        you y = new you();
        // 代理角色 得到真实的角色的引用
        i i = new i(y);
        i.modified();
    }
}

/**
 * 静态代理模式
 */
interface modify {
    void modified();
}
// 真实角色
class you implements modify{

    @Override
    public void modified() {
        System.out.println("你和嫦娥结婚了....!");
    }
}
// 代理角色
class i implements modify{
    private you y;

    public i(){};

    public i(you y){
        this.y = y;
    }

    private void before(){
        System.out.println("布置新房！");
    }

    private void after(){
        System.out.println("闹伴娘....");
    }
    @Override
    public void modified(){
        before();
        y.modified();
        after();
    }
}


/**
 * 个人类
 */
class personal {

        private String height = "170cm";
        private String Level_of_appearance = "80";

        public String getHeight() {
            return height;
        }

        public void setHeight(String height) {
            this.height = height;
        }

        public String getLevel_of_appearance() {
            return Level_of_appearance;
        }

        public void setLevel_of_appearance(String level_of_appearance) {
            Level_of_appearance = level_of_appearance;
        }


}

/**
 * 衣服类
 */
class clothes{
    private personal pp;

    public clothes(personal pp,String height,String level){
        pp.setHeight(height);
        pp.setLevel_of_appearance(level);
    };
}

/**
 *  装饰设计模式
 */
class horn{

        private int volume = 10;

        public int getVolume() {
            return volume;
        }

        public void setVolume(int volume) {
            this.volume = volume;
        }

        public void say(){
            System.out.println(volume);
        }

}

class Loudspeaker{
       private horn volume;

       public Loudspeaker(horn h){
           this.volume = h;
       }

       public void say(){
           System.out.println(volume.getVolume()*1000);
       }
}

/**
 * 单例设计模式     1
 */
class Person {
    public Person(){}

    private static Person p= null;

    public static Person getPerson(){
          if( p == null ){
               p = new Person();
          }
          return p;
    };
}

/**
 * 单例设计模式     2
 */
class Animal {
    private Animal(){}

    private static Animal a = new Animal();;

    public static Animal getAnimal(){
        return a;
    };
}
```
## 基于 JDK Proxy类的动态代理

```java
    import java.lang.reflect.InvocationHandler;
    import java.lang.reflect.Method;
    import java.lang.reflect.Proxy;

    /**
     *  在Java运行Class文件的时候
     *  就是在执行了 java helloworld 命令的时候会先加载调用bootstrapClassLoader 系统引导类  extClassloader 扩展类  appClassloader 自定义的应用类
     *  其中 AppcclassLoader 在运行的时候如果本机配置了classpath就会按照配置的路径进行逐一查找 找不到的话就会抛出找不到类的异常
     *  如果没有配置的话那么就是根据当前项目进行查找 相同的使 如果没有找到的话那就也会抛出一个相同的错误
     */

    public class dynamic_proxy {
        public static void main(String[] args) {
            /**
             *  基于 JDK Proxy  类 实现动态代理
             *  动态代理是在程序运行时 动态创建代理对象进行创建的
             *  被代理对象 必须要实现 接口
             *  需要获取到被代理的对象的类加载器和所实现的接口
             */
            Formulate target = new FormulateImpl();
            /**
             *    第一个参数     被代理的对象的类加载器
             *    第二个参数     被代理的对象所实现的类
             *    第三个参数     一个接口 匿名函数
             *                  第一个参数  代理对象   第二个参数  目标方法   第三个参数  目标方法参数列表
             *                  通过反射的invoke方法进行调用  返回Object类型 第二个参数就是参数列表啦
             *                  最后直接返回即可 这时候 被代理对象的内容已经被进行改变了
              */
            Formulate fr = (Formulate) Proxy.newProxyInstance(target.getClass().getClassLoader(), target.getClass().getInterfaces(), new InvocationHandler() {
                @Override
                public Object invoke(Object proxy, Method method, Object[] args) throws Throwable {
                    Object oo = method.invoke(target, args);
                    return ((String)oo).toUpperCase();
                }
            });
            String result = fr.findAll("123");
            System.out.println(result);
        }
    }
    // 接口
    interface Formulate {
        String findAll(String aa);
    }
    // 目标代理对象
    class FormulateImpl implements Formulate{
        @Override
        public String findAll(String aa) {
            System.out.println("findAll");
            return "abcde";
        }
    };
```

## 反射

**一般用于框架底层**

**获取类三种方法**

+ Class.forName("package.className")
+ className.class
+ classObject.getClass()

**获取类名称**

+ clazz.getName()    带包的名字详细
+ clazz.getSimpleName() 简单的名字

**获取到类的修饰符信息**

+ clazz.getModifires()  返回值是 int 修饰符以数字来表示
+ 0 1 2 4 8 16 32  ......

**获取到当前类的包**

+ clazz.getPackage()  返回个  Package类
+ p.getName()

**获取到当前类的父类**

+ p.getSuperClass()  返回 Class对象

**通过class对象实例化当前类**

+ clazz.newInstance()   返回Object类型  可以强转为需要的类型    因为在设计的时候 不知道Cla's's对象代表的是哪一个类 所以返回的就是一个Object对象

**获取属性**

+ clazz.getFiled("name")   返回值  是  Filed 类

```java
Field newField = clazz.getField("name");
newField.getModifiers();  // 获取到属性的修饰符
newField.getType();   // 获取到属性的类型   返回class
newField.getName();   // 获取到属性的名字
/* 通过反射设置获取属性 但是这样只能够操作公共的属性 */
Person p = (Person) clazz.newInstance();
newField.set(p,"大加好");   // 设置和获取的时候要生命是设置或者获取哪一个对象里面的属性
String s = (String) newField.get(p);
System.out.println(s);
/* 设置私有的属性和获取私有的属性 */
Field ff = clazz.getDeclaredField("love");
ff.setAccessible(true);  // 设置可以修改私有属性
ff.set(p,80);
System.out.println(ff.get(p));
/* 获取到所有公共的属性 */
Field[]  f = clazz.getFields();  // 返回的是一个数组
```

**获取方法**

```java
Class clazz = Class.forName("Person");
Person pp  = (Person)clazz.newInstance();
Method mm = clazz.getMethod("a",int.class);  // 无参方法的话不需要进行传递类信息
mm.invoke(pp,123);  // 无参的话可以直接调了 传递一个Person对象即可

/* 获取私有方法 */
Class clazz = Class.forName("Person");
Person pp  = (Person)clazz.newInstance();
Method mm = clazz.getDeclaredMethod("c");
mm.setAccessible(true);
mm.invoke(pp);
```

**获取有参构造器**

```java
Class clazz = Class.forName("Person");
Constructor cc = clazz.getConstructor(String.class,int.class);
Person pppp  =  (Person)cc.newInstance("lee",18);
System.out.println(pppp.name);
/* 获取无参构造函数 */
Class clazz = Class.forName("Person");
clazz.newinstance();
```

## JSP/SERVLET 上传文件 

```java
package Servlet;

import javafx.scene.input.DataFormat;
import org.apache.commons.fileupload.FileItem;
import org.apache.commons.fileupload.FileItemFactory;
import org.apache.commons.fileupload.FileUploadBase;
import org.apache.commons.fileupload.FileUploadException;
import org.apache.commons.fileupload.disk.DiskFileItemFactory;
import org.apache.commons.fileupload.servlet.ServletFileUpload;

import javax.servlet.ServletContext;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebInitParam;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import java.io.File;
import java.io.IOException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.Iterator;
import java.util.List;

@WebServlet(name = "Servlet",urlPatterns = "/Servlet",initParams = {@WebInitParam(name="name",value = "465")})
public class Servlet extends HttpServlet {
    protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        System.out.println("进入Servlet");
        //单个Servlet的初始化参数
        //        super.getInitParameter("name");
        // 获取到上下文初始化参数
        //        ServletContext sc = super.getServletContext();
        //        String str = sc.getInitParameter("name");

        /**
             *  上传图片代码
             */
        request.setCharacterEncoding("utf-8");
        response.setContentType("text/html;charset=utf-8");
        response.setCharacterEncoding("utf-8");
        /* 第一步 检查上传的表单是否包含上传图片 */
        boolean isUpload = ServletFileUpload.isMultipartContent(request);
        if (isUpload){
            // 代表有上传文件
            FileItemFactory factory = new DiskFileItemFactory();
            ServletFileUpload sf   =  new ServletFileUpload(factory);
            try {
                //大小必须在解析前进行限制
                sf.setSizeMax(100*1024);
                List<FileItem>  temps = sf.parseRequest(request);
                Iterator<FileItem> iter = temps.iterator();
                while (iter.hasNext()){
                    FileItem temp = iter.next();
                    // 获取到字段name名称
                    String fieldName = temp.getFieldName();
                    String name = null;
                    if(temp.isFormField()){
                        if(fieldName.equals("names")){
                            name = temp.getString();
                        }else{
                            System.out.println("其他字段");
                        }
                        System.out.println(name);
                    }else{
                        // 获取到文件名称
                        String fileName = temp.getName();
                        String ext  = fileName.substring(fileName.lastIndexOf(".")+1);
                        List<String> list = new ArrayList<>();
                        list.add("png");
                        list.add("jpg");
                        list.add("gif");
                        boolean isFileUploadType = list.contains(ext);
                        if(!isFileUploadType){
                            System.out.println("请上传正确的类型文件");
                            return;
                        }
                        // 路径是根据打包后的路径  也可以自己写死
                        String path = 		                            request.getSession().getServletContext().getRealPath("up");
                        Date dd = new Date(System.currentTimeMillis());
                        SimpleDateFormat sdf = new SimpleDateFormat("yyyy-MM-dd");
                        String date = sdf.format(dd);
                        File  f = new File(path,date + "." + ext);
                        // temp 就是整个文件的核心 就在这一步将文件上传了进去
                        temp.write(f);

                    }
                }
            }catch (FileUploadBase.SizeLimitExceededException e){
                System.out.println("超过限制大小100kb");
            } catch (FileUploadException e) {
                e.printStackTrace();
            } catch (Exception e) {
                e.printStackTrace();
            }
        }else{
            //没有
        }

    }

    protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        doPost(request,response);
    }
}
```

## 下载

```java
// 获取 路径
String file_name = request.getParameter("filename");

/* 添加响应头 */
response.setHeader("Content-disposition","attachment;filename="+fileName);
response.addHeader("content-type","application/octet-stream");

/* 读取文件 */
// 读取这个资源文件
InputStream is = getServletContext().getResourceAsStream("/up/"+file_name);
ServletOutputStream sos = response.getOutputStream();
byte[] b = new byte[1024];
int len = 0;
while (-1 != (len = is.read(b))){
     sos.write(b,0,len);
}
sos.flush();
```
## JSTL 标签

```java
<%@ include file="index2.jsp"%>

<c:choose>
  <c:when test="${1 < 2}">
    1 < 2
  </c:when>

  <c:when test="${ 1 > 0}">
    1 > 0
  </c:when>

  <c:otherwise>
    其他
  </c:otherwise>
</c:choose>

<c:out value="789" default="789456" escapeXml="true">
</c:out>

<c:set var="name" value="789" scope="request">
</c:set>

<c:remove var="name" scope="request">
</c:remove>

<c:if test="${1 == 2}" var="status" scope="request">
      uio
</c:if>



<c:forEach begin="1" end="10" var="i">
    ${i}
</c:forEach>

<c:if test="${not empty list}">
  <c:forEach items="${list}" var="i" varStatus="status">
    ${status.count}
    ${i}
  </c:forEach>
</c:if>
```
## listener

```java
package Listener;

import javax.servlet.ServletContextEvent;
import javax.servlet.ServletContextListener;
import javax.servlet.ServletRequestEvent;
import javax.servlet.ServletRequestListener;
import javax.servlet.annotation.WebListener;
import javax.servlet.http.*;

@WebListener()
public class Listener implements ServletContextListener,
        HttpSessionListener, ServletRequestListener, HttpSessionActivationListener,HttpSessionAttributeListener, HttpSessionBindingListener {

    // Public constructor is required by servlet spec
    public Listener() {
        System.out.println("listener构造器");
    }

    // -------------------------------------------------------
    // ServletContextListener implementation
    // -------------------------------------------------------
    public void contextInitialized(ServletContextEvent sce) {
      /* This method is called when the servlet context is
         initialized(when the Web application is deployed). 
         You can initialize servlet context related data here.
      */
        System.out.println("上下文初始化");

    }

    public void contextDestroyed(ServletContextEvent sce) {
      /* This method is invoked when the Servlet Context 
         (the Web application) is undeployed or 
         Application Server shuts down.
      */
        System.out.println("上下文销毁");
    }

    // -------------------------------------------------------
    // HttpSessionListener implementation
    // -------------------------------------------------------
    public void sessionCreated(HttpSessionEvent se) {
        /* Session is created. */
        System.out.println("session创建");
    }

    public void sessionDestroyed(HttpSessionEvent se) {
        /* Session is destroyed. */
        System.out.println("session销毁");
    }

    // -------------------------------------------------------
    // HttpSessionAttributeListener implementation
    // -------------------------------------------------------

    public void attributeAdded(HttpSessionBindingEvent sbe) {
      /* This method is called when an attribute 
         is added to a session.
      */
        System.out.println("session属性添加");
    }

    public void attributeRemoved(HttpSessionBindingEvent sbe) {
      /* This method is called when an attribute
         is removed from a session.
      */
        System.out.println("session属性移除");
    }

    public void attributeReplaced(HttpSessionBindingEvent sbe) {
      /* This method is invoked when an attibute
         is replaced in a session.
      */
        System.out.println("session属性修改");
    }

    @Override
    public void requestDestroyed(ServletRequestEvent servletRequestEvent) {
        System.out.println("请求request销毁");
    }

    @Override
    public void requestInitialized(ServletRequestEvent servletRequestEvent) {
        System.out.println("请求request初始化");
    }

    @Override
    public void valueBound(HttpSessionBindingEvent httpSessionBindingEvent) {
        System.out.println("session绑定了 一个对象");
    }

    @Override
    public void valueUnbound(HttpSessionBindingEvent httpSessionBindingEvent) {
        System.out.println("session解绑了一个对象");
    }

    @Override
    public void sessionWillPassivate(HttpSessionEvent httpSessionEvent) {
        httpSessionEvent.getSession();
        System.out.println("session钝化");
    }

    @Override
    public void sessionDidActivate(HttpSessionEvent httpSessionEvent) {
        System.out.println("session活化");
    }

    // 通过配置tomcat 实现钝化 活化
  
}

```

### webXml 配置

+ ```xml
  <listener>
      <!-- 包名.类名 -->
      <listener-class>Listener.Listener</listener-class>
  </listener>
  ```

## 钝化 活化 配置

```xml
<Manager className="org.apache.catalina.session.PersistentManager" maxIdleSwap="1">
  <Store className="org.apache.catalina.session.FileStore" directory="填上自己的文件名" />
 </Manager>！
```
## JUnit

+ 导入jar包
+ 设置注解   直接加载类中 不需要main入口
  + @Before
    + 前置方法  在测试前执行
  + @After
    + 后置方法   在测试后执行
  + @Test
    + 测试方法   

## log4j    log4j2

+ 日志级别

  + fatal
  + error
  + warn
  + info
  + debug
  + trace

+ 便于控制

+ 如果将配置文件  log4j2.xml 放置在 src 目录下的话 那么就会默认导入

+ 如果放置在其他文件夹下的话那么就需要通过ConfigurationSource类来进行导入

+ 代码

  + ```java
    ConfigurationSource source = new ConfigurationSource(new FileInputStream(new File("log4j/config/log4j2.xml").getAbsolutePath()));
    Configurator.initialize(null, source);
    Logger logger = LogManager.getLogger(log4j.class);
    logger.fatal("真特么的  发生了致命错误!");
    logger.error("真特么的  发生了错误!");
    logger.warn("啊  警告！");
    logger.info("有信息");
    logger.debug("调试了一下");
    logger.trace("堆栈信息");
    ```

