<?php

namespace App\Http\Controllers;

use App\Models\BlockedAttempt;
use App\Models\BlockedIp;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FirewallController extends Controller
{

    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');

        /*
        |--------------------------------------------------------------------------
        | Blocked IP Query
        |--------------------------------------------------------------------------
        */

        $ipQuery = BlockedIp::query();

        if ($search !== '') {
            $ipQuery->where(function ($query) use ($search) {
                $query->where('ip_address', 'like', '%' . $search . '%')
                    ->orWhere('reason', 'like', '%' . $search . '%');
            });
        }

        if ($dateFrom) {
            $ipQuery->whereDate('created_at', '>=', $dateFrom);
        }

        if ($dateTo) {
            $ipQuery->whereDate('created_at', '<=', $dateTo);
        }

        $perPage = (int) $request->input('per_page', 5);

        if (!in_array($perPage, [5, 10, 25, 50, 100], true)) {
            $perPage = 5;
        }

        $ips = $ipQuery
            ->oldest()
            ->paginate($perPage)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Blocked Attempts Query
        |--------------------------------------------------------------------------
        */

        $attemptQuery = BlockedAttempt::query();

        if ($search !== '') {
            $attemptQuery->where(function ($query) use ($search) {
                $query->where('ip_address', 'like', '%' . $search . '%')
                    ->orWhere('url', 'like', '%' . $search . '%')
                    ->orWhere('method', 'like', '%' . $search . '%');
            });
        }

        if ($dateFrom) {
            $attemptQuery->whereDate('created_at', '>=', $dateFrom);
        }

        if ($dateTo) {
            $attemptQuery->whereDate('created_at', '<=', $dateTo);
        }

        $attempts = $attemptQuery
            ->latest()
            ->paginate(15, ['*'], 'attempts_page')
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        */

        $totalBlockedIps = BlockedIp::count();

        $totalAttempts = BlockedAttempt::count();

        $todayAttempts = BlockedAttempt::whereDate(
            'created_at',
            Carbon::today()
        )->count();

        $todayBlockedIps = BlockedIp::whereDate(
            'created_at',
            Carbon::today()
        )->count();

        $weekAttempts = BlockedAttempt::where(
            'created_at',
            '>=',
            Carbon::now()->subDays(7)
        )->count();

        $monthAttempts = BlockedAttempt::where(
            'created_at',
            '>=',
            Carbon::now()->subDays(30)
        )->count();

        $topBlockedIps = BlockedAttempt::select('ip_address')
            ->selectRaw('COUNT(*) as attempts_count')
            ->groupBy('ip_address')
            ->orderByDesc('attempts_count')
            ->limit(5)
            ->get();

        return view('firewall.index', compact(
            'ips',
            'attempts',
            'search',
            'dateFrom',
            'dateTo',
            'perPage',
            'totalBlockedIps',
            'totalAttempts',
            'todayAttempts',
            'todayBlockedIps',
            'weekAttempts',
            'monthAttempts',
            'topBlockedIps'
        ));
    }

    /**
     * Block a new IP.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ip_address' => [
                'required',
                'ip',
                'unique:blocked_ips,ip_address',
            ],
            'reason' => [
                'nullable',
                'string',
                'max:255',
            ],
        ]);

        BlockedIp::create([
            'ip_address' => $validated['ip_address'],
            'reason' => $validated['reason'] ?? null,
        ]);

        return redirect()
            ->route('firewall.index')
            ->with('success', 'IP blocked successfully!');
    }

    /**
     * Unblock an IP.
     */
    public function destroy($id)
    {
        $blockedIp = BlockedIp::findOrFail($id);

        $blockedIp->delete();

        return redirect()
            ->route('firewall.index')
            ->with('success', 'IP unblocked successfully!');
    }

    /**
     * Permanently delete a blocked IP record.
     */
    public function delete($id)
    {
        $blockedIp = BlockedIp::findOrFail($id);

        $blockedIp->delete();

        return redirect()
            ->route('firewall.index')
            ->with('success', 'Blocked IP deleted successfully.');
    }

    /**
     * Export filtered blocked IPs as CSV.
     */
    public function export(Request $request): StreamedResponse
    {
        $search = trim($request->input('search', ''));
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');

        $query = BlockedIp::query();

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('ip_address', 'like', '%' . $search . '%')
                    ->orWhere('reason', 'like', '%' . $search . '%');
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Date Filters
        |--------------------------------------------------------------------------
        */

        if ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }

        if ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        $fileName = 'firewall-blocked-ips-' . now()->format('Y-m-d-H-i-s') . '.csv';

        return response()->streamDownload(function () use ($query) {

            $handle = fopen('php://output', 'w');

            /*
            |--------------------------------------------------------------------------
            | CSV Header
            |--------------------------------------------------------------------------
            */

            fputcsv($handle, [
                'ID',
                'IP Address',
                'Reason',
                'Blocked At',
            ]);

            /*
            |--------------------------------------------------------------------------
            | CSV Rows
            |--------------------------------------------------------------------------
            */

            $query
                ->latest()
                ->chunk(500, function ($ips) use ($handle) {

                    foreach ($ips as $ip) {

                        fputcsv($handle, [
                            $ip->id,
                            $ip->ip_address,
                            $ip->reason ?? '',
                            optional($ip->created_at)->format('Y-m-d H:i:s'),
                        ]);
                    }
                });

            fclose($handle);
        }, $fileName, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}
