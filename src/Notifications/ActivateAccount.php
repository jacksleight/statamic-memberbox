<?php

namespace JackSleight\StatamicMemberbox\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Statamic\Auth\Passwords\PasswordReset as PasswordResetManager;
use Statamic\Notifications\ActivateAccount as StatamicActivateAccount;

class ActivateAccount extends StatamicActivateAccount
{
    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->from(config('statamic.memberbox.invitation_from.address'), config('statamic.memberbox.invitation_from.name'))
            ->subject(static::$subject ?? __('statamic-memberbox::messages.activate_account_notification_subject'))
            ->line(static::$body ?? __('statamic-memberbox::messages.activate_account_notification_body'))
            ->action(__('Activate Account'), PasswordResetManager::url($this->token, PasswordResetManager::BROKER_ACTIVATIONS));
    }
}
