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
        <div>User name:</div>
        <div>E-mail:</div>
        <div>Password:</div>
      </div>
    </div>
    <div class="profile-main__orders">
      <div>
        <span>Order #</span>
        <span>Order date</span>
        <span>Items: </span>
        <span>Total Amount:</span>
      </div>
      <div>
        <span>111</span>
        <span>2018-03-15</span>
        <span>10</span>
        <span>$125.05</span>
      </div>
    </div>
  </div>
  <?php endif; ?> 
  

</section>

<div class="clearfix"></div>