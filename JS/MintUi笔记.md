# MintUi 笔记

在使用每一个JS组件的时候都需要进行引入

## 安装Mint UI

```
npm install --save mint-ui
```

您可以完全导入Mint UI，或者只导入您需要的内容。我们先来看看完全导入。 

在main.js中 

```
import Vue from 'vue'
import MintUI from 'mint-ui'
import 'mint-ui/lib/style.css'
import App from './App.vue'

Vue.use(MintUI)

new Vue({
  el: '#app',
  components: { App }
})
```

在[babel-plugin-component](https://github.com/QingWei-Li/babel-plugin-component)的帮助下，我们可以导入我们实际需要的组件，使项目比其他方式更小。

首先安装babel-plugin-component：

```
npm install babel-plugin-component -D
```

然后编辑.babelrc：

```
{
  "presets": [
    ["es2015", { "modules": false }]
  ],
  "plugins": [["component", [
    {
      "libraryName": "mint-ui",
      "style": true
    }
  ]]]
}
```

如果需要Button和Cell，请编辑main.js 

```
import Vue from 'vue'
import { Button, Cell } from 'mint-ui'
import App from './App.vue'

Vue.component(Button.name, Button)
Vue.component(Cell.name, Cell)
/* or
 * Vue.use(Button)
 * Vue.use(Cell)
 */

new Vue({
  el: '#app',
  components: { App }
})
```

# Toast

## 引入

```javascript
import { Toast } from 'mint-ui';
```

基本用法 

```javascript
Toast('提示信息');
```

在调用 `Toast` 时传入一个对象即可配置更多选项 

```javascript
Toast({
  message: '提示',
  position: 'bottom',
  duration: 5000
});
```

若需在文字上方显示一个 icon 图标，可以将图标的类名作为 `iconClass` 的值传给 `Toast`（图标需自行准备） 

```javascript
Toast({
  message: '操作成功',
  iconClass: 'icon icon-success'
});
```

执行 `Toast` 方法会返回一个 `Toast` 实例，每个实例都有 `close` 方法，用于手动关闭 `Toast` 

```javascript
let instance = Toast('提示信息');
setTimeout(() => {
  instance.close();
}, 2000);
```

## API

| 参数      | 说明                                     | 类型   | 可选值                  | 默认值   |
| --------- | ---------------------------------------- | ------ | ----------------------- | -------- |
| message   | 文本内容                                 | String |                         |          |
| position  | Toast 的位置                             | String | 'top' 'bottom' 'middle' | 'middle' |
| duration  | 持续时间（毫秒），若为 -1 则不会自动关闭 | Number |                         | 3000     |
| className | Toast 的类名。可以为其添加样式           | String |                         |          |
| iconClass | icon 图标的类名                          | String |                         |          |

# Indicator

## 引入

```javascript
import { Indicator } from 'mint-ui';
```

当需要显示加载提示框时，调用 `open` 方法 

```
Indicator.open();
```

在加载图标下方显示文本

```
Indicator.open('加载中...');
```

也可以在调用时传入一个对象

```
Indicator.open({
  text: '加载中...',
  spinnerType: 'fading-circle'
})
```

调用 `close` 方法将其关闭

```
Indicator.close()
```

## API

| 参数        | 说明           | 类型   | 可选值                                                  | 默认值  |
| ----------- | -------------- | ------ | ------------------------------------------------------- | ------- |
| text        | 文本内容       | String |                                                         |         |
| spinnerType | 加载图标的类型 | String | 'snake' 'fading-circle' 'double-bounce' 'triple-bounce' | 'snake' |

# Infinite scroll

无限滚动指令 

## 引入

全局引入过 无需在引

```
import { InfiniteScroll } from 'mint-ui';

Vue.use(InfiniteScroll);
```

## 例子

为 HTML 元素添加 `v-infinite-scroll` 指令即可使用无限滚动。滚动该元素，当其底部与被滚动元素底部的距离小于给定的阈值（通过 `infinite-scroll-distance` 设置）时，绑定到 `v-infinite-scroll` 指令的方法就会被触发。

```html
<ul
  v-infinite-scroll="loadMore"   滚动到底部调用的事件
  infinite-scroll-disabled="loading"   loadming 为true则禁用加载方法 为true则调用加载方法
  infinite-scroll-distance="10">      距离底部的距离为多少的时候在加载
  <li v-for="item in list">{{ item }}</li>  便利的数据集合	
</ul>
```

```javascript
loadMore() {
  this.loading = true;
  setTimeout(() => {
    let last = this.list[this.list.length - 1];
    for (let i = 1; i <= 10; i++) {
      this.list.push(last + i);
    }
    this.loading = false;
  }, 2500);
}
```

## API

 

| 参数                             | 说明                                                         | 类型     | 可选值 | 默认值 |
| -------------------------------- | ------------------------------------------------------------ | -------- | ------ | ------ |
| infinite-scroll-disabled         | 若为真，则无限滚动不会被触发                                 | Boolean  |        | false  |
| infinite-scroll-distance         | 触发加载方法的滚动距离阈值（像素）                           | Number   |        | 0      |
| infinite-scroll-immediate-check  | 若为真，则指令被绑定到元素上后会立即检查是否需要执行加载方法。在初始状态下内容有可能撑不满容器时十分有用。 | Boolean  |        | true   |
| infinite-scroll-listen-for-event | 一个 event，被执行时会立即检查是否需要执行加载方法。         | Function |        |        |

# Message box

弹出式提示框，有多种交互形式。 

## 引入

```
import { MessageBox } from 'mint-ui'
```

## 例子

以标题与内容字符串为参数进行调用

```
MessageBox('提示', '操作成功');
```

或者传入一个对象

```
MessageBox({
  title: '提示',
  message: '确定执行此操作?',
  showCancelButton: true
});
```

此外，`MessageBox` 还提供了 `alert`、`confirm` 和 `prompt` 三个方法，它们都返回一个 Promise

```
MessageBox.alert(message, title);
```

```
MessageBox.alert('操作成功').then(action => {
  ...
});
```

```
MessageBox.confirm(message, title);
```

```
MessageBox.confirm('确定执行此操作?').then(action => {
  ...
});
```

```
MessageBox.prompt(message, title);
```

```
MessageBox.prompt('请输入姓名').then(({ value, action }) => {
  ...
});
```

在 prompt 中，若用户点击了取消按钮，则 Promise 的状态会变为 rejected

## API

| 参数                   | 说明                         | 类型    | 可选值                | 默认值 |
| ---------------------- | ---------------------------- | ------- | --------------------- | ------ |
| title                  | 提示框的标题                 | String  |                       |        |
| message                | 提示框的内容                 | String  |                       |        |
| showConfirmButton      | 是否显示确认按钮             | Boolean |                       | true   |
| showCancelButton       | 是否显示取消按钮             | Boolean |                       | false  |
| confirmButtonText      | 确认按钮的文本               | String  |                       |        |
| confirmButtonHighlight | 是否将确认按钮的文本加粗显示 | Boolean |                       | false  |
| confirmButtonClass     | 确认按钮的类名               | String  |                       |        |
| cancelButtonText       | 取消按钮的文本               | String  |                       |        |
| cancelButtonHighlight  | 是否将取消按钮的文本加粗显示 | Boolean |                       | false  |
| cancelButtonClass      | 取消按钮的类名               | String  |                       |        |
| closeOnClickModal      | 是否在点击遮罩时关闭提示光   | Boolean | true (alert 为 false) |        |
| showInput              | 是否显示一个输入框           | Boolean |                       | false  |
| inputType              | 输入框的类型                 | String  |                       | 'text' |
| inputValue             | 输入框的值                   | String  |                       |        |
| inputPlaceholder       | 输入框的占位符               | String  |                       |        |

# Action sheet

操作表，从屏幕下方移入 

## 引入

```
import { Actionsheet } from 'mint-ui';

Vue.component(Actionsheet.name, Actionsheet);
```

## 例子

`actions` 属性绑定一个由对象组成的数组，每个对象有 `name` 和 `method` 两个键，`name` 为菜单项的文本，`method` 为点击该菜单项的回调函数。

将 `v-model` 绑定到一个本地变量，通过操作这个变量即可控制 `actionsheet` 的显示与隐藏。

```
<mt-actionsheet
  :actions="actions"
  v-model="sheetVisible">
</mt-actionsheet>
```

##使用案例

```javascript
<template>
  <div class="page-actionsheet">
    <h1 class="page-title">Action Sheet</h1>
    <div class="page-actionsheet-wrapper">
      <mt-button @click.native="sheetVisible = true" size="large">点击上拉 action sheet</mt-button>
      <mt-button @click.native="sheetVisible2 = true" size="large">不带取消按钮的 action sheet</mt-button>
    </div>
    <mt-actionsheet :actions="actions" v-model="sheetVisible"></mt-actionsheet>
    <mt-actionsheet :actions="actions2" v-model="sheetVisible2" cancel-text=""></mt-actionsheet>
  </div>
</template>

<style>
  @component-namespace page {
    @component actionsheet {
      @descendent wrapper {
        padding: 0 20px;
        position: absolute 50% * * *;
        width: 100%;
        transform: translateY(-50%);

        button:first-child {
          margin-bottom: 20px;
        }
      }
    }
  }
</style>

<script type="text/babel">
  export default {
    data() {
      return {
        sheetVisible: false,
        sheetVisible2: false,
        actions: [],  //里面包含着一个个对象
        actions2: []
      };
    },

    methods: {
      takePhoto() {   //点击选项后的回调函数
        console.log('taking photo');
      },

      openAlbum() {//点击选项后的回调函数
        console.log('opening album');
      },

      goBack() {//点击选项后的回调函数
        history.go(-1);
      }
    },

    mounted() {
      this.actions = [{  //展示的数据   在渲染完毕DOM组件后设置数据
        name: '拍照',
        method: this.takePhoto
      }, {
        name: '从相册中选择',
        method: this.openAlbum
      }];
      this.actions2 = [{
        name: '确定'
      }, {
        name: '返回上一步',
        method: this.goBack
      }];
    }
  };
</script>

```



## API

| 参数              | 说明                                             | 类型    | 可选值 | 默认值 |
| ----------------- | ------------------------------------------------ | ------- | ------ | ------ |
| actions           | 菜单项数组                                       | Array   |        |        |
| cancelText        | 取消按钮的文本。若设为空字符串，则不显示取消按钮 | String  |        | '取消' |
| closeOnClickModal | 是否可以通过点击 modal 层来关闭 `actionsheet`    | Boolean |        | true   |