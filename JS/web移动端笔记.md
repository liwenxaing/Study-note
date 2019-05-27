# WEB移动端笔记

## 站点模式

+ 移动站
+ 响应式站点
+ 最大宽度  640px  最小宽度 320px

## 问题

+ 适配问题

## 解决方案

+ 流式布局  百分比
+ 标准适配方案 <meta name="viewport" content="width=device-width,initial-scale=1.0"> 
+ 非主流适配方案  根据设备像素比缩放 显示的更清晰  但是适配成本比较高 一般不使用

## 开发建议

+ 不建议使用jq 因为jq封装兼容了大多数pc端浏览器 特别是IE

+ 使用的话会造成冗余

+ 可以使用h5的api 或者 zepto.js 基于高版本浏览器开发

+ 设置

  + ```css
    /* 有效防止内容溢出 */
    -webkit-box-sizing:border-box
    box-sizing:border-box
    ```

## 点击过渡

```css
a{
        transition:background  0.2s;
        display: block;
        width: 100px;
        height:  100px;
        background: #eee;
    }
     a:active{
         background: red;
     }
```

## 双飞翼 -- 圣杯 布局

+ 两侧固定布局  中间自适应
+ 可以采用两侧不占位 定位 
+ 中间内容使用一个容器百分之百包裹
+ 设置左padding为左侧固定容器的宽度 设置右padding为右侧容器的宽度
+ 设置百分百容器box-sizing:border-box

## 移动端事件

+ touchstart  触摸开始
+ touchmove   触摸移动
+ touchend   触摸结束
+ touchcancel  被迫取消触摸
+ 推荐使用 addEventListener('eventName',callback)  监听
+ 事件属性
  + changedTouches[0].clientX | clientY
  + touches[0].clientX | clientY

## 转化时分秒

+ 有一个总时间   time =     例如  1 * 60 * 60 这是一小时的秒数       1\*60\*60*24 这是一天的秒数
+ 计算时     Math.floor(time/3600)
+ 计算分     Math.floot(time%3600/60)
+ 计算秒     time%60

## 两栏自适应

+ 可以给左栏设置浮动
+ 右栏设置 overflow:hidden 自适应
+ 设置的意思是不让浮动元素影响到自己 自己也不影响到别的浮动元素

## 移动端 isScroll 滚动插件

+ 区域滚动效果

+ 使用

  + ```javascript
    //先引入
    
    //实例化
    new IScroll(DomNode,{
        scrollX:false,
        scrollY:true
    })  // 使用完毕
    ```

## 使用bootstrap自定义样式套路

+ 可以复制某一个模块的所有样式源码到自己的css中
+ 将自己的样式文件引入在bootstrap的样式文件后面
+ 然后通过f12进行调试 找出每一个元素对应的样式进行修改

## rem and em  适配

+ em 是相对父类容器的字体大小的
+ rem 是相对于html的字体大小
+ 浏览器默认字体16px
+ 使用rem适配修改高度
+ 一般将基准值设置为100px 好计算
+ 最小屏320px 和 ipad 640px 可以使用media 检测改变html的字体大小
+ 其他屏幕可以通过换算   预设值(100px)/设计稿宽度(640px)*屏幕宽度(320px)

## Zepto.js  移动端轻量级库

+ 针对现代高级版本浏览器
+ 应用场景不是pc端开发
+ 在移动端加载快
+ 类似于jquery 语法很类似
+ 需要注意的就是模块问题   需要引入 

### 常用方法

+ 写插件

  + ```javascript
    // 为  $.fn 上面添加属性  $.fn = $.prototype
    $.extend($.fn,{
        foo:function(){
            this.html("bar");
        }
    })
    ```

  + 引入的zeptojs文件  默认只包含了五个模块  包括核心方法

  + 想要使用其他的模块可以对应的引入

  + 主要就是模块问题 分开了 使用需要引入进来

### 手势事件

+ swipeLeft   向左
+ swipeRight   向右
+ swipeTop  向上
+ swipeBottom  向下

### Zepto 模块

| module                                                       | default | description                                                  |
| ------------------------------------------------------------ | ------- | ------------------------------------------------------------ |
| [zepto](https://github.com/madrobby/zepto/blob/master/src/zepto.js#files) | ✔       | 核心模块；包含许多方法                                       |
| [event](https://github.com/madrobby/zepto/blob/master/src/event.js#files) | ✔       | 通过`on()`& `off()`处理事件                                  |
| [ajax](https://github.com/madrobby/zepto/blob/master/src/ajax.js#files) | ✔       | XMLHttpRequest 和 JSONP 实用功能                             |
| [form](https://github.com/madrobby/zepto/blob/master/src/form.js#files) | ✔       | 序列化 & 提交web表单                                         |
| [ie](https://github.com/madrobby/zepto/blob/master/src/ie.js#files) | ✔       | 增加支持桌面的Internet Explorer 10+和Windows Phone 8。       |
| [detect](https://github.com/madrobby/zepto/blob/master/src/detect.js#files) |         | 提供 `$.os`和 `$.browser`消息                                |
| [fx](https://github.com/madrobby/zepto/blob/master/src/fx.js#files) |         | The `animate()`方法                                          |
| [fx_methods](https://github.com/madrobby/zepto/blob/master/src/fx_methods.js#files) |         | 以动画形式的 `show`, `hide`, `toggle`, 和 `fade*()`方法.     |
| [assets](https://github.com/madrobby/zepto/blob/master/src/assets.js#files) |         | 实验性支持从DOM中移除image元素后清理iOS的内存。              |
| [data](https://github.com/madrobby/zepto/blob/master/src/data.js#files) |         | 一个全面的 `data()`方法, 能够在内存中存储任意对象。          |
| [deferred](https://github.com/madrobby/zepto/blob/master/src/deferred.js#files) |         | 提供 `$.Deferred`promises API. 依赖"callbacks" 模块.  当包含这个模块时候, [`$.ajax()` ](https://www.css88.com/doc/zeptojs_api/#$.ajax)支持promise接口链式的回调。 |
| [callbacks](https://github.com/madrobby/zepto/blob/master/src/callbacks.js#files) |         | 为"deferred"模块提供 `$.Callbacks`。                         |
| [selector](https://github.com/madrobby/zepto/blob/master/src/selector.js#files) |         | 实验性的支持 [jQuery CSS 表达式](https://www.css88.com/jqapi-1.9/category/selectors/jquery-selector-extensions/) 实用功能，比如 `$('div:first')`和`el.is(':visible')`。 |
| [touch](https://github.com/madrobby/zepto/blob/master/src/touch.js#files) |         | 在触摸设备上触发tap– 和 swipe– 相关事件。这适用于所有的`touch`(iOS, Android)和`pointer`事件(Windows Phone)。 |
| [gesture](https://github.com/madrobby/zepto/blob/master/src/gesture.js#files) |         | 在触摸设备上触发 pinch 手势事件。                            |
| [stack](https://github.com/madrobby/zepto/blob/master/src/stack.js#files) |         | 提供 `andSelf`& `end()`链式调用方法                          |
| [ios3](https://github.com/madrobby/zepto/blob/master/src/ios3.js#files) |         | String.prototype.trim 和 Array.prototype.reduce 方法 (如果他们不存在) ，以兼容 iOS 3.x. |

 ## Swiper轮播插件

+ 使用简单 可以去百度搜索看文档
+ 引入css 引入 js
+ 如果项目中引入了jquery或者zepto那么就可以使用seper.jquery.min.js
+ 在dist文件夹下面

https://www.swiper.com.cn/api/effects/196.html