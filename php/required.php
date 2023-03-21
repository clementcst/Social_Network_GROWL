<?php
       if(file_exists("./php/constant.php")) {
              if(!defined('CONSTANTE_INCLUDED')) 
                     include_once("./php/constant.php"); 
              set_include_path(PHP);
       }
       if(!defined('CONSTANTE_INCLUDED')) 
              include_once("./constant.php");
       if(!defined('SESSION_INCLUDED'))  
              include_once(SESSION);      
       if(!defined('MISC_INCLUDED')) 
              include_once(MISC);
       if(!defined('DATABASE_INCLUDED')) 
              include_once(DATABASE);
?>