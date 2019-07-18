## Solr 和 Lucene笔记

### 简介

+ solr是一个分布式全文检索服务
+ 基于Lucene的全文搜索服务器
+ 实现了可扩展 可配置 并且对索引 搜索性能进行了优化
+ 可以独立运行在Jetty tomcat这些Servlet容器中
+ 使用到了倒排序索引  包含了文档和索引两部分
+ 全文索引就是首先在文档中创建索引  然后根据索引去查找对应的文档内容进行检索
+ 对于非结构化的数据  不是对于结构化的数据
+ 一个文档可以有不同的域
+ 采用java开发 是apache下的一个顶级项目

### Solr 和 lucene 区别

**lucene**

是一个开放源代码的全文检索引擎工具包 他不是一个完整的全文检索服务 如果需要构建一个站内搜索系统 需要自己开发许多代码  索引库 域   是 需要自己手动创建等..... 

**solr**

目的是打造一个企业级的搜索引擎系统 他是一个搜索引擎服务 可以独立运行 通过solr可以快速的构建企业级的搜索引擎 通过solr可以高效的完成站内搜索  大量配置

### solr安装

+ 将solr的tar包上传到虚拟机中
+ 解压
+ 移动到solr/example/webapps中有一个solr的war包
+ 移动到一个Tomcat的的servlet容器中的webapps文件夹下面
+ 修改一下solr下的web.xml文件设置env-entry的home为solr的路径**/example/solr** 这个目录是Solr运行的主目录  也可以将此目录下的内容复制出去到其他路径下  然后呢 设置复制到的目的路径
+ 然后复制solr下的lib下的ext下的jar包到tomcat的lib下
+ 然后可以启动tomcat进入到solr的管控台
+ 在管控台里面可以增加或者查询数据 但是一般是使用javaapi进行操作
+ slor就是一个服务器    分布式检索服务

### 配置IK分词器

+ 首先将分词器的jar包导入到solr的lib目录下

+ 在将配置文件复制到类路径下  编译过后的类路径在和WEB-INF同级的目录新建classes目录粘贴到里面

+ 然后在Schema.xml中进行配置IK分词器 配置如下

+ ```xml
  <fieldType name="text_ik" class="solr.TextField">
  	<analyzer class="org.wltea.analyzer.lucene.IKAnalyzer"/>
  </fieldType>
  
  <field name="content_ik" type="text_ik" indexed="true" stored="true" multiValued="true"/>
  <field name="name_ik" type="text_ik" indexed="true" stored="true" />
  ```

### Solr控制台增删改

+ 在Documents界面修改

+ 删除的话需要使用XML

  + 例如

    + ```xml
      <delete>
         <id>1</id>
      </delete>
      <commit/>
      <!-- 条件删除  删除所有-->
      <delete>
         <query>*:*</query>
      </delete>
      <commit/>
      <!-- 条件删除-->
      <delete>
         <query>id:change.me</query>
      </delete>
      <commit/>
      ```

### 配置批量导入数据

+ 使用dataimport插件导入数据

+ 第一步 ： 把dataimport插件依赖的jar包添加到solrcore中的collection1/lib中 没有就新建

  + solr-4.10.03/dist/solr-dataimporthandler.jar
  + solr-4.10.03/dist/solr-dataimporthandler-extras.jar
  + mysql-connection-java.jar

+ 配置 solrconfig.xml文件

  + ```xml
    <requestHandler name="/dataimport" class="org.apache.solr.handler.dataimport.DataImportHandler">
        <lst name="defaults">
            <str name="config">data-config.xml</str>
        </lst>
    </requestHandler>
    
    ```

+ 创建dataconfig.xml文件 保存到collection/conf目录下

  + ```xml
    <?xml version="1.0" encoding="utf-8"?>
    <dataConfig>
        <dataSource 
                    type="JdbcDataSource"
                    driver="com.mysql.jdbc.Driver"
                    url="jdbc:mysql://localhost:3306/lucene"
                    user="root"
                    password="root"/>
        <document>
            <entity name="product" query="SELECT pid,name,catalog_name,price,desc,createTime FROM products">
                <field column="pid" name="id"></field>
                <field column="name" name="product_name"></field>
                <field column="catalog_name" name="catalog_name"></field>
                <field column="price" name="price"></field>
                <field column="desc" name="desc"></field>
                <field column="createTime" name="createTime"></field>
             </entity>
        </document>
    </dataConfig>
    ```

+ 在Schema.xml中配置域

  + ```xml
    <field name="product_name" type="text_ik" indexed="true" stored="true"></field>
    <field name="catalog_name" type="text_ik"  indexed="true" stored="true"></field>
    <field name="price" type="float" indexed="true" stored="true"></field>
    <field name="desc" type="text_ik" indexed="true" stored="true"></field>
    <field name="createTime" type="string" indexed="true" stored="true"></field>
    
    <!-- 意思就是  以后搜索product_keywords就可以搜product_name和desc组合的字段内容了 转为一次请求 -->
    
    <field name="product_keywords" type="text_ik" indexed="true" stored="false" mulltiValued="true"/>
    
    <copyField source="product_name" dest="product_keywords"/>
    <copyField source="desc" dest="product_keywords"/>
    ```

    

### Solr 客户端

+ 增加

  + ```java
    @Test
    public void testSolrAdd() throws SolrServerException, IOException {
        // http://localhost:8080/solr/collection2   可以切换索引库进行存储
        SolrServer server = new HttpSolrServer("http://localhost:8080/solr");
        SolrInputDocument doc = new SolrInputDocument();
        doc.addField("id","haha");
        doc.addField("product_name","卫衣123");
        server.add(doc);
        UpdateResponse commit = server.commit();
        System.out.println(commit.getStatus());
    }
    ```

+ 删除

  + ```java
     @Test
       public void testSolrDelete() throws SolrServerException, IOException {
        SolrServer server = new HttpSolrServer("http://localhost:8080/solr");
        UpdateResponse deleteByQuery = server.deleteByQuery("id:haha",1000);
        System.out.println(deleteByQuery.getStatus());
       }
     ```

+ 查询

  + ```java
      @Test
      public void testSolrQuery() throws SolrServerException {
      	 SolrServer server = new HttpSolrServer("http://localhost:8080/solr");
      	 SolrQuery solrQuery = new SolrQuery();
      	 solrQuery.set("q","辣");
      	 solrQuery.setSort("product_price",ORDER.asc);
      	 solrQuery.setStart(0);
      	 solrQuery.setRows(3);
      	 solrQuery.set("df","desc");
      	 solrQuery.set("fl","id,desc,product_price");
      	 solrQuery.set("fq","product_price:[* TO 100]");
      	 solrQuery.setHighlight(true);
      	 solrQuery.addHighlightField("desc");
      	 solrQuery.setHighlightSimplePre("<span color='red'>");
      	 solrQuery.setHighlightSimplePost("</span>");
      	 QueryResponse query = server.query(solrQuery);
      	 SolrDocumentList results = query.getResults();
      	 long numFound = results.getNumFound();
      	 System.out.println(numFound);
      	 Map<String, Map<String, List<String>>> highlighting = query.getHighlighting();
      	 System.out.println(highlighting);
      	 for (SolrDocument doc : results) {
      		 System.out.println(doc.getFieldValue("id"));
      		 System.out.println(doc.getFieldValue("product_name"));
      		 System.out.println(doc.getFieldValue("product_catalog_name"));
      		 System.out.println(doc.getFieldValue("product_price"));
      		 System.out.println(doc.getFieldValue("desc"));
      		 System.out.println(highlighting);
      		 Map<String, List<String>> map = highlighting.get(doc.getFieldValue("id"));
      		 System.out.println(map);
      		 List<String> list = map.get("desc");
      		 System.out.println(list);
      	 }
      }
      ```
  