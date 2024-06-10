
<?php 
include('header.php');
?>

<?php

if(isset($_POST['comment']) && $_POST['comment'] !=''){
    $post_id=$_GET['id'];
    // $comment = $_POST['comment'];
    $blog->post_comment($post_id);
}

// jodi id set hoy and 0-thekewo jodi id number beshi thake tahole next page a jabe abong arry ar maddome data dekhabe 
if(isset($_GET['id']) && $_GET['id']>0){
    $result = $blog->getPost($_GET['id'])[0];
    // echo $blog->prd($result);
}else{
    // redirect
    // back main page
    header('location: ./');
}

?>

<!-- Main header -->
<div class="row mt-0 mt-md-5">

<!-- full post section -->
    <div class="col-lg-8">
            <div class="full_post mt-5">

            <!-- post image -->
                <img src="assets/image/<?php echo $result['thambnail'] ?>" alt="post">

                <h2 class="title">
                    <span class="text">
                        <!-- post title -->
                        <div><?php echo $result['title'] ?></div>
                    </span>
                </h2>

                <div class="content">
                    <!-- post description -->
                <?php echo $result['discription'] ?>
                </div>

                <div class="col-md-12 mt-5 comment_input_box">
                    <h4 class="title">Post your comment</h4>
                    <form action="" method="post">
                        <textarea name="comment" rows="6" id="" class="form-control" placeholder="Write your comment..."></textarea>
                        <button class="post float-end" type="submit">
                            Post comment
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>

                <!-- comment section -->
                <div class="col-md-12 post_comment">
                    <?php 
                    $rows =$blog->getComments($_GET['id']);
                    foreach($rows as $row){
                    ?>
                    <div class="comment_box mt-3">
                        <div class="comment">
                            <?php echo $row['comment'] ?>
                        </div>
                        <div class="comment_by">
                            Unknown
                        </div>
                    </div>
                    <?php } ?>
                </div>


            </div>
    </div>

    <!-- latest post and categories section -->
    <div class="col-lg-4 mt-5">
        <div class="row">
                 <!-- latest post start -->
                 <div class="col-md-12 latest_post ms-0 ms-md-3">
                    <h4 class="title">
                        Latest Blog
                    </h4>

                    <?php 
                    $rows=null;
                    $rows=$blog->getPost(null, 5);
                    foreach($rows as $row){
                    
                    ?>

                    <div class="post">
                        <a href="post?id=<?php echo $row['id'] ?>"><img src="assets/image/<?php echo $row['thambnail'] ?>" alt="thambnail" class="thumbnail"></a>
                        <div class="content">
                            <a href="post?id=<?php echo $row['id'] ?>" class="title"><?php echo $row['title'] ?></a>
                        <div class="desc">
                        <?php echo substr($row['discription'], 0, 56).'.....' ?>
                        </div>
                        </div>
                    </div>

                    <?php } ?>

                </div>
                    <!-- Latest post end -->

                    
                    <!-- Categories -->
                     <div class="col-md-12 categories ms-0 ms-md-3">
                        <h4 class="title">Categories</h4>
                        <ul>
                        <?php 
                            $rows=$blog->getCategory();
                            foreach($rows as $row){
                                $count=$blog->getPostCount_byCategory($row['id']);
                                echo '<li ><a href="#">'.$row['name'].' ('.$count.')</a></li>';
                            }
                            ?>
                        </ul>
                     </div>

                    <!-- Categories end -->



               </div>
    </div>

</div>


<?php 
include('footer.php');
?>