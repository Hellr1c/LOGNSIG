<?php
include('config.php');
$current=date('d-M-y');

if(isset($_POST['Fname'])){
  $Fname=$_POST['Fname'];
  $Lname=$_POST['Lname'];
  $Email=$_POST['Email'];
  $Phone=$_POST['Phone'];
  $JobTitle=$_POST['JobTitle'];
  $VALIDATIONsql = "SELECT EmployeeFN, EmployeeLN FROM employees WHERE EmployeeFN = '$Fname' AND EmployeeLN = '$Lname'";
  $sql = "INSERT INTO employees SET EmployeeFN = '$Fname', EmployeeLN = '$Lname', EmployeeEmail = '$Email',EmployeePhone = '$Phone', HireDate = '$current', ManagerID = 50, JobTitle = '$JobTitle'";
  $ifrecordexists = $conn->query($VALIDATIONsql);
  if ($ifrecordexists->num_rows > 0) {
      echo "Record already exists! Please Try Again!";
  }
  else {
    if($conn->query($sql)){
      header("location:EmployeeList.php");
    }
    else{
      echo $conn->error;
    }
  }
}
?>
