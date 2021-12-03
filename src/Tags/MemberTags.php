<?php

namespace JackSleight\StatamicMemberbox\Tags;

use JackSleight\StatamicMemberbox\Facades\Member;
use Statamic\Auth\UserTags;
use Statamic\Tags\Tags;
use Statamic\View\Antlers\AntlersString;

class MemberTags extends Tags
{
    public function index()
    {
        $user = $this->delegateToStatamic('index');
        if ($user instanceof AntlersString) {
            return $user;
        }

        if (! Member::verify($user)) {
            return $this->parseNoResults();
        }

        return $user;
    }

    protected function delegateToStatamic($method)
    {
        $tags = new UserTags();
        $tags->setProperties([
            'parser'     => $this->parser,
            'content'    => $this->content,
            'context'    => $this->context,
            'params'     => $this->params,
            'tag'        => $this->tag,
            'tag_method' => $this->method,
        ]);

        return $tags->{$method}();
    }
}
