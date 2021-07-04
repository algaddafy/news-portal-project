<?php include "header.php"; 

if($_SESSION['user_role'] == '0'){
  header("location: post.php");
}


?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-10">
                  <h1 class="admin-heading">All Users</h1>
              </div>
              <div class="col-md-2">
                  <a class="add-new" href="add-user.php">add user</a>
              </div>
              <div class="col-md-12">

<?php 

  include "config.php";
  $limit = 3;

if(isset($_GET['page'])){
  $page_number = $_GET['page'];
}else{
  $page_number = 1;
}
  
  $offset = ($page_number - 1) * $limit;


  $query = "SELECT * FROM user ORDER BY user_id DESC LIMIT {$offset}, {$limit}";
  $result = mysqli_query($connection,$query) or die("Failed");
  $count = mysqli_num_rows($result);

  if($count > 0){

?>
                  <table class="content-table">
                      <thead>
                          <th>DB ID</th>
                          <th>Full Name</th>
                          <th>User Name</th>
                          <th>Role</th>
                          <th>Edit</th>
                          <th>Delete</th>
                      </thead>
                      <tbody>

<?php 
    while($row = mysqli_fetch_assoc($result)){

?>
              <tr>
                  <td class='id'><?php echo $row['user_id'] ?></td>
                  <td><?php echo $row['first_name']." ".$row['last_name'] ?></td>
                  <td><?php echo $row['username'] ?></td>
                  <td>
               <?php 

                  if($row['role'] == 1){
                      echo "Admin";
                  }else{
                    echo "Moderator";
                  }
                    
               ?>
                  </td>
                  <td class='edit'><a href='update-user.php?id=<?php echo $row['user_id'] ?>'><i class='fa fa-edit'></i></a></td>
                  

                  <td class='delete'><a onclick="return confirm('Are You Sure?')" href='delete-user.php?id=<?php echo $row['user_id'] ?>'><i class='fa fa-trash-o'></i></a></td>
              </tr>

<?php } ?>

                      </tbody>

        <?php } ?>
                  </table>

<?php 

      include "config.php";
      $query2 = "SELECT * FROM user";
      $result2 = mysqli_query($connection,$query2) or dir("Failed.");
      if(mysqli_num_rows($result2)){
        $total_records = mysqli_num_rows($result2);
        $total_page = ceil($total_records/$limit);

        echo "<ul class='pagination admin-pagination'>";
        if($page_number > 1){
          echo '<li><a href="users.php?page='.($page_number-1).'">prev</a></li>';
        }
        
        for($i = 1; $i <= $total_page; $i++){

          if($i == $page_number){
            $active = "active";
          }else{
            $active = "";
          }

          echo '<li class='.$active.'><a href="users.php?page='.$i.'">'.$i.'</a></li>';
        }
        if($total_page > $page_number){
          echo '<li><a href="users.php?page='.($page_number+1).'">next</a></li>';
        }
        echo "</ul>";
      }
      

?>

                      <!-- <li class="active"><a>1</a></li> -->
                      
                  






              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
