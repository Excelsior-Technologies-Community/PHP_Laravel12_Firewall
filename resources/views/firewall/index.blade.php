<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Firewall Management</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 40px 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            font-size: 32px;
            margin-bottom: 10px;
        }
        .content {
            padding: 30px;
        }
        .form-group {
            background: #f7f9fc;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 30px;
        }
        .form-group h3 {
            margin-bottom: 20px;
            color: #333;
        }
        input[type="text"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        input[type="text"]:focus {
            outline: none;
            border-color: #667eea;
        }
        button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: transform 0.2s;
        }
        button:hover {
            transform: translateY(-2px);
        }
        .alert {
            padding: 15px;
            background: #d4edda;
            color: #155724;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .ip-list {
            list-style: none;
        }
        .ip-item {
            background: #f7f9fc;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: background 0.3s;
        }
        .ip-item:hover {
            background: #eef2f7;
        }
        .ip-info {
            flex: 1;
        }
        .ip-address {
            font-weight: bold;
            color: #333;
            font-size: 16px;
        }
        .ip-reason {
            color: #666;
            font-size: 14px;
            margin-top: 5px;
        }
        .ip-date {
            color: #999;
            font-size: 12px;
            margin-top: 5px;
        }
        .delete-form {
            margin-left: 15px;
        }
        .delete-btn {
            background: linear-gradient(135deg, #f56565 0%, #c53030 100%);
            padding: 8px 15px;
            font-size: 14px;
        }
        .empty-state {
            text-align: center;
            padding: 40px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔒 Firewall Management System</h1>
            <p>Manage blocked IP addresses</p>
        </div>

        <div class="content">
            @if(session('success'))
                <div class="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="form-group">
                <h3>Block New IP Address</h3>
                <form method="POST" action="{{ route('firewall.store') }}">
                    @csrf
                    <input type="text" name="ip_address" placeholder="Enter IP address (e.g., 127.0.0.1)" required>
                    <input type="text" name="reason" placeholder="Reason for blocking (optional)">
                    <button type="submit">Block IP</button>
                </form>
                @error('ip_address')
                    <p style="color: #f56565; margin-top: 10px;">{{ $message }}</p>
                @enderror
            </div>

            <h3 style="margin-bottom: 20px;">Blocked IP List</h3>
            
            @if($ips->count() > 0)
                <div class="ip-list">
                    @foreach($ips as $ip)
                        <div class="ip-item">
                            <div class="ip-info">
                                <div class="ip-address">{{ $ip->ip_address }}</div>
                                @if($ip->reason)
                                    <div class="ip-reason">Reason: {{ $ip->reason }}</div>
                                @endif
                                <div class="ip-date">Blocked: {{ $ip->created_at->diffForHumans() }}</div>
                            </div>
                            <form method="POST" action="{{ route('firewall.delete', $ip->id) }}" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-btn" onclick="return confirm('Are you sure you want to unblock this IP?')">Unblock</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <p>No IP addresses are currently blocked.</p>
                    <p style="font-size: 48px; margin-top: 20px;">🛡️</p>
                </div>
            @endif
        </div>
    </div>
</body>
</html>