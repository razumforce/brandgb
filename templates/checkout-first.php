<?php if (!$isAuth): ?>

<form class="checkout-steps__div_form-gr" action="">
  <h3>CHECK AS A GUEST OR REGISTER</h3>
  <p class="checkout-steps__p-light">Register with us for future convenience</p>
  <input type="radio" id="user-guest1" name="user_type" value="gst"><span>CHECKOUT AS GUEST</span><br>
  <input type="radio" id="user-reg1" name="user_type" value="reg" checked><span>REGISTER</span><br><br>
  <h3>REGISTER AND SAVE TIME!</h3>
  <p class="checkout-steps__p-light">Register with us for future convenience</p><br>
  <p class="checkout-steps__p-light1"><i class="fa fa-angle-double-right"></i>Fast and easy checkout</p>
  <p class="checkout-steps__p-light1"><i class="fa fa-angle-double-right"></i>Easy access to your order history and status</p>
  <button type="button" value="" onclick="checkoutNotRegistered()">CONTINUE</button>
</form>
<form class="checkout-steps__div_form-alr" action="">
  <h3>ALREADY REGISTERED?</h3>
  <p class="checkout-steps__p-light">Please log in below</p>
  <label for="login">LOGIN</label><span>*</span><br>
  <input type="text" name="login" id="checkout-login" required><br>
  <label for="password">PASSWORD</label><span>*</span><br>
  <input type="password" name="password" id="checkout-password" required><br>
  <p class="checkout-steps__p-red">*Required Fields</p>
  <button type="button" value="" onclick="userLoginCheckout()">SIGN IN&nbsp;&nbsp;&nbsp;&nbsp;</button>
  <span>Forgot Password?</span>
</form>

<?php endif; ?>


<?php if ($isAuth): ?>

<form class="checkout-steps__div_form-gr" action="">
  <h3>YOU ARE LOGGED IN</h3>
  <p class="checkout-steps__p-light">Your details below</p>
  <div>
    <div>User name: <?php echo $content['user_details']['login']; ?></div>
    <div>E-mail: <?php echo $content['user_details']['email']; ?></div>
  </div>
  <p><br></p>
  <h3>YOUR ORDER DETAILS</h3>
  <div>
    <div>Items in order: <?php echo $content['basket_details']['quantity_total']; ?></div>
    <div>Total amount: <?php echo $content['basket_details']['amount_total']; ?></div>
  </div>
  <button type="button" value="" onclick="checkoutNextStep()">CONFIRM ORDER</button>
</form>
<form class="checkout-steps__div_form-alr" action="">
  
</form>

<?php endif; ?>

