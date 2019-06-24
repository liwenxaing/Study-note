# mpVue 学习笔记
## 创建一个mpvue项目
 1. vue init mpvue/mpvue-quickstart project
 2. 需要提前安装 vuecli  
    1.  npm install --global vue-cli   
## 获取用户信息 访问用户是否授予权限
 1. 使用小程序原生的button 里面有一个open-type='getuserinfo' 就是获取用户信息的 有一个回调函数 bindgetuserinfo='方法名'
 2. 在回调函数里面有一个参数就是返回的信息  看 detail  在 mp 里面
## 绑定事件
 1. @tap="eventName"   @click="eventName"
## 组件
 1. 一个组件可以不挂载当前页面 但是 需要 添加main.js  不写内容可以
    1. 使用
       1.  import  componentName from 'componentNameAndUrl'
       2.  components{ componentName }
## 细节

+ 在每一次新建完毕新页面的时候都需要重新启动一下服务器
+ 在每一次在pages里面添加页面得时候 结尾总是 main
+ 因为 mpvue 将每一个页面打包后的wxml名称都编译成了 main

##  跳转传参数

  1. 使用navigateTo跳转时除了原生的onLoad方法  还可以使用Vue的beforeMount 通过访问this实例 就可以访问 $mp 里面有一个query 就保存着查询字符串的值
## 分享
  1. button 的 open-type = share 即可分享
## 网络请求
  1. 在小程序中不支持axios 
  2. 因为环境不同  axios 底层封装的是XMLHttpRequest 是输入windo对象的 而小程序没有window对象
  3. 我们如果不想使用 wx.request 的话可以使用 fly.js 请求
  4. 安装
     1. npm install flyio
  5. 使用
     1. import Fly from 'flyio/dist/npm/wx' || require('flyio/dist/npm/wx')
     2. let fly = new Fly   没有小括号
     3. 挂载到Vue的原型上面使每一个实例都可以用
        1. Vue.prototype.$fly = fly;
  6. github地址 
     1. https://github.com/wendux/fly
     2. 里面有具体的使用方法
## Vuex
 1. 使用扩展运算符 将 state里面的属性映射到当前实例上   例如 ...mapState({arrList})