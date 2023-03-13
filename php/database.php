<?php 
   /**
     ┌──────────────────────────────────────────────────────────────────────────┐
     │              Read and Write functions in mysql Database                  │
     └──────────────────────────────────────────────────────────────────────────┘
   **/

   function java_log(string $log) {
      $log = str_replace("'", '"', $log);
      ?> 
         <script>
            console.log('<?=$log?>');
         </script>
      <?php
   }

   function php_err(string $err) {
      $_SESSION["error_log"] = $err;
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
      return 
      array(
         'user' => db_columns($link, 'user'),
         'post' => db_columns($link, 'post'), 
         'comment' => db_columns($link, 'comment'), 
         'answer' => db_columns($link, 'answer'),  
         'media' => db_columns($link, 'media'), 
         'own_media' => db_columns($link, 'own_media'), 
         'conversation' => db_columns($link, 'conversation'), 
         'shared_post' => db_columns($link, 'shared_post'), 
         'liked_post' => db_columns($link, 'liked_post'), 
         'friends' => db_columns($link, 'friends'), 
         'password' => db_columns($link, 'password')
      );
   }

   function db_tableExist(string $table_name, \mysqli $link) {
      if(!in_array($table_name, array_keys(db_structure($link))))
         php_err("table :".$table_name." is not recognize or doesn't exist in database");
   }

   /**
      @param array[][] $item_content > associative array
      @param $item_content keys > column names of target table
      @param $item_content values > correspoding value u want in the column
      @summary > insert a row in a table
   **/
   function db_newRow(string $table_name, array $item_content) {
      $link = mysqli_open();
      $tables_struct = db_structure($link);
      if(!in_array($table_name, array_keys($tables_struct)))
         php_err("table :".$table_name." is not recognize or doesn't exist in database");
      if(!array_equal(array_keys($item_content), db_columns($link, $table_name))) {
         $err = "Can't create new row in table :".$table_name.
                "\\nWrong format :\\n".json_encode(array_keys($item_content)).
                "\\nExpected format :\\n".json_encode(array_keys($tables_struct));
         php_err($err);
      }
      $sql = "INSERT INTO `".$table_name."` (";
      for($i = 0 ; $i < count($tables_struct[$table_name]) - 1 ; $i++) {
         $column_name = $tables_struct[$table_name][$i];
         $sql .= "`".$column_name."` ,";
      }
      $sql .= "`".$tables_struct[$table_name][$i]."`) VALUES (";
      for($i = 0 ; $i < count($item_content) - 1 ; $i++) {
         $value = $item_content[$tables_struct[$table_name][$i]];
         $sql .= "'".$value."' ,";
      }
      $sql .= "'".$item_content[$tables_struct[$table_name][$i]]."')";
      //java_log($sql);
      $row_format = json_encode(array_values($item_content));
      if(mysqli_query($link, $sql)) {
         java_log("Row succesfully added in table ".$table_name."\\nRow :\\n".$row_format);
      } else {
         php_err("Cannot create row in table ".$table_name."\\nRow :\\n".$row_format);
      }
      mysqli_close($link);
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
      @param array $columns > array of the column names you want to retrieve
      @param array[][] $filters > associative array of array of string / null
         | key : column to which applies the filter
         | array[0] : operator (=, <>, LIKE, ...) 
         | array[1] : filter param 
         | array[2] : Operator Beetween this filter and the next one 
          (NONE = 0, AND = 1, OR = 2 [last filter must have 0])
      @summary > retrieve specified columns (filtered or not) of a table in the db
      @return > array of row.s selected by the statement 
   **/
  function db_selectColumns(string $table_name, array $columns, ?array $filters = null) {
      $link = mysqli_open();
      db_tableExist($table_name, $link);
      $table_struct = db_columns($link ,$table_name);
      if(in_array($columns, [['*'], ["*"]]))
         $columns = $table_struct;
      $sql = "SELECT ";
      for($i = 0 ; $i < count($columns) ; $i++) {
         if(!in_array($columns[$i], $table_struct))
            php_err("column ".$columns[$i]." is not recognized in table ".$table_name);
         if($i < count($columns) - 1)
            $sql .= $columns[$i].", ";
      }
      $sql .= $columns[$i-1]." FROM ".$table_name;
      if($filters <> null) {
         $sql .= " WHERE ";
         foreach($filters as $filteredColumn => $filterParam) {
            if(count($filterParam) <> 3 || !in_array($filterParam[2], [0, 1, 2]))
               php_err("parametre filters is incorrect in select statement");
            if(!in_array($filteredColumn, $table_struct)) {
               php_err("can't filter on column ".$filteredColumn.
               "column doesn't exist in table ".$table_name);
            }
            $sql .= $filteredColumn." ".$filterParam[0]." ".$filterParam[1]." ";
            switch ($filterParam[2]) {
               case 0 : $sql .= ";"; break;
               case 1 : $sql .= "AND "; break;
               case 2 : $sql .= "OR "; break;
            }
         }
      }
      $result = mysqli_query($link, $sql);
      if(!$result)
         php_err("error while trying select statement :\\n".$sql);
      return mysqli_fetch_all($result);      
   }

   function db_alreadyExist(string $table_name, string $column, $value) {
      $link = mysqli_open();
      db_tableExist($table_name, $link);
      if(!in_array($column, db_columns($link, $table_name)))
         php_err("column ".$column." is not recognized in table ".$table_name);
      $filter = array( $column => array("LIKE", $value, "0"));
      $result = db_selectColumns($table_name, [$column], $filter);
      return (count($result) != 0);
   }

   function db_newUser(array $user, string $encr_pwd) {
      if(db_alreadyExist('user', 'Mail', "'".$user['Mail']."'"))
         return 'mail'; //mail already exist
      elseif(db_alreadyExist('user', 'Username', "'".$user['Username']."'"))
         return 'userName'; //username already exist
      $id = db_generateId("user");
      $user = 
      array_merge($user, 
         array(
            'UserID' => $id,
            'IsAdmin' => '0',
            'Theme' => '0',
            'IsPremium' => '0'));
      db_newRow('user', $user);
      $pwd = 
      array('UserID' => $id,
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
?>