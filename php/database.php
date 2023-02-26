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
   
   function  mysqli_open() {
      $user = 'apache';
      $password = 'cible123';
      $db = 'social_network';
      $host = 'localhost';
      $port = 7077;
      $link = mysqli_connect($host, $user, $password, $db, $port);
      if (!$link) {
         $err = "Connection failed: " . mysqli_connect_error() ; 
         php_err($err);
      }
      return $link;
   }

   function db_columns(\mysqli $link, string $table_name) {
      $struct = array();
      $res = mysqli_query($link, 'DESCRIBE '.$table_name);   
      while($array_res = mysqli_fetch_array($res)) {
         array_push($struct, $array_res['Field']);
      }
      return $struct;
   }

   function db_structure(\mysqli $link) {
      return (
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
      ));
   }


   function db_newRow(string $table_name, array $item_content) {
      $link = mysqli_open();
      $tables_struct = db_structure($link);
      if(!in_array($table_name, array_keys($tables_struct)))
         php_err("table :" . $table_name . " is not recognize or doesn't exist in database");
      if(!array_equal(array_keys($item_content), db_columns($link, $table_name))) {
         $err = "Can't create new row in table :" . $table_name .
                "\\nWrong format :\\n" . json_encode(array_keys($item_content)) .
                "\\nExpected format :\\n" . json_encode(array_keys($tables_struct));
         php_err($err);
      }
      $sql = "INSERT INTO `".$table_name."` (";
      for($i = 0 ; $i < count($tables_struct[$table_name]) ; $i++) {
         $column_name = $tables_struct[$table_name][$i];
         if($i != count($tables_struct[$table_name]) - 1) 
            $sql .= "`".$column_name."` ,";
         else 
            $sql .= "`".$column_name."`) VALUES (";
      }
      for($i = 0 ; $i < count($item_content) ; $i++) {
         $value = $item_content[$tables_struct[$table_name][$i]];
         if($i != count($item_content) - 1)
            $sql .= "'".$value."' ,";
         else
            $sql .= "'".$value."')";
      }
      java_log($sql);
      $row_format = json_encode(array_values($item_content));
      if(mysqli_query($link, $sql)) {
         java_log("Row succesfully added in table " . $table_name . "\\nRow :\\n" . $row_format);
      } else {
         php_err("Cannot create row in table " . $table_name . "\\nRow :\\n" . $row_format);
      }
      mysqli_close($link);
   }

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
      $sql = "SELECT MAX(REPLACE(".$tables[$table][0].",'".$tables[$table][1]."','') + 1) FROM `".$table."`";
      $result = mysqli_query($link, $sql);
      mysqli_close($link);
      if(mysqli_num_rows($result) != 1) {
         php_err("can't genereate new id for :".$table);
         return "Na".$tables[$table][1];
      } else {
         $row = mysqli_fetch_array($result);
         return ($row[0] == NULL ? $tables[$table][1]."1" : $tables[$table][1].$row[0]); 
      }
      
   }

   function db_newUser(array $user) {
      $user = array_merge(
               $user, 
               array(
                'UserID' => db_generateId("user"),
                'IsAdmin' => '0',
                'Theme' => '0',
                'IsPremium' => '0'));
      db_newRow('user', $user);
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

      $user = array(
         'Username' => "Inspecteur",
         'Name' => "Gadget",
         'Firstname' => "ca va etre la joie",
         'Mail' => "houhou@",
         'Country' => "Au nom de la loi",
         'City' => "moi je vous arrete",
         'BirthDate' => "1999-01-02",
         'PhoneNumber' => "12",
         'Sex' => "1"
      );
     //db_newUser($user);
   

      $post = array(
         'NumberOfMedia' => "1",
         'Title' => "Yes",
         'Content' => "contenue",
         'PostedBy_UserID' => "U15"
      );
      db_newPost($post);
?>
