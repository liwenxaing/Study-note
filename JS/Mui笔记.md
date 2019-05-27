# MUI 笔记

# 效果部分

## 初始化

+ 需要调用mui.init()初始化  插件初始化
+ 需要使用h5+ 的话  mui.plusReady(function(){})   页面初始化  这个必须在真机才能运行
+ 真机测试  在手机上 进去设置 关于  找到软件版本号点击7次  开发者选项就进去了  默认是隐藏的

## 基础布局

```html
 <!--  基础布局  头部  -->

	 <!--  Muijs内部默认写好了返回的按钮  -->

	 <header class="mui-bar mui-bar-nav">

		 <a class="mui-action-back mui-icon  mui-icon-left-nav "> </a>

         <h1 class="mui-title"> 李文祥 </h1>	 	

	 </header>

	 <!-- 主体   如果存在头部 这个mui-content会自动加上padding-top 给头部区域让出来-->

	 <div class="mui-content">

	 	 123

	 </div>

```

## 折叠面板

```html
// 折叠面板 必须在mui-table-view中
<div class="mui-content">
	 	 <ul class="mui-table-view">
             // 如果想要哪一个项默认显示  只需要加上 mui-active 类 即可
	 	 	  <li class="mui-table-view-cell mui-collapse mui-active">
                   <a class="mui-navigate-right" href="#"> 面板1</a>	 	 	  	  
	 	 	       <div class="mui-collapse-content"> 
				       <p> 我是面板一内容 </p>
				  </div>
			  </li>
	 	 </ul>
	 </div>
```

## 按钮

```php+HTML
<button type="button" class="mui-btn">
    点击我
</button>
<button type="button" class="mui-btn mui-btn-danger">
    喜欢你
</button>
// outlined 是线条按钮
<button type="button" class="mui-btn mui-btn-danger mui-btn-outlined">
    喜欢你
</button>
```

## actionSheet,badge

```html
	   
//通过点击 触发底部菜单的调用
<button type="button" class="mui-btn mui-btn-blue" onclick="showMenu()">点击这里</button>

<div id="sheet1" class="mui-popover mui-popover-bottom mui-popover-action ">
    <!-- 可选择菜单 -->
    <ul class="mui-table-view">
        <li data-id="1" onclick="getValue(this)" class="mui-table-view-cell">
            <a href="#">1菜单1</a>
        </li>
        <li data-id="2" onclick="getValue(this)" class="mui-table-view-cell">
            <a href="#">2菜单2</a>
        </li>
    </ul>
    <!-- 取消菜单 -->
    <ul class="mui-table-view">
        <li class="mui-table-view-cell">
            //和最外层容器的id是一样的
            <a href="#sheet1"><b>3取消</b></a>
        </li>
    </ul>
</div>
<script type="text/javascript">
    function showMenu(){
        mui("#sheet1").popover("toggle");
    }
    
    function getValue(e){
        console.log(e);
        alert(e.dataset['id']);
        if(e.dataset['id'] == "1"){
            alert("菜单1");
        }else{
            alert("菜单2");
        }
    }
</script>

## badge
<span class="mui-badge mui-btn-blue">2</span>
<span class="mui-badge mui-btn-green">1</span>
<span class="mui-badge mui-btn-danger">1</span>	

```

## 纯JS底部弹出菜单  常用

```javascript
mui.plusReady(function(){
    var btnArray = [{title:"相机"},{title:"相册"}];
    document.getElementsByTagName("button")[0].addEventListener("tap",function(){
        plus.nativeUI.actionSheet({
            title:"选择图片",
            cancel:"取消",
            buttons:btnArray
        },function(e){
            var index = e.index;
            switch(index){
                case 1:
                    break;
                case 2:
                    break;
            }
        });      
    });
});
```



## checkbox radio

```html
<div class="mui-input-row mui-checkbox ">
    <label>Checkbox</label>
    <input name="Checkbox" type="checkbox" checked>
</div>
<div class="mui-input-row mui-checkbox ">
    <label>Checkbox</label>
    <input name="Checkbox" type="checkbox" checked>
</div>
<div class="mui-input-row mui-checkbox ">
    <label>Checkbox</label>
    <input name="Checkbox" type="checkbox" checked>
</div>


<div class="mui-input-row mui-radio ">
    <label>Radio</label>
    <input name="radio" type="radio" checked>
</div>
<div class="mui-input-row mui-radio ">
    <label>Radio</label>
    <input name="radio" type="radio" checked>
</div><div class="mui-input-row mui-radio ">
    <label>Radio</label>
    <input name="radio" type="radio" checked>
</div>
```

## Toast

 mui.toast('你好'); 

## 时间选择器  datepicker

## Dialog input

```javascript
提示框
mui.alert('hi...','小提醒','ok',callback);
确认框
mui.confirm('真的要删除吗？','提示',['取消','确定'],function(e){
    if(e.index == 1){
        mui.toast('删除成功');
    }else{
        mui.toast('您取消的删除');
    }
}); 
输入框
mui.prompt('亲输入您的邮箱','2857734156@qq.com','操作',['取消','确认'],e=>{
    if(e.index == 1){
        mui.toast(e.value);
    }else{
        mui.toast('您没有输入');
    }
});
// 提示
plus.nativeUI.alert(123)
// 等待框
var w = plus.nativeUI.showWaiting("加载中");
setTimeout(function(){
    w.close();
},2000);

```

## Form

```html
<form class="mui-input-group">
    <div class="mui-input-row">
        <label>姓名</label>
        <input type="text" class="mui-input-clear" placeholder="请输入">
    </div>
    <div class="mui-input-row">
        <label>年龄</label>
        <input type="number" class="mui-input-clear" placeholder="请输入">
    </div>
    <div class="mui-input-row">
        <label>生日</label>
        <input type="text" class="mui-input-clear" placeholder="请输入">
    </div>
    <div class="mui-button-row">
        <button type="button" class="mui-btn mui-btn-blue">取消</button>
        <button type="button" class="mui-btn mui-btn-blue">确定</button>
    </div>
</form>
```

## 轮播

```html
<div id="slider" class="mui-slider" >
    <div class="mui-slider-group mui-slider-loop">
        <!-- 额外增加的一个节点(循环轮播：第一个节点是最后一张轮播) -->
        <div class="mui-slider-item mui-slider-item-duplicate">
            <a href="#">
                <img src="a.jpg">
            </a>
        </div>
        <!-- 第一张 -->
        <div class="mui-slider-item">
            <a href="#">
                <img src="a.jpg">
            </a>
        </div>
        <!-- 第二张 -->
        <div class="mui-slider-item">
            <a href="#">
                <img src="a.jpg">
            </a>
        </div>
        <!-- 第三张 -->
        <div class="mui-slider-item">
            <a href="#">
                <img src="a.jpg">
            </a>
        </div>
        <!-- 第四张 -->
        <div class="mui-slider-item">
            <a href="#">
                <img src="a.jpg">
            </a>
        </div>
        <!-- 额外增加的一个节点(循环轮播：最后一个节点是第一张轮播) -->
        <div class="mui-slider-item mui-slider-item-duplicate">
            <a href="#">
                <img src="a.jpg">
            </a>
        </div>
    </div>
    <div class="mui-slider-indicator">
        <div class="mui-indicator mui-active"></div>
        <div class="mui-indicator"></div>
        <div class="mui-indicator"></div>
        <div class="mui-indicator"></div>
    </div>
</div>
<script type="text/javascript">
    mui.init()	 

    mui.plusReady(function(){ //在真机才会起作用

    });

    mui('#slider').slider({
        interval:2000,
        autoplay:2000
    })  //开启自动播放

    document.querySelector(".mui-slider").addEventListener("slide",function(event){
        console.log(event.detail.slideNumber); // 当前第几张图片
    })
    
    
    mui('#slider').slider(); //在ajax请求图片路径后在调用一下 否则有可能出现bug
</script>
```

## Mui选择器

mui(selector)  返回的是一个集合  通过数组的形式访问[0].....

## 基础列表

```html
<ul class="mui-table-view">
    <li class="mui-table-view-cell">
        <a class="mui-navigate-right">
            大家好哦
        </a>
    </li>
    <li class="mui-table-view-cell">
        大家好哦
    </li>
    <li class="mui-table-view-cell">
        大家好哦
    </li>
</ul>
```

## 图文列表

```html
<ul class="mui-table-view mui-grid-view">
    <li class="mui-table-view-cell mui-media mui-col-xs-6">
        <a href="#">
            <img class="mui-media-object" src="http://placehold.it/400x300">
            <div class="mui-media-body">文字说明1</div>
        </a>
    </li>
    <li class="mui-table-view-cell mui-media mui-col-xs-6">
        <a href="#">
            <img class="mui-media-object" src="http://placehold.it/400x300">
            <div class="mui-media-body">文字说明2</div>
        </a>
    </li>
</ul>
```

## 图文列表居左media

```html
<ul class="mui-table-view">
    <li class="mui-table-view-cell mui-media">
        <a href="javascript:;">
            <img class="mui-media-object mui-pull-left" src="">
            <div class="mui-media-body">
                幸福
                <p class="mui-ellipsis">能和心爱的人一起睡觉，是件幸福的事情；可是，打呼噜怎么办？</p>
            </div>
        </a>
    </li>
    <li class="mui-table-view-cell mui-media">
        <a href="javascript:;">
            <img class="mui-media-object mui-pull-left" src="">
            <div class="mui-media-body">
                木屋
                <p class="mui-ellipsis">想要这样一间小木屋，夏天挫冰吃瓜，冬天围炉取暖.</p>
            </div>
        </a>
    </li>
    <li class="mui-table-view-cell mui-media">
        <a href="javascript:;">
            <img class="mui-media-object mui-pull-left" src="">
            <div class="mui-media-body">
                CBD
                <p class="mui-ellipsis">烤炉模式的城，到黄昏，如同打翻的调色盘一般.</p>
            </div>
        </a>
    </li>
</ul>
```

## Progress

```html
<div class="mui-progressbar">
    <span></span>
</div>	
<script type="text/javascript">
    mui.init();
    //设置进度
    mui(".mui-progressbar").progressbar({progress:60}).show();
    //关闭进度条
    mui(".mui-progressbar").progressbar({progress:60}).hide();
</script>
```

## Range 滑块

```html
<div class="mui-input-row mui-input-range">
    <label>Range</label>
    <input type="range" min="0" max="100" value="50" id="range">
</div>
</div> 	
<script type="text/javascript">
    mui.init();
    //获取值
    mui.toast(mui("#range")[0].value);	 
</script>
```

## Switch 模块

```html
<div id="switch" class="mui-switch mui-switch-mini mui-active">
    <div class="mui-switch-handle"></div>
</div>
//判断是否拥有某一个类 来判断是否是开启的状态
var Switch = document.getElementById("switch").classList.contains('mui-active')
    if(Switch){ 
       mui.toast('开启')	
    }else{
       mui.toast("关闭");
}	
```

##cardView 卡片视图

```html
<div class="mui-card">
    <div class="mui-card-header">
        页头
    </div>
    <div class="mui-card-content">
        <img src="a.jpg" style="width:100%;">
    </div>
    <div class="mui-card-footer">
        <div class="mui-media-body">
            CBD
            <p class="mui-ellipsis">烤炉模式的城，到黄昏，如同打翻的调色盘一般.</p>
        </div>
    </div>
</div>
```

## mask 遮罩面板

```javascript
var m = mui.createMask(callback);
m.show();
m.close();
```

## TabBar 跳转方式  href不管用 以及页面传值

```html
获取到要点击的内容
通过querySelector获取监听tap事件 调用如下时间进行跳转
有动画
document.querySelector("#link").addEventListener("tap",function(){
    mui.openWindow({
        url:"a.html",
        id:"a"
    extras:{
        //自定义扩展参数
    },
    show:{
         autoShow:true,
        aniShow:"slider-in-right", pop-in  |   zoom-fade-out
        duration:1000
    }
    waiting:{
        autoShow:true //自动显示等待框 默认为true,
        title:'正在加载' //等待框上显示的提示内容,
    }
})
});
mui.openwindow({
   url:"地址",
   id:"和url写一样就好"
})
//目标页面取值
mui.plusReady(function(){
    //这就可以获取到传递的哪一个对象
    let data =  plus.webview.currentWebview();
    mui.toast(data.name);
})
```

+ 还有很多其他选项可以去百度

## 预加载

+ 加快响应速度 在用户没有点击页面的时候就直接加载好目标页面 在访问的时候会比较速度

+ ```javascript
  mui.init({
      preloadPages:[
          {
              url:"地址",
              id:"和地址一样",
              //参数
              extras:{name:"小明"}
          }
      ]
  })
  ```

## 事件绑定

+ 开启事件  有些时间默认是没有开启的
  + gestureConfig:{
    + tap:true, //默认为true
    + doubletap:true,  //默认为false
    + longtap:true , //默认为false
    + swipe : true, //默认是true,
    + drag:true //默认为true
  + }

+ addEventListener  监听

+ on 监听批量事件     mui(parentNode).on(eventName,childNode,callback)

+ **手势事件**

+ tap 单击事件

+ doubletap 双击

+ longtap 长按屏幕

+ hold 按住屏幕

+ swipeleft  左滑

+ swiperight 右滑

+ swipeup 上滑

+ swipedown  下滑

+ dragstart 开始拖动

+ darg 推动中

+ dragend 拖动结束

+ **事件触发**

+ mui.trigger(btn1,'tap')

+ **自定义事件**

+ 1. 预加载一个要跳转的页面     mui.preload({url:"",id:""});   在使用此事件的时候要包括在plusReady里面 必须等待此事件加载完毕得到webview对象才能够正常设置自定义事件 调哟个fire

  2. 调用 mui.fire(预加载对象,eventName,{name:"lee"}[参数]); 设置自定义事件

  3. 调用 mui.openWindow({url:"",id:""})  进行跳转

  4. 目标页面接受值  window.addEventListener(eventName,callback[event].detail 是参数对象)

     ```javascript
     mui.plusReady(function(){
         let prePage = mui.preload({url:"child.html",id:"child.html"});
         mui("#lists").on('tap','li',function(){
             mui.fire(prePage,'aaa',{title:this.innerHTML});
             mui.openWindow({url:"child.html",id:"child.html"});
         });
     })
     
     //child.html
     mui.plusReady(function(){
         window.addEventListener("aaa",function(event){
             alert(1232456);
             mui.toast(event.detail.title);
         });
     })
     ```

     

## Mui ajax请求

```javascript


mui.ajax({
    url:"",
    type:"",
    data:{},
    headers:"",
    dataType:"",
    success:function(){},
    error:function(){},
    timeout:1000,
    async:true,
    processData:false,
})

mui.get(url,callback,datatype);
mui.post(url,data,callback,datatype);
mui.getJSON(url,callback);

```

## 区域滚动

```html
<div class="mui-scroll-wrapper mui-slider-indicator mui-segmented-control mui-segmented-control-inverted">
    <div class="mui-scroll">
        <a class="mui-control-item mui-active">
            推荐
        </a>
        <a class="mui-control-item">
            热点
        </a>
        <a class="mui-control-item">
            北京
        </a>
        <a class="mui-control-item">
            社会
        </a>
        <a class="mui-control-item">
            娱乐
        </a>
        <a class="mui-control-item">
            科技
        </a>
    </div>
```

## 栅格布局

```html
<div class="mui-row">
    <div class="mui-col-sm-6 mui-col-xs-6">Item 1</div>
    <div class="mui-col-sm-6 mui-col-xs-6">Item 2</div>
</div>
<div class="mui-row">
    <div class="mui-col-sm-6 mui-col-xs-6">Item 1</div>
    <div class="mui-col-sm-6 mui-col-xs-6">Item 2</div>
</div>
  	   
```

## 创建子页面

+ 为防止App运行过程中出现卡顿现象 所以部分页面我们采用头部和内容分类的模式

+ ```javascript
  //  设置子页面
  mui.init({
      subpages:[
          {   
              url:"index2.html",
              id:"index2.html",
              styles:{
                  top:'40px',   默认44px
                  bottom:'50px',  默认50px
                  width:'100',     默认100%
                  hieght:'100'    默认100%
              },
              extras:{
  
              }
          }
      ]
  })
  ```

+ 一般用在有上拉加载 或者下拉刷新的页面中

## 关闭界面 三种方式

1. 加上 .mui-action.back 类  即可点击返回
2. mui.init({ swipeBack:true })  启动当前页面 向右滑动关闭页面功能
3. mui.init({ keyEventBind:{ backbutton:false } })   关闭Android 手机自带的back返回键返回

## 创建子页面之底部tab卡切换界面

```html
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
        <title></title>
        <script src="js/mui.min.js"></script>
        <link href="css/mui.min.css" rel="stylesheet"/>

    </head>
    <body>

        <nav class="mui-bar mui-bar-tab">
            <a id="home" class="mui-tab-item mui-active" href="home.html">
                <span class="mui-icon mui-icon-home"></span>
                <span class="mui-tab-label">首页</span>
            </a>
            <a id="phone" class="mui-tab-item" href="phone.html">
                <span class="mui-icon mui-icon-phone"></span>
                <span class="mui-tab-label">电话</span>
            </a>
            <a id="phone" class="mui-tab-item" href="c.html">
                <span class="mui-icon mui-icon-phone"></span>
                <span class="mui-tab-label">C</span>
            </a>
        </nav>  



        <script type="text/javascript" charset="utf-8">
            mui.init();

            mui.plusReady(function(){	
                //  设置加载的子页面数组  要注意顺序
                var subPages = ['home.html','phone.html','c.html'];
                //  设置加载的子页面的样式  妖姬底部50px 因为底部有一个tabbar
                var sub_style = { 
                    top:"0",
                    bottom:"50px"};
                //  获取到当前页面对象 对齐进行添加子页面
                var self = plus.webview.currentWebview();
                // 循环创建多个子页面 并且设置第一个默认显示  其他的默认隐藏
                for(var i = 0 ; i < subPages.length; i++){
                    var subPage = plus.webview.create(subPages[i],subPages[i],sub_style);
                    if(i > 0){ subPage.hide(); }
                    self.append(subPage);
                }
                // 设置点击切换 
                var subPageShow = subPages[0];  // 设置一个默认显示的页面
                mui(".mui-bar-tab").on("tap","a",function(){
                    var tempTarget = this.getAttribute("href");
                    if(subPageShow == tempTarget){return ; }
                    //显示目标选项卡
                    plus.webview.show(tempTarget);
                    //隐藏当前
                    plus.webview.hide(subPageShow);
                    subPageShow = tempTarget;
                });
            })

        </script>
    </body>
</html>
```

## 自己封装好的tabbar切换js

+ tarBar_toggle.js

```javascript
    //传入一个数组    DOM 结构要求a标签上需要有href 目标是需要跳转的页面路径
	function tabBar_toggle(sub_pages){
		   //  设置加载的子页面数组  要注意顺序
                var subPages = sub_pages;
                //  设置加载的子页面的样式  妖姬底部50px 因为底部有一个tabbar
                var sub_style = {
                    top:"0",
                    bottom:"50px"};
                //  获取到当前页面对象 对齐进行添加子页面
                var self = plus.webview.currentWebview();
                // 循环创建多个子页面 并且设置第一个默认显示  其他的默认隐藏
                for(var i = 0 ; i < subPages.length; i++){
                    var subPage = plus.webview.create(subPages[i],subPages[i],sub_style);
                    if(i > 0){ subPage.hide(); }
                    self.append(subPage);
                }
                // 设置点击切换 
                var subPageShow = subPages[0];  // 设置一个默认显示的页面
                mui(".mui-bar-tab").on("tap","a",function(){
                    var tempTarget = this.getAttribute("href");
                    if(subPageShow == tempTarget){return ; }
                    //显示目标选项卡
                    plus.webview.show(tempTarget);
                    //隐藏当前
                    plus.webview.hide(subPageShow);
                    subPageShow = tempTarget;
                });
	}

```

## 选择日期提示框

```javascript
mui.plusReady(function(){
    document.querySelector("#picker").onclick=function(){
        //设置时间    js的月是从0开始的  11算12月   0算1月
        var dDate = new Date();    //默认时间
        dDate.setFullYear(2018,0,17);
        var minDate = new Date();   // 最小时间
        minDate.setFullYear(2000,0,1);
        var maxDate = new Date();  // 最大时间
        maxDate.setFullYear(2020,11,31);

        plus.nativeUI.pickDate(function(e){
            var d = e.date;
            console.log(d);  // d.getFullYear   d.getHours  d.getDate
            alert("选择了时间");
        },function(){
            alert("没有选择时间");
        },
                               {title:"选择提醒是时间",date:dDate,minDate:minDate,maxDate:maxDate});  // 标题 默认时间  最小时间  最大时间

    }



});
```

## 下拉刷新  上拉加载

+ 都是在子页面完成的
+ 需要有一个容器进行包裹 否则在IOS端会出现BU

```javascript
//  下拉刷新  配置信息都是在mui.init() 内完成
// 1. 创建父页面  index.html   编写一个头部
// 2. 在父页面创建子页面 加载入需要下拉刷新的子页面
    subpages:[{url:"child.html",id:"child.html",styles:{top:"44px"}}]
// 3. 创建子页面  child.html   编写具体内容
    mui.init({
        pullRefresh:{
            container:"#pull",  //下拉容器标识
            down:{   // 下拉刷新
                contentdown:"下拉可以刷新",// 可选 在下拉刷新状态时
                contentover:"释放立即刷新", //可选  在释放可以刷新状态时
                contentrefresh:"正在刷新..." //必选,
                callback:fn //必选 刷新函数  根据业务来编写
            }，
            up:{//上拉加载
               contentrefresh:"正在加载...",
               contentnomore:"没有更多数据了",
               callback:upfn //处理函数
             }
        } 
})
// 4. 子页面操作
    function  fn(){
        alert("刷新啦!");
        setTimeout(function(){
             mui("#pull").pullRefresh().endPulldownToRefresh(); //关闭加载动画
        },2000)
    }
    function  upfn(){
        alert("下拉加载啦!");
        setTimeout(function(){
            this.endPullupToRefresh(true)  通知系统没有更多数据了 显示没有数据
             this.endPullupToRefresh(false)  通知系统没有还有数据了 继续加载数据
        },2000)
    }
  
```

+ z子页面  html 部分

+ ```html
  //最外层是容器 必须
  <div id="pull" class="mui-content mui-scroll-wrapper">
      <div class="mui-scroll">
          <ul class="mui-table-view">
              <li class="mui-table-view-cell">
                  Item 1	
              </li>
              <li class="mui-table-view-cell">
                  Item 2
              </li>
              <li class="mui-table-view-cell">
                  Item 3
              </li>
          </ul>
      </div>
  </div>
  ```

## 下拉菜单

```html
<a href="#popover" id="openPopover" class="mui-btn mui-btn-primary mui-btn-block">
    打开弹出菜单
</a>
<div id="popover" class="mui-popover">
    <ul class="mui-table-view">
        <li class="mui-table-view-cell"><a href="#">Item1</a></li>
        <li class="mui-table-view-cell"><a href="#">Item2</a></li>
        <li class="mui-table-view-cell"><a href="#">Item3</a></li>
        <li class="mui-table-view-cell"><a href="#">Item4</a></li>
        <li class="mui-table-view-cell"><a href="#">Item5</a></li>
    </ul>
</div>
```

# H5plus部分

## 照相机

```javascript
mui.plusReady(function(){
    document.querySelector("#crm").addEventListener("tap",function(){
        let cmr = plus.camera.getCamera();
        cmr.captureImage(function(p){
            //调用成功
            plus.io.resolveLocalFileSystemURL(p,function(entry){
                // 读取成功  
                let name = entry.name;
                let url = entry.toLocalURL();  //得到url
                alert(name)
                alert(url);
                document.querySelector("#image").src = url;
            },function(err){
                // 读取失败
                console.log(err.message);
            });
        },function(err){
            //调用失败
            console.log(err.message);
        },{filename:"_doc/camera",index:1})
    });
		  
```

## 相册

```javascript
plus.gallery.pick(function(path){
    img.src = path; //path就是路径
},function(){
    console.log("取消选择图片")
},{filter:"image"});
```

## 相机 照相机封装

```javascript
function openImageType(type,callback){
    if(type == 1){
        //相机
        let cmr = plus.camera.getCamera();
        cmr.captureImage(function(p){
            //调用成功
            plus.io.resolveLocalFileSystemURL(p,function(entry){
                // 读取成功  
                let name = entry.name;
                let url = entry.toLocalURL();  //得到url
                callback({name:name,url:url});
            },function(err){
                // 读取失败
                callback("error");
            });
        },function(err){
            //调用失败
            callback("error");
        },{filename:"_doc/camera",index:1})
    }else{
        plus.gallery.pick(function(path){
            callback({name:"未知",url:path});
        },function(){
            callback("error");
        },{filter:"image"});
    }
};
```



## 蜂鸣提示音 和 震动

```javascript
// 峰鸣
switch(plus.os.name){ //设备名称
    case 'iOS':
        //判断设备是否是iphone
        if(plus.device.model.indexOf("iPhone") >= 0){
            plus.device.beep();
        }else{
            console.log("此设备不支持峰鸣!")
        }
        break;
    default:
        plus.device.beep();
        break;
}
// 震动
switch(plus.os.name){ //设备名称
    case 'iOS':
        //判断设备是否是iphone
        if(plus.device.model.indexOf("iPhone") >= 0){
            plus.device.vibrate();
        }else{
            console.log("此设备不支持峰鸣!")
        }
        break;
    default:
        plus.device.vibrate();
        break;
}
```

## 设备信息

```javascript
var model = plus.device.model; //设备型号
var vendor = plus.device.vendor;//设备的生产厂商
var imei = plus.device.imei; //设备的国际移动身份证吗
var uuid = plus.device.uuid; // 设备的唯一标识
```

## 手机信息

```javascript
var name = plus.os.name;  //操作系统名称
var version = plus.os.version; //操作系统版本
var language = plus.os.language; //操作系统语言
var vendor = plus.os.vendor; //操作系统厂商
var types = {};
types[plus.networkinfo.CONNECTION_CELL2G] = "2G网络";
types[plus.networkinfo.CONNECTION_CELL3G] = "3G网络";
types[plus.networkinfo.CONNECTION_CELL4G] = "4G网络";
types[plus.networkinfo.CONNECTION_WIFI] = "WIFI网络";
types[plus.networkinfo.CONNECTION_UNKNOW] = "未知";
types[plus.networkinfo.CONNECTION_NONE] = "未连接网络";
types[plus.networkinfo.CONNECTION_ETHERNET] = "有线网络";
document.querySelector("#p").innerText = 
"设备型号："+model+",生产厂商:"+vendor+",国际移动身份证:"+imei+",唯一标识："+uuid
+ ",手机操作系统："+name+",版本："+version+",语言："+language+",厂商："+vendor+",网络："+types[plus.networkinfo.getCurrentType()];
```

##发送短信 发邮件 打电话  

```javascript
<a href="tel:15236148260"> 打电话 </a>
<a href="sms:15236148260"> 发短信 </a>
<a href="mailto:2857734156@qq.com"> 发邮件 </a>
//群发
btn[0].addEventListener("tap",function(){
    var msg = plus.messaging.createMessage(plus.messaging.TYPE_SMS);
    msg.to = ['15236148260','13213560663'];
    msg.body = "我是李文祥";
    plus.messaging.sendMessage(msg);
});
```

## 本地存储

```javascript
localStorage.setItem("name","lee");
localStorage.getItem("name");
localStorage.removeItem("name");
localStorage.clear();
```

## 上传图片

```javascript
<!doctype html>
    <html>

    <head>
    <meta charset="utf-8">
        <title></title>
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <link href="css/mui.css" rel="stylesheet" />
        </head>
<body>
        <a href="loading.html">加载</a>
<button type="button"> 选择图片 </button>
</body>
<script src="js/mui.js"></script>
<script type="text/javascript">     
    mui.init() ;
mui.plusReady(function(){
    var btnArray = [{title:"相机"},{title:"相册"}];
    document.getElementsByTagName("button")[0].addEventListener("tap",function(){
        plus.nativeUI.actionSheet({
            title:"选择图片",   
            cancel:"取消",
            buttons:btnArray
        },function(e){
            var index = e.index;
            switch(index){
                case 1:
                    openImageType(1,function(res){
                        //传递的参数是路径
                        start_upload(res)
                    })
                    break;
                case 2:
                    openImageType(2,function(res){
                        //传递的参数是路径
                        start_upload(res)
                    })
                    break;
            }
        });      
    });
});

function openImageType(type,callback){
    if(type == 1){
        //相机
        let cmr = plus.camera.getCamera();
        cmr.captureImage(function(p){
            //调用成功
            plus.io.resolveLocalFileSystemURL(p,function(entry){
                // 读取成功  
                let name = entry.name;
                let url = entry.toLocalURL();  //得到url
                callback({name:"uploadkey",path:url});
            },function(err){
                // 读取失败
                callback("error");
            });
        },function(err){
            //调用失败
            callback("error");	
        },{filename:"_doc/camera",index:1})
    }else{
        plus.gallery.pick(function(path){
            callback({name:"uploadkey",path:path});
        },function(){
            callback("error");
        },{filter:"image"});
    }
};


function start_upload(obj){
    if(obj != "error"){
        var w = plus.nativeUI.showWaiting("上传中...");
        var task = plus.uploader.createUpload("http://localhost:3000/upload",{
            method:"POST"
        },function(t,status){
            if(status == 200){
                //t.responseText 应该就是服务器端返回接结果
                var responseText = t.responseText;
                var json = eval("("+responseText+")");
                var files = json.files;
                //上传成功以后保存的路径
                var imgUrl = files.uploadkey.url;
                w.close();
            }else{
                alert("上传失败!");
                w.close();
            } 
        });
        //添加上传的文件 第一个参数是路径
        task.addFile( obj.path, {key:"testdoc"} );
        task.addData("name","lee");
        task.start(); //开始上传任务
    }else{
        alert("没有选择图片");
    }
};

</script>



</body>

</html>

```

## 通讯录

```javascript
plus.contacts.getAddressBook(  plus.contacts.ADDRESSBOOK_PHONE,function(addressbook){
    addressbook.find(null,function(contacts){
        var str = ""; 
        var i  = 0 ;
        for(var a in contacts){
            var user = contacts[a].displayName; //联系人
            var phone = contacts[a].phoneNumbers[0];
            str += user + contacts[a].phoneNumbers[0].value;
            i++;
        }
        document.querySelector("#p").innerText = str;
    })
})
```