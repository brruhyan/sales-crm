# Production Docker 401 Unauthorized Fix - Livewire File Uploads

## Problem Summary
**Error**: `POST https://aksyonsales.maralabs.ph/livewire/upload-file?expires=...&signature=... 401 (Unauthorized)`

**Symptom**: File uploads work fine in **Local Herd environment** but fail with **401 Unauthorized** in **Docker Production**.

**Root Causes Identified**:
1. ✅ **Syntax Error in AppServiceProvider.php** - Missing closing brace
2. ✅ **Missing Trusted Proxies Configuration** - Docker behind reverse proxy
3. ✅ **Insecure Session Configuration** - Missing encryption and security flags
4. ✅ **Wrong APP_URL** - Local URL in production environment

---

## Issues Fixed

### 1. **AppServiceProvider.php Syntax Error**
**File**: `app/Providers/AppServiceProvider.php`
- **Problem**: Missing closing brace in the `if()` statement for production check
- **Status**: ✅ **FIXED**
- **Impact**: This prevented the `URL::forceScheme('https')` from being set properly in production

### 2. **Bootstrap Trusted Proxies**
**File**: `bootstrap/app.php`
- **Problem**: No trusted proxy configuration for Docker/reverse proxy scenarios
- **Solution**: Added middleware configuration:
```php
->withMiddleware(function (Middleware $middleware): void {
    // Trust all proxies in Docker/production
    $middleware->trustProxies(at: '*');
})
```
- **Why**: When running behind Docker's reverse proxy or nginx, the app must trust the proxy headers to correctly identify the client IP and HTTPS status
- **Status**: ✅ **FIXED**

### 3. **Session Security Configuration**
**File**: `.env`
- **Changes Made**:
  ```env
  # BEFORE (Insecure)
  SESSION_ENCRYPT=false
  SESSION_PATH=/
  SESSION_DOMAIN=null
  
  # AFTER (Secure)
  SESSION_ENCRYPT=true
  SESSION_PATH=/
  SESSION_DOMAIN=.maralabs.ph
  SESSION_SECURE=true
  SESSION_HTTP_ONLY=true
  SESSION_SAME_SITE=lax
  ```
- **Why These Changes**:
  - `SESSION_ENCRYPT=true`: Encrypts session data to prevent tampering
  - `SESSION_DOMAIN=.maralabs.ph`: Sets domain for cross-subdomain cookie sharing
  - `SESSION_SECURE=true`: Cookies only sent over HTTPS (production)
  - `SESSION_HTTP_ONLY=true`: Prevents JavaScript access to session cookies
  - `SESSION_SAME_SITE=lax`: Protects against CSRF attacks
- **Status**: ✅ **FIXED**

### 4. **APP_URL Mismatch**
**File**: `.env`
- **Problem**: `APP_URL=http://localhost` doesn't match production domain
- **Solution**: Changed to `APP_URL=https://aksyonsales.maralabs.ph`
- **Why**: 
  - Livewire uses APP_URL to generate upload endpoints
  - Session cookies use APP_URL domain for generation
  - CSRF token validation uses APP_URL for verification
- **Status**: ✅ **FIXED**

---

## Why 401 Occurs in Production

### The Livewire Upload Flow:
1. Browser sends file upload request to `/livewire/upload-file` with **session cookie**
2. Laravel Filament receives request and validates:
   - ✓ CSRF token (from header or form)
   - ✓ Session authentication (from cookies)
   - ✓ User authentication (from session)
3. If session/auth fails → **401 Unauthorized**

### Why It Fails in Docker But Works Locally:

| Factor | Herd (Local) | Docker (Production) | Impact |
|--------|-------------|-------------------|--------|
| **APP_URL** | `http://localhost` | `http://localhost` (Wrong!) | Session domain mismatch |
| **Session Encryption** | Disabled | Disabled (Insecure) | May cause serialization issues |
| **HTTPS** | Not enforced | Should be enforced | Proxy headers not trusted |
| **Trusted Proxies** | Not needed | Missing! | Can't identify real client |
| **Cookie Domain** | `localhost` | `localhost` (Wrong!) | Cookies not sent to `maralabs.ph` |

### The 401 Chain of Failure:
```
Request to: https://aksyonsales.maralabs.ph/livewire/upload-file
   ↓
Django reads session cookie from domain: .maralabs.ph
   ↓
BUT session was created with domain: localhost
   ↓
Cookie doesn't match → Session not found
   ↓
Auth middleware runs: Auth::check() returns FALSE
   ↓
Route is protected → 401 UNAUTHORIZED
```

---

## Production Docker Setup Checklist

### ✅ Already Fixed:
- [x] AppServiceProvider syntax error
- [x] Trusted proxies middleware
- [x] Session encryption enabled
- [x] APP_URL set to production domain
- [x] Session security cookies configured

### 📋 For Your Docker Deployment:

1. **Environment Variables** - Ensure in your `.env` on server:
   ```env
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://aksyonsales.maralabs.ph
   SESSION_ENCRYPT=true
   SESSION_DOMAIN=.maralabs.ph
   SESSION_SECURE=true
   SESSION_SECURE_COOKIE=true
   ```

2. **Database Migrations** - Run after deployment:
   ```bash
   docker-compose exec laravel.test php artisan migrate
   ```

3. **Cache Configuration** - Important for production:
   ```bash
   docker-compose exec laravel.test php artisan config:cache
   docker-compose exec laravel.test php artisan route:cache
   docker-compose exec laravel.test php artisan view:cache
   ```

4. **File Permissions** - Ensure storage is writable:
   ```bash
   docker-compose exec laravel.test chmod -R 775 storage bootstrap/cache
   ```

5. **Sessions Table** - Ensure database has sessions table:
   ```bash
   docker-compose exec laravel.test php artisan session:table
   docker-compose exec laravel.test php artisan migrate
   ```

---

## Testing the Fix

### Test 1: Check Session Cookie
```bash
# Navigate to https://aksyonsales.maralabs.ph/client/login
# Open DevTools → Application → Cookies
# Should see cookie with:
# - Name: aksyonsales-session
# - Domain: .maralabs.ph
# - Secure: ✓ (checked)
# - HttpOnly: ✓ (checked)
# - SameSite: Lax
```

### Test 2: Try File Upload
1. Log in to the client panel
2. Try uploading a document
3. Check browser Network tab for the request to `/livewire/upload-file`
4. Should return **200** instead of **401**

### Test 3: Check Server Logs
```bash
docker-compose logs -f laravel.test
# Look for any authentication or CSRF token errors
```

---

## Migration Path

### Local Development (No Changes Needed):
- Herd will use `http://localhost`
- Session settings work with HTTP
- No HTTPS required

### Docker Production (Apply These Changes):
- ✅ Already applied in this codebase
- Ensure `.env` matches the configuration above
- Run migrations and cache commands

---

## Additional Notes

### Why Trusted Proxies Matter in Docker:
When you run:
```yaml
services:
  app:
    ports: ['80:80']  # External traffic on port 80
  nginx:
    # Reverse proxy that forwards to app
```

The app receives requests from nginx **internally** (X-Forwarded-For headers), not from the real client. Without trusting the proxy, Laravel thinks:
- Client is nginx (127.0.0.1)
- Protocol is HTTP (not HTTPS from original request)
- This breaks HTTPS-only session cookies

### Why APP_URL Must Match:
Livewire generates upload URLs using:
```php
URL::signedRoute('livewire.upload-file', ...)
```
This generates URLs based on APP_URL. If APP_URL doesn't match the actual domain:
- The signature becomes invalid
- CORS checks fail
- Session cookies don't match
- Result: 401 Unauthorized

---

## Files Modified

1. ✅ `app/Providers/AppServiceProvider.php` - Fixed syntax error
2. ✅ `bootstrap/app.php` - Added trusted proxies
3. ✅ `.env` - Updated session and URL configuration
4. ✅ `config/session.php` - Updated secure cookie logic

---

## Still Having Issues?

If you still get 401 errors, check:

1. **Cache**: Clear all caches
   ```bash
   docker-compose exec laravel.test php artisan cache:clear
   docker-compose exec laravel.test php artisan config:clear
   ```

2. **Database**: Check sessions table exists
   ```bash
   docker-compose exec laravel.test php artisan tinker
   >>> DB::table('sessions')->count()
   ```

3. **Logs**: Check Laravel logs
   ```bash
   docker-compose exec laravel.test tail -f storage/logs/laravel.log
   ```

4. **Browser**: Clear cookies and session storage, then try again

5. **Rebuild**: Rebuild Docker image with fresh environment
   ```bash
   docker-compose down
   docker-compose up --build
   ```
