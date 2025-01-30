<?php

namespace App\Notifications;

use App\Models\Checklist;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ChecklistApprovedNotification extends Notification
{
    use Queueable;

    protected $checklist;
    protected $approverType;

    public function __construct(Checklist $checklist, string $approverType)
    {
        $this->checklist = $checklist;
        $this->approverType = $approverType;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Checklist Approved')
            ->line('Your checklist has been approved by ' . ucfirst($this->approverType))
            ->line('Server: ' . $this->checklist->server->name)
            ->action('View Checklist', url('/checklists/' . $this->checklist->id))
            ->line('Thank you for using our application.');
    }

    public function toArray($notifiable)
    {
        return [
            'checklist_id' => $this->checklist->id,
            'server_name' => $this->checklist->server->name,
            'approver_type' => $this->approverType,
        ];
    }
}
