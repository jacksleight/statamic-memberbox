<?php

namespace JackSleight\StatamicMembers\Tags;

use JackSleight\StatamicMembers\Facades\Member;
use Statamic\Tags\Concerns;
use Statamic\Tags\Tags;
use Statamic\Facades\User;

class MemberTags extends Tags
{
    use Concerns\GetsFormSession,
        Concerns\GetsRedirects,
        Concerns\RendersForms;

    protected static $handle = 'member';

    public function index()
    {
        $user = User::current();
        
        return Member::authorize($user, $this->params);
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

    public function editForm()
    {
        $data = $this->getFormSession('member.edit');

        $knownParams = ['redirect'];

        $html = $this->formOpen(route('statamic.members.edit.action'), 'POST', $knownParams);

        if ($redirect = $this->params->get('redirect')) {
            $html .= '<input type="hidden" name="_redirect" value="'.$redirect.'" />';
        }

        $html .= $this->parse($data);

        $html .= $this->formClose();

        return $html;
    }

    public function passwordForm()
    {
        $data = $this->getFormSession('member.password');

        $knownParams = ['redirect'];

        $html = $this->formOpen(route('statamic.members.password.action'), 'POST', $knownParams);

        if ($redirect = $this->params->get('redirect')) {
            $html .= '<input type="hidden" name="_redirect" value="'.$redirect.'" />';
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

    public function resetUrl()
    {
        return route('statamic.members.reset');
    }

    public function editUrl()
    {
        return route('statamic.members.edit');
    }

    public function passwordUrl()
    {
        return route('statamic.members.password');
    }
}
