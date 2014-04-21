<?php

function setcachefile($u,$x=0) {
   // echo "$u,$x <br>\n\r";
    if ($_SESSION['USER_ID'] || $x) {
        return implode(file($u));
    }
    foreach($_GET as $gk => $gv) $ox.="$gk=$gv;";
    $cachefile = SITE_PATH . 'cache/cachefile_' . md5($u.$ox);
    $cachetime=$_SESSION['cachetime'];    
    if (file_exists($cachefile) && (time() - $cachetime < filemtime($cachefile))) {
        return implode(file($cachefile), '');
    } else {
        @unlink($cachefile);
        $fp = fopen($cachefile, 'w');
        fwrite($fp, Syntax(implode(file($u))));
        fclose($fp);
        return setcachefile($u,$x);
    }
}

function SYNTAX_include($template) {
    global $var_include;
    $include_x = chk_var($template);
    $template = trim(Syntax($include_x[0]));
    if (strpos($template, '/') === false)
        $template = 'template/urorbit/' . $template;
    $template_a = explode('?', $template);
    if (file_exists($template_a[0]) && !is_dir($template_a[0])) {
        $vars = explode('&', $template_a[1]);
        foreach ($vars as $var) {
            $setvars = explode('=', $var);
            $var_include[$setvars[0]] = $setvars[1];
        }
       // return implode(file($template_a[0]));        
        return setcachefile($template_a[0],$include_x[1]);
    }else
        $_SESSION['SYNTAX_DEBUG'][] = 'Function: SYNTAX_include <br> Error: File ' . $template . ' Not found!<hr>';
}

