# 1. Vue学习笔记

##Vue day 1

#### ES6中的模块

- 默认
  - 导入`import [,..xxx] [,..from] './xxx.ext'`
  - 导出 `export default obj;`
- 声明式
  - 1导出 `export var obj = xxx;`
  - 2导出 `export var obj2 = {};`
  - 3单独导出 ` export {stu};`
  - 导入 `import {obj,obj2,stu} from './xxx.js';  直接使用obj`
- 全体
- 默认导出和声明式导入在使用上的区别
  - 要注意，声明式导入的时候，必须{名称} 名称要一致（按需导入)
  - 默认导入，可以随意的使用变量名

```javascript
{
default:"我是默认导出的结果"    
        import xxx from './cal.js'会获取到整个对象的default属性
obj1:"我是声明式导出1"
obj2:"我是声明式导出2" 
obj3:"我是声明式导出3"     import {obj1,obj2}
obj4:"我是声明式导出4"
}
    import * as allObj from './cal.js';  获取的就是一整个对象
```

- import 和export一定写在顶级，不要包含在{}内

#### ES6中的代码变化

- 对象属性的声明 

```javascript
    var name = 'abc';
    var person = {name}; 简写-> var person = {name:name};

    声明函数 
    var cal = {
        add:function(){
            return 1;
        },
        add2(){
            return 2;
        },
        add3:funtion(n1,n2){
            return n1 + n2;
        },
        add4(n1,n2){  干掉了function
            return n1 + n2;
        }
    }
```

- 当属性的key和变量的名相同,而要使用变量的值做value,
- 就可以简写{name}->{name:name}
- es6中的函数声明
  - 就是干掉了:function    add(){ }

#### vue单文件方式

- 单文件就是以*.vue结尾的文件。最终通过webpack也会编译成*.js在浏览器运行
- 内容： <template></template> + <script></script> + <style></style>
  - 1:template中只能有一个根节点 2.x
  - 2:script中  按照 export default {配置} 来写
  - 3:style中 可以设置scoped属性，让其只在template中生效

####使用webpack4.x 配置 Vue 项目代码实例

#### 以单文件的方式启动

- webpack找人来理解你的单文件代码
  - vue-loader,vue-template-compiler,代码中依赖vue, vue-style-loader
  - 安装  npm install --save vue vue-loader vue-template-compiler
- 启动命令
- `..\\node_modules\\.bin\\webpack-dev-server --inline --hot --open`
- 快捷
- 在package.json 文件中scripts配置  dev:"webpack-dev-server --open"

#### vue介绍

- 2014年诞生,2013年react,09年angularjs
- 作者 尤雨溪
- 核心概念:     组件化  双向数据流 (基于ES5中的defineProperty来实现的),IE9才支持
- angular核心： 模块化 双向数据绑定(脏检测:一个数组（$watch）)
  - 开发一个登陆的模块，登陆需要显示的头部、底部、中部
  - 组件:组合起来的一个部件（头部、底部、中部）
  - __细分代码__
    - 头部: 页面、样式、动态效果
    - 代码: template style script
- 框架对比，建议学完vue再看
- https://cn.vuejs.org/v2/guide/comparison.html#React

#### 数据流

- 1向：js内存属性发生改变，影响页面的变化
- 1向：页面的改变影响js内存属性的改变

#### vue中常用的v-指令演示

- 常用指令 
- v-text 是元素的innerText只能在双标签中使用
- v-html 是元素的innerHTML，不能包含<!--{{xxx}} -->
- v-if 元素是否移除或者插入
- v-show 元素是否显示或隐藏
- v-model 双向数据绑定，v-bind是单向数据绑定(内存js改变影响页面)

#### class结合v-bind使用

- 需要根据可变的表达式的结果来给class赋值，就需要用到v-bind:class="xxx"
- v-bind:属性名="表达式"，最终表达式运算结束的结果赋值给该属性名
  - 简化的写法是: `:属性名="表达式"`
- class:结果的分类
  - 一个样式: 返回字符串(三元表达式和key和样式的清单对象)
  - 多个样式：返回对象(样式做key，true或flase做值)

#### methods和v-on的使用

- 绑定事件的方法
  - `v-on:事件名="表达式||函数名"`
  - 简写: `@事件名="表达式||函数名"`
- 函数名如果没有参数，可以省略()  只给一个函数名称
- 声明组件内函数，在export default这个对象的根属性加上methods属性，其是一个对象
  - key 是函数名 值是函数体
- 在export default这个对象的根属性加上data属性，其是一个函数，返回一个对象
  - 对象的属性是我们初始化的变量的名称
- 凡是在template中使用变量或者函数，不需要加this
- 在script中使用就需要加上this

#### v-for的使用

- 可以使用操作数组 (item,index)
- 可以使用操作对象 (value,key,index)
- key 是类似trank by 的一个属性
- 为的是告诉vue，js中的元素，与页面之间的关联，当识图删除元素的时候，是单个元素的删除而不是正版替换，所以需要关联其关系，设置(必须,性能)  
- 2.2.0+ 的版本里，当在组件中使用 v-for 时，key 现在是必须的。

#### 漂亮的列表

#### 父子组件使用

- 父和子，使用的是父，被用的是子
- 父需要声明子组件，引入子组件对象，声明方式如下

```javascript
import 子组件对象 from './xxx.vue';

    {
        components:{
            组件名:子组件对象
        }
    }
```

- 全局组件，使用更为方便，不需要声明，直接用
- 在main.js中引入一次，在main.js中使用 `vue.component('组件名',组件对象);`
- 所有的组件就可以直接通过组件名，使用

#### 父传子

- 父组件通过子组件的属性将值进行传递
  - 方式有2:
    - 常量:  prop1="常量值"
    - 变量:  :prop2="变量名"
- 子组件需要声明
  - 根属性props:['prop1','prop2']
  - 在页面中直接使用{{prop1}}
  - 在js中应该如何使用prop1？   this.prop1获取

#### 看文档的对象分类

- 1:全局的代表Vue.的
- 2:实例的代表this.或者new Vue().
- 3:选项代表 new Vue() 的参数
- 或者 export default里边的属性

#### 子向父组件通信（vuebus）(扩展)

- 通过new Vue()这样的一个对象，来$on('事件名',fn(prop1,pro2))
- 另一个组件引入同一个vuebus,  来$emit('事件名',prop1,pro2)

#### 总结

- -1 : 已经存在node_modules包，已经存在package.json和webpack.config.js文件
- 1: 创建index.html,看看其所在文件和webpack.config.js文件中描述的关系
- 2: 在index.html div->id->app
- 3: 创建main.js,看看其所在文件和webpack.config.js文件中描述的关系
- 4: 在main.js中引入vue,和相关组件对象
- 5: new Vue(选项options) , 目的地el   渲染内容 render:c=>c(App) 渲染App的内容
- 6: 编写app.vue 
  - template 在2.x以后只能有一个根节点
  - script 格式是export default { 选项options}
  - style 加上scoped（范围的）之后，样式只对当前模板有效
- 7: 可能使用组件或者使用函数或者接受参数
  - options(根属性):
    - data 是一个函数,return一个对象
    - methods 是一个对象,key是函数名,value是函数体
    - components 是一个对象,key是组件名,值是组件对象
    - props 是一个数组,元素是多个接受的参数
- 8: 套路总结
  - 凡是在上边可以使用的东西
  - 在下边就可以使用，通过this.
- 9:启动
  - 进入到webpack.config.js 和package.json文件同在的目录中启动命令行
  - 输入: 正在编码:  npm run dev 
    - 报错: 检查命令所执行的../ 上级,是否存在node_modules目录及相关文件是否存在
  - 输入: 代码编写完毕，提交到公司 :  npm run build

## Vue day2

#### 今日重点

- vue组件的使用
- 组件间通信
- vue-router使用
- vue-resource发起http请求
- axios

#### 过滤器

- content | 过滤器,vue中没有提供相关的内置过滤器,可以自定义过滤器
- 组件内的过滤器 + 全局过滤器
  - 组件内过滤器就是options中的一个filters的属性（一个对象）
    - 多个key就是不同过滤器名,多个value就是与key对应的过滤方式函数体
  - `Vue.filter(名,fn)`
- 输入的内容帮我做一个反转
- 例子:父已托我帮你办点事
- 总结
  - 全局 ：范围大，如果出现同名时，权利小
  - 组件内: 如果出现同名时，权利大，范围小

#### 获取DOM元素

- 救命稻草, 前端框架就是为了减少DOM操作，但是特定情况下，也给你留了后门
- 在指定的元素上，添加ref="名称A"
- 在获取的地方加入 this.$refs.名称A  
  - 如果ref放在了原生DOM元素上，获取的数据就是原生DOM对象
    - 可以直接操作
  - 如果ref放在了组件对象上，获取的就是组件对象
    - 1:获取到DOM对象,通过this.$refs.sub.$el,进行操作
  - 对应的事件
    - created 完成了数据的初始化，此时还未生成DOM，无法操作DOM
    - mounted 将数据已经装载到了DOM之上,可以操作DOM

#### mint-ui

- 组件库
- 饿了么出品,element-ui 在PC端使用的
- 移动端版本 mint-ui
- https://mint-ui.github.io/#!/zh-cn
- 注意:
  - 如果是全部安装的方式
    - 1:在template中可以直接使用组件标签
    - 2:在script中必须要声明，也就是引入组件对象（按需加载）

#### wappalyzer

- 获取到当前网站的使用的技术
- https://wappalyzer.com/download

#### vue-router

- 前端路由 核心就是锚点值的改变，根据不同的值，渲染指定DOM位置的不同数据
- ui-router:锚点值改变，如何获取模板？ajax、
- vue中，模板数据不是通过ajax请求来，而是调用函数获取到模板内容
- 核心：锚点值改变
- 以后看到vue开头，就知道必须Vue.use
- vue的核心插件:
  - vue-router 路由
  - vuex 管理全局共享数据
- 使用方式
  - 1:下载 `npm i vue-router -S`
  - 2:在main.js中引入 `import VueRouter from 'vue-router';`
  - 3:安装插件 `Vue.use(VueRouter);`
  - 4:创建路由对象并配置路由规则
    - `let router = new VueRouter({ routes:[ {path:'/home',component:Home}  ]   });`
  - 5:将其路由对象传递给Vue的实例，options中
    - options中加入 `router:router`
  - 6:在app.vue中留坑 ` <router-view></router-view>`

#### 命名路由

- 需求，通过a标签点击，做页面数据的跳转
- 使用router-link标签
  - 1:去哪里 `<router-link to="/beijing">去北京</router-link>`
  - 2:去哪里 `<router-link :to="{name:'bj'}">去北京</router-link>`
    - 更利于维护，如果修改了path，只修改路由配置中的path，该a标签会根据修改后的值生成href属性

#### 参数router-link

+ exact  加上路由设置的样式更加的精确到每一个路由上去  加在router-link中

+ linkActiveClass   加载VueRouter实例中设置类名

- 在vue-router中，有两大对象被挂载到了实例this
- $route(只读、具备信息的对象)、$router(具备功能函数)
- 查询字符串
  - 1:去哪里 `<router-link :to="{name:'detail',query:{id:1}  } ">xxx</router-link>`
  - 2:导航(查询字符串path不用改) `{ name:'detail' , path:'/detail',组件}`
  - 3:去了干嘛,获取路由参数(要注意是query还是params和对应id名)
    - `this.$route.query.id`
- path方式
  - 1:去哪里 `<router-link :to="{name:'detail',params:{name:1}  } ">xxx</router-link>`
  - 2:导航(path方式需要在路由规则上加上/:xxx) 
  - `{ name:'detail' , path:'/detail/:name',组件}`
  - 3:去了干嘛,获取路由参数(要注意是query还是params和对应name名)
    - `this.$route.params.name`

#### 编程导航

- 不能保证用户一定会点击某些按钮
- 并且当前操作，除了路由跳转以外，还有一些别的附加操作
- this.$router.go 根据浏览器记录 前进1 后退-1
- this.$router.push(直接跳转到某个页面显示)
  - push参数: 字符串 /xxx
  - 对象 :  `{name:'xxx',query:{id:1},params:{name:2}  }`

#### 复习

- 过滤器，全局，组件内
- 获取DOM元素 ，在元素上ref="xxx"
- 在代码中通过this.$refs.xxx 获取其元素
  - 原生DOM标签获取就是原生DOM对象
  - 如果是组件标签，获取的就是组件对象  $el继续再获取DOM元素
- 声明周期事件(钩子)回调函数
  - created: 数据的初始化、DOM没有生成
  - mounted: 将数据装载到DOM元素上，此时有DOM
- 路由
  - `window.addEventListener('hashchange',fn);`
  - 根据你放`<router-view></router-view><div id="xxx"></div>` 作为一个DOM上的标识
  - 最终当锚点值改变触发hashchange的回调函数，我们将指定的模板数据插入到DOM标识上

#### 重定向和404

- 进入后，默认就是/
- 重定向 `{ path:'/' ,redirect:'/home'  }`
- 重定向 `{ path:'/' ,redirect:{name:'home'}  }`
- 404 : 在路由规则的最后的一个规则
  - 写一个很强大的匹配
  - `{ path:'*' , component:notFoundVue}`

#### 多视图

- 以前可以一次放一个坑对应一个路由和显示一个组件
  - 一次行为 = 一个坑 + 一个路由 + 一个组件
  - 一次行为 = 多个坑 + 一个路由 + 多个组件
- components 多视图 是一个对象 对象内多个key和value
  - key对应视图的name属性
  - value 就是要显示的组件对象
- 多个视图`<router-view></router-view>` -> name就是default
- `<router-view name='xxx'></router-view>` -> name就是xxx 这是使用视图
- 在路由中这样写    {  components:{ default:Home,"xxx":Doc,"xxx":..... } }

#### 嵌套路由

- 用单页去实现多页应用，复杂的嵌套路由
- 开发中一般会需要使用
- 视图包含视图
- 路由父子级关系路由

```javascript
期组件内包含着第一层router-view
{ name:'music' ,path:'/music', component:Music ,
children:[   子路由的path /就是绝对路径   不/就是相对父级路径
    {name:'music.oumei' ,path:'oumei', component:Oumei },
    {name:'music.guochan' ,path:'guochan', component:Guochan }
]
}  
```

#### vue-resource(了解)

- 可以安装插件，早期vue团队开发的插件
- 停止维护了，作者推荐使用axios
- options预检请求，是当浏览器发现跨域 + application/json的请求，就会自动发起
- 并且发起的时候携带了一个content-type的头

#### axios

- https://segmentfault.com/a/1190000008470355?utm_source=tuicool&utm_medium=referral
- post请求的时候，如果数据是字符串 默认头就是键值对，否则是对象就是application/json
- this.$axios.get(url,options)
- this.$axios.post(url,data,options)
- options:{ params:{id:1}//查询字符串, headers:{ 'content-type':'xxxxx' },baseURL:''  }
- 全局默认设置 ：Axios.defaults.baseURL = 'xxxxx';
- 针对当前这一次请求的相关设置

#### 如何练习

- 1:路由核心
  - 路由基本使用
  - 任选一种路由参数的方式(查询字符串)
  - 404(路由匹配规则)
  - 嵌套路由
  - 编程导航
- 2:http请求
  - axios 发起get、post请求 （300）
  - 获取 http://182.254.146.100:8899/api/getcomments/300?pageindex=1
  - 发起 http://182.254.146.100:8899/api/postcomment/300
  - axios挂载属性方式

## Vue day3

#### 复习

- 路由操作的基本步骤

```javascript
引入对象
import VueRouter from 'vue-router';
安装插件
Vue.use(VueRouter);   挂载属性的行为
创建路由对象
let router = new VueRouter({
    routes:[
        { name:'xxx',path:'/xxx',组件  }
    ]
});
将路由对象放入到options中new Vue()
new Vue({
    router
})
```

- 套路
  - 1: 去哪里  <router-link :to="{name:'bj'}"></router-link>
  - 2: 导航(配置路由规则) `{name:'bj',path:'/beijing',组件A}`
  - 3: 去了干嘛(在组件A内干什么)
    - 在created事件函数中，获取路由参数
    - 发起请求，把数据挂载上去
- 参数
  - 查询字符串（#/beijing?id=1&age=2）
    - 1: 去哪里  <router-link :to="{name:'bj',query:{id:1,age:2}  }"></router-link>
    - 2: 导航(配置路由规则) `{name:'bj',path:'/beijing',组件A}`
    - 3: 去了干嘛(在组件A内干什么)
      - `this.$route.query.id||age`
  - path(#/beijing/1/2)
    - 1: 去哪里  <router-link :to="{name:'bj',params:{id:1,age:2}  }"></router-link>
    - 2: 导航(配置路由规则) `{name:'bj',path:'/beijing/:id/:age',组件A}`
    - 3: 去了干嘛(在组件A内干什么)
      - `this.$route.params.id||age`
- 编程导航
  - 一个获取信息的只读对象($route)
  - 一个具备功能函数的对象($router)
  - 根据浏览器历史记录前进和后台 `this.$router.go(1|-1);`
  - 跳转到指定路由  `this.$router.push({ name:'bj'  });`
- 嵌套路由
  - 让变化的视图(router-view)产生包含关系(router-view)
  - 让路由与router-view关联，并且也产生父子关系
- 多视图
  - 让视图更为灵活，以前一个一放，现在可以放多个，通过配置可以去修改
- axios:
  - 开始:
    - 跨域 + 默认的头是因为你的数据是对象，所以content-type:application/json
    - 有OPTIONS预检请求（浏览器自动发起）
  - 最终:
    - 当我们调整为字符串数据，引起content-type变为了www键值对
    - 没有那个OPTIONS预检请求
  - 总结： 跨域 + application/json 会引起OPTIONS预检请求，并且自定义一个头(提示服务器，这次的content-type较为特殊)，content-type的值
  - 服务器认为这个是一次请求，而没有允许content-type的头，
  - 浏览器就认为服务器不一定能处理掉这个特殊的头的数据
  - 抛出异常
  - 在node服务器 response.setHeader("Access-Control-Allow-Headers","content-type,多个");
  - formdata的样子:  key=value&key=value
- axios属性关系
  - options: headers、baseURL、params
  - 默认全局设置(大家都是这么用)
    - Axios.defaults-> options对象
  - 针对个别请求来附加options
  - axios.get(url,options)
  - axios.post(url,data,options)

#### 今日重点

- axios
- watch
- 计算属性
- 项目

#### axios

- 合并请求
- axios.all([请求1,请求2])
- 分发响应  axios.spread(fn)
- fn:对应参数(res)和请求的顺序一致
- 应用场景:
  - 必须保证两次请求都成功，比如，分头获取省、市的数据
- 执行特点: 只要有一次失败就算失败，否则成功

#### 拦截器

- 过滤，在每一次请求与响应中、添油加醋
- axios.interceptors.request.use(fn)  在请求之前
- function(config){ config.headers = { xxx }}   config 相当于options对象
- 默认设置 defaults 范围广、权利小
- 单个请求的设置options get(url,options)  范围小、权利中
- 拦截器 范围广、权利大

#### token(扩展)

- cookie 和session的机制，cookie自动带一个字符串
- cookie只在浏览器
- 移动端原生应用，也可以使用http协议，1:可以加自定义的头、原生应用没有cookie
- 对于三端来讲，token可以作为类似cookie的使用，并且可以通用
- 拦截器可以用在添加token上

#### 拦截器操作loadding

- 在请求发起前open，在响应回来后close

#### 监视

- watch 可以对（单个）变量进行监视，也可以深度监视
- 如果需求是对于10个变量进行监视？
- 计算属性computed 可以监视多个值，并且指定返回数据，并且可以显示在页面
- 都是options中的根属性
  - watch监视单个
  - computed可以监视多个this相关属性值的改变,如果和原值一样
  - 不会触发函数的调用，并且可以返回对象









## Vue 知识代码扩展

##### webpack 搭建 vue 脚手架

```javascript
const path = require("path")
const webpack = require("webpack")
const HtmlWebpackPlugin = require("html-webpack-plugin")
const CleanWebpackPlugin = require("clean-webpack-plugin")
const VueLoaderPlugin = require('vue-loader/lib/plugin') // Vue加载器处理程序插件
module.exports = {
    entry:{
        app:"./src/main.js"
    },
    output:{
        filename:"js/[name].js",
        path:path.resolve(__dirname,'dist')
    },
    //必须的配置不配置不能加载vue文件
    resolve: {
        alias: {
          'vue': 'vue/dist/vue.esm.js'
        }
      },
    module:{
        rules:[
            //设置加载Vue结尾的文件
            {
                test:/\.vue$/,
                use:['vue-loader']
            },
            {
                test:/\.css$/,
                use:['style-loader','css-loader']
            },
            {
                test:/\.(sass|scss)/,
                use:['style-loader','css-loader','sass-loader']
            },
            {
                test:/\.(gif|jpg|png|svg)$/,
                use:['url-loader'],
                /*  划分目录  */
                options:{
					// 当图片文件大于 4000 字节 生成单独的文件
					limit:4000,
					// 生成到图片到dist下的assets文件夹
					name:'assets/[name].[ext]'
				}
            }
        ] 
    },
    devServer:{ 
       contentBase:path.resolve(__dirname,'dist'),
       host:"localhost", 
       hot:true
    },
    plugins:[
        new HtmlWebpackPlugin({
            filename: 'index.html',
            template: './src/index.html',
            inject: true
        }),
        new CleanWebpackPlugin(['dist']),
        new webpack.HotModuleReplacementPlugin(),
        //实例化Vue插件
        new VueLoaderPlugin(),
  
    ],
    mode:"development"
}

```



##### coffee-script已经过时问题安装vuecli报错  

npm ls --depth 0 -g // 看看哪些失效了
npm prune -g // 修剪下全局包
npm rebuild -g // 重建下全局包
npm update -g // 更新下全局包的版本
npm cache clear --force -g // 删除全局包的缓存（慎重）

##### vue-resource 请求

```javascript
 this.$http.get("http://localhost:3000/getdata").then(res=>{
             this.data = res.body
             console.log(this.data);
           })
           this.$http.post("http://localhost:3000/getImgUrl",{key:"获取"},{emulateJSON:true}).then(res=>{
                 console.log("resourcepost")
            console.log(res.body);
           })
```

##### vue-axios 请求

```javascript
//params里面也可以写get参数  header 可以设置头信息 application/x-www-form-urlencoded
           this.$axios.get("http://localhost:3000/getdata",{ params:{  },headers:{} })
           .then(res=>{
             console.log("axiosget")
             console.log(res.data)
           })

            this.$axios.get("http://localhost:3000/getdata")
           .then(res=>{
             console.log("axiosget")
             console.log(res.data)
           })
           // axiospost设置header参数是在第三个参数 { headers:{} }
           this.$axios.post("http://localhost:3000/getImgUrl",{key:"获取"},{headers:{ }，baseURL:"").then(res=>{
                     console.log("axiospost")
                     console.log(res.data);
           })
```

##### axios请求合并

`只要有一个请求出现错误那么就直接返回错误`

```javascript
this.$axios.all([ this.$axios.post('/api/msg',{key:"test"}),this.$axios.get('/api/command') ])
//分发响应
.then(this.$axios.spread((res1,res2)=>{
    console.log(res1); //第一个请求的结果
    console.log(res2); //第二个请求的结果
}))
.catch(err=>{});
```



##### vue-axios 设置全局路径 （全局设置） 

```javascript
Axios.defaults.baseURL = 'http://www.baidu.com';
Axios.defaults.headers['token'] = ""
```

##### vue-axios 拦截器 在请求中添油加醋 处理一些程序

```javascript
//请求拦截器 config 就是请求对象  可以操作里面的属性  例如 headers method data
Axios.interceptors.request.use((config)=>{
      alert(config.method);
      //不返回就是一个拦截器
      return config;
});
//响应拦截器  一般用来关闭loadding加载......
Axios.interceptors.request.use((config)=>{
      alert(config.method);
      //不返回就是一个拦截器
      return config;
});
```

##### 侦听器 (watch)

```javascript
watch:{
       //名称要和data里面的属性名一致 两个参数 第一个是新值 第二个是老值
           final(value,oldValue){
             console.log(value + "这是改变后的值 -- " + "这是老值" + oldValue);
           }
      }
```

##### 设置router默认link激活样式

+ 默认是 router-link-active
+ 可以通过 linkActiveClass:"设置的类名" 来设置你自己定义的链接激活样式
+ 也可以在router-link 中 加入  active-class="类名"
+ exact 严格过滤

##### 日期格式化 (moment) 

+ 官网：http://momentjs.cn
+ 安装
+ npm install --save moment
+ 用法
+ import moment from 'moment'
+ 获取当前时间转化

##### vue-preview 图片预览插件

+ 安装 npm i -S vue-preview
+ github 搜索 vue-preview 就有具体用法 
+ https://github.com/LS1231/vue-preview
+ 引入  使用  import  .... from 'vue-preview'
+ Vue.use(...)
+ 使用的时候里面的class不能省
+ 便利的每一个对象都必须要有一个 w 和 h 

```javascript
 
<vue-preview  :slides="slide1" @close="handleClose"></vue-preview>


slide1: [
								{
							src: 'https://farm6.staticflickr.com/5591/15008867125_68a8ed88cc_b.jpg',
							msrc: 'https://farm6.staticflickr.com/5591/15008867125_68a8ed88cc_m.jpg',
							alt: 'picture1',
							title: 'Image Caption 1',
							w: 600,
							h: 400
								},
								{
							src: 'https://farm4.staticflickr.com/3902/14985871946_86abb8c56f_b.jpg',
	            			msrc: 'https://farm4.staticflickr.com/3902/14985871946_86abb8c56f_m.jpg',
							alt: 'picture2',
							title: 'Image Caption 2',
							w: 600,
							h: 400
								}
						]
```

##### mintUi 上拉加载注意

+ 不能让子盒子自己把父盒子撑开 父盒子需要设置一个固定的高 去除底部和头部的高
+ 因为一旦子盒子与父盒子的底部进行重叠就触发了上拉操作
+ 上拉完毕之后需要获取到当前的组件对象 通知此次上拉加载已经完成 要不然第二次拉会很别扭
+ 有时候容器没有被撑满 会默认调用一次 上拉事件 我们可以通过设置 auto-fill = "false" 不让他直接调用
+ 当加载到最后一点数据的时候 可以设置禁止调用上拉操作 可以判断返回的局的页大小

##### Vue - transition

+ after-leave 事件是隐藏之后触发

   <transition name="fade" @after-leave="end">
                 <span v-if="show"> 切换的字体 </span>
    </transition>

​                end(){
             		alert("隐藏结束")
             	}

+ 刚进入 与 离开后

.fade-enter,.fade-leave-to{
 	transition: opacity .5s;
    opacity:0;
 }

+ 进行中 与 离开中

.fade-enter-active,.fade-leave-active{

 	transition: opacity .5s;
 }

#####  过渡 router-view 淡入淡出

+ 默认进入和离开是同时操作的 可能会造成一些问题
+ 可以在transition中加入 mode = 'out-in / in-out' 取其一即可

##### vue 路由懒加载 按块加载 按需加载 

+ 当用户访问到了当前组件才进行请求
+ const Foo =  resolve => require(['./Foo.vue'],resolve);
+ 例子
+ 之前  import Home from './home.vue'
+ 按需  const Home = resolve=>require(['./home.vue',resolve]);  resolve是形参 可以随便写 require的第二个参数也是形参 中括号里面的是需要按需加载的路由块
+ 路由正常使用   { name:"home",path:"/",component:Home }

##### 导航守卫

###### 全局守卫

router.beforeEach((to,from,next)=>{
      **to去哪**  **from来自哪** **下一个进入的路由块 默认正常进入传递值的话就按照传递的值进行调转*跳转  
      if(to.path === "/login" || to.path === "/reg"){
           next();
      }else{
         alert("您还没有登录，请登录!");
        next("/login");
     }
 });

###### 局部守卫

 beforeRouteEnter:(to,form,next)=>{
             //当进入这个组件的时候 在这里面不能够直接获取到data里面的属性 在next里面接受的是一个回调函数 里                         面有一个参数可以调用data里面的属性
             next(data=>{

​                    //data就可以代表this 在这里面访问不到thsi实例 用data代替 

​                   console.log(data.name);
             });
        }

beforeRouteLeave:(to,form,next)=>{
             /* 当离开这个组件的时候 */
             if(window.confirm("你确定要离开吗？")){
                 next();  //正常跳转
             }else{
                 next(false); //里面传递个false代表不跳转
             }
        }

##### 事件修饰符

​              <!-- 键盘事件修饰符 -->
             <!-- $event 是 event对象 -->
            <input type="text" @keyup.enter="enter()"/>
            <input type="text" @keyup.tab="enter()"/>
            <input type="text" @keyup.esc="enter()"/>
            <input type="text" @keyup.delete="enter()"/>
            <input type="text" @keyup.stop="enter()"/>
            <input type="text" @keyup.prevent="enter()"/>
            <input type="text" @keyup.left="enter()"/>

​              <input type="text" @keyup.right="enter()"/>
            <input type="text" @keyup.up="enter()"/>

  <input type="text" @click.once="enter()"/>

##### 动态组件

```javascript
<!-- 可以直接通过模板语法调用 -->
         <!--{{currentView}}-->
         <!-- 标准写法 -->
         <!-- keep-alive 不会重新渲染 如果是死数据可以使用keep-alive缓存起来 下一次切换不会重新渲染 -->
         <keep-alive>
             <component :is="currentView"></component>
         </keep-alive>

         <button @click="changeModuls">切换组件</button>

    // currentView 是一个属性 	
    import small1 from "./small1"
    import small2 from "./small2"
    export default {
        name: "comkeep",
        //动态组件
        data(){
            return {
                //通过一个属性来保存此组件的名字
                currentView:"small1",
                flag:true
            }
        },
        methods:{
            changeModuls(){
                  if(this.flag){
                      this.currentView = "small1";
                      this.flag = false;
                  }else{
                      this.currentView = "small2";
                      this.flag = true;
                  }
            }
        },
        components:{
            small1,
            small2
        }
    }
```

##### 插槽

```html
<slot>这是没有内容分发的时候显示的</slot> 
<slot name="a"> 实名插槽 </slot>
<slot name="scoped" text="作用域插槽s"> 作用域插槽 </slot>

<!-- 使用插槽 在组件内部进行dom的传递 并且还能获取到插槽传递的值  -->
<slot-demo> 
    <p> 匿名插槽 </p>
    <p slot="a"> 内容  </p>  
    <p slot="scoped" slot-scope = "a"> {{a.text}} </p>
</slot-demo>
```

##### 自定义指令

###### 全局指令

Vue.directive("bg",{
      inserted:(el)=>{
      	  el.style['background'] = "red";
      }	
})

###### 局部指令

  directives:{
           "focus":{
              inserted:e=>{
                 e.focus();
              }
           }
      }

##### Vue lazyload第三方包

+ 下载安装  npm i -S vue-lazyload

+ 使用

  + ```html
    <img v-lazy="imgUrl('https://ss2.bdstatic.com/70cFvnSh_Q1YnxGkpoWK1HF6hhy/it/u=764856423,3994964277&fm=27&gp=0.jpg')"/>
    ```

    ```javascript
     
    data(){
        return {
            imgUrl:{
                src:"默认图片",
                error:"发生错误后的替补图片",
                loading:"加载中的图片"
            }
        }
    }
    
    methods:{
           imgUrl:url=>{
         //局部配置
               return {
               src:url,                                       
     error:"https://ss1.bdstatic.com/70cFvXSh_Q1YnxGkpoWK1HF6hhy/it/u=3779605030,1222595953&fm=27&gp=0.jpg ",
      loading:"https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1536845811374&di=35f820628f03b0a5f2fdd66c05327333&imgtype=0&src=http%3A%2F%2Fs1.knowsky.com%2F20151009%2F20151022223245155.gif "
    
                    }
                }
            }
    ```

##### fetch 请求 直接可以使用

  fetch("/apis/test/testToken.php",{
            method:"post",
            headers:{
                token:"f4c902c9ae5a2a9d8f84868ad064e706"
            },
            //传递参数
            body:JSON.stringify({
                username:"lee",
                password:"123456"
            })
        }).then(result=>{
            console.log("fetch");
            // fetch的body里面有一个流 需要进行json解析 我们这里直接返回就好 返回的是一个promise对象
            return result.json();
        }).then(data=>{
            console.log(data) ;
        });

##### Vuex   （Vue状态管理仓库 -- 数据共享） 

+ 在 Vuex 里面修改数据是被动的 不能够主动修改

```javascript
import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex);

//创建一个store仓库管理状态state count是里面的值 共享的数据
export default new Vuex.Store({
    state:{
        count:0
    },
    //进行计算操作 修改值  里面传一个state状态对象  调用的话通过$store.commit('函数名称进行调用')
    mutations:{
        //可以接受第二个参数 就是动态传递的值
        add(state,data){
            state.count++;
        },
        rem(state){
            state.count--;
        }
    },
    //如果需要进行请求  或者 异步操作的需要使用actions 调用通过$store.dispatch('') 来调用Mutations里面的方法
    //里面则传递一个参数可以调用commmit方法
    actions:{ //可以接受第二个参数
        add(mutations,data){
            setTimeout(e=>{
                mutations.commit('add');
            },1000)

        },
        rem(mutations){
            setTimeout(e=>{
                mutations.commit('rem');
            },1000)
        }
    },
    //可以做个判断 更加的合理 让state里面的数据进行一些逻辑上的运算再返回出去
    //里面传入一个state对象
    getters:{
        getCount(state){
            return state.count > 0 ? state.count : 0;
        } 
    }
})


// state
// mutations
// actions
//getters
//$store.state.属性名       state  
//$store.getters.getCount   getters
//$store.commit('方法名')   mutations
//$store.dispatch('方法名') actions
// 在Vue实例里面通过 this.$store.xxx调用
例如    this.$store.dispatch('add',"第二个参数的值")
```



##### 在vue-cli中使用sass 与 在 自己搭建的脚手架使用sass一样

+ 安装  sass-loader  node-sass
+ 然后配置 
+ ​           {
                  test:/\\.(sass|scss)/,
                  use:['style-loader','css-loader','sass-loader']
              }
+ 在 style 中 设置 lang="sass"

##### Vue SSR 学习视频地址

https://ke.qq.com/course/218393 

##### Vuex 学习视频地址

https://ke.qq.com/course/342368

##### Vue SSR 免费视频地址

https://www.bilibili.com/video/av36353273?from=search&seid=8165673801680951523

## Vue高级 在学习

### Vue 实例**属性**

+ **Instance.$data**		获取到Vue实例Data里面的属性
+ **Instance.$root**            获取到Vue实例
+ **Instance.$set(obj,property,value)**        设置某个对象里面的某个属性            
+ **Instance.$delete**                               删除某个对象中的某个属性
+ **Instance.$refs**                                    获取到引用的组件或者DOM节点
+ **Instance.$options**                             获取到Vue中的选项
+ **Instance.$on**                                      绑定事件 
+ **Instance.$emit**                                  触发事件
+ **Instance.$forceUpdate()**                强制刷新页面
+ **Instance.$watch()**                            监听器  一般在组件内部用 用完了就销毁了
+ **Instance.$once()**                               绑定事件 只触发一次
+ **Instance.$el**                                       获取到Vue绑定的DOM
+ **Instance.$props**                               获取到组件属性传递的值
+ **Instance.$slots**                                 获取到插槽内容
+ **Instance.$scopedSlots**                   获取到作用于插槽 
+ **Instance.$mount()**                          绑定DOM节点
+ **Instance.$options.render = (h)=> h(App)**        return h("div",{},"value")    渲染页面组件      
+ **Instance.$children**                          获取到插槽的子节点
+ **Instance.$isServer**                           是否是服务端渲染

### 生命周期

+ 常在组件中用的template最后还是被编译成了render去渲染 使用template不如render效率高

```js
beforeCreate(){
    console.log("获取不到当前Vue实例")
},
create(){
    console.log("获取不到当前的Vue实例 组件创建后")
},
beforeMount(){
     console.log("服务端渲染的时候不会被调用")
},
mounted() {
     console.log("在服务端渲染的时候不会被调用")
},
beforeUpdate(){

},
update(){

},
beforeDestroy(){
    console.log("销毁之前")
},
destory(){
    console.log("销毁之后")
}
renderError(h,err){
    console.log("渲染出现错误的时候 执行  仅限于当前组件")
},
errorCaptured(){
        console.log("子组件出现错误也会捕获,前提是正常的向上冒泡")
}
```

### Watch

```js
watch(){
    firstName:{
        handler:function(newValue,oldValue){
            
        }
    },
    "obj.a":{
        handler:function(newValue,oldValue){
            
        }
    }
}
```

### Render

+ Vue的Template最后还是被编译成了Render方法进行渲染 会创建一个VNode节点  虚拟DOM 会去和真正的DOM作比较 发现有需要更新之后就会去进行更新  render是通过一个createElement方法进行编译处理的
+ render方法的参数就是createElement接受三个参数 第一个是节点名称可以是组件名称 第二个参数是属性 第三个参数是内容 如果是一个新的节点的 话就需要传入一个数组

### Provide - inject

+ 可以实现子孙辈的数据传递
+ provide需要返回一个对象    不返回对象的话 在里面调用this是不成功的  因为VUe实例这时候还没有初始化成功

### Router

+ 配置参数
  + name
  + path
  + meat
  + props             将传递的参数通过属性的方式传递给目标组件 不需要早通过 this.$route获取
  + component
  + components
  + children
  + redirect

### 异步路由

+ 节省开销

+ 首屏加载更快

+ 不浪费资源

+ 使用

  ```
  component:()=>import("../component/hello.vue")  //只会在进入到当前组件才会加载js
  ```