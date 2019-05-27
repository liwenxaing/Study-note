COLOR 2
TITLE "上传git笔记"
@ECHO OFF

git status
git add .
git commit -m '提交了新的笔记'
git push https://github.com/liwenxaing/Study-note master
git log

ECHO "上传完毕" & pause > nul