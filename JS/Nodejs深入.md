# 这里面的内容是为了更深入的了解NodeJs

## 获取到请求方法

+ req.method

## 设置响应状态  并且设置响应内容类型

+ res.writeHeader(200,{"Content-Type":"text/html;charset=utf-8"});

## 创建一个文件夹

+ fs.mkdir(url,callback); 

## 删除一个文件夹

+ fs.rmdir(url,callback)

## 删除一个文件

+ fs.unlink(url,callback());

## 修改文件名称与文件夹名称通用

+ fs.rename(oldPath,newPath,callback);
+ 可以修改在同一个文件夹下的文件
+ 如果老路径在第一个文件夹下而修改后的新路径在另一个文件夹下那么就会删除老路径下的文件 修改到新文件夹的下面

## 检测文件状态

+ fs.stat(url,callback[err,data]{ **data就是获取到的这个文件**
	data.isFile()  **判断是否是一个文件**
	data.isDirectory();  **判断是否是目录**
})

## 将查询字符串转为对象

+ let querystring = require("querystring"); 

+ querystring.parse("age=123&name=lee")

## 获取到并解析POST参数  默认接受的是二进制 toString() 后 是一个查询字符串 然后使用queryString 转换后是对象



      if(req.url === "/post" && req.method.toLowerCase() ==="post"){
         console.log("adad"+ req.method);


         var postData = "";
         
         /* 监听中post数据事件 */
         req.addListener("data",function(chunk){
    
             postData += chunk;
    
         });
    
         /* 监听结束 得到结果 */
         req.addListener("end",function(){
            
            req.body = queryString.parse(postData);
    
            console.log(req.body);  
    
         });	


         res.end("post run" + req.method); 


## 上传图片处理  

### 上传图片第三方模块    同时也能获取到post参数与上传的图片信息       

+ npm insatll --save formidable

+ 使用

  ```javascript
  
  let http = require("http");
  
  /* 引入 */
  let formidable = require("formidable");
    
  http.createServer(function(req,res){
  
       if(req.url === "/post" && req.method.toLowerCase() === "post"){
             
             /* 实例化  form 对象 */ 
  
             let form = new formidable.IncomingForm();
  
             /* 设置上传到的路径 */
           
             form.uploadDir = "./uploads";
   
             /* 上传结束调用此方法得到回调结果 err 是错误对象 fields 是普通的输入框内容 files是上传                的文件内容是一个对象 */
           
             form.parse(req,function(err,fileds,files){
  
                  if(err) throw err; 
  
             });
  
             res.writeHeader(200,{"Content-Type":"text/html;charset=utf-8"});
  
             res.end("进来了POST请求!");	
  
       }
  
  }).listen(3000,function(){
  	console.log("running ........");
  });
  ```

  

## 获取到图片上传的绝对路径

```javascript
function getObjectURL(file) {
    let url = null;
    if (window.createObjcectURL != undefined) {
        url = window.createOjcectURL(file);
    } else if (window.URL != undefined) {
        url = window.URL.createObjectURL(file);
    } else if (window.webkitURL != undefined) {
        url = window.webkitURL.createObjectURL(file);
    }
    return url;
}


/* 调用 设置 */
$("#file").change(function(){
        let file = this.files[0];
        let url = getObjectURL(file);
        $("#img").attr("src",url);
    });
```
## EJS模板引擎

+ 下载安装

+ ```shell
  npm install --save ejs	
  ```

+ 使用

+ ```javascript
  /* ejs 模板引擎 */
  
  /* 引入 */
  let ejs = require("ejs");
  
  let str = "大家好我是<%= name %>   <% for(let i = 0 ; i < 5 ; i ++){  %>  大家好哦  <% } %> ";
  
  let data = {
      name:"lee"
  }
  
  /* 调用 返回一个模板字符串 */
  console.log(ejs.render(str,data));
  ```

## express框架中使用 ejs

```javascript
let express = require("express");
let app = express();
//代表的意思是使用的模板引擎是ejs 这时候路由的res上面就多了一个render属性
//不需要手动引入ejs 配置了这一句就会自动去找
app.set("view engine","ejs")

app.get("/",function(req,res){
    默认是去views目录下面找
    res.render("index.ejs",{
        name:"lee"
    }); 
});
```



## 请求 Router

app.all("/adad",function(){})   //会处理您的任何请求

url可以使用正则表达式(分组) 然后通过req,params[0] 获取

app.get("/student/:id",function(req,res){

​          // :id 就是可以当做是一个变量吧  可以动态传进来  通过  res.params['id'] 获取  或者 res.params.id  

})

```
# 通过正则匹配  通过请求对象的request 独享的params属性获取是个数组 下标对应分组的个数
app.get(/^\/(\d{4})(\w{3})$/,function(req,res){
       res.end(req.params[0] + "---" + req.params[1]);
});
```
## Cookie

+ 通过下载中间件  cookie-parser 来实现cookie的使用

+ req 对象上的cookie用来获取  res 对象上的cookie用来设置

+ 第一次访问请求头不会有cookie 而响应头会进行设置 在第二次访问的时候就会有了

+ ```javascript
   # 使用方法
   # 安装
   npm install --save cookie-parser
   ```
  #使用
   const cookieparser = require("cookie-parser"); 
   app.use(cookieparser());

  app.get("/",function(req,res){
        //maxAge 是时间 毫秒为单位
        res.cookie("name","46798",{maxAge:9000});
        res.send(req.cookies.name);
  })
  ```

## MD5 校验   通常用来比对两个文件版本是否一致

## 图片处理  GM

官网   http://www.graphicsmagick.org

如果服务器需要处理图片就要装这个软件 	graphicsmagick 

免费的

如果在linux服务器 需要下载linux版本的

下载完毕后配置环境变量  找到安装目录到gm.exe目录   编辑path环境变量  将路径添加进去

win7 加载最后面 前面加上一个 ; 号  用以和前面的内容区分开来

在cmd里输入gm即可运行gm.exe   提供了一些命令用来处理图片

​```javascript
GraphicsMagick图像处理系统使用方法
**显示图像文件详细信息** 
gm identify a.jpg 
gm identify -verbose filename.jpg 详细信息 
1.更改当前目录下*.jpg的尺寸大小，并保存于目录.thumb里面 
gm mogrify -output-directory .thumbs -resize 320x200 *.jpg

             -output-directory .thumbs可以不写就是当前文件夹  .thumbs 可以修改就是个文件夹

将三幅图像和并为一副图像 
gm montage -mode concatenate -tile 3x1 image1.ppm image2.ppm image3.ppm concatenated.miff 
将目录下面所有头像转为100x100拼接上下左右留5像素 
gm montage -geometry 100x100+5+5 -bordercolor red *.jpg out.jpg 
以1为背景付上2然后输出 
gm montage -texture 1.jpg 2.jpg out.jpg 
吧图片命名并拼接 
gm montage -geometry 100x100+2+2 -bordercolor black -label “111” 1.jpg -label “222” 2.jpg out.jpg

把123三张图片裁剪成100x100拼接成2x2方正中间留2像素 
gm montage +frame +shadow +label -tile 2x2 -geometry 100x100+2+2 1.jpg 2.jpg 3.jpg out.jpg

显示图像 
gm display ‘vid:*.jpg’

格式转换 
gm convert a.bmp a.jpg 
gm convert a.bmp a.pdf（转换为pdf)

调整图像dpi和大小 
gm convert -density 288 -geometry 25% image.gif image.gif 
（缩小为原先的1／4，并且dpi为288）

gm convert -resize 640x480 image.gif image.gif 
（转换为640x480的图像)

在图像上添加文字 
gm convert -font Arial -fill blue -pointsize 18 -draw “text 10,10 ‘your text here’” test.tif test.png 
加文字水印，指定字体、字体大小、颜色、位置 
gm convert -font ArialBold -pointsize 45 -fill red -draw “text 100,100 www.saysth.com” input.jpg output.jpg 
加图片水印至右下角，透明度50% 
gm composite -gravity southeast -dissolve 50 watermark.png input.jpg output.jpg 
加图片水印至制定位置，透明度50% 
gm composite -geometry +50+50 -dissolve 50 watermark.png input.jpg output.jpg
-gravity 位置参数 NorthWest 左上角, North 上面, NorthEast 右上角, West 左, Center 中,East右, SouthWest左下 , South下, SouthEast 右下

从gif文件中抽取第一帧 
gm convert “Image.gif[0]” first.gif

建立gif图像 
gm convert -delay 20 frame*.gif animation.gif 
gm convert -loop 50 frame*.gif animation.gif 
（让动画循环50次）

gm convert -delay 20 frame1.gif -delay 10 frame2.gif -delay 5 frame3.gif animation.gif 
（对每一帧手动指定延时）

截屏 
gm import a.jpg 
用鼠标点击所要截取的窗口，或者选择截屏区域，保存为a.jpg
gm import -frame a.jpg 
保留窗口的边框

GraphicsMagick常用管理命令
查看版本后安装情况：gm identify -version 
结果：：打印出信息

识别图片：gm identify /Users/zhaorai/Pictures/照片/100CANON-1/IMG_4108.JPG 
结果：/Users/zhaorai/Pictures/照片/100CANON-1/IMG_4108.JPG JPEG 3648x2736+0+0 DirectClass 8-bit 2.5M 0.000u 0:01

识别图片(高级)：gm identify -verbose /Users/zhaorai/Desktop/4.png 
结果：打印出很多信息。

GraphicsMagick缩放比例的精准控制
原始图片是input.jpg，尺寸：160x120

只缩小不放大 
gm convert input.jpg -resize “500x500>” output_1.jpg 
加了>,表示只有当图片的宽与高，大于给定的宽与高时，才进行“缩小”操作。 
生成的图片大小是：160x120，未进行操作 
如果不加>,会导致图片被比等放大。

等比缩图 （缺点：产生白边） 
gm convert input.jpg -thumbnail “100x100” output_1.jpg 
生成的图片大小是：100x75

非等比缩图，按给定的参数缩图（缺点：长宽比会变化） 
gm convert input.jpg -thumbnail “100x100!” output_2.jpg 
生成的图片大小是：100x100

裁剪后保证等比缩图 （缺点：裁剪了图片的一部分） 
gm convert input.jpg -thumbnail “100x100^” -gravity center -extent 100x100 output_3.jpg 
生成的图片大小是：100x100，还保证了比例。不过图片经过了裁剪，剪了图片左右两边才达到1:1

填充后保证等比缩图 （缺点：要填充颜色，和第一种方法基本一样） 
gm convert input.jpg -thumbnail “100x100” -background gray -gravity center -extent 100x100 output_4.jpg 
生成的图片大小是：100x100，还保证了比例，同时没有对图片进行任何裁剪，缺失的部分按指定颜色进行填充。 
gm convert -quality 100% f150ceb33dc7.jpg -thumbnail 401x401 -background gray -gravity center -extent 401x401 test1.jpg

裁剪、填充相结合 （缺点：最差的方法） 
gm convert input.jpg -thumbnail “10000@ -background gray -gravity center -extent 100x100 output_5.jpg 
生成的图片大小是：100x100，这次保证了大小和比例，其中的10000就是100x100的乘积，同时在填充和裁剪之间做了一个平衡。

位深度32 转为24 
IE6,7,8不支持显示“位深度32”的图片，但IE9、火狐、谷歌浏览器就可以显示。 
使用GM,把“位深度32”的图片转换为“位深度24”的图片 
输入图片zzz.jpg就是“位深度32”的图片，输出图片 zzz_out.jpg就是“位深度24”的图片 
gm convert -resize 100x100 -colorspace RGB zzz.jpg zzz_out.jpg 
转完后，图片的颜色会有轻微变化。

在浏览器上选择图片裁剪的坐标
如果想让用户手动裁剪头片的话，就是在浏览器上选择图片裁剪的坐标，imgAreaSelect是个好选择。 
imgAreaSelect is a jQuery plugin for selecting a rectangular area of an image. 
http://odyniec.net/projects/imgareaselect/

======================其它内容=================================

Jmagick锐化图片功能
ImageInfo info = new ImageInfo(filepath+”pics.jpg”); 
MagickImage image = new MagickImage(info); 
MagickImage sharpened = image.sharpenImage(1.0, 5.0); 
sharpened.setFileName(filepath+”sharpened.jpg”); 
sharpened.writeImage(info); 
主要是函数sharpenImage(double arg0, double arg1); 
建议arg0=1.0 arg1=5.0 
arg0为半径 arg1为阙值 
这样做的目的： 
明显会使图片变得清晰好看。

JMagick 常用技巧
ImageMagick中使用+profile “*” 删除图片中不存储附加信息. 
JMagick中,使用MagickImage类上的profileImage(“*”, null)方法,删除图片中不存储附加信息. 
删除图片中的ICC,ICM, IPTC,8bim等信息 
ImageMagick中使用-quality控制图片的品质, 
JMagick中,使用ImageInfo类上的setQuality(80)方法,控制图片的品质
--------------------- 
作者：努力一方 
来源：CSDN 
原文：https://blog.csdn.net/yufei6808/article/details/50897786 
版权声明：本文为博主原创文章，转载请附上博文链接！
  ```

## NodeJs 使用此图像处理

npm 搜索   gm    

安装  npm  install  --save gm

引包  const gm = require("gm")

具体api可以在npm上搜索gm进行查看

依赖fs模块  需要先引入fs模块

```
/* nodejs 缩略图 */

gm("./cc.jpg")
    .resize(150,150,"!")   加上叹号就是强行裁切到150*150的大小
    .write("./cc1.jpg",function(err){
        if(err){
            console.log(err);
        }
    });
    
/* 头像裁剪  并且强行设置大小 可以不用设置resize*/
gm("./cc.jpg").crop(w,h,x,y).resize(100,100,"!").write("./cc1.jpg",function(err){});
```

## WebSocket 长链接协议

#### 聊天室

+ http 协议是无状态的 想要实现实时应用非常的不方便   服务器无法主动的将最新消息发送至客户端只有每当受到客户端请求的时候才会进行响应最新的数据
+ **长轮询**   以前的实现方法
  + 客户端每隔很短时间，都会对服务器发出请求查看是否有新的消息 ，只要轮询速度够快 就能给人造成交互是实时进行的印象 这种做法是无奈之举 实际上对服务器 客户端都造成了大量的性能 浪费
+ 长连接
+ 客户端值请求一次 但是服务器会将连接保持 不会返回结果 服务器有了新数据就将数据发过来，又有了新数据就将数据发送过来而一直保持挂起状态，这种做法也造成了大量的性能浪费

## websocket 概念

+ 是一个协议   全双工的实时通信
+ 利用http请求产生握手  http头部中包含有webscoket协议的请求 所以握手之后 二者就转用TCP协议进行交流了(qq的协议)  那么之后就是qq和qq服务器的关系了

### websocket 支持

+ 使用webscoket的话需要浏览器和服务器支持的
+ 浏览器 Chrome4 火狐4 IE10 Safari5
+ 服务器 Node 0  Apache 7.0.2 Nginx 1.3 
+ NodeJs 需要处理scoket协议的话需要进行一些处理 使用的tcp模块  但是从底层一点一点写很费劲

### Socket.IO

+ 屏蔽了所有底层细节 让顶层调用非常的方便  并且还为不支持webscoket协议的浏览器提供了 长轮询的透明模拟机制

### Socket io 使用

+ https://socket.io 官网

+ npm 安装

+ ```shell
  npm install --save socket.io
  ```

+ **起步使用**

+ ```javascript
  /* 先创建http服务实例  */
  const http = require("http");
  
  const Server = http.createServer(function(req,res){
        res.end("hello lee");
  });
  
  # 引入io之后得到的是一个函数 后面传递的是参数就是http服务器实例
  const io = require("socket.io")(Server)
  
  Server.listen(3000,"127.0.0.1");
  ```

+ **当我们引入socket.io时在地址栏就有一个隐藏的客户端socket.io.js 文件**

+ http://localhost:3000/socket.io/socket.io.js

+ 我们可以在network面板中看到type为websocket的请求

### 使用

```javascript
 #  服务端代码 
 
 /* 先创建http服务实例  */
const http = require("http");
const fs = require("fs");

const Server = http.createServer(function(req,res){
     if(req.url == "/"){
        fs.readFile("./index.html","utf8",function(err,data){
            if(err){ return res.end("error") }
            res.end(data);
        });
     }
  
});
 
/* 引入socketIo 的得到的是一个函数参数是http服务器实例  */
const io = require("socket.io")(Server)

/* 监听客户端连接  但时此时并不可以打印出里面的内容 是需要进行一些html5的配置
*  在客户端进行配置  有一个隐藏地址是一个js文件 里面已经帮我们配置好了 我们直接用就好了
*   客户端和服务端都有都有socket对象  
*   都有emit方法 用以发送自定义事件   和on方法用于接收事件
*   当客户端使用socket.emit发送一个自定义事件的话服务端使用socket.on接受
*   当服务端使用socket.emit响应一个自定义事件的话客户端使用socket.on接受
*   很神奇
*/
io.on("connection",function(socket){
    console.log("一个客户端连接了");
    /* 由于这里的socket是在回调里面的 所以我们需要在回调里面进行书写代码  */
    /* 这里监听的事件就是客户端发送过来的自定义事件  */
    /* io.broadcast.emit()  是广播消息  一对多的  所有人都能看到 */
    /* socket对象是一对一的 每进来一个客户端就进行一次连接 一个socket对象就是一个用户 */
    socket.on("start",function(msg){
        console.log("客户端的信息是" + msg);
    });
    /* 服务端响应 创建自定义事件 回复 socket 是一对一的 */
    // socket.emit("huifu","我知道了你是李文祥");
    /* 广播  所有人都能看到  */
    io.emit("huifu","我知道了你是李文祥");
    
      // 使用 emit 发送消息，broadcast 表示 除自己以外的所有已连接的socket客户端。
       socket.broadcast.emit("receiveMsg",data);
    
    socket.on("disconnect",function(){
    console.log("用户断开了链接");
    });
})



Server.listen(3000,"127.0.0.1");

# 客户端代码

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>聊天室</title>
</head>
<body>
    <h1> 我是一个首页 引用了秘密Socket文件 </h1>
    
    
    <!--  创建一个页面  这个页面必须在服务器启动的时候才能测试 不能直接在客户端启动  引包   相对于绝对路径 -->
    <script  src="/socket.io/socket.io.js" ></script>
  
    <script>
    
    /*   得到上面文件暴露出来的io函数得到socket对象 必须调用 服务端才能监听到客户端的链接  */
    
    let socket = io();
    
    socket.emit("start","我是李文祥");
   
    /* 客户端接受服务端的回复 */
    socket.on("huifu",function(msg){
        
          console.log("服务器回复的数据是" + msg);

    });
    </script>

</body>
</html>   
```

## Express 与 socket.io

+ **基本设置**

+ ```javascript
  /* 引入express  与 socket io 配合使用需要两句固定的语法  */
  const express = require("express");
  const app = express();
  //引入http模块  调用Server函数传入app
  const http = require("http").Server(app);
  //引入Socket包 调用函数传入http服务器实例
  const io = require("socket.io")(http);
  
  app.engine("html",require("express-art-template"));
  
  app.get("/",function(req,res){
       res.render("index.html");  
  });
  
  //使用http监听端口
  http.listen(3000);
  
  ```

+ 设置的昵称一般用session存储当前登录用户 可以设置个内存数组存储用户名坐一个临时判断是否有此用户

+ 实现实时画图 利用canvas  io.emit("aaa",{})  可以是对象可以是数组

  ### Socket Io 运用

+ ```javascript
  io.on("connection",function (socket) {
  
        count++;
  
        console.log("新链接");
  
      // socket.io 使用 emit(eventname,data) 发送消息，使用on(eventname,callback)监听消息
  
      //监听客户端发送的 sendMsg 事件
  
      socket.on("sendMsg",function (data) {
  
            
  
          // data 为客户端发送的消息，可以是 字符串，json对象或buffer
  
          // 使用 emit 发送消息，broadcast 表示 除自己以外的所有已连接的socket客户端。
  
          socket.broadcast.emit("receiveMsg",{data,count});
  
      })
  
      socket.on("disconnect",function(){
  
        count--;
  
        console.log("用户断开了链接");
  
        });
  
  });
  
  ```

+ 

### 跨域

##### get -- jsonp

前台使用jsonp格式访问即可  有个构造函数

app.get("/getdata",(req,res)=>{

​    res.send(req.query.callback +"(" + JSON.stringify([{id:2,name:"lee",age:19},{id:1,name:"jack",age:18},{id:3,name:"not",age:18}]) + ")")

});

 ##### post get ...... n种

安装  npm install --save cors

const cors = require('cors') 

app.use(cors()) 

## Cors 跨域

使用express的话setHeader换成header    app.all("*",function(){    //头信息      })

```js
app.all('*', function(req, res, next) {
    res.header("Access-Control-Allow-Origin", "*");
    res.header("Access-Control-Allow-Headers", "X-Requested-With,Content-Type");
    res.header("Access-Control-Allow-Methods","PUT,POST,GET,DELETE,OPTIONS");
    res.header("X-Powered-By",' 3.2.1');
    res.header("Content-Type", "application/x-www-form-urlencoded");
    next();
});
```



也可以直接引入cors

> npm install cors

```
//app.js
var cors = require('cors');
app.use(cors());
```

# 二、Vue中使用socket.io

+ 安装  Vue-socket.io   npm install --save vue-socket.io

+ 私聊思路

+ ```
  //建立websocket连接之后，客户端首先设置一下
  // 自己的用户名，服务器端将用户名和socket.id的对应
  // 关系保存，当客户端A向B发送私聊信息时，需要带上客户端B的用户
  // 名。我们通过B的用户名，解析得到客户端B的socket.id，从socket集合中获取响应
  // 的socket，然后再发送消息。
  ```

+ 客户端

+ ```
  // The Vue build version to load with the `import` command
  // (runtime-only or standalone) has been set in webpack.base.conf with an alias.
  import Vue from 'vue'
  import App from './App'
  import VueSocketio from 'vue-socket.io';
  
  Vue.use(new VueSocketio({
    debug: true,
    connection: 'http://localhost:3000',
    vuex: {
      actionPrefix: 'SOCKET_',
      mutationPrefix: 'SOCKET_'
    }
  }));
  
  
  
  
  Vue.config.productionTip = false;
  
  /* eslint-disable no-new */
  new Vue({
    el: '#app',
    router,
    sockets: {
      //不能改,j建立连接自动调用connect
      connect: function () {
        //与socket.io连接后回调
        console.log("socket connected");
      },
      sendMsg:function(data){
        console.log('这个方法是由套接字服务器触发的。例如：io.emit（"sendMsg"，data)',data);
      }
    },
    components: { App },
    template: '<App/>'
  })
  ```



+ 服务端

+ ```
  /* 引入express  与 socket io 配合使用需要两句固定的语法  */
  const express = require("express");
  
  const app = express();
  //引入http模块  调用Server函数传入app
  const http = require("http").Server(app);
  //引入Socket包 调用函数传入http服务器实例
  const io = require("socket.io")(http);
  
  let sockets = [];
  let i = 0 ;
  io.on("connection",function (socket) {
  
      // Socket  唯一ID
      console.log("新链接",socket.id);
      sockets.push(socket);
  
      // socket.io 使用 emit(eventname,data) 发送消息，使用on(eventname,callback)监听消息
  
      //使用 emit 发送消息，broadcast 表示 除自己以外的所有已连接的socket客户端。
      // io.broadcast.emit("customEmit","ok");
      socket.on("Msg",function (data) {
  
          // data 为客户端发送的消息，可以是 字符串，json对象或buffer
  
  
          //  只有目标方会看到  利用自己存储的Socket进行发送
          console.log(data);
          setInterval(function () {
              sockets[data].emit("sendMsg",data);
          },1000)
  
      })
  
      socket.on("disconnect",function(){
          console.log("用户断开了链接");
  
      });
  
  });
  
  //使用http监听端口
  http.listen(3000);
  ```
  ## 在Nuxt中使用SocketIo 的话 再开一个服务器  然后客户端监听放到使用那个组件里 就是sockets这一串 原先在Vue实例的

  

  ```javascript
  
      document.getElementById("btn").onclick=function(){
  
          var reader = new FileReader();
  
          var AllowImgFileSize = 2100000; //上传图片最大值(单位字节)（ 2 M = 2097152 B ）超过2M上传失败
  
          var file = document.getElementById("image").files[0];
  
          var imgUrlBase64;
  
          if (file) {
              //将文件以Data URL形式读入页面
              imgUrlBase64 = reader.readAsDataURL(file);
  
              reader.onload = function (e) {
                  //var ImgFileSize = reader.result.substring(reader.result.indexOf(",") + 1).length;//截取base64码部分（可选可不选，需要与后台沟通）
                  if (AllowImgFileSize != 0 && AllowImgFileSize < reader.result.length) {
                      alert( '上传失败，请上传不大于2M的图片！');
                      return;
                  }else{
                      //执行上传操作
                      document.getElementById("img").src = reader.result;
                      console.log(reader.result);
                  }
              }
          }  }
  ```


