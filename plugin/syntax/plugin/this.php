<?php
function SYNTAX_this($template) {
global $THIS__result_index;
$template=trim(Syntax($template));
return $THIS__result_index[$template];
}

