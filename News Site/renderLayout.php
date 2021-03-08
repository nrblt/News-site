<?php
require_once 'functions.php';

  session_start();
  $session = $_SESSION['users'];
  $login = $session['login'];
  $account_type = $session['account_type'];

  $posts = getPosts();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Posts</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
   
   <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">  
   </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body>
<?php if (!empty($login)): ?>
  <nav class="text-left text-warning "><h2>Welcome back, <?=$login ?>!</h2></nav>
<?php endif ?>
<section class="">
  <?php if (!empty($login)): ?>
    <a href="new_post.php " class="text-right">
      <div >
         <h1><p>New post</p></h1>
      </div>
    </a>
  <?php endif ?>
  <?php foreach ($posts as $post): ?>
  <article class="">
    <header class="post-header">
      <h1><?= $post['title'] ?></h1>
      <?php renderButtons($account_type, $post['id']);?>
    </header>
    <main>
      <?php if ($post['img']):?>
      <div class="img">
        <a href="<?= $post['img'] ?>" target="_blank">
          <img class="w-100" style="height: auto;max-height: 500px;object-fit: cover;"src="<?= $post['img'] ?>" alt="Placeholder image">
        </a>
      </div>
      <?php endif?>
      <pre>
        <span>
            <?= $post['content'] ?>
          </span>
      </pre>
    </main>
    <footer class="text-right" style="border-bottom:2px black solid">
      <em ><?= $post['author']?></em>
    </footer>
  </article>
  <?php endforeach ?>
</section>
</body>
</html>