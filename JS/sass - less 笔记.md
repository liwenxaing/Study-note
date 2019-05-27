---

---

# SASS AND LESS 学习笔记

## 1. less and sass 基本认知

#### 1.1 less / sass

​      Css 预处理器   换个方式写css而已

​       less 视频
       http://www.imooc.com/learn/102
       http://www.imooc.com/learn/6

####1.2 Sass 需要编译环境

安装sass

gem  install sass

安装的时候注意添加环境变量

koala (停止更新了)    http://koala-app.com/index-zh.html

 **注意 ：使用koala编译sass出错时 进入设置 > sass > 将使用系统的sass编译器打上对勾 点击确定 **

命令的方式

依赖 ruby

编译的过程中不能有中文 不能有特殊符号 不能有空格 

##### 1.2.1编译的方式

```
单文件实时监听的命令 并压缩
     sass --watch common.scss:common.css compressed
手动编译文件
     sass common.scss common.css
监听整个文件夹  并压缩
    
编译压缩css文件
     sass --style compressed common.scss common.css
```
## 2. ruby官网

####2.1 下载ruby

+  http://rubyinstaller.org/downloads

## 3 sass 语法特性
#####3.1 变量

+ 使用 $width:red; 进行声明

+ 1.2 变量可以存储多个值 例如 $width:200px 300px 500px 但是这样直接获取不到

+ 1.3 要获取某一个值的话需要通过nth(变量名,哪一个值) 就可以用了  

+ 1.4 作用范围局部变量 全局变量 就近原则 变量必须声明才能使用

+ 1.5 局部变量

  ```
  .box{
      $width:200px;
      .child{
          width:$width;
      }
      height:100px;
  }
  ```

  

##### 3.2 嵌套

+ 以前我们使用css写的时候一个标签内部有许多子标签 我们都是使用后代选择器
+ 要写很多个代码块 这里我们可以使用scss的嵌套规则 可以直接在某一个类里面
+ 直接写他的子标签 方便
+ 嵌套层级越多匹配次数越多速度就会降低

##### 3.3 表达式

+ 在 sass 中我们可以使用任意的算数表达式

+ 进行加法运算

+ 进行减法运算 如果数值后加油单位需要加空格

+ 进行乘法运算 只能运算数值的相乘 不能加单位

+ 进行除法运算 只能运算数值的相除 不能加单位

  **注意：在进行运算的时候一定要加上小括号 要不然会被当作值直接编译**     

##### 3.4 属性嵌套

+ 是复合属性才能

+ 需要使用:号隔开

  ```
  .box{
       font:{
           size:14px;
           weight:100;
           family:宋体
       }
  }
  ```

  

##### 3.5 跳出嵌套

+ @at-root  `.title{ color:red; }` 跳出单个 生成编译后的代码不会加上父级

+ @at-root 跳出多个

  ```
  .parent {
       @at-root {
           .title{
               
           }
           .box{
               
           }
       }
  }
  ```

  

##### 3.6 上层选择器

+ & 可以为上层与当前层的类名进行拼接

+ ```
  .box{
      // .box_one{}
      &_one{
          代表的意思就是上一层的名字加上当前的名字
          常用语层级分明的类名
      }
  }
  ```

  

##### 3.7 混合(mixin)

+ 使用@mixin声明

+ 类似js里的函数
+ 使用@include调用

+ 基本语法

```
@mixin opa(){
    opacity:0.5;
    filter:alpha(opacity=50);
}

.demo{
    @include opa();
}
//传参数  不穿参数的话会报错
@mixin opa($opa){
    opacity:$opa / 100;
    filter:alpha(opacity=$opa);
}

.demo{
    @include opa(50);
}
//传参数 默认参数值 
@mixin opa($opa:50){
    opacity:$opa / 100;
    filter:alpha(opacity=$opa);
}

.demo{
    @include opa(50);
}
//传参数 不确定参数  ... 可以传递任意参数
@mixin shaodw($shadow...){
    box-shadow:$shadow
}
.demo{
    @include opa(0 0 2px block);
}

```



##### 3.8 混合与if(mixin and if) 

+ sass提供了@if(){}
+ not  and or
+ sass提供了@else if(){}
+ 一般配合@mixin使用
+ 基本语法

```
@mixin Perosn($fixed,$px){
    @if ($fixed == top){
        margin-top:$px
    }
    @else if($fixed == left){
         margin-left:$px
    }
}

.demo{
   @include Person(top,50px);
   //在sass中允许制定参数传参数 不是传的第一个这样也可以
   @include Person($px:50px);
}
```

##### 3.9 继承

+ 使用@extend 类名 进行继承另一个类的样式

+ 继承之后就可以的到另一个类的所有样式

+ sass会自动处理代码的优化问题

+ 简单语法

  ```
  .fl{
      clear:both;
  }
  .demo{
      @extend .fl;
  }
  ```

  

##### 4.0 占位选择器

+ %名字{} 这样写的样式可以被继承但是不会被当作一个类 就是一个公共的样式块
+ 可以说是专门被用来继承
+ 不会被当成类便宜到css文件中
+ 简单语法

```
%clear{
    //公共代码块
    clear:both;
}
.fl{
    @extend %clear;
}
```

#####4.1 字符串插槽 

+ \#{变量|String}字符串插槽 可以用作字符串拼接输出

  ```
  .a{
      color:#{re}d;
  }
  ```

  

##### 4.2 for循环

+ 有两种形式 to < | through <=

  基本语法

  ```
  /* 小于等于10次 */
  @for $i from 1 through 10{
      .box_#{$i}{
          width:$i * 10px;
      }
  }
  /* 小于10次 */
  @for $i from 1 through 10{
      .box_#{$i}{
          width:$i * 10px;
      }
  }
  
  ```

  

  

##### 4.3 @import

+ 使用@import可以互相引入文件
+ 引入scss @import "a" 后缀名可以省略 也可以 @import "a.scss"
+ 引入css @import "a.css" 后缀名不可省略

## 4. Less Sublime Text 3 插件

### 4.1 sublime Text 3 安装 less代码高亮插件

+ ctrl + shift + p > install package > less > enter

###4.2 Less 基础语法

##### 安装 依赖Node

npm install -g less

lessc -v  查看版本

lessc a.less a.css  编译

npm位置  c盘/用户/appdata/npm/lessc.cmd

##### 4.2.1  注释 

+ 与sass一样 /**/ 会被编译  //不会被编译

##### 4.2.2 变量

+ 在less中使用@aaa:red; 定义变量

```
//语法演示
//设置文件编码
@charset "utf-8";
//声明变量
@table_width:200px;
//选择器
table{
    width:@table_width;
}

```

##### 4.2.3 混合

+ 基本语法不带参数的时候有点类似sass里面的继承
+ 就是可以重用相同的代码

```
/* 基本混合 */
.border{
    border:1px solid red;
}

.box{
    /* 使用混合 */
    .border;
    margin-left:15px;
}
/* 带参数的混合 */
.border_radius(@border_radius){
    -webkit-border-radius:@border_radius
    -moz-border-radius:@border_radius
     border-radius:@border_radius
}

.box{
    /* 使用混合 */
    .border(5px);
    margin-left:15px;
}
/* 带默认参数的混合 */
.border_radius(@border_radius:5px){
    -webkit-border-radius:@border_radius
    -moz-border-radius:@border_radius
     border-radius:@border_radius
}

.box{
    /* 使用混合 */
    .border();
    margin-left:15px;
}
```

##### 4.2.4 匹配模式

+ 类似if

+ 在一个混合里面传递参数是不需要加上@变量可以直接写值

+ 调用的时候写上此值便可

+ 可以多写几份根据传入参数的不同调用不同的混合块

+ 三角形例子

+ ```
  /* 匹配模式 */
  
  // 抽离公共代码
  .creatd_modul(@size){
  	  width:0;
  	  height:0
  	  overflow:hidden;
  	  border-width:@size;
  	  border-style:solid;
  }
  
  .creatd(top,@size:5px,@color:#999){
  	  .creatd_modul(@size);
  	  border-color:transparent transparent @color transparent;
  }
  .creatd(bottom,@size:5px,@color:#999){
       .creatd_modul(@size);
  	  border-color:@color  transparent   transparent transparent;
  }
  .creatd(left,@size:5px,@color:#999){
        .creatd_modul(@size);
  	  border-color:transparent  @color transparent  transparent;
  }
  .creatd(right,@size:5px,@color:#999){
        .creatd_modul(@size);
  	  border-color:transparent transparent  transparent @color;
  }
  
  
  .creat{
  	.creatd(top);
  }
  ```

  

##### 4.2.5 运算

+ \+ \- \* / 与sass一样 

##### 4.2.6 嵌套规则

+ 与sass一致

##### 4.2.7 上级选择器

+ & 可以获取到上一层的选择器

+ 小例子 a:hover改变颜色

+ ```
  /* 以前的写法 */
  a{
      text-deracation:none;
      color:#999;
  }
  a:hover{
      color:#eee;
  }
  /* less写法 */
  a{
      text-deracation:none;
      color:#999;
      &:hover{
          color:#eee;
      }
  }
  ```

  

##### 4.2.8 arguments 变量

+ 参数数组变量 可以替代传递的参数 只需用写一个@argument即可

```
.border(@size:5px,@color:#eee,@style:solid){
    border:@argument; //就类似  border :  5px #eee solid;
}
.aaa{
    .border();
}
```

##### 4.2.9 常用函数与循环

+ @arr:1,5,6,8

+ length(@arr)  提取到长度

+ extract(@arr,1)  提取数组中的某一个位置的内容

+ 模拟循环 在less中默认没有提供循环语句

  + ```less
    @arr:1px,2px,3px,9px,200px,900px,20px,30px,25px,30px;
    .add(@index) when (@index > 0){
         @media(min-width:extract(@arr,@index)){
                html{
                    //rem 适配换算公式  预设基准值 / 设计稿宽度 * 屏幕宽度
                    font-size:extract(@arr,@index);
                }
         }
         .add(@index - 1);
    }
    .add(length(@arr));
    ```