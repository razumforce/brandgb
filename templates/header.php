<header class="header">
  <div class="container-w">
  
    <div class="header__logo">
      <a href="./">
        <div class="header__logo-pic">
          <img src="img/brand-logo.png" alt="Logo">
        </div>
        <div class="header__logo-text">
          <span>BRAN<span class="special-text_color">D</span></span>
        </div>
      </a>
    </div>
    
    <div class="header__search-bar">
      <div class="header__search-bar_browse">
        <div id="header-search-browse" class="styled-drop_box">
          <div>
            <span>Browse</span>
            <span><i class="fa fa-caret-down"></i></span>
          </div>
          <ul>
            <li>Men</li>
            <li>Women</li>
            <li>Kids</li>
            <li>Accessories</li>
          </ul>
        </div>
      </div>
      <div class="header__search-bar_form">
          <input id="header-browse-input" class="header__search-bar_item" type="text" name="search-item"  placeholder="Search for &nbsp;Item..." required pattern="^[a-zA-Z]+$">
          <button id="btn-header-browse" class="header__search-bar_button" type="submit" value=""><i class="fa fa-search"></i></button>
      </div>
    </div>
    
    <div class="header__acc-controls">
      <div class="header__basket-pic">
        <a href="#">
          <span id="cart_qty" class="badge"></span>
          <img src="img/Livecart.png" alt="Your cart">
        </a>
      </div>
      <div class="header__acc-button">
        <?php if (!$isAuth): ?>
        <a href="#">Sign in <i class="fa fa-caret-down"></i></a>
        <?php endif; ?>
        <?php if ($isAuth): ?>
        <a href="#">My Account <i class="fa fa-caret-down"></i></a>
        <?php endif; ?>
      </div>

      <div id="header-cart" class="header_cart" style="display: none">
        <div id="header-cart-content" class="header_cart__content">
        </div>
        <div class="header_cart__total">
          <span>TOTAL</span><span id="headercart-total">$0</span>
        </div>
        <div class="header_cart__checkout">
          <a id="headcart-checkout" href="./checkout">CHECKOUT</a>
        </div>
        <div class="header_cart__gotocart">
          <a id="headcart-gotocart" href="./shoppingcart">GO TO CART</a>
        </div>
      </div>
      
      <div class="header_myaccount" style="display: none">
        <?php include 'header-auth.php'; ?>
      </div>

    </div>
  </div>
</header>

<div class="clearfix"></div>