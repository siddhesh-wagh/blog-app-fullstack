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

blog_post_fullstack/
├── css/
│   └── style.css               # Main stylesheet with sectioned layout
├── js/
│   └── script.js               # Optional JavaScript functionality
├── includes/
│   ├── db.php                  # Database connection
│   ├── header.php              # Common header (navbar, meta)
│   ├── footer.php              # Common footer
│   └── auth.php                # Session and authentication checks
├── pages/
│   ├── index.php               # Homepage (shows all posts)
│   ├── blog.php                # Blog listing or detailed view
│   ├── contact.php             # Contact form page
│   ├── dashboard.php           # User dashboard (for adding/viewing posts)
│   ├── add_post.php            # Form to add a new post
│   ├── view_post.php           # View full post with comments or actions
│   ├── login.php               # Login form
│   ├── register.php            # User registration form
│   └── admin.php               # Admin dashboard
├── sql/
│   └── blog_post_fullstack.sql # Complete SQL dump (structure + data)
├── uploads/
│   └── (optional)              # Folder for uploaded images/files
├── README.md                   # Project readme file (you’re viewing this)
└── .htaccess                   # (optional) For URL rewriting, security etc.


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

> Built by Siddhesh Wagh with ❤️ using PHP and MySQL.
