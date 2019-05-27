# Hadoop笔记

## 修改主机ip 永久性不变

```linux
输入命令
vi /etc/sysconfig/network-scripts/ifcfg-eth0

删除UUID
删除MAC地址
ONBOOT=yes
IPADDR=192.168.190.110   ip  前三位和网关一样最后一位自己写[最大255]不写 0 1 永久的不变
NETMASK=255.255.255.0    子网掩码
GATEWAY=192.168.190.2    网关
BOOTPROTO=static

重启网络
service network restart

window 查看网关  MAC 物理地址
ipconfig/all

选择无线网络适配器 的 物理地址
```

## 克隆 之后修改网卡信息 和 ip

```
进入到如下文件 删除第一个 网卡信息  将第二个的eth1改为0
vi /etc/udev/rules.d/70-persistent-net.rules

进入到网卡配置
vi /etc/sysconfig/network-scripts/ifcfg-eth0

修改ip为其他的

重启虚拟机~~
```

## 修改用户名

```
vi /etc/sysconfig/network
```

## 修改系统时间

yum -t install  ntpdate

ntpdate pool.ntp.org

## 关闭防火墙

```
srvice  iptables status  查看状态
service iptables stop    关闭防火墙
chkconfig iptables off  永久关闭
```

