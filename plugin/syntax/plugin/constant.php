<?php
function SYNTAX_constant($template) {
    $template=trim(Syntax($template));

    if (defined($template)) eval('$x1='.$template.';');
    return $x1;
}
