<?php

namespace JackSleight\StatamicMemberbox\Widgets;

use Statamic\Facades\Scope;
use Statamic\Facades\User;
use Statamic\Widgets\Widget;

class Members extends Widget
{
    protected static $handle = 'mb_members';

    public function html()
    {
        if (! User::current()->can('mb view members')) {
            return;
        }

        $sort = $this->config('sort') ?? 'email:asc';
        $exploded = explode(':', $sort);
        $sortColumn = $exploded[0];
        $sortDirection = $exploded[1] ?? 'asc';

        return view('statamic-memberbox::cp.widgets.members', [
            'filters' => Scope::filters('users'),
            'title' => $this->config('title', __('Members')),
            'limit' => $this->config('limit', 5),
            'create' => $this->config('create', true),
            'paginate' => $this->config('paginate', true),
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
        ]);
    }
}
