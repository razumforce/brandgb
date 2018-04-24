<section class="featured-catalog">
  <div class="featured-info">
    <div class="featured-info__title">
      <h2>Featured Items</h2>
    </div>
    <div class="featured-info__text">
      <span>Shop for items based on what we featured in this week</span>
    </div>
  </div>
  <div class="featured-items">

    <?php foreach ($content['featured_product'] as $item): ?>
      <div class="product-items__item product-items__4col" data-id="<?=$item['id_item']?>">
        <img src="<?=$item['url']?>" alt="<?=$item['name']?>">
        <p class="product-items__item_desc"><?=$item['name']?></p>
        <p class="product-items__item_price">$<?=$item['price']?></p>
        <div class="product-items__item_add">
          <span>Add to cart</span>
        </div>
      </div>


    <?php endforeach; ?>


  </div>

  <div class="clearfix"></div>

  <div class="featured-browse">
    <div class="featured-browse__button">
      <a href="./product.html">Browse All Product <i class="fa fa-long-arrow-right"></i></a>
    </div>
  </div>
</section>