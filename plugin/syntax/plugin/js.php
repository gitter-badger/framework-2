<?php
//[js:"java script code here"end js]
function SYNTAX_js($template){
    $js=chk_var($template);    
    $js=CHNG_LANGUAGE(Syntax($js[0]));    
        $handle = fopen(SITE_PATH."cache/codejavascript".md5(QUERY_STRING), 'a');
        fwrite($handle,$js);
        fclose($handle);
       // echo (SITE_PATH."cache/codejavascript".md5(QUERY_STRING)."\n**************************************\n".$js."\n\n\n\n\n");
      //  return '';
}
