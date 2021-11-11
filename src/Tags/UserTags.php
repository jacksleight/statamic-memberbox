<?php

namespace JackSleight\StatamicMemberbox\Tags;

use Statamic\Tags\Concerns;
use Statamic\Facades\User;
use JackSleight\StatamicMemberbox\Facades\Member;

class UserTags extends SubTag
{
    use Concerns\GetsFormSession,
        Concerns\GetsRedirects,
        Concerns\RendersForms;

    public function member()
    {
        $user = User::current();
        
        return Member::verify($user);
    }

    public function has()
    {
        $user = User::current();

        foreach ($this->params as $name => $value) {
            if ($user->get($name) !== $value) {
                return false;
            }
        }

        return true;
    }

    public function activateForm()
    {
        $data = [
            'errors' => [],
        ];

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

    public function profileForm()
    {
        $data = $this->getFormSession('statamic-memberbox.user.profile');

        $knownParams = ['redirect'];

        $html = $this->formOpen(route('statamic-memberbox.profile.action'), 'POST', $knownParams);

        if ($redirect = $this->params->get('redirect')) {
            $html .= '<input type="hidden" name="_redirect" value="'.$redirect.'" />';
        }

        $html .= $this->parse($data);

        $html .= $this->formClose();

        return $html;
    }

    public function changePasswordForm()
    {
        $data = $this->getFormSession('statamic-memberbox.user.change_password');

        $knownParams = ['redirect'];

        $html = $this->formOpen(route('statamic-memberbox.change_password.action'), 'POST', $knownParams);

        if ($redirect = $this->params->get('redirect')) {
            $html .= '<input type="hidden" name="_redirect" value="'.$redirect.'" />';
        }

        $html .= $this->parse($data);

        $html .= $this->formClose();

        return $html;
    }

    public function registerUrl()
    {
        return route('statamic-memberbox.register');
    }

    public function loginUrl()
    {
        $redirect = null;
        if ($this->params->has('append_redirect')) {
            $append = $this->params->get('append_redirect');
            $redirect = $append === true
                ? url()->current()
                : $append;
        }
        return route('statamic-memberbox.login', ['redirect' => $redirect]);
    }

    public function profileUrl()
    {
        return route('statamic-memberbox.profile');
    }

    public function forgotPasswordUrl()
    {
        return route('statamic-memberbox.forgot_password');
    }

    public function resetPasswordUrl()
    {
        return route('statamic-memberbox.reset_password');
    }

    public function changePasswordUrl()
    {
        return route('statamic-memberbox.change_password');
    }
}
