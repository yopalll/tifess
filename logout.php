<?php

require_once "function.php";

// Hapus sesi admin
clearAdminSession();

// Balik ke halaman login
header("Location: login.php?logout=1");
exit;
