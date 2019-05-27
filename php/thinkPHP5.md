# THINKPHP 5 学习笔记
## 环境要求

+ PHP版本必须大于 5.4.0
+ 必须支持PDO扩展

## 安装

1. 下载源码包
   1. 下载后直接
2. composer
3. git

## 检测是否安装成功

1. 地址栏输入 http://localhost:8080/tp5/public
2. 看是否出来欢迎界面
3. tp5是文件夹名称

## 目录结构

1. application  应用目录 是整个网站的核心
   1.   index 前台目录
      1. controller 控制器
      2. model 数据模型
      3. view 页面
   2. admin 后台目录
2. extend 扩展类库目录
3. public  静态资源目录 js css 图片
   1. static 存放静态资源
   2. index.php 入口文件
4. runtime    网站运行时临时目录
5. tests      测试目录
6. thinkphp   Tp框架的核心文件
   1. lang 语言包
   2. library TP核心文件
   3. tpl 模板文件
7. vendor 第三方扩展目录 

## URL 地址

http :// localhost:8080 /THINKPHP5/tp5/public/index.php/ Index    /index     /user

协议        域名                           入口文件                                       模块     控制器    方法

## Tp 开发模式

+ **开启debug模式**
  + application/config.php 配置文件

+ **修改数据库配置**
  + application/database.php 文件进行修改	 
+ **添加视图页面**
  + application/index/view/index.html

## MVC的变形

+ MC   用于接口开发
+ VC     用于单页面开发

## TP 访问其他模块的方法

+ 使用命名空间
  + 例如   $model = new app\index\controller\Index
    + $model->index();  //调用里面的方法
+ 使用use
  + 在类上面使用  use app\index\controller\index
    + $model = new Index;
    + $model->index(); //调用方法 
+ 使用系统内置的controller("模块名称")方法
  + 例如  $model = controller("Index");
  + $model->index();  //调用里面的方法

## 创建控制器注意点

+ 在创建一个控制器的时候注意必须要使用命名空间
+ 例如   namespace app\index\controller
+ 例如  namespace app\admin\controller

## 调用当前控制器方法

+ $this->test()   当前类
+ self::test()    当前类
+ Index::test()    当前类
+ action("index")  内置方法

##调用不同控制器的方法

+ action("User/index"); 内置方法

## 调用后台index控制器的法方法

+ action("admin/Index/index")

## 配置相关

**读取惯例配置(thinkphp/convention.php)** 

+ 通过系统方法 config(name)
+ 如果配置是一个数组可以通过.语法调用
+ config("teacher.name")

**应用配置(application/config.php)**

**扩展配置(database.php)**

**自定义扩展配置(extea)**

+ config("文件名.属性")

**环境变量配置**

+ 新建.env文件  不能设置中文
  + 内容     key=value
    + ​	key=value
+ 读取  
  + 通过系统类
  + \Think\Env::get("name")
  + \Think\Env::get("name","not Found")

## 路由

+ 简化URL地址 方便记忆
+ 有利于爬虫抓取

### 设置前后分离入口文件

+ 就是访问前台的时候访问不到后台模块内容
+ 在public目录下增加admin.php 也可以复杂点的名字
+ 在index.php 和 admin.php 里面绑定模块
+ define("BIND_MODULE","index")  index.php
+ define("BIND_MODULE","admin")   admin.php
+ 然后就可以了  在访问的时候还可以省去模块名称

## 关闭后台路由

+ 在 admin.php 中 后台入口文件中 最下面添加
+ \Think\App::route(false)

## 使用路由

+ 要先开启路由
+ 引入系统类  \Think\Route
+ config.php 中  url_route_on=>true 即可 
+ 设置路由之后就不能使用pathinfo了
+ Route::rule("/","index/index/index")
+ tp5 支持四种请求类型 get post put delete

## 路由的形式

+ 默认支持所有请求

+ 静态路由
  + Route::rule("/index","Index/index/index")
+ 动态路由
  + Route::rule("/index/:id","Index/index/index")
  + **获取**
    + input("id")  在对应的方法中
+ 完美匹配路由
  + Route:rule("/index$")
  + 表示只匹配到协定的路由名称多写少写都不能匹配
+ 纯动态路由 (不推荐使用)
  + Route::rule(":id/:tid","Index/index/index")
+ 制定类型路由
  + Route::rule("/index","Index/index/index","POST")
  + Route::get("/index","Index/index/index"
  + Route::post("/index","Index/index/index")
+ 同时支持多种请求类型的路由
  + Route::rule("/index","Index/index/index","get|post")
+ 可选参数路由
  + Route::rule("/index/[:id]","Index/index/index","get|post")

## 批量注册

+ Route::get(["/index"=>"Index/index/index","/info/:id"=>"Index/index/info"])
+ Route::post(["/index"=>"Index/index/index","/info/:id"=>"Index/index/info"]):

## 设置路由参数规则

+ Route::rule("/index/:id","Index/index/index","get",[],['id'=>"\d+"]); 规定参数类型

## 资源路由

+ Route::resource("blog","Index/blog")   访问blog控制器  会自动生成七个路由 用来增删改查

## 生成URL地址

+ url("Index/index/index")

## 加载页面

+ 使用系统方法  view()
+ 使用conteroller类的fetch方法  需要继承Controller类    在继承前要引入  \Think\Controller
  + return $this->fetch()
+ 使用view类
  + 需要先引入view类
    + use \Think\View
    + $view  = new View()
    + $view->fetch()

## 初始化方法

+ 必须继承Controller 
+ 编写   public function _initializ(){ 在每一个方法调用前这里的方法就会第一执行 }

## 数据库操作

+ ```php
  namespace app\index\controller;
  
  use think\Db;
  
  class Database{
  
      public function index(){
  
          $db = new Db();
  
          $data = $db::table("tp_users")->select();
  
          dump($data);
  
          $data = $db::query("SELECT * FROM tp_users");
          
          /* 可以设置占位符 */
          
           $data = $db::query("SELECT * FROM tp_users where id = ? ",[2]);
  
          dump($data);
           
          /* 获取路由参数 */
          input("参数名称")
          /* 获取post参数 */
          input("post.id")
          /* 获取get参数 */
          input("get.id")
          return 123;
      }
  
  }
  ```

##数据库传统操作

+ Db::query()   查询 放回结果集
+ Db:execute()  增删改 返回影响行数

## 获取到static下面的资源

+ \__STATIC__/css/index.css

