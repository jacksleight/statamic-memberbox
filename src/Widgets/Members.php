<?php

namespace JackSleight\StatamicMembers\Widgets;

use Statamic\Widgets\Widget;
use Statamic\Facades\User;
use Statamic\Facades\Scope;

class Members extends Widget
{
    public function html()
    {
        if (!User::current()->can('view members')) {
            return;
        }

        $sort = $this->config('sort') ?? 'email:asc';
        $exploded = explode(':', $sort);
        $sortColumn = $exploded[0];
        $sortDirection = $exploded[1] ?? 'asc';

        return view('statamic-members::cp.widgets.members', [
            'filters'       => Scope::filters('users'),
            'title'         => $this->config('title', __('Members')),
            'limit'         => $this->config('limit', 5),
            'create'        => $this->config('create', false),
            'paginate'      => $this->config('paginate', false),
            'sortColumn'    => $sortColumn,
            'sortDirection' => $sortDirection,
        ]);
    }
}
