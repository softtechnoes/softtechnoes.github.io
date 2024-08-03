<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;
use Lang;
use Config;

class PasswordReset extends Notification
{
    use Queueable;
    protected $user; // receiver

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user,$code)
    {
        $this->user   = $user;
        $this->code   = $code;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        if (config('app.activate_mail_notifications')) {
            return ['mail'];
          } else {
            return [];
        }
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        /** @var User $user */
        $user         = $this->user;
        $code         = $this->code;

        return (new MailMessage)
            ->from(Config::get('mail.from.address'), Config::get('mail.from.name'))
            ->subject(Lang::get('notifications.PasswordReset_email_subject'))
            ->greeting(Lang::get('site_lang.hello') . ' ' . $user->name . ',')
            ->line(Lang::get('notifications.PasswordReset_email_line_intro'))
            ->line($code)
            ->line(Lang::get('notifications.PasswordReset_email_line_expiry',['hours' => config('auth.passwords.users.expire')/60]))
            ->line(Lang::get('notifications.PasswordReset_email_line_outro'))
            ->salutation(Lang::get('notifications.PasswordReset_email_salutations').'<br>'.Lang::get('site_lang.administrator'));

    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
