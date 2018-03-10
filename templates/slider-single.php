<section class="single-slider">
  <div id="single-slider-div" class="carousel slide" data-ride="carousel" data-interval="5000">
    <!-- Indicators -->
    <ol class="carousel-indicators slider-ind single-slider-ind">
      <?php foreach ($content['single_item']['pic'] as $key => $pic): ?>
        <li data-target="#single-slider-div" data-slide-to="<?=$key;?>" class="<?=$pic['type'];?>"></li>
      <?php endforeach; ?>

<!-- 
      <li data-target="#single-slider-div" data-slide-to="0" class="active"></li>
      <li data-target="#single-slider-div" data-slide-to="1"></li>
      <li data-target="#single-slider-div" data-slide-to="2"></li>
      
-->
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner">

    <?php foreach ($content['single_item']['pic'] as $key => $pic): ?>
      <div class="item <?=$pic['type'];?>">
        <img src="<?=$pic['url'];?>" alt="single-<?=$key;?>">
      </div>
    <?php endforeach; ?>


<!--
     
      <div class="item active">
        <img src="./img/single/product-big-photo.png" alt="single-0">
      </div>

      <div class="item">
        <img src="./img/single/product-big-photo.png" alt="product-0">
      </div>

      <div class="item">
        <img src="./img/single/product-big-photo.png" alt="product-0">
      </div>                        
      
-->
      
    </div>
  </div>       
  <div class="single-slider__left">
    <a href="#single-slider-div" data-slide="prev"><i class="fa fa-chevron-left"></i></a>
  </div>
  <div class="single-slider__right">
    <a href="#single-slider-div" data-slide="next"><i class="fa fa-chevron-right"></i></a>
  </div>
  
</section>