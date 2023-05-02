<?php

namespace JackSleight\StatamicMemberbox\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Statamic\Exceptions\UnauthorizedHttpException;
use Statamic\Facades\User;
use Statamic\Forms\Uploaders\AssetsUploader;
use Statamic\Support\Arr;

class UsersController extends Controller
{
    public function profile(Request $request)
    {
        throw_unless($user = User::current(), new UnauthorizedHttpException(403));

        $only = collect(config('statamic.memberbox.profile_fields'));

        $blueprint = User::blueprint();

        $fields = $blueprint->fields()->only($only->all());
        $values = array_merge($request->all(), $this->normalizeAssetValues($fields, $request));
        $fields = $fields->addValues($values);

        $extraRules = $this->assetRules($fields);
        if ($only->contains('email')) {
            $extraRules = array_merge([
                'email' => ['required', 'unique_user_value:'.$user->id()],
            ], $extraRules);
        }
        $fieldRules = $fields->validator()->withRules($extraRules)->rules();

        $validator = Validator::make($values, $fieldRules);

        if ($validator->fails()) {
            $errors = $validator->errors();

            return back()->withInput()->withErrors($errors, 'statamic-memberbox.user.profile');
        }

        $values = array_merge($request->all(), $this->uploadAssetFiles($fields));
        $fields = $fields->addValues($values);
        // only() added here to filter out fields that weren't actualy submitted
        $values = $fields->process()->values()->only(array_keys($values))->except(['email', 'password', 'groups', 'roles']);

        foreach ($values as $key => $value) {
            $user->set($key, $value);
        }
        if ($only->contains('email') && $request->email) {
            $user->email($request->email);
        }

        $user->save();

        session()->flash('statamic-memberbox.user.profile.success', __('Account updated successfully.'));

        return request()->has('_redirect') ? redirect(request()->get('_redirect')) : back();
    }

    protected function assetRules($fields)
    {
        return $fields->all()
            ->filter(function ($field) {
                return $field->fieldtype()->handle() === 'assets';
            })
            ->mapWithKeys(function ($field) {
                return [$field->handle().'.*' => 'file'];
            })
            ->all();
    }

    protected function normalizeAssetValues($fields, $request)
    {
        return $fields->all()
            ->filter(function ($field) {
                return $field->fieldtype()->handle() === 'assets' && $field->get('max_files') === 1;
            })
            ->map(function ($field) use ($request) {
                return Arr::wrap($request->file($field->handle()));
            })
            ->all();
    }

    protected function uploadAssetFiles($fields)
    {
        return $fields->all()
            ->filter(function ($field) {
                return $field->fieldtype()->handle() === 'assets' && request()->hasFile($field->handle());
            })
            ->map(function ($field) {
                return AssetsUploader::field($field)->upload(request()->file($field->handle()));
            })
            ->all();
    }
}
