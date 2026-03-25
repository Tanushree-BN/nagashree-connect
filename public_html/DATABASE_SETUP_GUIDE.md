# Database Setup Guide — Nagashree English School

## Overview

This guide explains:

- How to create a MySQL database in cPanel
- What tables to create and the exact SQL queries
- How to connect the database to the project
- What data gets stored (default seeded vs newly added)

---

## Part 1 — Create the Database in cPanel

### Step 1: Log in to cPanel

Go to your hosting provider's cPanel URL, for example:

```
https://yourdomain.com/cpanel
```

or

```
https://yourdomain.com:2083
```

Enter your cPanel username and password.

---

### Step 2: Open "MySQL Databases"

In cPanel, search for **MySQL Databases** or find it under the **Databases** section. Click it.

---

### Step 3: Create a New Database

1. Under **Create New Database**, enter a name — for example: `nagashree`
2. Click **Create Database**
3. cPanel will create the database. The **actual database name will be**:

   ```
   cpanelusername_nagashree
   ```

   (cPanel automatically prefixes your cPanel username to the database name.)

4. Note down the full database name shown on screen.

---

### Step 4: Create a Database User

1. Scroll down to **MySQL Users** → **Add New User**
2. Enter a username — for example: `schooladmin`
3. Enter a strong password (or use the **Password Generator**)
4. Click **Create User**
5. Note down:
   - **Full username** shown (will be like `cpanelusername_schooladmin`)
   - **Password** you set

---

### Step 5: Assign the User to the Database

1. Scroll down to **Add User To Database**
2. Select the user you just created from the **User** dropdown
3. Select the database you created from the **Database** dropdown
4. Click **Add**
5. On the next screen, check **ALL PRIVILEGES**
6. Click **Make Changes**

The user is now linked to the database with full permissions.

---

## Part 2 — Create the Tables (SQL Queries)

### Method A: Import the Ready-Made SQL File (Easiest)

The project already has a complete schema file at:

```
public_html/config/schema.sql
```

To import it:

1. In cPanel → go to **phpMyAdmin**
2. In the left sidebar, click your database name (e.g. `cpanelusername_nagashree`)
3. Click the **Import** tab at the top
4. Click **Choose File** → select `config/schema.sql` from your local computer
5. Leave all settings as default
6. Click **Go** (bottom of the page)

All 5 tables will be created automatically.

---

### Method B: Run Queries Manually (Step by Step)

If you prefer to run queries yourself, go to **phpMyAdmin** → select your database → click the **SQL** tab and run each query below one by one.

---

#### Table 1: `admin_users`

Stores the admin login credentials.

```sql
CREATE TABLE IF NOT EXISTS admin_users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

#### Table 2: `gallery_images`

Stores the school gallery photos (max 50 images).

```sql
CREATE TABLE IF NOT EXISTS gallery_images (
  id INT AUTO_INCREMENT PRIMARY KEY,
  src LONGTEXT NOT NULL,
  alt_text VARCHAR(255) NOT NULL,
  category VARCHAR(50) NOT NULL,
  title VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

**`category` values used**: `events`, `classroom`, `sports`, `facilities`

---

#### Table 3: `faculties`

Stores teacher/staff profiles.

```sql
CREATE TABLE IF NOT EXISTS faculties (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  role VARCHAR(150) NOT NULL,
  subject VARCHAR(150) NOT NULL,
  experience VARCHAR(100) NOT NULL,
  image LONGTEXT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

**Note**: `image` stores a base64-encoded image string (or NULL if no photo uploaded).

---

#### Table 4: `contact_messages`

Stores messages submitted via the Contact Us page.

```sql
CREATE TABLE IF NOT EXISTS contact_messages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  email VARCHAR(255) NOT NULL,
  phone VARCHAR(30) NULL,
  subject VARCHAR(150) NOT NULL,
  message TEXT NOT NULL,
  seen TINYINT(1) DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

**`seen`**: 0 = unread, 1 = read by admin.

---

#### Table 5: `admissions`

Stores admission applications submitted via the Admission page.

```sql
CREATE TABLE IF NOT EXISTS admissions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  student_name VARCHAR(150) NOT NULL,
  parent_name VARCHAR(150) NOT NULL,
  mother_name VARCHAR(150) NULL,
  dob VARCHAR(30) NOT NULL,
  gender VARCHAR(30) NOT NULL,
  class_applying VARCHAR(50) NOT NULL,
  phone VARCHAR(30) NOT NULL,
  mother_phone VARCHAR(30) NULL,
  email VARCHAR(255) NULL,
  address TEXT NOT NULL,
  previous_school VARCHAR(255) NULL,
  seen TINYINT(1) DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

## Part 3 — Connect the Database to the Project

### Edit `config/db.php`

Open the file `public_html/config/db.php` and replace the placeholder values with your actual cPanel credentials:

**Before (placeholder):**

```php
$host = "localhost";
$user = "DB_USER";
$password = "DB_PASSWORD";
$database = "DB_NAME";
```

**After (fill in your real values):**

```php
$host = "localhost";
$user = "cpanelusername_schooladmin";   // your full cPanel DB username
$password = "YourStrongPassword123";    // password you set in Step 4
$database = "cpanelusername_nagashree"; // your full cPanel database name
```

> **Important**: `$host` is almost always `localhost` on cPanel shared hosting. Do not change it.

---

### Verify the Connection

After updating `config/db.php` and uploading the project to cPanel:

1. Visit your website home page
2. The app will auto-detect the DB connection on first load
3. Go to **Admin → Messages** or **Admin → Admissions** — if data appears, DB is connected
4. You can also check: Admin Login → Dashboard → the data tables work = DB is live

---

## Part 4 — What Data Gets Stored in the Database?

### Default / Pre-seeded Data (Auto-inserted on First Load)

When the database tables are **empty** and the app connects for the first time, it automatically inserts the following default data:

---

#### Admin User (1 record auto-created)

| username | password |
| -------- | -------- |
| admin    | admin123 |

> The password is stored as a secure bcrypt hash — never as plain text.
> **Change the admin password after first login** via the dashboard.

---

#### Gallery Images (18 records auto-seeded)

The following 18 school photos are inserted automatically from existing image files:

| Title                | Category   |
| -------------------- | ---------- |
| Annual Day 2024      | events     |
| Cultural Festival    | events     |
| Smart Classroom      | classroom  |
| Science Lab Session  | classroom  |
| Cricket Match        | sports     |
| Sports Day           | sports     |
| Library              | facilities |
| Computer Lab         | facilities |
| Independence Day     | events     |
| Yoga Day             | sports     |
| Morning Assembly     | events     |
| Transport Fleet      | facilities |
| Group Activity       | classroom  |
| Outdoor Games        | sports     |
| School Corridors     | facilities |
| School Assembly      | events     |
| Interactive Learning | classroom  |
| Campus View          | facilities |

This default gallery data comes from the image files already included in `public_html/assets/images/`.

---

#### Faculty / Staff (12 records auto-seeded)

| Name              | Role               | Subject                  |
| ----------------- | ------------------ | ------------------------ |
| Mrs. Savitha R.   | Principal          | Administration & English |
| Mr. Ramesh Kumar  | Vice Principal     | Mathematics              |
| Mrs. Lakshmi Devi | Senior Teacher     | Science                  |
| Mr. Suresh Babu   | Senior Teacher     | Social Studies           |
| Mrs. Anitha N.    | Teacher            | English & Literature     |
| Mr. Prasad H.M.   | Teacher            | Kannada                  |
| Mrs. Deepa S.     | Teacher            | Hindi                    |
| Mr. Mahesh K.     | Physical Education | Sports & PE              |
| Mrs. Shwetha R.   | Teacher            | Computer Science         |
| Mr. Naveen G.     | Teacher            | Art & Craft              |
| Mrs. Kavitha M.   | Teacher            | Music                    |
| Mr. Arun Kumar    | Lab Assistant      | Science Lab              |

---

#### Contact Messages and Admissions

**No default data** — these tables start empty. They only receive data when:

- A visitor submits the **Contact Us** form
- A visitor submits the **Admission Application** form

---

### Newly Added Data (Stored When Users Submit Forms)

| Action                         | Table              | Who Adds |
| ------------------------------ | ------------------ | -------- |
| Visitor fills Contact form     | `contact_messages` | Visitors |
| Visitor submits Admission form | `admissions`       | Visitors |
| Admin uploads a gallery photo  | `gallery_images`   | Admin    |
| Admin adds/edits a faculty     | `faculties`        | Admin    |

---

## Part 5 — Before DB vs After DB (Fallback Mode)

If the DB credentials in `config/db.php` are **not yet set** or the DB connection fails, the app runs in **Fallback Mode**:

| Feature          | Fallback Mode (no DB)                   | With DB Connected                 |
| ---------------- | --------------------------------------- | --------------------------------- |
| Gallery          | Uses default 18 images (from code)      | Reads from `gallery_images` table |
| Faculties        | Uses default 12 staff (from code)       | Reads from `faculties` table      |
| Contact messages | Saved to `storage/messages.json` file   | Saved to `contact_messages` table |
| Admissions       | Saved to `storage/admissions.json` file | Saved to `admissions` table       |
| Admin login      | Works (session-based)                   | Works (session-based, same)       |

> **Note**: Any messages/admissions stored in the JSON fallback files (`storage/messages.json`, `storage/admissions.json`) will **not** automatically migrate to the database when you connect it later. To preserve that data, check the `storage/` folder before switching to a live DB.

---

## Quick Checklist

- [ ] Created database in cPanel (MySQL Databases)
- [ ] Created database user with strong password
- [ ] Assigned user to database with ALL PRIVILEGES
- [ ] Imported `config/schema.sql` via phpMyAdmin (or ran queries manually)
- [ ] Edited `config/db.php` with real credentials (username, password, database name)
- [ ] Uploaded updated `config/db.php` to cPanel (File Manager or FTP)
- [ ] Visited the site — tables auto-bootstrapped with default data
- [ ] Changed admin password from default `admin123`

---

## Summary of Credentials Format in cPanel

| Field       | Example Value           | Notes                                   |
| ----------- | ----------------------- | --------------------------------------- |
| `$host`     | `localhost`             | Never changes on shared hosting         |
| `$user`     | `cpanel123_schooladmin` | cPanel prefix + username you chose      |
| `$password` | `MySecure@Pass99`       | Password you set for the DB user        |
| `$database` | `cpanel123_nagashree`   | cPanel prefix + database name you chose |

**Your cPanel username** is shown in the top-right corner when you log in to cPanel.

---

_End of Guide_
