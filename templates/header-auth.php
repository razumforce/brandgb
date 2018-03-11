<?php if (!$isAuth): ?>
<form>
  <label for="login">Login</label><br>
  <input type="text" name="login" id="myaccount-login"><br>
  <label for="password">Password</label><br>
  <input type="password" name="password" id="myaccount-password"><br>
  <input type="checkbox" name="rememberme" id="myaccount-rememberme">
  <label for="rememberme">Remember me</label>
  <input type="button" value="Sign in" onclick="userLogin()">
</form>
<a href="#">Forgot password?</a>
<div>
  <a href="#">Register</a>
</div>
<?php endif; ?>

<?php if ($isAuth): ?>
<div>Welcome,</div>
<div><?=$_SESSION['login'] ?></div>
<div>
  <a href="#">Go to profile</a>
</div>
<div>
  <a href="#" onclick="userLogout()">Logout</a>
</div>
<?php endif; ?>