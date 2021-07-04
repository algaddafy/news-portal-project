<?php include "header.php"; 

if($_SESSION['user_role'] == '0'){
  header("location: post.php");
}

if(isset($_POST['submit'])){

    include 'config.php';

    $user_id = mysqli_real_escape_string($connection,$_POST['user_id']);
    $fname = mysqli_real_escape_string($connection,$_POST['f_name']);
    $lname = mysqli_real_escape_string($connection,$_POST['l_name']);
    $user = mysqli_real_escape_string($connection,$_POST['username']);
    $role = mysqli_real_escape_string($connection,$_POST['role']);

    //UPDATE `user` SET `first_name` = 'Nirobz' WHERE `user`.`user_id` = 1;

    $query1 = "UPDATE user SET 
    first_name = '{$fname}', 
    last_name = '{$lname}',
    username = '{$user}',
    role = '{$role}' WHERE user_id = '{$user_id}'";

    $result1 = mysqli_query($connection,$query1) or die("Query faild.");
    if($result1){
      header("location: users.php");
    }
}





?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="admin-heading">Modify User Details</h1>
              </div>
              <div class="col-md-offset-4 col-md-4">
                  <!-- Form Start -->

<?php 

      $user_id = $_GET['id'];

      include "config.php";
      $query = "SELECT * FROM user WHERE user_id = {$user_id}";
      $result = mysqli_query($connection,$query) or die("Failed");
      $count = mysqli_num_rows($result);

      if($count > 0){
      while($row = mysqli_fetch_assoc($result)){

?>

                  <form  action="<?php $_SERVER['PHP_SELF'] ?>" method ="POST">
                      <div class="form-group">
                          <input type="hidden" name="user_id"  class="form-control" value="<?php echo $row['user_id'] ?>" placeholder="" >
                      </div>
                          <div class="form-group">
                          <label>First Name</label>
                          <input type="text" name="f_name" class="form-control" value="<?php echo $row['first_name'] ?>" placeholder="" required>
                      </div>
                      <div class="form-group">
                          <label>Last Name</label>
                          <input type="text" name="l_name" class="form-control" value="<?php echo $row['last_name'] ?>" placeholder="" required>
                      </div>
                      <div class="form-group">
                          <label>User Name</label>
                          <input type="text" name="username" class="form-control" value="<?php echo $row['username'] ?>" placeholder="" required>
                      </div>
                      <div class="form-group">
                          <label>User Role</label>
                          <select class="form-control" name="role" value="<?php echo $row['role']; ?>">
                            <?php 
                                  if($row['role'] == 1){
                                  
                                echo  "<option value='0'>Moderator</option>";
                                echo  "<option value='1' selected >Admin</option>";

                                  }else{
                                 
                                 echo  "<option value='0' selected >Moderator</option>";
                                 echo  "<option value='1'>Admin</option>";

                                  }
                            ?>

                          </select>
                      </div>
                      <input type="submit" name="submit" class="btn btn-primary" value="Update" required />
                  </form>
                  <!-- /Form -->

                    <?php 
                          }

                    }

                    ?>



              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
