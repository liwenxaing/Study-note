# webpack 笔记
## webpack是什么?
+ 打包工具 （模块打包器）
+ 前端工程师必不可少的工具
+ webpack 4.x
## webpack作用
+ 打包(依赖关系) -> 把多个文件打包成一个js文件  减少请求 节省带宽 减少服务里的压力
+ 转化 (比如 sass / less / ts)  需要 loader
+ 优化 (SPA webpack可以对项目进行一些优化)
##package.json 文件  npm 脚本 (scripts)

- 在此此文件中的 scripts 中添加属性 值为要执行的命令 
- 就可以使用 npm run 你设置的属性名调用了 方便
- 默认webpack为在node_modules/.bin/webpack



##安装执行

- ```shell
  npm init -y  配置项文件
  npm install -g webpack   全局安装  安装过可省略  不推荐使用
  npm install --save-dev webpack    此命令在某一个文件夹 执行完之后  所有的依赖就装好了
  npm install --save webpack@2.3.6 这样可以指定版本号 针对所有第三方包
  ```

- npm install --save和npm install --save-dev的区别：

- --save 会把依赖包名称添加到 package.json 文件 dependencies 键下，--save-dev 则添加到 package.json 文件 devDependencies 键下。dependencies是发布后还依赖的，devDependencies是开发时的依赖。

- 如果安装的 是webpack4.x版本 ，则还需要安装webpack-cli  否则webpack命令运行不了 

- 使用的是npm5以上的话 会有一个 package-lock.json 文件

- ```shell
  npm uninstall webpack-cli //卸载本地安装的webpack-cli
  npm install -g webpack-cli//全局安装webpack-cli
  npm install --save-dev webpack-cli //把webpack-cli安装到devDependencies
  ```

- 新建src文件夹  新建一个入口js文件app.js 新建一个写代码的js文件  入口文件 引入写代码的js文件

- 然后在src同级目录 创建一个根视图 index.html 里面的script标签引入的就是打包之后的js文件

- ./dist/main.js

- 在打包成功之后 会自动生成一个dist文件夹 里面有main.js

- 然后使用webpack  入口文件路径  进行打包   例如   webpack src/app.js

- 每一次都需要执行webpack 入口文件比较麻烦  下面配置一下 webpack.config.js 文件



## 构成

+ 入口文件 **entry**
+ 出口文件 **output**
+ loaders  **转化** 
+ plugins  **插件**
+ devServer **开发服务器**
+ mode 模式 (生产模式、开发模式) 4.x 多的
## 安装webpaack
> npm  先必须确保node环境已经安装
```npm install webpack-cli -g```
```npm install webpack -g```
## 开发环境(development)
+ 就是平常写代码的环境  
## 生产环境(production)
+ 项目开发完毕 部署上线
## 跑一跑webpack
+ 原始命令 入口 与 出口 一般不这么用
+ webpack src/index.js --output dist/bundle.js 
## 配置文件
+ **webpack.config.js**
+ 预览
 - 入口文件 (entry -> 属性名自定义 : 入口文件路径)
 - 出口文件 (output -> filename : '' , path : 路径)
 - 加载器   (loaders -> module.rules[ { test:/\.css$/,use['css-loader'] } ])
 - 插件     (plugins -> new HtmlWebpackPlugin({ title:"  " })) 
 - 开发服务器 (devServer) 
 - 开发模式  (mode -> 'production' | 'develepment') 
> 如果在配置文件配置好入口文件与出口文件的话就可以直接发webpack命令就可以了
## 修改webpack.config.js 配置文件为别的文件名称
+ 如果修改了此配置文件名为别的名称的话 需要这么使用
+ `webpack --config 你自己设置的配置文件名称`
+ 如果不这样写的话 打包过后的文件名就是一个main.js
## npm scripts
+ 可以在里面配置属性 值为要执行的命令  然后使用npm run 你设置的属性名 更加的方便
## 消除警告
+ 就是配置文件缺少一个mode配置 就是开发环(devlepoment)境与生产环境(production)
## 多入口 单出口
+ 如果entry里面是一个数组的话 会按照顺序打包 多入口对单出口
``` entry: [ './src/index.js','./src/index2.js' ]  ```
## 多入口 多出口 Hash更新
+ entry:{} json的形式  在output的时候加上动态出口  filename:'[name].js'    [hash].js 随机的一个hash文件名       |           [hash:6].js 随机的一个6位的hash文件名
+ 如果文件没有改动就会走缓存  改动了就更新
+ 出口里也有一个publicPath:"/" 配置  配置这样之后打包后会从根路径进行查找 默认是相对的 如果出现打包后的路径问题的话可以设置这个属性
## html-webpack-plugin 生成index.html页面 动态引入生成的js文件
+ 安装 ` npm install --save-dev html-webpack-plugin `
+ 引入 ` const HtmlWebpackPlugin = require(' html-webpack-plugin ') `
+ 依赖 webpack 如果本地不安装webpack的话是运行不起来的
+ webpack 依赖 webpack-cli 所以的话还需要在本地安装webpack-cli 才能运行起来
+ 安装 ` npm install --save-dev webpack-cli `  
### html-webpack-plugin 的使用
  ```
  const HtmlWebpackPlugin  = require(" html-webpack-plugin ") 
   plugins:[
       new HtmlWebpackPlugin({
               # 使用的模板
               template:'./src/index.html'
               # 清除缓存
               hash:true,
               # 设置标题  但是如果使用了模板的话需要在html文件中加入 <% htmlWebpackPlugin.options.title %> 才能使用
               title:' 这是标题 ',
               # 优化 压缩  
               minify:{
                   # 去除空格
                   collapseWhitespace:true
                   # 删除属性的双引号
                   removeAttributeQuotes:true 
               }
       }) 
   ]

  ```
### 生成多个页面 
  + 就是多实例几次 就可以了 但是要有个与之对应的模板  默认生成的多是index.html  
  + 这里需要指定生成的页面名称 里面有个属性名称是 filename:值就是你设置的名称 
  + 指定引入的js文件
  + 在里面有一个chunks:['index'] 配置 在里面可以写入口里面的属性名称 
### 清除某些东西 比如用不到的文件 clean-webapck-plugin
  + 安装 下载  ` npm install --save-dev clean-webpack-plugin `
  + 引入
  + 使用  new CleanWebpackPlugin(['dist'])  指定要删除的文件夹
## 热更新 服务器 webpack-dev-server
  + 安装 下载 ` npm install --save-dev webpack-dev-server `
  + 使用 直接用
  + 配置
    ``` 
      配置完之后就可以自动刷新了
      devServer:{ 
        // 设置服务器访问的基本目录
        contentBase:path.reslove(__dirname,'dist'),
        // 设置端口
        port:9000
        // 设置服务器的ip地址
        host:"localhost",
        //配置热更新 就是值更新某一个区域 但是直接这样配置还是有一点问题的必须要启用 这就依赖了 webpack 里面的一个实例
        hot:true,
        //这个配置是自动打开浏览器
        open:true  //也可以在package.json 文件中配置 
      } 

      还需要在webpack.config.js 中 引入webpack 在plugins中实例 new webpack.hotMoudle ..... 这个对象才能用

      我们可以在package.json 中的 scripts 中配置属性 dev : 'webpack-dev-server --open --mode development'  这样就可以直接使用 npm run dev 启动这个服务器了~
    ```
## loaders 处理css 以及压缩方式
 + 加载器 转化器
  - **处理css文件**
    ```
      module:{
        rules:[ // 规则
          {
            test:/\.css/, //这是测试的文件格式
            use:[,'style-loader','css-loader']  //需要加载的loader 可以有多种写法
            loader:['style-loader','css-loader'] //和上面的use是一样的 写一个就够了
          }
        ]
      }
      
    ```
  + 压缩方式
   - 在webpack4.x中 设置mode为开发环境在打包的时候就会自动将代码进行压缩
   - 在webpack4.x前 可以使用 uglifyjs-webpack-plugin 这个插件  引用 并且实例化 new uglifyjs() 即可 
## 加载图片 等资源
  + 在webpack中加载图片的话还需要引入特别的插件来进行支持
    - file-loader url-loader
  + 安装
    - npm i -D file-loader url-loader
    - 配置  url-loader 依赖 file-loader
    - module:{ rules : [ { test:/\.(png|gif|jpg)$/,use:['url-loader'] } ] }
## 加载字体文件

+ 需要file-loader

+ ```js
  {
      test:/\.(eot|svg|ttf|woff|woff2)(\?\S*)?$/,
          loader:'file-loader'
  }
  ```

+ 上面代码添加到webpack.config.js文件中的module.rules中去

## 分离 css webpack原意是不想分离的 所以要分离有一些麻烦

 + ```
   mini-css-extract-plugin
   ```

+ ```
  {
      test: /\.css$/,
      use:[MiniCssExtractPlugin.loader,"css-loader",{
          loader: "postcss-loader",
          options: {
              plugins: () => [require('autoprefixer')]
          }
      }]
  },
  ```
## less、ssss、处理、前缀、消除冗余css

 + 安装less 
  - 需要安装 less 和 loader-less 
  - 在useloader的时候编译是从右向左的 所以需要 style-loader css-loader less-loader 顺序不能乱 先解析less到css在到style标签
 + 安装sass
  - 需要安装 node-sass sass-loader
  - 在useloader的时候编译是从右向左的 所以需要 style-loader css-loader sass-loader 顺序不能乱 先解析sass到css在到style标签
 + 如果需要分离的话 是和 分离css一样的步骤 用同一个插件
## 消除荣誉CSS代码 在打包的时候会扫描没用到的样式 从而减少体积
 + PurifyCss
 + 下载
   - npm install purifycss-webpack purify-css --save-dev
 + 引入插件
   - const PurifyCssWebpack  = require('purifycss-webpack')
 + 需要额外引入一个包
   - glob 安装  引入
     - npm i -D glob   const glob = require('glob');      
 + 在plugin里配置
   - new  PurifyCssWebpack({ paths:glob.sync(path.join(__dirname,'src/*.html')) });
## 调试
 + webpack 4.x 开启调式
  - 将mode就是开发模式改为devlopment就可以在浏览器的source选项中的webpack查看项目的原目录结构进行调试
  - 修改为production就没有这个功能了    
 + webpack3.x 调试
  - 在webpack配置文件中加上  devtool:"source-map" 就可以了
## babel  编译ESNEXT
 + 需要三个包 下载
  - npm i -D babel-core babel-laoder babel-preset-env  
  - 配置1
    - 在rules中   1.  { test:/\.(js/jsx)/,use[{ loader:'babel-loader',options:{ preset:"env" } }],exclude:/node_modules/  } 
    - 上面是第一种配置方式  最后的exclude 是表示不编译node_modules文件夹下的js文件  不推荐 但是也可以
  - 配置2
   - 在rules中   { test:/\.(js/jsx)/,use['babel-loader'],exclude:/node_modules/  } 
   - 然后新建 .babelrc 文件 配置 { "preset":[ "env" ] } 即可
## 模块化配置 json配置 静态资源 插件
 + 模块和node中的使用是一样的
 + json的话webpack3.x之后默认支持的 require() 进来就直接可以用了
 + 静态资源输出 
   - 安装插件 npm install  copy-webpack-plugin -D
   - 配置  引入  const CopyWebpackPlugin = require('copy-webpack-plugin')
   - 使用  new    CopyWebpackPlugin([{form:path.join(__dirname,'./src/assects'),to:'./public'}]);  
   - 从src文件夹下的assects文件夹 移动输出到 public文件夹下  从生成的dist文件夹看起
## 使用第三方库
 + 例子 1.  下载jquery
  - npm i jquery -S
  - 引入 import $ from 'jquery'
 + 例子 2.  在全局暴露jq可以直接使用 在webpack中内置了一个插件 不需要安装 但是需要有webpack
  - 配置   new webpack.ProvidePlugin({ $:'jquery'}) 然后就可以使用了
 + 两种区别
   - import 引入的话如果不使用用jq还是会吧jq打进去 浪费了内存 
   - 第二种则不会       
 + 分离JS
 + 在entry中使用jquery:"jquery" 库名称
 + 在output中可以使用动态名称
   -     ![img](file:///C:\Users\Administrator\AppData\Roaming\Tencent\Users\2857734156\QQ\WinTemp\RichOle\%Q0F@MTHBA_V]T@GS2GF~JA.png) 

## 提取第三方包文件

webpack 4.x 以前  使用CommonsChunkPlugin

CommonsChunkPlugin已在webpack v4 legato中删除。要了解最新版本中如何处理块，请查看[SplitChunksPlugin](https://webpack.js.org/plugins/split-chunks-plugin/)。 

4.x 之后 使用 SplitChunksPlugin

webpack4中支持了零配置的特性，同时对块打包也做了优化， `CommonsChunkPlugin` 已经被移除了，现在是使用 `optimization.splitChunks` 代替。 

这是与entry同级的配置项

   optimization: {
         splitChunks: {
          chunks: 'all',
          cacheGroups: {
                vendors: {

​                //匹配的第三方包 要分离的 没有使用不会进行打包

​                  test: /[vue][jquery]/,
                   name: 'vendors'
                }
          }
   }





**配置项**

相关配置项：

module.exports = {
 //...
 optimization: {
 splitChunks: {
  chunks: 'async', 
  minSize: 30000,
  minChunks: 1,
  maxAsyncRequests: 5,
  maxInitialRequests: 3,
  automaticNameDelimiter: '~', 
  name: true,
  cacheGroups: {}
 }
 }
}

- chunks: 表示哪些代码需要优化，有三个可选值：initial(初始块)、async(按需加载块)、all(全部块)，默认为async
- minSize: 表示在压缩前的最小模块大小，默认为30000
- minChunks: 表示被引用次数，默认为1
- maxAsyncRequests: 按需加载时候最大的并行请求数，默认为5
- maxInitialRequests: 一个入口最大的并行请求数，默认为3
- automaticNameDelimiter: 命名连接符
- name: 拆分出来块的名字，默认由块名和hash值自动生成
- cacheGroups: 缓存组。缓存组的属性除上面所有属性外，还有test, priority, reuseExistingChunk
  - test: 用于控制哪些模块被这个缓存组匹配到
  - priority: 缓存组打包的先后优先级
  - reuseExistingChunk: 如果当前代码块包含的模块已经有了，就不在产生一个新的代码块

## 提取的好处

比如只修改了css文件 这时候css文件会和js文件载一块 那么修改之后就会重新加载整个js文件

提取出来就仅仅会加载这个css文件 只会重新加载修改了的文件每一次打包后 还有如果没有更新的话就会走缓存省流量

## Vue 打包后控制台的输出信息 与警告去除

在plugin里面加入以下代码

new webpack.DefinePlugin({

   'process.env':{

​          NODE_ENV:'"production"'

​    }

})

webpack 4 .x 去除警告设置mode:"production"

