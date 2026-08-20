<?php

/**
 * Slim index di document root (public_html/).
 *
 * Fallback agar aplikasi tetap tersaji meskipun server tidak
 * mengeksekusi .htaccess (AllowOverride off). Cukup arahkan
 * langsung ke front controller Laravel di folder public/.
 */

require __DIR__ . '/public/index.php';