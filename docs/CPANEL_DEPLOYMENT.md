# cPanel Deployment Checklist (PHP + MySQL)

## 1) Upload Files

- Open cPanel File Manager.
- Go to `public_html`.
- Upload **contents of this project's `public_html` folder** (not the parent project root).
- Ensure these key paths exist after upload:
  - `index.php`
  - `.htaccess`
  - `assets/`
  - `includes/`
  - `config/`
  - `api/`
  - `admin/`

## 2) Create Database

- In cPanel, open **MySQL Databases**.
- Create:
  - Database
  - Database user
  - Assign user to database with **ALL PRIVILEGES**.

## 3) Import Schema

- Open **phpMyAdmin**.
- Select your new database.
- Import file: `config/schema.sql`.

## 4) Configure DB Credentials

- Edit `config/db.php` and set:
  - `$host` (usually `localhost`)
  - `$user`
  - `$password`
  - `$database`
- Save changes.

## 5) Verify Apache Rewrite

- Confirm `.htaccess` is uploaded to `public_html`.
- In cPanel Apache environment, `mod_rewrite` is typically enabled by default.
- Test clean URLs:
  - `/about`
  - `/gallery`
  - `/admin/login`

## 6) First-Run Bootstrap Behavior

- On first successful load with DB connected:
  - Tables are ensured (already covered by schema import).
  - Default admin is auto-created **if no admin exists**:
    - Username: `admin`
    - Password: `admin123`
  - Default gallery/faculty records are auto-seeded if empty.

## 7) Post-Deployment Security Steps (Recommended)

- Log in at `/admin/login`.
- Immediately create a new admin at `/register` and use it.
- Remove/disable `register.php` after creating your permanent admin.
- Change or remove default `admin/admin123` account.
- Keep `config/` and `functions/` blocked from direct access (already handled in `.htaccess`).

## 8) Functional Smoke Test

- Public pages load with styles/images.
- Contact form submits and appears in Admin Messages.
- Admission form submits and appears in Admin Admissions.
- Gallery/Faculty add/edit/delete works in admin.
- Logout/login flow works.
