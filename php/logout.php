<?php
session_start();
session_destroy();
header('Location: /bib/login.html');
exit();
