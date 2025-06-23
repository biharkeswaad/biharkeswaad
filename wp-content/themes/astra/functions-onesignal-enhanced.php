<?php
/**
 * Bihar Ke Swaad - Enhanced OneSignal Integration with Shiprocket
 * 
 * Advanced notification system with tracking integration
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class BiharKeSwaadNotifications {
    
    private $onesignal_app_id = '8ca02997-acd8-46b6-a3a6-bfd6461f9b4d';
    private $onesignal_api_key = 'OGY5M2RlNzgtNjNhNS00Y2E0LThlYTYtZjUxNTBkZWU3Y2Ji';
    
    public function __construct() {
        add_action('woocommerce_order_status_changed', array($this, 'handle_order_status_change'), 10, 3);
        add_action('woocommerce_new_order', array($this, 'handle_new_order'), 10, 1);
        add_action('admin_init', array($this, 'handle_test_notification'));
        add_action('admin_notices', array($this, 'show_admin_notice'));
        
        // Add custom order meta hooks for Shiprocket
        add_action('woocommerce_order_status_shipped', array($this, 'add_tracking_notification'), 20, 1);
    }
    
    /**
     * Handle order status changes
     */
    public function handle_order_status_change($order_id, $old_status, $new_status) {
        $order = wc_get_order($order_id);
        
        if (!$order) {
            return;
        }
        
        // Don't send notification for admin-initiated changes (optional)
        if (is_admin() && !wp_doing_cron()) {
            // Log for admin reference
            error_log("Bihar Ke Swaad: Order #{$order_id} status changed from {$old_status} to {$new_status} by admin");
        }
        
        $this->send_status_notification($order, $old_status, $new_status);
    }
    
    /**
     * Handle new orders
     */
    public function handle_new_order($order_id) {
        $order = wc_get_order($order_id);
        
        if ($order && in_array($order->get_status(), array('pending', 'processing'))) {
            $this->send_welcome_notification($order);
        }
    }
    
    /**
     * Send status-specific notifications
     */
    private function send_status_notification($order, $old_status, $new_status) {
        $order_id = $order->get_id();
        $customer_name = $order->get_billing_first_name();
        $customer_email = $order->get_billing_email();
        $order_total = $order->get_formatted_order_total();
        
        $notifications = array(
            'processing' => array(
                'heading' => '🍽️ Order Confirmed - Bihar Ke Swaad',
                'message' => "Namaste {$customer_name}! Your authentic Bihar delicacies ({$order_total}) are being prepared fresh with love. Order #{$order_id}",
                'url' => $order->get_view_order_url(),
                'large_icon' => 'https://biharkeswaad.shop/wp-content/uploads/2025/01/order-confirmed.png'
            ),
            'shipped' => array(
                'heading' => '🚚 Order Shipped - Bihar Ke Swaad',
                'message' => "Great news {$customer_name}! Your Bihar Ke Swaad order #{$order_id} is on its way. Track your authentic flavors journey!",
                'url' => $this->get_tracking_url($order),
                'large_icon' => 'https://biharkeswaad.shop/wp-content/uploads/2025/01/order-shipped.png'
            ),
            'completed' => array(
                'heading' => '✨ Order Delivered - Bihar Ke Swaad',
                'message' => "Enjoy your authentic Bihar flavors {$customer_name}! We hope you love every bite. Share your experience with us! 🌟",
                'url' => $order->get_view_order_url() . '&review=1',
                'large_icon' => 'https://biharkeswaad.shop/wp-content/uploads/2025/01/order-delivered.png'
            ),
            'cancelled' => array(
                'heading' => '❌ Order Cancelled - Bihar Ke Swaad',
                'message' => "Sorry {$customer_name}, order #{$order_id} has been cancelled. Contact us for assistance or place a new order!",
                'url' => home_url('/contact/'),
                'large_icon' => 'https://biharkeswaad.shop/wp-content/uploads/2025/01/order-cancelled.png'
            ),
            'on-hold' => array(
                'heading' => '⏳ Payment Pending - Bihar Ke Swaad',
                'message' => "Hi {$customer_name}, your order #{$order_id} is waiting for payment. Complete payment to enjoy authentic Bihar cuisine!",
                'url' => $order->get_checkout_payment_url(),
                'large_icon' => 'https://biharkeswaad.shop/wp-content/uploads/2025/01/payment-pending.png'
            ),
            'refunded' => array(
                'heading' => '💰 Refund Processed - Bihar Ke Swaad',
                'message' => "Hi {$customer_name}, your refund for order #{$order_id} has been processed. Amount will reflect in 3-5 business days.",
                'url' => $order->get_view_order_url(),
                'large_icon' => 'https://biharkeswaad.shop/wp-content/uploads/2025/01/refund-processed.png'
            )
        );
        
        if (isset($notifications[$new_status]) && $this->should_send_notification($old_status, $new_status)) {
            $this->send_push_notification($notifications[$new_status], $customer_email, $order);
        }
    }
    
    /**
     * Send welcome notification for new orders
     */
    private function send_welcome_notification($order) {
        $customer_name = $order->get_billing_first_name();
        $customer_email = $order->get_billing_email();
        $order_id = $order->get_id();
        
        $notification = array(
            'heading' => '🙏 Thank You - Bihar Ke Swaad',
            'message' => "Thank you {$customer_name}! Your order #{$order_id} is received. We're excited to bring authentic Bihar flavors to your table!",
            'url' => $order->get_view_order_url(),
            'large_icon' => 'https://biharkeswaad.shop/wp-content/uploads/2025/01/welcome-order.png'
        );
        
        $this->send_push_notification($notification, $customer_email, $order);
    }
    
    /**
     * Get Shiprocket tracking URL
     */
    private function get_tracking_url($order) {
        // Check if Shiprocket tracking info exists
        $tracking_id = $order->get_meta('_shiprocket_tracking_id');
        $awb_code = $order->get_meta('_shiprocket_awb_code');
        
        if ($tracking_id && $awb_code) {
            return "https://shiprocket.co/tracking/{$awb_code}";
        }
        
        // Fallback to order tracking page
        return $order->get_view_order_url();
    }
    
    /**
     * Check if notification should be sent
     */
    private function should_send_notification($old_status, $new_status) {
        $valid_transitions = array(
            'pending' => array('processing', 'on-hold', 'cancelled'),
            'processing' => array('shipped', 'completed', 'cancelled', 'refunded'),
            'shipped' => array('completed'),
            'on-hold' => array('processing', 'cancelled'),
            'failed' => array('processing', 'cancelled')
        );
        
        return isset($valid_transitions[$old_status]) && 
               in_array($new_status, $valid_transitions[$old_status]);
    }
    
    /**
     * Send push notification via OneSignal
     */
    private function send_push_notification($notification_data, $customer_email, $order = null) {
        $fields = array(
            'app_id' => $this->onesignal_app_id,
            'headings' => array('en' => $notification_data['heading']),
            'contents' => array('en' => $notification_data['message']),
            'url' => $notification_data['url'],
            'chrome_web_icon' => $notification_data['large_icon'],
            'firefox_icon' => $notification_data['large_icon'],
            'chrome_icon' => $notification_data['large_icon'],
            'large_icon' => $notification_data['large_icon'],
            'included_segments' => array('All'),
            'data' => array(
                'source' => 'bihar_ke_swaad',
                'type' => 'order_update',
                'customer_email' => $customer_email,
                'timestamp' => current_time('timestamp'),
                'order_id' => $order ? $order->get_id() : null
            ),
            // Custom styling
            'android_accent_color' => 'FF9900',
            'chrome_web_badge' => get_site_icon_url(96),
            'priority' => 10
        );
        
        // Add order-specific data if available
        if ($order) {
            $fields['data']['order_total'] = $order->get_total();
            $fields['data']['order_status'] = $order->get_status();
        }
        
        $response = wp_remote_post('https://onesignal.com/api/v1/notifications', array(
            'headers' => array(
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . $this->onesignal_api_key
            ),
            'body' => json_encode($fields),
            'timeout' => 30
        ));
        
        // Enhanced logging
        if (is_wp_error($response)) {
            error_log('Bihar Ke Swaad OneSignal Error: ' . $response->get_error_message());
            return false;
        } else {
            $response_body = wp_remote_retrieve_body($response);
            $response_data = json_decode($response_body, true);
            
            if (isset($response_data['id'])) {
                error_log("Bihar Ke Swaad OneSignal Success: Notification sent with ID {$response_data['id']}");
                
                // Save notification log to order meta
                if ($order) {
                    $order->add_meta_data('_onesignal_notification_' . time(), array(
                        'notification_id' => $response_data['id'],
                        'heading' => $notification_data['heading'],
                        'message' => $notification_data['message'],
                        'sent_at' => current_time('mysql')
                    ));
                    $order->save();
                }
                
                return true;
            } else {
                error_log('Bihar Ke Swaad OneSignal Error: ' . $response_body);
                return false;
            }
        }
    }
    
    /**
     * Handle test notifications
     */
    public function handle_test_notification() {
        if (current_user_can('manage_options') && isset($_GET['test_bihar_notification'])) {
            $test_data = array(
                'heading' => '🧪 Test Notification - Bihar Ke Swaad',
                'message' => 'This is a test notification! Your OneSignal integration is working perfectly. 🎉',
                'url' => admin_url(),
                'large_icon' => get_site_icon_url(256) ?: 'https://biharkeswaad.shop/wp-content/uploads/2025/01/test-icon.png'
            );
            
            $result = $this->send_push_notification($test_data, get_option('admin_email'));
            
            if ($result) {
                wp_die('<h1>✅ Test Notification Sent!</h1><p>Check your browser for the push notification. If you don\'t see it, make sure you\'ve subscribed to notifications on your website.</p><p><a href="' . admin_url() . '">← Back to Admin</a></p>');
            } else {
                wp_die('<h1>❌ Test Failed</h1><p>There was an error sending the test notification. Check error logs for details.</p><p><a href="' . admin_url() . '">← Back to Admin</a></p>');
            }
        }
    }
    
    /**
     * Show admin notice with test button
     */
    public function show_admin_notice() {
        if (current_user_can('manage_options') && !isset($_GET['test_bihar_notification'])) {
            $test_url = add_query_arg('test_bihar_notification', '1', admin_url('admin.php'));
            echo '<div class="notice notice-success is-dismissible">';
            echo '<p><strong>🍽️ Bihar Ke Swaad OneSignal Integration Active!</strong> ';
            echo 'Order notifications are ready to delight your customers. ';
            echo '<a href="' . esc_url($test_url) . '" class="button button-secondary">Send Test Notification</a>';
            echo '</p></div>';
        }
    }
    
    /**
     * Add tracking notification when Shiprocket updates
     */
    public function add_tracking_notification($order_id) {
        $order = wc_get_order($order_id);
        
        if (!$order) {
            return;
        }
        
        // Wait a bit for Shiprocket to update tracking info
        wp_schedule_single_event(time() + 300, 'bihar_send_tracking_notification', array($order_id)); // 5 minutes delay
    }
}

// Initialize the notification system
new BiharKeSwaadNotifications();

/**
 * Send tracking notification (scheduled)
 */
add_action('bihar_send_tracking_notification', function($order_id) {
    $order = wc_get_order($order_id);
    $customer_name = $order->get_billing_first_name();
    $customer_email = $order->get_billing_email();
    
    $tracking_id = $order->get_meta('_shiprocket_tracking_id');
    $awb_code = $order->get_meta('_shiprocket_awb_code');
    
    if ($tracking_id && $awb_code) {
        $notification = array(
            'heading' => '📦 Track Your Order - Bihar Ke Swaad',
            'message' => "Hi {$customer_name}! Your order is now trackable. AWB: {$awb_code}. Click to track your authentic Bihar delicacies!",
            'url' => "https://shiprocket.co/tracking/{$awb_code}",
            'large_icon' => 'https://biharkeswaad.shop/wp-content/uploads/2025/01/tracking-icon.png'
        );
        
        $notification_system = new BiharKeSwaadNotifications();
        $notification_system->send_push_notification($notification, $customer_email, $order);
    }
});

/**
 * Add custom order tracking info to account page
 */
add_action('woocommerce_view_order', function($order_id) {
    $order = wc_get_order($order_id);
    $awb_code = $order->get_meta('_shiprocket_awb_code');
    
    if ($awb_code) {
        echo '<div class="bihar-tracking-info" style="background: #f8f9fa; padding: 15px; border-radius: 5px; margin: 20px 0;">';
        echo '<h3>📦 Track Your Bihar Ke Swaad Order</h3>';
        echo '<p>AWB Code: <strong>' . esc_html($awb_code) . '</strong></p>';
        echo '<a href="https://shiprocket.co/tracking/' . esc_attr($awb_code) . '" target="_blank" class="button">Track Package</a>';
        echo '</div>';
    }
}, 20);
