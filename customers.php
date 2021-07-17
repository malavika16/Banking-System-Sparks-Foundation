<?php
    include 'includes/common.php';
    $sql = "SELECT * FROM `bank`.`users`";
    $result = mysqli_query($con,$sql);
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
        <style>
          h2{
            padding-top: 70px;
          }
          body{
            background: url(images/s2.jpg) no-repeat center center;
            height: 100%;
            background-size: cover;
            position: relative;

          }
          th{
            background-color: #585858;
            color:white;
          }
          tbody{
            background-color: #F8F8FF;
          }
          .footer{
            margin-top: 20px;
          }
        </style>

    </head>
    <body>
      <?php
        include 'includes/header.php';
        ?>
<div class="container">
  <h2 class="text-center"><strong>Our Customers</strong></h2><br><br>
  <div class="table-responsive">
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>SL No.</th>
        <th>Name</th>
        <th>Email</th>
        <th>Account Balance</th>
        <th>View</th>
      </tr>
    </thead>
    <tbody>
      <?php
          while($rows=mysqli_fetch_assoc($result)){
      ?>
      <tr>
        <td class="py-2"><?php echo $rows['id'] ?></td>
        <td class="py-2"><?php echo $rows['name']?></td>
        <td class="py-2"><?php echo $rows['email']?></td>
        <td class="py-2"><?php echo $rows['balance']?></td>
        <td><a href="view.php?id= <?php echo $rows['id'] ;?>"> <button type="button" class="btn btn-info">View</button></a></td>

      </tr>
      <?php
          }
      ?>
    </tbody>
  </table>
</div>
</div>
</body>
<?php
include 'includes/footer.php';
?>
</html>
