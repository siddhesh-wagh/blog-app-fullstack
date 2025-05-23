# 📝 Blog Post Fullstack Application

A feature-rich blog platform built with **Core PHP** and **MySQL**, supporting user authentication, role-based access control, post creation, reporting system, and a full admin panel.

---

## 🚀 Features

* ✨ **User registration & secure login**
* 🛡️ **Password hashing (bcrypt)**
* 📝 **Create, Read, Update, Delete (CRUD) blog posts**
* 🚨 **Report inappropriate posts**
* 🧑‍💼 **Admin dashboard for post & user management**
* 📬 **Contact form with message logging**
* 🔁 **Admin role request & approval flow**
* 📱 **Fully responsive design with Bootstrap**

---

## 🛠️ Tech Stack

### 💻 Frontend

* **HTML5** – Structure via `.php` templates
* **CSS3** – Custom styling (`style.css`)
* **JavaScript** – Client-side interactions
* **Bootstrap 5** – Responsive UI components (via CDN)

### 🖥️ Backend

* **PHP (Core PHP)** – No frameworks, lightweight and flexible
* **MySQL / MariaDB** – RDBMS used for persistent storage

### 🗃️ Database

**Database Name**: `blog_post_fullstack`

Core Tables:

* `users` – Stores login data, roles, and admin request status
* `posts` – Blog content authored by users
* `reports` – Reports logged for offensive or irrelevant posts
* `contacts` – Submissions from the contact form

---

## 📁 Folder Structure

```plaintext
blog_post_fullstack/
├── css/
│   └── style.css               # Main stylesheet
├── js/
│   └── script.js               # Optional JS functionality
├── includes/
│   ├── db.php                  # Database connection logic
│   ├── header.php              # Common header (nav, meta)
│   ├── footer.php              # Common footer
│   └── auth.php                # Session-based access control
├── pages/
│   ├── index.php               # Homepage with post listings
│   ├── blog.php                # Blog view or listing
│   ├── contact.php             # Contact form
│   ├── dashboard.php           # User panel to manage posts
│   ├── add_post.php            # Form to create a new post
│   ├── view_post.php           # Detailed view of single post
│   ├── login.php               # Login form
│   ├── register.php            # Registration form
│   └── admin.php               # Admin control panel
├── sql/
│   └── blog_post_fullstack.sql # SQL dump with structure & data
├── uploads/
│   └── (optional)              # Directory for post-related files
├── README.md                   # You're reading it!
└── .htaccess                   # Optional: clean URLs, security
```

## 📸 Screenshots

Here are some preview screenshots of the blog application:

### 🏠 Home Page
![Home1](assets/screenshots/home1.png)
![Home2](assets/screenshots/home2.png)
![Home3](assets/screenshots/home3.png)

### 📖 Blog
![Blog1](assets/screenshots/blog1.png)
![Blog2](assets/screenshots/blog2.png)

### 🔐 Authentication
![Login](assets/screenshots/login.png)
![Register](assets/screenshots/register.png)

### 📬 Contact Page
![Contact](assets/screenshots/contact.png)

### 🧑‍💼 User Dashboard
![Dashboard](assets/screenshots/dashboard.png)

### 🛠️ Admin Panel
![Admin1](assets/screenshots/admin1.png)
![Admin2](assets/screenshots/admin2.png)

---


---

## ⚙️ Setup Instructions

1. **Clone or Download** the project to your local server directory (e.g., `htdocs/` if using XAMPP).

2. **Import the Database**

   * Open **phpMyAdmin**
   * Create a DB named `blog_post_fullstack`
   * Import the SQL file from `sql/blog_post_fullstack.sql`

3. **Configure DB Connection**
   In `includes/db.php`, update your DB credentials:

   ```php
   $conn = new mysqli('localhost', 'root', '', 'blog_post_fullstack');
   ```

4. **Run the Application**
   Start Apache and MySQL from XAMPP, then visit:

   ```
   http://localhost/blog_post_fullstack/pages/index.php
   ```

5. **Admin Access**
   Default Admin Account:

   * **Email:** `admin@gmail.com`
   * **Password:** *(update in DB manually or via reset flow)*

---

## 🔒 Security

✅ Passwords stored securely via **bcrypt hashing**
✅ Admin routes protected via session middleware
✅ Actions gated by **role-based access control**

---


## 📬 Contact

For questions, feedback, or collaboration inquiries, feel free to reach out:
📧 **Email:** [siddhesh.01092004@gmail.com](mailto:siddhesh.01092004@gmail.com)

---

> Crafted with ❤️ by [**Siddhesh Wagh**](https://siddhesh-wagh.github.io/portfolio/) using Core PHP and MySQL

---

