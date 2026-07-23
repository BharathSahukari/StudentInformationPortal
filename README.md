# 🎓 Student Management System 

A web-based **Student Management System** developed using **PHP, MySQL, HTML, CSS, and JavaScript**. The system enables administrators to manage student records through registration, profile management, and CRUD (Create, Read, Update, Delete) operations.

---

# 📖 Table of Contents

- Project Overview
- Features
- Technologies Used
- Project Structure
- Installation
- Database
- Project Modules
- Future Enhancements
- Author
- License

---

# 📌 Project Overview

The Student Management System is designed to simplify the process of managing student information. It allows administrators to register students, view student details, update records, delete records, and manage student profiles through a simple and user-friendly interface.

The system helps reduce manual paperwork and provides an efficient way to maintain student information.

---

# ✨ Features

## Authentication
- Admin Login
- Secure Logout

## Student Registration
- Add New Student
- Upload Student Profile Image
- Store Student Details

## Student Management
- View Student Records
- Edit Student Details
- Delete Student Records

## Student Profile
- Display Complete Student Information
- View Student Profile Image

## Dashboard
- Admin Dashboard
- Display Recently Added Students

---

# 💻 Technologies Used

### Frontend
- HTML5
- CSS3
- JavaScript

### Backend
- PHP

### Database
- MySQL

### Development Tools
- XAMPP
- Visual Studio Code

---

# 📁 Project Structure

```
StudentManagementSystem/
│
├── css/
│   ├── addstyle.css
│   ├── dashboardstyle.css
│   ├── deletestyle.css
│   ├── editstyle.css
│   ├── loginstyle.css
│   ├── myprofilestyle.css
│   ├── profilestyle.css
│   ├── registerstyle.css
│   ├── studenteditstyle.css
│   ├── studentviewstyle.css
│   ├── viewstyle.css
│   
│
├── dashboard/
│   ├── admin_dashboard.php
│   ├── student_dashboard.php
│
├── database/
│   ├── student_management.sql
│ 
├── edit/  
│   ├── edit_admin.php
│   ├── edit_student.php
│   
├── images
│  
├── js/
│   ├── login.js
│   ├── logoutConfirm.js
│   ├── register.js
│   
├── login/
│   ├── admin_login.php
│   ├── forgot_password.php
│   ├── reeset_password.php
│   ├── student_login.php
│   ├── verify_otp.php
│  
├── /PHPMailer\src
│   ├── DSNConfigurator.php
│   ├── Exception.php
│   ├── OAuth.php
│   ├── OAuthTokenProvider.php
│   ├── PHPMailer.php
│   ├── POP3.php
│   ├── SMTP.php
│
├── profile/
│   ├── admin_profile.php
│   ├── myprofile.php
│   └── student_profile.php
│
├── registration/
│   ├── admin_register.php
│   ├── student_register.php
│  
├── uploads/ 
│   ├── 1783960992_profile.jpeg
│   ├── bharath_profile.jpeg 
│   
├── view/
│   ├── myview.php
│   ├── view_admin.php
│   ├── view_student.php
│
├── add_student.php
├── db.php
├── delete_student.php
├── index.php
├── logout.php
├── README.md
```

---

# ⚙ Installation

1. Install XAMPP.
2. Copy the project folder into the `htdocs` folder.
3. Start Apache and MySQL.
4. Create a database using phpMyAdmin.
5. Import the SQL database file.
6. Update the database connection in `db.php`.
7. Open the project in your browser:

```
http://localhost/StudentManagementSystem/
```

---

# 🗄 Database

**Database Name**

```
student_management
```

**Main Table**

```
students
```

### Students Table Fields

- Student ID
- Roll Number
- Full Name
- Email
- Password
- Phone Number
- Gender
- Department
- Academic Year
- Profile Image
- Address
- Created Date

---

#  📚 Project Modules

### 1. Admin Login Module
Allows the administrator to securely log in to the system.

### 2. Student Registration Module
Enables the administrator to register new students by entering personal and academic details.

### 3. Student Management Module
Provides CRUD operations:
- Create Student
- View Student
- Update Student
- Delete Student

### 4. Student Profile Module
Displays complete student information, including the uploaded profile image.

### 5. Admin Dashboard Module
Displays the main dashboard with quick access to student management features and recently added students.

---

# 📸 Screenshots

- Login Page
- Admin Dashboard
- Add Student Page
- View Students Page
- Edit Student Page
- Student Profile Page

---

# 🚀 Future Enhancements

- Search Functionality
- Filter by Department
- Pagination
- Dashboard Statistics
- Chart.js Analytics
- Export to PDF
- Export to Excel
- Attendance Management

---

# ✅ Conclusion

The Student Management System provides an efficient solution for managing student information. It allows administrators to register, view, edit, and delete student records while maintaining organized and secure data. The project demonstrates the practical implementation of PHP, MySQL, HTML, CSS, and JavaScript in building a web-based application.

---

# 👩‍💻 Author

**Ahalya Thirlangi**

Student Management System – Task 3

---

# 📜 License

This project is developed for educational and academic purposes.
