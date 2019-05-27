## Mybatis-plus 笔记

### 概念

+ 是一个mybatis的增强工具
+ 无侵入 可以正常使用mybatis原生的内容
+ 代码生成器
+ 分页插件
+ CURD 
+ ......

### 依赖项

+ mybatis
+ mybatis-spring

### Maven 依赖

```xml
<dependency>
    <groupId>com.baomidou</groupId>
    <artifactId>mybatis-plus</artifactId>
    <version>2.3</version>
</dependency>
<dependency>
    <groupId>junit</groupId>
    <artifactId>junit</artifactId>
    <version>4.12</version>
</dependency>
<dependency>
    <groupId>log4j</groupId>
    <artifactId>log4j</artifactId>
    <version>1.2.17</version>
</dependency>
<dependency>
    <groupId>mysql</groupId>
    <artifactId>mysql-connector-java</artifactId>
    <version>5.1.47</version>
</dependency>
<dependency>
    <groupId>org.springframework</groupId>
    <artifactId>spring-context</artifactId>
    <version>4.3.7.RELEASE</version>
</dependency>
<dependency>
    <groupId>org.springframework</groupId>
    <artifactId>spring-orm</artifactId>
    <version>4.3.10.RELEASE</version>
</dependency>
<dependency>
    <groupId>org.apache.velocity</groupId>
    <artifactId>velocity-engine-core</artifactId>
    <version>2.0</version>
</dependency>
<dependency>
    <groupId>org.slf4j</groupId>
    <artifactId>slf4j-api</artifactId>
    <version>1.7.7</version>  
</dependency>
<dependency>
    <groupId>org.slf4j</groupId>
    <artifactId>slf4j-log4j12</artifactId>
    <version>1.7.7</version>
</dependency>
```

### 集成Spring

+ 只需要将以前的SqlSessionFactoryBean替换为MybatisSqlSessionFactoryBean即可
+ 因为MybatisSqlSessionFactoryBean是我们mybatis-plus提供的

```xml
之前
<bean id="sqlSessionFactory" class="org.mybatis.spring.SqlSessionFactoryBean">
    <property name="dataSource" ref="dataSource"/>
    <property name="configLocation" value="classpath:mybatis-config.xml"/>
    <property name="typeAliasesPackage" value="top.liwenxiang.pojo"/>
</bean>
之后
<bean id="sqlSessionFactory" class="com.baomidou.mybatisplus.spring.MybatisSqlSessionFactoryBean">
    <property name="dataSource" ref="dataSource"/>
    <property name="configLocation" value="classpath:mybatis-config.xml"/>
    <property name="typeAliasesPackage" value="top.liwenxiang.pojo"/>
    <!-- 注入GlobalConfiguration -->
    <property name="globalConfig" ref="configuration"/>
</bean>
```

```xml
<!-- 配置mybatis-plus全局策略  需要在 MybatisSqlSessionFactoryBean 中注入 -->
<bean id="configuration" class="com.baomidou.mybatisplus.entity.GlobalConfiguration">
     <property name="dbColumnUnderline" value="true"/>  // 自动将数据库的下划线和实体中驼峰对应好 默认true
     <property name="tablePrefix" value="mp_"/>  // 全局配置表前缀
</bean>
```

### 注解

+ TableName(value="",resultMap="")  可以指定表名 和结果映射 默认会根据实体类名称去数据库中查找
+ TableId(type=IdType.AUTO,value="uid")  可以指定和数据库中的id字段以及ID自增
+ TableFiled(value="",exist=false)  可以指定字段在数据表中名称 和这个字段是否在数据表中存在

### CURD METHDO BASEMAPPER 

+ inser    会判断属性是否为NULL如果是NULL的话就不会进行增加了sql语句会发生变化，
+ insertAllColumn   会将所有字段都拼接sql语句进行添加 不会判断是否为null
+ updateById   根据id查询会保留原本的数据如果为NULL的话
+ updateAllCloumn 修改所有
+ selectOne  传入一个实体类进行查询 会将部位NULL的字段党当做条件
+ selectById  根据id进行查询
+ selectBatchIds  根据多个id进行查询
+ selectByMap 传入一个Map作为条件  key 是字段名 value是值
+ selectPage  分页查询 传入一个Page<>类 第二个参数是条件构造器不需要的话传递NULL 内存分页性能不好
+ deleteById  根据ID删除
+ deleteBatchIds  根据多个id进行删除
+ deleteByMap   传入一个Map作为条件  key 是字段名 value是值

### EntityWapper

+ 使用EntityWapper类

+ 例如

  ```java
  List<helloWorld> age = hello.selectPage(new Page<helloWorld>(1, 2),
                                          new EntityWrapper<helloWorld>()
                                          .gt("age", 18)
                                         );
  ```

+ 常用方法

  + or   在sql中添加一个or
  + orNew   在sql中添加一个or 另起一个()  
  + between
  + gt
  + lt
  + ge
  + le
  + eq
  + like
  + last
  + orderBy
  + orderByDesc
  + orderByAsc
  + in
  + groupBy

### AR (活动记录)

+ 另一种形式的数据库操作
+ 以实体类本身进行数据的增删改查
+ 继承Model类泛型填写操作的实体
+ 需要重写一个pkVal方法 设置受保护的权限 返回主键this.id主键属性
+ 需要Mapper并且还是需要继承BaseMapper<>类
+ 需要引入配置文件
+ CURD 方法 和BaseMapper的差不多 直接实体类点就可以看了
+ 也可以使用EnyityWapper 条件构造器
+ selectPage返回的使Page对象

### 代码生成器

+ MBG mybatis 的代买生成器  可以生成接口 映射文件 实体类
+ MP 的 代买生成器  可以生成接口 映射文件  实体类(是否AR模式) service Controll
+ 在我们生成的service接口中已经帮助我们注入了Mapper 继承了ServiceImpl 并且提供了一下增删改查的方法

**代码生成器依赖**

```xml
<dependency>
    <groupId>org.apache.velocity</groupId>
    <artifactId>velocity-engine-core</artifactId>
    <version>2.0</version>
</dependency>
<dependency>
    <groupId>org.slf4j</groupId>
    <artifactId>slf4j-api</artifactId>
    <version>1.7.7</version>  
</dependency>
<dependency>
    <groupId>org.slf4j</groupId>
    <artifactId>slf4j-log4j12</artifactId>
    <version>1.7.7</version>
</dependency>
```

**生成的步骤**

+ 配置全局配置
+ 配置数据源
+ 配置主键策略
+ 配置包策略
+ 整合配置

   ```java
   GlobalConfig config = new GlobalConfig();
   config.setAuthor("liwenxiang")
    .setActiveRecord(true)
    .setOutputDir("D:\\SSM\\mp03\\src\\main\\java")
    .setFileOverride(true)
    .setIdType(IdType.AUTO)
    //.setServiceName() 设置生成的servuce接口的名字首字母是否为I
    .setBaseResultMap(true)
    .setBaseColumnList(true);
   
   DataSourceConfig dc = new DataSourceConfig();
   dc.setDbType(DbType.MYSQL)
       .setDriverName("com.mysql.jdbc.Driver")
       .setUrl("jdbc:mysql://localhost:3306/mp?useUnicode=true&characterEncoding=utf-8")
       .setUsername("root")
       .setPassword("root");
   
   StrategyConfig ac = new StrategyConfig();
   ac.setCapitalMode(true)  //全局大写命名
       .setDbColumnUnderline(true)
       .setNaming(NamingStrategy.underline_to_camel)
       .setTablePrefix("mp_")
       .setInclude("mp_helloworld"); //生成的表
   
   PackageConfig pc = new PackageConfig();
   pc.setParent("top.liwenxiang")
       .setEntity("pojo")
       .setMapper("dao")
       .setXml("dao")
       .setService("service")
       .setController("controller");
   
   AutoGenerator ag = new AutoGenerator();
   ag.setGlobalConfig(config)
       .setDataSource(dc)
       .setPackageInfo(pc)
       .setStrategy(ac);
   
   ag.execute();
   
   ```


### 扩展插件

#### 分页插件

+ 可以在mybatis-config中的plugins进行配置 interceptor属性值为插件全限定名
+ 也可以在MybatisSqlSessionFactoryBean中配置注入属性plugins是一个数组可以使用list也可以使用便捷的方法直接,
+ 使用还是使用selectPage<>()只不过现在已经变成了物理分页
+ 这个时候page

```java
ApplicationContext ac = new ClassPathXmlApplicationContext("classpath:spring.xml");
IUserMapper usermapper = ac.getBean("IUserMapper",IUserMapper.class);
Page<user> p = new Page<user>(1,2);
List<user> user = usermapper.selectPage(p,null);
System.out.println(user);
System.out.println(p);
System.out.println(p.hasNext());
```

```xml
//分页插件
<plugins>
    <plugin interceptor="com.baomidou.mybatisplus.plugins.PaginationInterceptor"/>
</plugins>
```

#### 性能分析插件

#### 乐观锁插件

#### 自动注入全局

#### 逻辑删除 假删除

### Mybatis-plus  大坑

+ 如果注解了表名 属性名一定不要和表名有重复内容部分否则就报错 有可能会报错 具体问题不太清楚
+ 还有和其他实体类也都不要重复否则就报错
+ 反正报错就是实体类的属性问题