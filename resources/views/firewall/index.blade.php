<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Firewall Management</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family:
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                Roboto,
                Arial,
                sans-serif;

            background: #f4f7fb;
            color: #1f2937;
        }

        .container {
            width: 95%;
            max-width: 1400px;
            margin: 30px auto;
        }

        /* Header */

        .header {
            background:
                linear-gradient(135deg,
                    #667eea,
                    #764ba2);

            color: white;

            padding: 30px;

            border-radius: 15px;

            margin-bottom: 25px;

            box-shadow:
                0 10px 30px rgba(0, 0, 0, .15);
        }

        .header h1 {
            margin-bottom: 8px;
        }

        .header p {
            opacity: .9;
        }

        /* Statistics */

        .stats {
            display: grid;

            grid-template-columns:
                repeat(4, 1fr);

            gap: 20px;

            margin-bottom: 25px;
        }

        .stat-card {
            background: white;

            padding: 25px;

            border-radius: 12px;

            box-shadow:
                0 5px 20px rgba(0, 0, 0, .07);
        }

        .stat-card h4 {
            color: #6b7280;

            font-size: 14px;

            margin-bottom: 10px;
        }

        .stat-number {
            font-size: 30px;

            font-weight: 700;

            color: #4f46e5;
        }

        /* Cards */

        .card {
            background: white;

            border-radius: 12px;

            padding: 25px;

            margin-bottom: 25px;

            box-shadow:
                0 5px 20px rgba(0, 0, 0, .07);
        }

        .card h2 {
            margin-bottom: 20px;

            font-size: 20px;
        }

        /* Form */

        .form-grid {
            display: grid;

            grid-template-columns:
                1fr 1fr auto;

            gap: 15px;
        }

        input,
        select {
            width: 100%;

            padding: 12px 14px;

            border: 1px solid #d1d5db;

            border-radius: 8px;

            font-size: 14px;
        }

        input:focus,
        select:focus {
            outline: none;

            border-color: #6366f1;

            box-shadow:
                0 0 0 3px rgba(99, 102, 241, .1);
        }

        button,
        .btn {
            border: none;

            padding: 12px 18px;

            border-radius: 8px;

            cursor: pointer;

            text-decoration: none;

            display: inline-block;

            font-size: 14px;

            font-weight: 600;
        }

        .btn-primary {
            background: #4f46e5;
            color: white;
        }

        .btn-success {
            background: #059669;
            color: white;
        }

        .btn-danger {
            background: #dc2626;
            color: white;
        }

        .btn-secondary {
            background: #6b7280;
            color: white;
        }

        /* Filter */

        .filter-grid {
            display: grid;

            grid-template-columns:
                2fr 1fr 1fr 120px auto auto;

            gap: 12px;

            align-items: end;
        }

        .field label {
            display: block;

            margin-bottom: 6px;

            font-size: 13px;

            font-weight: 600;

            color: #4b5563;
        }

        /* Table */

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;

            border-collapse: collapse;
        }

        th {
            background: #f8fafc;

            padding: 14px;

            text-align: left;

            font-size: 13px;

            color: #475569;
        }

        td {
            padding: 14px;

            border-bottom: 1px solid #e5e7eb;

            font-size: 14px;

            vertical-align: top;
        }

        tr:hover td {
            background: #f9fafb;
        }

        .badge {
            display: inline-block;

            padding: 5px 10px;

            border-radius: 20px;

            background: #fee2e2;

            color: #991b1b;

            font-size: 12px;

            font-weight: 600;
        }

        /* Alerts */

        .alert {
            padding: 15px;

            border-radius: 8px;

            margin-bottom: 20px;
        }

        .alert-success {
            background: #d1fae5;

            color: #065f46;
        }

        .alert-danger {
            background: #fee2e2;

            color: #991b1b;
        }

        .error-list {
            margin-top: 10px;

            padding-left: 20px;
        }

        .btn-warning {
            background: #f59e0b;
            color: white;
        }

        .btn-danger {
            background: #dc2626;
            color: white;
        }

        /* Pagination */

        .pagination-wrapper {
            margin-top: 20px;
        }

        .number-pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .number-pagination a {
            min-width: 38px;
            height: 38px;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 0 12px;

            border: 1px solid #d1d5db;

            border-radius: 8px;

            background: white;

            color: #374151;

            text-decoration: none;

            font-size: 14px;

            font-weight: 600;

            transition: all 0.2s ease;
        }

        .number-pagination a:hover {
            background: #eef2ff;

            border-color: #6366f1;

            color: #4f46e5;
        }

        .number-pagination a.active {
            background: #4f46e5;

            border-color: #4f46e5;

            color: white;
        }

        /* Top IP */

        .top-ip-list {
            display: grid;

            gap: 10px;
        }

        .top-ip {
            display: flex;

            justify-content: space-between;

            align-items: center;

            background: #f8fafc;

            padding: 12px 15px;

            border-radius: 8px;
        }

        .count {
            background: #e0e7ff;

            color: #3730a3;

            padding: 5px 10px;

            border-radius: 20px;

            font-size: 12px;

            font-weight: 600;
        }

        /* Responsive */

        @media (max-width: 1100px) {

            .stats {
                grid-template-columns:
                    repeat(2, 1fr);
            }

            .filter-grid {
                grid-template-columns:
                    1fr 1fr;
            }

            .form-grid {
                grid-template-columns:
                    1fr;
            }
        }

        @media (max-width: 600px) {

            .container {
                width: 94%;
            }

            .stats {
                grid-template-columns: 1fr;
            }

            .filter-grid {
                grid-template-columns: 1fr;
            }

            .header h1 {
                font-size: 24px;
            }

            .card {
                padding: 18px;
            }
        }
    </style>
</head>

<body>

    <div class="container">

        {{-- Header --}}

        <div class="header">

            <h1>
                🔒 Firewall Management System
            </h1>

            <p>
                Manage blocked IP addresses,
                monitor unauthorized access attempts
                and export firewall data.
            </p>

        </div>


        {{-- Success Message --}}

        @if(session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

        @endif


        {{-- Validation Errors --}}

        @if($errors->any())

        <div class="alert alert-danger">

            <strong>
                Please fix the following errors:
            </strong>

            <ul class="error-list">

                @foreach($errors->all() as $error)

                <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

        @endif


        {{-- Statistics --}}

        <div class="stats">

            <div class="stat-card">

                <h4>
                    Total Blocked IPs
                </h4>

                <div class="stat-number">
                    {{ $totalBlockedIps }}
                </div>

            </div>


            <div class="stat-card">

                <h4>
                    Total Blocked Attempts
                </h4>

                <div class="stat-number">
                    {{ $totalAttempts }}
                </div>

            </div>


            <div class="stat-card">

                <h4>
                    Today's Attempts
                </h4>

                <div class="stat-number">
                    {{ $todayAttempts }}
                </div>

            </div>


            <div class="stat-card">

                <h4>
                    Blocked Today
                </h4>

                <div class="stat-number">
                    {{ $todayBlockedIps }}
                </div>

            </div>

        </div>


        {{-- Additional Statistics --}}

        <div class="stats">

            <div class="stat-card">

                <h4>
                    Last 7 Days Attempts
                </h4>

                <div class="stat-number">
                    {{ $weekAttempts }}
                </div>

            </div>


            <div class="stat-card">

                <h4>
                    Last 30 Days Attempts
                </h4>

                <div class="stat-number">
                    {{ $monthAttempts }}
                </div>

            </div>

        </div>


        {{-- Block New IP --}}

        <div class="card">

            <h2>
                🚫 Block New IP Address
            </h2>

            <form
                method="POST"
                action="{{ route('firewall.store') }}">

                @csrf

                <div class="form-grid">

                    <div>

                        <input
                            type="text"
                            name="ip_address"
                            value="{{ old('ip_address') }}"
                            placeholder="Enter IP address e.g. 192.168.1.10"
                            required>

                    </div>


                    <div>

                        <input
                            type="text"
                            name="reason"
                            value="{{ old('reason') }}"
                            placeholder="Reason for blocking">

                    </div>


                    <div>

                        <button
                            type="submit"
                            class="btn btn-danger">
                            Block IP
                        </button>

                    </div>

                </div>

            </form>

        </div>

        {{-- Export --}}

        <div class="card">

            <div style="
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap:15px;
            flex-wrap:wrap;
        ">

                <div>

                    <h2 style="margin-bottom:5px;">
                        📥 Export Firewall Data
                    </h2>

                    <p style="color:#6b7280;font-size:14px;">
                        Export the currently filtered blocked IP records.
                    </p>

                </div>


                <a
                    href="{{ route('firewall.export', [
                    'search' => $search,
                    'date_from' => $dateFrom,
                    'date_to' => $dateTo,
                ]) }}"
                    class="btn btn-success">
                    Download CSV
                </a>

            </div>

        </div>


        {{-- Search / Filters --}}

        <div class="card">

            <h2>
                🔎 Search & Filter
            </h2>

            <form
                method="GET"
                action="{{ route('firewall.index') }}">

                <div class="filter-grid">

                    {{-- Search --}}

                    <div class="field">

                        <label>
                            Search
                        </label>

                        <input
                            type="text"
                            name="search"
                            value="{{ $search }}"
                            placeholder="Search IP, reason, URL...">

                    </div>


                    {{-- From --}}

                    <div class="field">

                        <label>
                            Date From
                        </label>

                        <input
                            type="date"
                            name="date_from"
                            value="{{ $dateFrom }}">

                    </div>


                    {{-- To --}}

                    <div class="field">

                        <label>
                            Date To
                        </label>

                        <input
                            type="date"
                            name="date_to"
                            value="{{ $dateTo }}">

                    </div>


                    {{-- Per Page --}}

                    <div class="field">

                        <label>
                            Per Page
                        </label>

                        <select name="per_page">

                            <option
                                value="5"
                                {{ $perPage == 5 ? 'selected' : '' }}>
                                5
                            </option>

                            <option
                                value="10"
                                {{ $perPage == 10 ? 'selected' : '' }}>
                                10
                            </option>

                            <option
                                value="25"
                                {{ $perPage == 25 ? 'selected' : '' }}>
                                25
                            </option>

                            <option
                                value="50"
                                {{ $perPage == 50 ? 'selected' : '' }}>
                                50
                            </option>

                            <option
                                value="100"
                                {{ $perPage == 100 ? 'selected' : '' }}>
                                100
                            </option>

                        </select>

                    </div>


                    {{-- Filter --}}

                    <div>

                        <button
                            type="submit"
                            class="btn btn-primary">
                            Filter
                        </button>

                    </div>


                    {{-- Reset --}}

                    <div>

                        <a
                            href="{{ route('firewall.index') }}"
                            class="btn btn-secondary">
                            Reset
                        </a>

                    </div>

                </div>

            </form>

        </div>



        {{-- Blocked IPs --}}

        <div class="card">

            <div style="
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:20px;
            gap:15px;
            flex-wrap:wrap;
        ">

                <h2 style="margin:0;">
                    🛡️ Blocked IP Addresses
                </h2>

                <span class="badge">
                    {{ $ips->total() }} Records
                </span>

            </div>


            @if($ips->count() > 0)

            <div class="table-wrapper">

                <table>

                    <thead>

                        <tr>

                            <th>
                                #
                            </th>

                            <th>
                                IP Address
                            </th>

                            <th>
                                Reason
                            </th>

                            <th>
                                Blocked At
                            </th>

                            <th>
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($ips as $ip)

                        <tr>

                            <td>
                                {{ $ips->firstItem() + $loop->index }}
                            </td>

                            <td>

                                <strong>
                                    {{ $ip->ip_address }}
                                </strong>

                            </td>

                            <td>

                                {{ $ip->reason ?: 'No reason provided' }}

                            </td>

                            <td>

                                {{ $ip->created_at->format('d M Y, h:i A') }}

                                <br>

                                <small style="color:#6b7280;">
                                    {{ $ip->created_at->diffForHumans() }}
                                </small>

                            </td>

                            <td>

                                <div style="display:flex; gap:8px;">

                                    {{-- EXISTING UNBLOCK --}}
                                    <form
                                        method="POST"
                                        action="{{ route('firewall.unblock', $ip->id) }}">
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-warning"
                                            onclick="return confirm('Unblock this IP?')">
                                            Unblock
                                        </button>
                                    </form>


                                    {{-- NEW DELETE --}}
                                    <form
                                        method="POST"
                                        action="{{ route('firewall.delete', $ip->id) }}">
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-danger"
                                            onclick="return confirm('This will permanently delete the IP record. Continue?')">
                                            Delete
                                        </button>
                                    </form>

                                </div>

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>


            <div class="pagination-wrapper">

                @if ($ips->hasPages())

                <div class="number-pagination">

                    @for ($page = 1; $page <= $ips->lastPage(); $page++)

                        <a
                            href="{{ $ips->appends(request()->query())->url($page) }}"
                            class="{{ $ips->currentPage() == $page ? 'active' : '' }}">
                            {{ $page }}
                        </a>

                        @endfor

                </div>

                @endif

            </div>

            @else

            <div style="
                text-align:center;
                padding:50px;
                color:#6b7280;
            ">

                <div style="font-size:50px;">
                    🛡️
                </div>

                <h3 style="margin:10px 0;">
                    No blocked IPs found
                </h3>

                <p>
                    Try changing your search or filter.
                </p>

            </div>

            @endif

        </div>


        {{-- Top Blocked IPs --}}

        <div class="card">

            <h2>
                🔥 Most Active Blocked IPs
            </h2>

            @if($topBlockedIps->count())

            <div class="top-ip-list">

                @foreach($topBlockedIps as $topIp)

                <div class="top-ip">

                    <strong>
                        {{ $topIp->ip_address }}
                    </strong>

                    <span class="count">
                        {{ $topIp->attempts_count }}
                        attempts
                    </span>

                </div>

                @endforeach

            </div>

            @else

            <p style="color:#6b7280;">
                No blocked attempts recorded yet.
            </p>

            @endif

        </div>


        {{-- Blocked Attempts --}}

        <div class="card">

            <h2>
                🚨 Blocked Access Attempts
            </h2>


            @if($attempts->count() > 0)

            <div class="table-wrapper">

                <table>

                    <thead>

                        <tr>

                            <th>
                                #
                            </th>

                            <th>
                                IP Address
                            </th>

                            <th>
                                Method
                            </th>

                            <th>
                                URL
                            </th>

                            <th>
                                User Agent
                            </th>

                            <th>
                                Time
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($attempts as $attempt)

                        <tr>

                            <td>
                                {{ $attempts->firstItem() + $loop->index }}
                            </td>

                            <td>

                                <strong>
                                    {{ $attempt->ip_address }}
                                </strong>

                            </td>

                            <td>

                                <span class="badge">
                                    {{ $attempt->method }}
                                </span>

                            </td>

                            <td style="
                                max-width:300px;
                                word-break:break-all;
                            ">

                                {{ $attempt->url }}

                            </td>

                            <td style="
                                max-width:300px;
                                word-break:break-word;
                            ">

                                {{ $attempt->user_agent ?: 'Unknown' }}

                            </td>

                            <td style="white-space:nowrap;">

                                {{ $attempt->created_at->format('d M Y, h:i A') }}

                                <br>

                                <small style="color:#6b7280;">
                                    {{ $attempt->created_at->diffForHumans() }}
                                </small>

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>


            <div class="pagination-wrapper">

                @if ($ips->hasPages())

                <div class="number-pagination">

                    @for ($page = 1; $page <= $ips->lastPage(); $page++)

                        <a
                            href="{{ $ips->appends(request()->query())->url($page) }}"
                            class="{{ $ips->currentPage() == $page ? 'active' : '' }}">
                            {{ $page }}
                        </a>

                        @endfor

                </div>

                @endif

            </div>

            @else

            <div style="
                text-align:center;
                padding:40px;
                color:#6b7280;
            ">

                <div style="font-size:50px;">
                    📋
                </div>

                <h3>
                    No blocked attempts found
                </h3>

            </div>

            @endif

        </div>

    </div>

</body>

</html>