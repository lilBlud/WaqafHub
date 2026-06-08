# WaqafHub Security Hardening Report

**Student Name:** [Your Name]
**Matric Number:** [Your Matric Number]
**Web App Title:** WaqafHub (IIUM Waqaf)

---

## 1. Context

WaqafHub (IIUM Waqaf) is a web-based platform designed to simplify and organize the process of item donation and requests within the community. It allows users to browse available items (such as Books, Clothes, Food, and Electronics), post demands for specific needs, and coordinate donations securely. The platform aims to foster community support through sharing and giving.

## 2. Security Hardening Objectives

The objective of this project is to thoroughly enhance the security posture of the WaqafHub application as part of the Information Assurance (INFO 3305) requirements. While the original prototype was functional, it lacked essential security controls. The primary goal is to harden the application against common web vulnerabilities and secure user data by implementing industry best practices across six core domains:

1. **Input Validation:** Ensuring all user inputs are strictly validated on both the client and server sides to prevent malformed data entry.
2. **Authentication Hardening:** Securing user login mechanisms, including robust password hashing and secure session management to prevent unauthorized access.
3. **Authorization (RBAC):** Implementing Role-Based Access Control to ensure users can only access resources and actions explicitly permitted by their assigned roles.
4. **XSS & CSRF Prevention:** Protecting the application from Cross-Site Scripting (XSS) by properly sanitizing output and enforcing Anti-CSRF tokens on all state-changing requests.
5. **Database Security:** Eliminating all risks of SQL Injection (SQLi) by replacing raw SQL queries with parameterized queries and utilizing the Eloquent ORM.
6. **File Security & Web Server Configuration:** Securing sensitive environment configurations and ensuring proper directory access controls to prevent file leaks or directory traversal.

---

## 3. Security Enhancements Implemented

### 3.1 Input Validation
To prevent malformed data and injection attacks, both client-side and server-side validation were implemented. Client-side HTML5 attributes (`required`, `type`) improve user experience, while server-side validation acts as the ultimate security gatekeeper.

**Before (Original - Vulnerable):**
```php
public function store(Request $request)
{
    // Vulnerability: Blindly accepting all user input without validation
    Item::create([
        'user_id' => Auth::id(),
        'title' => $request->title,
        'category' => $request->category,
        'description' => $request->description,
        // ...
    ]);
}
```

**After (Enhanced - Secured):**
```php
public function store(Request $request)
{
    // Enhancement: Strict server-side validation using Laravel's validation rules
    $request->validate([
        'title' => 'required|string|max:255',
        'category' => 'required|string',
        'location' => 'required|string',
        'condition' => 'required|string',
        'description' => 'required|string',
        'images' => 'required|array|max:5',
        'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
    ]);

    // Item creation logic proceeds only if validation passes
}
```

### 3.2 Authentication Hardening
Authentication was hardened by ensuring passwords are securely hashed via Laravel's built-in `Hash::make()` (bcrypt) mechanism and reinforcing session security in `config/session.php`.

**Before (Original - Vulnerable):**
```php
// Vulnerable session configuration (config/session.php)
'secure' => env('SESSION_SECURE_COOKIE', false),
'http_only' => false,
'same_site' => null,
```

**After (Enhanced - Secured):**
```php
// Enhanced session configuration to prevent session hijacking (config/session.php)
'secure' => env('SESSION_SECURE_COOKIE', true), // Enforce HTTPS cookies
'http_only' => true, // Prevent JavaScript access to session cookie (mitigates XSS)
'same_site' => 'lax', // Mitigates CSRF attacks
```

### 3.3 Authorization (RBAC)
Role-Based Access Control (RBAC) was introduced to restrict administrative functionalities. An `admin` middleware was created and applied strictly to administrative routes.

**Before (Original - Vulnerable):**
```php
// Vulnerability: Admin routes exposed without proper role checks (routes/web.php)
Route::get('/admin/review', [AdminController::class, 'reviewIndex'])->name('admin.review');
Route::post('/admin/items/{item}/approve', [AdminController::class, 'approve']);
```

**After (Enhanced - Secured):**
```php
// Enhancement: Admin routes shielded by an 'admin' middleware (routes/web.php)
Route::middleware('admin')->group(function () {
    Route::get('/admin/review', [AdminController::class, 'reviewIndex'])->name('admin.review');
    Route::post('/admin/items/{item}/approve', [AdminController::class, 'approve'])->name('admin.items.approve');
    Route::post('/admin/items/{item}/decline', [AdminController::class, 'decline'])->name('admin.items.decline');
});
```

### 3.4 XSS & CSRF Prevention
Cross-Site Scripting (XSS) is prevented by utilizing Blade's `{{ }}` syntax, which automatically runs `htmlspecialchars()` on output. Cross-Site Request Forgery (CSRF) is blocked by including `@csrf` tokens in all state-changing forms.

**Before (Original - Vulnerable):**
```html
<!-- Vulnerability: Unescaped output and missing CSRF token -->
<form method="POST" action="/items">
    <input type="text" name="title">
    <button type="submit">Submit</button>
</form>
<div>{!! $item->description !!}</div>
```

**After (Enhanced - Secured):**
```html
<!-- Enhancement: Escaped output and CSRF token included -->
<form method="POST" action="{{ route('items.store') }}">
    @csrf
    <input type="text" name="title" required>
    <button type="submit">Submit</button>
</form>
<div>{{ $item->description }}</div>
```

### 3.5 Database Security
To eliminate SQL Injection (SQLi) vulnerabilities, all database interactions were refactored to strictly use Laravel's Eloquent ORM, which inherently utilizes PDO parameter binding.

**Before (Original - Vulnerable):**
```php
// Vulnerability: Raw SQL query susceptible to SQL Injection
$title = $_POST['title'];
$items = DB::select(DB::raw("SELECT * FROM items WHERE title = '$title'"));
```

**After (Enhanced - Secured):**
```php
// Enhancement: Eloquent ORM using parameterized queries automatically
$items = Item::where('title', $request->title)->get();
```

### 3.6 File Security & Web Server Configuration
The environment configuration was locked down to hide sensitive stack traces from users in a production environment, effectively preventing information leakage.

**Before (Original - Vulnerable):**
```env
# Vulnerability: Debug mode enabled in production (.env)
APP_ENV=production
APP_DEBUG=true
```

**After (Enhanced - Secured):**
```env
# Enhancement: Debug mode safely disabled (.env)
APP_ENV=production
APP_DEBUG=false
```

---

## 4. References

1. **OWASP Foundation. (2021).** *OWASP Top 10:2021*. Retrieved from [https://owasp.org/Top10/](https://owasp.org/Top10/) (Provides the foundation for understanding critical web application security risks).
2. **Laravel. (n.d.).** *Laravel Security Documentation*. Retrieved from [https://laravel.com/docs/master/security](https://laravel.com/docs/master/security) (Official best practices for implementing Authentication, Authorization, and Encryption in Laravel).
3. **OWASP Foundation. (n.d.).** *Cross-Site Request Forgery (CSRF) Prevention Cheat Sheet*. Retrieved from [https://cheatsheetseries.owasp.org/cheatsheets/Cross-Site_Request_Forgery_Prevention_Cheat_Sheet.html](https://cheatsheetseries.owasp.org/cheatsheets/Cross-Site_Request_Forgery_Prevention_Cheat_Sheet.html) (Detailed guidance on preventing CSRF attacks, relevant to the implemented form tokens).

---