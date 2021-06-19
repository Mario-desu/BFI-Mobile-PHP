<?php
session_start();
session_regenerate_id(true);
session_destroy();
header("location:projekt_login.php");
?>