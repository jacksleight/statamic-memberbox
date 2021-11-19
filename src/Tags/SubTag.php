<?php

namespace JackSleight\StatamicMemberbox\Tags;

use Statamic\Tags\Tags;

class SubTag extends Tags
{
    public function __construct(BaseTag $passed)
    {
        $this->content = $passed->content;
        $this->context = $passed->context;
        $this->params = $passed->params;
        $this->tag = $passed->tag;
        $this->method = $passed->method;
        $this->parser = $passed->parser;
    }
}
