<div class="card p-0 overflow-hidden h-full">
    <div class="flex justify-between items-center p-2">
        <h2>
            <a class="flex items-center" href="{{ cp_route('statamic-members.index') }}">
                <div class="h-6 w-6 mr-1 text-grey-80">
                    @cp_svg('users')
                </div>
                <span>{{ $title }}</span>
            </a>
        </h2>
        @if ($create)
            @can('create members')
                <a href="{{ cp_route('statamic-members.create') }}" class="text-blue hover:text-blue-dark text-sm">{{ __('Create Member') }}</a>
            @endcan
        @endif
    </div>
    <members-user-widget
        listing-key="members"
        :filters="{{ $filters->toJson() }}"
        initial-sort-column="{{ $sortColumn }}"
        initial-sort-direction="{{ $sortDirection }}"
        :initial-per-page="{{ $limit }}"
        :paginate="@json($paginate)"
    ></members-user-widget>
</div>