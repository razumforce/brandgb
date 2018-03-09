<section class="maylike-catalog">
  <div class="maylike-info">
    <div class="maylike-info__title">
      <h2>YOU MAY LIKE ALSO</h2>
    </div>
  </div>
  <div class="maylike-items">

    <?php foreach ($content['maylike_product'] as $item): ?>
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
</section>