<?php
// Session Configuration - Must be included before session_start()
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', isset($_SERVER['HTTPS']));

// Other session security settings you might want to add
ini_set('session.gc_maxlifetime', 3600); // Session timeout after 1 hour
ini_set('session.cookie_lifetime', 0); // Session cookie expires when browser closes
?>
