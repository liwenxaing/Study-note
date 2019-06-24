# 1. NodeJs学习笔记(基本认知)

## 1. NodeJs是什么

+ MDN https://developer.mozilla.org/zh-CN/ 
+ NodeJs 不是一门语言
+ NodeJs 不是一个库 一个框架
+ NodeJs  是Javascript运行时环境
+ NodeJs   可以执行解析js代码
+ 可以完全脱离浏览器运行 
+ 以前只有浏览器可以解析js代码
+ 底层是C++写的

## 2. 浏览器里的JS

+ ECMAScript
+ 基本的语法
+ if
+ var
+ function
+ Object
+ Array
+ Bom
+ Dom

## 3. NodeJs中的js

+ 没有bom和dom

+ 支持ECMAScript语法

+ 服务器不处理DOM

  ####3.1 Nodejs 提供了一些服务器级别的API

  + 文件的读写
  + 网络服务的构建..
  + 网络通信
  + http服务器等..

##3. NodeJs中的特点   

+ **从单线程到非阻塞IO到事件驱动都是环环相扣的缺一不可**

+ 单线程   不存在销毁线程 创建线程的时间开销    也减少了内存的开销
  + 坏处    一个用户造成了线程的崩溃 那么整个线程就崩溃了
  + ![1543393552990](C:\Users\Administrator\AppData\Local\Temp\1543393552990.png)

+ 非阻塞I/O模型 异步
  + 异步就去进行数据库的读取操作    I/O  读取数据库
  + ![img](file://C:/Users/Administrator/AppData/Local/Temp/1543394637553.png?lastModify=1543394648) 
+ 事件驱动  事件机制 事件环
  + 不管是新用户的请求 还是老用户的回调 都会通过事件的方式加入事件环 等待调度！
  + ![1543396711035](C:\Users\Administrator\AppData\Local\Temp\1543396711035.png)
+ 轻量和高效
+ npm 基于NodeJs的包管理分发工具 生态系统 开源库
+ 基于Chrome V8 引擎之上

## 4. 浏览器引擎

+ Javascript解释器引擎
+ 渲染引擎
+ Google的Chrome v8 引擎目前是公认的解析Javascript最快的

## 5. NodeJs 做什么？

+ Web服务器后台
+ 命令行工具
  +  git
  + npm

## 6. 辅助资源

+ http://www.nodebeginner.org/index-zh-cn.html `NodeJs入门`
+ 社区 http://cnodejs.org
+ 深入浅出nodejs

## 7. 能学到啥

+ B/S编程模型
+ 模块化编程
+ 异步编程
+ Express开发框架
+ EcmaScript6

##8. 安装

+ 安装新的版本就会覆盖以前的版本

## 9. NodeJs 文件命名规则

+ 还是写在js文件里面 
+ 文件名不可使使用 node.js 命名
+ 不要使用中文

## 10. 核心模块 - 读取文件

+ 使用require 方法加载 fs 模块  
+ 调用readFile(url,callback[error,data])方法读取文件
+ 调用writeFile(url,content,callback[error])写入文件
+ 还有n个方法...........

## 11. 核心模块 - 创建http服务器

+ 使用require 方法加载 http 模块  

+ ```
  let http = require("http");
  ```

+ 调用createServer(callback[request,response])方法

+ ```
  let server = http.createServer();
  ```

+ 或者获取到createServer返回Server实例 调用 on('request',callback(req,res))

+ ```
  server.on("request",function(request,response){
      //request.url  获取到的路径是从 端口后面获取到的
      
      //告诉客户端 结束响应可以呈现给用户了
      response.end("phpstrom!"); //可以在结束响应的同时输出数据
  });
  
  //第二种方式
  http.createServer((request,response)=>{
  
          //返回json
  
          let pro = [ {name:'lee',title:'李文祥',price:8000000000000000}];
  
          response.end(JSON.stringify(pro));
  
  }).listen(3000,e=>{
          console.log("服务器启动!");
  });
  ```

+ ```
  // 绑定request请求事件  回调函数可以接受两个参数  一个是
  // request  用来获取客户端的一些请求信息 例如请求路径
  // response 响应对象可以用来给客户端发送响应信息
  // response 里面有一个write方法 可以使用多次 但是最后一定要使用end来结束响应
  // 不然的话客户端会一直在等待
  ```

+ 里面有req.url 获取到url

+ res.end([String|Buffer]) 结束响应

+ res.write([String|Buffer]) 输出信息

+ 这是一个客户端请求事件

+ readdir(url,callback[error,files(Array)]) 是读取一个目录

+ 在调用listen(port,callback)启动服务并设置端口

+ ```
  server.listen(3000);
  ```

  ### 11.1 设置相应内容类型`content-type`

  + 调用res.setHeader('content-type','text/plain;charset')

  + ```
    /* 在服务端默认发送的数据，其实是utf-编码的内容 */
    /* 但是浏览器不知道你是utf-8编码 */   
    /* 浏览器不知道服务器相应内容的编码就会按照当前操作系统的编码去解析 */
    /* 中文操作系统默认是GBK */
    /* 解决办法就是告诉浏览器我们的编码格式 */
    /* 调用setHeader设置响应头信息 */
    /* text/plain 普通文本   text/html htl格式文本 */
    ```

  + 设置编码与设置相应内容类型

  + ```
    res.setHeader('content-Type','text/plain;charset=utf-8');
    ```

  + 注意每一个格式的文件的响应类型都是不一样的

## 12. NodeJs 作用域

* 1. 具名的核心模块

* 2. 用户自己编写的文件模块

* 在Node中没有全局作用域  只有模块作用域

* 模块与模块之间不会产生变量污染

* 引入的模块不能使用其他模块的变量与函数

* 作用域仅限于当前文件 模块~

* require 方法可以接受到其他模块的对外接口

* require获取到的默认是一个空的exports对象

* 想要访问其他模块中的成员 就必须挂在到这个对象上面 进行导出

* ```
  //使用exports到处的属性 方法 在被引用此模块的时候都可以调用了
  //默认就会返回exports对象 默认是一个空的对象
  //可以在这个对象上面挂载属性方法
  
  导出的文件
  
  exports.add=(x,y)=>{
      return x + y;
  };
  
  exports.foo = 'bar';
  ```

##13. 核心模块 - os|path

```
 let os = require("os");  //引入操作系统模块

//获取到cpu信息
console.log(os.cpus());  

/* 获取内存 */
console.log((os.totalmem()/1024/1024/1024).toFixed(2)+"G");

/* Node 中的 js */
//路径模块
let path = require("path");

/* 获取到目录名 / 文件名 */
path.dirname("");
path.basename("")
```

## 14. 端口与ip

```
/* 需要进行通信的就是需要端口号 */

/* ip就是用来定位计算机的 */

/* 端口号 范围 0 - 65535 */

let http = require("http");

http.createServer((req,res)=>{
       
        /* 获取到请求者的端口  与ip地址   ::1 本机 */
       console.log("请求的端口号是"+req.socket.remotePort);
       console.log("请求的地址是"+req.socket.remoteAddress);
       res.end("end server!");

}).listen(3000,e=>{
   console.log("服务器启动成功!");
});
```

## 15. JS中的代码风格注意事项

+ 以 `[(` 开头的代码最好在前面加上一个 ; 为了防止有可能报错



## 16. 手写apache功能 (统一加载静态资源)

```
/* 编写一个象apache那样的服务器 */
/* 能够统一定位静态资源 */



/* www 根目录 */
let wwwDir = "G:/globalReview/nodeJs/day2/www";

/* 加载http模块 */
let http = require("http");
/* 加载文件系统模块 */
let fs = require("fs");

/* 默认访问文件 */


/* 得到Server实例对象 */
let Server = http.createServer();

/* 绑定请求事件 */
Server.on("request",function(request,response){
     let url = request.url;
     

     let fileName = "/index.html";

     if(url !== "/"){
        fileName = url;
     }

/* 判断当前路径结尾是不是/ 是的话默认访问该路径下的index.html */
     if(/\/$/.test(url)){
         fileName = url +"index.html";
     }

     fs.readFile(wwwDir + fileName,function(err,data){
     	if(err){
            return response.end("<h1>404 Not Found !</h1>" + wwwDir + fileName);
     	}
     	response.end(data);
     }); 
     
  

}).listen(3000,function(){
	console.log("Server statr running...");
});

```

## 17. JS模板引擎 （art-template）（解析字符串）

+ 在node中安装art-template  

  输入命令 npm install art-template --save

  + 在哪执行这条命令就安装到哪里
  + 会默认显示在node_modules文件夹中
  + node_modules 文件夹不能改
  + 目录 node_modules > art-template > lib > template-web.js 是给在浏览器上用的

+ 模板引擎不关心内容 只关心数剧

+ 在浏览器中将模板字符串存储到script标签中

+ 使用模板引擎

+ ```
  <!DOCTYPE html>
  <html lang="en">
  <head>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <meta name="description" content="">
      <meta name="keywords" content="">
      <meta charset="UTF-8">
      <title>art-template</title>
  </head>
  <body>
     <h1>在浏览器中使用</h1>
     <!-- 在浏览器中需要引用这这个文件  才能使用模板-->
     <script src="node_modules/art-template/lib/template-web.js"></script>
     <!-- 给script修改一下type 为了防止浏览器给这个当js解析 加个id = tpl -->
     <!-- 填写内容 -->
     <script type="text/template" id="tpl">
            /* 解析变量 */
            hello {{ name }}
            我今年{{ age }}
            我来自 {{ form }}
            /* 便利 */
            我喜欢  {{each loves}}  {{ $value }} - {{ $index }}  {{/each}}
     </script>
  
     <script>
         /* 填写数据 */
         let ret = template("tpl",{
             name:"lee",
             age:18,
             form:"中国",
             loves:[
                 "大花生",
                 "米酒",
                 "啤酒",
                 "可乐"
             ]
         })
         /* 输出信息 */
         console.log(ret);
     </script>
  
  </body>
  </html>
  ```

  ### 标准语法

  1. {{ 变量名 }}
  2. {{ each 集合名 }}  {{ $value  获取到便利项}}  {{ /each }}
  3. {{ if  1>2 }} 内容 {{ else  if  3>2 }}  内容 {{ else }}  内容  {{ /if }}
  4. {{ include 'index.html' }}   
  5. {{ block 'head' }}   默认内容   {{ /block }}   这就是相当于埋了个坑   
  6. {{ extend  'index.html' }}   继承一个埋了坑的模板文件可以使用同样的语法进行填坑
  7. 在哪埋的坑就会在那进行替换

## 18. 在NodeJs中使用模板引擎

+ 在node中将模板字符串存储到文件中

+ 在需要使用的文件中加载art-template  ---   require("art-template")

  ```
  let art =  require("art-template");
  
  //执行字符串解析   并返回解析后的字符串
  art.render(template-string,obj);
  
  
  
  /* 案例 */
  let art =  require("art-template");
  
  let res = art.render("hello {{ name }}",{
        name:"lee"
  });
  
  console.log(res); // hello lee
  ```

  

## 19. 渲染模式

+ 客户端渲染不利于SEO优化 爬虫抓取不到
+ 服务端渲染能够被爬虫抓取到
+ 真正的网站既不是纯异步 也不是纯服务端 是两者相互配合使用的
+ 论场景  如果需要考虑SEO使用服务端渲染 不需要考虑SEO的话就使用客户端渲染

## 20. url模块

+ url 模块 对浏览器地址的url进行处理 并且返回一个对象易于管理

+ 里面的query存储着地址后的请求参数

+ 获取到浏览器get传递过来的值

+ ```
  let url = require("url");
  
  /* 获取到url的所有信息 */
  let parseUrl = url.parse("http://localhost:3000/?age=18&title=lee",true);
  
  /* 打印对象 */
  console.log(parseUrl);
  ```

  

## 21. 谷歌json格式化插件

https://github.com/gildas-lormeau/JSONView-for-Chrome 

+ 下载后解压 > 打开谷歌 > 更多工具 > 扩展程序 > 启动开发者模式 > 添加扩展程序 > 选择解压后的安装包

## 22. 设置响应状态与重定向

+ res.status = 302  设置响应状态为临时重定向
+ res.setHeader("Location",url)  设置重定向页面地址
+ res.setHeader("Content-Type","text/html;charset=utf-8")   设置响应内容类型
+ res.writeHeader(200,{"Content-Type":"text/html;charset=utf-8"}); 设置响应状态 设置响应内容类型

# 2.模块系统

 ## 2.1 基本规则

+ 核心模块

+ 第三方模块

  + 必须安装 npm install 模块名

+ 自定义模块

  #### 2.1.1 commonJS	模块规则

  + 文件作用域
  + 通信规则
    + 加载  require
    + 导出  exports

+ 使用require加载模块

+ 使用exports接口对象导出模块 

+ 在node中没有全局作用域 只有模块作用域

+ a文件加载b文件只能得到b文件导出(exports)的数据

+ 我们直接使用exports导出的获取到是一个对象

+ 怎么才能直接导出一个方法数组或者字符串呢？

+ 我们可以使用modul-exports = add 这样导出的就直接是这个方法了 而不再是对象了

+ 导出多个成员

+ ```javascript
  exports.a = 1;
  exports.add="hello";
  exports.post=function(){
      
  }
  ```

+ 导出单个成员

+ ```javascript
  module.exports = "heelo";
  
  module.exports.add="hello";
  /* 后面的会覆盖前面 */
  module.exports.post=function(){
      
  }
  
  /* 也可以导出多个成员 */
  
  module.exports = {
      name:"lee",
      age:18
  }
  ```

## 2.2 原理

+ 在node中每一个模块内部都有一个自己的module对象
+ 改module对象中有一个成员叫 exports 我们看不到
+ 在模块中还有一个exports的变量等于module.exports 所以可以直接exports导出成员
+ 默认在代码的最后有一句 return module.exports 

##2.3 require方法加载规则

+ 多文件相互加载不会重复加载 当加载到已加载过的模块 会先从缓存到中找如果有直接返回结果让你用
+ 避免重复加载 提高模块加载效率
+ 优先从缓存中加载
+ require模块引入核心模块里面的参数不是路径而是模块标识符
+ 路径的话是./  ../ 之类的

 #### 4.3.1 第三方模块加载规则(重要)

+ 以 art-template为例

+ 先找到当前文件所处目录中的node_moduls 目录
+ 再找到node_moduls/art-template文件夹
+ 再找到node_moduls/art-template/package.json 文件
+ 再找到node_moduls/art-template/package.json 文件中的main属性
+ main属性中记录了art-template的入口模块
+ 然后加载使用这个第三方包
+ 实际上最后加载的还是文件
+ 如果没有package.json 文件 不存在或者main属性的路径不对  那么node就会默认找当前目录下的index.js文件
+ 如果以上的条件都不满足那就会进到上一级目录的node_moduls文件夹进行查找以此类推~
+ 最后找不到就报错 找不到这个模块
+ 我们一个项目有且只有一个node_moduls放在项目根目录中

## 2.4 npm(node package manager)

+ node package manager （node 包资源管理器）

+ npm网站 是用来上传包的 共别人下载使用

+ 命令行工具

+ npm uninstall 包名  移除模块  只删除 但会保留依赖模块

+ npm uninstall --save  移除模块的同时还会把依赖项删除
  + npm help 查看使用帮助

       #### 2.4.1 解决npm被墙问题

+  npm服务器在国外  有时候在国内访问比较慢 所以我们需要解决这个问题

+ http://npm.taobao.org 淘宝团队在国内给npm做了一个备份

+ 安装淘宝的cnpm

+ ```
  # 在任意目录安装即可 但是要加上--global 表示安装到全局
  npm install --global cnpm
  # 安装完之后 我们就可以在cmd中是用 cnpm innstall 包名安装了
  会默认使用淘宝的服务器进行下载安装
  否则还是使用国外的服务器进行下载
  ```

+ npm config set register https://register.npm.taobao.org   

+ 如果你不想安装淘宝镜像 但是还想使用淘宝服务器的话 就需要设置配置文件  写上上面的代码

+ npm config list  查看配置信息

## 2.5 package.json(包描述文件)

+ 我们建议每一个项目的根目录都要有一个`package.json`文件（包描述文件）给人踏实的感觉
+ 这个文件可以通过npm init 创建出来 npm init -y 跨过引导
+ 里面的dependencies选项，可以用来帮助我们保存第三方包的依赖信息 就是我们这个项目依赖了那些第三方模块
+ 建议执行npm install 包名 的时候都要加上--save 因为这个选项 目的是用来保存依赖信息
+ 当我们的node_moduls文件夹丢失的时候 我们可以明确的看到当前的项目中依赖了哪些模块
+ 我们可以使用npm install 命令去安装这些依赖项 他会默认安装package.json文件中的  dependencies选项中的依赖项

## 2.6 package.lock.json 文件

+ 这样的话npm install 速度就会提升
+ 锁定版本号 防止自动升级新版

# 3. sublime Text 3 安装插件方法

```
代码提示插件  sublimeTemp
ctrl + shilft + p  打开sbulime Text 3 插件管理工具
安装package control 
在点击preferences 点击package control 安装install  在安装 sublimeTemp
安完之后 在preferences Browse Control 单击里面有个sublimeTemp 看到这个就可以代码提示了
```
# 4. Express

+ 安装express
+ npm install express --save

#### 4.1 创建第一个http应用程序

+ 1. 安装s

  2. 引包 const express = require("express");

  3. 创建服务器  const app = express();  就相当于以前的http.createServer();

  4. 设置端口 app.listen(3000,callback)

  5. 接受get请求 app.get("/",function(req,res){   res.send("hello world!");  });

  6. 在express中已经帮我们设置了content-type 不需要我们再去设置

  7. epress  默认会将错误的路径进行处理 

  8. req.query 可以获取到get传递过来的参数 返回的是一个对象

  9. res.redirect("/");  重定向 比起原生的更好使用

  10. ```javascript
      # 原生重定向方法
      res.statusCode = 302;
      res.setHeader("Location","/");
      #express重定向方法  能够自动结束响应
      res.redirect("/");
      ```

#### 4.2 修改完代码自动重启服务

+ 我们可以使用一个第三方命令行工具 `nodemon`来帮助我们完成频繁修改代码的 重启服务问题

+ `nodemon`是一个基于nodejs开发的第三方命令行工具我们使用需要独立安装

+ ```shell
  npm install --global nodemon
  ```

+ 然后在启动的时候将`node app.js`修改成`nodemon app.js`即可

+ 一旦你启动了这个文件 就会监听你文件的改变进行服务的自动重启

#### 4.3 express中的static-server 静态资源服务 与路由

+ 路由

+ ```javascript
  # 在express中路由支持链式调用  
  
  const express = require("express");
  
  const app = express();
  
  app.get("/",函数).get("/",函数).post("/",函数)  因为他的get或者post返回的是app这个对象
  
  app.listen(3000);
  ```

+ 静态资源

+ ```javascript
  # 加载静态资源 不需要我们以前再用原生还要判断获取url 在读取文件输出
  # 当访问/public/的时候 就去./public文件夹下面找资源
  app.use("/public/",express.static("./public/"));
  # 可以理解a就是./publicDevelopment别名 输入/a/xxx.js 就可以访问 就代表了 /public/xxx.js
  app.use("/a/",express.static("./public/"))
  # 可以理解为不需要前面的public文件夹名称 可以直接xxx.js就访问这个文件
  app.use(express.static("./public/"))
  ```

+ 以上三种一般来说用第一种的多 因为看起来更加的直观

#### 4.4 在express中配置使用art-template

+ ```shell
  #首先要安装art-template
  npm install --save art-template 
  npm install --save express-art-template
  #也可以一次性安装多个文件
  npm install --save art-template express-art-template
  #安装完之后需要进行配置 里面为res提供了render方法默认不能使用 必须配置完毕才可以使用
  #完整代码实例
  const express = require("express");
  const app = express();
  #这里可以不用引入art-template 因为 express-art-template 依赖了art-template 所以这里需要安装art-template
  app.engine("art",require("express-art-template"));
  #如果想要修改默认的views目录可以通过 第一个参数是固定的views 第二个参数是要修改的目录名*/
   app.set("views","page"); 
  app.get("/",function(req,res){
      #这里的index.art的后缀名师默认在engine里面进行的配置可以替换成其他的
      #我们这里不用加views文件夹名字因为express与art有一种约定就是默认读取views文件夹下的文件
      #如果views文件夹下面还有文件夹那么就加上views下面的文件夹的名字
      #第一个就是模板字符串 第二个参数就是要传递的模板对象值~
      #这个方法会自动将加载到的模板字符串渲染出去
      #不需要在调用express提供的send方法
      res.render("index.art"|"admin/index.art",{
          name:"lee"
      });
      
  });
  ```

#### 4.5 处理post请求数据

+ express默认没有提供直接获取post请求体参数的API
+ 我们可以通过下载第三方包body-parser来获取post请求体参数
+ 配置信息如下

```javascript
# 第一步  安装
npm install --save body-parser

const express = require("express");
# 加载包文件
const bodyParser = require("body-parser");

const app = express();

#配置bodyParser
#只要加入了这个配置 request请求对象上就会多出来一个body属性
#也就是说你可以直接通过 req.body 来获取POST请求体参数了
app.use(bodyParse.urlencoded({extended:false}));

app.use(bodyParser.json());

app.post("/",function(req,res){
      res.send(res.body); #post参数
});


```

## 4.6 Express - CRUD

#### 起步

+ 初始化 
+ 模板处理

#### 路由设计

| 请求方法 | 请求路径        | get参数 | post参数                   | 备注             |
| -------- | --------------- | ------- | -------------------------- | ---------------- |
| GET      | /students       |         |                            | 渲染首页         |
| GET      | /student/new    |         |                            | 渲染学生添加页   |
| POST     | /student/new    |         | name、 、gender、hobbies   | 处理添加学生请求 |
| GET      | /students/edit  | id      |                            | 渲染编辑页面     |
| POST     | /students/edit  |         | id,name,age,gender,hibbies | 处理编辑请求     |
| GET      | /student/delete | id      |                            | 处理删除请求     |
|          |                 |         |                            |                  |

#### 路由模块的抽离

+ 将app.js里的路由模块抽离到另一个文件中
+ 一个模块只负责一件事
+ 我们一般就是创建一个router.js里面的内容就是负责处理请求
+ 不使用express提供的方法的写法  抽离

```javascript
# app.js  负责一些配置信息 就是一个入口文件
  const express = require("express");
  const app = express();
/* 引入路由模块 得到导出的函数*/
  const router = require("./router");
/* 调用 传入app */  
  router(app);
## router.js
const fs = require("fs");
# 导出的数据
module.exports = function(app){
    app.get("/",function(req,res){
        
    });
}
```

+ 使用express提供的方法

```javascript
# app.js  负责一些配置信息 就是一个入口文件
  const express = require("express");
  const app = express();
/* 引入路由模块 得到导出的函数*/
  const router = require("./router");
/* 使用router */  
  app.use(router);
## router.js
const fs = require("fs");
const express = require("express");
const router = express.Router();
router.get("/",function(req,res){
       res.send("hello world!");
});
# 导出的数据
module.exports = router;
```

#### 封装异步API

```javascript
# student.js

# 一般来说异步操作的内容不会按正常的执行顺序来执行

#我们想要获取到异步操作的数据在es5中必须使用回掉函数

#例子

function fn(callback){
    let data = "默认数据";
    setTimeout(function(){
          data = "hello";
          callback(data)
    },1000); 
}
# 这样就获取到了数据
fn(function(data){
    console.log(data); // hello
})


# es6 Promise

function Pro(){
   return new Promise((resolve,reject)=>{
       let data = "默认数据";
       setTimeout(function(){
            data = "hello";
            resolve(data);
       });
   });
}

Pro().then((data)=>{
     console.log(data); //hello
});
```

#### 保存 学生的异步编程封装方法(示例) 异步编程是nodejs的核心也是精华

``` javascript
#往文件里保存数据
exports.save=function(student,callback){
    fs.readFile(dbPath,"utf8",function(err,data){
        if(err) return callback(err).send("Server Error!");
        let students = JSON.parse(data).student;
        student.id = students[students.length  - 1].id + 1;
        students.push(student)
        let WriteStr = JSON.stringify({
            student:students
        });
        fs.writeFile(dbPath,WriteStr,function(err){
            if(err) return callback(err).send("Server Error!");
            callback(null);
        })
    });

};
```
## 5. MongoDB

+ 用c++编写

+ 非关系型数据库   没有sql语句

+ 所有的关系性数据库都需要sql语句来操作

+ 而且数据表支持约束

  + 主键
  + 非空
  + 唯一的
  + 默认值

+ 非关系型数据库非常的灵活

+ 有的非关系型数据库就是 key-value键值对儿

+ 但是mongoDB是最像关系型数据库的非关系型数据库

  + 数据库 > 数据库
  + 数据表 > 集合(数据)
  + 表记录 > 文档对象

+ MongoDB不需要设计表结构

+ 也就是说可以往里面任意存数据 没有表结构一说

  ### 安装

+ 官网下载  http://mongodb.org

+ custom 可以选择自定义安装

+ 安装完毕之后配置环境变量  

+ 在环境变量里面配置 PATH 为 mongoDB安装路径\bin  bin目录下就是一些可执行文件

+ 输入mongod  --version 检查版本  如果出现版本就证明安装成功了

####        5.1 启动关闭数据库

+ 启动

+ ```shell
  # mongodb 默认使用执行mongod 命令所处盘符根目录下的 /data/db 作为自己的数据存储目录
  # 如果没有那个目录的话就会启动不成功 那么的话就可以手动的在根目录下创建一个/data/db文件夹
  mongod  --dbpath c:/mongo  回车  就启动了  后面的是设置数据存储路径
  # mongod 存储数据的文件以.ns 结尾的就是数据库 可以拷贝
  ```

  + 如果要修改默认的数据存储路径 可以这么干

  + ```shell
    mongod --dbpath=数据存储路径
    ```

  + 停止

  + ```javascript
    在开启服务的控制台直接ctrl+c 即可停止运行
    或者直接关闭开启服务的控制台也可以
    ```

    ### 链接数据库

    在cmd中输入 mongo 回车就连上了   这些都是命令的方式  但是前提是必须要打开mongodb数据库服务 默认链接本机数据库服务

    ### 退出链接状态

    在cmd中输入 exit 回车就退出链接状态了

## 5.2 基本命令

+ ```shell
  # 查看所有数据库  有几个默认的系统数据库
  show  dbs
  # 查看当前数据库 默认是test 只有里面有数据了 使用show dbs才能显示出来
  db
  # 切换到当前数据库 如果没有则创建
  use 数据库名称
  # 在mongodb中表的概念就是集合 创建一个表
  db.student   #db就代表当前数据库  没有则创建表student
  db.student.insertOne({"name":"lee"});
  # 显示当前db下的所有集合 可以理解为表
  show collections
  以上这些基本不用~
  
  # 往某一个数据库里的某一个集合里面导入数据
  mongoimport --db  test --collection student --drop --file data.json
  --db  test   哪一个数据库  
  --collection student  哪一个集合
  --drop 先把当前的集合清空
  --file data.json 导入的是哪一个文件 可以写路径
  ```

  ## 5.3 Mongoose （在node中操作mongodb数据库）

  + 使用mongodb官方提供的包

    |http://github.com/mongodb/node-mongodb-native|

    + 但是一般不用  太过于原生 麻烦 在实际开发不怎么用

### 5.2.1 使用mongoose来操作MongoDB数据库

+  这是第三方的东西 基于官网的mongodb包进行了进一步的封装
+  网址 http://mongoosejs.com
+  安装  npm install --save mongoose
+  mongoose的所有操作mongodb数据库的方法都支持Promsie then

### 5.2.2 mongodb基本概念

+ 数据库

+ 集合(数组) 相当于 mysql中的表

+ 文档 相当于mysql中的表记录

+ ```javascript
  就是一个对象而已
  {
      #相当于数据库
      aaa:{
          #相当于数据表
          aaa:[
              #相当于表记录
              {name:"age"} 
          ]
      }
              
  }
  ```

  

## 前置 - 增删改查

### 正经业务开发时会将模型进导出

```javascript
/* 1. 引包 */
let mongoose = require("mongoose");

/* 得到Schema */
let Schema = mongoose.Schema;

/* 链接你的数据库  这最后是一个数据库名称  不需要存在 如果不存在就会在你第一次进行添加数据的时候自动创建 */
mongoose.connect("mongodb://localhost/lee");

/* 创建数据结构 */
let userSchema = new Schema({
      name:{
          type:String,
          required:true,
          enum:[0,1], //取值范围只限于此 枚举类型
          default:0
      },
      password:{
          type:String,
          require:true
      },
      email:{
          type:String
      }
});

/* 生成对象模型  返回这个对应的users构造函数   传入一个大写的单数User mongoose会将其自动转换为小写的*/
module.exports =  mongoose.model("User",userSchema);  //导出供外部调用进行数据的操作
```



 ##### 前置

+ 得到 Schema 创建数据结构 然后在省城对象模型返回构造函数 实例化此构造函数进行传递参数格式要与数据结构的格式一致

 ```javascript
/* 1. 引包 */
let mongoose = require("mongoose");

/* 得到Schema */
let Schema = mongoose.Schema;

/* 链接你的数据库  这最后是一个数据库名称  不需要存在 如果不存在就会在你第一次进行添加数据的时候自动创建 */
mongoose.connect("mongodb://localhost/lee");

/* 创建数据结构 */
let userSchema = new Schema({
      name:{
          type:String,
          required:true
      },
      password:{
          type:String,
          require:true
      },
      email:{
          type:String
      }
});

/* 生成对象模型  返回这个对应的users构造函数   传入一个大写的单数User mongoose会将其自动转换为小写的
* 复数集合users  下来就可以为所欲为了
* */
let user  = mongoose.model("User",userSchema);

 ```



##### 增

```javascript
/* 实例化构造函数 就可以对这个构造函数进行操作了 */

let addUser = new user({
     name:"lee",
     password:"admin",
     email:"admin@admin.com"
});

/* 调用添加方法 */
/* res就是你刚刚插入进去的一条数据 */
addUser.save(function(err,res){
     if(err) return console.log("插入失败");
     if(res) return console.log("插入成功",res);
});
```

##### 查

+ 查询所有

+ ```javascript
  let user  = mongoose.model("User",userSchema);
  user.find(function(err,data){
       if (err) return console.log("查询失败");
       console.log(data);
  });
  ```

+ 按条件查询所有

+ ```javascript
  user.find({
      name:"lees"
  },function(err,data){
      if (err) return console.log("查询失败");
      console.log(data);
  });
  ```

+ 查询单个 / 按条件查询单个  并且的关系

+ ```javascript
  user.findOne({
      name:"lee",
      password:"admin"
  },function(err,data){
      if (err) return console.log("查询失败");
      console.log(data);
  });
  ```

  + 按条件查询 条件一成立 或者 条件而成立的记录

  + ```javascript
    user.find({
        $or:[
            {name:"leess"},
            {name:"lees"}
        ]
    },function(err,data){
          console.log(data);
    });
    ```

  + 

##### 删

+ 符合条件就删除 多个

+ ```javascript
  # user是返回的模型对象   let user = new Schema("User",userSchema);
  user.remove({
      name:"leessssssss"
  },function(err,data){
      if(err) return console.log("删除失败!");
      console.log(data);
  })
  ```

  + 根据查到的数据进行删除

  + ```javascript
    user.findOne({name:"lees"},function(err,data){
          if(err) return;
          data.remove();  //删除查到的数据
          console.log("remove success");
    });
    ```

    + 根据条件删除一个

    + ```javascript
      Model.findOneAndRemove(conditions,[options],[callback])
      ```

    + 根据id删除一个

    + ```javascript
      Model.findByIdAndRemove(conditions,[options],[callback])
      ```

##### 改

+ 根据ID修改

+ ```javascript
  user.findByIdAndUpdate('5bf6830e421e0e0e24df4b64',{
      password:'ad'
  },function(err,res){
        if(err) return console.log("更新失败");
      console.log(res,"更新成功!");
  });
  ```

### Mongoose  AND Mongodb 增删改查方法

```javascript
# 默认_id 就是一个索引   索引不能相同 一旦相同就会报错
db.集合名称.createIndex({"name":1}) //创建索引 查找会更快 但是添加的时候会稍微慢一点  1 代表升序排列
#分页查询   skip是当前页    limit 是一页显示多少数据
db.student.find().skip(5).limit(5)
#查询总数量
db.student.find().count()
#模糊查询  利用正则模糊查询  查询name里面包含abc的数据记录
Model.count().then(res=>{ res就是总量 })
Model.find({name:{$regex:/abc/}})
Model.find([callback])  //查找所有  mongoose
Model.insert({"name":"lee"}); //添加数据
db.集合名称.drop(); //删除集合 
Model.find([Paramobj],[callback]) //根据条件查询多个
Model.find({"age":20},[callback]); //精确单个条件
Model.find({"age":{$gt:30}},[callback]); //大于条件
Model.find({"age":{$lt:30}},[callback]); //小于条件
Model.find($or[{"name":"lee"},{name:"jack"}},[callback]); //或者条件
Model.find({"name":"lee","age":18}[callback]); //并且条件
Model.find().sort({"age":1}); //   1  代表升序   -1 代表降序 排序   这句话就是根据年龄升序排列
Model.findOne([条件-参数],[callback]); //根据条件查询单个  mongoose
Model.findById(id,[callback]); //根据di查找一条记录  mongoose
Model.remove([条件参数],[callback]); //根据条件移除  mongoose
Model.findOneAndRemove([条件参数],[callback]); //根据条件查找一个删除 mongoose
Model.findByIdAndRemove(id,[callback]); //根据id删除一个  mongoose
Model.update([条件参数],[要修改的内容],[callback]); //根据条件修改所有  mongoose
Model.findByIdAndUpdate(id,[要修改的内容],[callback]); //根据id修改单个 查询到的id室友问题的 不是加的有双引号就是有空格两边各一个 可以打印length测试  mongoose
Model.findOneAndUpdate([条件参数],[要修改的内容],[callback]); //根据条件修改单个  mongoose
#user就是生成的模型对象    let user = mongoose.model("User",userSchema); userSchema 是数据结构
let user = new User({name:"lee"});
user.save([callback]); //添加数据

```

## NodeJs操作Mysql

+ 安装 

+ ```shell
  npm install --save mysql
  ```

+ ```javascript
  let mysql = require("mysql");
  
  let connection = mysql.createConnection({
      host:"localhost",
      user:"root",
      password:"root",
      database:"book"
  });
  
  connection.connect();
  
  connection.query("SELECT * FROM books",function(error,results,field){
        if(error) throw error;
        console.log(results);
  });
  
  connection.end();
  ```
  


## 其他杂碎细节知识

### Path 核心模块

+ 基本API
+ path.basename(path,[option])   默认获取一个路径的文件名部分 加上第二个参数就是获取文件名不带后缀部分
+ path.dirname(path) 获取到路径的目录部分
+ path.extname(path) 获取到路径的扩展名部分
+ path.isAbsolute(path) 判断是否是绝对路径
+ path.parse(path) 是上面所有放啊的整合 返回一个对象
+ path.join(path1,path2,.......) 支持多个参数 自动拼接路径

### Node中的其他成员

+ `__dirname`  **动态获取** 获取到当前文件所属目录的绝对路径

+ `__filename`  **动态获取**获取到当前文件的绝对路径

+ 在node中 执行文件的相对路径就是在你执行node命令所处的路径

+ 但是引入模块的路径不受这个影响

  

## express默认提供了一个返回json格式字符串的方法

+ res.json({name:"lee"})

## MD5 加密包

npm install blueimp-md5

引入    let md5 = require("blueimp-md5");    导出的就是一个函数

使用     md5(字符串);

## express Session 中间件

+ 下载 npm install --save express-session

+ 引包 require("express-session")

+ 配置

+ ```javascript
  let express = require("express");
  let app = express();
  # 配置信息
  app.use(session({
      secret:"keyboard cat",
      resave:false,
      saveUninitialized:true
  }))
  ```

+ 使用

+ 当我们配置完毕后 就可以通过req.session来访问session   req,session是一个对象 可以添加多个属性

+ 添加数据 req.session.foo = "bar"

+ 获取数据 req.session.foo

+ 清除 req.session.foo = null 

## Express 中间件详解

+ 简单来说就是在程序运行中间的处理环节
+ 不限制与请求类型的中间件  app.use(function(req,res,next){  })
+ 中间件默认不会继续向下执行  除非调用了next() 方法就会继续执行下一个中间件
+ 限制匹配路径的中间件  app.use("/a",function(req,res,next){  })
+ 严格限制匹配路径的中间件 app.get(function(req,res){  });
+ 中间件的本质就是一个方法  用来进行处理请求

## 配置中间件

+ 同一个请求所只用的request对象和response对象是一样的

+ 处理404中间件  配置在app.use(router) 后面  有个顺序问题

+ 当所有请求都不匹配时会进入到此中间件

+ ```javascript
  app.use(function(req,res){
       res.render("404.html");
  });
  ```

+ 配置错误处理中间件 此中间件必须是四个参数 缺一不可

+ 当上面的中间件发生错误时通过next参数传递一个err对象 就会直接跳到错误处理中间件

+ 这个中间件也需要写在路由之后

+ ```javascript
  app.get("/",function(req,res,next){
      fs.readFile("adad",function(err,data){
          next(err) //会直接跳到错误处理中间件
      }) 
  });
  app.use(function(err,req,res,next){
      res.status(500).send(err.message); 
  });
  ```
  


## mddir自动生成目录结构树

要安装：npm install mddir   -D

为当前目录生成直接在cmd里面打命令   

### NodeJs 发送邮件

安装

npm install nodemailer --save 

