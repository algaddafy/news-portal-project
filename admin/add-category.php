<?php include "header.php"; ?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="admin-heading">Add New Category</h1>
              </div>
              <div class="col-md-offset-3 col-md-6">
                  <?php 

if(isset($_POST['save'])){

    include 'config.php';

    $category_name = mysqli_real_escape_string($connection,$_POST['category_name']);

    $query = "SELECT category_name FROM category WHERE category_name='{$category_name}'";
    $result = mysqli_query($connection,$query) or die("Query faild.");

    $count = mysqli_num_rows($result);
    if($count > 0){
      echo "Category Already Exists.";
    }else{
      $query1 = "INSERT INTO category (category_name) 
      VALUE ('$category_name')";
      $result = mysqli_query($connection,$query1) or die("Query Failed.");

      if($result){
        header("location: category.php");
      }



    }

}


                   ?>


                  <!-- Form Start -->
                  <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">
                      <div class="form-group">
                          <label>Category Name</label>
                          <input type="text" name="category_name" class="form-control" placeholder="Category Name" required>
                      </div>
                      <input type="submit" name="save" class="btn btn-primary" value="Save" required />
                  </form>
                  <!-- /Form End -->
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
