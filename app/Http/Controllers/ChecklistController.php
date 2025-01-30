<?php

namespace App\Http\Controllers;

use App\Models\Checklist;
use App\Models\Server;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChecklistController extends Controller
{
    public function index()
    {
        $checklists = Checklist::with('server')->latest()->get();
        return view('checklists.index', compact('checklists'));
    }

    public function create(Server $server)
    {
        return view('checklists.create', compact('server'));
    }

    public function store(Request $request, Server $server)
    {
        $validated = $request->validate([
            'items' => 'required|json',
            'comments' => 'nullable|string'
        ]);

        $checklist = new Checklist($validated);
        $checklist->server_id = $server->id;
        $checklist->created_by = Auth::id();
        $checklist->status = 'pending';
        $checklist->save();

        return redirect()->route('checklists.show', $checklist)
            ->with('success', 'Checklist created successfully');
    }

    public function show(Checklist $checklist)
    {
        return view('checklists.show', compact('checklist'));
    }

    public function approve(Request $request, Checklist $checklist)
    {
        $validated = $request->validate([
            'comments' => 'nullable|string'
        ]);

        $checklist->approvals()->create([
            'approver_id' => Auth::id(),
            'type' => Auth::user()->role,
            'status' => 'approved',
            'comments' => $validated['comments'] ?? null
        ]);

        $this->updateChecklistStatus($checklist);

        return redirect()->back()->with('success', 'Checklist approved successfully');
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
