# Bihar Ke Swaad - E-commerce Website

> **Anupama Ke Saath** - Authentic Bihar Cuisine Online

A WordPress-based e-commerce platform specializing in handcrafted, traditional Bihar food products. This website serves as an online marketplace for authentic Bihari cuisine, offering fresh, made-to-order food items with nationwide delivery across India.

## 🌟 Project Overview

**Bihar Ke Swaad** is a food e-commerce business that celebrates the rich culinary heritage of Bihar, India. The platform connects food enthusiasts across the country with authentic Bihari flavors through a user-friendly online shopping experience.

### Key Features

- **Fresh, Made-to-Order Products**: All items are handcrafted and prepared fresh upon order
- **Nationwide Delivery**: Pan-India shipping via Shiprocket logistics
- **WordPress + WooCommerce**: Robust e-commerce functionality
- **Mobile-Responsive Design**: Astra theme for optimal user experience
- **Secure Payments**: Integrated payment gateways including UPI QR codes
- **User Account Management**: Customer registration, login, and order tracking
- **Social Media Integration**: Facebook Pixel and Google Analytics integration
- **Push Notifications**: Real-time order status updates via OneSignal

## 🛠 Tech Stack

### Core Platform
- **CMS**: WordPress (Latest Version)
- **E-commerce**: WooCommerce
- **Theme**: Astra (v4.11.3)
- **Database**: MySQL
- **Server**: PHP 5.3+

### Key Plugins
- **WooCommerce** - E-commerce functionality
- **Astra Sites** - Website templates and design
- **Jetpack** - Security and performance
- **LiteSpeed Cache** - Performance optimization
- **Google Site Kit** - Analytics and SEO
- **Ultimate Member** - User management
- **Shiprocket** - Shipping and logistics
- **Facebook for WooCommerce** - Social commerce
- **UPI QR Code Payment** - Indian payment integration
- **Ultimate Addons for Gutenberg** - Enhanced block editor
- **OneSignal Web Push Notifications** - Push notifications for order updates

## 📁 Project Structure

```
public_html/
├── wp-admin/          # WordPress admin interface
├── wp-content/        # Themes, plugins, uploads
│   ├── themes/        # Website themes
│   │   ├── astra/     # Active theme
│   │   └── twenty*/   # Default WordPress themes
│   ├── plugins/       # WordPress plugins
│   └── uploads/       # Media files and assets
├── wp-includes/       # WordPress core files
├── wp-config.php      # WordPress configuration
├── index.php          # Main entry point
└── README.md          # This file
```

## 🚀 Installation & Setup

### Prerequisites
- Web server (Apache/Nginx)
- PHP 5.3 or higher
- MySQL 5.6 or higher
- WordPress compatible hosting

### Deployment (Hostinger)

This project is deployed on Hostinger using Git deployment. When you push to the repository, you may see these informational messages:

```
Looking for composer.lock file
composer.lock file was not found
Looking for composer.json file
composer.json file was not found
```

**This is normal behavior** - these messages are informational, not errors. Hostinger's deployment system checks for Composer dependency management (used in modern PHP frameworks), but WordPress projects typically don't use Composer at the root level. Your deployment will complete successfully despite these messages.

### Local Development Setup

1. **Clone the Repository**
   ```bash
   git clone <repository-url>
   cd biharkeswaad/public_html
   ```

2. **Option A: Full WordPress Setup (Recommended)**
   
   **Using XAMPP:**
   ```powershell
   # Install XAMPP from https://www.apachefriends.org/
   # Copy project to: C:\xampp\htdocs\biharkeswaad\
   # Start Apache and MySQL in XAMPP Control Panel
   # Access: http://localhost/biharkeswaad/
   ```
   
   **Using PHP Built-in Server:**
   ```powershell
   # If PHP is installed locally
   cd "d:\wordpress\biharkeswaad\public_html"
   php -S localhost:8000
   # Access: http://localhost:8000
   ```

3. **Option B: Static File Testing (Python)**
   ```powershell
   # For viewing static files only (limited functionality)
   cd "d:\wordpress\biharkeswaad\public_html"
   python -m http.server 8000
   # Access: http://localhost:8000
   # Note: WordPress dynamic features won't work
   ```

4. **Database Configuration**
   - Create a MySQL database
   - Import existing database or set up fresh installation
   - Update `wp-config.php` with your database credentials

5. **WordPress Configuration**
   ```php
   // Update these in wp-config.php
   define('DB_NAME', 'your_database_name');
   define('DB_USER', 'your_username');
   define('DB_PASSWORD', 'your_password');
   define('DB_HOST', 'localhost');
   ```

6. **File Permissions**
   ```bash
   # Set appropriate permissions
   chmod 644 wp-config.php
   chmod -R 755 wp-content/
   chmod -R 777 wp-content/uploads/
   ```

7. **Plugin Activation**
   - Access WordPress admin (`/wp-admin`)
   - Activate required plugins
   - Configure WooCommerce settings
   - Set up payment gateways

8. **OneSignal Configuration**
   - Install OneSignal Web Push Notifications plugin
   - Configure with settings documented in `onesignal-config.md`
   - App ID: `8ca02997-acd8-46b6-a3a6-bfd6461f9b4d`
   - Enable 3rd party plugin notifications for WooCommerce integration

## 🔧 Configuration

### WooCommerce Setup
1. **Store Details**: Configure store address, currency (INR), and tax settings
2. **Payment Gateways**: Set up UPI, card payments, and other methods
3. **Shipping**: Configure Shiprocket integration for nationwide delivery
4. **Products**: Add food categories and product listings

### Theme Customization
- **Active Theme**: Astra
- **Customizer**: Access via Appearance > Customize
- **Page Builder**: Compatible with Gutenberg and other builders

### Essential Settings
- **Permalinks**: Set to "Post name" for SEO-friendly URLs
- **Security**: Configure Jetpack security features
- **Performance**: Enable LiteSpeed caching
- **Analytics**: Set up Google Analytics via Site Kit

## 📦 Key Business Features

### Product Management
- **Categories**: Traditional snacks, main courses, sweets, pickles
- **Inventory**: Fresh preparation model (no stock management)
- **Pricing**: Competitive pricing for authentic Bihari products

### Order Processing
- **Order Flow**: Customer order → Preparation → Packaging → Shipping
- **Payment**: Secure online payments with UPI integration
- **Shipping**: 2-7 business days via Shiprocket network

### Customer Experience
- **User Accounts**: Registration, order history, tracking
- **Support**: Email support at support@biharkeswaad.shop
- **Policies**: Clear returns, shipping, and terms policies

## 🔒 Security Features

- **WordPress Security**: Regular updates and security plugins
- **SSL Certificate**: HTTPS encryption for secure transactions
- **Payment Security**: PCI-compliant payment processing
- **Data Protection**: Customer data protection and privacy policies

## 📈 Performance Optimization

- **Caching**: LiteSpeed Cache for faster loading
- **CDN**: Jetpack CDN for global content delivery
- **Image Optimization**: Automatic image compression
- **Database**: Optimized queries and regular maintenance

## 🛡 Backup & Maintenance

### Regular Maintenance
- WordPress core updates
- Plugin and theme updates
- Database optimization
- Security scans

### Backup Strategy
- **Files**: Regular backup of wp-content directory
- **Database**: Daily database backups
- **Recovery**: Tested restore procedures

## 📞 Business Information

- **Website**: [biharkeswaad.shop](https://biharkeswaad.shop)
- **Email**: support@biharkeswaad.shop
- **Business Model**: B2C E-commerce (Food & Beverages)
- **Target Market**: Indian diaspora and food enthusiasts
- **Unique Selling Point**: Authentic Bihar cuisine with nationwide delivery

## 📄 Legal Compliance

- **Business Policies**: Returns, shipping, terms & conditions
- **Data Privacy**: GDPR compliant data handling
- **Food Safety**: Adherence to food safety regulations
- **E-commerce Law**: Compliance with Indian e-commerce regulations

## 🤝 Contributing

This is a commercial project. For business inquiries or support:
- Email: support@biharkeswaad.shop
- Website: [biharkeswaad.shop](https://biharkeswaad.shop)

## 📝 License

This project is proprietary software owned by Bihar Ke Swaad. WordPress core and plugins retain their respective licenses.

---

**© 2023 Bihar Ke Swaad - Bringing Authentic Bihar Flavors to Your Doorstep**
