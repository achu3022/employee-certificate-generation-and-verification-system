# CodeIgniter 4 - Root Deployment without `public/` Folder

This project is configured to run CodeIgniter 4 directly from the **project root**, without needing a separate `/public` folder. This is helpful for shared hosting platforms like **Hostinger**, where setting the web root to `/public` is not possible.

---

## ✅ Project Folder Structure

## Move public/index.php to public_html/index.php

set the path as

/*
 *---------------------------------------------------------------
 * SET THE CURRENT DIRECTORY
 *---------------------------------------------------------------
 */
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);

// Set working directory
if (getcwd() . DIRECTORY_SEPARATOR !== FCPATH) {
    chdir(FCPATH);
}

/*
 *---------------------------------------------------------------
 * BOOTSTRAP THE APPLICATION
 *---------------------------------------------------------------
 */

// ✅ FIXED PATH TO Paths.php (you're now in root, not public)
require FCPATH . 'app/Config/Paths.php';

// Instantiate Paths and start the app
$paths = new Paths();

require $paths->systemDirectory . '/Boot.php';


## add these lines .htaccess files


# ----------------------------------------------------------------------
# Disable directory listing
# ----------------------------------------------------------------------
Options -Indexes

# ----------------------------------------------------------------------
# Hide server signature
# ----------------------------------------------------------------------
ServerSignature Off

# ----------------------------------------------------------------------
# Enable Rewrite Engine
# ----------------------------------------------------------------------
<IfModule mod_rewrite.c>
    Options +FollowSymlinks
    RewriteEngine On

    # ------------------------------------------------------------------
    # Block access to protected folders
    # ------------------------------------------------------------------
    RewriteRule ^(app|system|writable|tests|vendor)/ - [F,L]

    # ------------------------------------------------------------------
    # Allow requests for real files and directories
    # ------------------------------------------------------------------
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d

    # ------------------------------------------------------------------
    # Rewrite everything else to index.php
    # ------------------------------------------------------------------
    RewriteRule ^(.*)$ index.php/$1 [L]
</IfModule>

<IfModule !mod_rewrite.c>
    ErrorDocument 404 index.php
</IfModule>
