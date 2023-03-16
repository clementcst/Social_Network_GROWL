<?php 
   function java_log(string $log) {
      $log = str_replace("'", '"', $log);
      ?> 
         <script>
            console.log('<?=$log?>');
         </script>
      <?php
   }

   function php_err(string $err) {
      $_SESSION["php_error_log"] = $err;
      java_log($err);
      die($err);
   }

   function array_equal($a, $b) {
      return (
         is_array($a) 
         && is_array($b) 
         && count($a) == count($b) 
         && array_diff($a, $b) === array_diff($b, $a)
      );
   }


/**
   ┌──────────────────────────────────────────────────────────────────────────┐
   │                     Functions for mysql Database                         │
   └──────────────────────────────────────────────────────────────────────────┘
**/
/** 
   @return \mysqli > for mysqli fcts 
   @summary > connection to the database
**/
   function  mysqli_open() {
      $link = mysqli_connect(
         'localhost', 
         'apache', 
         'cible123', 
         'social_network', 
         3308 
      );
      if (!$link) {
         $err = "Connection failed: ".mysqli_connect_error() ; 
         php_err($err);
      }
      return $link;
   }

/**
   @return array > table column names
   @summary retrieves the table structure
**/
   function db_columns(\mysqli $link, string $table_name) {
      $struct = array();
      $res = mysqli_query($link, 'DESCRIBE '.$table_name);   
      while($array_res = mysqli_fetch_array($res)) {
         array_push($struct, $array_res['Field']);
      }
      return $struct;
   }

/**
   @return array[][] > associative array
   @return keys > table names
   @return values > array \w table column names
   @summary > retrieves the database structure
**/
   function db_structure(\mysqli $link) {
      $tables = mysqli_fetch_all(mysqli_query($link, "SHOW TABLES;"));
      $struct = array();
      for($i = 0 ; $i < count($tables); $i++) {
         $struct = array_merge($struct, [$tables[$i][0] => db_columns($link, $tables[$i][0])]);
      }
      return $struct;
   }

/**
   @summary > check if a table exist in the db
**/
   function db_tableExist(string $table_name, \mysqli $link) {
      if(!in_array($table_name, array_keys(db_structure($link))))
         php_err("table :".$table_name." is not recognize or doesn't exist in database");
   }

/**
   @summary > genere a new id for a table
**/
  function db_generateId(string $table) {
      $link = mysqli_open();
      $tables = array(         
         "user" => array("UserID", "U"),
         "post" => array("PostID", "P"),
         "comment" => array("CommentID", "CM"),
         "answer" => array("AnswerID", "A"),
         "media" => array("MediaID", "M"),
         "conversation" => array("ConversationID", "CV")
      );
      $sql = "SELECT MAX(REPLACE(".
            $tables[$table][0].",'".
            $tables[$table][1]."','') + 1)".
            " FROM `".$table."`";
      $result = mysqli_query($link, $sql);
      mysqli_close($link);
      if(mysqli_num_rows($result) != 1) {
         php_err("can't generate new id for table:".$table);
         return "Na".$tables[$table][1];
      } else {
         $row = mysqli_fetch_array($result);
         return ($row[0] == NULL ? $tables[$table][1]."1" : $tables[$table][1].$row[0]); 
      }
   }

   
   /**
      @param array[][] $filters > associative array of array of string / null
         | key : column to which applies the filter
         | array[0] : operator (=, <>, LIKE, ...) 
         | array[1] : filter param 
         | array[2] : Operator Beetween this filter and the next one 
          (NONE = 0, AND = 1, OR = 2 [last filter must have 0])
      @return string > WHERE statement part according to $filter param
   **/
   function db_filterStmt(\mysqli $link, string $table_name, array $filters) {
      $sql = " WHERE ";
      $table_struct = db_columns($link, $table_name);
      foreach($filters as $filteredColumn => $filterParam) {
         if(count($filterParam) <> 3 || !in_array($filterParam[2], [0, 1, 2]))
            php_err("parametre filters is incorrect in select statement");
         if(!in_array($filteredColumn, $table_struct)) {
            php_err("can't filter on column ".$filteredColumn.
            "column doesn't exist in table ".$table_name);
         }
         $sql .= $filteredColumn." ".$filterParam[0]." ".$filterParam[1]." ";
         switch ($filterParam[2]) {
            case 0 : $sql .= " "; break;
            case 1 : $sql .= "AND "; break;
            case 2 : $sql .= "OR "; break;
         }
      }
      return $sql;
   }

   /**
      @param string $group_by > column name 
      @return string > GROUP BY statement part according to $groupBy param
   **/
   function db_groupByStmt(\mysqli $link, string $table_name, string $group_by) {
      $sql = " GROUP BY ";
      if(!in_array($group_by, db_columns($link, $table_name))) {
         php_err("can't group by using the column ".$group_by.
         ", it doesn't exist in table ".$table_name);
      } 
      return $sql;
   }

   /**
      @param string[] $order_by > array of string : columns
      @return string > ORDER BY statement part according to $groupBy param
   **/
   function db_orderByStmt(\mysqli $link, string $table_name, array $order_by) {
      $sql = " ORDER BY ";
      $table_struct = db_columns($link, $table_name);
      for($i = 0; $i < count($order_by); $i++ ) {
         if(!in_array($order_by[$i], $table_struct)) {
            php_err("can't order by using the column ".$order_by[$i].
            ", it doesn't exist in table ".$table_name);
         }
         $sql .= $order_by[$i] ;
         $sql .= ($i <> count($order_by)-1)? ', ' : ' ';
      }
      return $sql;
   }

   /**
      @param array $columns > array of the column names you want to retrieve
      @param array[][] $filters > check db_filterStmnt dox
      @param $group_by > check db_orderByStmt
      @summary > retrieve specified columns (filtered or not) of a table in the db
      @return > array of row.s selected by the statement 
   **/
  function db_selectColumns(string $table_name, array $columns, 
                           ?array $filters = null, 
                           ?string $prefix = null,
                           ?string $suffix = null, 
                           ?array $order_by = null,
                           ?string $group_by = null) {
      $link = mysqli_open();
      db_tableExist($table_name, $link);
      $table_struct = db_columns($link ,$table_name);
      if(in_array($columns, [['*'], ["*"]]))
         $columns = $table_struct;
      $sql = "SELECT ";
      if($prefix <> null) 
         $sql .= $prefix." ";
      for($i = 0 ; $i < count($columns) ; $i++) {
         if(!in_array($columns[$i], $table_struct))
            php_err("column ".$columns[$i]." is not recognized in table ".$table_name);
         if($i < count($columns) - 1)
            $sql .= $columns[$i].", ";
      }
      $sql .= $columns[$i-1]." FROM ".$table_name;
      if($filters <> null)
         $sql .= db_filterStmt($link, $table_name, $filters);
      if($group_by <> null)
         $sql .= db_groupByStmt($link, $table_name, $group_by);
      if($order_by <> null)
         $sql .= db_orderByStmt($link, $table_name, $order_by);
      if($suffix <> null) 
         $sql .= $suffix." ";
      $result = mysqli_query($link, $sql.';');
      if(!$result)
         php_err("error while trying select statement :\\n".$sql);
      return mysqli_fetch_all($result);      
   }

   /**
      @param array[][] $new_content > associative array
      @param $new_content keys > column names of the target table u wanna update
      @param $new_content values > correspoding value u want in the column
      @param array[][] $filters > check db_filterStmnt dox
      @summary > retrieve specified columns (filtered or not) of a table in the db
      @return > true  
   **/
  function db_updateColumns(string $table_name, array $new_content, ?array $filters = null) {
      $link = mysqli_open();
      db_tableExist($table_name, $link);
      $table_struct = db_columns($link ,$table_name);
      $sql = "UPDATE $table_name SET ";   
      for($i = 0 ; $i < count($new_content) ; $i++) {
         $column = array_keys($new_content)[$i];
         if(!in_array($column, $table_struct))
            php_err("column ".$column." is not recognized in table ".$table_name);
         $sql .= $column." = '".$new_content[$column];
         $sql .= ($i < count($new_content) - 1)? "', " : "' ";
      }
      if($filters <> null)
         $sql .= db_filterStmt($link, $table_name, $filters);
      java_log($sql);
      $result = mysqli_query($link, $sql.';');
      java_log(json_encode($result));
      if(!$result)
         php_err("error while trying update statement :\\n".$sql);
      else
         java_log("Row succesfully updated in table ".$table_name);
      return $result;      
   }
    /**
      @summary > allows you to know if a value belongs to a table, on a specific column
      @return > bool
   **/
   function db_alreadyExist(string $table_name, string $column, $value) {
      $link = mysqli_open();
      db_tableExist($table_name, $link);
      if(!in_array($column, db_columns($link, $table_name)))
         php_err("column ".$column." is not recognized in table ".$table_name);
      $filter = array( $column => array("LIKE", $value, "0"));
      $result = db_selectColumns($table_name, [$column], $filter);
      return (count($result) != 0);
   }

    /**
      @param array[][] $item_content > associative array
      @param $item_content keys > column names of target table
      @param $item_content values > correspoding value u want in the column
      @summary > insert a row in a table
   **/
  function db_newRow(string $table_name, array $item_content) {
      $link = mysqli_open();
      db_tableExist($table_name, $link);
      $table_struct = db_columns($link, $table_name);   
      for($i = 0 ; $i < count($item_content) ; $i++) {
         $column = array_keys($item_content)[$i];
         if(!in_array($column, $table_struct))
            php_err("error while trying select statement :".
            "\\ncolumn ".$column." is not recognized in table ".$table_name);
      }
      $table_struct = array_keys($item_content);
      $sql = "INSERT INTO `".$table_name."` (";
      for($i = 0 ; $i < count($table_struct) - 1 ; $i++) {
         $column_name = $table_struct[$i];
         $sql .= "`".$column_name."` ,";
      } 
      $sql .= "`".$table_struct[$i]."`) VALUES (";
      for($i = 0 ; $i < count($item_content) - 1 ; $i++) {
         $value = $item_content[$table_struct[$i]];
         $sql .= "'".$value."' ,";
      }
      $sql .= "'".$item_content[$table_struct[$i]]."')";
      $row = json_encode(array_values($item_content));
      java_log($sql);
      if(mysqli_query($link, $sql)) {
         java_log("Row succesfully added in table ".$table_name."\\nRow :\\n".$row);
      } else {
         php_err("Cannot create row in table ".$table_name."\\nRow :\\n".$row);
      }
      mysqli_close($link);
   }

   /**
     ┌──────────────────────────────────────────────────────────────────────────┐
     │                   specific fcts for our database                         │
     └──────────────────────────────────────────────────────────────────────────┘
   **/
   function db_newUser(array $user, string $encr_pwd) {
      if(db_alreadyExist('user', 'Mail', "'".$user['Mail']."'"))
         return 'mail'; //mail already exist
      elseif(db_alreadyExist('user', 'Username', "'".$user['Username']."'"))
         return 'userName'; //username already exist
      $id = db_generateId("user");
      $user = array_merge(
         $user, 
         array('UserID' => $id));
      db_newRow('user', $user);
      $pwd = array(
         'UserID' => $id,
         'EncrPwd' => $encr_pwd);
      db_newRow('password', $pwd);
      return 1;
   }

   function db_newPost(array $post) {
      $post = array_merge(
               $post, 
               array(
                'PostID' => db_generateId("post"),
                'Posted_DateTime' => date("Y-m-d"),
                'NumberOfLikes' => '0',
                'NumberOfShares' => '0'));
      db_newRow('post', $post); 
   }

   function db_getUserData(string $user_id) {
      if(!db_alreadyExist('user','UserID',"'".$user_id."'"))
         php_err("User with ID: ".$user_id." doesn't exist in database");
      return (
      db_selectColumns(
         table_name:'user',
         columns:['Username','Name','Firstname','Mail',
                  'Country','City','BirthDate','PhoneNumber',
                  'Sex','ProfilConfidentiality','PostConfidentiality','Theme'], 
         filters:['UserID' => ['LIKE', '"'.$user_id.'"','0']], 
         suffix:"LIMIT 1")[0]);
   }
?>



