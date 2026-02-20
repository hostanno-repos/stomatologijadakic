# Troubleshooting .htaccess Issues in WAMP

## Common Issues and Solutions

### Issue: Internal Server Error (500)

This usually means there's a syntax error in `.htaccess` or a required Apache module is not enabled.

### Solution 1: Enable mod_rewrite in WAMP

1. Click on the WAMP icon in the system tray
2. Go to: **Apache → Apache modules**
3. Check: **rewrite_module**
4. Restart Apache (click WAMP icon → Restart All Services)

### Solution 2: Check Apache Error Log

1. Click on the WAMP icon
2. Go to: **Apache → Apache error log**
2. Look for the most recent error related to `.htaccess`
3. Common errors:
   - `Invalid command 'Order'` → Apache 2.4 syntax issue (fixed in new .htaccess)
   - `mod_rewrite not enabled` → Enable rewrite_module (Solution 1)
   - `RewriteBase: argument is not a valid URL` → Path issue

### Solution 3: Verify .htaccess Syntax

The current `.htaccess` uses Apache 2.4 syntax:
- ✅ `Require all denied` (Apache 2.4)
- ❌ `Order Allow,Deny` (Apache 2.2 - old)

### Solution 4: Test mod_rewrite

1. Access: `http://localhost/dakic_cms/admin/test_rewrite.php`
2. Check if mod_rewrite is loaded
3. If not, follow Solution 1

### Solution 5: Alternative - Use Simple .htaccess

If mod_rewrite still doesn't work:

1. Rename `.htaccess` to `.htaccess.backup`
2. Rename `.htaccess.simple` to `.htaccess`
3. Access files directly: `http://localhost/dakic_cms/admin/index.php`

### Solution 6: Check AllowOverride in Apache Config

1. Find your Apache httpd.conf (usually in `C:\wamp64\bin\apache\apache2.4.x\conf\`)
2. Look for your `<Directory>` block for the document root
3. Make sure it has: `AllowOverride All`
4. Restart Apache

### Solution 7: Verify Document Root Path

The `.htaccess` uses `RewriteBase /dakic_cms/admin/`

If your WAMP document root is different, you may need to adjust this. Check:
- Your WAMP document root path
- The actual URL you're accessing

## Testing Steps

1. **Test 1:** Access `http://localhost/dakic_cms/admin/test_rewrite.php`
   - Should show mod_rewrite status

2. **Test 2:** Access `http://localhost/dakic_cms/admin/index.php`
   - Should work (direct file access)

3. **Test 3:** Access `http://localhost/dakic_cms/admin/auth/login`
   - Should route through index.php if mod_rewrite works
   - If not, you'll get 404 or 500 error

## Quick Fix Checklist

- [ ] mod_rewrite enabled in WAMP
- [ ] Apache restarted after enabling mod_rewrite
- [ ] `.htaccess` uses Apache 2.4 syntax
- [ ] `AllowOverride All` in Apache config
- [ ] No syntax errors in `.htaccess`
- [ ] Correct RewriteBase path

## Still Having Issues?

If none of the above work:

1. Check Apache error log for specific error messages
2. Try the simple `.htaccess` version
3. Consider accessing files directly without URL rewriting
4. Verify your WAMP installation is working correctly
