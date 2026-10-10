# BrightSpace — PHP Login and Home Page

A beginner-friendly PHP + MySQL login system based on the file structure shown in the reference screenshots. It includes a styled login page, account registration, a protected home page, logout, and a MySQL database.

## Files

- `index.php` — login page and authentication
- `register.php` — creates a new account
- `home.php` — protected dashboard shown after login
- `logout.php` — ends the session and returns to login
- `db.php` — PDO database connection
- `style.css` — responsive page styling
- `login_system.sql` — database and table setup

## Requirements

- XAMPP (Apache + PHP + MySQL/MariaDB) or another PHP/MySQL environment
- A web browser

## Setup with XAMPP

1. Copy the `simple_login_home_php` folder into `C:\\xampp\\htdocs\\`.
2. Start **Apache** and **MySQL** from the XAMPP Control Panel.
3. Open `http://localhost/phpmyadmin`.
4. Select **Import**, choose `login_system.sql`, then click **Import** / **Go**. Alternatively, open the SQL file in the SQL tab and run it.
5. Open `db.php`. The default settings use host `localhost`, database `login_system`, username `root`, and a blank password. Change these if your local MySQL credentials differ.
6. Visit `http://localhost/simple_login_home_php/`.
7. Click **Create an account**, register with your name, email, and a password of at least 8 characters, then sign in.

## How it works

1. Registration validates the submitted fields and checks whether the email is already used.
2. Passwords are stored as hashes using PHP `password_hash()`; the original password is not stored.
3. Login retrieves the account with a prepared SQL statement and checks the password with `password_verify()`.
4. Successful login starts a session and redirects to `home.php`.
5. `home.php` checks for a signed-in session. Visitors who are not signed in are redirected to the login page.
6. Logout clears the session and redirects to the login page.

## Notes

- Use a local PHP server such as XAMPP; opening the PHP files directly from the file manager will not run them.
- The Google Fonts import requires internet access, but the layout still works with fallback fonts.
- This is a classroom starter project. For production use, add CSRF protection, rate limiting, email verification, and deployment-specific secure cookie settings.
