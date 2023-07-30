<?php 

session_start();
session_unset();
session_destroy();

echo '<script> window.location = "http://localhost/projects/project1/Hotel MS/index.php" </script>';
