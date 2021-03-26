<?php

namespace Text;

function truncate($string, $max_length = 30, $replacement = '', $trunc_at_space = false)
{
    $max_length -= strlen($replacement);
    $string_length = strlen($string);
    if($string_length <= $max_length)
        return $string;
    if( $trunc_at_space && ($space_position = strrpos($string, ' ', $max_length-$string_length)) )
        $max_length = $space_position;
    return substr_replace($string, $replacement, $max_length);
}
