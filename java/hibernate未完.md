## Hibernate5 笔记

### 概述

+ 是一个ORM框架
+ 内部封装的JDBC更加方便的进行数据库操作
+ 主要是针对持久层

### 配置文件

```xml
<?xml version="1.0" encoding="GBK"?>
<!-- 指定Hibernate配置文件的DTD信息 -->
<!DOCTYPE hibernate-configuration PUBLIC
    "-//Hibernate/Hibernate Configuration DTD 3.0//EN"
    "http://www.hibernate.org/dtd/hibernate-configuration-3.0.dtd">
<!-- hibernate- configuration是连接配置文件的根元素 -->
<hibernate-configuration>
    <session-factory>
        <!-- 指定连接数据库所用的驱动 -->
        <property name="connection.driver_class">com.mysql.jdbc.Driver</property>
        <!-- 指定连接数据库的url，hibernate连接的数据库名 -->
        <property name="connection.url">jdbc:mysql://localhost/数据库名</property>
        <!-- 指定连接数据库的用户名 -->
        <property name="connection.username">root</property>
        <!-- 指定连接数据库的密码 -->
        <property name="connection.password">32147</property>
        <!-- 指定使用c3p0连接池 -->
  	 	<property name="hibernate.connection.provider_class">org.hibernate.c3p0.internal.C3P0ConnectionProvider</property>
        <!-- 指定连接池里最大连接数 -->
        <property name="hibernate.c3p0.max_size">20</property>
        <!-- 指定连接池里最小连接数 -->
        <property name="hibernate.c3p0.min_size">1</property>
        <!-- 指定连接池里连接的超时时长 -->
        <property name="hibernate.c3p0.timeout">5000</property>
        <!-- 指定连接池里最大缓存多少个Statement对象 -->
        <property name="hibernate.c3p0.max_statements">100</property>
        <!-- 每隔多久时间进行扫描  取差值 干掉超时链接 是一个新线程 -->
        <property name="hibernate.c3p0.idle_test_period">3000</property>
        <!-- 当连接池满之后一次申请多少个新链接池 看性能配置 -->
        <property name="hibernate.c3p0.acquire_increment">2</property>
		<!-- mysql 不支持   假设读取1万条数据  不会立即读取10000条 而是慢慢读取 等待处理完读取 -->
        <property name="hibernate.jdbc.fetch.size">100</property>
        <!-- mysql 支持 进行批处理 优化性能 合理设置 30 -->
        <property name="hibernate.jdbc.batch.size">30</property>
        <property name="hibernate.c3p0.validate">true</property>
        <!-- 指定数据库方言 -->
        <property name="dialect">org.hibernate.dialect.MySQL5InnoDBDialect</property>
        <!-- 根据需要自动创建数据表 -->
        <!-- update create create-drop validate -->
        <property name="hbm2ddl.auto">update</property>
        <!-- 显示Hibernate持久化操作所生成的SQL -->
        <property name="show_sql">true</property>
        <!-- 将SQL脚本进行格式化后再输出 -->
        <property name="hibernate.format_sql">true</property>
        <!-- 罗列所有的映射文件 -->
        <mapping resource="映射文件路径/News.hbm.xml"/>
    </session-factory>
</hibernate-configuration>
```

### 映射文件

```xml
<?xml version="1.0"?> 
<!DOCTYPE hibernate-mapping PUBLIC 
"-//Hibernate/Hibernate Mapping DTD 3.0//EN" 
"D:\LINUX\hibernate\hibernate.mapping.dtd">
<hibernate-mapping   [package="com.lwx.model"]>
    	<!-- name:实体类全限定包名  table:对应数据库中生成的表格-->
         <class name="com.hibernate.entity.users"  table="USERS">
         		<!-- name:实体类的属性名称    type:对应的java类型 -->
         	   <id name="id" type="java.lang.Integer" [column="ID"]>
         	   	    <!-- 这里就是在数据库中生成的字段 -->
         	   	   <column name="ID"/>
                   <!--  native uuid -->
         	   	   <generator class="native"/>
         	   </id>
         	   <property name="name" type="java.lang.String" [column=NAME] [index="xxx"]>
         	   	   <column name="NAME" />
         	   </property>
         	   <property length="50" name="auther" type="java.lang.String">
         	   		 <column name="AUTHER"/>
         	   </property>
         	   <property  name="date" type="java.util.Date">
         	          <column name="DATE"></column>
         	   </property>
                <property name="MyContent" type="text">
         	          <column name="CONTENT" sql-type="text"></column>
         	   </property>
                <property name="blob" type="blob">
         	          <column name="blob" sql-type="mediumblob"></column>
         	   </property>
               <!-- 派生字段  在数据库中实际不存储 formula 不能加column 加了会报错-->
               <property name="blob" type="blob" formula="(SELECT floor(NOW(),s.date) FROM users WHERE s.id = id)"/>
         </class>
</hibernate-mapping>
```

### 获取Session

```java
SessionFactory sessionFactory = null;
// 默认回去类路径下面查找   hibernate.cfg.xml 文件
Configuration configuration = new Configuration().configure();
ServiceRegistry serviceRegistry = configuration.getStandardServiceRegistryBuilder().build();
sessionFactory = new MetadataSources(serviceRegistry).buildMetadata().buildSessionFactory();
Session openSession = sessionFactory.openSession();
// 开启事务
Transaction transaction = openSession.beginTransaction(); 
Users u = new Users(null,"张三","北京",new Date());
openSession.save(u);
// 提交事务
transaction.commit();
openSession.close();
sessionFactory.close();
```
### 增删改查API

```java
# 根据ID 查询
Users users = openSession.get(Users.class,1);
System.out.println(users);
Users users1 = openSession.get(Users.class,1);
System.out.println(users1);
# 增加
Users users = new Users(null,"李文祥","北京昌平",new Date());
openSession.save(users);	
```

### 缓存

+ hibernate的一级缓存默认是开启的  是session级别的
+ 只要session缓存不被清空  对象会一直存在 生命周期中
+ 减少访问数据库的频率
+ 保证缓存中的数据和数据库的数据一致
+ flush操作在进行提交的操作中就进行了  这个是为了保证数据库中数据和缓存池中数据是一致的而提供的 如果数据库数据和缓存中数据不一致  那么就会发出update语句对数据库进行更新 
+ refresh   不会判断  直接向数据库发送查询语句  查询之后看数据是否和缓存中一致  如果不一致修改缓存中数据
+ clear 清空session中的缓存
+ 区别
  + flush
    + 是让数据库数据和缓存一致
  + refresh   
    + 是让缓存数据和数据库一致
  + clear
    + 清空缓存

### 对象状态

+ 临时状态
  + 刚创建的时候
+ 持久化状态
  + 执行save方法的时候  被session托管了
+ 游离状态
  + 执行delete的时候或者clear的时候
+ hibernate中的缓存中不允许出现ID相同的对象 否则就会报错

### session常用方法

+ save
+ saveOrUpdate
+ delete
+ get
  + 返回的是对象本身
  + 会立即直接发送SQL
+ load
  + 返回的是一个代理对象
  + 可以延时加载 使用到了该对象才会去发送sql语句
+ clear
+ close
+ update
+ evict
  + 将一个对象从session缓存中移除 变为游离状态
+ doWork
  + 可以拿到JDBC中的connection对象 进行批处理操作

### 配置文件

##### 使用连接池

+ 导入hibernate-c3p0的依赖即可  内部依赖了c3p0的jar

### 映射关系

##### 单向多对一

+ 在hibernate中进行关联式全自动的    需要创建真正的外键约束   假设我们式单项的多对一连接查询 那我们在插入的时候建议线插入一方在插入多方 会比先插入多方在插入一方效率高 因为少发了SQL语句  并且在删除的时候删除多方没有问题  但是在删除一方的时候  如果一方还有被多方被引用的地方 那么就会抛出异常 从而删除失败

+ 配置

  + ```xml
    <many-to-one name="属性名" class="关联类全限定包名" fetch="join  链接方式">
        <!-- 会和一方的表中的主键进行关联 -->  
        <column name="TEACHER_ID"/>
    </many-to-one>
    ```

+ ```java
  /**
  * 先添加一方	
  */
  Teacher teacher = new Teacher(null,"李老师");
  /**
  * 添加多方
  */
  Student student1 = new Student(null,"小庄",teacher);
  Student student2 = new Student(null,"小工",teacher);
  
  openSession.save(teacher);
  openSession.save(student1);
  openSession.save(student2);
  
  
  
  /**
   * 动态添加
   */
  Student stu = openSession.get(Student.class,7);
  
  Teacher t = openSession.get(Teacher.class,1);
  
  stu.setTeacher(t);
  ```

+ ```java
  /**
  * 延时加载查询
  */
  
  Student stu = openSession.load(Student.class,1);
  System.out.println(stu);
  ```

+ ```java
  /**
  * 删除  删除多方
  */
  
  Student stu = new Student();
  stu.setSid(1);
  
  openSession.delete(stu);
  ```

+ 修改的话 只要对象在session缓存区中  那么只要修改了对象的属性 那么在事务提交的时候hibernate就会进行修改

##### 双向多对一 一对多

+ 多方配置不变  如上

+ 需要修改一方的配置

+ ```xml
  + 一对多方
  
  <?xml version="1.0"?> 
  <!DOCTYPE hibernate-mapping PUBLIC 
  "-//Hibernate/Hibernate Mapping DTD 3.0//EN" 
  "D:\LINUX\hibernate\hibernate.mapping.dtd">
  <hibernate-mapping  package="com.liwenxiang.model">
      <!-- name:实体类全限定包名  table:对应数据库中生成的表格-->
      <class name="Teacher"  table="T_TEACHERS">
          <!-- name:实体类的属性名称    type:对应的java类型 -->
          <id name="tid" type="java.lang.Integer">
              <!-- 这里就是在数据库中生成的字段 -->
              <column name="TID"/>
              <generator class="native"/>
          </id>
          <property name="name" type="java.lang.String">
              <column name="NAME" />
          </property>
          <!-- 一对多配置set list  map 都类似  -->
          <!-- 属性名     是否一方维护   懒加载   排序  多方表名-->
          <set name="students" inverse="true" lazy="true" order-by="sid desc" table="T_STUDENTS">
              <key>
                  <!-- 多方的外键 -->
                  <column name="TEACHER_ID"></column>
              </key>
              <!-- 多方的全限定包名 -->
              <one-to-many class="Student"/>
          </set>
      </class>
  </hibernate-mapping>
  
  +  多对一方
  
  <?xml version="1.0"?> 
  <!DOCTYPE hibernate-mapping PUBLIC 
  "-//Hibernate/Hibernate Mapping DTD 3.0//EN" 
  "D:\LINUX\hibernate\hibernate.mapping.dtd">
  <hibernate-mapping  package="com.liwenxiang.model">
      	<!-- name:实体类全限定包名  table:对应数据库中生成的表格-->
           <class name="Student"  table="T_STUDENTS">
           		<!-- name:实体类的属性名称    type:对应的java类型 -->
           	   <id name="sid" type="java.lang.Integer">
           	   	    <!-- 这里就是在数据库中生成的字段 -->
           	   	   <column name="SID"/>
           	   	   <generator class="native"/>
           	   </id>
           	   <property name="name"  type="java.lang.String">
           	   	   <column name="NAME" />
           	   </property>
           	   
       			<many-to-one name="teacher" class="Teacher" fetch="join">
       				<column name="TEACHER_ID"/>
       			</many-to-one>
           </class>
  </hibernate-mapping>
  ```

+ ```java
  package com.liwenxiang.model;
  import java.util.HashSet;
  import java.util.Set;
  import org.hibernate.Session;
  import org.hibernate.SessionFactory;
  import org.hibernate.Transaction;
  import org.hibernate.boot.MetadataSources;
  import org.hibernate.cfg.Configuration;
  import org.hibernate.service.ServiceRegistry;
  
  public class OneToManyTest {
      public static void main(String[] args) {
          SessionFactory sessionFactory = null;
          // 默认回去类路径下面查找   hibernate.cfg.xml 文件
          Configuration configuration = new Configuration().configure();
          ServiceRegistry serviceRegistry = configuration.getStandardServiceRegistryBuilder().build();
          sessionFactory = new MetadataSources(serviceRegistry).buildMetadata().buildSessionFactory();
          Session openSession = sessionFactory.openSession();
          // 开启事务
          Transaction transaction = openSession.beginTransaction(); 
          System.out.println("---------------start----------------");
  
          //		Teacher teacher = new Teacher(null,"刘老师");
          //		
          //		Student stu1 = new Student(null,"小王八");
          //		
          //		stu1.setTeacher(teacher);
          //		
          //		Student stu2 = new Student(null,"王八刚");
          //		
          //		stu2.setTeacher(teacher);
  
          /*
  		 * Set<Student> students = new HashSet<>(); students.add(stu1);
  		 * students.add(stu2);
  		 * 
  		 * teacher.setStudents(students);
  		 */
  
  
          /**
  		 * 	建议先添加一方 在添加多方  默认是双方都会去维护关系
  		 */
  
          //		openSession.save(teacher);
          //		openSession.save(stu1);
          //		openSession.save(stu2);
          //		
  
          /*
  		 * Teacher load = openSession.load(Teacher.class,3); System.out.println(load);
  		 * System.out.println(load.getStudents());
  		 */
          
          /* 正常添加学生 的时候的添加方式 */
  
          Student stu = openSession.get(Student.class,7);
  
          Teacher t = openSession.get(Teacher.class,1);
  
          stu.setTeacher(t);
  
          System.out.println("----------------end---------------");
          // 提交事务
          transaction.commit();
          openSession.close();
          sessionFactory.close(); 
      }
  }
  
  ```

##### 一对一

+ 是指一个表中的外键和另一表中的主键进行关联

```xml
<?xml version="1.0"?> 
<!DOCTYPE hibernate-mapping PUBLIC 
"-//Hibernate/Hibernate Mapping DTD 3.0//EN" 
"D:\LINUX\hibernate\hibernate.mapping.dtd">
<hibernate-mapping  package="com.liwenxiang.model">
    <!-- name:实体类全限定包名  table:对应数据库中生成的表格-->
    <class name="Person"  table="T_PERSON">
        <!-- name:实体类的属性名称    type:对应的java类型 -->
        <id name="id" type="java.lang.Integer">
            <!-- 这里就是在数据库中生成的字段 -->
            <column name="ID"/>
            <generator class="native"/>
        </id>
        <property name="name"  type="java.lang.String">
            <column name="NAME" />
        </property>
        <!-- 一对一配置  维护方可以配置多对一 设置唯一值即可 -->
        <many-to-one name="idCard" class="IdCard">
            <column name="ID_CARD_ID" unique="true"/>
        </many-to-one>
    </class>
</hibernate-mapping>
```

```xml
<?xml version="1.0"?> 
<!DOCTYPE hibernate-mapping PUBLIC 
"-//Hibernate/Hibernate Mapping DTD 3.0//EN" 
"D:\LINUX\hibernate\hibernate.mapping.dtd">
<hibernate-mapping  package="com.liwenxiang.model">
    <!-- name:实体类全限定包名  table:对应数据库中生成的表格-->
    <class name="IdCard"  table="T_ID_CARD">
        <!-- name:实体类的属性名称    type:对应的java类型 -->
        <id name="id" type="java.lang.Integer">
            <!-- 这里就是在数据库中生成的字段 -->
            <column name="ID"/>
            <generator class="native"/>
        </id>
        <property name="cardNo"  type="java.lang.String">
            <column name="CARD_NO" />
        </property>
        <!-- 关联的属性名   类的全限定名    Person类中相互关联的引用属性名称 -->
        <one-to-one name="person" class="Person" property-ref="idCard"/>
    </class>
</hibernate-mapping>
```

```java
package com.liwenxiang.model;

import org.hibernate.Session;
import org.hibernate.SessionFactory;
import org.hibernate.Transaction;
import org.hibernate.boot.MetadataSources;
import org.hibernate.cfg.Configuration;
import org.hibernate.service.ServiceRegistry;

public class OneToOne {
    public static void main(String[] args) {
        SessionFactory sessionFactory = null;
        // 默认回去类路径下面查找   hibernate.cfg.xml 文件
        Configuration configuration = new Configuration().configure();
        ServiceRegistry serviceRegistry = configuration.getStandardServiceRegistryBuilder().build();
        sessionFactory = new MetadataSources(serviceRegistry).buildMetadata().buildSessionFactory();
        Session openSession = sessionFactory.openSession();
        // 开启事务
        Transaction transaction = openSession.beginTransaction(); 
        System.out.println("---------------start----------------");

        /*
		 * Person p = new Person(); p.setName("李文祥");
		 * 
		 * IdCard card = new IdCard(); card.setCardNo("410329200008179597");
		 * 
		 * p.setIdCard(card); card.setPerson(p);
		 * 
		 * openSession.save(card); openSession.save(p);
		 */

        Person p = openSession.get(Person.class,1);
        System.out.println(p);
        System.out.println(p.getIdCard());

        IdCard card = openSession.load(IdCard.class,1);
        System.out.println(card);
        System.out.println(card.getPerson());


        System.out.println("----------------end---------------");
        // 提交事务
        transaction.commit();
        openSession.close();
        sessionFactory.close(); 
    }
}

```

##### 多对多

```xml
<?xml version="1.0"?> 
<!DOCTYPE hibernate-mapping PUBLIC 
"-//Hibernate/Hibernate Mapping DTD 3.0//EN" 
"D:\LINUX\hibernate\hibernate.mapping.dtd">
<hibernate-mapping  package="com.liwenxiang.model">
    <!-- name:实体类全限定包名  table:对应数据库中生成的表格-->
    <class name="Teacher"  table="T_TEACHERS">
        <!-- name:实体类的属性名称    type:对应的java类型 -->
        <id name="tid" type="java.lang.Integer">
            <!-- 这里就是在数据库中生成的字段 -->
            <column name="TID"/>
            <generator class="native"/>
        </id>
        <property name="name" type="java.lang.String">
            <column name="NAME" />
        </property>
        <!-- 一对多配置set list map 都类似  -->
        <set name="students"  inverse="true" lazy="true" order-by="sid desc" table="T_STUDENTS">
            <key>
                <column name="TEACHER_ID"></column>
            </key>
            <one-to-many class="Student"/>
        </set>
        <set name="carous" inverse="true" table="t_teacher_carous">
            <key column="teacher_id"/>
            <many-to-many class="Carous" column="carous_id"></many-to-many> 	
        </set>
    </class>
</hibernate-mapping>
```

```xml
<?xml version="1.0"?> 
<!DOCTYPE hibernate-mapping PUBLIC 
"-//Hibernate/Hibernate Mapping DTD 3.0//EN" 
"D:\LINUX\hibernate\hibernate.mapping.dtd">
<hibernate-mapping  package="com.liwenxiang.model">
    <!-- name:实体类全限定包名  table:对应数据库中生成的表格-->
    <class name="Carous"  table="T_CAROUS">
        <!-- name:实体类的属性名称    type:对应的java类型 -->
        <id name="id" type="java.lang.Integer">
            <!-- 这里就是在数据库中生成的字段 -->
            <column name="id"/>
            <generator class="native"/>
        </id>
        <property name="name" type="java.lang.String">
            <column name="NAME" />
        </property>
        <!-- table - 中间表   column 是关联的字段-->
        <set name="teachers" table="t_teacher_carous">
            <key column="carous_id"/>
            <many-to-many class="Teacher" column="teacher_id"></many-to-many> 	
        </set>
    </class>
</hibernate-mapping>
```

```java
package com.liwenxiang.model;

import java.util.HashSet;
import java.util.Set;

import org.hibernate.Session;
import org.hibernate.SessionFactory;
import org.hibernate.Transaction;
import org.hibernate.boot.MetadataSources;
import org.hibernate.cfg.Configuration;
import org.hibernate.service.ServiceRegistry;

public class ManyToMany {
public static void main(String[] args) {
SessionFactory sessionFactory = null;
// 默认回去类路径下面查找   hibernate.cfg.xml 文件
Configuration configuration = new Configuration().configure();
ServiceRegistry serviceRegistry = configuration.getStandardServiceRegistryBuilder().build();
sessionFactory = new MetadataSources(serviceRegistry).buildMetadata().buildSessionFactory();
Session openSession = sessionFactory.openSession();
// 开启事务
Transaction transaction = openSession.beginTransaction(); 
System.out.println("---------------start----------------");
    /** 
		添加数据
    */
    Carous car = new Carous();
    car.setName("Hibernate");
    Carous car1 = new Carous();
    car1.setName("JavaWeb");

    Teacher t = new Teacher();
    t.setName("李文祥");
    Teacher t1 = new Teacher();
    t1.setName("战三凤");

	Set<Carous> carous = new HashSet<>();
    carous.add(car);
    carous.add(car1);
    t.setCarous(carous);
    t1.setCarous(carous);

    Set<Teacher> teachers = new HashSet<>();
    teachers.add(t);
    teachers.add(t1);
    car.setTeachers(teachers);
    car1.setTeachers(teachers);

    openSession.save(car);
    openSession.save(car1);
    openSession.save(t);
    openSession.save(t1);

    
    Teacher t = openSession.load(Teacher.class,6);
    System.out.println(t);
    System.out.println(t.getStudents());
    System.out.println(t.getCarous());
    
    
    System.out.println("----------------end---------------");
    // 提交事务
    transaction.commit();
    openSession.close();
    sessionFactory.close(); 	
    }
    }

```

##### 组件映射

+ 就是一个实体类的字段实际上没有和数据库中的某一个表进行映射

+ 作为某一个实体类的组件类 包括了某一个类的实际需要的次要参数

+ Product类  

  + 内部需要有一个属性是ProductInfo类型的 进行映射

+ ProductInfo类   和数据库没有直接对应的表  仅仅只是包含了Product类的一些信息数据

+ 映射文件

+ ```xml
  <?xml version="1.0"?> 
  <!DOCTYPE hibernate-mapping PUBLIC 
  "-//Hibernate/Hibernate Mapping DTD 3.0//EN" 
  "D:\LINUX\hibernate\hibernate.mapping.dtd">
  <hibernate-mapping  package="com.liwenxiang.model">
      	<!-- name:实体类全限定包名  table:对应数据库中生成的表格-->
           <class name="Product"  table="T_PRODUCT">
           		<!-- name:实体类的属性名称    type:对应的java类型 -->
           	   <id name="id" type="java.lang.Integer">
           	   	    <!-- 这里就是在数据库中生成的字段 -->
           	   	   <column name="id"/>
           	   	   <generator class="native"/>
           	   </id>
           	   <property name="name" type="java.lang.String">
           	   	   <column name="NAME" />
           	   </property>
           	   <property name="price" type="java.lang.String">
           	   	   <column name="price"/>
           	   </property>
           	   
           	   <component name="productInfo" class="ProductInfo">
           	   	 <property name="type" type="string" column="type"></property>
           	   </component>
           </class>
  </hibernate-mapping>
  ```

  ##### 继承映射

  + 略过

### 检索策略

##### 立即检索策略

##### 延时检索策略

##### 左外连接检索策略

+ batch-size  规定检索的

### 检索方式

##### 对象导航图

+ 根据对象之间的关系

##### OID

+ 根据ID进行查询

#####QBC

+ API Hibernate提供的完全基于面向对象的一种操作数据库的一种方式

##### HQL 重点

+ 类似SQL 但是又有所简化

##### 本地SQL

+ JDBC sql 语句

### HQL

