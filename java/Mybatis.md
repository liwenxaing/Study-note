# Mybatis
  1. Mybatis 概述
     Mybatis 是apache的一个开源项目iBatis 后来迁移到了谷歌改名为Mybatis 2013 年迁移到Github
     ORM  Object Relationship Mapping 
  2. 应用场景
     Mybatis 一般应用于三层架构的dao层 是一个 **ORM(对象关系映射)** 框架 **持久层**的框架 内部封装了JDBC 使开发者只需关注sql语句本身
     Mybatis 通过**xml**和**注解(Annotation)**两种方式将各种Statement配置起来 并通过**java对象**和**Statement中的sql的动态参数**进行映射
     生成最终的sql语句 最后Mybatis框架执行sql语句并将结果映射成**java对象**返回
  3. 下载地址
      https://github.com/mybatis
  4. Mybatis 和 hibernate 的区别
     4. 1. Hibernate 框架实现了全自动的**ORM(对象关系映射)** 实现了 **POJO** 和数据库 **表** 之间的映射,以及sql语句的生成和自动执行
     4. 2. Mybatis 不会为程序员自动生成sql语句 具体的sql语句需要程序员自己手动编写 然后通过sql映射文件 将所需要的参数以及结果字段映射到
           POJO 中;
     4. 3. 于Hibernate 相比 Mybatis 有以下的显著优点
            4. 3. 1. 在 xml 文件中配置sql语句 实现了SQL语句于代码的实际分离 给程序的维护带来了很大的便利
            4. 3. 2. 因为需要程序员 自己手动的去编写sql语句 程序员可以灵活的控制sql语句 因此能够实现比Hibernate等全自动ORM框架更高的查询
                     效率 能够完成更复杂的查询  
            4. 3. 3. 易于学习 上手快 
  5. Mybatis 架构
     接口层                 数据查询接口  数据插入接口  数据更新接口  数据删除接口  数据配置接口   ↑   
     数据处理曾               参数映射      sql解析      sql执行     结果映射                   ↑
     基础支撑层               链接管理      事务管理      配置加载    缓存管理                    ↑
                                                配置完成                                      ↑
  6. 配置文件
     6. 1. 配置文件有两个
           6. 1. 1. Mybatis.xml  主配置文件 (名称随意)
           6. 1. 2. Mapper.xml   映射文件 (名称随意)   **需要在主配置文件进行注册**
                    需要与Mybatis中的mapper.dtd文件进行约束   根标签是 <mapper></mapper>
                    相对的 dtd 文件在 org.apache.ibatis.builder.xml.mybatis-3-config.tdt
           6. 1. 3. *映射配置文件放置在dao层   主配置文件放在类路径下 就是src下*
                    相对的 dtd 文件在 org.apache.ibatis.builder.xml.mybatis-3-mapper.dtd
           6. 1. 4. 在Mybatis主配置文件中需要配置进行映射文件注册
                    <mappers>
                         <mapper  resource="包名+文件名">
                         </mapper>
                    </mappers>
           6. 1. 5. 在映射文件中书写sql语句的时候 如果是插入的话需要在insert上加入parameterType=你的类型所在的包名+类名         
           6. 1. 5. 在映射文件中书写sql语句的时候 如果是查询的话需要在select上加入resultType=你的类型所在的包名+类名         
  7. 映射文件注意事项
     7. 1. mapper文件中的namespace属性不能够冲突 当注册多个mapper的时候 可以另起一个namespace 
           在使用的时候 要使用全名 命名空间加上你的sql映射id名
  8. 输入流不用关闭  自动提交事务  回滚 问题
     8. 1. 在我们获取 SqlSessionFactoryBuilder 类的时候 在他的构造里面传入一个输入流 Mybatis 在内部调用重载的build方法 已经将其
           关闭了 所以不需要我们手动关闭
           创建SqlSession对象 实际是对各个属性进行了初始化
           而我们的增删改 其实执行的都是修改的方法  update
           commit方法 实际上吧事务也提交了
           SqlSession关闭之后就不用执行回滚了 如果我们没有提交 那么 在执行的时候会执行回滚 我们写入的SQL就起不到作用了
  9. Mysql 获取到刚插入后的ID
     **只能跟在insert语句之后**
        9. 1.  select @@identity
        9. 2.  select last_insert_id  
  10. 在插入之后可以继续执行查询的sql语句 将结果映射到 类中的某一个字段
     ```
        <insert id="insertStudentCacheId" parameterType="Student">
                  INSERT INTO student (name,age,score) VALUES (#{name},#{age},#{score})
                 <selectKey resultType="int" keyProperty="id" order="AFTER">
                     select @@identity
                 </selectKey>
        </insert>
     ```
  11. 使用查询返回Map的时候 需要指定一个查询的表的实体类的属性名称即可
      map = ss.selectMap("selectAllStudentsMap","name")
      这样Map的key就是name了
  12. 数据库字段名称和实体类属性名称不一致问题
      12. 1. 一般来说 只会对 查询有影响 因为需要返回数据 而底层又是通过反射设置值的 增删改 一般不会有所影响 因为传过来的参数
             属性写的都是正确的属性名
      12. 2. 解决办法
             12. 2. 1. 使用别名  后面的就是别名 是和实体类一直的名称
                        SELECT tid id,tname name,tage age,tscore score FROM student       
             12. 2. 2. 使用 resultMap
         
      12. 3. 为什么会产生名称不一致问题？
             如果只是我们自己写的话 肯定要写成一样的
             但是需要考虑的是如果以后在大公司干活那么分工是非常细的 也许实体类是专门一个人写的 数据库是专门一个人写的
             那么可能这两个人写的字段和属性就不能一一对应起来 而他们将文件给你的时候需要你去完成代码的编写 这时候你就
             需要使用这两种方式去编写程序了  否则是会出错的    
  13. Mapper 动态代理
      13. 1. 删掉实现类
      13. 2. dao层的方法名必须和Mapper的id一样
      13. 3. 在测试类获取到SqlSession对象 调用 getMapper 方法 里面参数为该Mapper的映射接口的class对象 
      13. 4. 设置Mapper的命名空间为改mapper映射的Dao的包名+类名
      13. 5. 就可以使用了  方法名一定要和Mapper里面的id一致
  14. 多个条件参数的处理方法  
      14. 1. 使用Map封装为一个
             14. 1. 1. 在Mapper映射文件中的SQL语句可以填写#{Map的key || Map的key对象.属性}
             14. 1. 2. 多个参数通过下标获取 例如  #{0}  #{1} 
  15. 动态SQL 
      15. 1. 动态拼接SQL
             15. 1. 1. <if test=" condition "></if>
             15. 1. 2. <where>  <if test=" condition "></if>  </where>  当数据量大时 查询数据加上1=1会大大降低性能 所有产生了where解决这个问题
             15. 1. 3. <where>  <choose> <when test="name != null and name != '' "> and name = #{name}  </when> </choose> <otherwise> 1 = 2 </otherwise>  </where>
             15. 1. 4.  一般使用in配合这个遍历
               **遍历数组 array 是别名**
               <if test="array.length > 0">
                <foreach collection="array"  item="item" open="("  close=")"  separator=","> 
                    #{item}
                </foreach>
               </if>
               **遍历List集合 内置类型  list 是别名**
              <if test="list.size > 0">
               <foreach collection="list"  item="item" open="("  close=")"  separator=","> 
                 #{item}
               </foreach>
              </if> 
               **遍历List集合 自定义类型  list 是别名**
              <if test="list.size > 0">
                <foreach collection="list"  item="stu" open="("  close=")"  separator=","> 
                   #\{stu.id\}
                </foreach>
              </if>   
             15. 1. 5. SQL 片段    <sql id="selectCloumns">  select * from </sql>  引入 <include refid="selectCloumns" />
  16. 关联查询
      16. 1. 一对多
      16. 2. 多对一
      16. 3. 自关联
      16. 4. 多对多
      16. 5. 持有外键的表就是多的一方 一般来说一对多查询的时候一方可以生命集合进行存储多方的实体对象
             多对一刚好就是反过来 在多表建立一表实体的类型属性 进行储存
             自关联  使用递归的方式进行查询并返回实体数据 可以设置集合泛型为自身
             多对多  三张表 中间表持有左右两表外键 故为多表  以  学生表 - 选课表（studentId,courseId） - 课程表
  17. 延迟加载
      17. 1. 是对关联表的延迟加载 主表在Mybatis中会直接加载  在 Hibernate 中 主表也可以延迟加载
      17. 2. 延迟加载时机       
             17. 2. 1. 直接加载
                       17. 2. 1. 1. 加载完主加载对象的sql语句 直接加载关联对象的sql语句 
             17. 2. 2. 侵入式加载 (aggressiveLazyLoading)  默认true 
                       17. 2. 2. 1. 默认是开启的  将关联对象的详情侵入到主加载对象里 当加载主加载对象的时候
                                    就会去加载关联对象 
             17. 2. 3. 深度延迟 (lazyLoadingEnabled)  默认false
                       17. 2. 3. 1. 当加载玩主加载对象的时候 如果没有访问到关联对象的属性或者方法的话是不会
                                    去加载关联对象的  一但访问了关联对象的属性或者方法的话 那么就会执行关联对象
                                    的sql语句     
                       使用主配置文件的 settings > setting.name=lazyLoadingEnabled.value=true 来配置             
             **延迟加载的要求 必须是关联对象的查询与主对象的查询是分开的sql查询 不能够是多表sql的查询**
  18. 查询缓存 底层是一个Map对象  增加了查询数据的速度 返回数据更快
      18. 1. 一级缓存
             18. 1. 1. 一级缓存默认是开启的 已经存在的
             18. 1. 2. 形成条件   sqlId + sql语句 相同才会读取缓存
             18. 1. 3. 作用域   是根据namespace划分的 
             18. 1. 4. 生命周期  是单线程的 即当前SqlSession关闭之后 这个缓存就清空了
             18. 1. 5. 当执行增删改操作的时候 会清空缓存池内的内容            
      18. 2. 二级缓存  一般不使用  要求太高
             18. 2. 1. 开启二级缓存  在主配置文件加上 cache 标签
             18. 2. 2. 当执行增删改操作的时候 会清空缓存池内的内容          
             18. 2. 3. 对于二级缓存的清空 其实就是将所查找的key对应的value 设置null 而并非将key value 即entry对象删除         
             18. 2. 4. 从数据库中进行select查询的条件是 
                       1) 缓存中就不存在这个key         
                       2) 缓存中存在改key所对应的entry对象  但是 其value为null         
                       3) 二级缓存的配置 cache标签
                          1) eviction="FIFO | LRU"  FIFO 先进先出  LRU 未使用时间最长的（默认）    逐出策略
                          2) flushInterval="180000000"  刷新缓存的时间  一般不指定  执行增删改的自动清空即可
                          3) readOnly="true"  是否对象只是可读的  默认false
                          4) size="521"   即缓存空间中可以存储多少个对象  默认1024个
             18. 2. 5. 生命周期  是多线程的 可以在多个sqlSession之间共享数据
             18. 2. 6. 实体需要进行序列化
             18. 2. 7. 二级缓存的关闭
                       1) 全局关闭
                           <settings><setting name="cacheEnabled" value="true"></setting></settings>
                       2) 局部关闭
                           在select查询语句上加上  useCache="false" 即可     
             18. 2. 8. 二级缓存的使用原则
                       1) 多个namespace不要操作同一张表
                       2) 不要在关联表中执行增删改操作
                       3) 查询多于修改的时候可以使用二级缓存
  19. 注解式开发
      19. 1. 将注解放置到dao方法的上面即可 增删改查
             @Select
             @Insert
             @Update
             @Delete
             @SelectKey  

### 采用批量执行器

```xml
<bean id="sqlSessionTemplateBatch" class="org.mybatis.spring.SqlSessionTemplate">     
	<constructor-arg index="0" ref="sqlSessionFactory" />  
	<!--更新采用批量的executor -->  
	<constructor-arg index="1" value="BATCH"/>  
</bean>

```

### 逆向工程

```java
public class GeneratorTest {
    public static void main(String[] args) throws Exception {
        List<String> warnings = new ArrayList<String>();
        boolean overwrite = true;
        //指向逆向工程配置文件
        File configFile = new File(GeneratorTest.class.getResource("/mbg.xml").getFile());
        ConfigurationParser cp = new ConfigurationParser(warnings);
        Configuration config = cp.parseConfiguration(configFile);
        DefaultShellCallback callback = new DefaultShellCallback(overwrite);
        MyBatisGenerator myBatisGenerator = new MyBatisGenerator(config,
                callback, warnings);
        myBatisGenerator.generate(null);
    }
}
```

```xml
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE generatorConfiguration
        PUBLIC "-//mybatis.org//DTD MyBatis Generator Configuration 1.0//EN"
        "http://mybatis.org/dtd/mybatis-generator-config_1_0.dtd">

<generatorConfiguration>
    <context id="testTables" targetRuntime="MyBatis3">
        <commentGenerator>
            <!-- 是否去除自动生成的注释 true：是 ： false:否 -->
            <property name="suppressAllComments" value="true" />
        </commentGenerator>
        <!--数据库连接的信息：驱动类、连接地址、用户名、密码 -->
        <jdbcConnection driverClass="com.mysql.jdbc.Driver"
                        connectionURL="jdbc:mysql://localhost:3306/dpm_curd" userId="root"
                        password="root">
        </jdbcConnection>

        <!-- 默认false，把JDBC DECIMAL 和 NUMERIC 类型解析为 Integer，为 true时把JDBC DECIMAL和NUMERIC类型解析为java.math.BigDecimal -->
        <javaTypeResolver>
            <property name="forceBigDecimals" value="false" />
        </javaTypeResolver>

        <!-- targetProject:生成PO类的位置，重要！！ -->
        <javaModelGenerator targetPackage="com.yuntu.dmp.beans"
                            targetProject=".\src\main\java">
            <!-- enableSubPackages:是否让schema作为包的后缀 -->
            <property name="enableSubPackages" value="false" />
            <!-- 从数据库返回的值被清理前后的空格 -->
            <property name="trimStrings" value="true" />
        </javaModelGenerator>
        <!-- targetProject:mapper映射文件生成的位置，重要！！ -->
        <sqlMapGenerator targetPackage="mapper"
                         targetProject=".\src\main\resources">
            <property name="enableSubPackages" value="false" />
        </sqlMapGenerator>
        <!-- targetPackage：mapper接口生成的位置，重要！！ -->
        <javaClientGenerator type="XMLMAPPER"
                             targetPackage="com.yuntu.dmp.dao"
                             targetProject=".\src\main\java">
            <property name="enableSubPackages" value="false" />
        </javaClientGenerator>
        <!-- 指定数据库表，要生成哪些表，就写哪些表，要和数据库中对应，不能写错！ -->
        <table tableName="applicant" domainObjectName="Applicant"/>
        <table tableName="projectinfo" domainObjectName="ProjectInfo"/>

    </context>
</generatorConfiguration>
```
## 3、Mybatis中javaType和jdbcType对应关系

```
   JDBCType            JavaType
    CHAR                String
    VARCHAR             String
    LONGVARCHAR         String
    NUMERIC             java.math.BigDecimal
    DECIMAL             java.math.BigDecimal
    BIT                 boolean
    BOOLEAN             boolean
    TINYINT             byte
    SMALLINT            short
    INTEGER             int
    BIGINT              long
    REAL                float
    FLOAT               double
    DOUBLE              double
    BINARY              byte[]
    VARBINARY           byte[]
    LONGVARBINARY               byte[]
    DATE                java.sql.Date
    TIME                java.sql.Time
    TIMESTAMP           java.sql.Timestamp
    CLOB                Clob
    BLOB                Blob
    ARRAY               Array
    DISTINCT            mapping of underlying type
    STRUCT              Struct
    REF                 Ref
    DATALINK            java.net.URL[color=red][/color]
```