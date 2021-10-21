<?php

namespace JackSleight\Members\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Statamic\Notifications\ActivateAccount as StatamicActivateAccount;
use Statamic\Auth\Passwords\PasswordReset as PasswordResetManager;

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
            ->subject(static::$subject ?? __('members::messages.activate_account_notification_subject'))
            ->line(static::$body ?? __('members::messages.activate_account_notification_body'))
            ->action(__('Activate Account'), PasswordResetManager::url($this->token, PasswordResetManager::BROKER_ACTIVATIONS));
    }
}