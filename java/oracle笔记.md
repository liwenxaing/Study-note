# 0. Oracle笔记

##目录

###Oracle简介

+ Oracle基础概念（实例、表空间、用户、表之间关系）
+ 数据库
+ 实例
+ 用户
+ 表空间
+ 数据文件（dbf、ora）
+ Oracle关系图
+ SQLPlus常用语句
+ Oracle数据类型
+ Oracle创建用户、角色、授权、建表
+ **用户权限**
+ 创建新用户
+ 删除用户
+ 授权角色
+ 创建/授权/删除角色

####Oracle约束

+ 添加约束语法：
+ 主键约束（ Primary key, 简称 PK）
+ 非空约束( not null , 简称 NN )
+ 唯一约束( Unique , 简称 UK )
+ 检查约束( Check , 简称 CK )
+ 外键约束( Foreign key, 简称 FK )
+ 默认约束( Default Key,简称 DF )

####**Oracle注释**

+ 添加表级注释
+ 添加列级注释
+ 查看表级注释
+ 查看列级注释
+ 删除注释（即，添加空注释）

**Oracle序列**

+ 创建序列
+ 使用序列
+ 查看序列

###第一章、Oracle基础

####Oracle简介

+ Oracle数据库是Oracle（甲骨文）公司的核心产品，适合
+ 于大型项目的开发；银行、电信、电商、金融等各领域都大
+ 量使用Oracle数据库。
+ Oracle数据库是一种对象关系型数据库，在关系型数据库
+ 的基础上，引入了一些面向对象的特性。
+ Oracle基础概念（实例、表空间、用户、表之间关系）
+ 数据库
+ 数据库是数据集合。Oracle是一种数据库管理系统，是一种关系型的数
+ 据库管理系统。
+ 实例
+ 一个Oracle实例（Oracle Instance）有一系列的后台进程和内存结构
+ 组成。一个数据库可以有n个实例。
+ 用户
+ 用户是在实例下建立的。不同实例可以建相同名字的用户。
+ Oracle数据库建好后，要想在数据库里建表，必须先为数据库建立用

+ 户，并为用户指定表空间。

####表空间

```
表空间是一个用来管理数据存储逻辑概念，表空间只是和数据文件

（ORA或者DBF文件）发生关系，数据文件是物理的，一个表空间可以包含

多个数据文件，而一个数据文件只能隶属一个表空间。

数据文件（dbf、ora）

数据文件是数据库的物理存储单位。数据库的数据是存储在表空间中

的，真正是在某一个或者多个数据文件中。而一个表空间可以由一个或多个

数据文件组成，一个数据文件只能属于一个表空间。一旦数据文件被加入到

某个表空间后，就不能删除这个文件，如果要删除某个数据文件，只能删除

其所属于的表空间才行。

理解：表的数据，是有用户放入某一个表空间的，而这个表空间会随机把这些表数据

放到一个或者多个数据文件中。

由于oracle的数据库不是普通的概念，oracle是由用户和表空间对数据进行管理和存放

的。但是表不是由表空间去查询的，而是由用户去查的。因为不同用户可以在同一个

表空间建立同一个名字的表！这里区分就是用户了！

Oracle关系图

Oracle数据库可以创建多个实例，每个实例可以创建多个表空间，每个

表空间下可以创建多个用户和数据库文件，用户可以创建多个表。

解释：一个表空间（数据库）包含一个或多个数据文件，数据文件通常为*.dbf格式，

一个数据库的数据文件包含全部数据库数据（如表、索引等）。

一个用户可以使用一个或多个表空间，一个表空间也可以供多个用户使用。用户和表

空间没有隶属关系，表空间是一个用来管理数据存储的逻辑概念，表空间只是和数据

文件发生关系，数据文件是物理的，一个表空间可以包含多个数据文件，而一个数据

文件只能隶属一个表空间。

总结：解释数据库、表空间、数据文件、表、数据的最好办法就是想象一个装满东西

的柜子。数据库其实就是柜子，柜中的抽屉是表空间，抽屉中的文件夹是数据文件，

文件夹中的纸是表，写在纸上的信息就是数据。

```

####**SQLPlus常用语句**

  ##### 显示当前用户名

 **SQL>show user**;

  ##### 查看当前用户的角色

 **SQL>select * from user_role_privs**;

 ##### 查看当前用户的系统权限和表级权限

**SQL>select * from user_sys_privs**;
 **SQL>select * from user_tab_privs**;

  ##### 查看用户所有表

**SQL>select * from all_tab_comments ‐‐ 查询所有用户的表,视图等**。
 **SQL>select * from user_tab_comments ‐‐ 查询本用户的表,视图等**。
 **SQL>select * from all_col_comments  ‐‐查询所有用户的表的列名和注释**。
 **SQL>select * from user_col_comments ‐‐ 查询本用户的表的列名和注释**。
 **SQL>select * from all_tab_columns ‐‐查询所有用户的表的列名等信息**。
 **SQL>select * from user_tab_columns ‐‐查询本用户的表的列名等信息**。

#####关闭数据库

 **SQL>shutdown immediate**;

  ##### 启动数据库

 **SQL>startup open**;

  ##### 创建表空间（数据库）

 **SQL>create tablespace**   data //表空间名称
2 **datafile 'E:\路径\文件名.dbf' //表空间数据文件路径**
3 **size 100M //表空间初始大小**

 ##### 删除表空间

 **SQL>drop tablespace 数据库名;**

  ##### 修改表空间：添加文件

1 **SQL>alter tablespace 数据库**；

2 **add datafile'E:/Oracle/文件名.dbf' //添加文件**
3 **size 10M; 文件大小**

   ##### 修改表空间：删除文件

1 **SQL>alter tablespace //数据库**

2 **drop datafile'E:/Oracle/文件名.dbf'; //删除文件**

  ##### 显示当前连接用户

 **SQL>show user**

  ##### 查看系统拥有哪些用户

 **SQL>select * from all_users**;

  ##### 连接到新用户

 **SQL>conn**

  ##### 查看oracle的版本信息

 **SQL>select * from v$version**;

  ##### 查询当前用户下所有对象

**SQL>select * from tab;**

  ##### 查询表结构

 **SQL>desc 表名**;

 ##### 回滚

 **SQL>roll**;
 **SQL>rollback**;
  **提交**
**SQL>commit**;

  ##### 退出

 **SQL>exit**;
 **SQL>quit;**

  ##### 设置显示效果

 **SQL>set linesize 300**;
 **SQL>set pagesize 300**;

#####Oracle数据类型

#####Oracle创建用户、角色、授权、建表

```
oracle用户的概念对于Oracle数据库至关重要，在现实环境当中一个服务器

一般只会安装一个Oracle实例，一个Oracle用户代表着一个用户群，他们通过

该用户登录数据库，进行数据库对象的创建、查询等开发。

每一个用户对应着该用户下的N多对象，因此，在实际项目开发过程中，不

同的项目组使用不同的Oracle用户进行开发，不相互干扰。也可以理解为一个

Oracle用户既是一个业务模块，这些用户群构成一个完整的业务系统，不同模

块间的关联可以通过Oracle用户的权限来控制，来获取其它业务模块的数据和

操作其它业务模块的某些对象。

用户权限

Oracle数据库用户权限分为：系统权限和对象权限两种。

系统权限：比如：create session可以和数据库进行连接权限、create

table、create view 等具有创建数据库对象权限。

对象权限：比如：对表中数据进行增删改查操作，拥有数据库对象权限的用

户可以对所拥有的对象进行相应的操作。

```

####创建表

create table myschool(id number(9),name nvarchar2(10),age number(3));

####创建新用户

1 create user student‐‐用户名
2   identified by "123456"‐‐密码
3   default tablespace USERS‐‐表空间名
4   temporary tablespace temp ‐‐临时表空间名
5   profile DEFAULT ‐‐数据文件（默认数据文件）
6   account unlock; ‐‐ 账户是否解锁（lock:锁定、unlock解锁）

#### 更改用户：

2  alter user STUDENT
3   identified by 123456  ‐‐修改密码
4   account lock;‐‐修改用户处于锁定状态或者解锁状态 （LOCK|UNLOCK ）

####删除用户

1 语法：
2  drop user 用户名;
3 例子：
4  drop user test;
5 若用户拥有对象，则不能直接删除，否则将返回一个错误值。
6
7 指定关键字cascade,可删除用户所有的对象，然后再删除用户。
8 语法：
9  drop user 用户名 cascade;
10 例子：
11  drop user test cascade;

####授权角色

三种标准角色：
1.connect(连接角色)
connect角色是Oracle用户的基本角色，connect权限代表着用户可以和Oracle服务器
进行连接，建立session（会话）。
2.resource(资源角色)
resouce角色是开发过程中常用的角色。 RESOURCE给用户提供了可以创建自己的对
象，包括：表、视图、序列、过程、触发器、索引、包、类型等。
3.dba(数据库管理员角色)
DBA角色是管理数据库管理员该有的角色。它拥护系统了所有权限，和给其他用户授
权的权限。SYSTEM用户就具有DBA权限。
提示：
系统权限只能通过DBA用户授权，对象权限有拥有该对象权限的对象授权（不一定是
本身对象）！用户不能自己给自己授权！

#### 授权命令：

2 ‐‐GRANT 对象权限 on 对象 TO 用户   
3 grant select, insert, update, delete on JSQUSER to STUDENT;
4 ‐‐GRANT 系统权限 to 用户
5 grant select any table to STUDENT;
6 ‐‐GRANT 角色 TO 用户
7 grant connect to STUDENT;‐‐授权connect角色
8 grant resource to STUDENT;‐‐授予resource角色
9

#### 撤销权限：

11 ‐‐ Revoke 对象权限 on 对象 from 用户
12 revoke select, insert, update, delete on JSQUSER from STUDENT;
13 ‐‐ Revoke 系统权限  from 用户
14 revoke SELECT ANY TABLE from STUDENT;
15 ‐‐ Revoke 角色（role） from 用户
16 revoke RESOURCE from STUDENT;

####创建/授权/删除角色

1 创建角色：
2 语法：
3  create role 角色名;
4 例子：
5  create role testRole;
6 授权角色：
7 语法：
8  grant select on class to 角色名;
9 列子：
10  grant select on class to testRole;
11 注：现在，拥有testRole角色的所有用户都具有对class表的select查询权限
12 删除角色：
13 语法：
14  drop role 角色名;
15 例子：
16  drop role testRole;
17 注：与testRole角色相关的权限将从数据库全部删除

####Oracle约束

在Oracle中，数据完整性可以使用约束、触发器、应用程序（过程、函数）
三种方法来实现，在这三种方法中，因为约束易于维护，并且具有最好的性能，
所以作为维护数据完整性的首选。
添加约束语法：
1 ALTER TABLE 表名 ADD CONSTRAINT 约束名 约束类型 约束描述

####约束命名规范:  

 非空约束     NN_表名_列名
 唯一约束     UK_表名_列名
 主键约束     PK_表名_列名
 外键约束     FK_表名_列名
 检查约束     CK_表名_列名
 默认约束     DF_表名_列名
主键约束（ Primary key, 简称 PK）
该约束的定义为：不能重复，不能为null。
1 **SQL> alter table 表名 add constraint 约束名 primary key(字段名)**;
非空约束( not null , 简称 NN )
约束该列不能为空值。
1 **SQL> alter table 表名 modify 字段名 not null**;
唯一约束( Unique , 简称 UK )
约束该列数据不能重复，不能相同。
1 **SQL> alter table 表名 add constraint 约束名 unique(字段名)**;
检查约束( Check , 简称 CK )
检查自定义条件是否为真，为真就可以插入，更新。
1 **SQL> alter table 表名 add constraint 约束名 check(字段名 in('约束的值','约束**
**的值')));**
2 例子：
3 S**QL> alter table emp add constraint CK_stuSex check(sex in('男','女'));**
4 ‐‐出生日期在1980年1月1日之后
5 **ALTER TABLE student ADD CONSTRAINT CK_student_borndate CHECK (borndate >**
**TO_date(‘1980‐01‐01‘,‘yyyy‐MM‐dd‘) );**
外键约束( Foreign key, 简称 FK )
外键约束定义在具有父子关系的子表中，外键约束使得子表中的列对应父表的主键列，
用以维护数据库的完整性。

####外键约束注意以下几点：

1、 外键约束的子表中的列和对应父表中的列数据类型必须相同，列名可以不同
2、 对应的父表列必须存在主键约束（PRIMARY KEY）或唯一约束（UNIQUE）
3、 外键约束列允许NULL值，对应的行就成了孤行了
4、 外键约束的表中的列数据必须包含在父表主键字段的数据内，否则会报错：ORA-
02298: 无法验证- 未找到父项关键字
其实很多时候不使用外键，很多人认为会让删除操作比较麻烦，比如要删除父表中的某
条数据，但某个子表中又有对该条数据的引用，这时就会导致删除失败。我们有两种方式来
优化这种场景：
　  第一种方式：简单粗暴，删除的时候，级联删除掉子表中的所有匹配行，
在创建外键时，通过 on delete cascade 子句指定该外键列可级联删除：
1 **SQL> alter table 表名 add constraint 约束名 foreign key(字段名) references**
**父表名 (父表字段) on delete cascade;**
　
第二种方式：删除父表中的对应行，会将对应子表中的所有匹配行的外键约
束列置为NULL，通过 on delete set null 子句实施：
1 **SQL> alter table 表名 add constraint 约束名 foreign key(字段名) references**
**父表名 (父表字段) on delete set null;**
默认约束( Default Key,简称 DF )
约束用于向列中插入默认值。
1 **SQL> alter table 表名 modify （字段 类型 default 默认值）**
2 例子：
3 **alter table Student Modify Address varchar(50) default '地址不详';**
4 **alter table Student Modify JoinDate Date default sysdate;**

####Oracle注释

#####添加表级注释

1 **SQL> COMMENT ON TABLE 表名 IS '注释内容'**;

#####添加列级注释

1 **SQL> COMMENT ON COLUMN 表名.字段名 IS '注释内容';**

#####查看表级注释

1 **SQL> SELECT * FROM USER_TAB_COMMENTS WHERE TABLE_NAME='表名';**

#####查看列级注释

1 **SQL> SELECT * FROM USER_COL_COMMENTS WHERE COLUMN_NAME='字段名' AND COMMEN**
**TS IS NOT NULL;**

#####删除注释（即，添加空注释）

1 **SQL> COMMENT ON TABLE 表名 IS '';**
2 **SQL> COMMENT ON COLUMN 表名.字段名 IS '';**

#####Oracle序列

序列(SEQUENCE)是序列号生成器，可以为表中的行自动生成序列号，产生
一组等间隔的数值(类型为数字)。不占用磁盘空间，占用内存。
其主要用途是生成表的主键值，可以在插入语句中引用，也可以通过查询检
查当前值，或使序列增至下一个值。

#####创建序列

1 创建序列需要**CREATE SEQUENCE**系统权限。
2 序列的创建语法如下：
3   CREATE SEQUENCE 序列名
4   [INCREMENT BY n]
5   [START WITH n]
6   [{MAXVALUE/ MINVALUE n| NOMAXVALUE}]
7   [{CYCLE|NOCYCLE}]
8   [{CACHE n| NOCACHE}];
9

##### 其中：

11 1)  INCREMENT BY用于定义序列的步长，如果省略，则默认为1，如果出现负值，则代表O
racle序列的值是按照此步长递减的。
12 2)  **START WITH** 定义序列的初始值(即产生的第一个值)，默认为1。
13 3)  **MAXVALUE** 定义序列生成器能产生的最大值，选项**NOMAXVALUE**是默认选项，代表没有
最大值定义。
14 4)  **MINVALUE**定义序列生成器能产生的最小值。选项**NOMAXVALUE**是默认选项，代表没有
最小值定义。
15 5)  **CYCLE**和**NOCYCLE** 表示当序列生成器的值达到限制值后是否循环。**CYCLE**代表循环，N
**OCYCLE**代表不循环。如果循环，则当递增序列达到最大值时，循环到最小值;对于递减序列达
到最小值时，循环到最大值。
16 如果不循环，达到限制值后，继续产生新值就会发生错误。
17 6)  **CACHE**(缓冲)定义存放序列的内存块的大小，默认为20。**NOCACHE**表示不对序列进行内
存缓冲。对序列进行内存缓冲，可以改善序列的性能。
18 8)  **CURRVAL** 中存放序列的当前值,**NEXTVAL** 应在 **CURRVAL** 之前指定 ，二者应同时有
效。
19
20 例子：
21 **SQL> create sequence t1_seq increment by 1 start with 1;**
使用序列
**调用NEXTVAL将生成序列中的下一个序列号，调用时要指出序列名，即用以**
**下方式调用: 序列名.NEXTVAL**
**CURRVAL**用于产生序列的当前值，无论调用多少次都不会产生序列的下一个
值。如果序列还没有通过调用**NEXTVAL**产生过序列的下一个值，先引用
**CURRVAL**没有意义。调用**CURRVAL**的方法同上，要指出序列名，即用以下方式
调用:序列名.**CURRVAL**
1 SQL> **create table t1(id number,qq number,ww number);**
2 SQL> **insert into t1 values(t1_seq.nextval,1,1);**
查看序列
1 SQL> select * from t1;
2         ID         QQ         WW
3 ‐‐‐‐‐‐‐‐‐‐     ‐‐‐‐‐‐‐‐‐‐     ‐‐‐‐‐‐‐‐‐‐
4          1          1          1
5          2          1          1
6          3          1          1
7          4          1          1
8          5          1          1
9
10 SQL> **select t1_seq.currval from dual;**
11    CURRVAL
12 ‐‐‐‐‐‐‐‐‐‐
13          5
14
15 SQL> **select t1_seq.nextval from dual;**
16    NEXTVAL
17 ‐‐‐‐‐‐‐‐‐‐
18          6
19
20 SQL> **select t1_seq.nextval from dual;**
21    NEXTVAL
22 ‐‐‐‐‐‐‐‐‐‐
23          7