<?php
include 'includes/common.php';

if(isset($_POST['submit']))
{
    $from = $_GET['id'];
    $to = $_POST['to'];
    $amount = $_POST['amount'];

    $sql1 = "SELECT * from `bank`.`users` WHERE id = $from";
    $query = mysqli_query($con,$sql1);
    $sql2 = mysqli_fetch_array($query);

    $sql1 = "SELECT* from `bank`.`users` WHERE id=$to";
    $query = mysqli_query($con,$sql1);
    $sql3 = mysqli_fetch_array($query);

    if (($amount)<0)       // constraint to check if input is a negative value
   {
        echo '<script type="text/javascript">';
        echo ' alert("Negative values cannot be transferred!")';
        echo '</script>';
    }
    else if($amount > $sql2['balance'])    // constraint to check insufficient balance
    {

        echo '<script type="text/javascript">';
        echo ' alert("Insufficient Balance")';  // showing an alert box.
        echo '</script>';
    }
    else if($amount == 0){              // constraint to check if amount is zero

         echo "<script type='text/javascript'>";
         echo "alert('Amount cannot be zero')";
         echo "</script>";
     }

    else {
                $newbalance = $sql2['balance'] - $amount;
                $sql = "UPDATE users set balance=$newbalance where id=$from";
                mysqli_query($con,$sql);

                $newbalance = $sql3['balance'] + $amount;
                $sql = "UPDATE users set balance=$newbalance where id=$to";
                mysqli_query($con,$sql);

                $sender = $sql2['name'];
                $receiver = $sql3['name'];

                $sql = "INSERT INTO `bank`.`transactions`( `sender`, `receiver`, `amount`, `ttime`) VALUES ('$sender','$receiver','$amount', current_timestamp());";
                $query = mysqli_query($con,$sql);

                if($query){
                     echo "<script> alert('Transaction Successful');
                                     window.location='transactions.php';
                           </script>";
                }
                $newbalance= 0;
                $amount =0;
        }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>ABC Bank</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="style.css">

        <style media="screen">
        body{
          background: url(images/s2.jpg) no-repeat center center;
          height: 100%;
          background-size: cover;
          position: relative;
        }
        .container1{
          background-color: #fafafa;
          border-style: outset;
        }
        .label{
          color:black;
        }
        </style>
    </head>
    <body>
      <?php
        include 'includes/header.php';

        
            $link = mysqli_connect("localhost", "root", "", "bank");
            $sid=$_GET['id'];
            $sql = "SELECT * FROM `bank`.`users` WHERE id= $sid";
            $result=mysqli_query($con,$sql);
            if(!$result)
            {
                echo "Error : ".$sql."<br>". mysqli_error($conn);
            }
            $rows = mysqli_fetch_assoc($result);
        ?>
        <form method="post" name="tcredit" class="tabletext" ><br>

              <div  class="container container1 jumbotron">
                <h2 class="text-center"><strong><u>User Details</u></strong></h2><br>
                <h4><strong>Name: <strong><?php echo $rows['name'] ?> </h4>
                <h4><strong>Email: <strong><?php echo $rows['email'] ?> </h4>
                <h4><strong>Account Balance: <strong><?php echo $rows['balance'] ?> </h4>
          </div>
          <br><br><br>
          <div class="container container1">
          <label class="label" style="font-size:15px;">Transfer To:</label>
          <select name="to" class="form-control" class="selectcl" required >
          <br><br>
              <option value="" disabled selected>Select Customer</option>
              <?php
                  include 'includes/common.php';
                  $sid=$_GET['id'];
                  $sql = "SELECT * FROM `bank`.`users` where id!=$sid";
                  $result=mysqli_query($con,$sql);
                  if(!$result)
                  {
                      echo "Error ".$sql."<br>".mysqli_error($con);
                  }
                  while($rows = mysqli_fetch_assoc($result)) {
              ?>
                  <option class="table" value="<?php echo $rows['id'];?>" >

                      <?php echo $rows['name'] ;?> (Balance:
                      <?php echo $rows['balance'] ;?> )

                  </option>
              <?php
                  }
              ?>
              <div>
          </select>
          <br>
          <br>
              <label class="label" style="font-size:15px;">Amount:</label>
              <input type="number" class="form-control" name="amount" required>
              <br><br>
                  <div class="text-center" >
              <button class="btn btn-primary" name="submit" type="submit" id="myBtn">Transfer</button>
              </div>
          </form>
      </div>
    </div>
  </body>
  <?php
  include 'includes/footer.php';
  ?>
  </html>
