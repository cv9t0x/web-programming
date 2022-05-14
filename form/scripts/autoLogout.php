<?php
session_start();

if (isset($_SESSION['LAST_SEEN']) && (time() - $_SESSION['LAST_SEEN'] > 200)) {
  unset($_SESSION['LAST_SEEN'], $_SESSION['isAdmin']);
}

$_SESSION['LAST_SEEN'] = time();