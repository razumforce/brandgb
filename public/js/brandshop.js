"use strict";
// brandshop - js - init file

$(document).ready(function() {

// код для BROWSE SEARCH на всех страницах

  if($('#header-search-browse').length !== 0) {
    browseLoadOptions();
    $('#btn-header-browse').on('click', searchBrowseItem);
    $('#header-search-browse>div>span:first-child').on('change', loadBrowseInput);
  }

// код для HEADER MENU на всех страницах

  var menuHeader = new Menu();
  menuHeader.init();


  var basket = new Basket($('#shopcart-content'), $('#header-cart'));

  $('body').on('click', bodyClick);
  $('body').on('click', '.styled-drop_box', toggleStyledDropBox);
  $('.styled-drop_box').on('click', 'li', selectStyledDropBox);

  // $('.styled-drop_box').on('click', 'i.fa', toggleStyledDropBox);

// код для My Account на всех страницах

  if($('.header__acc-button').length != 0) {
    $('.header__acc-button').on('click', toggleMyAccount);
    $('.header_myaccount').on('change', basket, refreshBasket);
  }

// код для страницы index.html

  if ($('.featured-items').length !== 0) {
    $('.featured-catalog').first().on('click', '.product-items__item_add>span', basket, gotoSingleItem);
  }

// код для страницы product.html

  if ($('#product-price-slider').length !== 0) {
    productPriceSliderInit();
    productLeftNavInit();
    var productPagination = new ProductByPage($('#product-pagination'), $('.product-items__item'));
    $('.product-choice').first().on('click', '.product-items__item_add>span', basket, gotoSingleItem);
    $('.product__left-nav').first().on('click', 'span', toggleProductCategory);

    $('#product-sort-name>div>span:first-child').on('change', function() {
      productPagination.loadAndShow();
      });
    $('#product-sort-number>div>span:first-child').on('change', function() {
      productPagination.loadAndShow();
      });
  }

// код для страницы single.html

  if ($('.maylike-items').length !== 0) {
    $('button.single-item__item-add').first().on('click', basket, addItemToBasket);
    $('.maylike-catalog').first().on('click', '.product-items__item_add>span', basket, gotoSingleItem);
  }

// код для страницы checkout.html

  if ($('.checkout-steps').length !== 0) {
    checkoutStepsInit();
    $('.checkout-steps').first().on('click', '.checkout-steps__title', toggleCheckoutSteps);
  }

// код для страницы shoppingcart.html



// код для КОРЗИН на всех страницах

  if ($('#shopcart-content').length !== 0) {
    $('#shopcart-content').on('click', '.fa-times-circle', basket, deleteItemFromBasket);
    $('#shopcart-clear-button').on('click', basket, clearBasket);
  }
  if ($('#header-cart').length !== 0) {
    $('#header-cart').on('click', '.fa-times-circle', basket, deleteItemFromBasket);
    $('.header__basket-pic').first().on('mouseenter', basketPicEnterHandler);
    $('.header__basket-pic').first().on('mouseleave', basketPicLeaveHandler);
    $('#header-cart').on('mouseenter', basketPicEnterHandler);
    $('#header-cart').on('mouseleave', basketPicLeaveHandler);
  }
  

});

function gotoSingleItem(event) {
  event.stopPropagation();
  console.log(event.data);
  console.log($(event.currentTarget).parent().parent().attr('data-id') == '');
  var id = $(event.currentTarget).parent().parent().attr('data-id')
  console.log(id);

  if (typeof id === 'undefined' || id === '') {
    console.log('no data-id!!!');
  } else {
    window.location.href = './single?id=' + id;
  }
}

function deleteItemFromBasket(event) {
  console.log(event.currentTarget);
  var id = $(event.currentTarget).parent().parent().attr('data-id');
  if (typeof id === 'undefined' || id === '') {
    console.log('no data-id!!!'); // вообще-то ИЗБЫТОЧНО. в корзине по опредению должно быть data-id
  } else {
    var cid = $(event.currentTarget).parent().parent().attr('data-cid');
    console.log(cid);
    var sid = $(event.currentTarget).parent().parent().attr('data-sid');
    var shid = $(event.currentTarget).parent().parent().attr('data-shid');
    console.log('XXX delete started!', id, cid, sid, shid);
    event.data.delete(id, cid, sid, shid);
  }
}

function clearBasket(event) {
  event.data.clear();
}

function refreshBasket(event) {
  event.data.collectBasketItems();
}

function basketPicEnterHandler() {
  var headerCart = document.getElementById('header-cart');
  headerCart.style.display = 'block';
}

function basketPicLeaveHandler() {
  var headerCart = document.getElementById('header-cart');
  headerCart.style.display = 'none';
}

// styled-drop-box - functionality

function bodyClick(event) {
  if ($(event.target).hasClass('styled-drop_box') || $(event.target).parent().hasClass('styled-drop_box') ||
      $(event.target).parent().parent().hasClass('styled-drop_box') ||
      $(event.target).parent().parent().parent().hasClass('styled-drop_box')) {

  } else {
    closeAllDropBox();
  }
}

function toggleStyledDropBox(event) {
  var $currentDrop = $(event.currentTarget).children('ul').first();

  if ($currentDrop.css('display') == 'none') {
    closeAllDropBox();
    $currentDrop.css('display', 'block');
  } else {
    $currentDrop.css('display', 'none');
  }
}

function selectStyledDropBox(event) {
  $(event.currentTarget).parent().parent().children('div').first().children('span').first()
    .html($(event.currentTarget).html()).trigger('change');
}

function closeAllDropBox() {
  $('.styled-drop_box').each(function(i, elem) {
    $(this).children('ul').first().css('display', 'none');
  });
}

function browseLoadOptions() {
  $.get({
      url: './serverdata/browseoptions.json',
      dataType: 'json',
      success: function (data) {
          if (data.result) {
            styledLoadOptions($('#header-search-browse>ul'), data.options);
          } else {
            console.log('SOMETHING WENT WRONG, ERROR MESSAGE: ' + data.message);
          }
          
      }
  });
}

function styledLoadOptions($elem, data) {
  $elem.html('');
  for (var i in data) {
    var $option = $('<li />', {
      html: data[i]
    });
    $option.appendTo($elem);
  }
}

function loadBrowseInput(event) {
  console.log($(event.currentTarget).html());
  $.get({
      url: './serverdata/catinputdata.json',
      dataType: 'json',
      success: function (data) {
          if (data.result) {
            $('#header-browse-input').autocomplete({
              source: data.options
            });
          } else {
            console.log('SOMETHING WENT WRONG, ERROR MESSAGE: ' + data.message);
          }  
      }
  });
}

function searchBrowseItem(event) {
  console.log($('#header-browse-input').val());
  $('#info-dialog').attr('title', 'Search');
  $('#info-dialog').html('Searching for: ' + $('#header-browse-input').val());
  $('#info-dialog').dialog();
}

function toggleMyAccount(event) {
  $('.header_myaccount').slideToggle();
}

function userLogin() {
  var login = $('#myaccount-login').val();
  var password = $('#myaccount-password').val();
  var rememberme = $('#myaccount-rememberme').prop('checked');
  $.ajax({
    type: 'post',
    dataType: "json",
    url: '/api/login.php',
    data: {
      login: login,
      password: password,
      rememberme: rememberme
    },
    success: function(response) {
      console.log(response);
      $('.header_myaccount').html(response.html);
      if (response.result) {
        $('.header__acc-button>a').html('My Account <i class="fa fa-caret-down"></i>');
        setTimeout(function() {
          $('.header_myaccount').slideToggle();
        }, 1500);
        $.ajax({
          type: 'post',
          dataType: 'json',
          url: './api/get-basket.php',
          data: {
            request: 'merge'
          },
          success: function(response) {
            console.log('BASKET COOKIE CLEARED!');
          }
        });
        $('.header_myaccount').trigger('change');
        $.ajax({
          type: 'post',
          dataType: 'json',
          url: './api/get-checkoutstep.php',
          data: {},
          success: function(response) {
            $('.checkout-steps__div').first().html(response);
          }
        });
      }
    }
  });
}

function userLogout() {
  $.ajax({
    type: 'post',
    dataType: "json",
    url: '/api/logout.php',
    success: function(response) {
      console.log(response);
      $('.header__acc-button>a').html('Sign in <i class="fa fa-caret-down"></i>');
      $('.header_myaccount').html('Logout Successful!');
      setTimeout(function() {
        $('.header_myaccount').slideToggle(function() {
          $('.header_myaccount').html(response);
        });
      }, 1500);
      $('.header_myaccount').trigger('change');
      $.ajax({
        type: 'post',
        dataType: 'json',
        url: './api/get-checkoutstep.php',
        data: {},
        success: function(response) {
          $('.checkout-steps__div').first().html(response);
        }
      });
    }
  });
}

function userLoginCheckout() {
  var login = $('#checkout-login').val();
  var password = $('#checkout-password').val();
  var rememberme = false;
  $.ajax({
    type: 'post',
    dataType: "json",
    url: '/api/login.php',
    data: {
      login: login,
      password: password,
      rememberme: rememberme
    },
    success: function(response) {
      console.log(response);
      $('.header_myaccount').html(response.html);
      if (response.result) {
        $('.header__acc-button>a').html('My Account <i class="fa fa-caret-down"></i>');
        $.ajax({
          type: 'post',
          dataType: 'json',
          url: './api/get-basket.php',
          data: {
            request: 'replace'
          },
          success: function(response) {
            console.log('BASKET COOKIE CLEARED!');
          }
        });
        $('.header_myaccount').trigger('change');
        $.ajax({
          type: 'post',
          dataType: 'json',
          url: './api/get-checkoutstep.php',
          data: {},
          success: function(response) {
            $('.checkout-steps__div').first().html(response);
          }
        });
      }
    }
  });
}

function checkoutNotRegistered() {
  $('#info-dialog').attr('title', 'Continue button pressed');
  $('#info-dialog').html('User NOT registered or NOT logged in!');
  $('#info-dialog').dialog();
}

function checkoutNextStep() {
  $('#info-dialog').attr('title', 'NEXT STEP button pressed');
  $('#info-dialog').html('User logged in - lets go to place ORDER!');
  $('#info-dialog').dialog();  
}
