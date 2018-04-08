<section class="profile-main">
  <?php if (!$isAuth): ?>
  <div class="profile-main__div">
    <div class="profile-main__title">
      <span>Please Sign in or Register in order to view your profile</span>
    </div>
  </div>
  <?php endif; ?>

  <?php if ($isAuth): ?>
  <div class="profile-main__div">
    <div class="profile-main__title">
      <span>Your personal profile</span>
    </div>
    <div class="profile-main__user">
      <p class="profile-main__p-light">Your details</p>
      <div>
        <div>User name: <?php echo $content['user_details']['login']; ?></div>
        <div>E-mail: <?php echo $content['user_details']['email']; ?></div>
        <div>Password: <?php echo $content['user_details']['password']; ?></div>
      </div>
    </div>
    <div class="profile-main__orders">
      <div>
        <span>Order #</span>
        <span>Order date</span>
        <span>Items: </span>
        <span>Total Amount:</span>
      </div>
      <?php foreach ($content['orders'] as $order): ?>
      <div>
        <span><?=$order['id_order']?></span>
        <span><?=$order['date']?></span>
        <span><?=$order['quantity']?></span>
        <span><?=$order['amount']?></span>
      </div>
    <?php endforeach; ?>
    </div>
  </div>
  <?php endif; ?> 
  

</section>

<div class="clearfix"></div>