<?php

namespace JackSleight\StatamicMembers\Tags;

use Statamic\Facades\URL;
use Statamic\Facades\User;
use Statamic\Fields\Field;
use Statamic\Support\Arr;
use Statamic\Tags\Concerns;
use Statamic\Tags\Tags;

class UserTags extends Tags
{
    use Concerns\GetsFormSession,
        Concerns\GetsRedirects,
        Concerns\RendersForms;

    protected static $handle = 'members_user';

    public function __call($method, $args)
    {
        $id = Arr::get($this->context, $method);

        if (! $user = User::find($id)) {
            return;
        }

        return $user;
    }

    public function activateForm()
    {
        $data = [
            'errors' => [],
        ];

        if (session('success')) {
            return $this->parse(['success' => true]);
        }

        if (session('errors')) {
            $data['errors'] = session('errors')->all();
        }

        $knownParams = ['redirect', 'error_redirect'];

        $html = $this->formOpen(route('statamic.account.activate.action'), 'POST', $knownParams);

        $html .= '<input type="hidden" name="token" value="'.request('token').'" />';

        if ($redirect = $this->params->get('redirect')) {
            $html .= '<input type="hidden" name="redirect" value="'.$redirect.'" />';
        }

        if ($error_redirect = $this->params->get('error_redirect')) {
            $html .= '<input type="hidden" name="error_redirect" value="'.$error_redirect.'" />';
        }

        $html .= $this->parse($data);

        $html .= $this->formClose();

        return $html;
    }

    public function editForm()
    {
        $data = $this->getFormSession('members_user.edit');

        $knownParams = ['redirect'];

        $html = $this->formOpen(route('statamic.members.edit.action'), 'POST', $knownParams);

        if ($redirect = $this->params->get('redirect')) {
            $html .= '<input type="hidden" name="redirect" value="'.$redirect.'" />';
        }

        $html .= $this->parse($data);

        $html .= $this->formClose();

        return $html;
    }

    public function passwordForm()
    {
        $data = $this->getFormSession('members_user.password');

        $knownParams = ['redirect'];

        $html = $this->formOpen(route('statamic.members.password.action'), 'POST', $knownParams);

        if ($redirect = $this->params->get('redirect')) {
            $html .= '<input type="hidden" name="redirect" value="'.$redirect.'" />';
        }

        $html .= $this->parse($data);

        $html .= $this->formClose();

        return $html;
    }

    public function registerUrl()
    {
        return route('statamic.members.register');
    }

    public function loginUrl()
    {
        return route('statamic.members.login');
    }

    public function forgotUrl()
    {
        return route('statamic.members.forgot');
    }

    public function editUrl()
    {
        return route('statamic.members.edit');
    }

    public function passwordUrl()
    {
        return route('statamic.members.password');
    }

    public function referrerUrl()
    {
        return old('_redirect', url()->previous());
    }
}
