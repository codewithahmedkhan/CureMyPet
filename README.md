<div align="center">
  <br />
      <img src="https://raw.githubusercontent.com/codewithahmedkhan/CureMyPet/main/img/to-next-level-pet-care.webp" alt="CureMyPet Banner" width="100%">
  <br />
  
  <div>
    <img src="https://img.shields.io/badge/-PHP-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP" />
    <img src="https://img.shields.io/badge/-MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL" />
    <img src="https://img.shields.io/badge/-Bootstrap-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white" alt="Bootstrap" />
    <img src="https://img.shields.io/badge/-jQuery-0769AD?style=for-the-badge&logo=jquery&logoColor=white" alt="jQuery" />
    <img src="https://img.shields.io/badge/-Stripe-008CDD?style=for-the-badge&logo=stripe&logoColor=white" alt="Stripe" />
    <img src="https://img.shields.io/badge/-Botpress-1C7ED6?style=for-the-badge&logo=chatbot&logoColor=white" alt="Botpress" />
  </div>

  <h3 align="center">CureMyPet: Comprehensive Veterinary Care & E-commerce Platform</h3>

   <div align="center">
     CureMyPet is a full-featured veterinary management system that combines appointment booking, e-commerce functionality, and multi-role user management. Built to revolutionize pet care services by providing a seamless platform for pet owners, veterinarians, and clinic administrators.
    </div>
</div>

## 📋 <a name="table">Table of Contents</a>

1. 🐾 [Introduction](#introduction)
2. ⚙️ [Tech Stack](#tech-stack)
3. 🔋 [Features](#features)
4. 🚀 [Quick Start](#quick-start)
5. 📱 [Screenshots](#screenshots)
6. 🏗️ [Project Structure](#structure)
7. 📊 [Database Schema](#database)
8. 🔐 [Security](#security)
9. 🌐 [Demo](#demo)
10. 👨‍💻 [About Developer](#about)
11. 🤝 [Contributing](#contributing)

## <a name="introduction">🐾 Introduction</a>

CureMyPet is a comprehensive veterinary care platform designed to streamline pet healthcare management. It offers an integrated solution for booking veterinary appointments, purchasing pet products, accessing educational resources, and managing treatment records. The platform serves three main user types: pet owners, veterinarians, and administrators, each with tailored functionalities.

## <a name="tech-stack">⚙️ Tech Stack</a>

### Backend
- **PHP 7.4+** - Server-side scripting
- **MySQL** - Database management
- **MySQLi** - Database connectivity
- **PHPMailer** - Email functionality

### Frontend
- **Bootstrap 5** - Responsive UI framework
- **jQuery** - JavaScript library
- **Font Awesome** - Icon library
- **Custom CSS** - Modern styling with gradients
- **SCSS** - CSS preprocessor

### Third-Party Integrations
- **Botpress** - AI-powered chatbot
- **Stripe** - Payment processing (ready for integration)
- **Cloudinary** - Image management (ready for integration)

### Development Tools
- **Git** - Version control
- **Composer** - PHP dependency management
- **PHPUnit** - Testing framework

## <a name="features">🔋 Features</a>

### 🏥 For Pet Owners
- **Easy Appointment Booking** - Book appointments with preferred veterinarians
- **Service Selection** - Choose from various pet care services
- **Appointment History** - Track past and upcoming appointments
- **E-commerce Platform** - Purchase pet products and medicines
- **Shopping Cart** - Manage product selections
- **Order Tracking** - Monitor order status and history
- **Educational Resources** - Access pet care guides and articles
- **User Profile** - Manage personal and pet information
- **AI Chatbot** - Get instant answers to pet care questions

### 👨‍⚕️ For Veterinarians
- **Appointment Management** - View and manage assigned appointments
- **Treatment Records** - Add and update patient treatment information
- **Appointment Reminders** - Send automated reminders to clients
- **Patient History** - Access complete pet medical records
- **Schedule Management** - Organize daily appointments

### 👤 For Administrators
- **User Management** - CRUD operations for all users
- **Doctor Management** - Add, update, and remove veterinarians
- **Service Management** - Configure available services
- **Product Inventory** - Manage e-commerce products
- **Order Processing** - Handle customer orders
- **Contact Management** - Respond to user inquiries
- **Analytics Dashboard** - Monitor platform statistics

## <a name="quick-start">🚀 Quick Start</a>

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server
- Composer (optional)

### Installation Steps

1. **Clone the repository**
```bash
git clone https://github.com/codewithahmedkhan/CureMyPet.git
cd CureMyPet
```

2. **Database Setup**
```sql
CREATE DATABASE curemypet;
```

3. **Import Database Schema**
```bash
mysql -u username -p curemypet < database/schema.sql
```

4. **Configure Database Connection**
Edit `connection.php`:
```php
<?php
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "curemypet";
?>
```

5. **Configure Virtual Host** (Apache example)
```apache
<VirtualHost *:80>
    ServerName curemypet.local
    DocumentRoot /path/to/CureMyPet
    <Directory /path/to/CureMyPet>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

6. **Set File Permissions**
```bash
chmod -R 755 .
chmod -R 777 dashboard/product_images/
chmod -R 777 dashboard/service_image/
```

7. **Access the Application**
```
http://localhost/CureMyPet
```

### Default Credentials
- **Admin Panel**: `/dashboard/login.php`
  - Username: `admin@curemypet.com`
  - Password: `admin123`
  
- **Doctor Panel**: `/dr_panel/login.php`
  - Username: `doctor@curemypet.com`
  - Password: `doctor123`

## <a name="screenshots">📱 Screenshots</a>

### Homepage
<img src="https://raw.githubusercontent.com/codewithahmedkhan/CureMyPet/main/screenshots/homepage.png" alt="Homepage" width="100%">

### Appointment Booking
<img src="https://raw.githubusercontent.com/codewithahmedkhan/CureMyPet/main/screenshots/appointment.png" alt="Appointment Booking" width="100%">

### Product Catalog
<img src="https://raw.githubusercontent.com/codewithahmedkhan/CureMyPet/main/screenshots/products.png" alt="Products" width="100%">

### Admin Dashboard
<img src="https://raw.githubusercontent.com/codewithahmedkhan/CureMyPet/main/screenshots/admin-dashboard.png" alt="Admin Dashboard" width="100%">

## <a name="structure">🏗️ Project Structure</a>

```
CureMyPet/
├── 📁 assets/              # Frontend assets
│   ├── 📁 css/            # Stylesheets
│   ├── 📁 js/             # JavaScript files
│   ├── 📁 fonts/          # Web fonts
│   └── 📁 img/            # Images
├── 📁 dashboard/          # Admin panel
│   ├── 📁 css/           # Admin styles
│   ├── 📁 js/            # Admin scripts
│   ├── 📁 vendor/        # Admin dependencies
│   ├── 📄 index.php      # Admin dashboard
│   └── 📄 *.php          # Admin modules
├── 📁 dr_panel/          # Doctor panel
│   ├── 📄 appointment.php # View appointments
│   ├── 📄 treatment.php  # Manage treatments
│   └── 📄 *.php         # Doctor modules
├── 📁 img/              # Application images
├── 📁 vendor/           # PHP dependencies
├── 📄 index.php        # Homepage
├── 📄 connection.php   # Database config
├── 📄 header.php      # Common header
├── 📄 footer.php      # Common footer
├── 📄 login.php       # User login
├── 📄 register.php    # User registration
├── 📄 products.php    # Product catalog
├── 📄 cart.php       # Shopping cart
├── 📄 form.php       # Appointment form
└── 📄 services.php   # Services listing
```

## <a name="database">📊 Database Schema</a>

### Core Tables

#### Users Table
```sql
CREATE TABLE user (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    contact VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

#### Doctors Table
```sql
CREATE TABLE doctor (
    id INT PRIMARY KEY AUTO_INCREMENT,
    drname VARCHAR(100) NOT NULL,
    specialization VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    contact VARCHAR(20),
    experience INT,
    qualification VARCHAR(200)
);
```

#### Services Table
```sql
CREATE TABLE services (
    id INT PRIMARY KEY AUTO_INCREMENT,
    servicename VARCHAR(100) NOT NULL,
    servicedesc TEXT,
    img VARCHAR(255),
    price DECIMAL(10,2)
);
```

#### Products Table
```sql
CREATE TABLE products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2),
    image VARCHAR(255),
    category VARCHAR(50),
    stock_quantity INT DEFAULT 0
);
```

#### Appointments Table
```sql
CREATE TABLE form (
    id INT PRIMARY KEY AUTO_INCREMENT,
    drname VARCHAR(100),
    servicesname VARCHAR(100),
    petdetail TEXT,
    location VARCHAR(200),
    contact VARCHAR(20),
    message TEXT,
    useremail VARCHAR(100),
    username VARCHAR(100),
    appointment_date DATETIME,
    status ENUM('pending','confirmed','completed','cancelled') DEFAULT 'pending'
);
```

## <a name="security">🔐 Security Features</a>

### Implemented Security Measures
- ✅ **Password Hashing** - bcrypt for secure password storage
- ✅ **Session Management** - Secure session handling
- ✅ **SQL Injection Prevention** - Prepared statements (partial)
- ✅ **XSS Protection** - Output escaping with htmlspecialchars
- ✅ **Access Control** - Role-based authentication
- ✅ **HTTPS Ready** - SSL/TLS support

### Security Best Practices
```php
// Password hashing example
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

// Input sanitization
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');

// Prepared statements
$stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
$stmt->bind_param("s", $email);
```

## <a name="api">📡 API Endpoints</a>

### Authentication
- `POST /login.php` - User login
- `POST /register.php` - User registration
- `GET /logout.php` - User logout

### Appointments
- `POST /form.php` - Create appointment
- `GET /appointment_history.php` - View appointments

### E-commerce
- `GET /products.php` - List products
- `POST /cart.php` - Add to cart
- `POST /checkout.php` - Process order

### Admin
- `GET /dashboard/` - Admin dashboard
- `POST /dashboard/addproduct.php` - Add product
- `POST /dashboard/addservice.php` - Add service

## <a name="demo">🌐 Live Demo</a>

🔗 **Live URL**: [Coming Soon]

### Test Accounts
- **Customer**: demo@curemypet.com / demo123
- **Doctor**: drdemo@curemypet.com / doctor123
- **Admin**: admin@curemypet.com / admin123

## <a name="about">👨‍💻 About Developer</a>

Hi! I'm **Ahmed Khan**, a passionate full-stack developer specializing in web applications.

- 🌐 **Portfolio**: [codewithahmedkhan.com](https://codewithahmedkhan.com)
- 💼 **GitHub**: [@codewithahmedkhan](https://github.com/codewithahmedkhan)
- 📧 **Email**: codewithahmedkhan@gmail.com
- 💬 **LinkedIn**: [Ahmed Khan](https://linkedin.com/in/codewithahmedkhan)

## <a name="contributing">🤝 Contributing</a>

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

### Development Guidelines
- Follow PSR-12 coding standards
- Write meaningful commit messages
- Add appropriate comments
- Test your changes thoroughly
- Update documentation as needed

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🙏 Acknowledgments

- Bootstrap team for the amazing CSS framework
- Font Awesome for the icon library
- Botpress for the AI chatbot integration
- PHPMailer contributors
- All contributors and testers

---

<div align="center">
  Made with ❤️ by <a href="https://github.com/codewithahmedkhan">Ahmed Khan</a>
  <br />
  ⭐ Star this repository if you find it helpful!
</div>