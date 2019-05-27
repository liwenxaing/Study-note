# Koa学习笔记
## 安装 以及 使用
 1. 首先需要安装nodejs
 2. 必须高于 v7.6 才能完全支持 koa2
 3. npm install --save koa
 4. const koa = require('koa')
    const app = new koa()
    app.use(async (ctx)=>{
        ctx.body = "hello koa2"
    })
    app.listen(3000)
## 参数以及中间件
 1. app.use(async (ctx)=>{
         ctx.body = "hello koa2"; // 就相当于返回数据了 等于 express 的 res.send()
    });   
## 路由
 1. 和 express 中的路由有所不同
 2. 我们需要安装对应的路由模块   koa-router
    1. cnpm install --save koa-router 
 3. 使用路由
      const  router = require('koa-router')();
      // 配置路由
      router.get("/",(ctx)=>{
          ctx.body = "这是首页";
      }).get("/news",(ctx)=>{
          ctx.body = "这是新闻页面";
      }).get("/newsContent",(ctx)=>{
          ctx.body = "这是新闻内容页面";
      });
      //启用路由  配置  不配置不能使用路由
      app.use(router.routes());
      app.use(router.allowedMethods());       
   4. 里面的ctx包含了 request 和 response koa 将其归纳成一个了 
## 路由动态参数 以及 get查询字符串
   1. 查询字符串通过 ctx.query.xxx 获取 获取到的使一个对象
   2. 查询字符串通过 ctx.queryString 获取  获取到的手使查询字符串本身
   3. 查询字符串通过 ctx.request.query 获取  获取到的使一个对象
   4. 查询字符串通过 ctx.request.queryString 获取 获取到查询字符串本身
   5. 动态路由 在 路径后面加上 /:id 即可
   6. 获取的时候 通过 ctx.params.xxx 获取即可
## 中间件
   1. 应用级中间件
      1. app.use(async (ctx,next)=>{ // 匹配所有请求 await next() })   
   2. 路由级中间件
      1. app.use("/news",async (ctx,next)=>{ await next() 继续匹配 }) 
   3. 错误处理中间件
      1. app.use((ctx,next)=>{ 
            next()
            if(ctx.status == 404){
               ctx.body = "这是一个404页面";
            }else{
               console.log(ctx.url); 
            }
            })
   4. 第三方中间件
      1. 就是use第三方包的
   5. 执行顺序
      1. 在koa中 app.use() 总是最先执行的 无论放在上下面    
      2. 并且不能够使用app.use匹配路由 只能当做中间件使用
## ejs 模板引擎
   1. 在 koa 中使用 ejs 的话首先要安装一个 koa-views 第三方库 
      1. cnpm install --save koa-views 
   2. 安装ejs
      1. cnpm install --save ejs
   3. 引入 使用
      1. const views = require('koa-views');
      **配置**
      2. app.use(views(__dirname + '/views',{map:{html:'ejs'}}))      后缀名称为 html
      3. app.use(views(__dirname + '/views',{extension:'ejs'}))       后缀名称为 ejs  
      **使用**
      4. app.get('/',async (ctx)=>{
          **表示渲染views目录下面的index页面**
          await ctx.render('index.ejs',{name:'LiWenXiang'})
      })   
   4. 在使用render前有必要使用await修饰一下 否则有可能获取不到传递过去的值
      **ejs简单语法**
   1. 输出  <%=title %>   输出但不会解析html字符串 <%-htmlStr %>
   2. 循环  <% for(let i = 0 ; i < 10 ; i++) { %>  <%=i %>  <% } %>           
   3. 引入模块 <% include public/header.html %>
   4. 判断  <% if(1<2){ %> **if内容** <% }else if(3>2){ %> **else if 内容** <% }else{ %> **else内容** <% } %>
   5. 所有模板共享数据  
      **使用**
      添加一个应用级中间件  设置  ctx.state = { sessionName:"共享的数据session" }
      接下来在每一个模板里面都可以使用ejs语法使用了 要注意的使要继续向下匹配路由 前面加上 await
      *例如*
        <%=sessionName%>
## 处理 post Request   koa-bodyParser
   1. 安装
      cnpm install --save koa-bodyparser
      **配置 以及  使用**
      const bodyparser = require("koa-bodyparser");
      app.use(bodyparser()) 
      **获取**
      ctx.request.body  
## 访问静态资源
  1. 安装  koa-static
  2. cnpm install --save koa-static 
  3. let static = require('koa-static')
    **使用**
    app.use(static(path.join(__dirname,"static")));  //访问静态资源 从static下面开始找    
    访问例子： 目标文件路径  ./static/css/index.css 
            实际访问路径  css/index.css 即可  因为默认从static里面进行查找      
## art-template 模板引擎  更加的快速            
  1. 安装 cnpm install --save art-template koa-art-template
  2. 引入 const render = require('koa-art-template')
  3. render(app,{
        root:path.join(__dirname,"views"),  //访问的目录
        extname:".art",   // 后缀名称 
        debug:process.env.NODE_ENV !== 'production'  // 是否开启调试模式
     }) 
     配置完就可以使用了 await ctx.render("index",{});
## cookie
  1. 24*60*60*1000 一天的毫秒数
  2. ctx.cookies.set('username','lee',{ maxAge:24*60*60*1000 })  设置cookie一天后过期
  3. ctx.cookies.get('usernames');    
  4. 在koa中cookie不能直接设置cookie
  5. 通过Buffer来设置中文 先转成base64格式的
     1. new Buffer('张三').toString("base64"); 编码
     2. new Buffer("5byg5LiJ",'base64').toString(); 解码 
## session
  1. 安装 koa-session
  2. command :  cnpm install --save koa-session      
  3. 配置信息
     1. app.keys = ['some secret hurr'];  // Cookie的签名
        const CONFIG = {
              key:'koa:sess',
              maxAge:86400000,
              overwrite:true,
              httpOnly:true,
              signed:true,
              rolling:false, 每次访问的时候都重新设置cookie
              renew:true     快过期的时候重新设置 cookie
        };
        app.use(session(CONFIG,app));
  4. setter and getter session 
     1. ctx.session.username  = "lee";
     2. ctx.session.username 
## es6 单例
`  class Person{
       constructor(){
           console.log("构造器");
           this.connect();
       }
       connect(){
           console.log("链接数据库")
       }
       find(){
           console.log("查找数据库");
       }
       static getInit(){
            if(!Person.init){
                Person.init = new Person();
            }
            return  Person.init;
       }
   } `
  1. 通过 静态方法 在里面进行判断 是否存在某一个静态属性 不存在证明是第一次 则进去实例化 否则就直接返回 不直接实例化构造器
## Mongodb数据库
  1. 基于官网的 node-mongodb-nvtive 封装一个更小更快更灵活的库
  2. 原生nodeJs操作mongodb数据库
     1. 安装  cnpm install --save mongodb
     2. 引入 使用
     
     *  nodeJs 原生操作 mongodb 数据库
     
     // 引入包
     const mongodb = require("mongodb");
     
     // 链接客户端
     let mongoClient = mongodb.MongoClient;
     
     //设置链接地址
     const url = "mongodb://127.0.0.1:27017";
     
     //设置链接的数据库名称
     const dbName = "koa";
     
     // 链接数据库
     mongoClient.connect(url,(err,client)=>{
     
      if(err) return err;
     
      设置数据库  返回个db对象
      let db = client.db(dbName);
     
      增加一条数据
      db.collection('koas').insertOne({name:"nick",age:20,price:3000},function(err,result){
              if(!err){
                  console.log("增加成功");
              }
      });
     
      db.collection('koas').update({'name':'nick'},{$set:{'name':'liwenxaing'}},function(err){
             if(!err){
                 console.log("修改成功")
             }
      });
     
      查询数据
      let result = db.collection("koas").find();
     
      docs 就是查询到的数据
     
      result.toArray((err,docs)=>{
              console.log(docs);
      });
         
      修改数据
         db.collection("koas").update({name:"liwenxiang"},{$set:{name:"刺激"}},(err,result)=>{
              console.log(result.result.ok);
      });
     
      删除数据
         db.collection("koas").removeOne({price:1000},(err,result)=>{
              console.log(result);
      })
         
      client.close();
     
     });   
     
## 路由模块化
  1. 将每一个模块的业务封装为一个router文件 最后将router 导出即可
  2. app.js 文件将 导出的router进行启用就好了 挂载到 app对象上  
  3. 每一个模块都需要引入路由模块  koa-router  最后在导出           