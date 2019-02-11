<?php
include 'constants.php';
session_start();
session_destroy();
header('Location:'.HOMEURL);
?>