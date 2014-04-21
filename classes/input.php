<?php
//write js code in other file , in z-compress footer plugin you can add any code from php index plugin by this var $js_NOTcompression_code use . $js_NOTcompression_code.='';
function write_JScode($code) {    
    $filejavascript = SITE_PATH . "cache/codejavascript" . md5(QUERY_STRING);     
    $handle = fopen($filejavascript, 'a');
    fwrite($handle, CHNG_LANGUAGE($code));
    fclose($handle);
    return true;
}
