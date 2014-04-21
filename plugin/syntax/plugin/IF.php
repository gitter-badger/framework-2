<?php
function SYNTAX_IF($template) {
    $IF=chk_var($template,'[ELSE]');
    $IF[0]=Syntax($IF[0]);
    $ifelse=explode("[[[__[ELSE]__]]]",$IF[1]);
    if( preg_match('/^.*[\=|\!].*$/',$IF[0])) { // "bassam=me" or "bassam!ali"
        $tmp_if=explode("=",$IF[0] );
        $nit=0;
        if(!$tmp_if[1]) { $nit=1; unset($tmp_if); $tmp_if=explode("!",$IF[0]); }
        $var_k= Syntax($tmp_if[0]);
        $var_v= Syntax($tmp_if[1]);
    }else {
        $var_k= Syntax($IF[0]);
        $nit=2;
    }
    if($nit==0) {
        if($var_k==$var_v) {
            $result=$ifelse[0];
        }else {
            $result=$ifelse[1];
        }
    }elseif($nit==1) {
        if($var_k!=$var_v) {
            $result=$ifelse[0];
        }else {
            $result=$ifelse[1];
        }
    }else {
        if($var_k) {
            $result=$ifelse[0];
        }else {
            $result=$ifelse[1];
        }
    }
    return $result;
}

