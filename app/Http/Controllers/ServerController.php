<?php

namespace App\Http\Controllers;

use App\Models\Server;
use Illuminate\Http\Request;

class ServerController extends Controller
{
    public function index()
    {
        $servers = Server::all();
        return view('servers.index', compact('servers'));
    }

    public function create()
    {
        return view('servers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:servers',
            'ip_address' => 'required|ip',
            'location' => 'required',
            'type' => 'required|in:virtual,physical',
            'operating_system' => 'required',
            'environment' => 'required',
            'specifications' => 'required|json',
            'stakeholders' => 'required|json',
            'business_impact' => 'required'
        ]);

        Server::create($validated);
        return redirect()->route('servers.index')->with('success', 'Server created successfully');
    }

    public function show(Server $server)
    {
        return view('servers.show', compact('server'));
    }

    public function edit(Server $server)
    {
        return view('servers.edit', compact('server'));
    }

    public function update(Request $request, Server $server)
    {
        $validated = $request->validate([
            'name' => 'required|unique:servers,name,' . $server->id,
            'ip_address' => 'required|ip',
            'location' => 'required',
            'type' => 'required|in:virtual,physical',
            'operating_system' => 'required',
            'environment' => 'required',
            'specifications' => 'required|json',
            'stakeholders' => 'required|json',
            'business_impact' => 'required'
        ]);

        $server->update($validated);
        return redirect()->route('servers.index')->with('success', 'Server updated successfully');
    }

    public function destroy(Server $server)
    {
        $server->delete();
        return redirect()->route('servers.index')->with('success', 'Server deleted successfully');
    }
}
