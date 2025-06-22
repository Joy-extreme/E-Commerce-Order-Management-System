# E-Commerce Order Management System

## Overview
This is a role-based order management system designed for an e-commerce platform. The system supports three types of users with distinct access permissions and responsibilities, facilitating efficient order handling and product management across multiple outlets.

---

## Tech Stack

- **Backend:** PHP (Laravel Framework)  
- **Frontend:** HTML, CSS, JavaScript, Bootstrap  
- **Database:** MySQL  
- **Version Control:** Git & GitHub  
- **Authentication & Authorization:** Laravel Middleware and Role-based Access Control  
- **Other Tools:** Composer, Laravel Mix  

---
## Mail Configuration

- **Mailtrap** is used for email testing during user registration and email verification.
- SMTP configuration details (found in `.env` file):
```text
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=your-email@example.com
MAIL_FROM_NAME="${APP_NAME}"
```
---
## Stakeholders & Their Functionalities

### 1. Super Admin
- Full control over the system.
- Manage users (create, update, delete).
- Manage products (CRUD operations).
- Manage outlets (CRUD operations).
- Assign roles to users.

### 2. Admin
- View all orders across outlets.
- Accept or cancel orders.
- Transfer orders between outlets.

### 3. Outlet In Charge
- View only orders related to their assigned outlet.
- Accept orders for their outlet.
- Transfer orders to other outlets if needed.

---

## Contact

For any questions, suggestions, or contributions, please contact:

**Joy Bhowmik**  
Email: Joybhowmik67@gmail.com
GitHub: (https://github.com/Joy-extreme)  
LinkedIn: (https://www.linkedin.com/in/joybhowmik7/)  

---

*Thank you for using the E-Commerce Order Management System!*
