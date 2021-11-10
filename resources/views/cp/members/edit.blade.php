@extends('statamic::layout')
@section('title', __('Edit Member'))

@section('content')

    <memberbox-members-publish-form
        :actions="{{ json_encode($actions) }}"
        method="patch"
        publish-container="base"
        initial-title="{{ $title }}"
        initial-reference="{{ $reference }}"
        :initial-fieldset="{{ json_encode($blueprint) }}"
        :initial-values="{{ json_encode($values) }}"
        :initial-meta="{{ json_encode($meta) }}"
        :can-edit-password="{{ Statamic\Support\Str::bool($canEditPassword) }}"
    ></memberbox-member-publish-form>

@endsection