# WEUI笔记

### BEM CSS 命名规范

- title-left  - 代表块
- title-left__content   __ __ 代表一个块内的元素
- -- 代表修饰符

### 官网

https://www.kancloud.cn/ywfwj2008/weui/274287    使用直接来着看

## ActionSheet

`ActionSheet`用于显示包含一系列可交互的动作集合，包括说明、跳转等。由底部弹出，一般用于响应用户对页面的点击

## Article

文字视图显示大段文字，这些文字通常是页面上的主体内容。`Article`支持分段、多层标题、引用、内嵌图片、有/无序列表等富文本样式，并可响应用户的选择操作。

##badge，徽章

带文字的badge

```
<view class="weui-badge">New</view>
```

小红点

```
<view class="weui-badge weui-badge_dot"></view>
```

## Button

按钮可以使用`a`或者`button`标签。wap上要触发按钮的active态，必须触发ontouchstart事件，可以在`body`上加上`ontouchstart=""`全局触发。

## Cell

`Cell`，列表视图，用于将信息以列表的结构显示在页面上，是wap上最常用的内容结构。`Cell`由多个section组成，每个section包括section header`weui-cells__title`以及cells`weui-cells`。

`cell`由thumbnail`weui-cell__hd`、body`weui-cell__bd`、accessory`weui-cell__ft`三部分组成，其中`weui-cell__bd`采用自适应布局.

**详见badge源码demo**

## Flex

`Flex`用于快速进行Flex布局

**核心类名**

+ weui-flex
  + weui-flex__item

## Footer

`Footer`用于实现页脚，Copyright

```
<div class="weui-footer">
    <p class="weui-footer__text">Copyright &copy; 2008-2016 weui.io</p>
</div>
<div class="weui-footer">
    <p class="weui-footer__links">
        <a href="javascript:void(0);" class="weui-footer__link">底部链接</a>
    </p>
    <p class="weui-footer__text">Copyright &copy; 2008-2016 weui.io</p>
</div>
```

# Grid

`grid` 九宫格，功能类似于微信钱包界面中的九宫格，用于展示有多个相同级别的入口。包含功能的图标和简洁的文字

## Loadmore

`Loadmore`用于实现加载更多的效果。

##Input

`Input`，用于表单，可以分成“输入型”和“选择型”两种。输入型包括单行文本（文本、数值、电话、密码等）、多行文本；选择型包括下拉选择、单选、多选、开关、日期时间等。在 WeUI 中，表单通常与 Cell 组件配合使用。

示例代码如下：

##Msg Page

结果页通常来说可以认为进行一系列操作步骤后，作为流程结束的总结性页面。结果页的作用主要是告知用户操作处理结果以及必要的相关细节（可用于确认之前的操作是否有误）等信息；若该流程用于开启或关闭某些重要功能，可在结果页增加与该功能相关的描述性内容；除此之外，结果页也可以承载一些附加价值操作，例如提供抽奖、关注公众号等功能入口。

##Navbar

Navbar，顶部 tab，当需要在页面顶部展示 tab 导航时使用，用法与 Tabbar 类似。

可以直接使用原生tabbar

##Panel

Panel`weui-panel`由head（可选）、body、foot（可选）三部分组成，主要承载了图文组合列表`weui-media-box_appmsg`、文字组合列表`weui-media-box_text`以及小图文组合列表`weui-media-box_small-appmsg`。

##Progress

Progress，进度条，用于上传、下载等耗时并且需要显示进度的场景，用户可以随时中断该操作

# SearchBar

`searchBar` 搜索栏，类似于微信原生的搜索栏，应用于常见的搜索场景