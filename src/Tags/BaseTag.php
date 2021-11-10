<?php

namespace JackSleight\StatamicMemberbox\Tags;

use Str;
use Statamic\Tags\Tags;
use Statamic\Tags\TagNotFoundException;

class BaseTag extends Tags
{
    protected static $handle = 'mb';

    protected $tagClasses = [
        'user'   => UserTags::class,
        'member' => MemberTags::class,
    ];

    public function wildcard(string $tag)
    {
        $tag = explode(':', $tag);

        $class = collect($this->tagClasses)
            ->map(function ($value, $key) {
                return [
                    'key'   => $key,
                    'value' => $value,
                ];
            })
            ->where('key', $tag[0])
            ->pluck('value')
            ->first();

        $method = isset($tag[1]) ? Str::camel($tag[1]) : 'index';

        if (! $class) {
            throw new TagNotFoundException("Tag [{$tag[0]}] could not be found.");
        }

        if (method_exists($class, $method)) {
            return (new $class($this))->{$method}();
        }

        if (method_exists($class, 'wildcard')) {
            return (new $class($this))->wildcard($method);
        }

        throw new TagNotFoundException("Tag [{$tag[0]}] could not be found.");
    }
}
