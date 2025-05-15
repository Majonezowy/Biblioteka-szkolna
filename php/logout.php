<?php
session_start();
session_destroy();
header('Location: /bib/login.php?message=' . urlencode('Wylogowano pomyślnie.') . '&l=0');
exit();
