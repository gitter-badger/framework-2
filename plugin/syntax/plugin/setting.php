<?php

function SYNTAX_setting($template) {
    $template=trim(Syntax($template));
    return get_cache($template);
}