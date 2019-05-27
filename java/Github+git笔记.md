# 1. GIT版本控制 - github 代码托管平台

 ## 1.1 基本概念

+ 开源的分布式版本控制系统

+ 2005 年正式诞生

+ 官网下载 http://git-scm.com/download/win

+ 学得是命令行模式下的 学会了界面模式的自然就会用了

+ ```shell
  git --version  //查看版本
  ```

+  git监听的其实就是文件的修改

## 1.2 使用前的配置

+ 就相当于注册
+ 打开cmd 输入如下命令

```shell
git config --global user.name 'liwenxaing';
git config --global user.email '2857734156';
//查看是否注册成功  如果拥有上面两条信息就证明注册成功了
git config --list;
```

## 1.3 理论基础

#### 1.3.1 Git记录的是什么？

+ git是将每个版本独立保存
+ 围绕三个区域分别是   工作区域 暂存区域 Git仓库  （三棵树）
  + **工作区域**
  + 平时存项目的地方
  + **暂存区域**
  + 保存的就是即将提交到仓库的内容，临时改动的文件
  + **Git仓库**
  + 最新版本的数据都存在这里

### 1.3.2 Git的工作流程

+ 在工作目录中添加 修改文件
+ 将需要进行版本管理的问文件放入暂存区域
+ 将暂存区域的文件提交到git仓库

### 1.3.3 Git管理文件的三种状态

+ 已修改 (modifyed)
+ 已暂存 (staged)
+ 已提交 (committed)

## 1.4 初始化git仓库

```shell
/* 首先建一个文件夹 当做是项目目录 cd 到此文件夹 执行如下命令 会生成.get文件夹 默认是隐藏状态的 可以选择显示  里面的核心目录不要修改*/
git init
```

## 1.5 正常GIt流程  创建文件 修改 >  添加到暂存区域  >  提交到仓库

+ 1. 在工作目录添加修改文件

  2. 执行   git add 文件名 

  3. ```shell
     /* 例子 */
     git add README.md
     ```

  4. 然后吧暂存区域的文件提交到git仓库

  5. 执行 git commit -m "这里面是描述 做了哪些改动"

  6. ```shell
     /*例子  提交到git仓库*/
      git commit -m "this is a file"
      
      [master (root-commit) e5385e0] add a aaa file
      1 file changed, 1 insertion(+)
      create mode 100644 aaa.txt 
      出现这个就代表没问题了   提交成功
     ```

 ## 1.6 查看状态 与 最近提交

+  git status   查看当前状态  在工作目录中修改了哪些文件  在暂存区域有哪些文件
+  如果显示红色就代表当前文件是在工作目录中
+ 如果显示绿色就代表当前文件是在暂存目录中
+ 如果显示 nothing to commit, working tree clean  就代表没有需要提交的文件
+ git log 可以查看最近提交到仓库的内容 以及描述  会有一个sha1 效验码 作为id
+ 从下至上  从最早到最晚提交顺序

![1543130521260](C:\Users\Administrator\AppData\Local\Temp\1543130521260.png)![#1543130602599](C:\Users\Administrator\AppData\Local\Temp\1543130602599.png)

 ##  1.7 回到过去 - 将提交到仓库的文件恢复到暂存区域 将 暂存区域的文件回复到工作目录

+ git checkout -- fileName   可以将提交到暂存区域的文件回复到本地工作区域 影响工作区 并回到修改代码之前
+ git reset HEAD fileName   将版本库中的文件回退到暂存区 不影响工作区

## 1.8 Github 免费的空间

+  新建一个 Repository 名字为 你的用户名称 + .github.io
+ 在里面创建一个首页就可以了 html

## 1.9 从远程克隆项目到本地 

+ git clone 地址    示例 git clone https://github.com/2857734156/test.git
+ 将远程项目下载到本地 我们可以修改这个项目里的文件
+ 修改之后添加到暂存区 在提交到本地仓库
+ 当我们在本地将文件搞到本地git仓库中的时候我们想要将其推送到原生github上的时候我们就可以使用
+ git push 推送到远程仓库           git pull 从远程仓库下载到本地
+ shift + z + z  退出注释模式



![1543139418023](C:\Users\Administrator\AppData\Local\Temp\1543139418023.png)



## HEAD 

+ HEAD指向当前最新的版本

### 版本回退 与 时光穿梭机

+ 就是回退到上一个版本
+ 比如你刚提交了一个最新的版本
+ 你想要退回到提交这个最新版本的上一个版本
+ 就可以使用以下命令 文件内容就会恢复到你上一个版本的内容
+ 这时候查看git log 的时候你最近一次提交的信息就没有了
+ 一个^就是回退一个版本  以此类推

```
git reset --hard HEAD^        一个^就是上一个版本  上上一个版本就是 ^^   以此类推
```

+ 现在，你回退到了某个版本，关掉了电脑，第二天早上就后悔了，想恢复到新版本怎么办？找不到新版本的`commit id`怎么办？ 
+ 在Git中，总是有后悔药可以吃的。当你用`$ git reset --hard HEAD^`回退到上一个版本时，再想恢复到刚刚推回退的版本就必须找到刚刚回退版本的commit id。Git提供了一个命令`git reflog`用来记录你的每一次命令： 
+ 在执行git reflog 之后 会把提交的commit id展示出来 你可以选择你最近回退的版本重新恢复过去  记的在HEAD@{标识序号}
+ git reset --hard HEAD@{3}   重新穿梭到已经回退了的版本  内容会重新出来

### 撤销修改

当你改乱了工作区某个文件的内容，想直接丢弃工作区的修改时，用命令`git checkout -- fileName`。 

### 差异

![1543150709856](C:\Users\Administrator\AppData\Local\Temp\1543150709856.png)

## Git 的存储

+ 暂存区就是在.git文件夹下的index文件中

## Git 分支

![1543153057563](C:\Users\Administrator\AppData\Local\Temp\1543153057563.png)

+ 在git中默认会有一个master分支
+ git的分支就是一个文本文件里面的内容是hash值  分支会指向最新的提交
+ 一个提交可以被多个分支指向
+ 默认分支是存放在.get/refs/heads
+ ![1543153323624](C:\Users\Administrator\AppData\Local\Temp\1543153323624.png)

### 创建分支

+ git branch dev
  + .get/HEAD 这个文件就记录了我们现在是工作在那个分支上面

## GIT 命令

```shell
# git 命令
cd ~/.ssh 移动到ssh目录
ssh-keygen 生成公钥密钥
git remote -v 列出远程分支 带地址
git remote add origin https://github.com/2857734156/gitTest.git  添加一个远程仓库
git push origin dev (分支名称)   发布到远程仓库的分支
git branch dev 创建分支  不会自动切换到此分支
git checkout -b dev  创建分支并自动切换到此分支
git checkout dev 切换到要使用的分支
git branch 查看分支 * 在谁前面就代表我们在哪一个分支上面进行工作
ll .get/refs/heads  查看文件下的分支
git config --global user.name
git config --global user.email
git init test 在本地创建一个仓库
git add a.txt  添加到暂存区
git add .   会把所有改动的都放到暂存区里面
git commit -m  '描述'  提交到本地仓库
git status  查看状态   红等于在工作目录   绿等于在暂存区域
git log  查看最近提交的信息
git push  推送到远程仓库
git pull  下载修改的文件到本地
git clone 克隆整个项目到本地
git commit 回车  会让你打注释 shift + z + z 退出
git help   查看帮助
git --version  查看版本
git config --list  查看配置列表
clear 清屏
pwd   显示当前目录列表
vi  a.txt  终端编辑 编辑某一个文件 不存在则创建编辑  存在则编辑  insert 切换插入  按 esc 然后按 shift + z + z 退出
git diff  查看暂存区 与 工作目录文件的文件差异
git diff HEAD 查看工作目录 与 本地仓库的文件差异
git diff --cached 本地仓库与暂存区的差异
touch init.txt  在git中新建文件
git rm --cached  init.txt  从暂存区移除到工作目录
git ls-files -s 查看暂存区存储的文件
git cat-file -p 上面输出的hash值前四位即可 查看内容
cat a.txt 查看文件内容
git rm filename 删除文件
# cmd 
mspaint 打开画图
del a.txt 删除一个文件
echo "">a.txt 创建一个文件
rd 空文件夹  删除空文件夹
rd /s 文件夹    删除文件夹带文件
```

# 2. GitHub

+ 新建仓库  new repository
+ 删除仓库 setting   delete  repository