# PHP_Laravel12_Firewall
This guide explains how to build a complete IP‑based Firewall System in Laravel.

The project includes:

* IP Blocking System
* Custom Middleware Protection
* Admin Management Interface
* Blocked Access Page
* Database Storage
* Validation & Testing

---

## STEP 1 – Create New Laravel Project

composer create-project laravel/laravel laravel-firewall
cd laravel-firewall

---

## STEP 2 – Create Firewall Middleware

php artisan make:middleware FirewallMiddleware

Middleware Logic:

* Capture user IP address
* Check database for blocked IP
* If blocked → show custom blocked page
* If not blocked → continue request

---

## STEP 3 – Register Middleware

Open bootstrap/app.php and register middleware alias:

'firewall' => \App\Http\Middleware\FirewallMiddleware::class

This allows usage like:

Route::middleware('firewall')->group(function () {
// protected routes
});

---

## STEP 4 – Create Blocked IP Model & Migration

php artisan make:model BlockedIp -m

Blocked IP Table Fields:

* id
* ip_address (unique)
* reason (nullable)
* timestamps

Run migration:

php artisan migrate

---

## STEP 5 – Create Blocked Access Page

Create view:

resources/views/blocked.blade.php

Features:

* Clean UI
* Access denied message
* Contact admin notice
* Styled design

---

## STEP 6 – Protect Routes Using Firewall

Example routes/web.php configuration:

Public Route (No Firewall):

* /info

Protected Routes:

* /
* /dashboard
* /admin

Wrap them inside:

Route::middleware('firewall')->group(function () {
// routes here
});

---

## STEP 7 – Create Firewall Controller

php artisan make:controller FirewallController

Controller Responsibilities:

* index() → Show blocked IP list
* store() → Block new IP
* destroy() → Unblock IP

Validation Rules:

* ip_address required
* must be valid IP
* must be unique
* reason optional

---

## STEP 8 – Create Firewall Management View

Create folder:

resources/views/firewall

Create index.blade.php

Features:

* Add IP form
* List blocked IPs
* Show reason
* Show blocked date
* Unblock button
* Success flash message

---

## STEP 9 – Test Firewall System

Start server:

php artisan serve

Test Protected Routes:

* [http://localhost:8000/](http://localhost:8000/)
* <img width="1434" height="458" alt="image" src="https://github.com/user-attachments/assets/7cad9fef-fe93-4a64-806d-dc361650692c" />
* [http://localhost:8000/dashboard](http://localhost:8000/dashboard)
*<img width="1383" height="952" alt="image" src="https://github.com/user-attachments/assets/18a4fe56-f038-4118-b89a-8ebbf18bc060" />
* [http://localhost:8000/admin](http://localhost:8000/admin)
<img width="931" height="327" alt="image" src="https://github.com/user-attachments/assets/f87b21c2-1012-43d0-ba66-3d4e1fde6ed6" />

Block Your IP Using Tinker:

php artisan tinker

App\Models\BlockedIp::create([
'ip_address' => '127.0.0.1',
'reason' => 'Testing firewall'
]);

Refresh browser → Access Denied page should appear.

---

## STEP 10 – Add Sample Data (Optional)

Add more blocked IPs via Tinker:

App\Models\BlockedIp::create(['ip_address' => '192.168.1.1', 'reason' => 'Suspicious activity']);
App\Models\BlockedIp::create(['ip_address' => '10.0.0.1', 'reason' => 'Brute force attempt']);
App\Models\BlockedIp::create(['ip_address' => '172.16.0.1', 'reason' => 'Spam source']);

---

## FEATURES IMPLEMENTED

* IP Address Blocking
* Middleware Route Protection
* Admin Management Panel
* Custom Blocked Page
* Database Storage
* Validation

---

## HOW IT WORKS INTERNALLY

1. User visits protected route
2. FirewallMiddleware captures IP
3. Database checks blocked_ips table
4. If match found → blocked view returned
5. If no match → request proceeds

---

## PROJECT STRUCTURE SUMMARY

laravel-firewall/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── FirewallController.php
│   │   └── Middleware/
│   │       └── FirewallMiddleware.php
│   └── Models/
│       └── BlockedIp.php
├── database/
│   └── migrations/
├── resources/
│   └── views/
│       ├── blocked.blade.php
│       └── firewall/index.blade.php
└── routes/web.php

---

## POSSIBLE EXTENSIONS

* Rate limiting
* GeoIP blocking
* Auto block after failed login attempts
* API firewall
* Role-based firewall management
* Logging blocked attempts
* Email notifications

---

## SUMMARY

This Laravel Firewall System demonstrates how to implement a middleware-based security layer using database-driven IP blocking.

It is suitable for:

* Security learning projects
* Admin panel protection
* Custom access control systems
* Portfolio demonstration

End of Documentation
