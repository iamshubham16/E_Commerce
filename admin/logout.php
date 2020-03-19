<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/E_commerce/core/init.php';
  unset($_SESSION['SBUser']);
  header('Location:login.php');
