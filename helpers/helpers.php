<?php
  function display_errors($errors){
    $display = '<ul class="bg-danger">';
    foreach($errors as $error){
      $display.='<li class="text-danger">'.$error.'</li>';
    }
    $display.='</ul>';
    return $display;
  }
function sanitize($dirty){
  return htmlentities($dirty,ENT_QUOTES,"UTF-8");
}

function money($number){
  return '₹'.number_format($number,2);
}
function login($user_id){
  $_SESSION['SBUser'] = $user_id;
  global $db;
  $date = date("Y-m-d H:i:s");
  $db->query("UPDATE users SET last_login='$date' WHERE id = '$user_id'");
  $_SESSION['success_flash'] = 'You are now logged in';
  header("Refresh:0; url='index.php'");
}
function is_logged_in(){
  if(isset($_SESSION['SBUser']) && $_SESSION['SBUser'] > 0){
    return true;
  }
  else {
    return false;
  }
}

function login_error_redirect($url='login.php'){
  $_SESSION['success_error'] = "You must be logged in to access that page";
  header("Refresh:0; url='login.php'");
}

function permission_error_redirect($url='login.php'){
  $_SESSION['success_error'] = "You do not have permission to access that page";
  header("Refresh:0; url='login.php'");
}

function has_permission($permission = 'admin'){
  global $user_data;
  $permissions = explode(',',$user_data['permissions']);
  if(in_array($permission,$permissions,true)){
    return true;
  }else{
    return false;
  }
}


function get_category($child_id){
  global $db;
  $id = sanitize($child_id);
  $sql = "SELECT p.id AS 'pid' , p.category AS 'parent' , c.id as 'cid' ,c.category AS 'child'
          FROM categories c
          INNER JOIN categories p
          ON c.parent = p.id
          WHERE c.id ='$id'";
  $query=$db->query($sql);
  $category = mysqli_fetch_assoc($query);
  return $category;
}

function pretty_date($date){
  return date("M d, Y h:i A",strtotime($date));
}

function sizesToArray($string){
  $sizesArray = explode(',',$string);
  $returnArray = array();
  foreach($sizesArray as $size){
    $s = explode(':',$size);
    $returnArray[] = array('size' => $s[0],'quantity' => $s[1]);
  }
  return $returnArray;
}

function sizesToString($sizes){
  $sizeString = '';
  foreach ($sizes as $size){
    $sizeString .= $size['size'].':'.$size['quantity'].',';
    }
    $trimmed = rtrim($sizeString, ',');
    return $trimmed;
}
