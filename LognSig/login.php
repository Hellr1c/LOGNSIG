<?php
include('config.php');
$msg='';
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

if(isset($_POST['txtUname'])){
  $U = $_POST['txtUname'];
  $P = md5($_POST['txtUpass']);
  $sql ="SELECT * FROM users WHERE user_name='$U' AND user_pass='$P'";
  if($rs=$conn->query($sql)){
  	if($rs->num_rows>0){
  		$row=$rs->fetch_assoc();
      $usertype=$row['user_type'];
      $userid=$row['user_id'];
      setcookie('token',$userid);
      switch($usertype){
        case '0' : header("location:EmployeeList.php"); break;
        case '1' : header("location:staff_dash.php"); break;
        case '2' : header("location:guest_dash.php"); break;
      }
    }else{
      $msg = 'Invalid Credentials';
    }
  }else{
    	echo $conn->error;
  }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Login</title>
  </head>
  <body>
    <div style="width:200px; margin:auto;">
      <fieldset>
        <legend>LOGIN</legend>
        <form  method="post">
            <label>USERNAME</label><br/>
            <input type="text" required="true" name="txtUname" placeholder="Enter Username"/><br/>
            <label>PASSWORD</label><br/>
            <input type="password" required="true" name="txtUpass" placeholder="Enter Password"/><br/>
            <input type="submit" name="btnLogin" value="LOGIN"/><br/>
            <button name="signupbtn" onclick="location.href='signup.php';">SIGN UP</button><br/>
            <?php echo $msg; ?>
        </form>
      </fieldset>
    </div>
  </body>
</html>
