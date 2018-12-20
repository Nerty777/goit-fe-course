<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>
  <body>
      
  <!--http://jquery.eisbehr.de/lazy/-->
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.9/jquery.lazy.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.9/jquery.lazy.plugins.min.js"></script>
  <script src="brokenAndSmallPhoto.js"></script>

    <?php
$number = 0;

foreach($offers as $offer)
 {
  $num = 1;
  $num2 = 1;
?>
    <div class="wrapper-body">
      <div class="body-category">
        <div class="category" title="Категория">
          <div class="category-icon icon"></div>
         <p class="category-title">
            <?php
  foreach($xml->shop->categories->category as $category)
   {
    if ($count_category > 30 or count($all_offers) > 3000)
     {
    
      if ($category['id'] == "$offer->categoryId")
      {
        echo $offer->categoryId . ' ::: ' . $category . '<br>';
        break;
      } 
           elseif ($count_category < 500){
           if (in_array("$offer->categoryId", $array_not_write_category))
           {
           ?>
          <div class="alarm">
            <div class="alarm-icon icon"></div>
           <p class="alarm-text-name"><?php echo 'Номер '. "$offer->categoryId" .' category id не прописан в categories.';?></p>
          </div>
          <?php
           break;
           }
           }
     }
    else
     {
      $array_category_id[] = "$category[id]";
      $array_category333[] = "$category";
      if ($category['id'] == "$offer->categoryId")
      {
        $num_category_id = 0;
        for ($num_category_id = 0; $num_category_id < count($array_category_id); $num_category_id++)
         {
          if ($category['parentId'] == $array_category_id[$num_category_id])
          {
            echo '<span class="category_id-name">'.$array_category333[$num_category_id] .'</span>'.'<br>';
            break;
          };
         }
        echo $offer->categoryId . ' ::: ' . $category . '<br>';
      }
      else {

      if (in_array("$offer->categoryId", $array_not_write_category)){
           ?>
          <div class="alarm">
          <div class="alarm-icon icon"></div>
          <p class="alarm-text-name">
          <?php echo 'Номер '. "$offer->categoryId" .' category id не прописан в categories.';?>
          </p>
          </div>
       <?php
          break;
      }
      }
     }
     
   }

?>
          </p>
          <?php
  if (empty(strip_tags(trim("$offer->categoryId"))))
   { ?>
          <div class="alarm">
            <div class="alarm-icon icon"></div>
           <p class="alarm-text-name">Нет категории</p>
          </div>
          <?php
   };
?>
        </div>
        <div class="name" title="Название">
          <div class="name-icon icon"></div>
         <p class="name-title">
            <span class="name-color"><?php
              if (empty(strip_tags(trim("$offer->name"))))
   {
   }
   else
   { echo ("<a href='$offer->url' title='Ссылка на страницу с товаром на сайте продавца' target='_blank' rel='noopener noreferrer' class='name-color_link'>$offer->name</a>"); }?></span>
            <?php
            if (empty(strip_tags(trim("$offer->name")) ==false) and empty(strip_tags(trim("$offer->model"))) ==false) {echo '<br>';};
  if (empty(strip_tags(trim("$offer->model"))))
   {
   }
  else ?><span class="model-color"><?php
  echo ("<a href='$offer->url' title='Ссылка на страницу с товаром на сайте продавца' target='_blank' rel='noopener noreferrer'>$offer->model</a>"); ?></span>
            <?php
            if($name_offer > 0){
  if (empty(strip_tags(trim("$offer->name"))) and empty(strip_tags(trim("$offer->model"))))
   { ?>
          <div class="alarm">
            <div class="alarm-icon icon"></div>
           <p class="alarm-text">Нет названия</p>
          </div>
          <?php
   };
            }
   ?>
          </p>
        </div>
        <div class="vendor" title="Производитель">
          <div class="vendor-icon icon"></div>
         <p class="vendor-title">
            <?php
  echo $offer->vendor; ?>
            <?php
  if (empty(strip_tags(trim("$offer->vendor"))))
   { ?>
          <div class="alarm">
            <div class="alarm-icon icon"></div>
           <p class="alarm-text">Нет производителя</p>
          </div>
          <?php
   };
?>
          </p>
        </div>
        <?php
        if($num_ne_ukazan_vendor_name > 0){
            
   if(empty("$offer->vendor") != true){
  $not_vendor_in_name = 0;
  $not_vendor_in_model = 0;
  $lower_name = mb_strtolower("$offer->name");
  $lower_vendor = mb_strtolower("$offer->vendor");
  $not_vendor_in_name = strrpos($lower_name , $lower_vendor);
  if ($not_vendor_in_name === false and empty("$offer->vendor") != true)
   {
    $not_vendor_in_name++;
    if (empty("$offer->model"))
     { ?>	 
        <div class="attention">
          <div class="alarm-icon icon"></div>
        <p class="attention-title">Не указан производитель в названии</p>
        </div>
        <?php
     };
   }
  }
 }

if($num_ne_ukazan_vendor_model > 0){
  $not_vendor_in_model = 0;
  if(empty("$offer->vendor") != true){
  $lower_vendor = mb_strtolower("$offer->vendor");
  $lower_model = mb_strtolower("$offer->model");
  $not_vendor_in_model = strrpos($lower_model , $lower_vendor);
  if ($not_vendor_in_model === false and empty("$offer->vendor") != true)
   {
    $not_vendor_in_model++;
    if (empty("$offer->name"))
     { ?>	 
        <div class="attention">
          <div class="alarm-icon icon"></div>
         <p class="attention-title">Не указан производитель в названии</p>
        </div>
        <?php
     };
   }
  }
}
?>
        <div class="price"  title="Цена">
          <div class="price-icon icon"></div>
         <p class="price-title">
            <?php
  echo '<span style="color: grey; font-weight: bold; text-decoration: line-through;">' . $offer->old_price . '</span>' . ' ' . $offer->price . ' ' . $offer->currencyId; ?>
          </p>
          <?php
  if (empty(strip_tags(trim("$offer->price"))) or ($offer->price) <= 0)
   { ?>
          <div class="alarm">
            <div class="alarm-icon icon"></div>
<p class="alarm-text-name">Нет цены</p>
          </div>
          <?php
   };
  if (empty(strip_tags(trim("$offer->currencyId"))))
   { ?>
          <div class="alarm">
            <div class="alarm-icon icon"></div>
<p class="alarm-text-name">Нет валюты</p>
          </div>
          <?php
   };
  if ($offer->price < 10 and empty(strip_tags(trim("$offer->price"))) != true and ($offer->price) > 0 and $offer->currencyId == 'UAH')
   { ?>
          <div class="alarm">
            <div class="alarm-icon icon"></div>
<p class="alarm-text-name">Цена меньше 10грн</p>
          </div>
          <?php
   };
?>	
        </div>
        <div class="offer_id" title="offer id">
          <div class="offer_id-icon icon"></div>
<p class="offer_id-title">
            <?php
  echo $offer['id']; ?>
          </p>
          <?php
  if (empty($offer['id']))
   { ?>
          <div class="alarm">
            <div class="alarm-icon icon"></div>
<p class="alarm-text-name">Нет offer id</p>
          </div>
          <?php
   };
?>	
        </div>
        <div class="stock_quantity" title="Количество">
          <div class="stock_quantity-icon icon" ></div>
<p class="stock_quantity-title">
            <?php
  if (empty(strip_tags(trim("$offer->stock_quantity"))) and "$offer->stock_quantity" == '')
   {
?>
          <div class="alarm">
            <div class="alarm-icon icon"></div>
<p class="alarm-text-name">Нет количества</p>
          </div>
          <?php
   }
  else
  {
    echo '<span style="color: Gray; font-weight: bold;">' . 'Количество товара: ' . "$offer->stock_quantity" . '</span>' . '<br>';
  };
?>
          </p>
        </div>
        <?php
  if (($offer['available'] == 'false' or empty($offer['available'])) or ($offer['available'] == 'true' and $offer->stock_quantity == '0' and $offer->stock_quantity !== ''))
   { ?>
        <div class="available"  title="Товара нет в наличии">
          <div class="available-icon-stop icon"></div>
<p class="available-title">
            <?php
    echo '
<span style="color: red; font-weight: bold;">' . $offer['available'] . ' Товара нет в наличии.' . '</span>'; ?>
          </p>
        </div>
        <?php
   }
  else
  if ($offer['available'] = 'true')
   { ?>
        <div class="available" title="Наличие">
          <div class="available-icon icon" ></div>
<p class="available-title">
            <?php
    echo 'В наличии товар'; ?>
          </p>
        </div>
        <?php
   } ?>
        <?php
  if ($offer['аvailable'] == 'false' or $offer['аvailable'] == 'true')
   { ?>
        <div class="attention">
          <div class="first-icon icon"></div>
<p class="attention-title">
            <?php
    echo '<span style="color: red; font-weight: bold">' . 'Первая буква в слове available написана в русской раскладке.' . '<br>' . $offer['аvailable'] . '</span>'; ?>
          </p>
        </div>
        <?php
   }
   ?>
        <div class="number" title="Порядковый номер">
          <div class="number-icon icon" ></div>
<p class="number-title">
            <?php
  echo ++$number; ?>
          </p>
        </div>
        <div class="links" title="Ссылки">
          <div class="link-icon icon"></div>
<div class="spoiler_links-category blue link-wrapper"><span class="linkwordlink">Ссылки&nbsp;<div class="icon_click"></div></span></div>
          <div class="spoiler_body-category">
            <div class="link">
              <?php
  echo 'Ссылка на товар: ' . '<br>';
  echo ("<a href='$offer->url' target='_blank' rel='noopener noreferrer'>$offer->url</a>") . '<br>';
  foreach($offer->picture as $picture)
   {;
    echo 'Ссылка на фото ' . $num2++ . ':' . '<br>';
    echo ("<a href='$picture' target='_blank' rel='noopener noreferrer'>$picture</a>") . '<br>';
   } ?>
            </div>
          </div>
        </div>
        <?php
  if (empty(strip_tags(trim("$offer->url"))))
   { ?>
        <div class="attention attention-not-link">
          <div class="alarm-icon icon"></div>
<p class="attention-title">Нет ссылки на товар</p>
        </div>
        <?php
   }
?>
      </div>
      <div class="param" style="width: <?php if(count($all_offers) == count($count_picture)){echo 'calc((100% - 250px)/3 - 50px)';} else{echo 'calc((100% - 280px)/3 - 150px)';};   ?> ;">
        <?php
        
        
  foreach($offer->param as $param)
   {
    echo '<div class="color-hr"></div>' . '<span class="param_name">' . $param['name'] . '</span>' . ' ::: ' . $param;
    // if(count($all_offers) < 15000) {
    if (empty(strip_tags(trim("$param"))))
     {
?>
        <div class="alarm">
          <div class="alarm-icon icon"></div>
<p class="alarm-text-name">Незаполнено значение</p>
        </div>
        <?php
     }
     
    if (strrpos($param, 'https') !== false or strrpos("$param", 'http') !== false
    or strrpos("$param", '.gif') !== false or strrpos("$param", 'www') !== false
    or strrpos("$param", 'com.') !== false or strrpos("$param", '.ua') !== false
    or strrpos("$param", '.net') !== false or strrpos("$param", '.png') !== false
    or strrpos("$param", '.jpg') !== false or strrpos("$param[name]", 'https') !== false
    or strrpos("$param[name]", 'http') !== false or strrpos("$param[name]", 'www') !== false
    or strrpos("$param[name]", '.gif') !== false or strrpos("$param[name]", '.ua') !== false
    or strrpos("$param[name]", '.net') !== false or strrpos("$param", '.com') !== false
    or strrpos("$param[name]", '.png') !== false or strrpos("$param[name]", '.jpg') !== false)
     {;
?>
        <div class="alarm">
          <div class="alarm-icon icon"></div>
<p class="alarm-text-name">Ссылка в параметрах</p>
        </div>
        <?php
     }
   }
  if (empty($offer->param['name']))
   {;
?>
        <div class="alarm">
          <div class="alarm-icon icon"></div>
 <p class="alarm-text-name">Нет параметров</p>
        </div>
        <?php
   }
?>
        <div class="color-hr"></div>
        <div class="double-param">
          <?php
          if($double_param_name > 0){
  foreach($offer->param as $param)
   {
    $double[] = $param['name'];
   };
  if (count($double) > 0)
   {
    $unique_double = array_unique($double);
    $result_double_param = array_diff_assoc($double, $unique_double);
   };
  for ($i = 1; $i <= count($double); $i++)
   {
    if (empty($result_double_param[$i]) === false)
     {
      echo '<span style="color: #f00; font-weight: bold;">' . $result_double_param[$i] . '</span>' . '<br>';
     };
   }

  if (count($double) !== count($unique_double) and count($double) > 0)
   {;
?>
          <div class="alarm">
            <div class="alarm-icon icon"></div>
<p class="alarm-text-name">Дубли названий параметров</p>
          </div>
          <?php
   };
  $double = array();
      }       
?>
        </div>
      </div>
      <?php
       
         ?> 
 
      <div class="wrapper-picture">
        <div class="picture" style="width: <?php if(count($all_offers) == count($count_picture)){echo '240px';};   ?> ;">
          <?php
  foreach($offer->picture as $picture)
   {
    // echo ("<a href='$picture' target='_blank' rel='noopener noreferrer'><img src='$picture' style='max-width:220px; height:auto;' title='$picture' /></a>");
    echo ("<a href='$picture' target='_blank' rel='noopener noreferrer'><img class='lazy' data-src='$picture' style='max-width:220px; height:auto;' title='$picture' /></a>");
    echo $num++ . '<br>';

if($picture_null_value > 0){
    if (empty(strip_tags(trim("$picture"))))
     { ?>
          <div class="alarm empty_photo">
            <div class="alarm-icon icon"></div>
<p class="alarm-text-name">Отсуствует ссылка в фото <?php
      echo $num - 1; ?></p>
          </div>
          <?php
     }
}

if($picture_filename_extension) {
    
    
    if (empty(strip_tags(trim("$picture"))) === false and strrpos(strtolower($picture), '.jpg') == false and strrpos(strtolower($picture), '.jpeg') == false and strrpos(strtolower($picture), '.png') == false and strrpos(strtolower($picture), '.gif') == false and strrpos(strtolower($picture), '.bmp') == false and strrpos(strtolower($picture), '.svg') == false and strrpos(strtolower($picture), '.tif') == false and strrpos(strtolower($picture), '.webp') == false) {
            // $picture_filename_extension++;
            ?>
          <div class="alarm empty_photo">
            <div class="alarm-icon icon"></div>
<p class="alarm-text-name">Фото <?php echo $num-1 ?> неверного расширения</p>
          </div>
          <?php
        }

}

   }
   if($picture_offer > 0){
  if (empty(strip_tags(trim("$offer->picture"))))
   {
?>
          <div class="alarm">
            <div class="alarm-icon icon"></div>
            <p class="alarm-text-name">Нет фото</p>
          </div>
          <?php
   }
   }
?>
        </div>
      </div>
      <div class="description" style="width: <?php if(count($all_offers) == count($count_picture)){echo 'calc(100%/3)';} else{echo 'calc(100%/3 - 100px)';};   ?> ;">
        <?php
  echo $offer->description;
  
  if($description_offer > 0){
  $trim_description= trim("$offer->description");
  $strip_tags_description= strip_tags($trim_description);
  $emty_description = empty($strip_tags_description);
if ($emty_description > 0)
   { ?>
        <div class="alarm">
          <div class="alarm-icon icon"></div>
          <p class="alarm-text-name">Нет описания</p>
        </div>
        <?php
   }
  }
// if(count($all_offers) < 20000) {
    
    
    if($http_description > 0){
  if (strrpos("$offer->description", 'https') !== false or strrpos("$offer->description", 'http:') !== false
  or strrpos("$offer->description", '.gif') !== false or strrpos("$offer->description", '.com') !== false
  or strrpos("$offer->description", "www") !== false or strrpos("$offer->description", '.ua') !== false
  or strrpos("$offer->description", '.net') !== false or strrpos("$offer->description", '.png') !== false
  or strrpos("$offer->description", '.jpg') !== false)
   {
?>
        <br><br>
<div class="spoiler_links blue" style="text-align: center;">
<!--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-->
Открыть описание с тегами html с выделением ссылки</div>
<div class="spoiler_body"  >
    <?php
// вывод с тегами html
$offer->description = str_replace("<",   '&lt;' , $offer->description);
$offer->description = str_replace(">",  '&gt;' , $offer->description);
$offer->description = str_replace("https",  '<span style="color: red; font-weight: bold;">'.'HTTPS'.'</span>' , $offer->description);
$offer->description = str_replace("http",  '<span style="color: red; font-weight: bold;">'.'HTTP'.'</span>' , $offer->description);
$offer->description = str_replace(".gif",  '<span style="color: red; font-weight: bold;">'.".GIF".'</span>' , $offer->description);
$offer->description = str_replace(".com",  '<span style="color: red; font-weight: bold;">'.".COM".'</span>' , $offer->description);
$offer->description = str_replace("www",  '<span style="color: red; font-weight: bold;">'."WWW".'</span>' , $offer->description);
$offer->description = str_replace(".ua",  '<span style="color: red; font-weight: bold;">'.".UA".'</span>' , $offer->description);
$offer->description = str_replace(".net",  '<span style="color: red; font-weight: bold;">'.".NET".'</span>' , $offer->description);
$offer->description = str_replace(".png",  '<span style="color: red; font-weight: bold;">'.".PNG".'</span>' , $offer->description);
$offer->description = str_replace(".jpg",  '<span style="color: red; font-weight: bold;">'.".JPG".'</span>' , $offer->description);
?>
<div style="max-width: 330px; overflow-wrap: break-word;">
<?php
echo $offer->description;
?>
</div>
<?php
$offer->description = str_replace("&lt;",   '<' , $offer->description);
$offer->description = str_replace("&gt;",  '>' , $offer->description);
$offer->description = str_replace('<span style="color: red; font-weight: bold;">'.'HTTPS'.'</span>' , "https", $offer->description);
$offer->description = str_replace('<span style="color: red; font-weight: bold;">'.'HTTP'.'</span>' , "http", $offer->description);
$offer->description = str_replace('<span style="color: red; font-weight: bold;">'.".GIF".'</span>' , ".gif",  $offer->description);
$offer->description = str_replace('<span style="color: red; font-weight: bold;">'.".COM".'</span>' , ".com",  $offer->description);
$offer->description = str_replace('<span style="color: red; font-weight: bold;">'."WWW".'</span>' , "www",  $offer->description);
$offer->description = str_replace('<span style="color: red; font-weight: bold;">'.".UA".'</span>' , ".ua",  $offer->description);
$offer->description = str_replace('<span style="color: red; font-weight: bold;">'.".NET".'</span>' , ".net",  $offer->description);
$offer->description = str_replace('<span style="color: red; font-weight: bold;">'.".PNG".'</span>' , ".png",  $offer->description);
$offer->description = str_replace('<span style="color: red; font-weight: bold;">'.".JPG".'</span>' , ".jpg",  $offer->description);
?>
<br>
</div>
        <div class="alarm">
          <div class="alarm-icon icon"></div>
          <div class="link-flex">
            <p class="alarm-text-name link-alarm" style="text-align:left;">В описании есть <span style="color: red; font-weight: bold;">ссылки</span></p>
<br>
<span class="descr-reg">																							
            <?php
            
            // $regex = '/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i'; //старый вариант
    $regex = '/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]|[-A-Za-z0-9+&@#\/%?=~_|$!:,.;]+\.com[-A-Za-z0-9+&@#\/%?=~_|$!:,.;]+|[-A-Za-z0-9+&@#\/%?=~_|$!:,.;]+\.com|[-A-Za-z0-9+&@#\/%?=~_|$!:,.;]+\.net[-A-Za-z0-9+&@#\/%?=~_|$!:,.;]+|[-A-Za-z0-9+&@#\/%?=~_|$!:,.;]+\.net|[-A-Za-z0-9+&@#\/%?=~_|$!:,.;]+\.jpg|[-A-Za-z0-9+&@#\/%?=~_|$!:,.;]+\.png|[-A-Za-z0-9+&@#\/%?=~_|$!:,.;]+\.gif/i'; 
    
    preg_match_all($regex, $offer->description, $matches);
    $urls = $matches[0];
    // go over all links
    foreach($urls as $url)
     {
      echo ("<a href='$url' target='_blank' rel='noopener noreferrer'>$url</a>") . '<br>' . '<br>';
     }
?>
            </span>
          </div>
        </div>
        <?php
   }
}
//   }
  // проверка на наличие в описании стоп слов.
//   if (count($all_offers) < 9000) {
if($description_stop_sum > 0){

  $description_store = 0;
  $description_pay = 0;
  $description_delivery = 0;
  $description_buy = 0;
  $description_phone = 0;
  $description_uah = 0;
  $description_site = 0;
  $description_price = 0;
  $description_price2 = 0;
  $description_manager = 0;
  $description_proposal = 0;
  $description_call = 0;
  $description_contact = 0;
  $description_variation = 0;
  $description_order = 0;

$lower_description = mb_strtolower("$offer->description");
if (strrpos($lower_description, 'магазин') !== false)
   {
    $description_store++;
   }

if (strrpos($lower_description, 'оплат') !== false)
   {
    $description_pay++;
   }

if (strrpos($lower_description, 'доставк') !== false)
   {
    $description_delivery++;
   }

if (strrpos($lower_description, 'купит') !== false)
   {
    $description_buy++;
   }

if (strrpos($lower_description, 'тел.') !== false)
   {
    $description_phone++;
   }

if (strrpos($lower_description, 'грн') !== false)
   {
    $description_uah++;
   }

if (strrpos($lower_description, 'сайт') !== false)
   {
    $description_site++;
   }

if (strrpos($lower_description, 'цена') !== false)
   {
    $description_price++;
   }

if (strrpos($lower_description, 'стоимость') !== false)
   {
    $description_price2++;
   }

if (strrpos($lower_description, 'менеджер') !== false)
   {
    $description_manager++;
   }

if (strrpos($lower_description, 'заявк') !== false)
   {
    $description_proposal++;
   }

if (strrpos($lower_description, 'позвонит') !== false)
   {
    $description_call++;
   }

if (strrpos($lower_description, 'обраща') !== false)
   {
    $description_contact++;
   }

if (strrpos($lower_description, 'вариа') !== false)
   {
    $description_variation++;
   }

if (strrpos($lower_description, 'заказ') !== false)
   {
    $description_order++;
   }


  if ($description_store > 0)
   {
?>
        <br>
        <div class="alarm">
          <div class="alarm-icon icon"></div>
          <p class="alarm-text-name">В описании есть слово <span style="color: red; font-weight: bold;">м-а-г-а-з-и-н</span></p>
        </div>
        <?php
   }

  if ($description_pay > 0)
   {
?>
        <br>
        <div class="alarm">
          <div class="alarm-icon icon"></div>
          <p class="alarm-text-name">В описании есть слово <span style="color: red; font-weight: bold;">о-п-л-а-т(про о-п-л-а-т-и-т-ь)</span></p>
        </div>
        <?php
   }

  if ($description_delivery > 0)
   {
?>
        <br>
        <div class="alarm">
          <div class="alarm-icon icon"></div>
          <p class="alarm-text-name">В описании есть слово <span style="color: red; font-weight: bold;">д-о-с-т-а-в-к(про д-о-с-т-а-в-к-у)</span></p>
        </div>
        <?php
   }

  if ($description_buy > 0)
   {
?>
        <br>
        <div class="alarm">
          <div class="alarm-icon icon"></div>
          <p class="alarm-text-name">В описании есть слово <span style="color: red; font-weight: bold;">к-у-п-и-т(про к-у-п-и-т-ь)</span></p>
        </div>
        <?php
   }

  if ($description_phone > 0)
   {
?>
        <br>
        <div class="alarm">
          <div class="alarm-icon icon"></div>
          <p class="alarm-text-name">В описании есть слово <span style="color: red; font-weight: bold;">т-е-л.</span></p>
        </div>
        <?php
   }

  if ($description_uah > 0)
   {
?>
        <br>
        <div class="alarm">
          <div class="alarm-icon icon"></div>
          <p class="alarm-text-name">В описании есть слово <span style="color: red; font-weight: bold;">г-р-н</span></p>
        </div>
        <?php
   }

  if ($description_site > 0)
   {
?>
        <br>
        <div class="alarm">
          <div class="alarm-icon icon"></div>
          <p class="alarm-text-name">В описании есть слово <span style="color: red; font-weight: bold;">с-а-й-т</span></p>
        </div>
        <?php
   }

  if ($description_price > 0)
   {
?>
        <br>
        <div class="alarm">
          <div class="alarm-icon icon"></div>
          <p class="alarm-text-name">В описании есть слово <span style="color: red; font-weight: bold;">ц-е-н-а</span></p>
        </div>
        <?php
   }

  if ($description_price2 > 0)
   {
?>
        <br>
        <div class="alarm">
          <div class="alarm-icon icon"></div>
          <p class="alarm-text-name">В описании есть слово <span style="color: red; font-weight: bold;">с-т-о-и-м-о-с-т-ь</span></p>
        </div>
        <?php
   }

  if ($description_manager > 0)
   {
?>
        <br>
        <div class="alarm">
          <div class="alarm-icon icon"></div>
          <p class="alarm-text-name">В описании есть слово <span style="color: red; font-weight: bold;">м-е-н-е-д-ж-е-р</span></p>
        </div>
        <?php
   }

  if ($description_proposal > 0)
   {
?>
        <br>
        <div class="alarm">
          <div class="alarm-icon icon"></div>
          <p class="alarm-text-name">В описании есть слово <span style="color: red; font-weight: bold;">з-а-я-в-к(про з-а-я-в-к-у)</span></p>
        </div>
        <?php
   }

  if ($description_call > 0)
   {
?>
        <br>
        <div class="alarm">
          <div class="alarm-icon icon"></div>
          <p class="alarm-text-name">В описании есть слово <span style="color: red; font-weight: bold;">п-о-з-в-о-н-и-т(про п-о-з-в-о-н-и-т-е)</span></p>
        </div>
        <?php
   }

  if ($description_contact > 0)
   {
?>
        <br>
        <div class="alarm">
          <div class="alarm-icon icon"></div>
          <p class="alarm-text-name">В описании есть слово <span style="color: red; font-weight: bold;">о-б-р-а-щ-а(про о-б-р-а-щ-а-й-т-е-с-ь)</span></p>
        </div>
        <?php
   }

  if ($description_variation > 0)
   {
?>
        <br>
        <div class="alarm">
          <div class="alarm-icon icon"></div>
          <p class="alarm-text-name">В описании есть слово <span style="color: red; font-weight: bold;">в-а-р-и-а(про в-а-р-и-а-н-т)</span></p>
        </div>
        <?php
   }

  if ($description_order > 0)
   {
?>
        <br>
        <div class="alarm">
          <div class="alarm-icon icon"></div>
          <p class="alarm-text-name">В описании есть слово <span style="color: red; font-weight: bold;">з-а-к-а-з</span></p>
        </div>
        <?php
   }

}
// }
?>
      </div>
    </div>
    <?php
 }

?>
  </body>
</html>

 

 

