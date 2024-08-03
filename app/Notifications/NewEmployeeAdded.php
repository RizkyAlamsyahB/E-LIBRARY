<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewEmployeeAdded extends Notification
{
    use Queueable;

    protected $user;
    protected $plainPassword;

    /**
     * Create a new notification instance.
     *
     * @param \App\Models\User $user
     * @return void
     */
    public function __construct(User $user, $plainPassword)
    {
        $this->user = $user;
        $this->plainPassword = $plainPassword;
    }

    /**
     * Determine the channels the notification should be sent on.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail']; // Specify that this notification should be sent via email
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('Anda telah berhasil ditambahkan sebagai pegawai.')
            ->line('Nama: ' . $this->user->name)
            ->line('Email: ' . $this->user->email)
            ->line('Password : **' . $this->plainPassword . '**')
            ->line('Nomor Telepon: ' . $this->user->phone)
            ->line('Tanggal Lahir: ' . $this->user->date_of_birth)
            ->line('Jenis Kelamin: ' . $this->user->gender)
            ->line('Harap ganti password Anda setelah login.')
            ->line('Terima kasih!');
    }
}
