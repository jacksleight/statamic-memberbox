<?php

namespace JackSleight\StatamicMemberbox\Tags;

use JackSleight\StatamicMemberbox\Support\Util;
use Statamic\Support\Str;
use Statamic\Tags\TagNotFoundException;
use Statamic\Tags\Tags;

class BaseTag extends Tags
{
    protected static $handle = 'mb';

    protected $tagClasses = [
        'user'    => UserTags::class,
        'member'  => MemberTags::class,
        'members' => MembersTags::class,
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

        $tags = new $class();
        $tags->setProperties([
            'parser'     => $this->parser,
            'content'    => $this->content,
            'context'    => $this->context,
            'params'     => $this->params,
            'tag'        => $this->tag,
            'tag_method' => $this->method,
        ]);

        if (Util::methodDefined($tags, $method)) {
            return $tags->{$method}();
        }

        if (Util::methodDefined($tags, 'wildcard')) {
            return $tags->wildcard($method);
        }

        throw new TagNotFoundException("Tag [{$tag[0]}] could not be found.");
    }
}
