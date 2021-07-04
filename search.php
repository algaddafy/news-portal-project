<?php include 'header.php'; ?>
    <div id="main-content">
      <div class="container">
        <div class="row">
            <div class="col-md-8">
                <!-- post-container -->
                <div class="post-container">
                    
<?php 

                    include "admin/config.php";
                    if(isset($_GET['search'])){
                    $search = mysqli_real_escape_string($connection,$_GET['search']);

?>

                  <h2 class="page-heading"> Search: <?php echo $search; ?></h2>
                    

<?php 


  $limit = 3;

if(isset($_GET['page'])){
  $page_number = $_GET['page'];
}else{
  $page_number = 1;
}
  
  $offset = ($page_number - 1) * $limit;


$query = "SELECT post.post_id, post.title, post.description,post.post_img, post.post_date,post.category, category.category_name,user.username,post.author FROM post
  LEFT JOIN category ON post.category = category.category_id
  LEFT JOIN user ON post.author = user.user_id WHERE post.title LIKE '%{$search}%' 
  or post.description LIKE '%{$search}%'
  ORDER BY post.post_id DESC LIMIT {$offset },{$limit}";

  $result = mysqli_query($connection,$query) or die("Failed");
  $count = mysqli_num_rows($result);

  if($count > 0){
    while($row = mysqli_fetch_assoc($result)){

?>


                    <div class="post-content">
                        <div class="row">
                            <div class="col-md-4">
                                <a class="post-img" href="single.php?id=<?php echo $row['post_id'] ?>"><img src="admin/upload/<?php echo $row['post_img'] ?>" alt=""/></a>
                            </div>
                            <div class="col-md-8">
                                <div class="inner-content clearfix">
                                    <h3><a href='single.php?id=<?php echo $row['post_id'] ?>'><?php echo $row['title'] ?></a></h3>
                                    <div class="post-information">
                                        <span>
                                            <i class="fa fa-tags" aria-hidden="true"></i>
                                            <a href='category.php?search=<?php echo $row['category'] ?>'><?php echo $row['category_name'] ?></a>
                                        </span>
                                        <span>
                                            <i class="fa fa-user" aria-hidden="true"></i>
                                            <a href='author.php?search=<?php echo $row['author'] ?>'><?php echo $row['username'] ?></a>
                                        </span>
                                        <span>
                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                            <?php echo $row['post_date'] ?>
                                        </span>
                                    </div>
                                    <p class="description">
                                        <?php echo substr($row['description'], 0,170)."..." ?>
                                    </p>
                                    <a class='read-more pull-right' href='single.php?id=<?php echo $row['post_id'] ?>'>read more</a>
                                </div>
                            </div>
                        </div>
                    </div>
                        
      <?php }

      }else{
        echo "No Record Found.";
      }

      $query2 = "SELECT * FROM post WHERE post.title LIKE '%{$search}%'";
      $result2 = mysqli_query($connection,$query2) or dir("Failed.");
      if(mysqli_num_rows($result2)){
        $total_records = mysqli_num_rows($result2);
        $total_page = ceil($total_records/$limit);

        echo "<ul class='pagination admin-pagination'>";
        if($page_number > 1){
          echo '<li><a href="search.php?search'.$search.'&page='.($page_number-1).'">prev</a></li>';
        }
        
        for($i = 1; $i <= $total_page; $i++){

          if($i == $page_number){
            $active = "active";
          }else{
            $active = "";
          }

          echo '<li class='.$active.'><a href="search.php?search='.$search.'&page='.$i.'">'.$i.'</a></li>';
        }
        if($total_page > $page_number){
          echo '<li><a href="search.php?search='.$search.'&page='.($page_number+1).'">next</a></li>';
        }
        echo "</ul>";
      }
                    }else{
                    echo "<h2>No Record Found.</h2>";
                  }

      ?>


                </div><!-- /post-container -->
            </div>
            <?php include 'sidebar.php'; ?>
        </div>
      </div>
    </div>
<?php include 'footer.php'; ?>
