<?php
session_set_cookie_params(3600 * 24 * 7);
session_start();
include "conf.php";
define('YOUCANINCLUDE', 'Yes');


// request vars
foreach ($_REQUEST as $KEy => $VAl) {
    if (is_array($_REQUEST[$KEy])) {
        foreach ($_REQUEST[$KEy] as $KEy1 => $VAl1) {
            if (is_array($$KEy)) {
                $$KEy = array_merge($$KEy, array($KEy1 => filter_vars($VAl1)));
            } else {
                $$KEy = array($KEy1 => filter_vars($VAl1));
            }
        }
    } else {
        $$KEy = filter_vars($VAl);
    }
}

$TEMPLATE_link = TEMPLATE_PATH . 'urorbit/';

/* * *************include index.php plugin**************** */
$dir = PLUGIN_PATH;
if ($dh = opendir($dir)) {
    while (($file = readdir($dh)) !== false)
        if(filetype($dir . $file)=='dir'  && $file!='.svn' && strlen($file)>2)
            $file_plugin[]= $dir . $file;            
    closedir($dh);
}

if(is_array($file_plugin)) {
    sort($file_plugin);
    foreach($file_plugin as $kplugin){
        include($kplugin."/index.php");
}
}

/**********************************************************/
    if ($chng_tpl){
        $my_simple_tmplt = include_file_template($chng_tpl); // set template from url
    }else {
        $my_simple_tmplt = include_file_template('index');
    }


/* * *************include footer.php plugin**************** */
if (is_array($file_plugin))
    foreach ($file_plugin as $kplugin){
        if (file_exists(SITE_PATH .  $kplugin . "/footer.php")){
            include(SITE_PATH .  $kplugin . "/footer.php");
        }
    }
/* * *****************echo html code******************** */

$my_simple_tmplt = FUNCTION_AT_END($my_simple_tmplt);
echo str_replace($_SESSION['SYNTAX_VAR']['OLD'], $_SESSION['SYNTAX_VAR']['NEW'], $my_simple_tmplt);
?>