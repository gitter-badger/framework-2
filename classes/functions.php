<?php
function createPath($path) {
    if (is_dir($path)) return true;
    $prev_path = substr($path, 0, strrpos($path, '/', -2) + 1 );
    $return = createPath($prev_path);
    return ($return && is_writable($prev_path)) ? mkdir($path) : false;
}
function filewrite($file, $content) {
    @unlink($file);
    $fp = fopen($file, 'w');
    if (flock($fp, LOCK_EX | LOCK_NB)) {
        fwrite($fp, $content);
        fflush($fp);
        flock($fp, LOCK_UN);
    }
    fclose($fp);
}

// var check
function filter_vars($var, $i = 1) {
    $search = array('%', '[', ']');
    $replace = array('&#37;', '&#91;', '&#93;');
    $var = str_replace($search, $replace, $var);
    if ($i) {
        $var = htmlspecialchars(strip_tags(@addslashes($var)));
    }
    return $var;
}


function filter_output($var) {
    $search = array('&#37;', '&#91;', '&#93;', '&amp;#37;', '&amp;#91;', '&amp;#93;');
    $replace = array('%', '[', ']', '%', '[', ']');
    $var = str_replace($search, $replace, $var);
    $var = stripslashes($var);
    return $var;
}

//get setting for any title from list setting
function sett_site($word, $field = 2, $ad = 0) {
    $row = get_cache($word);
    if ($ad) {
        set_cache($word, $field, 155520000);
        return '';
    }else
        return $row;
}



/* Translate function */
function CHNG_LANGUAGE($text_TR) {
    $lin_rpl_frm[] = "\n";
    $lin_rpl_frm[] = "\r";
    $_LANGUAGE_X = array();
    $dir = SITE_PATH . PLUGIN_PATH;
    $tmp_lang = SITE_PATH . TMP_PATH . 'LANGUAGE_' . $_SESSION['lng_CH'] . '.txt';
    if (!file_exists($tmp_lang)) {
        if ($handler = opendir($dir)) {
            while (($sub = readdir($handler)) !== FALSE)
                if ($sub != "." && $sub != ".." && $sub != '.svn')
                    if (file_exists($dir . $sub . "/lang/" . $_SESSION['lng_CH']))
                        $_LANGUAGE_X.= "\n".file_get_contents($dir . $sub . "/lang/" . $_SESSION['lng_CH']);
            closedir($handler);
        }
        $handle = fopen($tmp_lang, 'a');
        fwrite($handle, $_LANGUAGE_X);
        fclose($handle);
    }
    $_LANGUAGE_X = file($tmp_lang);
    foreach ($_LANGUAGE_X as $_LANGUAGE_V) {
        $_LANGUAGE_K = explode("=", $_LANGUAGE_V);
        $text_TR = str_replace('[' . $_LANGUAGE_K[0] . ']', str_replace($lin_rpl_frm, '', $_LANGUAGE_K[1]), $text_TR);
    }
    return $text_TR;
}

/* * **********Download any  file**************** */

function downloadFile($fullPath) {
    // Must be fresh start
    if (headers_sent())
        die('Headers Sent');

    // Required for some browsers
    if (ini_get('zlib.output_compression'))
        ini_set('zlib.output_compression', 'Off');

    // File Exists?
    if (file_exists(SITE_PATH . $fullPath)) {

        // Parse Info / Get Extension
        $fsize = filesize(SITE_PATH . $fullPath);
        $path_parts = pathinfo(SITE_PATH . $fullPath);
        $ext = strtolower($path_parts["extension"]);

        // Determine Content Type
        switch ($ext) {
            case "pdf": $ctype = "application/pdf";
                break;
            case "exe": $ctype = "application/octet-stream";
                break;
            case "zip": $ctype = "application/zip";
                break;
            case "doc": $ctype = "application/msword";
                break;
            case "xls": $ctype = "application/vnd.ms-excel";
                break;
            case "ppt": $ctype = "application/vnd.ms-powerpoint";
                break;
            case "gif": $ctype = "image/gif";
                break;
            case "png": $ctype = "image/png";
                break;
            case "jpeg":
            case "jpg": $ctype = "image/jpg";
                break;
            default: $ctype = "application/force-download";
        }

        header("Pragma: public"); // required
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private", false); // required for certain browsers
        header("Content-Type: $ctype");
        header("Content-Disposition: attachment; filename=\"" . basename($fullPath) . "\";");
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: " . $fsize);
        ob_clean();
        flush();
        readfile(SITE_PATH . $fullPath);
    } else
        die('File Not Found: '.SITE_PATH . $fullPath);
}

/* * *************include templates**************** */
function include_file_template($template_name) {
    $p = TEMPLATE_PATH . 'urorbit' . DIRECTORY_SEPARATOR;
    if (end(explode('.', $template_name)) != 'inc')
        $template_name = $template_name . '.inc';
    if (file_exists($p . $template_name)) {
        return implode(file($p . $template_name), '');
    }
}


function set_cache($var, $val, $time = 86400) {
    $x = @end(getResults("select string1 from table3 where string1='$var' and `md5`='SETTING'"));
    if (!$x[string1]) {
        mysql_query("INSERT INTO table3 SET  `string1`='$var' ,`string2`='$val' ,`string3`='" . time() . "' ,`string4`='$time' ,`md5`='SETTING'");
    } else {
        mysql_query("UPDATE table3 SET  `string2`='$val' ,`string3`='" . time() . "' ,`string4`='$time' where `string1`='$var' and `md5`='SETTING'");
    }
}

function get_cache($var) {
    $x = @end(getResults("select string1,string2 from table3 where string1='$var' and `md5`='SETTING'"));
    if ($x[string1]) {
        return $x[string2];
    }
    return false;
}

/* Convert bite to any unit */
function convert_mb($size) {
    $unit = array('b', 'kb', 'mb', 'gb', 'tb', 'pb');
    return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
}

//*************** this functions run in index page
// on the last :
function FUNCTION_AT_END($t) {
    $t = Syntax_cache($t);
    return $t;
}
