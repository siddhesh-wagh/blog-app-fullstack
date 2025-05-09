

```markdown
# 📝 Blog Post Fullstack Application

A full-featured blog web application with user authentication, role-based access, post creation, reporting system, and admin dashboard.

## 🚀 Features

- User registration and login
- Password hashing for secure authentication
- Create, read, update, delete (CRUD) blog posts
- Report inappropriate posts
- Admin dashboard for managing users and posts
- Contact form with message submission
- Admin request system for promoting users
- Fully responsive frontend with modular CSS

## 🛠️ Tech Stack

**Frontend:**
- HTML, CSS, JavaScript
- Bootstrap (optional for UI components)

**Backend:**
- PHP (Core PHP, no frameworks)
- MySQL (MariaDB recommended)

**Database:**
- `blog_post_fullstack` with 4 core tables:
  - `users`
  - `posts`
  - `reports`
  - `contacts`

## 📁 Folder Structure

```

project-root/
│
├── css/
│   └── style.css            # Main stylesheet
├── js/
│   └── script.js            # Optional JS functionality
├── includes/
│   ├── db.php               # DB connection
│   ├── header.php           # Common header
│   ├── footer.php           # Common footer
│   └── auth.php             # Session management
├── pages/
│   ├── index.php            # Home
│   ├── login.php
│   ├── register.php
│   ├── dashboard.php
│   ├── admin.php
│   ├── contact.php
│   ├── add\_post.php
│   └── view\_post.php
├── sql/
│   └── blog\_post\_fullstack.sql  # Full database schema + data
└── README.md

````

## ⚙️ Setup Instructions

1. **Clone or download** the project to your local machine.

2. **Import Database:**
   - Open phpMyAdmin.
   - Create a database named `blog_post_fullstack`.
   - Import the `blog_post_fullstack.sql` file from the `/sql/` folder.

3. **Configure Database Connection:**
   - Open `includes/db.php`.
   - Update database credentials:
     ```php
     $conn = new mysqli('localhost', 'root', '', 'blog_post_fullstack');
     ```

4. **Start Local Server:**
   - Use XAMPP or any PHP local server.
   - Place the project folder in `htdocs/`.
   - Open browser and navigate to:  
     `http://localhost/blog_post_fullstack/pages/index.php`

5. **Default Admin Login:**
   - Email: `admin@gmail.com`
   - Password: (encrypted in DB — update via DB or reset password logic)

## 🔒 Security Notes

- Passwords are hashed using bcrypt.
- All user actions are protected via session checks.
- Only admins can access the admin dashboard or approve admin requests.

## ✉️ Contact

For queries or suggestions, feel free to raise an issue or contact the project maintainer.

---

> Built by Siddhesh Wagh with ❤️ using PHP and MySQL.
````

---

Would you like me to generate a downloadable `README.md` file for you?
