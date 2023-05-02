<?php

namespace JackSleight\StatamicMemberbox\Support;

class Util
{
    public static function methodDefined($ref, $method)
    {
        $class = (is_string($ref)) ? $ref : get_class($ref);

        return method_exists($class, $method) && ($class === (new \ReflectionMethod($class, $method))->getDeclaringClass()->name);
    }
}
