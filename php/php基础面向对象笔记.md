# PHP 基础笔记 与 面向对象笔记

## php 设置跨域 以及自定义请求头 的 传递与获取

```php
header('Content-Type: text/html;charset=utf-8');
header('Access-Control-Allow-Origin:*'); // *代表允许任何网址请求
header('Access-Control-Allow-Methods:POST,GET,OPTIONS,DELETE'); // 允许请求的类型
header('Access-Control-Allow-Credentials: true'); // 设置是否允许发送 cookies
header('Access-Control-Allow-Headers: Content-Type,Content-Length,Accept-Encoding,X-Requested-with, Origin,token'); // 设置允许自定义请求头的字段
```

```php
echo $_SERVER['HTTP_TOKEN'];  // 获取
```

```javascript
btn.onclick = function () {
    let xhr = new XMLHttpRequest();
    xhr.open("post","http://localhost:8080/upload/up.php",true);
    xhr.setRequestHeader("token","qeljakslcnlawelasd");  // 设置 可以设置的请求头
    xhr.onreadystatechange=function(){
        if(xhr.readyState === 4 && xhr.status === 200){
            console.log(xhr.responseText);
        }
    };
    xhr.send(null);
};
```

## 基础部分

####交互编码 设置头信息  声明文件生成的类型  声明编码

+ header("Content-Type:text/html;charset=utf-8"); 
+ header("Location:index.php")

####php 格式

+ <? = $name  ?>
+ <?php   echo $name   ?>

#### 打印变量

+ echo
+ var_dump
+ print

#### 删除变量

+ unset()

####检测变量是否存在

+ isset() 

####赋值模式

+ 传值赋值 

  + ```php
    // 传值赋值  不会相互影响  两个不同的内存空间
    $userName1 = "张三";
    $userName2 = $userName1;
    $userName2 = "李四";
    echo $userName2."-".$userName1;
    ```

+ 引用赋值 

  + ```php
    //引用赋值  相互影响  相同的内存空间
    $userName3 = "张三";
    $userName4 = &$userName3;
    $userName4 = "李四";
    echo $userName3."-".$userName4;
    ```

#### 声明变量

+ $变量名

#### 预定义变量共9个 (前四个 )

+ $_GET[]    获取到客户端GET传递过来的值 

+ $_POST[]    获取到客户端POST传递过来的值 

+ $_REQUEST[]   获取到任意方式传递过来的值 

+ $GLOBALS['a']  跨作用域访问变量 

+ $_FILES['file'] 获取到上传的文件信息

+ $_SERVER[]   服务器与客户端相关信息 

  + ```php
    echo $_SERVER["HTTP_USER_AGENT"]; //浏览器信息
    echo $_SERVER['REMOTE_ADDR']; //客户端IP
    echo $_SERVER['SERVER_ADDR']; //服务器IP
    ```

#### 数组与数组操作

+ $arr = array();   低版本支持 
+ $arr = ["数钱","帅哥","美女"];    高版本支持 
+ implode('-',$str)   这个函数指的是通过一定的符号将某一个数组里面的元素进行拼接成字符串 
+ join("-",$str)    这个函数指的是通过一定的符号将某一个数组里面的元素进行拼接成字符串 
+ explode(' ',$str); //将字符串按照指定的分隔符转换成数组 
+ array_splice($array,0,1) 删除元素 返回删除的元素 
+ array_splice($array,0,1,['aaaa']); //删除指定的元素替换新的元素 
+ extract($a);  将数组的key作为变量名称  数组的值作为变量 
+ array_filter($numbers,'test') 对数组进行过滤  把数组中的每一个值传递给回调函数  第二个参数是一个函数名字 里面可以写条件 
+ 索引数组  [0,1,2,3]
+ 关联数组  ['a'=>"Lee",'b'=>"Mr."] 
+ \$arr[] = $i; //在数组后面添加元素 
+ array_unique($arr) 去除数组中重复的值 
+ in_array(1,$list) 检测数组中是否拥有某一个值 
+ sort($newList); //对数组进行排序 
+ rsort($arr);  //对数组进行降序 
+ ksort();  按照键名进行升序 
+ krsort(); 按照键名进行降序 
+ shuffle($arr); //将数组的顺序打乱 
+ array_reverse($arr); //将数组进行翻转 
+ array_rand($arr,3)  从数组中随机取N个元素的键名
+ array_merge([1,2],[4,5])  合并数组  返回一个新的数组 
+ array_push($list,'Lee'); //在数组后面添加一些元素 
+ array_pop($list,'Lee'); //在数组后面移除一个元素
+ array_unshift();   数组前追加
+ array_shift ()  数组前移除 
+ list($a,$b,$c) = $arr;  就按那个数组中的元素按顺序赋值给变量 
+ 打印数组
  + print_r($arr2); 	

#### 加密函数

+ sha1 ()
+ md5 ()
+ base64_encode ()
+ uniqid();  唯一ID 

#### 常量

+ define("PAI",'3.14');   定义常量    
+ constant('PAI') 输出常量
+ defined("PAI");   判断常量是否存在 

#### 魔术常量  前有都有__

+ echo __LINE__; //获取到当前的行号

  echo __FILE__; //获取到当前的文件的路径

  echo __DIR__; //获取到当前文件的路径 到目录

  echo __FUNCTION__; //获取到当前的函数名

  echo __CLASS__; //获取到当前的类名

#### 进制转换

+ bindec(1000101); //二进制转换为十进制 
+ decoct(10); //十进制转八进制 
+ dechex(15); //十进制转16进制 

#### 类型转换

+ (integer)"5"+1 
+ (float)1 
+ (string)5 

#### 字符串区别与操作

+ 链接字符串 .

+ ‘’ 单引号不会识别变量

+ “” 双引号能识别变量

+ \{$a}  \|  \${a}  都能够放变量

+ []操作符  查看 修改 不能删除 

+ strtolower($str);  转换小写

+ strtoupper ($str)  转换大写

+ substr($str,0,1); //截取字符串 

+  mb_substr($str1,0,1); //截取中文 

+ strrchr($str2,'.'); //倒过来进行截取 

+  str_replace('.',"点",$str2); //字符串替换 

+ trim($str3); //去除空格 

+ ltrim($str3); //去除左边空格 

+ rtrim($str3) ; //去除右边空格 

+  htmlspecialchars($str); //去除HTML标记的功能 过滤HTML字符串 

+ urlencode("大家好"); //编码 

+ urldecode(urlencode("大家好")); //解码 

+ 

+ 复杂字符串 多行字符串

  + ```php
    $str =<<<xml
    <?xml version="1.0"  encoding="UTF-8" ?>
    <root>
     <person> 人类 </person>
     <Animal> 动物 </Animal>
    </root> 
    xml;
    echo $str;
    ```

    

#### 流程语句简易if

```php
$i = 5;
if($i < 10) :
   echo "小于5";
endif;
echo "<br/>";
if(true):
    echo "小于5";
else:
    echo "小于1";
endif;
echo "<br/>";
for($i = 0; $i < 5 ; $i++):
    echo $i;
endfor;
echo "<br/>";
while($i >= 1):
   echo $i;
   $i--;
endwhile;
```

#### 模块引入

+ include  报警告错误 后面代码继续执行  用法一: include '文件路径'   用法二：include(’文件路径’) 
+ require  报致命错误 后面代码不带执行  用法一: require'文件路径'   用法二：require(’文件路径’) 
+ include_once 
+ require_once  

#### 判断函数是否存在

+ function_exists (Fname)

#### 判断类型

+ is_numeric()
+ is_bool ()
+ is_long ()
+ is_double ()

#### 日期操作

+  date_default_timezone_set('Asia/Shanghai'); //设置时区 
+  date('Y-m-d H:i:s')    获取到当前时间 大 H 24小时制 
+ time(); //返回当前的时间戳 
+  date("Y-m-d H:i:s",1994619855); //第二个参数是一个时间戳 可以根据此时间戳格式化一个时间 
+ strtotime($str)  将字符串转化为时间戳

#### 数学函数

+  ceil(5.1); //进一取整 
+  floor(4.1); //舍去取整法 
+  dechex(rand(0,15)); //随机数并转换成16进制 
+ round(5.4); //四舍五入 

#### 捕获异常

```php
 try{
     echo "早上起床";
     //  抛出一个异常
     if(true){ //自己设定可能发生的错误时抛出一个异常
         throw new Exception("起不来了");
     }
 }catch(Exception $e){
     echo "按闹铃";
 }finally{
     echo "总要执行的";
 }

```

#### 正则函数

+ preg_match('/^\d{11}$/',$str) 
+ preg_match_all("/^\d+$/",$str,$mt))   判断是否匹配成功 并且返回一个匹配到的元素的数组 给第三个参数变量 
+ preg_replace("/^(\d+)-(\d+)-(\d+)$/",'$1/$2/$3',$str); 

#### 文件系统

+ filetype('myTest.txt'); //判断文件类型 

+  is_file('myTest.txt'); //判断是否是文件 

+ file_exists('myTest.txt'); //判断文件或者目录是否存在 

+  is_dir('myTest.txt'); //判断是否是目录 

+  filesize('myTest.txt')."B"; 

+ unlink('a.txt'); //删除一个文件 

+ copy('./a.txt','./a/b.txt'); //复制一个文件到另一个目录 

+ rename('a.txt','new.txt'); //更改文件名 

+ **打开一个文件**

  + ```php
    //资源类型
    $res = fopen('myTest.txt','r');
     //读取文件内容  第二个参数是读取的长度
    // echo fread($res,filesize('myTest.txt'));
    echo fgets($res);
    
    echo fgets($res);
    fclose($res);
    
    $res = fopen('myTest.txt','a');
    //读取文件内容  第二个参数是读取的长度
    fwrite($res,"打架后\r\n");
    fwrite($res,'打架后aaaaa');
    
    fclose($res);
    
    
    
    
    
    $res = fopen('./myTest.txt','r');
    //上锁
    flock($res,LOCK_EX);
      while(!feof($res)){
          echo fgets($res);
          echo "<br/>";
      }
    //开锁
    flock($res,LOCK_UN);
    fclose($res);
    ```

+ file_get_contents($path) 

+ readfile($path);  读取文件内容并输出 

+  file_put_contents($path,'新加的',FILE_APPEND); 

+  file_put_contents($path,'新加的'); 

+ strtok('Hello world!','1') 

+ rmdir('b'); //删除目录 

+ mkdir('b'); //新建目录 

+ **目录**

  + ```php
    $resDir = opendir('a'); //打开一个目录
      while($file = readdir($resDir)){
          if($file != '.' && $file != '..'){
              if(is_dir($file)){
                  echo $file.'是目录';
              }else{
                  echo $file;
              }
    
          }
      }
    closedir($resDir); //关闭目录
    ```

  + scandir('a'); //获取到一个目录下的内容 返回一个数组 

+ move_uploaded_file($_FILES['file']['tmp_name'],'./b/'.$_FILES\['file'\]\['name'\]);

+ **文件的下载**

  + ```php
    //下载文件  知道路径  加上二进制流  定位到附件  使用readfile()输出就可以下载了
    header("Content-Type:text/html;charset=utf-8");
    
    $file = $_GET['file'];
    
    $download = './b/'.$file;
    
    $fileSize = filesize($download);
    
    header('content-type:application/octet-stream');
    
    header("content-disposition:attachment;filename={$file}");
    
    header("content-length:{$fileSize}");
    
    readfile($download);
    ```

#### Session Cookie

+  //开启session

   session_start();

+ $_SESSION['name'] = 'Lee'; 

+ unset($_SESSION); //清空所有session立即生效 

+ setcookie('PHPSESSID','',time()-1);   //清除sessionid

+ setCookie()  5.3版本以前 之前不能存在任何输出语句 因为他也是http标头的一部分 

+  // cookie名字  值  时间  作用范围

   setcookie('username','Lee',time()+3600,'/');

+ echo $_COOKIE['username']; 

+  print_r($_COOKIE); 

#### JSON 格式化函数

+ json_encode()
+ json_decode();

#### XSS防御转义函数

+ strip_tags($string)  可以去除html标签 只返回内容
+ htmlspecialchars($string,ENT_QUOTES)   将html字符进行转义原样输出

#### 上传信息拆解函数

+ pathinfo($_FILES\['file']['name']) 返回一个数组

# 面向对象部分

####类

```php
class Student
{
    public  $name;
    public  $age;
    public  $sex;

    public function __construct($name,$age,$sex){
        $this->name = $name;
        $this->age = $age;
        $this->sex = $sex;
    }
    //对象不在内存中时被销毁  PHP脚本执行完毕或者被删除
    public function __destruct(){
        // TODO: Implement __destruct() method.
        echo "对象被销毁了";
    }

    public function StudentOne(){
        //在内部使用$this调用本类的方法属性
        echo "学生的姓名是{$this->name},年龄是{$this->age},性别是{$this->sex}";

    }
}
 //创建对象    修改属性值
 $student = new Student('Mr.Lee','20','男');
 $student->StudentOne();
 //删除属性的值
 $student->sex = null;
 //删除属性
 unset($student->sex);
```

#### 类常量

+ const MAX = 10;   类常量 必须要初始化  不能出现在类的方法中 

#### 静态方法

+ 使用static修饰的
+ self::方法名   内部访问
+ 类名::方法名  外部访问

#### 静态属性

- self::属性名  内部访问
- 类名::属性名   外部访问

#### 继承

+ 使用extends关键字
+ 访问父类方法  parent::方法名|属性名

#### final

+ 被 final 修饰的类不能被继承 

#### 修饰符

+ private    私有的 
+ public    公共的  
+ protected   受保护的 

#### 抽象类

+ abstract 修饰  
+ 不能够被实例化 只能够作为子类的超类

#### 参数限制类型

+ ```php
  function test(array $arr,Animal $obj,$age){
       $obj->ec();
  }
  ```

#### 接口

+ 使用interface修饰
+ 子类实现使用  implements 
+ 可以多继承

#### 对象的克隆

```php
class a{
     public $name = 'Lee';
    //在进行克隆操作时调用
     public function __clone()
     {
         // TODO: Implement __clone() method.
         echo "克隆";
     }
}
$a1 = new a();
//通过克隆关键字克隆  是两个空间
$a2 = clone $a1;
```

#### 自动加载类

自动加载  系统会自动传入类名 直接调用即可 这就是自动加载 

```php
function __autoload($class_name){
    require "{$class_name}.class.php";
}

$book = new Book();
var_dump($book);


$person = new Person();
var_dump($person);
```

#### 操作XML

+ 实例化 SimpleXMLElement(复杂字符串)
+  asXML('test.xml');  生成xml文件
+ simplexml_load_file('test.xml');  载入XML 
+ $loadXml->asXML();  输出信息 
+ 解析xml  获取一级标签 \$loadXml->Person."-".\$loadXml->address; 
+ $loadXml->Person[0]."-".$loadXml->address[0];  获取多个相同的标签 
+  $loadXml->Pet->attributes();  获取属性 
+ $loadXml->Pet->Cat;  获取不同层级的标签 

#### 序列化

+ 序列化 将运行过程中具有类型的数据进行持久化 保存到如数据库 文件里 
+ serialize($data)  序列化函数 
+ 反序列化 将序列化后的数据重新加载到内存中 
+ unserialize() 反序列化函数  还原数据 

```php
//序列化时自动调用 返回需要序列化的属性数组
     public function __sleep(){
         return ['username','age','sex'];
     }

     //反序列化时对类进行初始化
     public function __wakeup(){
        //初始化操作
     }
```

#### 类特殊方法

//  __construct;

//  __destruct;

//  __clone;

//  __sleep;

//  __wakeup;

//  __autoload;

//  __toString;

//  __invoke;

// __callStatic  访问的静态方法不存在 

// __call    访问的方法不存在 

  

#### 属性的重载可以理解为封装 

+ __set($name,$value)  当给一个不可访问的属性设置值的时候调用 
+ __get($name) 当访问一个不可访问的属性的时候调用 

# 链接数据库

## PDO

+ 老方式链接发送

+ $pdo = new PDO("mysql:host=localhost;dbname=pdo","root","root");  连接数据库 
+  \$smt = \$pdo->query($sql);   发送sql语句  返回一个 PDOstatement对象 里面有收到结果集的方法 
+ $rows = $smt->fetchAll(PDO::FETCH_ASSOC);    获取到结果集  是一个数组 但是默认的话返回的是一个混合数组 我们一般只需要关联数组 所以需要添加 PDO::FETCH_ASSOC 
+ $pdo->exec("set names utf8");   设置字符集编码 
+ echo $pdo->exec($sql2);   执行增删改查  返回受影响的行数 
+ 以上的基本不用除了链接

## PDO 预处理语句

 预先将sql语句防止在服务器上发送请求时检查服务器上是否有此语句 有的话不发送直接执行  提高安全性 降低sql       注入 

+  $pdo = new PDO("mysql:host=localhost;dbname=pdo","root","root");   连接数据库 
+ \$smt = \$pdo->prepare($sql);     预备一条sql语句 返回  PDOStatement对象 
+  $smt->bindValue(1,1); //设置占位符的值  
+  $to = $smt->execute();   执行一条sql语句  返回true false 
+ $smt->fetchAll(PDO::FETCH_ASSOC)   获取到查询的结果集 
+ $smt->rowCount()  获取受影响的行数 
+ $smt->fetch(PDO::FETCH_NUM)  获取到资源结果集  如果还有一行数据  则返回一个一维数组  有多行的话就返回多维数组 
+  $smt->fetchColumn();  获取到某一行的第某列数据是0可以默认不写 调用一次下移一行 
+   $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);   设置默认的获取的关联数组的下标样式 
+  $pdo->getAttribute(PDO::ATTR_DEFAULT_FETCH_MODE);   获取到设置的属性  返回数值 
+  $pdo->lastInsertId();  获取到最后一次插入的ID 
+ **事务**
  + $pdo->beginTransaction();   关闭自动提交 
  + $pdo->commit();   提交
  + $pdo->rollBack();    回滚

 

---- - -- - - -- - ---------------------------------------

PDO 类  不推荐使用

 \*  exec()  返回影响行数

 \*  query() 执行sql

 \*  推荐使用

 \*  prepred() 提前预备一条sql到服务器上  推荐使用

 \*  lastInsertid() 获取到最后插入的id

 \*  setAttribute() 设置默认资源结果集返回的下标属性 PDO::ATTR_DEFAULT_FETCH_MODE

 \*  getAttribute() 获取到默认资源结果集的下标序列

 *

 \*  PDOStatement 推荐使用  更安全 降低sql注入

 \*  execute() 发送sql语句  返回true fasle

 \*  rowCount() 返回受影响的的行数

 \*  fetchColumn() 获取到某一行的某一列

 \*  bindValue() 设置占位符的值

 \*  fetch() 返回一行一位数据数据

 \*  fetchAll() 返回查找到的资源结果集

## MYSQLI

+ $mysqli = new mysqli("localhost","root","root","pdo");  链接数据库 

+ $mysqli->errno; //错误代号   运行时错误 

  $mysqli->error; //错误信息   运行时错误 

+ $mysqli->set_charset("utf8");   设置字符集

+ $mysqli->query($sql);  发送sql语句

+ $rows = $res->fetch_assoc(); 获取到一行数据 以关联数组 

+   res->fetch_array()   获取到一行数据 索引关联

+ ​    res->fetch_num()  获取到一行数据  索引数组

+   res->fetch_object()   获取到一行数据对象

+ $res->free(); 销毁结果集 

+ $mysqli->close();   关闭连接 

#常用自定义函数集锦

### 将json字符串转化为php对象

```php
$content= file_get_contents("http://t.weather.sojson.com/api/weather/city/101210501");
$contents = json_decode($content);//将json字符串转化成php数组

/* 将对象转为数组 */
function object_array($array) {
    if(is_object($array)) {
        $array = (array)$array;
    } if(is_array($array)) {
        foreach($array as $key=>$value) {
            $array[$key] = object_array($value);
        }
    }
    return $array;
}

echo  object_array($contents)['time'];
```

