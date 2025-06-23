# OneSignal Configuration - Bihar Ke Swaad

## Plugin Information
- **Plugin Name**: OneSignal Web Push Notifications
- **Version**: [Latest version installed locally]
- **Installation Date**: June 24, 2025
- **Status**: ✅ Configured and active on live site

## OneSignal App Settings
```
App ID: 8ca02997-acd8-46b6-a3a6-bfd6461f9b4d
API Key: OGY5M2RlNzgtNjNhNS00Y2E0LThlYTYtZjUxNTBkZWU3Y2Ji
App Name: Bihar Ke Swaad
Website URL: https://biharkeswaad.shop
```

## 🔧 Live Site Configuration (Current Settings)

### Advanced Settings
- **Additional Notification URL Parameters**: (blank)
- **Additional Custom Post Types for Automatic Notifications**: (blank)

### Automatic Notification Triggers
- ❌ **Automatically send notifications when a post is published or updated**: Disabled
- ❌ **Automatically send notifications when a page is published or updated**: Disabled
- ✅ **Automatically send a push notification when I publish a post from 3rd party plugins**: Enabled
- ✅ **Send notification to Mobile app subscribers**: Enabled

### Purpose of This Configuration
This setup is specifically optimized for **WooCommerce order notifications**:
- Regular post/page notifications are disabled to prevent spam
- 3rd party plugin notifications enabled for WooCommerce integration
- Mobile app support enabled for wider reach

## Configuration Settings

### Basic Settings
- [x] Web Push enabled
- [x] Safari Web Push enabled (if applicable)
- [ ] Auto-register users
- [x] Show notifications on same origin

### Notification Prompt Settings
- **Prompt Type**: [Subscription Bell / Native Browser / Custom]
- **Prompt Position**: [Top/Bottom Left/Right]
- **Welcome Notification**: [Enabled/Disabled]
- **Welcome Message**: "Welcome to Bihar Ke Swaad! Get notified about your order updates."

### Subscription Settings
- **Auto-prompt**: [Enabled/Disabled]
- **Delay**: [X seconds]
- **Page Views**: [After X page views]

## WooCommerce Integration Settings
- **Order Status Notifications**: [Enabled/Disabled]
- **Notification Triggers**:
  - [ ] Order Confirmed (pending → processing)
  - [ ] Order Shipped (processing → shipped)
  - [ ] Order Delivered (shipped → completed)
  - [ ] Order Cancelled

## Custom Notification Templates

### Order Confirmed
- **Title**: "Order Confirmed - Bihar Ke Swaad"
- **Message**: "Thank you! Your authentic Bihar delicacies are being prepared fresh."

### Order Shipped
- **Title**: "Order Shipped - Bihar Ke Swaad"
- **Message**: "Your order is on its way! Track your package via Shiprocket."

### Order Delivered
- **Title**: "Order Delivered - Bihar Ke Swaad"
- **Message**: "Enjoy your authentic Bihar flavors! Please rate your experience."

## Integration Notes
- **Shiprocket Integration**: [Details about tracking link integration]
- **Custom Code Location**: [Theme functions.php or custom plugin]
- **Testing Status**: [Tested/Pending]

## Backup Information
- **Settings Export Date**: [Date]
- **Configuration Backup**: [Location of backup file]
- **Database Tables**: wp_options (onesignal_* entries)

---
*Last Updated: June 24, 2025*
