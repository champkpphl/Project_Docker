<?php
session_start();
session_destroy();

if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], '8080') !== false) {
    header('Location: http://localhost:8080/');
} else {
    header('Location: /login.php');
}
exit;
?>
