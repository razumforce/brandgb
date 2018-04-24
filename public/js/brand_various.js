"use strict";

// SINGLE.PHP

function addItemToBasket(event) {
  // event.stopPropagation();

  // console.log($(event.currentTarget).parent().attr('data-id') == '');
  var id = $(event.currentTarget).parent().attr('data-id')

  if (typeof id === 'undefined' || id === '') {
    console.log('no data-id!!!');
  } else {
    var color = $('#single-item-color>div>span:first-child>span').attr('data-cid');
    var size = $('#single-item-size>div>span:first-child>span').attr('data-sid');
    var qty = $('#single-item-qty>div>input').val();
    var shipping = '1'; // for future - 'data-shid', from dropbox
    console.log(id, color, size, qty, shipping);
    event.data.add(id, color, size, qty, shipping);
  }
}


// PRODUCT.PHP

function ProductByPage($root, $productItems) {
    this.$root = $root;
    this.$productItems = $productItems;
    this.totalPages = 1;
    this.currentPage = $root.attr('data-page');
    
    this.showMaxPositions = 8;

    this.loadAndShow();
    this.$root.on('click', 'span.product-choice__pag', this, this.pageClickHandler);
    this.$root.on('click', '#product-pagination-left', this, this.leftClickHandler);
    this.$root.on('click', '#product-pagination-right', this, this.rightClickHandler);
}

ProductByPage.prototype.loadAndShow = function() {
  var itemsPerPage = $('#product-sort-number>div>span:first-child').text();
  var sortBy = $('#product-sort-name>div>span:first-child').text();
  $.ajax({
      type: 'post',
      url: '/index.php',
      dataType: 'json',
      data: {
        metod: 'catalog',
        page: this.currentPage,
        items: itemsPerPage,
        sort: sortBy
      },
      success: function (data) {
        console.log(data);
          if (data.result) {
            this.totalPages = parseInt(data.total / itemsPerPage) + 1;
            this.renderPagination();
            this.$productItems.each(function(index) {
              if (typeof data.items[index] == 'undefined') {
                $(this).css('visibility', 'hidden');
              } else {
                $(this).css('visibility', 'visible');
                $(this).attr('data-id', data.items[index].id);
                $(this).children('img').attr('src', data.items[index].pic);
                $(this).children('img').attr('alt', data.items[index].pic.split('/').pop());
                $(this).children('p.product-items__item_desc').text(data.items[index].name);
                $(this).children('p.product-items__item_price').text(data.items[index].price);
              }
            });
          } else {
            console.log('SOMETHING WENT WRONG, ERROR MESSAGE: ' + data.message);
          }
          
      },
      context: this
  });
}

ProductByPage.prototype.renderPagination = function() {
  this.$root.html('');
  if (this.currentPage == 1) {
    this.$root.append('<span id="product-pagination-left">&lt;</span>');
  } else {
    this.$root.append('<span id="product-pagination-left" class="product-choice__control-active">&lt;</span>');
  }
  for (var i = 1; i <= this.totalPages; i++) {
    if (i == this.currentPage) {
      this.$root.append('<span class="product-choice__pag product-choice__pag-active">' + i + '</span>');
    } else {
      this.$root.append('<span class="product-choice__pag">' + i + '</span>');
    }
  }
  if (this.currentPage == this.totalPages) {
    this.$root.append('<span id="product-pagination-right">&gt;</span>');
  } else {
    this.$root.append('<span id="product-pagination-right" class="product-choice__control-active">&gt;</span>');
  }
}

ProductByPage.prototype.pageClickHandler = function(event) {
  if (event.data.currentPage != $(event.currentTarget).html()) {
    var spanChild = +event.data.currentPage + 1;
    event.data.$root.children('span:nth-child(' + spanChild + ')').removeClass('product-choice__pag-active');
    event.data.currentPage = $(event.currentTarget).html();
    spanChild = +event.data.currentPage + 1;
    event.data.$root.children('span:nth-child(' + spanChild + ')').addClass('product-choice__pag-active');
    event.data.$root.attr('data-page', event.data.currentPage);
    event.data.loadAndShow();
  }
}

ProductByPage.prototype.leftClickHandler = function(event) {
  if (event.data.currentPage != 1) {
    event.data.currentPage = +event.data.$root.children('.product-choice__pag-active').first().html() - 1;
    event.data.$root.children('.product-choice__pag-active').first().removeClass('product-choice__pag-active');
    var spanChild = +event.data.currentPage + 1;
    event.data.$root.children('span:nth-child(' + spanChild + ')').addClass('product-choice__pag-active');
    event.data.$root.attr('data-page', event.data.currentPage);
    event.data.loadAndShow();
  }
}

ProductByPage.prototype.rightClickHandler = function(event) {
  if (event.data.currentPage != event.data.totalPages) {
    event.data.currentPage = +event.data.$root.children('.product-choice__pag-active').first().html() + 1;
    event.data.$root.children('.product-choice__pag-active').first().removeClass('product-choice__pag-active');
    var spanChild = +event.data.currentPage + 1;
    event.data.$root.children('span:nth-child(' + spanChild + ')').addClass('product-choice__pag-active');
    event.data.$root.attr('data-page', event.data.currentPage);
    event.data.loadAndShow();
  }
}


function productPriceSliderInit() {
  $('#product-price-slider').slider({
    range: true,
    min: 52,
    max: 450,
    values: [ 75, 300 ],
    slide: function( event, ui ) {
      $('#product-price1').val('$' + ui.values[0]);
      $('#product-price2').val('$' + ui.values[1]);
    }
  });
  $('#product-price1').val('$' + $('#product-price-slider').slider('values', 0));
  $('#product-price2').val('$' + $('#product-price-slider').slider('values', 1));
}

function productLeftNavInit() {
  $('.product__left-nav').first().children('.product__left-nav__head').each(function(index) {
    if ($(this).hasClass('product__left-nav__active')) {
      $(this).children('.product__left-nav__items').show(0);
    } else {
      $(this).children('.product__left-nav__items').hide(0);
    }
  });
}

function toggleProductCategory(event) {
  // console.log($(event.currentTarget).next().attr('class').split(' '));
  if ($(event.currentTarget).parent().hasClass('product__left-nav__active')) {

  } else {
    $(event.currentTarget).parent().parent().find('.product__left-nav__active').first()
      .children('.product__left-nav__items').first().hide(500);
    $(event.currentTarget).parent().parent().find('.product__left-nav__active').first().removeClass('product__left-nav__active');
    $(event.currentTarget).parent().addClass('product__left-nav__active');
    $(event.currentTarget).parent().children('.product__left-nav__items').first().show(500);
  }
}


// CHECKOUT

function checkoutStepsInit() {
  $('.checkout-steps').first().find('.checkout-steps__div').each(function(index) {
    if ($(this).hasClass('checkout-steps__active')) {
      $(this).show(0);
    } else {
      $(this).hide(0);
    }
  });
}

function toggleCheckoutSteps(event) {
  // console.log($(event.currentTarget).next().attr('class').split(' '));
  if ($(event.currentTarget).next().hasClass('checkout-steps__active')) {

  } else {
    $(event.currentTarget).parent().parent().find('.checkout-steps__active').first().slideUp(500);
    $(event.currentTarget).parent().parent().find('.checkout-steps__active').first().removeClass('checkout-steps__active');
    $(event.currentTarget).next().addClass('checkout-steps__active');
    $(event.currentTarget).next().slideDown(500);
  }
}

function toggleCheckoutStep(event) {
  // console.log($(event.currentTarget).next().attr('class').split(' '));
  if ($(event.currentTarget).next().hasClass('checkout-steps__active')) {

  } else {
    $(event.currentTarget).parent().parent().find('.checkout-steps__active').first().removeClass('checkout-steps__active');
    $(event.currentTarget).next().addClass('checkout-steps__active');
  }
}


