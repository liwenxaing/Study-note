# ThinkPHP 3 介绍及安装

## WillLi 威尔 - 李

## ThinkPHP的介绍            //了解

	MVC
		M - Model 模型                工作：负责数据的操作
		V - View  视图（模板）        工作：负责前台页面显示
		C - Controller 控制器（模块） 工作：描述功能
	框架

2. ThinkPHP的获取            //了解
	http://www.thinkphp.cn
3. ThinkPHP核心文件介绍      //了解

	+ ├─ThinkPHP.php     框架入口文件
	+ ├─Common 框架公共文件
	+ ├─Conf 框架配置文件
	+ ├─Extend 框架扩展目录
	+ ├─Lang 核心语言包目录
	+ ├─Lib 核心类库目录
	+ │  ├─Behavior 核心行为类库
	+ │  ├─Core 核心基类库
	+ │  ├─Driver 内置驱动
	+ │  │  ├─Cache 内置缓存驱动
	+ │  │  ├─Db 内置数据库驱动
	+ │  │  ├─TagLib 内置标签驱动
	+ │  │  └─Template 内置模板引擎驱动
	+ │  └─Template 内置模板引擎
	+ └─Tpl 系统模板目录
	
4. 实验环境搭建              //了解

5. 项目搭建                  //重点
        1. 搭建一个项目前后台总共需要三个步骤
        2. 确定应用名称  前台 | 后台
        3. 确定应用路径  前台 | 后台
        4. 引入核心文件ThinkPHP.php
        5. 例子
           1. 先定义一个常量作为应用名称 名字是固定的
              define("APP_NAME",'Home'); //注意开头大写
              define("APP_PATH","./Home/"); //注意最后加上/ 在访问index.php的时候就会自动生成
              define("APP_DEBUG",true);   开启调试模式
              require './ThinkPHP/ThinkPHP.php'; // 引入核心入口文件 
              创建一个后台应用步骤是一眼给只需要换一个名称即可
                    
			Home 前台应用文件夹
		├─Common 项目公共文件目录
		├─Conf 项目配置目录
		├─Lang 项目语言目录
		├─Lib 项目类库目录
		│  ├─Action Action类库目录
		│  ├─Behavior 行为类库目录
		│  ├─Model 模型类库目录
		│  └─Widget Widget类库目录
		├─Runtime 项目运行时目录
		│  ├─Cache 模板缓存目录
		│  ├─Data 数据缓存目录
		│  ├─Logs 日志文件目录
		│  └─Temp 临时缓存目录
		└─Tpl 项目模板目录
	
## MVC 模式 和 URL 访问
  + M - Model 模型                工作：负责数据的操作
  + V - View  视图（模板）        工作：负责前台页面显示
  + C - Controller 控制器（模块） 工作：描述功能		
    **特点** 
  + 各层之间不相互依赖  更加的灵活 
    **MVC各层对应的目录**
  + V 对应的是在项目目录下的应用目录下的 Tpl 目录
  + M 对应的是应用目录下的 lib 文件夹下的 Model 文件夹
  + C 对应的是应用目录下的 lib 文件夹下的 Action 文件夹
    **url访问控制器**
  + URL 访问 C 
  + 一共有四种访问方式
    1. PATHINFO 方式  也是使用最多的一种模式
        1. ThinkPHP3.x 的话 PHP 版本高于等于7.x的话 会没有效果
        2. 传递参数的话 可以通过 /键1/值1/键2/值2
        3. 例如   http://localhost:8080/project/index.php/Index/api/name/lee/age/18
        4. 可以修改默认的分隔符
        5. 在Conf文件夹有config.php 文件 里面存放的是配置文件 
            1. 通过 配置 APP_PATHINFO_DEPR => '-' 就可以配置了 
            2. 配置完毕之后再访问就是这样访问
            http://localhost:8080/project/index.php/Index-show-name-lee-age-18
    2. REWRITE 模式
        可以省去index.php这样的文件名称  更加的安全一点
        但是需要去Apache配置文件开启 rewrite_module 模块
        然后创建.htaccess 文件 添加配置项 放置在项目根目录下
        <IfModule mod_rewrite.c>
        	RewriteEngine on
        	RewriteCond %{REQUEST_FILENAME} !-d
        	RewriteCond %{REQUEST_FILENAME} !-f
        	RewriteRule ^(.*)$ index.php/$1 [QSA,PT,L]
        </IfModule>  
    3. 普通模式
        1. http://localhost:8080/THINKPHP/day1/index.php?m=Index&a=index&name=will&age=18   
        2. m 代表 这个模块名称  a 代表 这个模块里面的哪一个方法
    4. 兼容模式
        1. http://localhost:8080/THINKPHP/day1/index.php?s=Index/api&name=lee&age=123    
        2. s = 模块名/方法名
        3. 后面可以紧跟参数
## 输出和模型使用
  1. 使用内置的 echo 形式输出
  2. 再有的时候要输出一些html标签 在使用echo就不太合适了
     1. 这个时候就可以使用 V 层来完成输出的工作 
     2. 在C层中的模块方法内调用 **$this->display()** 方法 就可以调用Tpl下和次模块名称对应的html模板文件
     3. 例如你是 Index模块下的index方法 那么 Tpl下面就必须要有个Index文件夹下面有一个index.html 
     4. 名称要保持一致
     5. 这就实现了 C 层 访问 V 层的简单使用
     6. 但是V层呢还是需要花很大时间巩固的
  3. 动态的传递参数给模板
     1. 通过调用  **$this.assign('标识名称',值)**
     2. 在html模板中通过 {$标识名称} 进行调用  多加了一个 $ 名称   
     3. {} 是定界符
     4. 修改左右定界符
        1. 修改配置文件
            1. TMPL_L_DELIM=>"<{", //左定界符
            2. TMPL_R_DELIM=>">}"  //右定界符
  4. 模型的使用
     1. 主要作用是在数据库中取数据   
     2. 通过在C层的方法中实例化一个 Model('你的表名称') 首字母大写更好点  去掉前缀
     3. 返回一个 Model 对象 里面有各种各样的数据库操作方法
     4. 但是要使用Model类的话需要对config.php进行配置
        1. DB_TYPE=>"mysql",     数据库类型
        2. DB_NAME=>"test",      数据库名称
        3. DB_HOST=>"localhost", 数据库主机名
        4. DB_PORT=>"3306",      数据库端口
        5. DB_USER=>"root",      数据库用户名
        6. DB_PWD="root",        数据库密码
        7. DB_PREFIX=>"tp_"      数据库表前缀
        8. "DB_DSN"=>"mysql://root:root@localhost:3306/test" 这样配置更简单 简洁  可以去掉上面的了 除了 1前缀
        9. 如果 DSN 和 上面的传统配置都存在的话 会优先谁用 DSN
     5. 例子 
        $model = new Model('Users');
        $users = $model-select();  // 查询到这个表里的所有数据
        $this->assign('users',$users);
        $this->display();  在display方法里面传入具体的方法名称 可以跳转到具体的模板中
     6. 还有一种简单的方式 获取Model
        $m = M('Users'); 等效于  new Model('Uses');
     7. 开启页面调试模式  page_trace
        1. 需要首先开启 DEBUG 模式 
        2. 在 config.php 文件中 添加 SHOW_PAGE_TRACE=>true 即可
        3. 会在右下角 出现一个 小调试框      
## CURD  操作
  1. 查询
     1. $m->select()  查找所有
     2. $m->Find()    查找单个 默认是id为1的就是第一条数据
     3. $m->Find(id)  查找指定id的数据 返回一条
     4. $m->getFiled('name')   查找一个指定字段的数据  查一条  默认第一条
     5. $m->where('id = 2')->getField('name')  查找id为2的那个记录的name字段值 也叫连贯操作 中间加了个where相当于给数据库豫剧加条件   
     6. $m->add()     添加一条数据 注意的使需要在调用该方法前使调用 $m->字段名称进行设置值 在调用add方法 返回插入的id
     7. $m-delete(id) 删除一条数据根据id 也可以使用连贯操作 返回受影响的行数
        $data['id']=1;
        $data['name'] = "will";
     8. $m->save(data); 修改数据 传入一个数组 数组里要包含id为条件 返回一个受影响的行数
        $data['name'] = "wills";
     9. $m->where('id = 10')->save($data); 使用连贯操作 修改数据  返回受影响的行数 
     10. $this->success('数据删除成功!')  这个方法用来提示操作成功结果 并返回到上一级页面
     11. $this->error('数据删除失败!')  这个方法用来提示操作失败结果 并返回到上一级页面
     12. $this->success('数据删除成功','跳转的模板名称')  跳转到制定的模板页
     13. 在模板中可以使用 __URL__ 代替动态生成的路径 最后面加上方法名 例如  __URL__/index 完美~
## 查询方式
  1. 普通查询方式
     1. 字符串查询 
            在 where(查询字符串条件)
            例子  $m->where('name='lee' and age = 18')->find() 查询 name=lee的并且年龄等于18的
     2. 数组形式 (推荐使用  格式更加的标准)
            $data['字段名称'] = 值
            $data['字段名称'] = 值
            $m->where($data)->find()   默认两个是 and 的关系
            如果想要换成or的关系那就需要加一个属性叫做 _logic
            $data['_logic'] = 'or'; 即可
     
  2. 表达式查询方式
     1. EQ   等于
     2. NEQ  不等于
     3. GT   大于
     4. EGT  大于等于
     5. ELT  小于等于
     6. LT   小于
     查询方式
     $data['id'] = array('gt',5);   id > 5 的
     $data['id'] = array('lt',5);   id < 5 的
     $data['id'] = array('elt',5);  id <= 5 的
     $data['id'] = array('egt',5);  id >= 5 的
     $data['id'] = array('eq',5);   id == 5 的
     $data['id'] = array('neq',5);  id != 5 的
     $data['id'] = array('eq',array(5,6));  id = 5 的 或者 id = 6 的
     $data['id'] = array('eq',array(5,6),'and');  id = 5 的 并且 id = 6 的
     $data['name'] = array('like','%li%');  name 包含 li 的
     $data['name'] = array('like',array('%w%','%li%'));  name 包含 li 的 或者 包含 w 的
     $data['name'] = array('notlike',array('%w%','%li%'));  name 不包含 li 的 或者 不包含 w 的
     $data['name'] = array('notlike',array('%w%','%li%'),'and');  name 不包含 li 的 并且 不包含 w 的
     $data['id'] = array(array('gt',2),array('lt',5));  id 大于 2 的 并且 小于 5 的
     $data['id'] = array(array('gt',2),array('lt',5),"or");  id 大于 2 的 或者 小于 5 的
     $data['id'] = array('in',array(2,3));  id 是 2 3 的
     $arr = $m->where($data)->find();
     print_r($arr);
  3. 区间查询
  		$data['id']=array(array('gt',4),array('lt',10));//默认关系是 and 的关系
  		//SELECT * FROM `tp_user` WHERE ( (`id` > 4) AND (`id` < 10) ) 
  
  		$data['id']=array(array('gt',4),array('lt',10),'or') //关系就是or的关系
  	  
  		$data['name']=array(array('like','%2%'),array('like','%五%'),'gege','or');
  4. 统计查询
  		count //获取个数
  		$count = $m->where('id > 5')->count();
  		max   //获取最大数
  		$m->max('字段名称');
  		min   //获取最小数
  		$m->min('字段名称');
  		avg   //获取平均数
        $m->avg('字段名称');
  		sum   //获取总和
  		$m->sum('字段名称');
  5. SQL直接查询
  	a、query 主要数处理读取数据的
  		成功返回数据的结果集
  		失败返回boolean false
  		$m=M();
  		$result=$m->query("select *  from t_user where id >50");
  		var_dump($result);
  	b、execute 用于更新个写入操作
  		成功返回影响行数
  		失败返回boolean false
  		$m=M();
  		$result=$m->execute("insert into t_user(`username`) values('ztz3')");
  		var_dump($result);

## 连贯操作
 没有顺序之别 谁前后都可以
 1. where
    1. where($data)
 2. order
    1. order('id desc')->select()
 3. limit
    1. limit(0,5) | limit('0,5') -> select()
 4. field
    1. field('username') | field(array('username','sex')) || field('id',true) 除了id字段不获取其余都获取
 5. group
    1. group('id')  返回本身类实例
 6. having
    2. having('id > 10 ')  在分组的基础上加上条件

## 视图
 1. 修改模板后缀名
    1. 在配置文件中配置   'TMPL_TEMPLATE_SUFFIX'=>'.tpl'
 2. 修改模板文件的目录层次
    1. 增加配置项  'TMPL_FILE_DEPR'=>'_';  模板名_方法名.html
 3. 模板主题
    1. 设置默认主题模板 需要在项目目录下创建一个模板文件夹 并增加配置项
       'DEFAULT_THEME'=>'your'
    2. 配置自动侦测模板主题
       'TMPL_DETECT_THEME'=>true
    3. 支持的模板主题列表
       'THEME_LIST'=>'your,my' 写的是所有的主题模板的文件夹名称
    4. 通过 url 地址栏传递  t=主题文件夹名称   修改参数值 可以替换不同的模板文件
 4. 输出模板内容
    1. 普通的display方法   $this->display() | $this.display('模板文件名称')   必须在同一模块下
    2. 访问不同模块下的模板  在 display方法里面加入('模块名称|文件夹名称:模板名称')  不带后缀  
 5. 模板替换
     1. 模板替换          （重点）
         __PUBLIC__：会被替换成当前网站的公共目录 通常是 /Public/ 可以用来引入公共文件 例如 css js 图片
         __ROOT__： 会替换成当前网站的地址（不含域名） 
         __APP__： 会替换成当前项目的URL地址 （不含域名）
         __GROUP__：会替换成当前分组的URL地址 （不含域名）
         __URL__： 会替换成当前模块的URL地址（不含域名）
         __ACTION__：会替换成当前操作的URL地址 （不含域名）
         __SELF__： 会替换成当前的页面URL
			
         更换模板变量规则，修改配置项
            'TMPL_PARSE_STRING'=>array(           //添加自己的模板变量规则
            '__CSS__'=>__ROOT__.'/Public/Css',
            '__JS__'=>__ROOT__.'/Public/Js',
		    ), 
## 验证码的使用
 1. 验证码默认不是在核心包里面
 2. 需要我们引入扩展包里面的内容
 3. 我们可以拷贝一份扩展包里面的内容 然后给复制到ThinkPHP核心包目录下面的Extend文件夹
 4. 编写一个模块因为有多处需要用到验证码
 5. 在里面写入一个方法 引入 图片类
 6. Public function verify(){
        import('ORG.Util.Image');
        Image::buildImageVerify();
    }
 7. 在模板里面 创建一个  img标签  src=__APP__+"/Public/code" 即可 __APP__是获取到这个应用的路径 不带模块
 8. 如果想点击刷新的话添加一个点击事件即可
 9. onclick="this.src=this.src+?"Math.random()"" 加随机数是为了在IE中能够正常使用  因为IE会读缓存
 10. 后台验证验证码   判断是否一致
    1. if($_SESSION['verify'] != md5($_POST['verify'])) {
          $this->error('验证码错误！');
          }
 11. 还有中文验证码  具体可以去看手册使用 在  杂项-验证码位置
## 模板变量
 1. 变量输出
    1. {$变量}
    2. {$name[0]}  索引数组输出
    3. {$name['key']}  关联数组输出
    4. {$name.key}  关联数组输出
    5. {$name:name}  对象输出 
        1. 在thinkPhp中想要使用自定义的类就需要在核心包下的Extends中的扩展文件夹的lib文件夹下面一致翻到第新建自己的类目录
        2. 引入的时候通过 import('ORG.你的文件夹名字.类名') 
        3. 可以实例化了
 2. 系统变量
    1. {$Think.get.xxx}   get 参数
    2. {$Think.post.xxx}  post参数
    3. {$Think.session.xxx} session值
    4. {$Think.cookie.xxx}  cookie值
    5. {$Think.version.xxx}  版本号
    6. {$Think.now.xxx}     当前时间
 3. 使用函数
    1. {$name|md5}
    2. {$name|strtolower}
    3. {$name|date='Y-M-D H:i:s',###}
 4. 默认值
    1. {$name|default='默认值'}
 5. 运算符      
    1. + - * / % ++ -- 
## 模板中的语法
 1. 导入 CSS JS 文件
    1. __PUBLIC__/Js/index.js
    1. __PUBLIC__/Css/index.css
 2. 分支结构
    1. <if condition="$sex eq '男'">
            是男的
          <elseif condition="$sex eq '女'"/>
           是女的
           <else/>
           人妖
       </if>
       
    2. <switch name="$sum">
               <case value="20">
                   20
               </case>
               <case value="40">
                   40
               </case>
               <case value="60">
                   60
               </case>
          </switch>   
 3. 循环结构
    1.  <for start="0" end="10" name="v">
              {$v}
        </for>
       
        <foreach name="datasd" item="v" key="k">
                {$v}
        </foreach>
        
        <volist name='datas' id='vo'>
              {$vo}
        </volist>
        
         <volist name="你的数据名称" id="vo 这是每一次便利到的数组项 "></volist>      用来循环遍历数组     
 4. 特殊标签
    1. 比较标签   更方便的判断比较
        1. eq
          <eq name="n" value='2'> yes <else/> no </eq>
        2. gt
          <gt name="n" value='2'> yes <else/> no </gt>
        3. lt
          <lt name="n" value='2'> yes <else/> no </lt>
        4. elt
          <elt name="n" value='2'> yes <else/> no </elt>
        5. egt
          <egt name="n" value='2'> yes <else/> no </egt>
        6. in
          <in name="n" value='1,2,3,4,5'> yes <else/> no </in>          
 5. 其他标签使用    
        1. <php> echo '大家好' </php>   可以编写PHP代码 但是不推荐使用

## 模板的使用技巧
 1. 文件包含
    <include file='Public:header' title='开源框架' keywords='免费的开源框架'/>   Public 文件夹下的 header 模板 一般和模块放在同级目录
    file 也可以是一个完整的路径
    在公共的头部模板里面 使用 [title] 编译替换 或者 [keywords]
    html
        meta    
        head
            [title]
        /head
        body
        /body
    /html
## 控制器的模块和操作
 1. 空模块和空操作  容错机制
    1. 空操作  
       public function _empty($name){
            echo "$name - 你要的页面丢失了！！！";
       }    
    2. 空模块  在 Action 下面新建一个模块 名称是 EmptyAction.class.php
       class EmptyAction extends Action {
                public function index(){
                   echo "页面丢失了！";
                }
       }
 2. 前置和后置操作
    1. 用来判断是否有访问页面的权限
    2. 就是用户是否登陆了
    3. _before_方法名  _after_方法名 
    4. 就是在进入页面的前后瞬间进行一个操作
## URL
 1. URL 规则
     1. 默认URL是严格区分大小写的
     2. 可以修改配置项
     3. 如果模块名称比较复杂的话  那么可以在中间加上一个_ 否则访问不会成功
     4. 例子  UserGroupAction.class.php  必须配置不区分大小写才可以
        1. user_group/index  
 2. URL 伪静态
     1. 可以通过配置来限制伪静态的后缀名
 3. URL 路由
     1. 启动路由  是pathinfo模式才支持的
        1. 在路由中配置开启路由   ‘URL_ROUTER_ON’=>true  
        2. 配置路由项           ‘URL_ROUTE_RULES’=array('my'=>'Index/index')  静态路由 
        3. 动态路由             ‘URL_ROUTE_RULES’=array('my/:id'=>'Index/index')                   
        3. 动态路由正则匹配数字   ‘URL_ROUTE_RULES’=array('my/:id\d'=>'Index/index')    
 4. URL 重写
     1. 设置 rewrite 模式
 5. URL 生成
     1. U('Index/add',array("id"=>1,"name"=>2),"html")  生成一个URL  
## 分组 页面跳转 与 ajax 
 1. 分应用配置技巧
    1. 就是一个项目有前台后台
    2. 但是有的配置项是一样的
    3. 为了解决这个问题我们可以在项目的根目录下创建一个config.php里面写一些共用配置
    4. 在每一个相应的文件夹下面的conf下面的config.php中引入创建的公用的config.php
    5. include './config.php';  因为是根据项目入口文件算起的路劲 所以是./
    6. 然后将两个数组合并  并且返回即可
 2. 分组技巧
    1. 也是为了解决 相同配置的问题的
    2. 创建一个应用APP在配置项里面开启分组
        'APP_GROUP_LIST' => 'Home,Admin', //项目分组设定
        'DEFAULT_GROUP'  => 'Home', //默认分组
         在浏览器访问的时候记得带上分组的名称 /thinkphp/Home/Index/index
    3. 在Action下面创建你分组的文件夹名称
    4. 在对应的文件夹下面写对应的控制器
    5. 配置的话如果想要写不一样的个性配置 那就在Conf文件夹下面在创建两个分组制定好的文件夹 和Action下面的一样
    6. 然后创建一个confifg.php 开始写起各自的个性配置  原本拥有的config.php  
    7. 前台模板也是 在 Tpl 下面新建自己的分组文件夹  然后在下面在写html文件
 3. 页面跳转
    $this->success(message,'url');
    $this->error(mesage,'url');
    $this->redirect('url');
    $this->success('',U("User/test"));  跳转其他模块的时候  使用大U包含书 生成一个URL
 4. ajax
    $this->ajaxReturn(msg,title,status); 请求过来返回数据 
## 页面权限访问判断
 1. Thinkphp  提供了一个初始化的时候调用的方法
 2. 我们可以在访问需要权限的页面进行时用
 3. 使用
    1. 新建一个 CommonAction 类 继承 Action  
    2. 在里面编写 一个公共方法
    3. public class _initialize(){
          在里面进行判断
    }                 
    4. 然后在需要判断权限的控制器内继承这个Common这个类 即可 
    5. 在每一次进行访问到该控制器的页面的时候就会先去父类 调用此方法 如果不通过 就执行里面的操作
    6. 通过 就通过了正常显示  
## 自动创建
  调用   模型对象的   create() 方法
  之后调用add 即可  直接 获取到表单的数据 就可以直接插入到数据库了 
## 自动验证
   需要创建模型  名称规则 为 数据库表名Model 必须继承 Model  
   例如   UserModel extends Model  {     
        
            需要一个属性 
            protected $_vaildate = array(array(字段名称，验证规则，错误提示文本，...))
     
       }
    可以写多个  一个字段也可以写多个 
    在控制器中要使用大D函数 将 M 换成 D  
## 自动完成 
## 文件上传
## 验证码
## 分页                       
## config.php 配置项汇总
 ```
   'URL_PATHINFO_DEPR'=>'-',//修改URL的分隔符
   'TMPL_L_DELIM'=>'<{', //修改左定界符
   'TMPL_R_DELIM'=>'}>', //修改右定界符
   'DB_TYPE'=>'mysql',   //设置数据库类型
   'DB_HOST'=>'localhost',//设置主机
   'DB_NAME'=>'thinkphp',//设置数据库名
   'DB_USER'=>'root',    //设置用户名
   'DB_PWD'=>'',        //设置密码
   'DB_PORT'=>'3306',   //设置端口号
   'DB_PREFIX'=>'tp_',  //设置表前缀
   'DB_DSN'=>'mysql://root:@localhost:3306/thinkphp',//使用DSN方式配置数据库信息
   'SHOW_PAGE_TRACE'=>true,//开启页面Trace
   'TMPL_TEMPLATE_SUFFIX'=>'.html',//更改模板文件后缀名
   'TMPL_FILE_DEPR'=>'_',//修改模板文件目录层次
   'TMPL_DETECT_THEME'=>true,//自动侦测模板主题
   'THEME_LIST'=>'your,my',//支持的模板主题列表
   'TMPL_PARSE_STRING'=>array(           //添加自己的模板变量规则
   	'__CSS__'=>__ROOT__.'/Public/Css',
   	'__JS__'=>__ROOT__.'/Public/Js',
    ),
   'LAYOUT_ON'=>true,//开启模板渲染
   'URL_CASE_INSENSITIVE'=>true,//url不区分大小写
   'URL_HTML_SUFFIX'=>'html|shtml|xml',//限制伪静态的后缀
   'APP_GROUP_LIST' => 'Home,Admin', //项目分组设定
   'DEFAULT_GROUP'  => 'Home', //默认分组

 ```