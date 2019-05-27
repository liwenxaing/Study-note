## VueSSR笔记

## 安装依赖

`npm install vue-server-renderer --save`

`npm install vue --save`

## 初步代码实现

```javascript
//第一步
const Vue = require("vue")
const app = new Vue({
    template:"<div>HelloWorld</div>"
})
//第二步
const renderer = require("vue-server-renderer").createRenderer();
//第三步  将Vue实例渲染为html
renderer.renderTostring(app,(err,html)=>{
     //是异步操作 
});


//实操
const Vue = require("vue");
const renderer = require("vue-server-renderer").createRenderer();
const express = require("express");
const server =  express();

server.get("*",(req,res)=>{
    renderer.renderToString(app,(err,html)=>{
        if(err) return;
        res.send(html);
    })
});

server.listen(3000);

let app = new Vue({
    template:`<div> 
<h1> Hello  Vue Ssr !</h1>
</div>`,
    data:function(){
        return {

        }
    }
});



```

## Vue服务端渲染是需要webpack配合

+ 但是配置一个完整的webpack服务端配置是很费劲的
+ Vue官方给我们配置好了
+ 网址   https://github.com/vuejs/vue-hackernews-2.0
+ 下载完毕之后呢 npm install 安装所有依赖
+ 就可以开始进行开发啦

## NUXT

### npx

npm v5.0.0 引入了一条命令npx 引入这个命令的目的是为了提升开发者使用包内提供的命令行工具的体验

避免了全局安装脚手架

### 创建一个工程

官网  https://zh.nuxtjs.org/

npx在NPM5.2.0之后已经默认安装了 之前没有安装

创建一个项目  直接不用安装脚手架了 直接可以创建

`npx create-nuxt-app helloNuxt[工程名称]`   

会询问你使用什么node框架  Ui框架  axios 等等.....

`npm run dev`    启动项目

## 从头开始新建项目

如果不使用 Nuxt.js 提供的 starter 模板，我们也可以从头开始新建一个 Nuxt.js 应用项目，过程非常简单，只需要 *1个文件和1个目录*。如下所示：

```
$ mkdir <项目名>
$ cd <项目名>
```

**提示:** 将 `<项目名>` 替换成为你想创建的实际项目名。

### 新建 package.json 文件

`package.json` 文件用来设定如何运行 `nuxt`：

```
{
  "name": "my-app",
  "scripts": {
    "dev": "nuxt"
  }
}
```

上面的配置使得我们可以通过运行 `npm run dev` 来运行 `nuxt`。

### 安装 `nuxt`

一旦 `package.json` 创建好， 可以通过以下npm命令将 `nuxt` 安装至项目中：

```
npm install --save nuxt
```

### pages 目录

Nuxt.js 会依据 `pages` 目录中的所有 `*.vue` 文件生成应用的路由配置。

创建 `pages` 目录：

```
$ mkdir pages
```

创建我们的第一个页面 `pages/index.vue`：

```
<template>
  <h1>Hello world!</h1>
</template>
```

然后启动项目：

```
$ npm run dev
```

现在我们的应用运行在 [http://localhost:3000](http://localhost:3000/) 上运行。

注意：Nuxt.js 会监听 `pages` 目录中的文件更改，因此在添加新页面时无需重新启动应用程序。

了解更多关于Nuxt.js应用的目录结构： [目录结构](https://zh.nuxtjs.org/guide/directory-structure)。

## 目录结构

asset 存放less sass javascript库 的静态文件

components  存放vue单文件组件

layouts  页面的整体布局  文件名不可修改

middleware 中间件

pages  存放页面

plugins 存放插件

server  存放服务器文件

static  存放静态文件 不会自动调用webpack进行编译处理  开放的静态文件资源 可以直接访问

store 存放vuex状态树

nuxt.config.js 名字不可以修改 用来修改nuxt的配置  以覆盖默认的配置

package.json 包描述文件

## 服务器配置

nuxt.config.js

如果要使用sass就必须安装node-sass sass-loader

npm install --save-dev node-sass sass-loader

### 配置css  是全局生效的

 css: [

​    'element-ui/lib/theme-chalk/index.css',

​    '@/assets/css/style.scss' //找到asset目录下的css目录下的style.scss 全局生效

  ]

## 路由

layouts  下面的 default.vue 可以理解为 Vue里面的App.vue 就是根试图  pages里面就是每一个页面组件

nuxt中没有路由的配置文件 nuxt会自动读取文件目录结构进行生成对应的路由

使用 \<nuxt-link to="/"\> 首页 \</nuxt-link\> 进行路由的跳转

使用 \<nuxt/\> 进行一个试图的显示    于 Vue中的 routerView一样

在Nuxt中路由是根据我们创建的文件夹进行区分的 文件夹名字就是路由的名字

实现动态路由的话需要在vue文件前面加上_下划线 下划线后面的路由名称就是参数名称

获取参数和Vue一样通过 $route.params.你的动态路由名称

实现父子路由的话需要有一个vue文件和一个文件夹同级并且名字相同

例如

-- user.vue  父路由

-- user          子路由

​    -- profile.vue

​    -- _id  动态路由

生成的路由就是    /user/profile

动态路由实例   /user/13    跳过去可以直接获取到了  13 就是 _id 这个页面并且包括id

如果子组件里面有动态路由的话 可能会产生跳转的干扰  我们可以使用name进行跳转

name就是 文件夹名称 以及 他的层级名称

例如  user-profile    user-id   

## 路由动画

+ 在 asset 里面的css文件中直接引入即可 但是需要将此css文件配置到nuxt.config.js 中 的全局css 

.page-leave-active,.page-enter-active{

​    transition: opacity .5s;

}

.page-enter,.page-leave-active{

​    opacity:0;

}

##中间件

每一个中间件应放置在 `middleware/` 目录。文件名的名称将成为中间件名称(`middleware/auth.js`将成为 `auth` 中间件)。

一个中间件接收 [context](https://zh.nuxtjs.org/api#%E4%B8%8A%E4%B8%8B%E6%96%87%E5%AF%B9%E8%B1%A1) 作为第一个参数：

```
export default function (context) {
  context.userAgent = process.server ? context.req.headers['user-agent'] : navigator.userAgent
}
```

中间件执行流程顺序：

1. `nuxt.config.js`
2. 匹配布局
3. 匹配页面

中间件可以异步执行,只需要返回一个 `Promise` 或使用第2个 `callback` 作为第一个参数：

`middleware/stats.js`

```
import axios from 'axios'

export default function ({ route }) {
  return axios.post('http://my-stats-api.com', {
    url: route.fullPath
  })
}
```

然后在你的 `nuxt.config.js` 、 layouts 或者 pages 中使用中间件:

`nuxt.config.js`

```
module.exports = {
  router: {
    middleware: 'stats'
  }
}
```

## 模板

在根目录创建一个app.html文件   全局的大文件  影响到所有页面

默认内容

        ```php+HTML
<!DOCTYPE html>
	<html {{HTML_ATTRS}}>
          	<head>
              {{HEAD}}
        	</head>
        <body {{BODY_ATTRS}}>
              {{APP}}
        </body>
    </html>
        ```

## asyncData

+ 在每个页面被初始化前调用

+ 可以发送请求去请求数据

+  asyncData({isDev, route, store, env, params, query, req, res, redirect, error}) {

  ​     //参数都是context参数的属性  可以直接调用     

  }

  asyncData({isDev, route, store, env, params, query, req, res, redirect, error}) {

  ​          return axios.get("/data.json")  //static 下面的文件是开放的

  ​          .then(res=>{

  ​              console.log(res);

  ​              //返回个对象方便此组件使用

  ​               return {

  ​                   details:res.data

  ​               }

  ​          });

  ​     }

## 插件

nuxt.config.js

build: {

​    extend(config, ctx) {

​      

​    },

​    //设置后只会打包一个axios 不会再多个页面使用打包多次

​    vendor:['axios']

  }

### 自定义插件函数

再 plugins 下面创建myInfo.js文件  文件名可以随便起 在里面引入Vue实例 

import Vue from 'vue'

Vue.prototype.$myInfo = (String) => { console.log(String) };

再 nuxt.config.js 的 plugin中进行配置 ['@/plugins/myInfo'] 即可在每一个组件里面进行调用这个函数

例如   this.$myInfo('hello');

##model

## vuex 状态树

+ 传统方式使用  和 客户端渲染使用一样  需要安装并且使用 Vue.use() 挂载

+ 模块模式   内部已经默认挂载

  + export const state = ()=>({

    ​    count:1

    })

     

    export const mutations  =  {

    ​    add(state){

    ​        state.count++;

    ​    }

    }

    //调用

     {{ $store.state.count }}

    ​                    \<el-button @click="$store.commit('add')"\>

    ​                         调用add

    ​                    \</el-button\>

## 部署

npm run generate  部署静态项目

##引用外部资源

###全局配置

在 nuxt.config.js 中配置你想引用的资源文件：

```
module.exports = {
  head: {
    script: [
      { src: 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js' }
    ],
    link: [
      { rel: 'stylesheet', href: 'https://fonts.googleapis.com/css?family=Roboto' }
    ]
  }
}
```

###局部配置

可在 `pages` 目录内的 `.vue` 文件中引用外部资源，如下所示：

```
<template>
  <h1>使用 jQuery 和 Roboto 字体的关于页</h1>
</template>

<script>
export default {
  head: {
    script: [
      { src: 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js' }
    ],
    link: [
      { rel: 'stylesheet', href: 'https://fonts.googleapis.com/css?family=Roboto' }
    ]
  }
}
</script>
```
## 使用sass

安装

npm i node-sass sass-loader scss-loader --save-dev

配置css    nuxt.config.js   全局使用   局部的话直接修改 style lang=scss

```
   css: [
         {
               src: '*.scss',
               lang: 'scss'
          }
    ] 
```

