## Docker 容器

### Paas平台

+ PAAS平台通过网络进行程序提供的服务称之为[SaaS](https://baike.so.com/doc/5924595-6137516.html)(Software as a Service)，而[云计算](https://baike.so.com/doc/5477834-5715746.html)时代相应的服务器平台或者开发环境作为服务进行提供就成为了 PaaS(Platform as a Service)。
+ 把应用服务的运行和开发环境作为一种服务提供的商业模式 

### Docker 简介

+ 是基于GO语言实现的云开源项目
+ Docker 是第三代的Pass平台
+ Docker 就是一个虚拟化的一种轻量级的替代技术
+ 不依赖任何语言和系统
+ 容器虚拟化技术
+ Docker是一个开源的应用容器引擎 基于Linux内核的cgroup namespace Union等技术 对应用进行封装隔离 并且独立与宿主机与其他进程 
+ 可以将APP变成一种标准化的 可移植的 自管理和组件 可以在任何主流系统中运行调试

+ Docker hub   
  + 镜像仓库  可以将自己打包的镜像上传上去 让别人下载使用
+ image
  + 镜像
    + 包括环境  配置  代码 ....... 等
+ LXC
  + linux container
+ Docker 三要素
  + 容器
    + linux container 不是一个完整的操作系统 而是对进程进行了隔离  有了容器 就可以将软件运行所需要的所有资源打包到一个隔离的容器中去 相对来说轻便很多  保证运行在和部署在任何 环境中都能正常的运行	容器是用镜像创建的实例
    + 每隔容器之间相互隔离
  + 镜像
    + 包含我们开发人员配置好和编写好的代码 配置 环境 等内容......    即拿即用
  + 仓库
    + 我们可以将打包好的集装箱或者说镜像容器发布到仓库中  就可以下载了  类似github那种网站
+ 一句话概括
  + 解决了运行环境和配置问题以及软件容器
  + 方便做持续集成并有助于整体发布的虚拟化容器技术
+ 虚拟机
  + 就是带环境安装的一种解决方案
  + 就是可以在一个操作系统中模拟运行另一种操作系统  必须在window操作系统中运行linux操作系统  应用程序对此毫无感知
  + 硬件也模拟
  + **虚拟机的缺点**
    + 占用内存多
    + 冗余步骤多
    + 启动慢
+ docker
  + 启动快
  + 更快速的应用交付和部署
  + 更便捷的升级和扩缩容
  + 更简单的系统运维
  + 更高效的计算机资源利用
  + 标准的 统一的打包部署方案
+ 官网
  + http://www.docker.com
  + https://www.docker-cn.com
  + https://hub.docker.com
+ Docker Hub 一般不用  国外太慢  用阿里云的快速

### 生命周期

+ create  
+ running -> [ <- stop | <- pause]
+ kill|Destory

### 部署安装

+ 查看内核版本  uname -r    要大于2.6.32.431
+ 查看服务器系统版本  cat /etc/redhat-release
+ https://blog.csdn.net/qq_39057639/article/details/95060711   博客安装地址

##### 配置镜像加速器

百度搜索阿里云

控制台 > 搜索容器镜像服务

针对Docker客户端版本大于 1.10.0 的用户

您可以通过修改daemon配置文件/etc/docker/daemon.json来使用加速器

```
sudo mkdir -p /etc/docker
sudo tee /etc/docker/daemon.json <<-'EOF'
{
  "registry-mirrors": ["https://llttyfsz.mirror.aliyuncs.com"]
}
EOF
sudo systemctl daemon-reload
sudo systemctl restart docker
```

### Docker 原理

+ Docker后面有一个后台守护进程 里面可以安装任意个软件 例如 redis  ngxin 等 来运行
+ Docker 减少了抽象层  中间层  没有了硬件的负累   在进行重新启动的时候要比虚拟机快非常多 而是有一个Docker引擎来帮助Docker启动关闭

### 常用命令

+ systemctl start docker 启动docker
+ systemctl enable docker  开机自启动
+ systemctl  restatr docker  重启docker
+ docker run imageName  运行一个镜像 如果不存在则拉取
  + --name
  + -it
  + -h
  + -i
  + -t
  + -P   随机分配端口
  + -p     主机端口:容器端口     例如启动tomcat      docker run -it -p 8888:8080  tomcat    在外部访问8888就能够访问到tomcat了    因为我们的tomcat是在docker中的所以我们需要访问docker  就是相当于做了一个映射
  + docker run -it  288545asd --name myCentOs     创建一个交互式容器
  + 进入到redis中 启动的环境 
  + docker exec -it 85564sad  /bin/bash     进入到容器中去
    + 还可以这样用
      + docker exec -it 85564sad  /bin/bash ls /  可以不进入到容器中 并且可以直接运行容器内部的命令
  + docker attach  容器ID    进入到容器中去
+ docker run -d 镜像名    启动守护式容器
+ docker version    版本
+ docker info       详细信息
+ docker --help    帮助
+ docker search tomcat
  + -s 30  点赞数大于30
  + docker search -s 30 tomcat
+ docker images   查看本地镜像
  + -a		显示所有本地镜像含中间层映像
  	 -q	         只显示镜像ID
  + --digests   显示镜像的摘要信息
  + --digests --no-trunc    显示完整的镜像信息
+ docker pull tomcat  拉取镜像
  + 如果后面不加版本默认是最新的镜像
  + 加了版本就是指定的版本
  + docker pull tomcat:7.0
+ docker rmi -f  hello-world  强制删除镜像
+ docker rmi -f hello-world nginx  删除多个镜像
+ docker rmi -f $(docker images -qa)  删除所有镜像
+ docker ps   列出当前正在运行的docker进程
  + -l  上一个容器
  + -n 2    前n个容器
+ exit   退出容器
+ ctrl+p+q    容器不停止退出
+ docker exec -it 容器ID /bin/bash     重新进入到容器中 
+ docker start   容器ID或者容器名称   启动容器
+ docker  stop   容器ID或者容器名称    停止容器
+ docker kill   容器ID或者容器名称       强制停止容器
+ docker rm 容器ID      删除容器
+ docker rm -f   容器ID    强制删除容器
+ docker rm -f $(docker ps -qa)   删除所有容器
+ docker restart 容器ID或者容器名称   重启容器
+ docker logs -f -t -tail 容器ID  查看容器日志
  + -f 跟随最新的日志打印
  + -t 加入时间戳
  + --tail  数字  显示最后多少条
+ docker top 容器ID   查看容器内进程
+ docker cp 容器ID:容器内路径  目的主机路径       可以将容器中的文件拷贝到宿主机上
+ docker commit -a='lwx' -m='commit my image' 容器ID  要创建的目标镜像名:[标签名]
  + docker commit -a='lwx' -m='commit my image '  asd54as6d  lwx/tomcat:1.2

### Docker镜像

##### 镜像是什么

镜像是一种轻量级可执行的独立软件包    用来打包软件运行环境和基于运行环境开发的软件   包括代码 运行时  库 环境变量  和 配置中心

Docker 镜像的底层是UnionFS 联合文件系统  是一种分层 轻量级 并且高性能的文件系统 他支持对文件系统的修改作为一次提交来一层层叠加    

**特性**

一次加载多个文件系统  带从外面看起来 只能看到一个文件系统 联合加载会把各个文件叠加起来

### 容器数据卷

##### 直接命令添加

+ 容器的持久化
+ 容器间继承+数据共享
+ 能够实现主机和容器之间的数据共享
+ 命令    
  + docker run -it -v /myDataVolume:/myDataVolume 1123asdwe
  + docker run -it -v 主机目录:容器目录 容器ID
  + docker run -it -v /myDataVolume:/myDataVolume:ro 1123asdwe
    + 容器只读
    + 宿主机可读可写
  + docker inspect  容器ID  查看信息

##### Docker File 添加

+ 是images镜像的描述 底层源码

##### --volumes-from

+ 容器间相互传递 共享数据
+ **用到了在百度**   

###Docker File

+ DockerFile 是用来构建Docker镜像的构建文件 是由一系列命令和参数构成的脚本

+ DockerFile 保留字指令必须大写

+ 执行顺序从上至下

+ docker build -f /path/dockerFile01  -t  mycentos:1.3 .      . 代表当前版本

  + docker build -f   dockerFile路径  -t   镜像名字:TAG   .

+ Docker File 关键字

  + FROM	          基础镜像  当前新景象是基于哪个镜像的
  + MAINTAINER   镜像维护者的姓名和邮箱地址
  + RUN                  容器构建时需要运行的命令
  + EXPOSE            对外暴露的端口
  + WORKDIR        指定在创建容器后 终端默认登录的进来的工作目录 一个落脚点
  + ENV                  用来在构建镜像过程中设置环境变量
  + ADD                 将宿主机目录下的文件拷贝进镜像 并且ADD命令会解压tar压缩包 自动处理URL
    + ADD /mydata/jdk.tar.gz   /usr/local/jdk.tar.gz
  + COPY               类似ADD 拷贝文件到目录镜像中   不会自动解压
    + COPY /mydata/c.txt   /usr/local/c.txt
  + VALUME          容器数据卷  用于数据保存和持久化操作  ['/path',‘/path’]
  + CMD                指定一个容器启动时需要执行的命令   dockerFile中可以有多个CMD指令  但只有最后一个生效     CMD  会被docker run 之后的参数替代
  + ENTYRPOINT    指定一个容器启动时需要执行的命令 
    + 在启动时的指令不会被docker run 之后的参数替代  而是会进行拼接 所以功能要比cmd强大一些
  + ONBUILD        当构建一个被继承的DockerFile时运行命令  父镜像在被子镜像继承后父镜像的onbuild被触发
    + ONBUILD echo 'success ...... 886'
    + 就是说一个父镜像被子镜像继承之后 父镜像中有ONBUILD 那么该ONBUILD就会被触发

+ 第一个脚本镜像描述文件  

+ ```dockerfile
  FROM centos
  MAINTAINER 'lwx2857734156@qq.com'
  ENV mypath /usr/local
  WORKDIR  $mypath
  RUN yum install -y  vim
  EXPOSE 8080
  CMD 'success.........'
  CMD '/bin/bash'
  ```

### 安装MYSQL

+ docker search mysql
+ docker pull mysql:5.6
+ docker run -p 3306:3306 --name mysql -v /lwx/mysql/conf:/etc/mysql/conf.d  -v /lwx/mysql/logs:/logs -v /mysql/data:/var/lib/mysql -e MYSQL_ROOT_PASSWORD=123456 -d mysql:5.6
+ 客户端就可以链接了
+ 可以进入到mysql中  登录用户
+ docker exec -it 容器ID  /bin/bash
+ mysql -uroot -p   回车 输入密码   123456   即可

### 安装Redis

+ docker pull redis:3.2
+ docker run -p 6379:6379 -v /lwx/redis/data:/data -v /lwx/redis/conf/redis.conf:/usr/local/etc/redis/redis.conf -d redis:3.2 redis-server /usr/local/etc/redis/redis.conf --appendonly yes
+ docker exec -it  容器ID  redis-cli    进入到redis中

### 本地镜像推送到阿里云

+ 登录阿里云   搜索 容器镜像服务
+ 创建镜像仓库   和 命名空间
+ 然后点击进去查看详情 进行推送
+ 推送完毕就可以搜索了   命名空间/镜像名称
+ 可以 拉取  docker pull  registry.cn-hangzhou.aliyuncs.com/liwenxiang/mylwx

### 卸载Docker

```shell
systemctl stop docker 
systemctl remove docker-ce 
rm -rf /var/lib/docker 
```

### 卸载旧版本

```shell
sudo yum remove docker \
                  docker-client \
                  docker-client-latest \
                  docker-common \
                  docker-latest \
                  docker-latest-logrotate \
                  docker-logrotate \
                  docker-engine
```

### CentOS7安装初始化命令设置

+ 查看ip
  + ip addr 
    + 查不到就去开启网卡设置  可能默认没开启网卡
      + /etc/sysocnfig/network-scripts/ifcfg-ens700000
        + onboot=yes
      + systemctl restart network  重启网络服务
      + 有可能最后的呢日哦那个不一样 可以切换到这个文件夹进行查看

+ 换回默认的iptables服务 同centos6位置一样  不换回的话会提示没有command

  ###CentOS7 关闭防火墙

CentOS6关闭防火墙使用以下命令， 

```shell
//临时关闭
service iptables stop
//禁止开机启动
chkconfig iptables off
```

CentOS7中若使用同样的命令会报错， 

```shell
stop  iptables.service
Failed to stop iptables.service: Unit iptables.service not loaded.
```

这是因为CentOS7版本后防火墙默认使用firewalld，因此在CentOS7中关闭防火墙使用以下命令， 

```shell
//临时关闭
systemctl stop firewalld
//禁止开机启动
systemctl disable firewalld
Removed symlink /etc/systemd/system/multi-user.target.wants/firewalld.service.
Removed symlink /etc/systemd/system/dbus-org.fedoraproject.FirewallD1.service.
```

当然，如果安装了iptables-service，也可以使用下面的命令 

```shell
yum install -y iptables-services
//关闭防火墙
service iptables stop
Redirecting to /bin/systemctl stop  iptables.service
//检查防火墙状态
service iptables status
Redirecting to /bin/systemctl status  iptables.service
鈼iptables.service - IPv4 firewall with iptables
   Loaded: loaded (/usr/lib/systemd/system/iptables.service; disabled; vendor preset: disabled)
   Active: inactive (dead)
```

