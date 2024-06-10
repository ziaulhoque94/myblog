<?php include('header.php'); ?>


        <!-- Main header -->
        <div class="row mt-0 mt-md-5">


            <!-- post section -->
            <div class="col-lg-8">

                <?php 
                $search=null;
                if(isset($_GET['search']) && $_GET['search']!=''){
                    $search =trim($_GET['search']);
                }

                $catagory_id=null;
                if(isset($_GET['cat']) && $_GET['cat']!=''){
                    $catagory_id =trim($_GET['cat']);
                }

                $rows=$blog->getPost(null, null, $search, $catagory_id);
                //for error test and show query
                // echo $rows; 
                //  die;

                foreach($rows as $row){
                    $title=($search==null)?$row['title']:blog::getHighlight_search($row['title'], $search);
                    $discription=($search==null)?$row['discription']:blog::getHighlight_search($row['discription'], $search);
                ?>

                <div class="card post-box mt-5">
                    <div class="row" style="--postdate:'<?php echo date('d M, Y', strtotime($row['created_on'])); ?>'">
                        <div class="col-md-5">
                            <a href="post?id=<?php echo $row['id'] ?>">
                                <img class="post-image" style="--b:53% 47% 74% 26%/32% 30% 70% 60%" src="assets/image/<?php echo $row['thambnail'] ?>" alt="post">
                            </a>
                        </div>
                        <div class="col-md-7">
                            <h2>
                                <a href="post?id=<?php echo $row['id'] ?>" class="title"><?php echo $title ?></a>
                            </h2>
                            <div>By Admin | 
                                <?php echo $row['category'] ?> | 
                                <?php echo $blog->getCommentCount_ByPostId($row['id']).' Comments'; ?>
                             </div>
                            <p class="content justify"> 
                            <?php echo substr($discription, 0, 164) ?>
                            </p>
                            <div class="df_jcsb">
                                <div class="social">
                                    <a target="_blank" href="https://facebook.com/share.php?u=<?php echo urlencode('https://example.com/post/post?id='.$row['id']) ?>">
                                        <i class="fa-brands fa-facebook"></i>
                                    </a>
                                    <a target="_blank" href="https://api.whatsapp.com/send?text=<?php echo urlencode('https://example.com/post/post?id='.$row['id']) ?>">
                                        <i class="fa-brands fa-whatsapp"></i>
                                    </a>
                                    <a target="_blank" href="https://twitter.com/share?text=<?php echo $row['title'] ?>&url=<?php echo urlencode('https://example.com/post/post?id='.$row['id']) ?>">
                                        <i class="fa-brands fa-twitter"></i></a>
                                    <a target="_blank" href="https://www.linkedin.com/shareing/share-offsite/?url=<?php echo urlencode('https://example.com/post/post?id='.$row['id']) ?>">
                                        <i class="fa-brands fa-linkedin"></i>
                                    </a>
                                </div>
                                <a href="post?id=<?php echo $row['id'] ?>" class="read_more">
                                    <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>


                <?php } ?> <!-- php loop end -->

            </div>
            <!-- post end -->


            <div class="col-lg-4 mt-md-5">
               <div class="row">
                 <!-- latest post start -->
                 <div class="col-md-12 latest_post ms-0 ms-md-3">
                    <h4 class="title">
                        Latest from of our blog
                    </h4>

                    <?php 
                    $rows=null;
                    $rows=$blog->getPost(null, 5);
                    foreach($rows as $row){
                    
                    ?>

                    <div class="post">
                        <a href="#"><img src="assets/image/<?php echo $row['thambnail'] ?>" alt="thambnail" class="thumbnail"></a>
                        <div class="content">
                            <a href="#" class="title"><?php echo $row['title'] ?></a>
                        <div class="desc">
                        <?php echo substr($row['discription'], 0, 56).'.....' ?>
                        </div>
                        </div>
                    </div>

                    <?php } ?>

                </div>
                    <!-- Latest post end -->



                    <!-- latest comment start -->
                    <div class="col-md-12 latest_comment ms-0 ms-md-3">
                            <h4 class="title">Latest Comment</h4>
                            <?php 
                            $rows =$blog->getLatest_Comments();
                            foreach ($rows as $row) { 
                            ?>
                            <div class="comment_box mt-3">
                                <div class="comment">
                                    <?php echo $row['comment'] ?>
                                </div>
                                <div class="comment_by">
                                        Unknown on <a href="post?id=<?php echo $row['id'] ?>"><?php echo $row['title'] ?></a>
                                </div>
                            </div>

                            <?php } ?>

                        </div>
                        <!-- latest comment end -->



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
<?php include('footer.php'); ?>