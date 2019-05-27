# Mongodb 笔记
## 配置数据库
  + **下载后安装 傻瓜式**
  + **配置环境变量** 
  + **mongod 启动数据库**
  + **mongo  链接数据库**
  + **exit   退出链接**
##核心命令导入导出

+ bsondump 导出bson结构
+ mongodump 整体数据库导出
+ mongoexport 导出易识别的json文档
+ mongorestore  数据库整体导入
+ mongos 路由器(分片时用)

## 查看当前数据库

  + show dbs  
## 创建数据库
  + use dbName  
## 查看当前使用的数据库
  + db
## 查看当前数据库的所有集合
  + show collections
##  删除数据库
  + db.dropDatabase()
## 创建集合
  + db.createCollection(name,option) 
## 删除集合
  + db.collectionName.drop()
## 插入文档
  + db.collectionName.insert({name:"lee",age:"18"})
  + db.collectionName.insertOne({name:"lee",age:"18"})  
## 更新文档

+ db.admin_article.update({'_id':ObjectId("5cb9e7e44910e730e81e30dd")},{'$unset':{'volumn':''}})  删除某一个字段

  + db.collectionName.update(query,update)
  + db.col.update({'title':'MongoDB 教程'},{$set:{'title':'MongoDB'}})   
  + 只更新第一条记录：
  + db.col.update( { "count" : { $gt : 1 } } , { $set : { "test2" : "OK"} } );
  + 全部更新：
  + db.col.update( { "count" : { $gt : 3 } } , { $set : { "test2" : "OK"} },false,true );
  + 只添加第一条：
  + db.col.update( { "count" : { $gt : 4 } } , { $set : { "test5" : "OK"} },true,false );
  + 全部添加进去:
  + db.col.update( { "count" : { $gt : 5 } } , { $set : { "test5" : "OK"} },true,true );
  + 全部更新：
  + db.col.update( { "count" : { $gt : 15 } } , { $inc : { "count" : 1} },false,true );
  + 只更新第一条记录：
  + db.col.update( { "count" : { $gt : 10 } } , { $inc : { "count" : 1} },false,false );  
## 删除文档
  + db.collection.remove(query,justOne[如果设为 true 或 1，则只删除一个文档，如果不设置该参数，或使用默认值 false，则删除所有匹配条件的文档。]) 
## 查询文档
  + db.collection.find(query)
  + 操作	格式	范例RDBMS中的类似语句
  	 等于	     {<key>:<value>}	    db.col.find({"by":"菜鸟教程"}).pretty()	 where by = '菜鸟教程'
  	 小于	     {<key>:{$lt:<value>}}	db.col.find({"likes":{$lt:50}}).pretty()  where likes < 50
  	 小于或等于 {<key>:{$lte:<value>}}	db.col.find({"likes":{$lte:50}}).pretty() where likes <= 50
  	 大于	     {<key>:{$gt:<value>}}	db.col.find({"likes":{$gt:50}}).pretty()  where likes > 50
  	 大于或等于 {<key>:{$gte:<value>}}	db.col.find({"likes":{$gte:50}}).pretty()  where likes >= 50
  	 不等于	 {<key>:{$ne:<value>}}	db.col.find({"likes":{$ne:50}}).pretty()  where likes != 50  
        MongoDB AND 条件
  + db.col.find({key1:value1, key2:value2}) 
    MongoDB OR 条件
  + db.col.find({$or:[{key1:value1}, {key2:value2}]})    
    AND 和 OR 联合使用
  + db.col.find({"likes": {$gt:50}, $or: [{"by": "菜鸟教程"},{"title": "MongoDB 教程"}]})
## limit
  + db.col.find({},{"title":1,_id:0}).limit(2) 查询两条
## skip
  + db.COLLECTION_NAME.find().limit(NUMBER).skip(NUMBER) skip 表示跳过几条数据 
## MongoDB 排序
  + db.COLLECTION_NAME.find().sort({KEY:1|-1})
## MongoDB 索引
  + db.col.createIndex({"title":1}) 
  + 语法中 Key 值为你要创建的索引字段，1 为指定按升序创建索引，如果你想按降序来创建索引指定为 -1 即可。
  + db.col.createIndex({"title":1,"description":-1})
  + createIndex() 方法中你也可以设置使用多个字段创建索引（关系型数据库中称作复合索引）。 
## 模糊查询
  + db.posts.find({post_text:{$regex:"runoob"}})
  + b.posts.find({post_text:{$regex:"runoob",$options:"$i"}})   不区分大小写
## 聚合函数
  + db.koas.count({name:"liwenxaing"})  查询总数
    

名字	描述
$avg	Returns an average of numerical values. Ignores non-numeric values.（返回平均值）
$first	Returns a value from the first document for each group. Order is only defined if the documents are in a defined order.（返回第一个）
$last	Returns a value from the last document for each group. Order is only defined if the documents are in a defined order.（返回最后一个）
$max	Returns the highest expression value for each group.（返回最大值）
$min	Returns the lowest expression value for each group.（返回最小值）
$push	Returns an array of expression values for each group.
$addToSet	Returns an array of unique expression values for each group. Order of the array elements is undefined.（）
$stdDevPop	Returns the population standard deviation of the input values.
$stdDevSamp	Returns the sample standard deviation of the input values.

$sum	Returns a sum of numerical values. Ignores non-numeric values.（返回总和）

