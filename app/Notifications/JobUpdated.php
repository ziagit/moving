<?php

namespace App\Notifications;

use App\Jobstatus;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class JobUpdated extends Notification
{
    use Queueable;
    public $job;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->job = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $jobstatus = Jobstatus::find($this->job->jobstatus_id);
        $url = url('/#/carrier/history/details/'.$this->job->id);
        return (new MailMessage)
        ->subject('Shipment Status')
        ->greeting('Dear Customer')
        ->line('Your frieght is '.$jobstatus->title)
        ->action('View more details', $url);
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
