<?php
include('config.php');

if(isset($_COOKIE['token'])){
  $id=$_COOKIE['token'];
  $sql ="SELECT * FROM users WHERE user_id=$id";
  if($rs=$conn->query($sql)){
    if($rs->num_rows>0){
      $row=$rs->fetch_assoc();
      $usertype=$row['user_type'];
      $userid=$row['user_id'];
      switch($usertype){
        case 0 : header("location:EmployeeList.php"); break;
        case 1 : header("location:staff_dash.php"); break;
        case 2 : header("location:guest_dash.php"); break;
      }
    }else{
        header("location:logout.php");
    }
  }
  else{
    	echo $conn->error;
  }
}

$username='';
$useremail='';
$userpass='';
$msg='';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = $_POST['username'];
    $useremail = $_POST['useremail'];
    $userpass = md5($_POST['userpass']);

    if (empty($useremail) || empty($userpass) || empty($username)) {
        $msg = 'Fill in all fields';
    } else {
        $VALIDATIONsql = "SELECT user_email FROM users WHERE user_email = '$useremail'";
        $sql = "INSERT INTO users SET user_type = '2', user_name = '$username', user_pass = '$userpass', user_email = '$useremail'";
        if($rs=$conn->query($VALIDATIONsql)){
          if($rs->num_rows>0){
            $msg = 'Email already being used';
          }
          else{
            if($rs=$conn->query($sql)){
              $msg = 'Account Created';
              header("location:login.php");
            }
            else{
              $msg = 'There is an error creating an account'.$conn->error;
            }
          }
        }
        else{
          $msg = 'There is an error creating an account'.$conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Sign Up</title>
  </head>
  <body>
    <div style="width:200px; margin:auto;">
      <fieldset>
        <legend>SIGN UP</legend>
        <form method="post">
          <label>EMAIL</label><br/>
          <input type="text" placeholder="Enter Email" name="useremail" required><br/>
          <label>USERNAME</label><br/>
          <input type="text" placeholder="Enter Username" name="username" required><br/>
          <label>PASSWORD</label><br/>
          <input type="password" placeholder="Enter Password" name="userpass" required><br/>
          <input type="submit" class="signupbtn" value='Create Account' onclick="save()" /><br/>
          <button name="cancelbtn" onclick="location.href='logout.php';">CANCEL</button><br/>
          <p><?php echo $msg; ?></p>
        </form>
      </fieldset>
    </div>
  </body>
</html>
