<?php
/* you can edit this values*/
ini_set('display_errors', '0'); // set 1 to show error , 0 to hide error
define('db_host', 'localhost'); // database host
define('db_name', 'dea150c_demo'); // db name
define('db_user', 'dea150c_demo'); // db user name
define('db_pass', 'demo123'); // db password
date_default_timezone_set('Asia/Amman'); // you can change it to your country from this page http://www.php.net/manual/en/timezones.php
define('SITE_LINK',  'http://'.$_SERVER['HTTP_HOST'].'/fw-demo/'); // your site make sure in the last add /


/*Dot edit any line after this comment! */
error_reporting(E_ERROR | E_WARNING | E_PARSE);

/***********************************/
unset($_SESSION['SYNTAX_DEBUG']);
unset ($_SESSION['SYNTAX_WORD']);
unset ($_SESSION['SYNTAX_VAR']);

$slashend= (substr($_SERVER['DOCUMENT_ROOT'], -1)!='/') ? '/' : '';
define('SITE_PATH',  __DIR__. $slashend);
define('TEMPLATE_PATH', 'template/');
define('UPLOADED_PATH', 'uploaded/');
define('CLASSES_PATH', 'classes/');
define('CACHE_PATH', 'cache/');
define('TMP_PATH', 'tmp/');
define('PLUGIN_PATH', 'plugin/');
define('IP_SITE', $_SERVER[SERVER_ADDR]);
define('Defualt_Language', 'en');
define('Version', '2.0');
define('_CONVERT_PATH', '/usr/local/bin/'); // for applicatio on linux

/*************connect to databese***********************/
$link = mysql_connect(db_host,db_user,db_pass)or die ('I cannot connect to the database because: ' . mysql_error());
$db_selected = mysql_select_db(db_name, $link);

/***************include Classes*****************/
$dir = SITE_PATH.CLASSES_PATH;
if ($dh = opendir($dir)) {
    while (($file = readdir($dh)) !== false) {
        if($file!='.' && $file!='..' && $file!='.svn' && filetype($dir . $file)!='dir'){
            //echo "$file:";
            include($dir.$file);
            //echo "$file<br>";
            } 
    }
    closedir($dh);
}