<?php

function SYNTAX_sub_menu($template) {
    $template=trim(Syntax($template));
    if(mysql_num_rows(mysql_query("select * from pages where slave='$template' limit 2")))
        return '1';
}

