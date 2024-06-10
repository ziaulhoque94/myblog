<?php
require_once('header.php');
?>

<div class="row mt-0 mt-md-5 g-5">
    <?php
    $rows=$blog->getCategory();
    foreach($rows as $row){
    ?>
    <div class="col-lg-3 col-md-4 col-sm-6">
        <a href="./?cat=<?php echo $row['id'] ?>" class="category mx-3 mx-sm-0">
            <h3 class="name"><?php echo $row['name'] ?></h3>
            <h5 class="post_count">
                <?php 
                echo $blog->getPostCount_byCategory($row['id']);
                ?>
                <span>Post</span>
            </h5>
        </a>

    </div>
    <?php } ?>
</div>

<?php
require_once('footer.php');
?>