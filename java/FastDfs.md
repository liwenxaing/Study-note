## FastDFS

### 简介

+ 是一个共享的文件存储系统
+ 支持单点的 同时也支持集群
+ 是使用C语言编写的一个文件系统
+ 使用起来比较简单 但是安装的时候稍微复杂一些
+ 两大概念点
  + Tracker 跟踪器  通过这个访问到资源
  + Storage   存储库

### 安装

```shell
# 第一步 安装gcc-c++
yum install make cmake gcc gcc-c++
# 安装公共的 libfastcommons
上传libfastcommons-master.zip 到usr/local目录下
# 进行解压
unzip libfastcommons-master.zip -d  /usr/local/fast
# 进入目录
cd /usr/local/fast/libfastcommons-master
# 进行编译和安装
./make.sh
./make.sh install
# 默认安装路径是/usr/lib  我们可以将主程序目录设置为/usr/local/lib 就需要创建软链接了
# 命令
mkdir /usr/local/lib
ln -s /usr/lib64/libfastcommon.so /usr/local/lib/libfastcommon.so
ln -s /usr/lib64/libfastcommon.so /usr/lib/libfastcommon.so
ln -s /usr/lib64/libfastclient.so /usr/local/lib/libfastcommon.so
ln -s /usr/lib64/libfastclient.so /usr/lib/libfastclient.so
# 安装FASTDFS
# 上传FastDFS tar.gz包到/usr/local/software
cd /usr/local/software
tar -zxvf FastDFS_v5.05.tar.gz -C /usr/local/fast
# 安装编译
cd /usr/local/fast/FastDFS
./make.sh
./make.sh install
# 默认安装方式脚本文件说明
# 服务脚本在
/etc/init.d/fdfs_storaged
/etc/init.d/fdfs_trackerd
# 配置文件在
/etc/fdfs/client.conf.sample
/etc/fdfs/storage.conf.sample
/etc/fdfs/tracker.conf.sample
# FastDFS服务脚本设置的bin目录为/usr/local/bin/下 但是实际我们安装在了/usr/bin/下面  所以我们需要修改FastDFS文件中的路径   也就是需要修改两个配置文件
# 命令
vim /etc/init.d/fdfs_storaged
# 进行全局替换
%s+/usr/local/bin+/usr/bin
# 命令
vim /etc/init.d/fdfs_trackerd
# 进行全局替换
%s+/usr/local/bin+/usr/bin

# 在某一个节点中配置 tracker 追踪器
cd /etc/fdfs
cp tracker.conf.sample   ./tracker.conf
vim  ./tracker.conf
# 修改basepath为自定义的一个目录
# 例如
basepath=/fdfs/tracker
# 创建目录
mkdir /fdfs/tracker
# 关闭防火墙
service iptables stop  
# 或者添加配置开放端口
vim /etc/sysconfig/iptables
# 启动tracker
/etc/init.d/fdfs_trackerd start
/etc/init.d/fdfs_trackerd  stop
ps -ef | grep fdfs   # 查看进程
# 设置开机自启动
vim /etc/rc.d/rc.local
# 加入配置 即可
/etc/init.d/fdfs_trackerd start  

# 在某一个节点中配置 storaged 存储

```

