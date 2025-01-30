<?php

namespace App\Notifications;

use App\Models\Checklist;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ChecklistNeedsApprovalNotification extends Notification
{
    use Queueable;

    protected $checklist;

    public function __construct(Checklist $checklist)
    {
        $this->checklist = $checklist;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Checklist Requires Your Approval')
            ->line('A new checklist has been submitted for your approval.')
            ->line('Server: ' . $this->checklist->server->name)
            ->line('Created by: ' . $this->checklist->creator->name)
            ->action('Review Checklist', url('/checklists/' . $this->checklist->id))
            ->line('Thank you for your prompt attention to this matter.');
    }

    public function toArray($notifiable)
    {
        return [
            'checklist_id' => $this->checklist->id,
            'server_name' => $this->checklist->server->name,
            'created_by' => $this->checklist->creator->name,
        ];
    }
}
