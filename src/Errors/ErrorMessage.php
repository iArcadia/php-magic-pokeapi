<?php

namespace iArcadia\MagicPokeAPI\Errors;

class ErrorMessage
{
    public static function TypeError(int $argPos, string $expected)
    {
        $function = debug_backtrace()[1]['function'];
        $class = debug_backtrace()[1]['class'];
        $type = debug_backtrace()[1]['type'];
        $argType = gettype(debug_backtrace()[1]['args'][$argPos - 1]);
        
        $message = "Argument {$argPos} passed to {$class}{$type}{$function}() must be of the type {$expected}, {$argType} given,";
        
        return $message;
    }
}