<?php
require_once 'Auth.php';
$auth = new Auth();

/**
 * Memanggil method logout() yang berisi:
 * 1. session_unset()
 * 2. session_destroy()
 * 3. redirect ke login.php
 */
$auth->logout();