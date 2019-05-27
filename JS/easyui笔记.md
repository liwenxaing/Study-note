#EasyUi笔记

## dialog

```html
<div id="dialog" class="easyui-dialog" title="标题" style="width:200px;height:200px;">
    内容
</div>
```

```javascript
$("#dialog").dialog({
    width:100,
    height:100,
    title:"对话",
    modal:true,
    iconCls:"icon-login",
    closable:false,
    buttons:"#btn"  //按钮 底部
})
```



## draggable

```html
<div class="draggable easyui-draggable">
    可拖动的Div
</div>
```

```javascript
$("#draggable").draggable({
    proxy:"clone"
});
```

## Tooltip

```html
<a href="javascript:void(0)" class="easyui-tooltip" title="提示信息">
    Hover Messager
</a>
```

```javascript
$("#tooltip").tooltip({
    content:"内容提示",
    showEvent:"click"
})
```

##linkButton

```html
<a id="linkButton" href="javascript:void(0)"  class="easyui-linkbutton">
    查阅
</a>
```

```javascript
$("#linkButton").linkbutton({
    disabled:true,
    selected:true,
    plain:true,
    iconCls:"icon-add",
    iconAlign:"right"
})
```

## progressBar

```html
 <div class="easyui-progressbar" data-options="value:50"></div>
```

```javascript
$("#progress").progressbar({
    width:400,
    height:15,
    value:50
});
```

## Panel

```html
<div class="easyui-panel" title="面板" style="width:400px;height: 200px;" data-options="closable:true">
    内容
</div>
```

```javascript
$("#panel").panel({
    title:"查询面板",
    width:400,
    height:200,
    iconCls:"icon-search",
    href:"./api.php",
    bodyCls:"a",
    headerCls:"b",
    fit:false, //设置面板是否自适应,
    collapsible:true,
    closable:true,
    tools:[
        {iconCls:"icon-help",handler:e=>{alert("help")}}
    ]
});
```

## tabs

```html
<div class="easyui-tabs" style="width:400px;height:200px;">
    <div title="新闻" style="padding:5px;"> 新闻 </div>
    <div title="娱乐" style="padding:5px;"> 娱乐 </div>
    <div title="闲聊" style="padding:5px;"> 闲聊 </div>
</div>
```

```javascript
$("#tabs").tabs({
    width:600,
    height:200,
    tabPosition:"left",
    headerWidth:100,
    tools:[
        {
            iconCls:"icon-search",
            handler:e=>{
                alert("搜索")
            }
        }
    ]
});
```

## Accordion

```html
<div class="easyui-accordion" style="width:200px;height:200px;">
    <div title="标题1"> 标题1 </div>
    <div title="标题2"> 标题2 </div>
    <div title="标题3"> 标题3 </div>
</div>
```

```javascript
$("#accordion").accordion({
    width:200,
    height:200,
    multiple:true
})
```

## Layout

```html
// 可以将div换成body 实现全屏 的效果
<div class="easyui-layout" style="width:600px;height:400px;">
    <div data-options="region:'north',split:true,title:'头部'" style="height:100px;"></div>
    <div data-options="region:'south',title:'底部'" style="height:100px;"></div>
    <div data-options="region:'west',title:'左边'" style="width:100px;"></div>
    <div data-options="region:'east',title:'右边'" style="width:100px;"></div>
    <div data-options="region:'center',title:'中间'"></div>
</div>
```

## Window窗口

```html
<div title="ad" class="easyui-window" style="width:500px;height:300px;" data-options="modal:true">
   
</div>
```

```javascript
$("#box").window({
    width:300,
    height:300,
    title:"标题",
    collapsible:false,
    minimizable:false,
    maximizable:false,
    closable:false,
    shadow:true,
    inline:true,
    onClose:e=>{
        alert("关了");
    }
});
```

## Messager

+ 只有通过JS完成

```javascript
$.messager.alert("提示","您确定删除吗？",'info',function(){

});
$.messager.confirm("提示","你真的要删除吗？",function(flag){
    if(flag){
        $.messager.alert("提示","删除成功","info")
    }
});
$.messager.prompt("请输入","您的名称",function(con){
    console.log(con);
})
$.messager.progress({
    title:"执行中",
    msg:"努力上传中"
})
$.messager.show({
    title:"我的消息",
    timeout:3000,
    msg:"3秒后关闭"
})

```

## Menu

+ 右键菜单

  ```html
  <div id="box" class="easyui-menu">
      <div >开始</div>
      <div data-options="iconCls:'icon-save'">保存
          <div>
              <div> Excel </div>
              <div> Word </div>
              <div> ppt </div>
          </div>
      </div>
      <div data-options="iconCls:'icon-edit'">编辑</div>
      <div>退出</div>
  </div>
  ```

  ```javascript
  $(document).on("contextmenu",function(e){
      e.preventDefault();
      $("#box").menu("show",{
          left:e.pageX,
          top:e.pageY
      })
  });
  ```

## MenuButton

```html
<a href="javascript:;" data-options="iconCls:'icon-edit',menu:'#box'" class="easyui-menubutton">
    编辑
</a>

<div id="box">
    <div> 剪切 </div>
    <div> 复制 </div>
    <div> 删除 </div>
</div>
```

## pagination

```html
    <div id="content" class="easyui-panel" data-options="href:'page.php?page=1&pageSize=1'" title="用户列表" style="height:150px;">
               内容
         </div>

         <div id="box"></div>

         <script>
             $(function () {
                 $("#box").pagination({
                     total:5,
                     pageSize:1,
                     pageNumber:1,
                     pageList:[1,2,4,6,8,10],
                     onSelectPage:function(pageNumber,pageSize){
                         $("#content").panel("refresh",'page.php?page='+pageNumber+"&pageSize="+pageSize,)
                     }
                 });
             })
         </script>
```

## searchBox

```html
<div class="easyui-searchbox" data-options="menu:'#list',prompt:'请输入搜索的关键字',searcher:sendMsg" style="width:300px;"></div>

<div id="list">
    <div data-options="iconCls:'icon-ok'"> 所有频道 </div>
    <div data-options="iconCls:'icon-error'"> 体育频道 </div>
</div>

function sendMsg(name,value){
      $.messager.alert("提示",name+"-"+value);
}
```

## validateBox

```html
<input class="easyui-validatebox" data-options="required:true,validType:'email'"> // url length[2,10]

$("#input").validatebox({
  required:true,
  missingMessage:"请输入管理员账号",
  invalidMessage:"不得为空"
})

$("#pwd").validatebox({
    required:true,
    validType:"length[6,16]",
    missingMessage:"请输入管理员密码",
    invalidMessage:"必须为6-16位之间"
})

//判断是否通过验证
alert($("#user").validatebox("isValid"));
```

## numberbox

```html
  <input type="text" class="easyui-numberbox" data-options="min:1,max:10">
```

## calendar

```javascript
$("#can").calendar({
    width:300,
    height:300,
    onSelect:function (date) {
    alert(date.toLocaleString());
    }
});
```

## datetimebox

```javascript
 <input id="time">
$("#time").datetimebox({
    onChange:function (data) {
        console.log(data);
    }
});
```

## form

```html
<form id="form" action="123.html" class="easyui-form" method="post">
    <p>
        账号
        <input class="easyui-validatebox" data-options="required:true,validType:'length[1,8]'">
    </p>
    <p>
        邮箱
        <input class="easyui-validatebox" data-options="required:true,validType:'email'">
    </p>
    <input type="submit">
</form>
```

```javascript
$("#form").form({
    url:"content.php",
    onSubmit:function(params){
        //  提交之前 触发 可以携带一些额外的参数
        params.code = "12346798";
    },
    success:function(data){
        //data 是请求到的数据
        console.log(data)
    }
});
```

## table

###基本数据展示与分页

```javascript
// 返回的json格式一定按照这个返回
// 后台接收当前页和页大小的时候 监听 $_POST['page']  $_POST['rows'] 
{
    "total":3,
        "rows":[
            {
                "user":"李文祥",
                "email":"2857734156@qq.com",
                "date":"2018-8-9"
            },
            {
                "user":"李文祥",
                "email":"2857734156@qq.com",
                "date":"2018-8-9"
            },{
                "user":"李文祥",
                "email":"2857734156@qq.com",
                "date":"2018-8-9"
            }
        ]
}
//配置信息
$("#table").datagrid({
    width:400,
    title:"用户列表",
    columns:[[
        //field根据数据库字段名命名
        {title:"账号",field:"user",},
        {title:"邮箱",field:"email",},
        {title:"时间",field:"date",}
    ]],
    url:"data.json",
    pagination:true,
    pageSize:1,  // 和pageList 要一至
    pageNumber:1,
    pageList:[1,2,3],
    fit:true
});
// DOM 结构
<table id="table"></table>
```

###客户端排序

```javascript
$("#table").datagrid({
    width:800,
    title:"用户列表",
    columns:[[
        //field根据数据库字段名命名
        {title:"账号",field:"user",sortable:true},
        {title:"邮箱",field:"email",sortable:true},
        {title:"时间",field:"date",sortable:true},
        {title:"性别",field:"sex",sortable:true}
    ]],
    url:"data.json",
    pagination:true,
    pageSize:1,
    pageNumber:1,
    pageList:[1,2,3],
    remoteSort:false, //客户端排序  关闭服务端排序
});
```

### 样式设置

```javascript
$("#table").datagrid({
    width:800,
    title:"用户列表",
    columns:[[
        //field根据数据库字段名命名
        {title:"账号",field:"user",width:100,sortable:true,align:"center"},
        {title:"邮箱",field:"email",width:100,sortable:true,align:"center"},
        {title:"时间",field:"date",width:100,sortable:true,align:"center"},
        {title:"性别",field:"sex",width:100,sortable:true,align:"center"}
    ]],
    url:"data.json",
    pagination:true,
    pageSize:1,
    fitColumns:true, //自动填充列 平分宽度  给每个字段设置width 100
    pageNumber:1,
    pageList:[1,2,3],
    remoteSort:false, //客户端排序
    striped:true,
    nowarp:false,
    loadMsg:"加载中...",
    rownumbers:true
});
```

### 查询功能以及插入DOM结构 toolbar

```html
// id是标识
<div id="tb">
    <div style="padding:5px;">
        <a href="javascript:;" class="easyui-linkbutton" plain="true" iconCls="icon-edit"> 编辑 </a>
        <a href="javascript:;" class="easyui-linkbutton" plain="true" iconCls="icon-add"> 添加 </a>
        <a href="javascript:;" class="easyui-linkbutton" plain="true" iconCls="icon-remove"> 删除 </a>
    </div>
    <div style="padding:5px 5px 5px 9px;">
        账号：<input type="text" class="textinput" name="user">
        创建时间从：<input type="text" class="easyui-datebox" name="date_form">
        到：<input type="text" class="easyui-datebox" name="date_to">
        <!-- 调用查询的方法 -->
        <a href="javascript:;" class="easyui-linkbutton" onclick="obj.search()" iconCls="icon-search"> 查询 </a>
    </div>
</div>
```

```javascript
let obj = {
    search:function(){
        //发送请求  load方法  具体逻辑在后端处理  第二个对象是传递的参数
        $("#table").datagrid("load",{
            user:$("input[name=user]").val(),
            date_form:$("input[name=date_form]").val()
        })
    }
} 

$("#table").datagrid({
    width:800,
    title:"用户列表",
    fitColumns:true, //自动填充列 平分宽度  给每个字段设置width 100
    columns:[[
        //field根据数据库字段名命名
        {title:"账号",field:"user",width:100,sortable:true,align:"center"},
        {title:"邮箱",field:"email",width:100,sortable:true,align:"center"},
        {title:"时间",field:"date",width:100,sortable:true,align:"center"},
        {title:"性别",field:"sex",width:100,sortable:true,align:"center"}
    ]],
    toolbar:"#tb", // 插入进来的DOM 插在头上面
    url:"data.json",
    pagination:true,
    pageSize:1,
    pageNumber:1,
    pageList:[1,2,3],
    remoteSort:false, //客户端排序
    striped:true,
    nowarp:false,
    loadMsg:"加载中...",
    rownumbers:true
});
```

### 新增功能

+ 禁止输入

+ ```html
  <input type="text" class="easyui-datebox" editable="false" name="date_form">
  ```

+ 行尾添加一条记录  点击按钮时调用

+ ```javascript
  add:function(){
      //在行尾添加一条记录
      $("#table").datagrid("appendRow",{
          user:"lee",
          email:"123465@qq.com",
          date:"2000-2-5",
          sex:"女"
      })
  }
  ```

+ 行首添加

+ ```javascript
  $("#table").datagrid("insertRow",{
      index:0,
      row:{
          user:"lee",
          email:"123465@qq.com",
          date:"2000-2-5",
          sex:"女"
      }
  })
  ```

## 删除

```javascript
remove:function(){
    //先获取到所有选中的行
    var rows = $("#table").datagrid("getSelections");
    if(rows.length <= 0){
        $.messager.alert("提示","请选择要删除的记录!","info");
    }else{
        let flag = window.confirm("确定要删除吗?")
        if(flag){
            var ids = [];
            for(var i = 0 ; i < rows.length; i++){
                ids.push(rows[i].id);
            }
            $.messager.alert("提示",ids.join(","));
        }
    }
}
//添加一列   在数据库的时候一定要查出id
{title:"编号",field:"id",width:100,checkbox:true},
```

### 下拉列表框

```html
<select class="easyui-combobox" id="select">
    <option value="菜单一"> 菜单一 </option>
    <option value="菜单2"> 菜单2 </option>
    <option value="菜单3"> 菜单3 </option>
    <option value="菜单4"> 菜单4 </option>
</select>
```

```javascript
$("#select").combobox({
    onSelect:function(res){
        console.log(res);
    }
});
```

## Tree

### 静态导航

```html
<div class="easyui-panel" title="会员操作列表"  style="width:150px;height:200px;padding:5px;">
    <ul class="easyui-tree">
        <li> 
            <span> 系统信息 </span>
            <ul>
                <li> 
                    <span><a href="?" target="con"> 主机信息</a> </span>
                    <ul>
                        <li> 版本信息 </li>
                        <li>数据库信息  </li>
                    </ul>
                </li>
            </ul>
        </li>
        <li>会员信息</li>
    </ul>
</div>
```

### 动态导航

```javascript
//json文件格式
[
    {
        "id":1,
        "text":"系统管理",
        "iconCls":"icon-edit",
        "children":[
            {
                "text":"更新信息",
                "children":[
                    {
                        "text":"更新信息",
                        "checked":true
                    },
                    {
                        "text":"添加信息"
                    }
                ]
            },
            {
                "text":"添加信息"
            }
        ]
    },
    {
        "id":2,
        "text":"会员管理",
        "children":[
            {
                "text":"更新信息",
                "text":"添加信息"
            }
        ]
    }
]

// js
$("#tree").tree({
    url:"tree.json",
    animate:true,  //动画
    checkbox:true, //显示复选框
    lines:true, //显示线
    dnd:true //可拖拽
})
```



## 禁止右键菜单显示

```
$(document).on("contextmenu",function(e){
    e.preventDefault();
});
```