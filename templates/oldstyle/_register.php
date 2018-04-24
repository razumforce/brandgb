<?php include 'header-bc.php'; ?>

<div class="container-w">

  <?php

  if (!$isAuth) {
    include 'register-main.php';
  } else {
    echo "<script>window.location = './profile'</script>";
  }
   
  ?>
    
</div>


