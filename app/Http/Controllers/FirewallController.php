<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlockedIp;
use App\Models\BlockedAttempt;

class FirewallController extends Controller
{
    public function index()
    {
        $ips = BlockedIp::latest()->get();

        $attempts = BlockedAttempt::latest()->paginate(15);

        return view('firewall.index', compact('ips', 'attempts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ip_address' => 'required|ip|unique:blocked_ips,ip_address',
            'reason' => 'nullable|string|max:255',
        ]);

        BlockedIp::create([
            'ip_address' => $request->ip_address,
            'reason' => $request->reason,
        ]);

        return redirect()
            ->route('firewall.index')
            ->with('success', 'IP blocked successfully!');
    }

    public function destroy($id)
    {
        $blockedIp = BlockedIp::findOrFail($id);

        $blockedIp->delete();

        return redirect()
            ->route('firewall.index')
            ->with('success', 'IP unblocked successfully!');
    }
}