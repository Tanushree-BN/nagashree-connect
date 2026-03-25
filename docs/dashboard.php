<?php
require_once __DIR__ . '/functions/helpers.php';
if (!is_admin_logged_in()) {
    redirect_to('/admin/login');
}
redirect_to('/admin/dashboard');
