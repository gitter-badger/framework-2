<?php
//[css:"style","content"end css]

function SYNTAX_css($template) {
    $css=chk_var($template);
    foreach($css as $k=>$v) {
        if($k>0) {
            $content_search[]='{content'.$k.'}';
            $content_replace[]= $v;
            $file.='<div style="color:#333"><b>This style Not Found</b><br>'.'{content'.$k.'}'.'</div>';

        }
    }
    if(file_exists(TEMPLATE_PATH.'css_'.$css[0].'.inc')) $file=implode(file(TEMPLATE_PATH.'css_'.$css[0].'.inc'));
    return  str_replace($content_search, $content_replace, $file ) ;
}
