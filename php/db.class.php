<?php
/**
 * User: Mr.Chen
 * Date: 2018/8/25
 * Time: 19:33
 */
header("Content-Type:text/html;charset=utf-8");

/**
 * 分页
 */

 class db{
     private $host = "mysql:host=localhost;";
     private $database = "dbname=php";
     private $username = "root";
     private $password = "123456";
     private $pdo;
     private $isCommit; //是否开启事务

     public function __construct($commit=false){
         $this->pdo = new PDO("{$this->host}{$this->database}",$this->username,$this->password);
         $this->pdo->exec("set names utf8");
         $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
         $this->isCommit = $commit;
         if($this->isCommit){
             //开启事务
             $this->pdo->beginTransaction();
         }
     }
     //提交数据
     public function commit(){
         $this->pdo->commit();
     }
     //回滚
     public function rollback(){
         $this->pdo->rollBack();
     }

     private function setValue(PDOStatement $pdoStatement,$data = null){
         if($data!=null){
             for($i = 0 ; $i < count($data);$i++){
                 $pdoStatement->bindValue(($i+1),$data[$i],PDO::PARAM_INT);
             }
         }
     }
     //增删改
     public function insert($sql,$data=null){
          $smt = $this->pdo->prepare($sql);
          $this->setValue($smt,$data);
          $flag = $smt->execute();
          if($flag){
              return ["flag"=>$flag,"row"=>$smt->rowCount(),"lastid"=>$this->pdo->lastInsertId()];
          };
     }
     //查询多条
     public function query($sql,$data=null){
         $smt = $this->pdo->prepare($sql);
         $this->setValue($smt,$data);
         if($smt->execute()){
             return $smt->fetchAll();
         }else{
             echo "失败";
         };
     }

     //查询一条 获取数量
     public function count($sql,$isAssoc=false,$data=null)
     {
         $smt = $this->pdo->prepare($sql);
         $this->setValue($smt, $data);
         if ($smt->execute()) {
             if($isAssoc){
                 return $smt->fetch(PDO::FETCH_ASSOC);//返回字段名
             }else{
                 return $smt->fetch(PDO::FETCH_NUM);//返回索引
             }

         };
     }
 }


?>
