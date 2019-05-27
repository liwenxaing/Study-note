# VUESSR 笔记
## 远程JSON生成网站
 1. http://myjson.com/
## 使用的包
 1. 内部使用了  **vue-server-renderer** 
## 安装方式
### 方式1
 1. npm install --global vue-cli
 2. npm init -y
 3. vue init nuxt/starter
    - 会询问项目名称 描述等.....
 4. npm install
 **使用此种方式可能需要配置图片的loader**
### 方式2
 1. npx create-nuxt-app projectName 
 2. 会询问使用的各种UI框架服务器端框架等...

##目录结构
### 文件夹
 1.  .nuxt                打包后生成的部署文件存放地址
 2.  assets               静态资源文件目录 防止 sass less Javascript库
 3.  components           放置自己编写的Vue组件
 4.  layout               布局文件 default.vue 相当于 App.vue
 5.  middleware           放置的中间件
 6.  node_modules         依赖包文件夹
 7.  pages                页面结构存放位置
 8.  plugins              存放的下载插件文件
 9.  static               存放图片等静态资源文件  是对外开放的 可以直接访问
 10. store                Vuex状态树文件
### 文件
 1. .editorconfig         编辑器配置文件
 2. .eslint               代码规范
 3. .gitignore            不默认上传的文件 git仓库
 4. nuxt.config.js Nuxt   配置文件 用来覆盖默认的配置
    1. head               用来配置html文件头部内容 包括 title、meta、link、script
    2. loading            页面上方加载的进度条颜色
    3. build              打包配置
      1. loaders[{test:"",use:['']}]  其他文件扩展配置   例如 图片 
      loaders:[
               {
                 test:/\.(png|jpeg|gif|svg)$/,
                 use:['url-loader'],
                 query:{  限制一下图片的大小超过就不会转码为base64
                    limit:10000,
                    name:"img/[name].[hash].[ext]"
                 }
               }
              ]        
    4. css                全局CSS配置   
 5. package-lock.json     整个项目的描述文件
 6. package.json          包描述文件
    1. 端口被占用解决方案  scripts 增加配置项
       1. "config": {
              "nuxt":{
                "host": "127.0.0.1",
                "port": 3000
              }
          } 
## 路由
### NuxtJs路由概念
   **路由没有配置文件 统一在pages下面写文件 NuxtJs 会自动生成对应的路由结构进行跳转**
   **路由的name是根据当前文件夹名称和文件名称区分的中间以-分隔开**
   **父子路由的话 必须要在同级有一个Vue文件然后有一个文件夹是同名称就形成了父子路由关系**
   **动态路由 动态路由的话文件开头以_开头 在访问到该路由后可以直接传递参数**
   **获取参数 通过$route.params.你的动态路由名称**
   **跳转 <nuxt-link to="/"> 名称 </nuxt-link>**
   **to可以是动态的 例如 :to='{name:"users",params{id:1}}'这样的话就不需要写_开头的文件名称了直接可以在目标文件接收**
   **显示 <nuxt/>  显示子路由 <nuxt-child></nuxt-child>**   
   **一个文件夹下面有一个index.vue的话 会被当成默认第一个显示的路由**
### 参数校验
   **在当前vue组件中可以通过 validate({params}){ return /^\d+$/.test(params.id)}来校验参数的正确规范 如果参数不符合我们的规范就会被跳转到默认的404页面**

   > export default {
        name: "news",
        validate({params}){
           return /^\d+$/.test(params.news);
        }
    }

### 路由切换动画
   1. 在全局的CSS文件中加入以下样式即可
   2. NuxtJs 默认为 transition 设置 name 为 page
   > .page-enter-active,.page-leave-active{ 
       transition:opacity .3s;  /* 可以设置时间 */
     }
     .page-enter,.page-leave-active{
       opacity:0 
     } 

### 路由切换动画 - 单个组件
   1. 和全局切换一样只需要把前面的名称修改一下即可 样式写在 同一个css文件中
   2. 在Vue组件里面export default { transition:"你设置的名称即可" } ; 

## 模板
   1. 在根目录中创建 app.html 
   2. 这个文件的内容就是默认的模板
   3. 会显示在所有组件中
    app.html 内容 
    <!DOCTYPE html>
     <html lang="en">
     <head>
        {{ HEAD }}
     </head>
     <body>
        <p> xxxx </p>
        {{ APP }}
     </body>
     </html>

   **修改模板后需要重启服务器**

## 错误页面 - 个性meta标签设置
### 错误页面
   1. 在 layouts 下面创建 error.vue 组件
   2. 当用户在输入错误的网址的时候会出现
   3. 名字是固定的
   4. 判断是404还是500
      + export default {
                name: "error",
                props:['error']   // 获取到上下文参数 error
          } 
      + <p v-if="error.statusCode==404"> 404 </p>
        <p v-else > 500 </p>
      **进行判断状态码来输出**  
### 个性化设置
   1. 为了更好的SEO NuxtJs 提供了修改title 和 meta 标签的能力
   2. 可以让每一个 title 都不一样 以及 描述信息
   3. 在每一个组件里面的export default 中 加入 如下代码  是一个函数 返回一个对对象
      >    head(){
              return {
                title:"123456",         // 这个是网页的标题
                meta:[
                  {
                    hid:"description",  // 如果设置的和nuxt.config.js中的重复的话就会覆盖
                    name:"index",       // 这个是name
                    content:"内容"       // 这个是内容 
                  }
                ]
              }
            }

## asyncData 异步请求方法
   1. 在每一个组件里面加入异步请求很简单 
   2. 就像以前在Vue Spa 应用 的时候 通过 mounted created 等函数初始化数据一样
   3. 只需要在export default 中加入 asyncData(){} 就好
   4. 里面可以返回一个Promise 或者 使用 async await 
   5. 最终的结果是要返回一个对象 因为该组件中还需要使用这个异步请求带来的数据结果
   6. 例子 ： 
      >  import axios from 'axios';
          // 返回 Promise
          export default {
            acyncData(){
               return axios.get('/data.json')
               .then(res=>{
                   return {
                     data:res.data     //组件中可以直接通过 data.xxx 绑定数据
                   }
               })
               .catch(err=>{
                   console.log(err);
                   return;
               })
            }
          }    
         //使用 anync await 
         export default {
            async acyncData(){
               let res = await axios.get('/data.json');
               return {
                  data : res.data
               }
               //更加的简单 明了 
             }
            }    

## 静态部署
  1. 使用 npm run generate 即可 生成一个dist文件夹 在里面放置了 各种静态资源文件
  2. 有可能静态资源文件图片在本地会显示不出来  部署到服务器上应该就解决了这个问题

## 中间件
  1. 在 middleware 文件夹下面创建一个js文件 然后 export default 一个 function 参数可以是 nuxt 嗯嗯 context 参数
  2. 在 路由跳转的过程中间进行一些业务的处理  例如 用户的访问页面的权限
  3. 在 nuxt.config.js 中配置 router:{ middleware:"你的JS文件名称即可" }
  4. 省略 ext 名
  > nuxt.config.js file content 
    router:{
      middleware:['proxyRequest']
    }
  > proxyRequest.js file content  
    // 里面的参数是内置的  
    export default function({params,error,redirect,router,store}){
            console.log("我是中间件");
    }

## Vuex 状态树

+ ### 普通方式

  使用普通方式的状态树，需要添加 `store/index.js` 文件，并对外暴露一个 Vuex.Store 实例：

  [![复制代码](http://common.cnblogs.com/images/copycode.gif)](javascript:void(0);)

  ```
  const store = () => new Vuex.Store({
  
    state: {
      count: 0
    },
    actions:{
      asyncDatas(mutations){
        mutations.commit("asyncDatas");
      }
    },
    mutations: {
      asyncDatas (state) {
        state.count++
      }
    },
    getters:{
       counter:(state)=>{
           return "Y" + state.count;
       }
    }
  });
  
  export default store
  
  调用
  $store.getters.xxx
  ```

  [![复制代码](http://common.cnblogs.com/images/copycode.gif)](javascript:void(0);)

  现在我们可以在组件里面通过 `this.$store` 来使用状态树

  　　

  ### 模块方式

  状态树还可以拆分成为模块，`store` 目录下的每个 `.js` 文件会被转换成为状态树[指定命名的子模块](http://vuex.vuejs.org/en/modules.html)

  使用状态树模块化的方式，`store/index.js` 不需要返回 Vuex.Store 实例，而应该直接将 `state`、`mutations` 和 `actions` 暴露出来：

  [![复制代码](http://common.cnblogs.com/images/copycode.gif)](javascript:void(0);)

  ```
  export const state = () => ({
    counter: 0
  })
  
  export const mutations = {
    increment (state) {
      state.counter++
    }
  }
  ```

  [![复制代码](http://common.cnblogs.com/images/copycode.gif)](javascript:void(0);)

  其他的模块文件也需要采用类似的方式，如 `store/todos.js` 文件：

  [![复制代码](http://common.cnblogs.com/images/copycode.gif)](javascript:void(0);)

  ```
  export const state = () => ({
    list: []
  })
  
  export const mutations = {
    add (state, text) {
      state.list.push({
        text: text,
        done: false
      })
    },
    remove (state, { todo }) {
      state.list.splice(state.list.indexOf(todo), 1)
    },
    toggle (state, todo) {
      todo.done = !todo.done
    }
  }
  
  export const actions ={
    asyncDatas:function(mutations){
      mutations.commit("add");
    }
  };
  ```

  [![复制代码](http://common.cnblogs.com/images/copycode.gif)](javascript:void(0);)

  在页面组件 `pages/todos.vue`， 可以像下面这样使用 `todos` 模块：

   

  [![复制代码](http://common.cnblogs.com/images/copycode.gif)](javascript:void(0);)

  ```
  <template>
    <ul>
      <li v-for="todo in todos">
        <input type="checkbox" :checked="todo.done" @change="toggle(todo)">
        <span :class="{ done: todo.done }">{{ todo.text }}</span>
      </li>
      <li><input placeholder="What needs to be done?" @keyup.enter="addTodo"></li>
    </ul>
  </template>
  
  <script>
  import { mapMutations } from 'vuex'
  
  export default {
    computed: {
      todos () { return this.$store.state.todos.list }
    },
    methods: {
      addTodo (e) {
        this.$store.commit('todos/add', e.target.value)
        e.target.value = ''
      },
      ...mapMutations({
        toggle: 'todos/toggle'
      })
    }
  }
  </script>
  
  <style>
  .done {
    text-decoration: line-through;
  }
  </style>
  ```

+  

# Nuxt中使用Nprogress，以及自定义进度条的颜色

![96](https://upload.jianshu.io/users/upload_avatars/15263556/1b8fb09e-eb93-4311-b08f-c019667def3e?imageMogr2/auto-orient/strip|imageView2/1/w/96/h/96)

 

[凉梦_ae33](https://www.jianshu.com/u/9985e2c26c3a)

 

关注

2019.01.01 19:20 字数 181 阅读 118评论 0喜欢 4

### 1.安装Nprogress

> npm install nprogress --save

### 2..在plugins中新建一个loading.js

![img](https://upload-images.jianshu.io/upload_images/15263556-494e524e394c4da8.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/204/format/webp)

loading.js

### 3.在loading.js中写入以下内容，他会在每次路由跳转的时候执行

> //引入nprogress
>
> import NProgress from 'nprogress'
>
> import 'nprogress/nprogress.css' //这个样式必须引入
>
> //Nprogress的基本配置
>
> NProgress.inc(0.2);
>
> NProgress.configure({easing:'ease', speed:500, showSpinner:false });
>
> export default ({ app }) => {
>
> app.router.beforeEach((to,from,next) => {
>
> ​    NProgress.start();
>
> ​    next()
>
> });
>
>   app.router.afterEach(() => {
>
> ​     NProgress.done()
>
> });
>
> }

### 4.在nuxt.config.js中引入这个loading.js

> plugins: [
>
>   {src:'@/plugins/loading', ssr:false },
>
> ],

### 5.如果要修改进度条的颜色颜色，你写入如下css， ！important是设置最高级权限，可以覆盖本来的颜色

> \#nprogress .bar {
>
> background:$color-main !important; //自定义颜色
>
> 18-02-23 发布

## vue-gemini-scrollbar（vue组件-自定义滚动条

```
npm i vue-gemini-scrollbar --save
```

在模板中使用

```
<GeminiScrollbar
    class="my-scroll-bar">
    content...
</GeminiScrollbar>
```

注意：只有内容溢出才会有滚动效果

```
.my-scroll-bar{
    height:200px;
}
```

## 使用

安装组件

```
import Vue from 'vue'
import GeminiScrollbar from 'vue-gemini-scrollbar'

Vue.use(GeminiScrollbar)
```

在模板中使用

```
<GeminiScrollbar
    class="my-scroll-bar">
    content...
</GeminiScrollbar>
```

添加自己的滚动条样式

```
/* override gemini-scrollbar default styles */

/* vertical scrollbar track */
.gm-scrollbar.-vertical {
  background-color: #f0f0f0
}

/* horizontal scrollbar track */
.gm-scrollbar.-horizontal {
  background-color: transparent;
}

/* scrollbar thumb */
.gm-scrollbar .thumb {
  background-color: rebeccapurple;
}
.gm-scrollbar .thumb:hover {
  background-color: fuchsia;
}
```

## 如何为body设置自定义滚动条

因为vue组件的根元素不能为body，此时可以从Vue.$geminiScrollbar访问到GeminiScrollbar对象，然后你就可以自由使用它了（文档请参考：[gemini-scrollbar](https://github.com/noeldelgado/gemini-scrollbar)）。

```
html {
    height: 100%;
    /* or */
    height: 100vh;
}
var scrollbar = new Vue.$geminiScrollbar({
    element: document.body
}).create();
```