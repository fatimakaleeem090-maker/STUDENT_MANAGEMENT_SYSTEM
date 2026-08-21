
Student Management System
Project Description

The Student Management System is a web-based application developed using PHP, MySQL, HTML, and CSS. It allows users to register and log in and provides features for managing student records.

The system allows users to add, view, search, edit, and delete student information through a simple and user-friendly interface.

Technologies Used
PHP
MySQL
HTML5
CSS3
XAMPP
phpMyAdmin
Features
User Registration
User Login
User Logout
Dashboard
Add Student
View Students
Search Students
View Student Details
Edit Student Information
Delete Student Records
Form Validation
Responsive Design
Loading Indicator
Pagination
User-friendly interface
Project Structure
student-management-system/
│
├── config.php
├── login.php
├── register.php
├── logout.php
├── dashboard.php
├── add_student.php
├── students.php
├── edit_student.php
├── student_details.php
├── delete_student.php
├── style.css
└── README.md
Database
The project uses MySQL for storing user and student information.

The database can be created and managed using phpMyAdmin through XAMPP.


## How to Run the Website

Follow these steps to run the Student Management System on your computer.

### 1. Download the Project

Click the green **Code** button on this GitHub repository and select **Download ZIP**.

Extract the downloaded ZIP file.

### 2. Install XAMPP

Download and install **XAMPP** if it is not already installed.

Open the XAMPP Control Panel and start:

* **Apache**
* **MySQL**

Both services must be running.

### 3. Move the Project to XAMPP

Copy the extracted project folder into the XAMPP `htdocs` folder:

```text
C:\xampp\htdocs\
```

For example:

```text
C:\xampp\htdocs\student-management-system
```

### 4. Create the Database

Open your browser and go to:

```text
http://localhost/phpmyadmin
```

Create the database required by the project.

Import the provided database SQL file if one is included in this repository.

If the project does not include an SQL file, create the required database and tables according to the database structure used by the project.

### 5. Configure the Database

Open the `config.php` file.

Check the database connection details and make sure they match your local MySQL settings.

Save the file.

### 6. Run the Website

Open Google Chrome or another web browser and enter:

```text
http://localhost/student-management-system/
```

Replace `student-management-system` with the actual project folder name if it is different.

### 7. Create an Account

Open the **Register** page and create a new account.

Then use the registered credentials to log in.

### 8. Use the System

After logging in, users can:

* Add students
* View students
* Search students
* View student details
* Edit student information
* Delete student records
* Logout

### Requirements

Before running the project, make sure you have:

* XAMPP
* Apache
* MySQL
* A web browser
* The project downloaded from this GitHub repository

**Note:** This project is a PHP and MySQL application, so it must be run through a local server such as XAMPP. It cannot be run by simply opening a `.php` file in a browser.






The project uses MySQL for storing user and student information.

The database can be created and managed using phpMyAdmin through XAMPP.
