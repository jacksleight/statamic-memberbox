<?php

namespace JackSleight\StatamicMemberbox\Tags;

use Statamic\Auth\UserTags as StatamicUserTags;
use Statamic\Support\Arr;

class UserTags extends StatamicUserTags
{
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

        $knownParams = ['redirect', 'files'];

        $html = $this->formOpen(route('statamic-memberbox.profile.action'), 'POST', $knownParams);

        if ($redirect = $this->params->get('redirect')) {
            $html .= '<input type="hidden" name="_redirect" value="'.$redirect.'" />';
        }

        $html .= $this->parse($data);

        $html .= $this->formClose();

        return $html;
    }

    public function registerUrl()
    {
        return $this->accountRouteUrl('register');
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

        return $this->accountRouteUrl('login', ['redirect' => $redirect]);
    }

    public function profileUrl()
    {
        return $this->accountRouteUrl('profile');
    }

    public function forgotPasswordUrl()
    {
        return $this->accountRouteUrl('forgot_password');
    }

    public function resetPasswordUrl()
    {
        return $this->accountRouteUrl('reset_password');
    }

    public function changePasswordUrl()
    {
        return $this->accountRouteUrl('change_password');
    }

    public function indexUrl()
    {
        return $this->directoryRouteUrl('index');
    }

    public function showUrl()
    {
        return $this->directoryRouteUrl('show', $this->params->all());
    }

    protected function accountRouteUrl($name, array $params = [])
    {
        if (config('statamic.memberbox.enable_account', true)) {
            return route('statamic-memberbox.'.$name, $params);
        }

        return $this->routeUrl($name, $params);
    }

    protected function directoryRouteUrl($name, array $params = [])
    {
        if (config('statamic.memberbox.enable_directory', false)) {
            return route('statamic-memberbox.'.$name, $params);
        }

        return $this->routeUrl($name, $params);
    }

    protected function routeUrl($name, array $params = [])
    {
        return url(config('statamic.memberbox.routes.'.$name)).($params ? ('?'.Arr::query($params)) : null);
    }
}
