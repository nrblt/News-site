<?php

function getConnection() {
$host = 'localhost';
$db = 'SimpleDB';
$user = 'root';
$pass = 'root';

$conn = mysqli_connect($host, $user, $pass, $db);

if (mysqli_connect_error()) {
    
    echo mysqli_connect_errno().": ".mysqli_connect_error();
    exit;
}
return $conn;
}

function searchInDB($login, $pass) {
    $conn = getConnection();
    $sql = 'SELECT * FROM users WHERE login="'. $login .'" AND pass="'. $pass .'"';
    $res = $conn->query($sql);
    if ($conn->error) {
        print_r($conn->error);
    }
    $user = $res->fetch_assoc();
    if($user==null){
        return false;
    }
    if ($login == $user['login'] && $pass == $user['pass']) {
        return $user;
    }
    return false;
}

function getPosts() {
    $conn = getConnection();
    $sql = "SELECT * from post ORDER BY id DESC";
    $res = $conn->query($sql);
    return $res->fetch_all(MYSQLI_ASSOC);

}

function createPost($title, $content, $img_url, $login) {
    $conn = getConnection();
    $img_url = ($img_url) ? $img_url : NULL;
    $sql = <<<SQL
    INSERT INTO post (title, content, img, author) VALUES (
        "$title", "$content", "$img_url", "$login"
    )
    SQL;
    $res = $conn->query($sql);

    if ($conn->error) {
        echo $conn->error;
    } else {
        header("Location: news.php");
    }
}

function getPostByID($id) {
    $conn = getConnection();

    $sql = 'SELECT * from post WHERE id = "'.$id.'"';
    $res = $conn->query($sql);
    return $res->fetch_assoc();
}

function updatePostByID($id, $title, $content, $img_url) {
    $conn = getConnection();
    $sql = <<<SQL
    UPDATE post SET title="$title", content="$content", img="$img_url" WHERE id = "$id"
    SQL;

    $res = $conn->query($sql);
    echo $conn->error;
    header("Location: news.php");
}


function deletePost ($post_id) {
    $conn = getConnection();
    $sql = <<< SQL
    DELETE FROM post WHERE id=$post_id
    SQL;

    $res = $conn->query($sql);
    echo $conn->error;
    header("Location: news.php");

}


function renderButtons($account_type, $post_id) {

    if ($account_type == "moder") {
        echo <<< htmlblock
        <div  class="text-left m-3">
            <a class="text-success mr-"href="edit_post.php?post_id=$post_id">Edit post</a>
            <a class="text-danger"href="delete_post.php?post_id=$post_id">Delete post</a>
        </div> 
        htmlblock;
    }
    else if ($account_type == "admin") {
        echo <<< htmlblock
        <div  class="text-left m-3">
            <a class="text-success"href="edit_post.php?post_id=$post_id">Edit post</a>
        </div> 
        htmlblock;
    }
    else {
        return false;
    }
}

function renderEditing() {
    $post_id = $_GET['post_id'];

    $post = getPostByID($post_id);
    $title = $post['title'];
    $img = $post['img'];
    $content = $post['content'];
    echo <<<hmtlblock
    <div class="container">
        <form action="edit_post.php" method="get">
            <h3>Post editing</h3>
            <input type="text" class="" name="post_id" value="$post_id" style="display: none;">
            <div class="mt-2">
              <input type="text" name="title" placeholder="Title" value="$title">
            </div>
            <div class="mt-2">
              <input type="text" name="img" placeholder="image url" value="$img">
             </div>
            <div class="mt-2">
              <textarea name="content" id="content-area" cols="30" rows="10">$content</textarea>
            </div>
            <button type="submit" class="btn bg-success mt-2" >Edit post!</button>
        </form>
    </div>
    hmtlblock;
}


function getUsers() {
    $conn = getConnection();
    $sql = "SELECT * from users";
    $res = $conn->query($sql);
    return $res->fetch_all(MYSQLI_ASSOC);
}?>
