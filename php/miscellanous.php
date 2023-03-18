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
?>