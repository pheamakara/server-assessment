<?php

namespace App\Services;

use App\Models\Checklist;
use App\Models\Server;
use App\Notifications\ChecklistNeedsApprovalNotification;
use App\Notifications\ChecklistApprovedNotification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ChecklistService
{
    public function createChecklist(Server $server, array $items, ?string $comments = null)
    {
        $checklist = Checklist::create([
            'server_id' => $server->id,
            'created_by' => Auth::id(),
            'status' => 'pending',
            'items' => json_encode($items),
            'comments' => $comments
        ]);

        // Notify approvers
        $this->notifyApprovers($checklist);

        return $checklist;
    }

    public function processApproval(Checklist $checklist, string $type, string $status, ?string $comments = null)
    {
        $approval = $checklist->approvals()->create([
            'approver_id' => Auth::id(),
            'type' => $type,
            'status' => $status,
            'comments' => $comments
        ]);

        $this->updateChecklistStatus($checklist);

        if ($status === 'approved') {
            $checklist->creator->notify(new ChecklistApprovedNotification($checklist, $type));
        }

        return $approval;
    }

    private function notifyApprovers(Checklist $checklist)
    {
        $approvers = User::whereHas('roles', function ($query) {
            $query->whereIn('name', ['security_approver', 'manager_approver']);
        })->get();

        foreach ($approvers as $approver) {
            $approver->notify(new ChecklistNeedsApprovalNotification($checklist));
        }
    }

    private function updateChecklistStatus(Checklist $checklist)
    {
        $approvals = $checklist->approvals;
        
        if ($approvals->where('type', 'security')->where('status', 'approved')->count() > 0 &&
            $approvals->where('type', 'manager')->where('status', 'approved')->count() > 0) {
            $checklist->update(['status' => 'approved']);
        }
    }
}
