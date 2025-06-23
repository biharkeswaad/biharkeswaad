# OneSignal Sync Verification Script

## Quick Check Commands

### 1. Verify Plugin Installation
```powershell
# Check if OneSignal plugin directory exists
Test-Path "d:\wordpress\biharkeswaad\public_html\wp-content\plugins\onesignal-free-web-push-notifications"
```

### 2. Check Plugin Files
```powershell
# List OneSignal plugin files
Get-ChildItem "d:\wordpress\biharkeswaad\public_html\wp-content\plugins\onesignal-free-web-push-notifications" -Recurse | Select-Object Name, Length
```

### 3. WordPress Configuration Steps
Once your local WordPress is running:

1. **Access WordPress Admin**: `http://localhost/wp-admin`
2. **Go to Plugins**: Plugins > Installed Plugins
3. **Activate OneSignal**: Click "Activate" for OneSignal Web Push Notifications
4. **Configure Settings**: OneSignal Push > Configuration
   - Enter App ID: `8ca02997-acd8-46b6-a3a6-bfd6461f9b4d`
   - Enter API Key: `OGY5M2RlNzgtNjNhNS00Y2E0LThlYTYtZjUxNTBkZWU3Y2Ji`
5. **Set Advanced Options**: OneSignal Push > Advanced Options
   - ❌ Disable auto-send for posts
   - ❌ Disable auto-send for pages
   - ✅ Enable 3rd party plugin notifications
   - ✅ Enable mobile app subscribers

### 4. Database Sync (Alternative Method)
If you have access to live database, export OneSignal settings:

```sql
-- Export OneSignal settings from live database
SELECT option_name, option_value 
FROM wp_options 
WHERE option_name LIKE 'onesignal_%'
ORDER BY option_name;
```

### 5. Testing the Setup
After configuration:
1. **Test Notification**: OneSignal Push > Send Notification
2. **Check Subscribers**: OneSignal Push > Subscribers
3. **Verify Integration**: Place a test WooCommerce order

## ✅ Verification Checklist
- [ ] OneSignal plugin installed locally
- [ ] Plugin activated in WordPress admin
- [ ] App ID and API Key configured
- [ ] Advanced settings match live site
- [ ] Test notification sent successfully
- [ ] WooCommerce integration ready for custom hooks

## 🔄 Next Steps
Once OneSignal is configured locally:
1. Add WooCommerce order status hooks
2. Create custom notification templates
3. Test the complete order notification flow
