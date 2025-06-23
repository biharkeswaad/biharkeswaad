<?php
/**
 * Bihar Ke Swaad - OneSignal WooCommerce Integration
 * 
 * This file handles push notifications for order status changes
 * Add this code to your theme's functions.php or create as a custom plugin
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Send OneSignal push notification for WooCommerce order status changes
 */
function bihar_ke_swaad_send_order_notification($order_id, $old_status, $new_status) {
    // Get order details
    $order = wc_get_order($order_id);
    
    if (!$order) {
        return;
    }
    
    // Get customer details
    $customer_email = $order->get_billing_email();
    $customer_name = $order->get_billing_first_name();
    $order_total = $order->get_total();
    
    // OneSignal configuration
    $onesignal_app_id = '8ca02997-acd8-46b6-a3a6-bfd6461f9b4d';
    $onesignal_api_key = 'OGY5M2RlNzgtNjNhNS00Y2E0LThlYTYtZjUxNTBkZWU3Y2Ji';
    
    // Define notification messages for different statuses
    $notification_data = get_bihar_notification_content($new_status, $order_id, $customer_name, $order_total);
    
    if ($notification_data && should_send_notification($old_status, $new_status)) {
        send_onesignal_notification($notification_data, $customer_email, $onesignal_app_id, $onesignal_api_key);
    }
}

/**
 * Get notification content based on order status
 */
function get_bihar_notification_content($status, $order_id, $customer_name, $order_total) {
    $notifications = array(
        'processing' => array(
            'heading' => 'Order Confirmed - Bihar Ke Swaad 🍽️',
            'message' => "Namaste {$customer_name}! Your authentic Bihar delicacies worth ₹{$order_total} are being prepared fresh with love. Order #{$order_id}",
            'url' => home_url('/my-account/orders/'),
            'icon' => 'https://biharkeswaad.shop/wp-content/uploads/2025/01/favicon.png'
        ),
        'shipped' => array(
            'heading' => 'Order Shipped - Bihar Ke Swaad 🚚',
            'message' => "Great news {$customer_name}! Your Bihar Ke Swaad order #{$order_id} is on its way via Shiprocket. Track your authentic flavors!",
            'url' => home_url('/my-account/orders/'),
            'icon' => 'https://biharkeswaad.shop/wp-content/uploads/2025/01/shipping-icon.png'
        ),
        'completed' => array(
            'heading' => 'Order Delivered - Bihar Ke Swaad ✨',
            'message' => "Enjoy your authentic Bihar flavors {$customer_name}! We hope you love every bite. Please share your experience! 🌟",
            'url' => home_url('/my-account/orders/'),
            'icon' => 'https://biharkeswaad.shop/wp-content/uploads/2025/01/delivered-icon.png'
        ),
        'cancelled' => array(
            'heading' => 'Order Cancelled - Bihar Ke Swaad',
            'message' => "Sorry {$customer_name}, your order #{$order_id} has been cancelled. Contact us at support@biharkeswaad.shop for assistance.",
            'url' => home_url('/contact/'),
            'icon' => 'https://biharkeswaad.shop/wp-content/uploads/2025/01/cancel-icon.png'
        ),
        'on-hold' => array(
            'heading' => 'Payment Pending - Bihar Ke Swaad ⏳',
            'message' => "Hi {$customer_name}, your order #{$order_id} is on hold. Please complete your payment to enjoy authentic Bihar cuisine!",
            'url' => $order->get_checkout_payment_url(),
            'icon' => 'https://biharkeswaad.shop/wp-content/uploads/2025/01/payment-icon.png'
        )
    );
    
    return isset($notifications[$status]) ? $notifications[$status] : null;
}

/**
 * Check if notification should be sent for this status change
 */
function should_send_notification($old_status, $new_status) {
    // Define which status changes should trigger notifications
    $notification_triggers = array(
        'pending' => array('processing', 'on-hold'),
        'processing' => array('shipped', 'completed', 'cancelled'),
        'shipped' => array('completed'),
        'on-hold' => array('processing', 'cancelled'),
        'failed' => array('processing')
    );
    
    return isset($notification_triggers[$old_status]) && 
           in_array($new_status, $notification_triggers[$old_status]);
}

/**
 * Send notification via OneSignal API
 */
function send_onesignal_notification($notification_data, $customer_email, $app_id, $api_key) {
    $heading = $notification_data['heading'];
    $message = $notification_data['message'];
    $url = $notification_data['url'];
    $icon = $notification_data['icon'];
    
    // OneSignal API payload
    $fields = array(
        'app_id' => $app_id,
        'headings' => array('en' => $heading),
        'contents' => array('en' => $message),
        'url' => $url,
        'chrome_web_icon' => $icon,
        'firefox_icon' => $icon,
        'chrome_icon' => $icon,
        'included_segments' => array('All'), // Send to all subscribers
        // Optionally filter by email if you have email-based segmentation
        // 'filters' => array(
        //     array('field' => 'email', 'value' => $customer_email)
        // ),
        'data' => array(
            'order_type' => 'woocommerce',
            'customer_email' => $customer_email,
            'timestamp' => current_time('timestamp')
        )
    );
    
    // Send to OneSignal
    $response = wp_remote_post('https://onesignal.com/api/v1/notifications', array(
        'headers' => array(
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic ' . $api_key
        ),
        'body' => json_encode($fields),
        'timeout' => 30
    ));
    
    // Log the response for debugging
    if (is_wp_error($response)) {
        error_log('Bihar Ke Swaad OneSignal Error: ' . $response->get_error_message());
    } else {
        $response_body = wp_remote_retrieve_body($response);
        error_log('Bihar Ke Swaad OneSignal Response: ' . $response_body);
    }
    
    return $response;
}

/**
 * Hook into WooCommerce order status changes
 */
add_action('woocommerce_order_status_changed', 'bihar_ke_swaad_send_order_notification', 10, 3);

/**
 * Optional: Send notification when order is first created
 */
function bihar_ke_swaad_new_order_notification($order_id) {
    $order = wc_get_order($order_id);
    
    if ($order && $order->get_status() === 'pending') {
        // Send welcome notification for new orders
        bihar_ke_swaad_send_order_notification($order_id, '', 'pending-created');
    }
}
add_action('woocommerce_new_order', 'bihar_ke_swaad_new_order_notification', 10, 1);

/**
 * Admin function to test notifications
 */
function bihar_ke_swaad_test_notification() {
    if (current_user_can('manage_options') && isset($_GET['test_bihar_notification'])) {
        $test_data = array(
            'heading' => 'Test Notification - Bihar Ke Swaad 🧪',
            'message' => 'This is a test notification to verify OneSignal integration is working properly!',
            'url' => home_url(),
            'icon' => get_site_icon_url()
        );
        
        $app_id = '8ca02997-acd8-46b6-a3a6-bfd6461f9b4d';
        $api_key = 'OGY5M2RlNzgtNjNhNS00Y2E0LThlYTYtZjUxNTBkZWU3Y2Ji';
        
        $response = send_onesignal_notification($test_data, 'test@biharkeswaad.shop', $app_id, $api_key);
        
        if (!is_wp_error($response)) {
            wp_die('Test notification sent! Check your browser for the push notification.');
        } else {
            wp_die('Error sending test notification: ' . $response->get_error_message());
        }
    }
}
add_action('admin_init', 'bihar_ke_swaad_test_notification');

// Add admin notice for testing
function bihar_ke_swaad_admin_notice() {
    if (current_user_can('manage_options')) {
        $test_url = admin_url('admin.php?test_bihar_notification=1');
        echo '<div class="notice notice-info"><p>';
        echo 'Bihar Ke Swaad OneSignal Integration is active! ';
        echo '<a href="' . $test_url . '" class="button">Send Test Notification</a>';
        echo '</p></div>';
    }
}
add_action('admin_notices', 'bihar_ke_swaad_admin_notice');
