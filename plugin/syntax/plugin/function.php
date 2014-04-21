<?php

function SYNTAX_function($template) {
    $template = trim(Syntax($template));
    if ($template) {
        eval('$value=' . $template . ';');
    }
    return $value;
}
