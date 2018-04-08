<section class="single-item">
  <h2><?=$content['single_item']['collection']; ?></h2>
  <div class="single-item__title-line">
  </div>
  
  <div class="single-item__item-details">
    <span><?=$content['single_item']['name']; ?></span>
    <p><?=$content['single_item']['description']; ?></p>
    <div class="single-item__item-details_info">
      <div class="single-item__item-details_info-det">
        <span>MATERIAL:</span>
        <span><?=$content['single_item']['material']; ?></span>
      </div>
      <div class="single-item__item-details_info-det">
        <span>DESIGNER:</span>
        <span><?=$content['single_item']['designer']; ?></span>
      </div>
    </div>
    <div class="single-item__item-details_price">
      <span>$<?=$content['single_item']['price']; ?></span>
    </div>
  </div>
  
  <form class="single-item__item-choice" action="#" data-id="<?=$content['single_item']['id']; ?>">
    <div class="single-item__item-choice_field">
     
      <div class="single-item__item-choice_type">
        <div for="item-color" class="single-item__item-choice_type-title">CHOOSE COLOR</div>
        <div id="single-item-color" class="styled-drop_box">
          <div>
            <span><span data-cid="<?=$content['single_item']['color'][0]['id_color']; ?>"><i class="fa fa-square" style="color: <?=$content['single_item']['color'][0]['color_code'];?>"></i>&nbsp;&nbsp;&nbsp;<?=$content['single_item']['color'][0]['color_name'];?></span>
            <span><i class="fa fa-caret-down"></i></span></span>
          </div>
          <ul>
            <?php foreach ($content['single_item']['color'] as $key => $color): ?>
              <li><span data-cid="<?=$content['single_item']['color'][$key]['id_color']; ?>"><i class="fa fa-square" style="color: <?=$content['single_item']['color'][$key]['color_code'];?>"></i>&nbsp;&nbsp;&nbsp;<?=$content['single_item']['color'][$key]['color_name'];?></span></li>
            <?php endforeach; ?>
          </ul>
        </div>  
      </div>

      <div class="single-item__item-choice_type">
        <div for="item-size" class="single-item__item-choice_type-title">CHOOSE SIZE</div>
        <div id="single-item-size" class="styled-drop_box">
          <div>
            <span><span data-sid="<?=$content['single_item']['size'][0]['id_size']; ?>"><?=$content['single_item']['size'][0]['name'];?></span></span>
            <span><i class="fa fa-caret-down"></i></span>
          </div>
          <ul>
            <?php foreach ($content['single_item']['size'] as $key => $size): ?>
              <li><span data-sid="<?=$content['single_item']['size'][$key]['id_size']; ?>"><?=$content['single_item']['size'][$key]['name'];?></span></li>
            <?php endforeach; ?>
          </ul>
        </div>  
      </div>
        
      <div class="single-item__item-choice_type">
        <div for="item-size" class="single-item__item-choice_type-title">QUANTITY</div>
        <div id="single-item-qty" class="styled-input_box">
          <div>
            <input type="text" value="1" name="quantity">
          </div>
        </div>  
      </div>
      
    </div>
    <button class="single-item__item-add" type="button">Add to Cart</button>
  </form>
            
</section>

<div class="clearfix"></div>