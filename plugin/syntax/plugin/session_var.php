<?php
$_SESSION[SYNTAX_WORD][]="var";
$_SESSION[SYNTAX_WORD][]="array";
$_SESSION[SYNTAX_WORD][]="session_array";
$_SESSION[SYNTAX_WORD][]="help";
$_SESSION[SYNTAX_WORD][]="MSG";

function SYNTAX_help($template) {
    return '<span rel="'.$template.'" class="showtooltip" style="cursor:pointer;">
		<img border="0" src="/template/input/css/ui-theme/images/tooltip.gif"></span>';
}
function SYNTAX_MSG($template) {
    global $_MSG;
    $SQL_x=chk_var($template);
    if($_MSG==$SQL_x[0])
        return '
<div class="ui-widget">
	<div style="padding: 0 .7em;" class="ui-state-error ui-corner-all">
		<p><span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-'.$SQL_x[1].'"></span>
		<strong>'.$SQL_x[2].':</strong> '.$SQL_x[3].'</p>
	</div>
</div>
';      
}

function SYNTAX_session_var($template) {
    $template=trim(Syntax($template));
    $SQL_x=chk_var($template);
    if($_SESSION[$SQL_x[0]])
        return $_SESSION[$SQL_x[0]];
}
function SYNTAX_var($template) {
    $template=trim(Syntax($template));
    if(isset($_REQUEST[$template]))
        return $_REQUEST[$template];

    global $$template;
    return $$template;
}
function SYNTAX_array($template) {
    $template=trim(Syntax($template));
    $SQL_x=chk_var($template);
    global $$SQL_x[0];
    $ary=&$$SQL_x[0];
    return $ary[$SQL_x[1]];
}
function SYNTAX_session_array($template) {
    $template=trim(Syntax($template));
    $SQL_x=chk_var($template);
    return $_SESSION[$SQL_x[0]][$SQL_x[1]];
}
?>