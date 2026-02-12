<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class AccountCreatedNotification extends Notification
{
    use Queueable;

    public function __construct(public $email, public $password,public $role)
    {
    }

    public function via($notifiable)
    {
        return ['mail']; // Send only via email
    }

public function toMail($notifiable)
{
    return (new MailMessage)
        ->subject('LMS Account Creation - Access Credentials Enclosed')
        ->greeting('Dear ' . ($notifiable->name ?? 'User') . ',')
        ->line('We are pleased to inform you that your Learning Management System (LMS) account has been successfully created by the system administrator.')
        ->line('Please find your account credentials below:')
        ->line('')
        ->line("**Role:** " . strtoupper($this->role))
        ->line("**Email Address:** {$this->email}")
        ->line("**Temporary Password:** {$this->password}")
        ->line('')
        ->action('Login to LMS', config('app.url') . '/login')
        ->line('')
        ->line('**Important Security Notice:**')
        ->line('For security purposes, you are required to change your password upon first login. Your temporary password will expire after the initial login session.')
        ->line('')
        ->line('If you experience any difficulties accessing your account or have questions about the platform, please contact us.')
        ->line('We look forward to your participation in our learning community.')
        ->salutation('Best regards,')
        ->salutation('The GSSM Administration Team');
}
}
