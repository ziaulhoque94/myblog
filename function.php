<?php 
// $db=mysqli_connect('localhost', 'root', '', 'myblog');


class blog
{
    private $db=null;
    function __construct()
    {
        date_default_timezone_set('Asia/Dhaka');
        $this->db=$db=mysqli_connect('localhost', 'root', '', 'myblog');
    }

    function getPost($post_id=null, $limit=null, $search=null, $categories_id=null){

        $sql="SELECT posts.*,categories.name as category FROM posts,categories where posts.categories_id=categories.id ";


        if($post_id != null){
            $sql .="AND posts.id = '$post_id' ";
        }

        if($search != null){
            $sql .="AND posts.title LIKE '%$search%' OR posts.discription LIKE '%$search%' ";
        }

        if($categories_id != null){
            $sql .="AND posts.categories_id = '$categories_id' ";
        }

         $sql .= "GROUP BY posts.id ORDER BY posts.created_on DESC ";

        if($limit != null){
            $sql .="LIMIT $limit ";
        }
        //  return $sql;
       return $this->db->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    // add catagory funtion
    function getCategory(){
        $sql="SELECT *FROM `categories`";

        return $this->db->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    // post count function
    function getPostCount_byCategory(int $category_id){
        $sql="SELECT count(*) as total FROM `posts` WHERE categories_id=$category_id";
        return $this->db->query($sql)->fetch_assoc()['total'];
    }

    // comment function
    function post_comment($post_id){
        $comment = $this->clean_input($_POST['comment']);
        $created_on=date('Y-m-d H:i:s');
        $sql="INSERT INTO `myblog`.`comments`(`post_id`,`comment`,`created_on`) VALUES ('$post_id','$comment','$created_on')";
        $this->db->query($sql);

    }

    function getCommentCount_ByPostId(int $post_id){
        $sql="SELECT count(*) as total FROM `comments` WHERE post_id=$post_id";
        return $this->db->query($sql)->fetch_assoc()['total'];
    }
    function clean_input($input){
        if($input!=''){
            return strip_tags($this->db->real_escape_string(trim($input)));
        }
    }

    // fetch comment
    function getComments($post_id=null){
        $sql="SELECT *FROM `comments` ";

        if($post_id!=null){
            $sql .="WHERE post_id='$post_id' ";
        }
        // for latest post
        // $sql .="ORDER BY created_on DESC ";
        // if($limit!=null){
        //     $sql .="LIMIT $limit";
        // }

        return $this->db->query($sql)->fetch_all(MYSQLI_ASSOC);
    }
    // for latest comment
    function getLatest_Comments(){
        // join query
        $sql="SELECT comments.comment, posts.title, posts.id FROM comments,posts WHERE comments.post_id=posts.id ORDER BY comments.created_on DESC LIMIT 5";
        return $this->db->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    // for search highlight method
    public static function getHighlight_search($text, $word){
         return preg_replace('#'.preg_quote($word).'#i','<span class="hlw">\\0</span>',$text);
    }
    // for test function
    function prd($arr){
        echo '<pre>';
        print_r($arr);
        echo '</pre>';
    }
}
