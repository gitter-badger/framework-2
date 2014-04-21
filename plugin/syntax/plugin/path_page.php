<?php
$_SESSION[SYNTAX_WORD][]="show_msg";
$_SESSION[SYNTAX_WORD][]="Get_exe_icon";

function SYNTAX_Get_exe_icon($template) {
$template = Syntax($template);
$exe=end(explode('.', $template));
if(!file_exists(SITE_PATH.TEMPLATE_PATH.'urorbit/images/icons/'.$exe.'.gif')) $exe='default';
return "<img src='/template/urorbit/images/icons/$exe.gif' title='attachment $template file'>";
}


function SYNTAX_show_msg($template) {
    global $SHOW_MSG;
    $SQL_x = chk_var($template);  
     $SQL_x[1] = trim(Syntax($SQL_x[1]));
     
    if($SHOW_MSG[$SQL_x[0]])
        return '<li><a id="show_msg" class="'.$SHOW_MSG[$SQL_x[0].'_status'].'" href="#">'.$SHOW_MSG[$SQL_x[0]].'</a></li>';
}

function SYNTAX_path_page($template) {
    $template = trim(Syntax($template));
    if ($template == 'O') {
        if ((sett_site('home_page') != $_GET[id]) && (get_root_page_id($_GET[id]) != sett_site('home_page')))
            $admin_page_text = "<a href='/'>" . getnamepage(sett_site('home_page')) . "</a> &#9658; ";  // for rtl &#9668;
        $epath = (get_root_page($_GET[id]));
        foreach ($epath as $kepath) {
            if ($kepath[id])
                $admin_page_text.= "<a href='/?id=$kepath[id]'>$kepath[page_name]</a> &#9658; ";
        }
    }else {
        $path_page = get_root_page($template);
        if ($template)
            $path_page[] = @end(getResults("Select id,page_name From pages where id='$template'"), MYSQL_NUM);
        foreach ($path_page as $path_page_v) {
            $admin_page_text.="<a href='?chng_tpl=system_setting&plgn=pages&p=page&show_sub=$path_page_v[id]'>$path_page_v[page_name]</a> &gt;  ";
        }
    }
    return $admin_page_text;
}