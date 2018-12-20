<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>Happy New Year!</title>
<link rel="shortcut icon" href="./favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="css/main.css">
</head>
<body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

<!--переключение темы-->
<script>
let theme = 'white';
theme = JSON.parse(localStorage.getItem("theme"));
if(theme === 'dark'){
    const head = document.querySelector("head");
    const linkThemeCss = document.createElement('link');
    linkThemeCss.rel = 'stylesheet'
    linkThemeCss.href = 'css/darkTheme.css'
    head.append(linkThemeCss);
} else {
    theme = 'white';
    localStorage.setItem( "theme", JSON.stringify(theme) ); 
}
 </script>   

<!--закрытие списка товаров с ошибками по кнопке закрыть и перемотка к верху результатов-->
<script>
function closeAndScroll() {
     $("html, body").animate({
        scrollTop: $('#result').offset().top
     }, {
        duration: 1000,
        easing: "swing"
     });
$('.spoiler_body').hide('normal');
}
</script>

<!--закрытие списка товаров по алфавиту и плавный скроллинг-->
<script>
function closeAndScrollSpoilerBodyList() {
     $("html, body").animate({
        scrollTop: $('.alphabetical-scrolling').offset().top
     }, {
        duration: 1000,
        easing: "swing"
     });
setTimeout(function() {
$('.spoiler_body-list').hide('normal');
}, 1000);
}
</script>

<!--работа спойлера и появлене кнопки скопировать при открытом спойлере-->
<script>
    $(document).ready(function() {
        $('.spoiler_links').click(function() {
            $(this).next('.spoiler_body').toggle('normal');
        });
    });
</script>
    
    <!--Клик спойлера Вывод используемых названий товаров по алфавиту, ...-->
    <script>
      $(document).ready(function(){
       $('.spoiler_links').click(function(){
        $(this).next('.spoiler_body-list').toggle('normal');
        return false;
       });
      });
    </script>
    
    <!--Клик спойлера ссылки-->    
    <script>
      $(document).ready(function(){
       $('.spoiler_links-category').click(function(){
        $(this).next('.spoiler_body-category').toggle('normal');
        return false;
       });
      });
    </script>
    
    <!--скрипт прокрутки горизонтальный -->
    <script>
      $(window).scroll(function(){
      var ratio = $(document).scrollTop()/(($(document).height() - $(window).height()) / 100);
      $("#progress").width(ratio+"%");
      });
    </script>
    
    <!--скрипт плавной прокрутки к якорным ссылкам со скоростью 1000-->
    <script>
  $(document).ready(function() {
  $("a.scrollto").click(function() {
     $("html, body").animate({
        scrollTop: $($(this).attr("href")).offset().top
     }, {
        duration: 1000,
        easing: "swing"
     });
     return false;
  });
});
    </script>

    <!--скрипт плавной прокрутки к якорным ссылкам со скоростью 4000-->    
    <script>
  $(document).ready(function() {
  $("a.scrolltofoursec").click(function() {
     $("html, body").animate({
        scrollTop: $($(this).attr("href")).offset().top
     }, {
        duration: 4000,
        easing: "swing"
     });
     return false;
  });
});
    </script>
    
    <!--копирование текста в буфер обмена при нажатии кнопки скопировать-->
    <script> 
    function onCopyHandle(event) {
        var node = event.target.parentNode;
        if ( document.selection ) {
            var range = document.body.createTextRange();
            range.moveToElementText( node  );
            range.select();
            document.execCommand("copy");
        } else if ( window.getSelection ) {
            var range = document.createRange();
            range.selectNodeContents( node );
            window.getSelection().removeAllRanges();
            window.getSelection().addRange( range );
            document.execCommand("copy");
        }
    }
    </script>
    
    
    <?php
// подключаю Google Analytics
include("google.php");

$data = date('l, d F Y, H:i:s');
$url             = $_POST["url"];

$found_google_drive_not_direct_link = stripos($url, 'https://drive.google.com/file');
if ($found_google_drive_not_direct_link !== false) {
$keywords = preg_split("/https:\/\/drive.google.com\/file\/d\//", $url);
$google_drive_id = preg_split("/\/view/", $keywords[1]);
$google_drive_id = $google_drive_id[0];
$url = 'https://docs.google.com/uc?export=download&id='.$google_drive_id;
}

// конвертор punycode
// header('Content-Type: text/html; charset=utf-8');
include('idna_convert.class.php');
function coderurl($url) {
$idn = new idna_convert(array('idn_version'=>2008));
$url=(stripos($url, 'xn--')!==false) ? $idn->decode($url) : $idn->encode($url);
return $url;
}
$url = coderurl($url);

$url_xml_for_photo = $url;
$fail            = '<br>' . '<br>' . '<br>' . '<br>' . '&emsp;' . '<span style="color: red; font-weight: bold;">' . 'Н' . '</span>' . 'ет связи с сервером xml.' . '<br>';
$xml_link        = "&emsp;" . "Проверьте, чтоб ссылка на xml файл открывалась в браузере без ошибок: "."<a href='$url' target='_blank' rel='noopener noreferrer'>$url</a>" . '<br>';
$xmlreturn       = "&emsp;" . "Вернутся на главную страницу сайта " . "<a href='https://195.16.88.10/~xml104/'>https://195.16.88.10/~xml104/</a>";
$xml_background  = '<div style="position: absolute; z-index: -1; width: 100%; background-color: #201C2B; color: #b8b5c0; height: 100vh; font-size: 14px;" id="particles-js">';
$xml_background2 = '</div>';
$xml = simplexml_load_file($url) or exit("$xml_background $fail $xml_link $xmlreturn $xml_background2");
$u = $xml->shop->url;

// считаю количество товаров в xml
$price_150 = 0;
foreach ($xml->shop->offers->offer as $offer) {
    $all_offers[] = $offer;
    if ($offer->price < 150)
        $price_150++;
}

// считаю количество фото в xml
$numer_of_picture = 0;
foreach ($xml->shop->offers->offer as $offer) {
    foreach ($offer->picture as $picture) {
        $count_picture[] = "$picture";
        $numer_of_picture++;
    }
}

// получение ip-адреса
$ip = getenv('HTTP_CLIENT_IP')?:
getenv('HTTP_X_FORWARDED_FOR')?:
getenv('HTTP_X_FORWARDED')?:
getenv('HTTP_FORWARDED_FOR')?:
getenv('HTTP_FORWARDED')?:
getenv('REMOTE_ADDR');
// https://ipinfo.io или https://ipapi.co/
$details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
$city = $details->city;
$region = $details->region;
$country = $details->country;
$loc = $details->loc;
$org = $details->org;
$span_open_count_offers = '<span class="count_offers_in_111html" style="color: #4aa7ed; font-weight: bold; white-space: nowrap;">';
$span_close_count_offers =  '</span>';
$span_open_ip = '<span class="ip_visitors_in_111html" style="color: #000000; font-weight: bold;">';
$span_close_ip =  '</span>';
$span_open_country = '<span class="country_in_111html" style="color: #FFA07A; font-weight: bold;">';
$span_close_country =  '</span>';
$count_offers = count($all_offers); 
$url_site = "<a href='$u' class='url_site_in_111html' target='_blank' rel='noopener noreferrer' style='color: #228B22;'>$u</a>";
$url_xml = "<a href='$url' class='url_xml_in_111html' target='_blank' rel='noopener noreferrer' style='white-space: nowrap; color: #0000cc;'>$url</a>";
$wrapper_xml_list_open = '<div style="display:flex; flex-wrap: nowrap;">';
$wrapper_xml_list_close ='</div>';
$wrapper_open = '<span style="white-space: nowrap;">';
$wrapper_close ='</span>';
$space = '&nbsp;';
$numberok = 0;
$current = file_get_contents('111.html');
$numberok = substr_count($current, "\n") +2;
$dot= '.';
$numer_of_picture_to_html = "<span class='numer_of_picture_in_111html' style='color: #e0157a; font-weight: bold;'>$numer_of_picture</span>";
// создается файл 111.html и в него прописываются все вводимые через форму адреса хмл
$file_data_max = "$wrapper_xml_list_open $wrapper_open $numberok $dot $data $space $span_open_ip $ip $city $span_open_country $country $span_close_country $org $span_close_ip $wrapper_close $space $span_open_count_offers $count_offers $numer_of_picture_to_html $span_close_count_offers $space $wrapper_open $url_site $wrapper_close $space $url_xml $wrapper_xml_list_close\n";
$file_data_min = "$wrapper_xml_list_open $wrapper_open $numberok $dot $data $space $wrapper_close $span_open_count_offers $count_offers $numer_of_picture_to_html $span_close_count_offers $space $wrapper_open $url_site $wrapper_close $space $url_xml $wrapper_xml_list_close\n";
if ($ip == "95.164.82.34"){}
elseif($ip == "88.81.226.126"){$file_data_min .= file_get_contents('111.html'); file_put_contents('111.html',$file_data_min);}
else{$file_data_max .= file_get_contents('111.html'); file_put_contents('111.html',$file_data_max);}

// создаю новый хмл $offers из старого хмл $xml и его сортирую по categoryId
$offers = $xml->xpath('/yml_catalog/shop/offers/offer');
function sortOffers($c1, $c2)
{
    return strcmp($c1->categoryId, $c2->categoryId);
}
uasort($offers, 'sortOffers'); // categoryId=61;categoryId=62;categoryId=63,etc.

$count_category = 0;
foreach ($xml->shop->categories->category as $category) {
    $count_category++; //считаю количество категорий, которые вообще существуют в хмл
}

//прокрутка загрузки страницы     
?>
<div id="cont">
<div id="progress"></div>
</div>
<?php


// подключаю раздел ВАЖНО
include("demandsxml.php");

?>
    <div id="result"></div>
    <div class="result-wrapper">
        
      <!--<img class="result-icon" src="icon/result.svg" alt="result" title="Информация">-->
      <div class="site-logo"></div>
      
<div class="result">
    <button class="info-button" title="Информация"></button>
    
    <!--клик по кнопке "инфо" показывает demandsxmlWrapper-->
    <script>
        const demandsxmlWrapper = document.querySelector(".demandsxml-wrapper");
        const offsetHeight = demandsxmlWrapper.offsetHeight;
        const infoButton = document.querySelector(".info-button");
        infoButton.addEventListener("click", handleInfoButtonClick);
        function handleInfoButtonClick(event) {
            demandsxmlWrapper.classList.toggle('flex');
        }
    </script>
    
        <?php
 $сyrillic_url = stripos($u, '//xn--');
 if($сyrillic_url) {
    $u = coderurl($u); 
 }
 
 $url = coderurl($url);
echo "<div class='wrapper-site-link'>"."Ссылка на сайт: <a class='site-link' href='$u' target='_blank' rel='noopener noreferrer'>$u</a>"."</div>";
echo "Ссылка на xml: <a class='xml-link' href='$url' target='_blank' rel='noopener noreferrer'>$url</a>" . '<br>';
 $url = coderurl($url); 
?>

<!--загрузка лого сайта продавца-->
<script>
const siteLink = document.querySelector('.site-link');
const siteLogo = document.querySelector('.site-logo');
let siteUrl = siteLink.href;
const badSiteUrl = siteUrl.indexOf('https://195.16.88.10/~xml104/') > -1;
if (badSiteUrl)
{
  siteUrl='';
}
if(siteUrl) {
    linkpreview(siteUrl);
}
function linkpreview(siteUrl) {
const key = "5bb920a205cea06f38e7909709a72b521a4a9d1c05841";
  return axios
    .get(`https://api.linkpreview.net/?key=${key}&q=${siteUrl}`)
    .then(response => {
      const siteImgLogo = response.data.image
      if(siteImgLogo){
         siteLogo.style.backgroundImage = `url(${siteImgLogo})`;
         siteLogo.style.backgroundColor = '#ffffff';
         siteLogo.title = `лого сайта ${siteUrl}`;
         siteLogo.insertAdjacentHTML('afterbegin', `<a class="site-url" href="${siteUrl}" target='_blank' rel="noopener noreferrer" ></a>`);
      } 
    })
    .catch(error => {
      console.log(error)
    })     
}
</script>

<?php
// функция получения хоста с url сайта
function stripToDomainName($uri = '')
{
    $uri = strtolower(trim($uri));
    $uri = preg_replace('%^(http:\/\/)*(www.)*%usi', '', $uri);
    $uri = preg_replace('%^(https:\/\/)*(www.)*%usi', '', $uri);
    $uri = preg_replace('%\/.*$%usi', '', $uri);
    return $uri;
}
$url_without_http = stripToDomainName($u);
echo ("Ссылка на pro.similarweb.com: <a href='https://pro.similarweb.com/#/website/audience-overview/$url_without_http/*/999/3m/?webSource=Total' target='_blank' rel='noopener noreferrer'>https://pro.similarweb.com/#/website/audience-overview/$url_without_http/*/999/3m/?webSource=Total</a>") . '<br>';
?>
</div> <!--result close-->


<div class="result_not_list">
<button class="copy-result-button-not-list" title="скопировать" onclick="onCopyHandle(event)"></button>
<div class="main-result-string">
<?php
// начинаются проверки хмл
echo 'Всего товаров: ' . '<span style="color: #4aa7ed; font-weight: bold;">' . count($all_offers) . '</span>' . '. ';

if ($price_150 > 0) {
    $price_good = count($all_offers) - $price_150;
    echo 'Товаров дороже 150грн: ' . $price_good . '. ';
}

// вывод количества производителей товара
foreach ($xml->shop->offers->offer as $offer) {
    $sort_vendorqqq[] = "$offer->vendor";
}
$count_vendor_spolerqqq = array_count_values($sort_vendorqqq);
ksort($count_vendor_spolerqqq);
$count_vendor_spoler_sortqqq = array_values($count_vendor_spolerqqq);
$vendor_uniqueqqq            = array_unique($sort_vendorqqq);
sort($vendor_uniqueqqq);
echo 'Производителей товаров: ' . '<span style="color: green; font-weight: bold;">' . count($vendor_uniqueqqq) . '</span>' . '. ';
echo 'Количество фото товаров: ' . '<span style="color: #e0157a; font-weight: bold;">' . count($count_picture) . '</span>' . '. ';

// вывод количества категорий
foreach ($xml->shop->offers->offer as $offer) {
    $sort_categoryId_spolerzzz[] = "$offer->categoryId";
}

$count_sort_categoryId_spolerzzz = array_count_values($sort_categoryId_spolerzzz);

foreach ($xml->shop->categories->category as $category) {
    $array_category_id_categorieszzz[] = "$category[id]";
    $array_category_categorieszzz[]    = "$category";
}
$array_combine_categorieszzz = array_combine($array_category_id_categorieszzz, $array_category_categorieszzz);
foreach ($xml->shop->offers->offer as $offer) {
    $sort_categoryIdzzz[] = "$offer->categoryId";
    $resultzzz            = array_unique($sort_categoryIdzzz);
}
sort($resultzzz);
echo '<span class="count-category">'.'Всего категорий в xml ' . $count_category . '. Из них товар представлен в ' . '<span style="color: purple; font-weight: bold;">' . count($resultzzz) . '</span>' . '.' . '</span>';
?>
</div> <!--close main-result-string-->
<?php
// проверка валюты(не выводится список)
foreach ($xml->shop->currencies->currency as $currency) {
    $currency_id[]   = "$currency[id]";
    $currency_rate[] = "$currency[rate]";
}

if (count($currency_id) != count(array_unique($currency_id))) {
    echo '<div class="title_list">' . 'Не верно прописана валюта в currencies.' . '</div>' .'<div class="error_discr_not_list">'.' Валюта прописывается так: &lt;currency id="UAH" rate="1"/&gt; Только у гривны rate="1". Остальные валюты на сайт не выводятся и главное, чтоб у них rate не был единицей.'.'</div>';
}

$rate_one        = 0;
$currency_id_UAH = 0;

for ($count_currency_id = 0; $count_currency_id < count($currency_id); $count_currency_id++) {
    if ($currency_rate[$count_currency_id] == 1) {
        $rate_one++;
    }
    
    if ($currency_rate[$count_currency_id] == 1 and $currency_id[$count_currency_id] == 'UAH') {
        $currency_id_UAH++;
    }
}

if ($rate_one > 1) {
    echo '<div class="title_list">' . 'Не верно прописана валюта в currencies.' . '</div>' .'<div class="error_discr_not_list">'.' Валюта прописывается так: &lt;currency id="UAH" rate="1"/&gt; Только у гривны rate="1". Остальные валюты на сайт не выводятся и главное, чтоб у них rate не был единицей.'.'</div>';
}

if ($currency_id_UAH > 1 or $currency_id_UAH == 0) {
    echo '<div class="title_list">' . 'Не верно прописана валюта в currencies.' . '</div>' .'<div class="error_discr_not_list">'.' Валюта прописывается так: &lt;currency id="UAH" rate="1"/&gt; Только у гривны rate="1". Остальные валюты на сайт не выводятся и главное, чтоб у них rate не был единицей.'.'</div>';
}

// проверка, что category id состоит только из цифр и нет дублей category id в categories.
$not_only_number_in_categoryId = 0;
$true_number_catefory_id = true;
$array_not_only_number_in_categoryId = array();
$array_double_category_id_in_categories = array();
foreach ($xml->shop->categories->category as $category) {
    $category_id_in_categories[] = "$category[id]";
    $true_number_catefory_id = ctype_digit("$category[id]");
    if ($true_number_catefory_id == false) {
        $not_only_number_in_categoryId++;
        array_push($array_not_only_number_in_categoryId, $category['id']);
    }
    if (count(array_unique($category_id_in_categories)) !== count($category_id_in_categories)) {
$array_count_values_category_id_in_categories = (array_count_values($category_id_in_categories));
arsort($array_count_values_category_id_in_categories);


if (count($array_count_values_category_id_in_categories) > 1) {
    $array_keys_category_id_in_categories = array_keys($array_count_values_category_id_in_categories);
}
if (count($array_count_values_category_id_in_categories) > 1) {
    $array_values_category_id_in_categories = array_values($array_count_values_category_id_in_categories);
}
$double_category_id_in_categories = 0;
for ($num_category_id_in_categories = 0; $num_category_id_in_categories < count($array_keys_category_id_in_categories); $num_category_id_in_categories++) {
    if ($array_values_category_id_in_categories[$num_category_id_in_categories] > 1) {
        $double_category_id_in_categories++;
        array_push($array_double_category_id_in_categories, $array_keys_category_id_in_categories[$num_category_id_in_categories]);
        $array_double_category_id_in_categories = array_unique($array_double_category_id_in_categories);
}
}
}
}

// проверка на написание капсом производителя
$capss           = 0;
$num_vendor_caps = 0;
$array_vendor_caps = array();
foreach ($xml->shop->offers->offer as $offer) {
    $vendor_caps[] = "$offer->vendor";
}
$vendor_caps_unigue = array_values(array_unique($vendor_caps));
for ($caps = 0; $caps < count($vendor_caps_unigue); $caps++) {
    if ((mb_strtoupper($vendor_caps_unigue[$caps]) === $vendor_caps_unigue[$caps]) and $vendor_caps_unigue[$caps] !== '') {
        $capss++;
    array_push($array_vendor_caps, $vendor_caps_unigue[$caps]);
    }
}

// проверка на несколько categoryId в пределах одного offer
$several_categoryId_in_offer = 0;
foreach ($xml->shop->offers->offer as $offer) {
foreach ($offer->categoryId as $categoryId) {
$categoryId_by_offer[] = $categoryId;
if (count($categoryId_by_offer) > 1 ) {$several_categoryId_in_offer++;};
 }
$categoryId_by_offer = array();
}

// проверка, чтоб был указан stock_quantity в каждой карточке товара.
$stock_quantity = 0;

foreach ($xml->shop->offers->offer as $offer) {
    if (empty(strip_tags(trim("$offer->stock_quantity"))) and $offer->stock_quantity == '') {
        $stock_quantity++;
    }
}

// проверка, чтоб был указан categoryId в каждой карточке товара.

$category_offer = 0;
foreach ($xml->shop->offers->offer as $offer) {
    if (empty(strip_tags(trim("$offer->categoryId"))))
        $category_offer++;
}

// проверка на наличие товара через available.

$available_offer = 0;
foreach ($xml->shop->offers->offer as $offer) {
    if (($offer['available'] == 'false' or empty($offer['available'])) or ($offer['available'] == 'true' and $offer->stock_quantity == '0' and $offer->stock_quantity !== '')) {
        $available_offer++;
    }
};

// проверка на наличие в available русских букв.

$available_offer_rus = 0;
foreach ($xml->shop->offers->offer as $offer) {
    if ($offer['аvailable'] == 'false' or $offer['аvailable'] == 'true')
        $available_offer_rus++;
}

// проверка на наличие названия товара.

$name_offer = 0;
foreach ($xml->shop->offers->offer as $offer) {
    if (empty(strip_tags(trim("$offer->name"))) and empty(strip_tags(trim("$offer->model")))) {
        $name_offer++;
    }
    ;
}

// проверка на наличие производителя через тег vendor.

$vendor_offer = 0;
foreach ($xml->shop->offers->offer as $offer) {
    if (empty(strip_tags(trim("$offer->vendor"))))
        $vendor_offer++;
}
// проверка на наличие написания производителя в названии через name или model; не проверяется, если есть и name и model в одной карточке товара

$num_ne_ukazan_vendor_name  = 0;
$num_ne_ukazan_vendor_model = 0;
foreach ($xml->shop->offers->offer as $offer) {
    $array_name_offer[]      = "$offer->name";
    $array_model_offer[]     = "$offer->model";
    $array_vendor_by_offer[] = "$offer->vendor";
}

for ($count_array_name_offer = 0; $count_array_name_offer < count($array_name_offer); $count_array_name_offer++) {
    $ne_ukazan_vendor_name = strrpos(mb_strtolower($array_name_offer[$count_array_name_offer]), mb_strtolower($array_vendor_by_offer[$count_array_name_offer]));
    if ($ne_ukazan_vendor_name === false and empty($array_vendor_by_offer[$count_array_name_offer]) != true) {
        $num_ne_ukazan_vendor_name++;
    }
}

for ($count_array_model_offer = 0; $count_array_model_offer < count($array_model_offer); $count_array_model_offer++) {
    $ne_ukazan_vendor_model = strrpos(mb_strtolower($array_model_offer[$count_array_model_offer]), mb_strtolower($array_vendor_by_offer[$count_array_model_offer]));
    if ($ne_ukazan_vendor_model === false and empty($array_vendor_by_offer[$count_array_model_offer]) != true) {
        $num_ne_ukazan_vendor_model++;
    }
}

// проверка на наличие параметров с пустым значением.

$param_null_value = 0;
foreach ($xml->shop->offers->offer as $offer) {
    foreach ($offer->param as $param) {
        $count_param[] = "$param";
        if (empty(strip_tags(trim("$param")))) {
            $param_null_value++;
        }
    }
}


// проверка на наличие параметров товара.

$param_name = 0;

foreach ($xml->shop->offers->offer as $offer) {
    if ( empty(strip_tags(trim($offer->param['name'])))) {
        $param_name++;
    }
}

// проверка на наличие дублей названий параметров товара.
$double_param_name = 0;
$unique_double2 = array();
$double2 = array();
foreach ($xml->shop->offers->offer as $offer) {
    foreach ($offer->param as $param) {
        $double2[] = $param['name'];
    }
    if (count($double2) > 0) {
        $unique_double2       = array_unique($double2);
        $result_double_param2 = array_diff_assoc($double2, $unique_double2);
    }
    if (count($double2) !== count($unique_double2) and count($double2) > 0) {
        $double_param_name++;
    }
    $double2 = array();
}

// проверка на наличие наличие ссылок в параметрах товара.

$http_param = 0;

foreach ($xml->shop->offers->offer as $offer) {
    foreach ($offer->param as $param) {
        
        // echo $param.'<br>'.'<hr>'.$http_param;
        
        if (strrpos($offer->param, 'https') !== false or strrpos("$param", 'http:') !== false or strrpos("$param", '.gif') !== false or strrpos("$param", '.com') !== false or strrpos("$param", 'www') !== false or strrpos("$param", '.ua') !== false or strrpos("$param", '.net') !== false or strrpos("$param", '.png') !== false or strrpos("$param", '.jpg') !== false or strrpos("$param[name]", 'https') !== false or strrpos("$param[name]", 'http:') !== false or strrpos("$param[name]", '.gif') !== false or strrpos("$param[name]", 'www') !== false or strrpos("$param[name]", '.ua') !== false or strrpos("$param[name]", '.net') !== false or strrpos("$param[name]", '.png') !== false or strrpos("$param[name]", '.jpg') !== false or strrpos("$param[name]", '.com') !== false or strrpos("$param[name]", '.net') !== false) {
            $http_param++;
        }
    }
}

// проверка на наличие фото товара.

$picture_offer = 0;

foreach ($xml->shop->offers->offer as $offer) {
    if (empty(strip_tags(trim("$offer->picture"))))
        $picture_offer++;
}

// проверка на наличие фото с пустым значением.
$picture_null_value = 0;
foreach ($xml->shop->offers->offer as $offer) {
    foreach ($offer->picture as $picture) {
        if (empty(strip_tags(trim("$picture")))) {
            $picture_null_value++;
        }
    }
}

// проверка на правильное разширение файла фото(jpeg, jpg, png, bmp, svg, tif, webp).
$picture_filename_extension = 0;
foreach ($xml->shop->offers->offer as $offer) {
    foreach ($offer->picture as $picture) {
        if (empty(strip_tags(trim("$picture"))) === false and strrpos(strtolower($picture), '.jpg') == false and strrpos(strtolower($picture), '.jpeg') == false and strrpos(strtolower($picture), '.png') == false and strrpos(strtolower($picture), '.gif') == false and strrpos(strtolower($picture), '.bmp') == false and strrpos(strtolower($picture), '.svg') == false and strrpos(strtolower($picture), '.tif') == false and strrpos(strtolower($picture), '.webp') == false) {
            $picture_filename_extension++;
        }
    }
}

// проверка на наличие ссылки на товар.

$url_offer = 0;

foreach ($xml->shop->offers->offer as $offer) {
    if (empty(strip_tags(trim("$offer->url"))))
        $url_offer++;
}

// проверка на наличие описания и наличие ссылок http и https в описании товара.

$http_description  = 0;
$description_offer = 0;

foreach ($xml->shop->offers->offer as $offer) {
    if (strrpos("$offer->description", 'https') !== false or strrpos("$offer->description", 'http:') !== false or strrpos("$offer->description", '.gif') !== false or strrpos("$offer->description", '.com') !== false or strrpos("$offer->description", 'www') !== false or strrpos("$offer->description", '.ua') !== false or strrpos("$offer->description", '.net') !== false or strrpos("$offer->description", '.png') !== false or strrpos("$offer->description", '.jpg') !== false) {
        $http_description++;
    }
    
    if (empty(strip_tags(trim("$offer->description")))) {
        $description_offer++;
    }
    ;
}

// проверка на наличие offer id в карточке товара.

$offer_id = 0;

foreach ($xml->shop->offers->offer as $offer) {
    if (empty($offer['id']))
        $offer_id++;
}

// проверка на наличие цены в товарах.

$price_offer = 0;

foreach ($xml->shop->offers->offer as $offer) {
    if (empty(strip_tags(trim("$offer->price"))) or ($offer->price) <= 0)
        $price_offer++;
}

// проверка на наличие валюты в товарах.

$currencyId = 0;

foreach ($xml->shop->offers->offer as $offer) {
    if (empty(strip_tags(trim("$offer->currencyId"))))
        $currencyId++;
}

// проверка на наличие товаров дешевле 10грн.

$price_ten = 0;

foreach ($xml->shop->offers->offer as $offer) {
    if ($offer->price < 10 and empty(strip_tags(trim("$offer->price"))) != true and ($offer->price) > 0 and $offer->currencyId == 'UAH')
        $price_ten++;
}

// проверка на наличие пробела в categoryId товара.

$num_naiden_probel_categoryId = 0;

foreach ($xml->shop->offers->offer as $offer) {
    $probel_categoryId        = "$offer->categoryId";
    $naiden_probel_categoryId = strrpos($probel_categoryId, ' ');
    if ($naiden_probel_categoryId === false) {
    } else {
        $num_naiden_probel_categoryId++;
    }
}

// проверка на наличие пробела в offer_id товара.

$num_naiden_probel_offer_id = 0;

foreach ($xml->shop->offers->offer as $offer) {
    $probel_offer_id        = "$offer[id]";
    $naiden_probel_offer_id = strrpos($probel_offer_id, ' ');
    if ($naiden_probel_offer_id === false) {
    } else {
        $num_naiden_probel_offer_id++;
    }
}

// проверка на наличие пробела в url товара

$num_naiden_probel_url = 0;

foreach ($xml->shop->offers->offer as $offer) {
    $probel_url        = "$offer->url";
    $probel_url = trim($probel_url);
    $naiden_probel_url = strrpos($probel_url, ' ');
    if ($naiden_probel_url === false) {
    } else {
        $num_naiden_probel_url++;
    }
}

// проверка на наличие пробела в price товара

$num_naiden_probel_price = 0;

foreach ($xml->shop->offers->offer as $offer) {
    $probel_price        = "$offer->price";
    $naiden_probel_price = strrpos($probel_price, ' ');
    if ($naiden_probel_price === false) {
    } else {
        $num_naiden_probel_price++;
    }
}

// проверка на наличие пробела в currencyId товара

$num_naiden_probel_currencyId = 0;

foreach ($xml->shop->offers->offer as $offer) {
    $probel_currencyId        = "$offer->currencyId";
    $naiden_probel_currencyId = strrpos($probel_currencyId, ' ');
    if ($naiden_probel_currencyId === false) {
    } else {
        $num_naiden_probel_currencyId++;
    }
}

// проверка на наличие пробела в picture товара

$num_naiden_probel_picture = 0;

foreach ($xml->shop->offers->offer as $offer) {
    foreach ($offer->picture as $picture44) {
        $count_of_picture_112[] = "$picture44";
        $probel_picture         = "$picture44";
        $probel_picture = trim($probel_picture);
        $naiden_probel_picture  = strrpos($probel_picture, ' ');
        if ($naiden_probel_picture === false) {
        } else {
            $num_naiden_probel_picture++;
        }
    }
}

// проверка на наличие дублей offer id.
$array_count_values_offer_id  = 0;
$array_values_offer_id = 0;
$array_double_offer_id = array();
$array_repeat_double_offer_id = array();
$double_offer_id = 0;
foreach ($xml->shop->offers->offer as $offer) {
    if("$offer[id]"){$num_offer[] = "$offer[id]";}
}
$offer_unique = array_unique($num_offer);
$sum_offerId  = count($num_offer) - count($offer_unique);
if (count($offer_unique) !== count($num_offer)) {
$array_count_values_offer_id = (array_count_values($num_offer));
    arsort($array_count_values_offer_id);
    
if (count($array_count_values_offer_id) > 1) {
    $array_keys_offer_id = array_keys($array_count_values_offer_id);
}
if (count($array_count_values_offer_id) > 1) {
    $array_values_offer_id = array_values($array_count_values_offer_id);
}

for ($count_values_offer_id = 0; $count_values_offer_id < count($array_keys_offer_id); $count_values_offer_id++) {
    if ($array_values_offer_id[$count_values_offer_id] > 1)
        $double_offer_id++;
}
for ($count_double_offer_id = 0; $count_double_offer_id < $double_offer_id; $count_double_offer_id++) {
array_push($array_double_offer_id, $array_keys_offer_id[$count_double_offer_id]);
array_push($array_repeat_double_offer_id, $array_values_offer_id[$count_double_offer_id]);
}
}

// проверка на дубли названия товара через name или model.
$array_count_values_name = 0;
$array_count_values_model = 0;
$repeat_double_model = 0;
$repeat_double_name = 0;
$array_double_name = array();
$array_repeat_double_name = array();
$array_double_model = array();
$array_repeat_double_model = array();
foreach ($xml->shop->offers->offer as $offer) {
    if("$offer->name"){$num_name[]  = "$offer->name";}
    if("$offer->model"){$num_model[] = "$offer->model";}
}
$offer_unique_name  = array_unique($num_name);
$offer_unique_model = array_unique($num_model);
$sum_offer_name     = count($num_name) - count($offer_unique_name);
if ($sum_offer_name == (count($num_name) - 1)) {
    $sum_offer_name = 0;
}
$sum_offer_model = count($num_model) - count($offer_unique_model);
if ($sum_offer_model == (count($num_model) - 1)) {
    $sum_offer_model = 0;
}
if (count($offer_unique_name) !== count($num_name) and $sum_offer_name !== 0) {
    $array_count_values_name = (array_count_values($num_name));
    arsort($array_count_values_name);
}
if (count($offer_unique_model) !== count($num_model) and $sum_offer_model !== 0 and empty($num_name[0])) {
    $array_count_values_model = (array_count_values($num_model));
    arsort($array_count_values_model);
}
if (count($array_count_values_name) > 1) {
    $double_name = array_keys($array_count_values_name);
}
if (count($array_count_values_model) > 1) {
    $double_model = array_keys($array_count_values_model);
}
if (count($array_count_values_name) > 1) {
    $repeat_double_name = array_values($array_count_values_name);
}
if (count($array_count_values_model) > 1) {
    $repeat_double_model = array_values($array_count_values_model);
}
$count_repeat_double_name = 0;
$count_repeat_double_model = 0;
for ($num_repeat_double_name = 0; $num_repeat_double_name < count($repeat_double_name); $num_repeat_double_name++) {
    if ($repeat_double_name[$num_repeat_double_name] > 1)
        $count_repeat_double_name++;
}
for ($num_repeat_double_model = 0; $num_repeat_double_model < count($repeat_double_model); $num_repeat_double_model++) {
    if ($repeat_double_model[$num_repeat_double_model] > 1)
        $count_repeat_double_model++;
}
$num_double_name = 1;
$num_double_model = 1;
for ($count_double_name = 0; $count_double_name < $count_repeat_double_name; $count_double_name++) {
    array_push($array_double_name, $double_name[$count_double_name]);
    array_push($array_repeat_double_name, $repeat_double_name[$count_double_name]);
}
for ($count_double_model = 0; $count_double_model < $count_repeat_double_model; $count_double_model++) {
    array_push($array_double_model, $double_model[$count_double_model]);
    array_push($array_repeat_double_model, $repeat_double_model[$count_double_model]);
}

// проверка, чтоб для categoryId прописаны категории в categories
foreach ($xml->shop->offers->offer as $offer) {
    foreach ($offer->categoryId as $categoryId) {
        $all_categoryId_by_offer[] = "$offer->categoryId";
    }
}
$unique_categoryId_by_offer = array_unique($all_categoryId_by_offer);
sort($unique_categoryId_by_offer);
foreach ($xml->shop->categories->category as $category) {
    $sort_category_id[] = "$category[id]";
    sort($sort_category_id);
}
$not_write_category = 0;
$array_not_write_category = array();
for ($num_category_id = 0; $num_category_id < count($unique_categoryId_by_offer); $num_category_id++) {
    if (in_array(($unique_categoryId_by_offer[$num_category_id]), $sort_category_id)) {
    } elseif (empty($unique_categoryId_by_offer[$num_category_id]) == false) {
        $not_write_category++;
        array_push($array_not_write_category, $unique_categoryId_by_offer[$num_category_id]);
    }
}

// проверка запрещенных вендоров
$vendor_veto = array();
$vendor_stop = 0;
foreach ($xml->shop->offers->offer as $offer) {
    $array_vendor_zapret[] = "$offer->vendor";
}

$array_vendor_zapret_unigue = array_unique($array_vendor_zapret);
$array_vendor_zapret_unigue = array_values($array_vendor_zapret_unigue);
$array_vendor_zapret_unigue = array_map('strtolower', $array_vendor_zapret_unigue);
for($i = 0; $i < count($array_vendor_zapret_unigue); $i++) {
if($array_vendor_zapret_unigue[$i]){
    
$boolean_vendor_zapret_Acer = ($array_vendor_zapret_unigue[$i] === 'acer');
if ($boolean_vendor_zapret_Acer !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Acer(Ноутбуки, Смартфоны, Мониторы, Проекторы, VR-очки).'); $vendor_stop++;
}

$boolean_vendor_zapret_Adidas = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Adidas'));
if ($boolean_vendor_zapret_Adidas !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Adidas(Одежда, обувь, аксессуары).'); $vendor_stop++;
}

$boolean_vendor_zapret_Air_Wick = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Air Wick'));
if ($boolean_vendor_zapret_Air_Wick !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Air Wick(Reckitt Benckiser Gmbh)(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Amazfit = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Amazfit'));
if ($boolean_vendor_zapret_Amazfit !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Amazfit(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Ariel = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Ariel'));
if ($boolean_vendor_zapret_Ariel !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Ariel(Procter&Gamble)(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Asus = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Asus'));
if ($boolean_vendor_zapret_Asus !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Asus(Ноутбуки, Смартфоны, Мониторы, Проекторы, VR-очки).'); $vendor_stop++;
}

$boolean_vendor_zapret_AULDEY = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('AULDEY'));
if ($boolean_vendor_zapret_AULDEY !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель AULDEY(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Avionaut = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Avionaut'));
if ($boolean_vendor_zapret_Avionaut !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Avionaut(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_BabaMama = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('BabaMama'));
if ($boolean_vendor_zapret_BabaMama !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель BabaMama(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Babyliss = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Babyliss'));
if ($boolean_vendor_zapret_Babyliss !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Babyliss(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Bastion = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Bastion'));
if ($boolean_vendor_zapret_Bastion !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Bastion(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_BAYBY = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('BAYBY'));
if ($boolean_vendor_zapret_BAYBY !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель BAYBY(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Becks_Plastilin = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Becks Plastilin'));
if ($boolean_vendor_zapret_Becks_Plastilin !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Becks Plastilin(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Bold = ($array_vendor_zapret_unigue[$i] === 'bold');
if ($boolean_vendor_zapret_Bold !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Bold(Procter&Gamble)(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Bonux = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Bonux'));
if ($boolean_vendor_zapret_Bonux !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Bonux(Procter&Gamble)(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Bosch = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Bosch'));
if ($boolean_vendor_zapret_Bosch !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Bosch - запрещены БТ, МБТ, КБТ, разрешен Bosch Professional и разрешен бренд Bosch в инструментах.'); $vendor_stop++;
}

$boolean_vendor_zapret_Braun = ($array_vendor_zapret_unigue[$i] ==='braun');
if ($boolean_vendor_zapret_Braun !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Braun(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Bref = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Bref'));
if ($boolean_vendor_zapret_Bref !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Bref(Henkel)(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Bryza = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Bryza'));
if ($boolean_vendor_zapret_Bryza !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Bryza(Reckitt Benckiser Gmbh)(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Calgon = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Calgon'));
if ($boolean_vendor_zapret_Calgon !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Calgon(Reckitt Benckiser Gmbh)(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Calgonit = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Calgonit'));
if ($boolean_vendor_zapret_Calgonit !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Calgonit(Reckitt Benckiser Gmbh)(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Calvin_Klein = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Calvin Klein'));
if ($boolean_vendor_zapret_Calvin_Klein !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Calvin Klein(Наручные часы).'); $vendor_stop++;
}

$boolean_vendor_zapret_CANDINO = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('CANDINO'));
if ($boolean_vendor_zapret_CANDINO !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель CANDINO(Наручные часы).'); $vendor_stop++;
}

$boolean_vendor_zapret_Cillit = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Cillit'));
if ($boolean_vendor_zapret_Cillit !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Cillit(Reckitt Benckiser Gmbh)(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Clarks = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Clarks'));
if ($boolean_vendor_zapret_Clarks !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Clarks(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Clean = ($array_vendor_zapret_unigue[$i] === 'clean');
if ($boolean_vendor_zapret_Clean !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Clean(Henkel)(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Cooper_Hunter = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Cooper&Hunter'));
if ($boolean_vendor_zapret_Cooper_Hunter !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Cooper&Hunter(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Crocs = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Crocs'));
if ($boolean_vendor_zapret_Crocs !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Crocs(Одежда, обувь, аксессуары).'); $vendor_stop++;
}

$boolean_vendor_zapret_Dash = ($array_vendor_zapret_unigue[$i] === 'dash');
if ($boolean_vendor_zapret_Dash !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Dash(Procter&Gamble)(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Dax = ($array_vendor_zapret_unigue[$i] === 'dax');
if ($boolean_vendor_zapret_Dax !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Dax(Procter&Gamble)(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Daz = ($array_vendor_zapret_unigue[$i] === 'daz');
if ($boolean_vendor_zapret_Daz !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Daz(Procter&Gamble)(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Dell = ($array_vendor_zapret_unigue[$i] === 'dell');
if ($boolean_vendor_zapret_Dell !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Dell(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_DELONGHI = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('DELONGHI'));
if ($boolean_vendor_zapret_DELONGHI !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель DELONGHI(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Deni = ($array_vendor_zapret_unigue[$i] === 'deni');
if ($boolean_vendor_zapret_Deni !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Deni(Henkel)(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Diadora = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Diadora'));
if ($boolean_vendor_zapret_Diadora !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Diadora(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Dixan = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Dixan'));
if ($boolean_vendor_zapret_Dixan !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Dixan(Henkel)(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Dosenka = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Dosenka'));
if ($boolean_vendor_zapret_Dosenka !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Dosenka(Reckitt Benckiser Gmbh)(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Dosia = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Dosia'));
if ($boolean_vendor_zapret_Dosia !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Dosia(Reckitt Benckiser Gmbh)(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Dreft = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Dreft'));
if ($boolean_vendor_zapret_Dreft !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Dreft(Procter&Gamble)(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Ecco = ($array_vendor_zapret_unigue[$i] === 'ecco');
if ($boolean_vendor_zapret_Ecco !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Ecco(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Eichhorn = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Eichhorn'));
if ($boolean_vendor_zapret_Eichhorn !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Eichhorn(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Epson = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Epson'));
if ($boolean_vendor_zapret_Epson !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Epson(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Fairy = ($array_vendor_zapret_unigue[$i] === 'fairy');
if ($boolean_vendor_zapret_Fairy !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Fairy(Procter&Gamble)(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Festina = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Festina'));
if ($boolean_vendor_zapret_Festina !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Festina(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Finish = ($array_vendor_zapret_unigue[$i] === 'finish');
if ($boolean_vendor_zapret_Finish !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Finish(Reckitt Benckiser Gmbh)(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_fischertechnik = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('fischertechnik'));
if ($boolean_vendor_zapret_fischertechnik !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель fischertechnik(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_fischerTIP = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('fischerTIP'));
if ($boolean_vendor_zapret_fischerTIP !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель fischerTIP(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Gala = ($array_vendor_zapret_unigue[$i] === 'gala');
if ($boolean_vendor_zapret_Gala !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Gala(Procter&Gamble)(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Galileo = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Galileo'));
if ($boolean_vendor_zapret_Galileo !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Galileo(Только детские велосипеды).'); $vendor_stop++;
}

$boolean_vendor_zapret_Galinka = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Galinka'));
if ($boolean_vendor_zapret_Galinka !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Galinka(Procter&Gamble)(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Geox = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Geox'));
if ($boolean_vendor_zapret_Geox !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Geox(Одежда, обувь, аксессуары).'); $vendor_stop++;
}

$boolean_vendor_zapret_Gillette = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Gillette'));
if ($boolean_vendor_zapret_Gillette !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Gillette(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_goki = ($array_vendor_zapret_unigue[$i] === 'goki');
if ($boolean_vendor_zapret_goki !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель goki(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_GoPro = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('GoPro'));
if ($boolean_vendor_zapret_GoPro !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель GoPro(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Heimess = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Heimess'));
if ($boolean_vendor_zapret_Heimess !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Heimess(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Hitachi = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Hitachi'));
if ($boolean_vendor_zapret_Hitachi !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Hitachi(Телевизоры).'); $vendor_stop++;
}

$boolean_vendor_zapret_Huawei = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Huawei'));
if ($boolean_vendor_zapret_Huawei !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Huawei(Ноутбуки, Смартфоны,VR-очки, Планшеты, Маршрутизаторы (кроме категории мобильный интернет)).'); $vendor_stop++;
}

$boolean_vendor_zapret_Janod = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Janod'));
if ($boolean_vendor_zapret_Janod !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Janod(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Jedo = ($array_vendor_zapret_unigue[$i] === 'jedo');
if ($boolean_vendor_zapret_Jedo !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Jedo(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Kaloo = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Kaloo'));
if ($boolean_vendor_zapret_Kaloo !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Kaloo(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Kenwood = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Kenwood'));
if ($boolean_vendor_zapret_Kenwood !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Kenwood(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Kokosal = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Kokosal'));
if ($boolean_vendor_zapret_Kokosal !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Kokosal(Henkel)(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Koolsun = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Koolsun'));
if ($boolean_vendor_zapret_Koolsun !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Koolsun(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Krups = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Krups'));
if ($boolean_vendor_zapret_Krups !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Krups(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Lacoste = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Lacoste'));
if ($boolean_vendor_zapret_Lacoste !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Lacoste(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Lapsi = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Lapsi'));
if ($boolean_vendor_zapret_Lapsi !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Lapsi(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Laska = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Laska'));
if ($boolean_vendor_zapret_Laska !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Laska(Henkel)(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Le_Chat = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Le Chat'));
if ($boolean_vendor_zapret_Le_Chat !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Le Chat(Henkel)(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_LEGO = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('LEGO'));
if ($boolean_vendor_zapret_LEGO !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель LEGO(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Lenor = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Lenor'));
if ($boolean_vendor_zapret_Lenor !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Lenor(Procter&Gamble)(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Lenovo = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Lenovo'));
if ($boolean_vendor_zapret_Lenovo !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Lenovo(Ноутбуки, мобильные телефоны).'); $vendor_stop++;
}

$boolean_vendor_zapret_LG = ($array_vendor_zapret_unigue[$i] === 'lg');
if ($boolean_vendor_zapret_LG !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель LG(Мобильные телефоны).'); $vendor_stop++;
}

$boolean_vendor_zapret_Light_Stax = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Light Stax'));
if ($boolean_vendor_zapret_Light_Stax !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Light Stax(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Losk = ($array_vendor_zapret_unigue[$i] === 'losk');
if ($boolean_vendor_zapret_Losk !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Losk(Henkel)(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Lovela = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Lovela'));
if ($boolean_vendor_zapret_Lovela !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Lovela(Reckitt Benckiser Gmbh)(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Magplayer = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Magplayer'));
if ($boolean_vendor_zapret_Magplayer !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Magplayer(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Meizu = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Meizu'));
if ($boolean_vendor_zapret_Meizu !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Meizu(Мобильные телефоны ).'); $vendor_stop++;
}

$boolean_vendor_zapret_Mif = ($array_vendor_zapret_unigue[$i] === 'mif');
if ($boolean_vendor_zapret_Mif !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Mif(Procter&Gamble)(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_MiJia = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('MiJia'));
if ($boolean_vendor_zapret_MiJia !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель MiJia(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Miqilong = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Miqilong'));
if ($boolean_vendor_zapret_Miqilong !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Miqilong(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Motorola = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Motorola'));
if ($boolean_vendor_zapret_Motorola !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Motorola(Мобильные телефоны).'); $vendor_stop++;
}

$boolean_vendor_zapret_Nokia = ($array_vendor_zapret_unigue[$i] === 'nokia');
if ($boolean_vendor_zapret_Nokia !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Nokia(Мобильные телефоны).'); $vendor_stop++;
}

$boolean_vendor_zapret_Motul = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Motul'));
if ($boolean_vendor_zapret_Motul !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Motul(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Moulinex = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Moulinex'));
if ($boolean_vendor_zapret_Moulinex !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Moulinex(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Mr_Proper = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Mr.Proper'));
if ($boolean_vendor_zapret_Mr_Proper !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Mr.Proper(Procter&Gamble)(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_NATTOU = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('NATTOU'));
if ($boolean_vendor_zapret_NATTOU !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель NATTOU(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Neon = ($array_vendor_zapret_unigue[$i] === 'neon');
if ($boolean_vendor_zapret_Neon !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Neon(Только детские самокаты).'); $vendor_stop++;
}

$boolean_vendor_zapret_New_Balance = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('New Balance'));
if ($boolean_vendor_zapret_New_Balance !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель New Balance(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_nic = ($array_vendor_zapret_unigue[$i] === 'nic');
if ($boolean_vendor_zapret_nic !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель nic(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Nike = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Nike'));
if ($boolean_vendor_zapret_Nike !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Nike(Одежда, обувь, аксессуары).'); $vendor_stop++;
}

$boolean_vendor_zapret_Nuvita = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Nuvita'));
if ($boolean_vendor_zapret_Nuvita !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Nuvita(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Olmo = ($array_vendor_zapret_unigue[$i] === 'olmo');
if ($boolean_vendor_zapret_Olmo !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Olmo(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Oral_B = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Oral-B'));
if ($boolean_vendor_zapret_Oral_B !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Oral-B(Procter&Gamble)(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Oribel = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Oribel'));
if ($boolean_vendor_zapret_Oribel !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Oribel(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Panasonic = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Panasonic'));
if ($boolean_vendor_zapret_Panasonic !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Panasonic(Все категории ИТ (кроме аксессуаров, наушников)).'); $vendor_stop++;
}

$boolean_vendor_zapret_Pemos = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Pemos'));
if ($boolean_vendor_zapret_Pemos !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Pemos(Henkel)(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Persil = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Persil'));
if ($boolean_vendor_zapret_Persil !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Persil(Henkel)(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Perwoll = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Perwoll'));
if ($boolean_vendor_zapret_Perwoll !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Perwoll(Henkel)(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Philips = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Philips'));
if ($boolean_vendor_zapret_Philips !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Philips(Все категории, кроме телевизоров, аксессуаров, наушников).'); $vendor_stop++;
}

$boolean_vendor_zapret_Playmags = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Playmags'));
if ($boolean_vendor_zapret_Playmags !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Playmags(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Pop_it_Up = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Pop-it-Up'));
if ($boolean_vendor_zapret_Pop_it_Up !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Pop-it-Up(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Primigi = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Primigi'));
if ($boolean_vendor_zapret_Primigi !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Primigi(Одежда, обувь, аксессуары).'); $vendor_stop++;
}

$boolean_vendor_zapret_Puma = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Puma'));
if ($boolean_vendor_zapret_Puma !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Puma(Одежда, обувь, аксессуары).'); $vendor_stop++;
}

$boolean_vendor_zapret_QCBABY = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('QCBABY'));
if ($boolean_vendor_zapret_QCBABY !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель QCBABY(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Reebok = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Reebok'));
if ($boolean_vendor_zapret_Reebok !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Reebok(Одежда, обувь, аксессуары).'); $vendor_stop++;
}

$boolean_vendor_zapret_Remington = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Remington'));
if ($boolean_vendor_zapret_Remington !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Remington(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Rex = ($array_vendor_zapret_unigue[$i] === 'rex');
if ($boolean_vendor_zapret_Rex !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Rex(Henkel)(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Rowenta = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Rowenta'));
if ($boolean_vendor_zapret_Rowenta !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Rowenta(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Russel_Hobs = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Russel Hobs'));
if ($boolean_vendor_zapret_Russel_Hobs !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Russel Hobs(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Saeco = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Saeco'));
if ($boolean_vendor_zapret_Saeco !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Saeco(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Same_Toy = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Same Toy'));
if ($boolean_vendor_zapret_Same_Toy !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Same Toy(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Samsung = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Samsung'));
if ($boolean_vendor_zapret_Samsung !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Samsung(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Scribble_Down = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Scribble Down'));
if ($boolean_vendor_zapret_Scribble_Down !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Scribble Down(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Sequin_Art = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Sequin Art'));
if ($boolean_vendor_zapret_Sequin_Art !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Sequin Art(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Siemens = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Siemens'));
if ($boolean_vendor_zapret_Siemens !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Siemens(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_sigikid = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('sigikid'));
if ($boolean_vendor_zapret_sigikid !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель sigikid(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Silan = ($array_vendor_zapret_unigue[$i] === 'silan');
if ($boolean_vendor_zapret_Silan !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Silan(Henkel)(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Skechers = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Skechers'));
if ($boolean_vendor_zapret_Skechers !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Skechers(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Soft_toy = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Soft toy'));
if ($boolean_vendor_zapret_Soft_toy !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Soft toy(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Somat = ($array_vendor_zapret_unigue[$i] === 'somat');
if ($boolean_vendor_zapret_Somat !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Somat (Henkel)(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Sony = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Sony'));
if ($boolean_vendor_zapret_Sony !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Sony(Все категории, кроме IT аксессуаров).'); $vendor_stop++;
}

$boolean_vendor_zapret_SWATCH = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('SWATCH'));
if ($boolean_vendor_zapret_SWATCH !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель SWATCH(Наручные часы).'); $vendor_stop++;
}

$boolean_vendor_zapret_Tefal = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Tefal'));
if ($boolean_vendor_zapret_Tefal !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Tefal(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Tide = ($array_vendor_zapret_unigue[$i] === 'tide');
if ($boolean_vendor_zapret_Tide !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Tide(Procter&Gamble)(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Timberland = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Timberland'));
if ($boolean_vendor_zapret_Timberland !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Timberland(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Tiret = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Tiret'));
if ($boolean_vendor_zapret_Tiret !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Tiret(Reckitt Benckiser Gmbh)(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Tissot = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Tissot'));
if ($boolean_vendor_zapret_Tissot !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Tissot(Наручные часы).'); $vendor_stop++;
}

$boolean_vendor_zapret_Tomi = ($array_vendor_zapret_unigue[$i] === 'tomi');
if ($boolean_vendor_zapret_Tomi !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Tomi(Henkel)(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Tosot = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Tosot'));
if ($boolean_vendor_zapret_Tosot !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Tosot(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_TP_Link = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('TP-Link'));
if ($boolean_vendor_zapret_TP_Link !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель TP-Link(Сетевое оборудование).'); $vendor_stop++;
}

$boolean_vendor_zapret_UGG = ($array_vendor_zapret_unigue[$i] === 'ugg');
if ($boolean_vendor_zapret_UGG !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель UGG(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Under_Armour = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Under Armour'));
if ($boolean_vendor_zapret_Under_Armour !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Under Armour(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Vagabond = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Vagabond'));
if ($boolean_vendor_zapret_Vagabond !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Vagabond(Одежда, обувь, аксессуары).'); $vendor_stop++;
}

$boolean_vendor_zapret_Vanish = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Vanish'));
if ($boolean_vendor_zapret_Vanish !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Vanish(Reckitt Benckiser Gmbh)(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Vans = ($array_vendor_zapret_unigue[$i] === 'vans');
if ($boolean_vendor_zapret_Vans !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Vans(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Vitek = ($array_vendor_zapret_unigue[$i] === 'vitek');
if ($boolean_vendor_zapret_Vitek !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Vitek(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Vizir = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Vizir'));
if ($boolean_vendor_zapret_Vizir !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Vizir(Procter&Gamble)(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Wipp_Express = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Wipp Express'));
if ($boolean_vendor_zapret_Wipp_Express !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Wipp Express(Henkel)(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_WonderWorld = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('WonderWorld'));
if ($boolean_vendor_zapret_WonderWorld !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель WonderWorld(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Xiaomi = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Xiaomi'));
if ($boolean_vendor_zapret_Xiaomi !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Xiaomi(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Yeelight = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Yeelight'));
if ($boolean_vendor_zapret_Yeelight !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Yeelight(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_Zelmer = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('Zelmer'));
if ($boolean_vendor_zapret_Zelmer !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель Zelmer(Все категории).'); $vendor_stop++;
}

$boolean_vendor_zapret_ZMi = strrpos($array_vendor_zapret_unigue[$i], mb_strtolower('ZMi'));
if ($boolean_vendor_zapret_ZMi !== false) {
array_push($vendor_veto, 'Присутствует запрещенный для продаж производитель ZMi(Все категории).'); $vendor_stop++;
}
}
}

// проверка на наличие в описании стоп слов.
$description_stop_sum  = 0;
$description_store     = 0;
$description_pay       = 0;
$description_delivery  = 0;
$description_buy       = 0;
$description_phone     = 0;
$description_uah       = 0;
$description_site      = 0;
$description_price     = 0;
$description_price2    = 0;
$description_manager   = 0;
$description_proposal  = 0;
$description_call      = 0;
$description_contact   = 0;
$description_variation = 0;
$description_order     = 0;

foreach ($xml->shop->offers->offer as $offer) {
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
    
if ( strrpos($lower_description, 'магазин') !== false or strrpos($lower_description, 'оплат') !== false or strrpos($lower_description, 'доставк') !== false
    or strrpos($lower_description, 'купит') !== false or strrpos($lower_description, 'тел.') !== false or strrpos($lower_description, 'грн') !== false
    or strrpos($lower_description, 'сайт') !== false or strrpos($lower_description, 'цена') !== false or strrpos($lower_description, 'стоимость') !== false
    or strrpos($lower_description, 'менеджер') !== false or strrpos($lower_description, 'заявк') !== false or strrpos($lower_description, 'позвонит') !== false
    or strrpos($lower_description, 'обраща') !== false or strrpos($lower_description, 'вариа') !== false or strrpos($lower_description, 'заказ') !== false)
    {
        $description_stop_sum++;
    }
}
// ===============================================================================================================================
// ===============================================================================================================================
// ===============================================================================================================================
// ===============================================================================================================================
// ===============================================================================================================================
// ===============================================================================================================================
// ===============================================================================================================================
// ===============================================================================================================================
// ===============================================================================================================================
// ===============================================================================================================================

?>
<div class="result-list">
<?php

// Список запрещенных брендов
if ($vendor_stop) {
?>
    <div class="spoiler_links spoiler_title"><div class="title_list"><?php echo 'Запрещенные производители(бренды): ' . '<span style="color: red; font-weight: bold;">' .'&nbsp;'. $vendor_stop.'&nbsp;'. '</span>'.'из '. count($vendor_uniqueqqq); echo '&nbsp;';?><div class="icon_click"></div></div>
<div class="error-descriptoin">
Товары запрещенных прозводителей не будут выведены на сайт. Их можно не вносить в файл xml.
</div>       
</div>        
        <div class="spoiler_body">
          <button class="close-button" title="закрыть" onclick="closeAndScroll()"></button>
          <button class="copy-button" title="скопировать" onclick="onCopyHandle(event)"></button>
          <div class="line"></div>
          <!--<div class="columnOf4">-->
<?php
for ($num = 0; $num < count($vendor_veto); $num++) {
     echo '<div class="double-offer-id">'.'<span class="double-offer-id-id">'.$vendor_veto[$num].'</span>'.'</div>';
       }
?>
        <!--</div>-->
        <div class="line"></div>
        </div>
        <?php
}

// Список сategory id в categories прописанных не цифрами
if ($not_only_number_in_categoryId) {
?>
    <div class="spoiler_links spoiler_title"><div class="title_list"><?php echo 'Номера сategory id в categories прописанных не цифрами: ' . '<span style="color: red; font-weight: bold;">' .'&nbsp;'. $not_only_number_in_categoryId.'&nbsp;'. '</span>' . 'из ' . count($category_id_in_categories); echo '&nbsp;';?><div class="icon_click"></div></div>
<div class="error-descriptoin">
Только цифрами должны быть category id в categories.
</div>       
</div>        
        <div class="spoiler_body">
          <button class="close-button" title="закрыть" onclick="closeAndScroll()"></button>
          <button class="copy-button" title="скопировать" onclick="onCopyHandle(event)"></button>
          <div class="line"></div>
          <div class="columnOf4">
<?php
for ($num = 0; $num < count($array_not_only_number_in_categoryId); $num++) {
     $num_not_only_number_in_categoryId = $num + 1;
     echo '<div class="double-offer-id">'.'<span class="double-offer-id-num">'.$num_not_only_number_in_categoryId.')'.'</span>'.'<span class="double-offer-id-id">'.$array_not_only_number_in_categoryId[$num].'</span>'.'</div>';
       }
?>
        </div>
        <div class="line"></div>
        </div>
        <?php
}

// Список дублей сategory id в categories
if ($double_category_id_in_categories) {
?>
    <div class="spoiler_links spoiler_title"><div class="title_list"><?php echo 'Дубли сategory id в categories: ' . '<span style="color: red; font-weight: bold;">' .'&nbsp;'. $double_category_id_in_categories.'&nbsp;'. '</span>' . 'из ' . count($category_id_in_categories); echo '&nbsp;';?><div class="icon_click"></div></div>
<div class="error-descriptoin">
сategory id в categories должны быть уникальны.
</div>       
</div>        
        <div class="spoiler_body">
          <button class="close-button" title="закрыть" onclick="closeAndScroll()"></button>
          <button class="copy-button" title="скопировать" onclick="onCopyHandle(event)"></button>
          <div class="line"></div>
          <div class="columnOf4">
<?php
for ($num = 0; $num < count($array_double_category_id_in_categories); $num++) {
     $num_double_category_id_in_categories = $num + 1;
     echo '<div class="double-offer-id">'.'<span class="double-offer-id-num">'.$num_double_category_id_in_categories.')'.'</span>'.'<span class="double-offer-id-id">'.$array_double_category_id_in_categories[$num].'</span>'.'</div>';
       }
?>
        </div>
        <div class="line"></div>
        </div>
        <?php
}

// Список category id не прописаных в categories
if ($not_write_category) {
?>
    <div class="spoiler_links spoiler_title"><div class="title_list"><?php echo 'Номера category id не прописанные в categories: ' . '<span style="color: red; font-weight: bold;">' .'&nbsp;'. $not_write_category.'&nbsp;'. '</span>' . 'из ' . count($unique_categoryId_by_offer); echo '&nbsp;';?><div class="icon_click"></div></div>
<div class="error-descriptoin">
Необходимо прописать все category id в categories.
</div>       
</div>        
        <div class="spoiler_body">
          <button class="close-button" title="закрыть" onclick="closeAndScroll()"></button>
          <button class="copy-button" title="скопировать" onclick="onCopyHandle(event)"></button>
          <div class="line"></div>
          <div class="columnOf4">
<?php
for ($num = 0; $num < count($array_not_write_category); $num++) {
     $num_not_write_category = $num + 1;
     echo '<div class="double-offer-id">'.'<span class="double-offer-id-num">'.$num_not_write_category.')'.'</span>'.'<span class="double-offer-id-id">'.$array_not_write_category[$num].'</span>'.'</div>';
       }
?>
        </div>
        <div class="line"></div>
        </div>
        <?php
}

// Список дублей offer id
if ($sum_offerId) {
?>
        <div class="spoiler_links spoiler_title"><div class="title_list"><?php echo 'Дубли offer id: ' . '<span style="color: red; font-weight: bold;">' .'&nbsp;'. $sum_offerId.'&nbsp;'. '</span>' . 'из ' . count($all_offers); echo '&nbsp;';?><div class="icon_click"></div></div>
<div class="error-descriptoin">
Каждый offer id должен быть уникальным.</div>       
</div>        
        <div class="spoiler_body">
          <button class="close-button" title="закрыть" onclick="closeAndScroll()"></button>
          <button class="copy-button" title="скопировать" onclick="onCopyHandle(event)"></button>
          <div class="line"></div>
          <div class="columnOf4">
<?php
$num_double_offer_id = 0;
 for ($num = 0; $num < count($array_double_offer_id); $num++) {
     $num_double_offer_id = $num + 1;
     echo '<div class="double-offer-id">'.'<span class="double-offer-id-num">'.$num_double_offer_id.')'.'</span>'.'<span class="double-offer-id-id">'.$array_double_offer_id[$num].'</span>'.'(повторений: '.'<span class="double-offer-id-repeat">'.$array_repeat_double_offer_id[$num].')'.'</span>'.'</div>';
       }
?>
          </div>
          <div class="line"></div>
        </div>
        <?php
}

// Список дублей названий товара
if (count($array_double_name) or count($array_double_name)) {
?>
<div class="spoiler_links spoiler_title"><div class="title_list"><?php echo 'Дубли названий товара: ' . '<span style="color: red; font-weight: bold;">' .'&nbsp;'; if(count($array_double_name)){echo $sum_offer_name;}; if(count($array_double_model)){echo '&nbsp;'.$sum_offer_model;}; echo '&nbsp;'. '</span>'; echo 'из ' . count($all_offers).'&nbsp;';?><div class="icon_click"></div></div>
<div class="error-descriptoin">
Каждое название товара должно быть уникальным.
</div>       
</div>        
        <div class="spoiler_body">
          <button class="close-button" title="закрыть" onclick="closeAndScroll()"></button>
          <button class="copy-button" title="скопировать" onclick="onCopyHandle(event)"></button>
          <div class="line"></div>
<?php
if(count($array_double_name)){
?>
<div class="columnNameRepeat">
    <?php
 for ($num = 0; $num < count($array_double_name); $num++) {
     $num_double_name_list = $num + 1;
     echo '<div class="double-offer-id">'.'<span class="double-name">'.$num_double_name_list.')'.'</span>'.'<span class="double-offer-id-id">'.$array_double_name[$num]; if($array_double_name[$num] == ''){echo '<span class="redbold">'.'Не указано название'.'</span>';}; echo '</span>'.'(повторений: '.'<span class="double-offer-id-repeat">'.$array_repeat_double_name[$num].')'.'</span>'.'</div>';
       }
       ?>
       </div>
       <?php
}

if(count($array_double_model)){
?>
 <div class="columnNameRepeat">
<?php
 for ($num = 0; $num < count($array_double_model); $num++) {
     $num_double_model_list = $num + 1;
     echo '<div class="double-offer-id">'.'<span class="double-name">'.$num_double_model_list.')'.'</span>'.'<span class="double-offer-id-id">'.$array_double_model[$num]; if($array_double_model[$num] == ''){echo '<span class="redbold">'.'Не указано название'.'</span>';}; echo '</span>'.'(повторений: '.'<span class="double-offer-id-repeat">'.$array_repeat_double_model[$num].')'.'</span>'.'</div>';
       }
?>
</div>
<?php
}
?>
<div class="line"></div>
</div>
<?php
}

// Список, где производитель через тег vendor прописан капсом.
if ($capss > 0) {
?>
        <div class="spoiler_links spoiler_title"><div class="title_list"><?php echo 'Производитель через тег vendor прописан капсом: ' . '<span style="color: red; font-weight: bold;">' .'&nbsp;'. $capss .'&nbsp;'. '</span>' . 'из ' . count($vendor_uniqueqqq); echo '&nbsp;';?><div class="icon_click"></div></div>
<div class="error-descriptoin">
Не нужно производителя писать капсом, только если он так документально не зарегистрирован.</div>       
</div>
        <div class="spoiler_body">
          <button class="close-button" title="закрыть" onclick="closeAndScroll()"></button>
          <button class="copy-button" title="скопировать" onclick="onCopyHandle(event)"></button>
          <div class="line"></div>
          <div class="columnOf4">
<?php
    for ($caps = 0; $caps < count($array_vendor_caps); $caps++) {
        $num_vendor_caps = $caps + 1;
        echo '<div class="vendor-caps">'.'<span class="num-vendor-caps">'.$num_vendor_caps.')'.'</span>'.$array_vendor_caps[$caps].'</div>';
    }
?>
          </div>
          <div class="line"></div>
        </div>
        <?php
}

// Список offer id , где не указан stock_quantity в карточке товара.
if ($stock_quantity > 0) {
?>
        <div class="spoiler_links spoiler_title"><div class="title_list"><?php echo 'Товаров без указания количества в карточке товара: ' . '<span style="color: red; font-weight: bold;">' .'&nbsp;'. $stock_quantity .'&nbsp;'. '</span>' . 'из ' . count($all_offers); echo '&nbsp;';?><div class="icon_click"></div></div>
<div class="error-descriptoin">
Желательно указать количество товара. Количество товара прописываются через тег <cite>&lt;stock_quantity&gt;&lt;/stock_quantity&gt;</cite>. Например, в наличии 100 штук товара: <cite>&lt;stock_quantity&gt;100&lt;/stock_quantity&gt;</cite>
</div>       
</div>
        <div class="spoiler_body">
          <button class="close-button" title="закрыть" onclick="closeAndScroll()"></button>
          <button class="copy-button" title="скопировать" onclick="onCopyHandle(event)"></button>
          <div class="line"></div>
<?php
    
    $stock_quantity_spoler = 0;
    foreach ($xml->shop->offers->offer as $offer) {
        if (empty(strip_tags(trim("$offer->stock_quantity"))) and $offer->stock_quantity == '') {
            $stock_quantity_spoler++;
            echo '<span class="offer_id_color">' .'Offer id: '.'</span>'.$offer['id']; if(empty(strip_tags(trim($offer['id'])))) {echo '<span class="offer-id-not-write">'.'offer id не указан'.'</span>';}; echo '<span class="name_color">'. ' Название: ' .'</span>'.$offer->name . '&nbsp;' . '&nbsp;' . '<span class="model_color">'.$offer->model.'</span>'; if(empty(strip_tags(trim("$offer->name"))) and empty(strip_tags(trim("$offer->model")))) {echo '<span class="name-not-write">'.'название товара не указано'.'</span>';}; echo'<br>';
        }
    }
?>
          <div class="line"></div>
        </div>
        <?php
}

if ($category_offer > 0) {
?>
        <div class="spoiler_links spoiler_title"><div class="title_list"><?php echo 'Товаров без указания категории в карточке товара: ' . '<span style="color: red; font-weight: bold;">' .'&nbsp;'. $category_offer.'&nbsp;'. '</span>' . 'из ' . count($all_offers); echo '&nbsp;';?><div class="icon_click"></div></div>
<div class="error-descriptoin">
Необходимо указать категорию товара. Категория товара прописывается через тег <cite>&lt;categoryId&gt;&lt;/categoryId&gt;</cite>. Без указания категории невозможно размещение товара.
</div>       
</div>        
        <div class="spoiler_body">
          <button class="close-button" title="закрыть" onclick="closeAndScroll()"></button>
          <button class="copy-button" title="скопировать" onclick="onCopyHandle(event)"></button>
          <div class="line"></div>
<?php
    // Список offer id , где не указан categoryId в карточке товара.
    
    $category_offer2 = 0;
    foreach ($xml->shop->offers->offer as $offer) {
        if (empty(strip_tags(trim("$offer->categoryId")))) {
            $category_offer2++;
            echo '<span class="offer_id_color">' .'Offer id: '.'</span>'.$offer['id']; if(empty(strip_tags(trim($offer['id'])))) {echo '<span class="offer-id-not-write">'.'offer id не указан'.'</span>';}; echo '<span class="name_color">'. ' Название: ' .'</span>'.$offer->name . '&nbsp;' . '&nbsp;' . '<span class="model_color">'.$offer->model.'</span>'; if(empty(strip_tags(trim("$offer->name"))) and empty(strip_tags(trim("$offer->model")))) {echo '<span class="name-not-write">'.'название товара не указано'.'</span>';}; echo'<br>'; //вывод оффер ид, где нет categoryId
        }
    }
    
?>
          <div class="line"></div>
        </div>
        <?php
}

if ($several_categoryId_in_offer >= 1) {
?>
        <div class="spoiler_links spoiler_title"><div class="title_list"><?php echo 'Товаров, где несколько categoryid в одном offer: ' . '<span style="color: red; font-weight: bold;">' .'&nbsp;'. $several_categoryId_in_offer.'&nbsp;'. '</span>' . 'из ' . count($all_offers); echo '&nbsp;';?><div class="icon_click"></div></div>
<div class="error-descriptoin">
В каждой карточке товара(offer) должна быть указана только одна категория. Если товар может относится к нескольким категориям, то необходимо выбрать одну категорию и ее указать.
</div>       
</div>         
        <div class="spoiler_body">
            <button class="close-button" title="закрыть" onclick="closeAndScroll()"></button>
            <button class="copy-button" title="скопировать" onclick="onCopyHandle(event)"></button>
            <div class="line"></div>
<?php
// Выводятся товары, где eсть несколько categoryId в пределах одного offer.
$categoryidnotone2 = 0;
foreach ($xml->shop->offers->offer as $offer){
foreach ($offer->categoryId as $categoryId){
$categoryidnotone[] = "$categoryId";
if (count($categoryidnotone) > 1 ) {$categoryidnotone2++; echo '<span class="offer_id_color">' .'Offer id: '.'</span>'.$offer['id']; if(empty(strip_tags(trim($offer['id'])))) {echo '<span class="offer-id-not-write">'.'offer id не указан'.'</span>';}; echo '<span class="name_color">'. ' Название: ' .'</span>'.$offer->name . '&nbsp;' . '&nbsp;' . '<span class="model_color">'.$offer->model.'</span>'; if(empty(strip_tags(trim("$offer->name"))) and empty(strip_tags(trim("$offer->model")))) {echo '<span class="name-not-write">'.'название товара не указано'.'</span>';}; echo'<br>';};
}
$categoryidnotone = array();
}
?>
          <div class="line"></div>
        </div>
        <?php
}

?>
        <?php
if ($available_offer > 0) {
?>
        <div class="spoiler_links spoiler_title"><div class="title_list"><?php echo 'Товаров нет в наличии: ' . '<span style="color: red; font-weight: bold;">' .'&nbsp;'. $available_offer.'&nbsp;'. '</span>' . 'из ' . count($all_offers); echo '&nbsp;'; echo '. Товаров в наличии ' . (count($all_offers) - $available_offer);echo '&nbsp;'; ?><div class="icon_click"></div></div>
<div class="error-descriptoin">
Товар должен быть в наличии и иметь статус available="true". Если товара нет в наличии, то его можно убрать с xml, так как при первичном размещении, эти товары не будут выведены на сайт.
</div>       
</div> 
        <div class="spoiler_body">
            <button class="close-button" title="закрыть" onclick="closeAndScroll()"></button>
            <button class="copy-button" title="скопировать" onclick="onCopyHandle(event)"></button>
            <div class="line"></div>
<?php
    // проверка на наличие товара через available.
    
    $available_offer2 = 0;
    foreach ($xml->shop->offers->offer as $offer) {
        if (($offer['available'] == 'false' or empty($offer['available'])) or ($offer['available'] == 'true' and $offer->stock_quantity == '0' and $offer->stock_quantity !== '')) {
            $available_offer2++;
            
echo '<span class="offer_id_color">' .'Offer id: '.'</span>'.$offer['id']; if(empty(strip_tags(trim($offer['id'])))) {echo '<span class="offer-id-not-write">'.'offer id не указан'.'</span>';}; echo '<span class="name_color">'. ' Название: ' .'</span>'.$offer->name . '&nbsp;' . '&nbsp;' . '<span class="model_color">'.$offer->model.'</span>'; if(empty(strip_tags(trim("$offer->name"))) and empty(strip_tags(trim("$offer->model")))) {echo '<span class="name-not-write">'.'название товара не указано'.'</span>';}; echo'<br>';
        }
        ;
    }
    
?>
          <div class="line"></div>
        </div>
        <?php
}

?>
        <?php
if ($available_offer_rus > 0) {
?>
        <div class="spoiler_links spoiler_title"><div class="title_list"><?php echo 'Товаров, где первая буква в слове available написана в русской раскладке: ' . '<span style="color: red; font-weight: bold;">' .'&nbsp;'. $available_offer_rus.'&nbsp;'. '</span>' . 'из ' . count($all_offers); echo '&nbsp;';?><div class="icon_click"></div></div>
<div class="error-descriptoin">
Необходимо писать слово available в латинской раскладке.
</div>       
</div>         
        <div class="spoiler_body">
            <button class="close-button" title="закрыть" onclick="closeAndScroll()"></button>
            <button class="copy-button" title="скопировать" onclick="onCopyHandle(event)"></button>
            <div class="line"></div>
<?php
    // проверка на наличие в available русских букв.
    
    $available_offer_rus2 = 0;
    foreach ($xml->shop->offers->offer as $offer) {
        if ($offer['аvailable'] == 'false' or $offer['аvailable'] == 'true') {
            $available_offer_rus2++;
            echo '<span class="offer_id_color">' .'Offer id: '.'</span>'.$offer['id']; if(empty(strip_tags(trim($offer['id'])))) {echo '<span class="offer-id-not-write">'.'offer id не указан'.'</span>';}; echo '<span class="name_color">'. ' Название: ' .'</span>'.$offer->name . '&nbsp;' . '&nbsp;' . '<span class="model_color">'.$offer->model.'</span>'; if(empty(strip_tags(trim("$offer->name"))) and empty(strip_tags(trim("$offer->model")))) {echo '<span class="name-not-write">'.'название товара не указано'.'</span>';}; echo'<br>';
        }
        ;
    }
    
?>
          <div class="line"></div>
        </div>
        <?php
}

?>
        <?php
if ($name_offer > 0) {
?>	  
        <div class="spoiler_links spoiler_title"><div class="title_list"><?php echo 'Товаров без названия: ' . '<span style="color: red; font-weight: bold;">' .'&nbsp;'. $name_offer.'&nbsp;'. '</span>' . 'из ' . count($all_offers); echo '&nbsp;';?><div class="icon_click"></div></div>
<div class="error-descriptoin">
Необходимо указать название товара через тег  <cite>&lt;name&gt;&lt;/name&gt;</cite> или через тег <cite>&lt;model&gt;&lt;/model&gt;</cite>. Без названия товара невозможно размещение товара. Названия товаров должны быть по схеме Тип-Бренд(Производитель)-Модель-Размер(Объем, Количество)-Цвет-Артикул. Смотрите названия товаров, для примера, на сайте. Не нужно писать слова в названии капсом. Названия должны быть уникальными и не повторяться. Обязательно проверьте, чтоб производитель(бренд) был указан в названии.
</div>       
</div>        
        <div class="spoiler_body">
            <button class="close-button" title="закрыть" onclick="closeAndScroll()"></button>
            <button class="copy-button" title="скопировать" onclick="onCopyHandle(event)"></button>
            <div class="line"></div>
            <div class="columnOf4">
<?php
    // проверка на наличие названия товара.
    
    $name_offer_spoler = 0;
    foreach ($xml->shop->offers->offer as $offer) {
        if (empty(strip_tags(trim("$offer->name"))) and empty(strip_tags(trim("$offer->model")))) {
            $name_offer_spoler++;
            echo '<span class="offer_id_color">' .'Offer id: '.'</span>'.$offer['id']; if(empty(strip_tags(trim($offer['id'])))) {echo '<span class="offer-id-not-write">'.'offer id не указан'.'</span>';}; echo '<br>';
        }
        ;
    }
?>
          </div>
          <div class="line"></div>
        </div>
        <?php
}

?>
        <?php
if ($vendor_offer > 0) {
?>
        <div class="spoiler_links spoiler_title"><div class="title_list"><?php echo 'Товаров без производителя: ' . '<span style="color: red; font-weight: bold;">' .'&nbsp;'. $vendor_offer.'&nbsp;'. '</span>' . 'из ' . count($all_offers); echo '&nbsp;';?><div class="icon_click"></div></div>
<div class="error-descriptoin">
Необходимо указать бренд(производителя) товара через тег  <cite>&lt;vendor&gt;&lt;/vendor&gt;</cite>. В названии и через vendor производитель должен прописываться одинаково. Не нужно производителя писать капсом, только если он так документально не зарегистрирован. Не нужно писать торговая марка ТМ, ЛТД, ООО, ФОП, ТОВ. Если на нашем сайте уже присутствует производитель товара, то написание производителя в xml должно совпадать с нашим сайтом.
</div>       
</div>         
        <div class="spoiler_body">
          <button class="close-button" title="закрыть" onclick="closeAndScroll()"></button>
          <button class="copy-button" title="скопировать" onclick="onCopyHandle(event)"></button>
          <div class="line"></div>
<?php
    // проверка на наличие производителя через тег vendor.
    
    $vendor_offer_spoler = 0;
    foreach ($xml->shop->offers->offer as $offer) {
        if (empty(strip_tags(trim("$offer->vendor")))) {
            $vendor_offer_spoler++;
            echo '<span class="offer_id_color">' .'Offer id: '.'</span>'.$offer['id']; if(empty(strip_tags(trim($offer['id'])))) {echo '<span class="offer-id-not-write">'.'offer id не указан'.'</span>';}; echo '<span class="name_color">'. ' Название: ' .'</span>'.$offer->name . '&nbsp;' . '&nbsp;' . '<span class="model_color">'.$offer->model.'</span>'; if(empty(strip_tags(trim("$offer->name"))) and empty(strip_tags(trim("$offer->model")))) {echo '<span class="name-not-write">'.'название товара не указано'.'</span>';}; echo'<br>';
        }
        ;
    }
    
?>
          <div class="line"></div>
        </div>
        <?php
}

?>
        <?php
if (($num_ne_ukazan_vendor_name > 0 and empty($array_model_offer[0])) or ($num_ne_ukazan_vendor_model > 0 and empty($array_name_offer[0]))) {


if ($num_ne_ukazan_vendor_name > 0 and empty($array_model_offer[0])) {
?>
<div class="spoiler_links spoiler_title"><div class="title_list"><?php echo 'Не указан производитель в названии: ' . '<span style="color: red; font-weight: bold;">' .'&nbsp;'. $num_ne_ukazan_vendor_name.'&nbsp;'. '</span>' . 'из ' . count($all_offers); echo '&nbsp;';?><div class="icon_click"></div></div>
<?php
}
if($num_ne_ukazan_vendor_model > 0 and empty($array_name_offer[0])) {
?>
<div class="spoiler_links spoiler_title"><div class="title_list"><?php echo 'Не указан производитель в названии: ' . '<span style="color: red; font-weight: bold;">' .'&nbsp;'. $num_ne_ukazan_vendor_model.'&nbsp;'. '</span>' . 'из ' . count($all_offers); echo '&nbsp;';?><div class="icon_click"></div></div>
<?php
}
?>
<div class="error-descriptoin">
Названия товаров должны быть по схеме Тип-Бренд(Производитель)-Модель-Размер(Объем, Количество)-Цвет-Артикул. Смотрите названия товаров, для примера, на сайте. Необходимо, чтоб производитель(бренд) был указан в названии.
</div>       
</div> 
<div class="spoiler_body">
          <button class="close-button" title="закрыть" onclick="closeAndScroll()"></button>
          <button class="copy-button" title="скопировать" onclick="onCopyHandle(event)"></button>
          <div class="line"></div>
          
 <?php         

      
    // проверка на наличие написания производителя в названии через name или model; не проверяется, если есть и name и model в одной карточке товара
    
    $num_ne_ukazan_vendor_name_spoler  = 0;
    $num_ne_ukazan_vendor_model_spoler = 0;
    foreach ($xml->shop->offers->offer as $offer) {
        $array_name_offer_spoler[]      = "$offer->name";
        $array_model_offer_spoler[]     = "$offer->model";
        $array_vendor_by_offer_spoler[] = "$offer->vendor";
    }
    
    for ($count_array_name_offer_spoler = 0; $count_array_name_offer_spoler < count($array_name_offer_spoler); $count_array_name_offer_spoler++) {
        $ne_ukazan_vendor_name_spoler = strrpos(mb_strtolower($array_name_offer_spoler[$count_array_name_offer_spoler]), mb_strtolower($array_vendor_by_offer_spoler[$count_array_name_offer_spoler]));
        if ($ne_ukazan_vendor_name_spoler === false and empty($array_vendor_by_offer_spoler[$count_array_name_offer_spoler]) != true) {
            $num_ne_ukazan_vendor_name_spoler++;
            if (empty($array_model_offer_spoler[$count_array_name_offer_spoler])) {
                // Название товара с отсутствием написания производителя в названии через name
                echo '<span class="name_color">' . ' Название: ' . '</span>'. $array_name_offer_spoler[$count_array_name_offer_spoler] . '&nbsp;' . '&nbsp;' . $array_model_offer_spoler[$count_array_name_offer_spoler]; if(empty(strip_tags(trim($array_name_offer_spoler[$count_array_name_offer_spoler]))) and empty(strip_tags(trim($array_model_offer_spoler[$count_array_name_offer_spoler])))){ echo '<span class="name-not-write">'.'название товара не указано'.'</span>';}; echo '&nbsp;' . '&nbsp;' .'<span class="vendor_color">'. 'Производитель: ' .'</span>'. '<span class="vendor-name_color">' . $array_vendor_by_offer_spoler[$count_array_name_offer_spoler] . '</span>' .'<br>';
            }
        }
    }
    
    for ($count_array_model_offer_spoler = 0; $count_array_model_offer_spoler < count($array_model_offer_spoler); $count_array_model_offer_spoler++) {
        $ne_ukazan_vendor_model_spoler = strrpos(mb_strtolower($array_model_offer_spoler[$count_array_model_offer_spoler]), mb_strtolower($array_vendor_by_offer_spoler[$count_array_model_offer_spoler]));
        if ($ne_ukazan_vendor_model_spoler === false and empty($array_vendor_by_offer_spoler[$count_array_model_offer_spoler]) != true) {
            $num_ne_ukazan_vendor_model_spoler++;
            if (empty($array_name_offer_spoler[$count_array_model_offer_spoler])) {
                // Название товара с отсутствием написания производителя в названии через model
                echo '<span class="name_color">' . ' Название: ' . $array_name_offer_spoler[$count_array_model_offer_spoler] . '&nbsp;' . '&nbsp;' . $array_model_offer_spoler[$count_array_model_offer_spoler]; if(empty(strip_tags(trim($array_name_offer_spoler[$count_array_name_offer_spoler]))) and empty(strip_tags(trim($array_model_offer_spoler[$count_array_name_offer_spoler])))){ echo '<span class="name-not-write">'.'название товара не указано'.'</span>';}; echo '&nbsp;' . '&nbsp;' .'<span class="vendor_color">'. 'Производитель: ' .'</span>'. '<span class="vendor-name_color">' . $array_vendor_by_offer_spoler[$count_array_model_offer_spoler] . '</span>' .'<br>';
            }
        }
    }
    
?>
          <div class="line"></div>
        </div>
        <?php
}

?>
        <?php
if ($param_null_value > 0) {
?>
        <div class="spoiler_links spoiler_title"><div class="title_list"><?php echo 'Параметров с пустым значением: ' . '<span style="color: red; font-weight: bold;">' .'&nbsp;'. $param_null_value.'&nbsp;'. '</span>' . 'из ' . count($count_param); echo '&nbsp;';?><div class="icon_click"></div></div>
<div class="error-descriptoin">
Необходимо заполнить значением все параметры или пустые параметры удалить с xml.
</div>       
</div> 
        <div class="spoiler_body">
          <button class="close-button" title="закрыть" onclick="closeAndScroll()"></button>
          <button class="copy-button" title="скопировать" onclick="onCopyHandle(event)"></button>
          <div class="line"></div>
<?php
    // проверка на наличие параметров с пустым значением.
    
    $param_null_value_spoler = 0;
    foreach ($xml->shop->offers->offer as $offer) {
        foreach ($offer->param as $param) {
            $count_param_spoler[] = "$param";
            if (empty(strip_tags(trim("$param")))) {
                $param_null_value_spoler++;
                echo '<span class="offer_id_color">' .'Offer id: '.'</span>'.$offer['id']; if(empty(strip_tags(trim($offer['id'])))) {echo '<span class="offer-id-not-write">'.'offer id не указан'.'</span>';}; echo '<span class="name_color">'. ' Название: ' .'</span>'.$offer->name . '&nbsp;' . '&nbsp;' . '<span class="model_color">'.$offer->model.'</span>'; if(empty(strip_tags(trim("$offer->name"))) and empty(strip_tags(trim("$offer->model")))) {echo '<span class="name-not-write">'.'название товара не указано'.'</span>';}; echo '&nbsp;' . '&nbsp;' .'<span class="param_color">'. 'Параметр: ' .'</span>'. '&nbsp;' . "$param[name]"  . '<br>';
            }
            ;
        }
    }
    
?>
          <div class="line"></div>
        </div>
        <?php
}


?>
<?php
if ($param_name > 0) {
?>
        <div class="spoiler_links spoiler_title"><div class="title_list"><?php echo 'Товаров без параметров: ' . '<span style="color: red; font-weight: bold;">' .'&nbsp;'. $param_name.'&nbsp;'. '</span>' . 'из ' . count($all_offers); echo '&nbsp;';?><div class="icon_click"></div></div>
<div class="error-descriptoin">
      Без указания параметров(param name) не возможно размещение товара. Перечень параметров смотрите в карточках товара, который уже продается (вкладка Характеристики) и слева в фильтрах категории, где будет размещаться товар. Обязательный параметр Тип(одним словом объясняет что это за товар). Параметры, которых нет у нас на сайте, необходимо вынести в описание. Почему так важны параметры в товаре? Покупатель видит в категории несколько сотен, а иногда и несколько тысяч позиций товара. Покупатель начинает отмечать фильтры в категории, чтобы оставить только те товары, которые его интересуют. Если не прописать параметры, то Ваш товар не попадет в отфильтрованные покупателем товары и они останутся в общей массе товаров. Клиент Ваш товар не увидит и не купит. Мы же хотим, чтоб Вы продавали. Важно, как минимум, прописать все параметры, которые являются фильтрами в категории, в которой будет размещаться товар на сайте.
</div>       
</div>
        

        
        
        <div class="spoiler_body">
          <button class="close-button" title="закрыть" onclick="closeAndScroll()"></button>
          <button class="copy-button" title="скопировать" onclick="onCopyHandle(event)"></button>
          <div class="line"></div>
<?php
    // проверка на наличие параметров товара.
    
    $param_name_spoler = 0;
    foreach ($xml->shop->offers->offer as $offer) {
        if (empty(strip_tags(trim($offer->param['name'])))) {
            $param_name_spoler++;
            echo '<span class="offer_id_color">' .'Offer id: '.'</span>'.$offer['id']; if(empty(strip_tags(trim($offer['id'])))) {echo '<span class="offer-id-not-write">'.'offer id не указан'.'</span>';}; echo '<span class="name_color">'. ' Название: ' .'</span>'.$offer->name . '&nbsp;' . '&nbsp;' . '<span class="model_color">'.$offer->model.'</span>'; if(empty(strip_tags(trim("$offer->name"))) and empty(strip_tags(trim("$offer->model")))) {echo '<span class="name-not-write">'.'название товара не указано'.'</span>';}; echo'<br>';
        }
        ;
        
    }
    
?>
          <div class="line"></div>
        </div>
        <?php
}

?>
        <?php
if ($double_param_name > 0) {
?>
        <div class="spoiler_links spoiler_title"><div class="title_list"><?php echo 'Товаров с дублями названий параметров: ' . '<span style="color: red; font-weight: bold;">' .'&nbsp;'. $double_param_name.'&nbsp;'. '</span>' . 'из ' . count($all_offers); echo '&nbsp;';?><div class="icon_click"></div></div>
<div class="error-descriptoin">
Не нужно дублировать названия параметров. Необходимо указать одно название параметра, а его значения прописать через запятую. 
</div>       
</div>         
        <div class="spoiler_body">
          <button class="close-button" title="закрыть" onclick="closeAndScroll()"></button>
          <button class="copy-button" title="скопировать" onclick="onCopyHandle(event)"></button>
          <div class="line"></div>
<?php
    // проверка на наличие дублей названий параметров товара.
    
    $double_param_name_spoler = 0;
    foreach ($xml->shop->offers->offer as $offer) {
        foreach ($offer->param as $param) {
            $double_spoler[] = $param['name'];
        }
        ;
        if (count($double_spoler) > 0) {
            $unique_double_spoler       = array_unique($double_spoler);
            $result_double_param_spoler = array_diff_assoc($double_spoler, $unique_double_spoler);
        }
        ;
        for ($i = 1; $i <= count($double_spoler); $i++) {
            if (empty($result_double_param_spoler[$i]) == false) {
                echo '<span style="color: #5D8FE0; font-weight: bold;">' . $result_double_param_spoler[$i] . '</span>' .'<br>';
            }
            
        }
        
        if (count($double_spoler) !== count($unique_double_spoler) and count($double_spoler) > 0) {
            ;
            $double_param_name_spoler++;
            echo '<span class="offer_id_color">' .'Offer id: '.'</span>'.$offer['id']; if(empty(strip_tags(trim($offer['id'])))) {echo '<span class="offer-id-not-write">'.'offer id не указан'.'</span>';}; echo '<span class="name_color">'. ' Название: ' .'</span>'.$offer->name . '&nbsp;' . '&nbsp;' . '<span class="model_color">'.$offer->model.'</span>'; if(empty(strip_tags(trim("$offer->name"))) and empty(strip_tags(trim("$offer->model")))) {echo '<span class="name-not-write">'.'название товара не указано'.'</span>';}; echo'<br>';
?>
          <div class="color-hr"></div>
          <?php
        }
        
        $double_spoler = array();
    }
    
?>
          <div class="line"></div>
        </div>
        <?php
}

?>
        <?php
if ($http_param > 0) {
?>
        <div class="spoiler_links spoiler_title"><div class="title_list"><?php echo 'Ссылок в параметрах: ' . '<span style="color: red; font-weight: bold;">' .'&nbsp;'. $http_param.'&nbsp;'. '</span>' . 'из ' . count($count_param) * 2; echo '&nbsp;';?><div class="icon_click"></div></div>
<div class="error-descriptoin">
Необходимо удалить ссылки в параметрах.
</div>       
</div>        
        <div class="spoiler_body">
          <button class="close-button" title="закрыть" onclick="closeAndScroll()"></button>
          <button class="copy-button" title="скопировать" onclick="onCopyHandle(event)"></button>
          <div class="line"></div>
<?php
    // проверка на наличие наличие ссылок http и https и т.д. в  параметрах товара.
    
    $http_param2 = 0;
    foreach ($xml->shop->offers->offer as $offer) {
        foreach ($offer->param as $param) {
            

            
            if (strrpos($param, 'https') !== false or strrpos("$param", 'http:') !== false or strrpos("$param", '.com') !== false or strrpos("$param", '.gif') !== false or strrpos("$param", 'www') !== false or strrpos("$param", '.ua') !== false or strrpos("$param", '.net') !== false or strrpos("$param", '.png') !== false or strrpos("$param", '.jpg') !== false or strrpos("$param[name]", 'https') !== false or strrpos("$param[name]", 'http:') !== false or strrpos("$param[name]", '.gif') !== false or strrpos("$param[name]", 'www') !== false or strrpos("$param[name]", '.ua') !== false or strrpos("$param[name]", '.net') !== false or strrpos("$param[name]", '.png') !== false or strrpos("$param[name]", '.com') !== false or strrpos("$param[name]", '.jpg') !== false) {
                
                
                $http_param2++;
                echo  '<span class="offer_id_color">'. $offer['id'].'</span>'.$offer['id']; if(empty(strip_tags(trim($offer['id'])))) {echo '<span class="offer-id-not-write">'.'offer id не указан'.'</span>';}; echo '&nbsp;' . '&nbsp;'. '<span class="name_color">'. ' Название: ' .'</span>'.$offer->name . '&nbsp;' . '&nbsp;' . '<span class="model_color">'.$offer->model.'</span>'; if(empty(strip_tags(trim("$offer->name"))) and empty(strip_tags(trim("$offer->model")))) {echo '<span class="name-not-write">'.'название товара не указано'.'</span>';}; echo '</span>' . '&nbsp;' . '&nbsp;' .'<span class="param-name_color" >'. $param['name'] . ' ::: ' . $param . '</span>'. '<br>';
            }
        }
    }
    
?>
          <div class="line"></div>
        </div>
        <?php
}

?>
        <?php
if ($picture_offer > 0) {
?>
        <div class="spoiler_links spoiler_title"><div class="title_list"><?php echo 'Товаров без фото: ' . '<span style="color: red; font-weight: bold;">' .'&nbsp;'. $picture_offer.'&nbsp;'. '</span>' . 'из ' . count($all_offers); echo '&nbsp;';?><div class="icon_click"></div></div>
<div class="error-descriptoin">
Необходимо указать ссылки на фото товара через тег <cite>&lt;picture&gt;&lt;/picture&gt;</cite>. Фотографии должны быть в большом разрешении и без водяных знаков, надписей, ссылок. На фотографии должен присутствовать товар в единичном экземпляре. Не должно быть сборных фотографий, где представлен, например, товар во всех цветах. Ссылки не должны быть битыми, все фотографии должны загружаться. Первая фотография в выгрузке xml будет основной в карточке товара. Первой фотографией нужно выгружать самое лучшее фото, чтобы был хорошо виден сам товар и его основные качества.
</div>       
</div> 
        <div class="spoiler_body">
          <button class="close-button" title="закрыть" onclick="closeAndScroll()"></button>
          <button class="copy-button" title="скопировать" onclick="onCopyHandle(event)"></button>
          <div class="line"></div>
<?php
    // проверка на наличие фото товара.
    
    $picture_offer_spoler = 0;
    foreach ($xml->shop->offers->offer as $offer) {
        if (empty(strip_tags(trim("$offer->picture")))) {
            $picture_offer_spoler++;
            echo '<span class="offer_id_color">' .'Offer id: '.'</span>'.$offer['id']; if(empty(strip_tags(trim($offer['id'])))) {echo '<span class="offer-id-not-write">'.'offer id не указан'.'</span>';}; echo '<span class="name_color">'. ' Название: ' .'</span>'.$offer->name . '&nbsp;' . '&nbsp;' . '<span class="model_color">'.$offer->model.'</span>'; if(empty(strip_tags(trim("$offer->name"))) and empty(strip_tags(trim("$offer->model")))) {echo '<span class="name-not-write">'.'название товара не указано'.'</span>';}; echo'<br>';
        }
        ;
    }
    
?>
          <div class="line"></div>
        </div>
        <?php
}
?>


        <?php
if ($picture_null_value > 0) {
?>
        <div class="spoiler_links spoiler_title"><div class="title_list"><?php echo 'Фото с пустым значением: ' . '<span style="color: red; font-weight: bold;">' .'&nbsp;'. $picture_null_value.'&nbsp;'. '</span>' . 'из ' . count($count_picture); echo '&nbsp;';?><div class="icon_click"></div></div>
<div class="error-descriptoin">
Необходимо указать корректную ссылку на фото или удалить фото с пустым значением.
</div>       
</div>         
        <div class="spoiler_body">
          <button class="close-button" title="закрыть" onclick="closeAndScroll()"></button>
          <button class="copy-button" title="скопировать" onclick="onCopyHandle(event)"></button>
          <div class="line"></div>
<?php
    // проверка на наличие фото с пустым значением.
    
    $param_null_value_spoler = 0;
    foreach ($xml->shop->offers->offer as $offer) {
        foreach ($offer->picture as $picture) {
            $count_picture_spoler[] = "$picture";
            if (empty(strip_tags(trim("$picture")))) {
                $picture_null_value_spoler++;
                echo '<span class="offer_id_color">' .'Offer id: '.'</span>'.$offer['id']; if(empty(strip_tags(trim($offer['id'])))) {echo '<span class="offer-id-not-write">'.'offer id не указан'.'</span>';}; echo '<span class="name_color">'. ' Название: ' .'</span>'.$offer->name . '&nbsp;' . '&nbsp;' . '<span class="model_color">'.$offer->model.'</span>'; if(empty(strip_tags(trim("$offer->name"))) and empty(strip_tags(trim("$offer->model")))) {echo '<span class="name-not-write">'.'название товара не указано'.'</span>';}; echo'<br>';
            }
        }
    }
    
?>
          <div class="line"></div>
        </div>
        <?php
}
?>

        <?php
if ($picture_filename_extension > 0) {
?>
        <div class="spoiler_links spoiler_title"><div class="title_list"><?php echo 'Фото с неверным расширением файла: ' . '<span style="color: red; font-weight: bold;">' .'&nbsp;'. $picture_filename_extension.'&nbsp;'. '</span>' . 'из ' . count($count_picture); echo '&nbsp;';?><div class="icon_click"></div></div>
<div class="error-descriptoin">
Необходимо проверить расширение фото. Популярные расширения png и jpg. 
</div>       
</div>       
        <div class="spoiler_body">
          <button class="close-button" title="закрыть" onclick="closeAndScroll()"></button>
          <button class="copy-button" title="скопировать" onclick="onCopyHandle(event)"></button>
          <div class="line"></div>
<?php
    // проверка на невернoe расширением файла фото.
    
    $picture_filename_extension_spoler = 0;
    foreach ($xml->shop->offers->offer as $offer) {
        foreach ($offer->picture as $picture) {
            $count_picture_spoler[] = "$picture";
  if (empty(strip_tags(trim("$picture"))) === false and strrpos(strtolower($picture), '.jpg') == false and strrpos(strtolower($picture), '.jpeg') == false and strrpos(strtolower($picture), '.png') == false and strrpos(strtolower($picture), '.gif') == false and strrpos(strtolower($picture), '.bmp') == false and strrpos(strtolower($picture), '.svg') == false and strrpos(strtolower($picture), '.tif') == false and strrpos(strtolower($picture), '.webp') == false) {
            $picture_filename_extension_spoler++;
                echo '<span class="offer_id_color">' .'Offer id: '.'</span>'.$offer['id']; if(empty(strip_tags(trim($offer['id'])))) {echo '<span class="offer-id-not-write">'.'offer id не указан'.'</span>';}; echo '<span class="name_color">'. ' Название: ' .'</span>'.$offer->name . '&nbsp;' . '&nbsp;' . '<span class="model_color">'.$offer->model.'</span>';
                echo "<a  href='$picture' target='_blank' rel='noopener noreferrer'>$picture</a>". '<br>';
            }
            
        }
    }
    
?>
          <div class="line"></div>
        </div>
        <?php
}
?>

<?php
if ($url_offer > 0) {
?>
        <div class="spoiler_links spoiler_title"><div class="title_list"><?php echo 'Товаров без ссылки на товар: ' . '<span style="color: red; font-weight: bold;">' .'&nbsp;'. $url_offer.'&nbsp;'. '</span>' . 'из ' . count($all_offers); echo '&nbsp;';?><div class="icon_click"></div></div>
<div class="error-descriptoin">
По возможности необходимо указать ссылку на товар на Вашем сайте через тег <cite>&lt;url&gt;&lt;/url&gt;</cite>. Если нет возможности указать ссылку на товар, то можно указать адрес Вашего сайта.
</div>       
</div>
        <div class="spoiler_body">
          <button class="close-button" title="закрыть" onclick="closeAndScroll()"></button>
          <button class="copy-button" title="скопировать" onclick="onCopyHandle(event)"></button>
          <div class="line"></div>
<?php
    // проверка на наличие ссылки на товар.
    
    $url_offer_spoler = 0;
    foreach ($xml->shop->offers->offer as $offer) {
        if (empty(strip_tags(trim("$offer->url")))) {
            $url_offer_spoler++;
            echo '<span class="offer_id_color">' .'Offer id: '.'</span>'.$offer['id']; if(empty(strip_tags(trim($offer['id'])))) {echo '<span class="offer-id-not-write">'.'offer id не указан'.'</span>';}; echo '<span class="name_color">'. ' Название: ' .'</span>'.$offer->name . '&nbsp;' . '&nbsp;' . '<span class="model_color">'.$offer->model.'</span>'; if(empty(strip_tags(trim("$offer->name"))) and empty(strip_tags(trim("$offer->model")))) {echo '<span class="name-not-write">'.'название товара не указано'.'</span>';}; echo'<br>';
        }
        
    }
    
?>
          <div class="line"></div>
        </div>
        <?php
}

?>
        <?php
if ($description_offer > 0) {
?>
        <div class="spoiler_links spoiler_title"><div class="title_list"><?php echo 'Товаров без описания: ' . '<span style="color: red; font-weight: bold;">' .'&nbsp;'. $description_offer.'&nbsp;'. '</span>' . 'из ' . count($all_offers); echo '&nbsp;';?><div class="icon_click"></div></div>
<div class="error-descriptoin">
Наличие описания товара положительно сказывается на зантересованности покупателей товаром. Описание товара прописывается через тег <cite>&lt;description&gt;&lt;/description&gt;</cite>. В описании должна быть информация только про сам товар. Не должно быть ссылок, телефонов, адресов, предложений услуг, акций, цен, картинок, видео, информации про другие варианты товара и т.д. Описание желательно прописать через html теги, чтоб было с форматированием(разбивкой на абзацы), а не сплошным текстом. Html теги завернуть в CDATA. Раздел CDATA открывается как <cite>&lt;![CDATA[</cite> и закрывается <cite>]]&gt;</cite>
</div>       
</div>        
        <div class="spoiler_body">
          <button class="close-button" title="закрыть" onclick="closeAndScroll()"></button>
          <button class="copy-button" title="скопировать" onclick="onCopyHandle(event)"></button>
          <div class="line"></div>
<?php
    // проверка на наличие описание товара.
    
    $description_offer_spoler = 0;
    foreach ($xml->shop->offers->offer as $offer) {
        if (empty(strip_tags(trim("$offer->description")))) {
            $description_offer_spoler++;
            echo '<span class="offer_id_color">' .'Offer id: '.'</span>'.$offer['id']; if(empty(strip_tags(trim($offer['id'])))) {echo '<span class="offer-id-not-write">'.'offer id не указан'.'</span>';}; echo '<span class="name_color">'. ' Название: ' .'</span>'.$offer->name . '&nbsp;' . '&nbsp;' . '<span class="model_color">'.$offer->model.'</span>'; if(empty(strip_tags(trim("$offer->name"))) and empty(strip_tags(trim("$offer->model")))) {echo '<span class="name-not-write">'.'название товара не указано'.'</span>';}; echo'<br>';
        }
        
    }
    
?>
          <div class="line"></div>
        </div>
        <?php
}

?>
        <?php
if ($http_description > 0) {
?>
        <div class="spoiler_links spoiler_title" id="description_link_list_up"><div class="title_list"><?php echo 'Товаров со ссылками в описании: ' . '<span style="color: red; font-weight: bold;">' .'&nbsp;'. $http_description.'&nbsp;'. '</span>' . 'из ' . count($all_offers); echo '&nbsp;';?><div class="icon_click"></div></div>
<div class="error-descriptoin">
Необходимо удалить ссылки с описания.
</div>       
</div>       
        <div class="spoiler_body">
          <button class="close-button" title="закрыть" onclick="closeAndScroll()"></button>
          <div class="line"></div>
<?php
    // проверка на наличие ссылок http и https в описании товара.
    
    $http_description_spoler      = 0;
    $http_description_spoler_more = 0;
    foreach ($xml->shop->offers->offer as $offer) {
        if (strrpos("$offer->description", 'https') !== false or strrpos("$offer->description", 'http:') !== false or strrpos("$offer->description", '.gif') !== false or strrpos("$offer->description", '.com') !== false or strrpos("$offer->description", 'www') !== false or strrpos("$offer->description", '.ua') !== false or strrpos("$offer->description", '.net') !== false or strrpos("$offer->description", '.png') !== false or strrpos("$offer->description", '.jpg') !== false) {
            $http_description_spoler++;
            echo '<span class="offer_id_color">' .'Offer id: '.'</span>'.$offer['id']; if(empty(strip_tags(trim($offer['id'])))) {echo '<span class="offer-id-not-write">'.'offer id не указан'.'</span>';}; echo '<span class="name_color">'. ' Название: ' .'</span>'.$offer->name . '&nbsp;' . '&nbsp;' . '<span class="model_color">'.$offer->model.'</span>'; if(empty(strip_tags(trim("$offer->name"))) and empty(strip_tags(trim("$offer->model")))) {echo '<span class="name-not-write">'.'название товара не указано'.'</span>';}; echo'<br>';
        }
        
    }
// если товаров с ссылками больше 100 то выводить полностью описание товаров, где есть в описании ссылки
if ($http_description > 0 and $http_description_spoler < 100 ) {
?>
<br>
          <hr>
          <p style="color: red; font-weight: 700;"> Подробнее с выводом описания. Повторный расширенный список товаров, в которых в описании есть ссылки:</p>
          <br>
          <?php
  foreach ($xml->shop->offers->offer as $offer) {
        if (strrpos("$offer->description", 'https') !== false or strrpos("$offer->description", 'http:') !== false or strrpos("$offer->description", '.gif') !== false or strrpos("$offer->description", '.com') !== false or strrpos("$offer->description", 'www') !== false or strrpos("$offer->description", '.ua') !== false or strrpos("$offer->description", '.net') !== false or strrpos("$offer->description", '.png') !== false or strrpos("$offer->description", '.jpg') !== false) {
?>
          <div class="discriptionLinksStopWord">
            <?php
            $http_description_spoler_more++;
            echo '<span class="offer_id_color">' .'Offer id: '.'</span>'.$offer['id']; if(empty(strip_tags(trim($offer['id'])))) {echo '<span class="offer-id-not-write">'.'offer id не указан'.'</span>';}; echo '<span class="name_color">'. ' Название: ' .'</span>'.$offer->name . '&nbsp;' . '&nbsp;' . '<span class="model_color">'.$offer->model.'</span>'; if(empty(strip_tags(trim("$offer->name"))) and empty(strip_tags(trim("$offer->model")))) {echo '<span class="name-not-write">'.'название товара не указано'.'</span>';}; echo'<br>';
            echo $offer->description;
?>
          </div><p>---------------------------------------------</p>
          <div class="spoiler_links blue" style="text-align:left;">Открыть описание с тегами html с выделением ссылки</div>
            <div class="spoiler_body">
                <!--вывод с тегами html-->
<?php
            $offer->description = str_replace("<", '&lt;', $offer->description);
            $offer->description = str_replace(">", '&gt;', $offer->description);
            $offer->description = str_replace("https", '<span style="color: red; font-weight: bold;">' . 'HTTPS' . '</span>', $offer->description);
            $offer->description = str_replace("http", '<span style="color: red; font-weight: bold;">' . 'HTTP' . '</span>', $offer->description);
            $offer->description = str_replace(".gif", '<span style="color: red; font-weight: bold;">' . ".GIF" . '</span>', $offer->description);
            $offer->description = str_replace(".com", '<span style="color: red; font-weight: bold;">' . ".COM" . '</span>', $offer->description);
            $offer->description = str_replace("www", '<span style="color: red; font-weight: bold;">' . "WWW" . '</span>', $offer->description);
            $offer->description = str_replace(".ua", '<span style="color: red; font-weight: bold;">' . ".UA" . '</span>', $offer->description);
            $offer->description = str_replace(".net", '<span style="color: red; font-weight: bold;">' . ".NET" . '</span>', $offer->description);
            $offer->description = str_replace(".png", '<span style="color: red; font-weight: bold;">' . ".PNG" . '</span>', $offer->description);
            $offer->description = str_replace(".jpg", '<span style="color: red; font-weight: bold;">' . ".JPG" . '</span>', $offer->description);
?>
              <div style="max-width: 800px; overflow-wrap: break-word;">
<?php
echo $offer->description;
?>
              </div>
              <?php
            $offer->description = str_replace("&lt;", '<', $offer->description);
            $offer->description = str_replace("&gt;", '>', $offer->description);
            $offer->description = str_replace('<span style="color: red; font-weight: bold;">' . 'HTTPS' . '</span>', "https", $offer->description);
            $offer->description = str_replace('<span style="color: red; font-weight: bold;">' . 'HTTP' . '</span>', "http", $offer->description);
            $offer->description = str_replace('<span style="color: red; font-weight: bold;">' . ".GIF" . '</span>', ".gif", $offer->description);
            $offer->description = str_replace('<span style="color: red; font-weight: bold;">' . ".COM" . '</span>', ".com", $offer->description);
            $offer->description = str_replace('<span style="color: red; font-weight: bold;">' . "WWW" . '</span>', "www", $offer->description);
            $offer->description = str_replace('<span style="color: red; font-weight: bold;">' . ".UA" . '</span>', ".ua", $offer->description);
            $offer->description = str_replace('<span style="color: red; font-weight: bold;">' . ".NET" . '</span>', ".net", $offer->description);
            $offer->description = str_replace('<span style="color: red; font-weight: bold;">' . ".PNG" . '</span>', ".png", $offer->description);
            $offer->description = str_replace('<span style="color: red; font-weight: bold;">' . ".JPG" . '</span>', ".jpg", $offer->description);
?>
            </div>

            <p class="alarm-text-name link-alarm" style="color: red; font-weight: bold;">В описании есть ссылки</p>
            <span class="descr-reg" style=" min-width: 800px;">																							
 <?php
    
            
        $regex = '/\b(https?|ftp|file):\/\/[-A-Za-z0-9+&@#\/%?=~_|$!:,.;]*[A-Za-z0-9+&@#\/%=~_|$]|[-A-Za-z0-9+&@#\/%?=~_|$!:,.;]+\.com[-A-Za-z0-9+&@#\/%?=~_|$!:,.;]+|[-A-Za-z0-9+&@#\/%?=~_|$!:,.;]+\.com|[-A-Za-z0-9+&@#\/%?=~_|$!:,.;]+\.net[-A-Za-z0-9+&@#\/%?=~_|$!:,.;]+|[-A-Za-z0-9+&@#\/%?=~_|$!:,.;]+\.net|[-A-Za-z0-9+&@#\/%?=~_|$!:,.;]+\.jpg|[-A-Za-z0-9+&@#\/%?=~_|$!:,.;]+\.png|[-A-Za-z0-9+&@#\/%?=~_|$!:,.;]+\.gif/i'; 
            preg_match_all($regex, $offer->description, $matches);
            $urls = $matches[0];
            // go over all links
            
            foreach ($urls as $urlss) {
                echo ("<a  href='$urlss' target='_blank' rel='noopener noreferrer'>$urlss</a>")  .'<br>'.'<br>';
            }
?>
            </span>

          <?php
            echo '<hr>';
    }
    }
    echo 'Товаров с ссылками в описании ' . '<span style="color: red; font-weight: bold;">' . $http_description_spoler . '</span>' . ' из ' . count($all_offers);
}
    echo '<br>';

    echo '<br>' . '<a href="#description_link_list_up" title="Вернуться к началу" class="hide-button scrollto">Вернуться к началу спойлера</a>' . '<br>' . '<br>';
?>
</div>
<?php
}
?>


<?php
if ($offer_id > 0) {
?>
        <div class="spoiler_links spoiler_title"><div class="title_list"><?php echo 'Товаров без offer id: ' . '<span style="color: red; font-weight: bold;">' .'&nbsp;'. $offer_id.'&nbsp;'. '</span>' . 'из ' . count($all_offers); echo '&nbsp;';?><div class="icon_click"></div></div>
<div class="error-descriptoin">
Без указания offer id невозможно размещение товара. Номера offer id должны быть уникальными.
</div>       
</div>        
        <div class="spoiler_body">
          <button class="close-button" title="закрыть" onclick="closeAndScroll()"></button>
          <button class="copy-button" title="скопировать" onclick="onCopyHandle(event)"></button>
          <div class="line"></div>
<?php
    // проверка на наличие offer id в карточке товара.
    
    $offer_id_spoler = 0;
    foreach ($xml->shop->offers->offer as $offer) {
        if (empty($offer['id'])) {
            $offer_id_spoler++;
            echo '<span class="name_color">'. ' Название: ' .'</span>'.$offer->name . '&nbsp;' . '&nbsp;' . '<span class="model_color">'.$offer->model.'</span>'; if(empty(strip_tags(trim("$offer->name"))) and empty(strip_tags(trim("$offer->model")))) {echo '<span class="name-not-write">'.'название товара не указано'.'</span>';}; echo'<br>';
          }
    }
    
?>
          <div class="line"></div>
        </div>
        <?php
}

?>
        <?php
if ($price_offer > 0) {
?>
        <div class="spoiler_links spoiler_title"><div class="title_list"><?php echo 'Товаров без цены: ' . '<span style="color: red; font-weight: bold;">' .'&nbsp;'. $price_offer.'&nbsp;'. '</span>' . 'из ' . count($all_offers); echo '&nbsp;';?><div class="icon_click"></div></div>
<div class="error-descriptoin">
Необходимо указать цену товара через тег <cite>&lt;price&gt;&lt;/price&gt;</cite>. Перечеркнутая цена указывается через тег <cite>&lt;old_price&gt;&lt;/old_price&gt;</cite>
</div>       
</div>         
        <div class="spoiler_body">
          <button class="close-button" title="закрыть" onclick="closeAndScroll()"></button>
          <button class="copy-button" title="скопировать" onclick="onCopyHandle(event)"></button>
          <div class="line"></div>
<?php
    // проверка на наличие цены в товарах.
    
    $price_offer_spoler = 0;
    foreach ($xml->shop->offers->offer as $offer) {
        if (empty(strip_tags(trim("$offer->price"))) or $offer->price <= 0) {
            $price_offer_spoler++;
            echo '<span class="offer_id_color">' .'Offer id: '.'</span>'.$offer['id']; if(empty(strip_tags(trim($offer['id'])))) {echo '<span class="offer-id-not-write">'.'offer id не указан'.'</span>';}; echo '<span class="name_color">'. ' Название: ' .'</span>'.$offer->name . '&nbsp;' . '&nbsp;' . '<span class="model_color">'.$offer->model.'</span>'; if(empty(strip_tags(trim("$offer->name"))) and empty(strip_tags(trim("$offer->model")))) {echo '<span class="name-not-write">'.'название товара не указано'.'</span>';}; echo'<br>';
        }
        
    }
    
?>
          <div class="line"></div>
        </div>
        <?php
}

?>
        <?php
if ($currencyId > 0) {
?>
        <div class="spoiler_links spoiler_title"><div class="title_list"><?php echo 'Товаров без валюты: ' . '<span style="color: red; font-weight: bold;">' .'&nbsp;'. $currencyId.'&nbsp;'. '</span>' . 'из ' . count($all_offers); echo '&nbsp;';?><div class="icon_click"></div></div>
<div class="error-descriptoin">
Необходимо указать цену товара через тег <cite>&lt;currencyId&gt;&lt;/currencyId&gt;</cite>
</div>       
</div>         
        <div class="spoiler_body">
          <button class="close-button" title="закрыть" onclick="closeAndScroll()"></button>
          <button class="copy-button" title="скопировать" onclick="onCopyHandle(event)"></button>
          <div class="line"></div>
<?php
    // проверка на наличие валюты в товарах.
    
    $currencyId_spoler = 0;
    foreach ($xml->shop->offers->offer as $offer) {
        if (empty(strip_tags(trim("$offer->currencyId")))) {
            $currencyId_spoler++;
            echo '<span class="offer_id_color">' .'Offer id: '.'</span>'.$offer['id']; if(empty(strip_tags(trim($offer['id'])))) {echo '<span class="offer-id-not-write">'.'offer id не указан'.'</span>';}; echo '<span class="name_color">'. ' Название: ' .'</span>'.$offer->name . '&nbsp;' . '&nbsp;' . '<span class="model_color">'.$offer->model.'</span>'; if(empty(strip_tags(trim("$offer->name"))) and empty(strip_tags(trim("$offer->model")))) {echo '<span class="name-not-write">'.'название товара не указано'.'</span>';}; echo'<br>';
        }
        
    }
    
    
?>

          <div class="line"></div>
        </div>
        <?php
}

?>
        <?php
if ($price_ten > 0) {
?>
        <div class="spoiler_links spoiler_title"><div class="title_list"><?php echo 'Товаров дешевле 10грн: ' . '<span style="color: red; font-weight: bold;">' .'&nbsp;'. $price_ten.'&nbsp;'. '</span>' . 'из ' . count($all_offers); echo '&nbsp;';?><div class="icon_click"></div></div>
<div class="error-descriptoin">
Необходимо сверить корректность цен в xml. 
</div>       
</div>         
        <div class="spoiler_body">
          <button class="close-button" title="закрыть" onclick="closeAndScroll()"></button>
          <button class="copy-button" title="скопировать" onclick="onCopyHandle(event)"></button>
          <div class="line"></div>
<?php
    // проверка на наличие товаров дешевле 10грн.
    
    $price_ten_spoler = 0;
    foreach ($xml->shop->offers->offer as $offer) {
        if ($offer->price < 10 and empty(strip_tags(trim("$offer->price"))) != true and $offer->price > 0 and $offer->currencyId == 'UAH') {
            $price_ten_spoler++;
            echo '<span class="offer_id_color">' .'Offer id: '.'</span>'.$offer['id']; if(empty(strip_tags(trim($offer['id'])))) {echo '<span class="offer-id-not-write">'.'offer id не указан'.'</span>';}; echo '<span class="name_color">'. ' Название: ' .'</span>'.$offer->name . '&nbsp;' . '&nbsp;' . '<span class="model_color">'.$offer->model.'</span>'; if(empty(strip_tags(trim("$offer->name"))) and empty(strip_tags(trim("$offer->model")))) {echo '<span class="name-not-write">'.'название товара не указано'.'</span>';}; echo '&nbsp;' . '&nbsp;' . '<span class="price_color">'.'Цена: ' .'</span>'. $offer->price . ' грн.'. '<br>';
        }
        
    }
    
?>
          <div class="line"></div>
        </div>
        <?php
}

?>
        <?php
if ($num_naiden_probel_categoryId > 0) {
?>
        <div class="spoiler_links spoiler_title"><div class="title_list"><?php echo 'Товаров с пробелом в categoryId: ' . '<span style="color: red; font-weight: bold;">' .'&nbsp;'. $num_naiden_probel_categoryId.'&nbsp;'. '</span>' . 'из ' . count($all_offers); echo '&nbsp;';?><div class="icon_click"></div></div>
<div class="error-descriptoin">
Необходимо удалить пробелы в categoryId.
</div>       
</div>        
        <div class="spoiler_body">
          <button class="close-button" title="закрыть" onclick="closeAndScroll()"></button>
          <button class="copy-button" title="скопировать" onclick="onCopyHandle(event)"></button>
          <div class="line"></div>
<?php
    // проверка на наличие пробела в categoryId товара
    
    $num_naiden_probel_categoryId_spoler = 0;
    foreach ($xml->shop->offers->offer as $offer) {
        $probel_categoryId               = "$offer->categoryId";
        $naiden_probel_categoryId_spoler = strrpos($probel_categoryId, ' ');
        if ($naiden_probel_categoryId_spoler === false) {
        } else {
            $num_naiden_probel_categoryId_spoler++;
            echo '<span class="offer_id_color">' .'Offer id: '.'</span>'.$offer['id']; if(empty(strip_tags(trim($offer['id'])))) {echo '<span class="offer-id-not-write">'.'offer id не указан'.'</span>';}; echo '<span class="name_color">'. ' Название: ' .'</span>'.$offer->name . '&nbsp;' . '&nbsp;' . '<span class="model_color">'.$offer->model.'</span>'; if(empty(strip_tags(trim("$offer->name"))) and empty(strip_tags(trim("$offer->model")))) {echo '<span class="name-not-write">'.'название товара не указано'.'</span>';}; echo '<span class="name_color">'. ' categoryId: ' .'</span>'.$offer->categoryId.'<br>';
        }
    }
    
?>
          <div class="line"></div>
        </div>
        <?php
}

?>
        <?php
if ($num_naiden_probel_offer_id > 0) {
?>
        <div class="spoiler_links spoiler_title"><div class="title_list"><?php echo 'Товаров с пробелом в offer id: ' . '<span style="color: red; font-weight: bold;">' .'&nbsp;'. $num_naiden_probel_offer_id.'&nbsp;'. '</span>' . 'из ' . count($all_offers); echo '&nbsp;';?><div class="icon_click"></div></div>
<div class="error-descriptoin">
Необходимо удалить пробелы в offer id.
</div>       
</div>         
        <div class="spoiler_body">
          <button class="close-button" title="закрыть" onclick="closeAndScroll()"></button>
          <button class="copy-button" title="скопировать" onclick="onCopyHandle(event)"></button>
          <div class="line"></div>
<?php
    // проверка на наличие пробела в offer_id товара.
    
    $num_naiden_probel_offer_id_spoler = 0;
    foreach ($xml->shop->offers->offer as $offer) {
        $probel_offer_id_spoler           = "$offer[id]";
        $naiden_probel_offer_id_id_spoler = strrpos($probel_offer_id_spoler, ' ');
        if ($naiden_probel_offer_id_id_spoler === false) {
        } else {
            $num_naiden_probel_offer_id_spoler++;
            echo '<span class="offer_id_color">' .'Offer id: '.'</span>'.$offer['id']; if(empty(strip_tags(trim($offer['id'])))) {echo '<span class="offer-id-not-write">'.'offer id не указан'.'</span>';}; echo '<span class="name_color">'. ' Название: ' .'</span>'.$offer->name . '&nbsp;' . '&nbsp;' . '<span class="model_color">'.$offer->model.'</span>'; if(empty(strip_tags(trim("$offer->name"))) and empty(strip_tags(trim("$offer->model")))) {echo '<span class="name-not-write">'.'название товара не указано'.'</span>';}; echo'<br>';
        }
    }
    
?>
          <div class="line"></div>
        </div>
        <?php
}

?>
        <?php
if ($num_naiden_probel_url > 0) {
?>
        <div class="spoiler_links spoiler_title"><div class="title_list"><?php echo 'Товаров с пробелом в url товара: ' . '<span style="color: red; font-weight: bold;">' .'&nbsp;'. $num_naiden_probel_url.'&nbsp;'. '</span>' . 'из ' . count($all_offers); echo '&nbsp;';?><div class="icon_click"></div></div>
<div class="error-descriptoin">
Необходимо удалить пробелы в url товара.
</div>       
</div>         
        <div class="spoiler_body">
          <button class="close-button" title="закрыть" onclick="closeAndScroll()"></button>
          <button class="copy-button" title="скопировать" onclick="onCopyHandle(event)"></button>
          <div class="line"></div>
<?php
    // проверка на наличие пробела в url товара
    
    $num_naiden_probel_url_spoler = 0;
    foreach ($xml->shop->offers->offer as $offer) {
        $probel_url_spoler        = "$offer->url";
        $probel_url_spoler = trim($probel_url_spoler);
        $naiden_probel_url_spoler = strrpos($probel_url_spoler, ' ');
        if ($naiden_probel_url_spoler === false) {
        } else {
            $num_naiden_probel_url_spoler++;
            echo '<span class="offer_id_color">' .'Offer id: '.'</span>'.$offer['id']; if(empty(strip_tags(trim($offer['id'])))) {echo '<span class="offer-id-not-write">'.'offer id не указан'.'</span>';}; echo '<span class="name_color">'. ' Название: ' .'</span>'.$offer->name . '&nbsp;' . '&nbsp;' . '<span class="model_color">'.$offer->model.'</span>';
            echo "<a href='$offer->url' target='_blank' rel='noopener noreferrer'>$offer->url</a>". '<br>';
        }
    }
    
?>
          <div class="line"></div>
        </div>
        <?php
}

?>
        <?php
if ($num_naiden_probel_price > 0) {
?>
        <div class="spoiler_links spoiler_title"><div class="title_list"><?php echo 'Товаров с пробелом в price товара: ' . '<span style="color: red; font-weight: bold;">' .'&nbsp;'. $num_naiden_probel_price.'&nbsp;'. '</span>' . 'из ' . count($all_offers); echo '&nbsp;';?><div class="icon_click"></div></div>
<div class="error-descriptoin">
Необходимо удалить пробелы в price товара.
</div>       
</div>        
        <div class="spoiler_body">
          <button class="close-button" title="закрыть" onclick="closeAndScroll()"></button>
          <button class="copy-button" title="скопировать" onclick="onCopyHandle(event)"></button>
          <div class="line"></div>
<?php
    // проверка на наличие пробела в price товара
    
    $num_naiden_probel_price_spoler = 0;
    foreach ($xml->shop->offers->offer as $offer) {
        $probel_price_spoler        = "$offer->price";
        $naiden_probel_price_spoler = strrpos($probel_price_spoler, ' ');
        if ($naiden_probel_price_spoler === false) {
        } else {
            $num_naiden_probel_price_spoler++;
            echo '<span class="offer_id_color">' .'Offer id: '.'</span>'.$offer['id']; if(empty(strip_tags(trim($offer['id'])))) {echo '<span class="offer-id-not-write">'.'offer id не указан'.'</span>';}; echo '<span class="name_color">'. ' Название: ' .'</span>'.$offer->name . '&nbsp;' . '&nbsp;' . '<span class="model_color">'.$offer->model.'</span>'; if(empty(strip_tags(trim("$offer->name"))) and empty(strip_tags(trim("$offer->model")))) {echo '<span class="name-not-write">'.'название товара не указано'.'</span>';}; echo '&nbsp;' . '&nbsp;' . '<span class="price_color">'.'Цена: ' .'</span>'. $offer->price . ' грн.'. '<br>';
        }
    }
    
?>
          <div class="line"></div>
        </div>
        <?php
}

?>
        <?php
if ($num_naiden_probel_currencyId > 0) {
?>
        <div class="spoiler_links spoiler_title"><div class="title_list"><?php echo 'Товаров с пробелом в currencyId товара: ' . '<span style="color: red; font-weight: bold;">' .'&nbsp;'. $num_naiden_probel_currencyId.'&nbsp;'. '</span>' . 'из ' . count($all_offers); echo '&nbsp;';?><div class="icon_click"></div></div>
<div class="error-descriptoin">
Необходимо удалить пробелы в currencyId товара.
</div>       
</div>         
        <div class="spoiler_body">
          <button class="close-button" title="закрыть" onclick="closeAndScroll()"></button>
          <button class="copy-button" title="скопировать" onclick="onCopyHandle(event)"></button>
          <div class="line"></div>
<?php
    // проверка на наличие пробела в currencyId товара
    
    $num_naiden_probel_currencyId_spoler = 0;
    foreach ($xml->shop->offers->offer as $offer) {
        $probel_currencyId_spoler        = "$offer->currencyId";
        $naiden_probel_currencyId_spoler = strrpos($probel_currencyId_spoler, ' ');
        if ($naiden_probel_currencyId_spoler === false) {
        } else {
            $num_naiden_probel_currencyId_spoler++;
            echo '<span class="offer_id_color">' .'Offer id: '.'</span>'.$offer['id']; if(empty(strip_tags(trim($offer['id'])))) {echo '<span class="offer-id-not-write">'.'offer id не указан'.'</span>';}; echo '<span class="name_color">'. ' Название: ' .'</span>'.$offer->name . '&nbsp;' . '&nbsp;' . '<span class="model_color">'.$offer->model.'</span>'; if(empty(strip_tags(trim("$offer->name"))) and empty(strip_tags(trim("$offer->model")))) {echo '<span class="name-not-write">'.'название товара не указано'.'</span>';}; echo '&nbsp;' . '&nbsp;' . '<span class="currencyId_color">'.'Валюта: ' .'</span>'. $offer->currencyId . '<br>';
        }
    }
    
?>
          <div class="line"></div>
        </div>
        <?php
}

?>
        <?php
if ($num_naiden_probel_picture > 0) {
?>
        <div class="spoiler_links spoiler_title"><div class="title_list"><?php echo 'Фото с пробелом в picture товара: ' . '<span style="color: red; font-weight: bold;">' .'&nbsp;'. $num_naiden_probel_picture.'&nbsp;'. '</span>' . 'из ' . count($count_of_picture_112); echo '&nbsp;';?><div class="icon_click"></div></div>
<div class="error-descriptoin">
Необходимо удалить пробелы в picture товара.
</div>       
</div>        
        <div class="spoiler_body">
          <button class="close-button" title="закрыть" onclick="closeAndScroll()"></button>
          <button class="copy-button" title="скопировать" onclick="onCopyHandle(event)"></button>
          <div class="line"></div>
<?php
    // проверка на наличие пробела в picture товара
    
    $num_naiden_probel_picture_spoler = 0;
    foreach ($xml->shop->offers->offer as $offer) {
        foreach ($offer->picture as $picture) {
            $probel_picture_spoler = trim($picture);
            $naiden_probel_picture_spoler     = strrpos($probel_picture_spoler, ' ');
            if ($naiden_probel_picture_spoler === false) {
            } else {
                $num_naiden_probel_picture_spoler++;
                echo '<span class="offer_id_color">' .'Offer id: '.'</span>'.$offer['id']; if(empty(strip_tags(trim($offer['id'])))) {echo '<span class="offer-id-not-write">'.'offer id не указан'.'</span>';}; echo '<span class="name_color">'. ' Название: ' .'</span>'.$offer->name . '&nbsp;' . '&nbsp;' . '<span class="model_color">'.$offer->model.'</span>'; if(empty(strip_tags(trim("$offer->name"))) and empty(strip_tags(trim("$offer->model")))) {echo '<span class="name-not-write">'.'название товара не указано'.'</span>';}; echo'&nbsp;' . '&nbsp;';
                echo "<a  href='$picture' target='_blank' rel='noopener noreferrer'>$picture</a>". '<br>';
            }
        }
    }
    
?>
          <div class="line"></div>
        </div>
        <?php
}

?>
        <?php
if ($description_store > 0 or $description_pay > 0 or $description_delivery > 0 or $description_buy > 0 or $description_phone > 0 or $description_uah > 0 or $description_site > 0 or $description_price > 0 or $description_price2 > 0 or $description_manager > 0 or $description_proposal > 0 or $description_call > 0 or $description_contact > 0 or $description_variation > 0 or $description_order > 0) {
?>
        <div class="spoiler_links spoiler_title" id="description_list_up"><div class="title_list"><?php echo 'Товаров, у которых в описании есть стоп-слово: ' . '<span style="color: red; font-weight: bold;">' .'&nbsp;'. $description_stop_sum.'&nbsp;'. '</span>' . 'из ' . count($all_offers); echo '&nbsp;';?><div class="icon_click"></div></div>
<div class="error-descriptoin">
В описании должна быть информация только про сам товар. Не должно быть ссылок, телефонов, адресов, предложений услуг, акций, цен, картинок, видео, информации про другие варианты товара и т.д. Проверьте свое описание по ключевым стоп-словам: магазин, оплат, доставк, купит, тел., грн, сайт, цена, стоимость, менеджер, заявк, позвонит, обраща, вариа, заказ.
</div>       
</div>        
        <div class="spoiler_body grey1">
          <button class="close-button" title="закрыть" onclick="closeAndScroll()"></button>
          <div class="line"></div>
<?php
    // проверка на наличие стоп-слов в описании товара.
    $description_stop      = 0;
    $description_stop_list = 0;
    
    $description_store_list     = 0;
    $description_pay_list       = 0;
    $description_delivery_list  = 0;
    $description_buy_list       = 0;
    $description_phone_list     = 0;
    $description_uah_list       = 0;
    $description_site_list      = 0;
    $description_price_list     = 0;
    $description_price2_list    = 0;
    $description_manager_list   = 0;
    $description_proposal_list  = 0;
    $description_call_list      = 0;
    $description_contact_list   = 0;
    $description_variation_list = 0;
    $description_order_list     = 0;
    
if ($description_store > 0) {
    echo 'Товаров, где в описании есть стоп-слово ' . '<span style="color: red; ">' . 'магазин' . '</span>' . ': ' . '<span style="color: red; font-weight: bold;">' . $description_store . '</span>' . ' из ' . count($all_offers) . '<br>';
}

if ($description_pay > 0) {
    echo 'Товаров, где в описании есть стоп-слово ' . '<span style="color: red; ">' . 'оплат(про оплатить)' . '</span>' . ': ' . '<span style="color: red; font-weight: bold;">' . $description_pay . '</span>' . ' из ' . count($all_offers) . '<br>';
}

if ($description_delivery > 0) {
    echo 'Товаров, где в описании есть стоп-слово ' . '<span style="color: red; ">' . 'доставк' . '</span>' . '(про доставку)' . ': ' . '<span style="color: red; font-weight: bold;">' . $description_delivery . '</span>' . ' из ' . count($all_offers) . '<br>';
}

if ($description_buy > 0) {
    echo 'Товаров, где в описании есть стоп-слово ' . '<span style="color: red; ">' . 'купит' . '</span>' . '(про купить)' . ': ' . '<span style="color: red; font-weight: bold;">' . $description_buy . '</span>' . ' из ' . count($all_offers) . '<br>';
}

if ($description_phone > 0) {
    echo 'Товаров, где в описании есть стоп-слово ' . '<span style="color: red; ">' . 'тел.' . '</span>' . ': ' . '<span style="color: red; font-weight: bold;">' . $description_phone . '</span>' . ' из ' . count($all_offers) . '<br>';
}

if ($description_uah > 0) {
    echo 'Товаров, где в описании есть стоп-слово ' . '<span style="color: red; ">' . 'грн' . '</span>' . ': ' . '<span style="color: red; font-weight: bold;">' . $description_uah . '</span>' . ' из ' . count($all_offers) . '<br>';
}

if ($description_site > 0) {
    echo 'Товаров, где в описании есть стоп-слово ' . '<span style="color: red; ">' . 'сайт' . '</span>' . ': ' . '<span style="color: red; font-weight: bold;">' . $description_site . '</span>' . ' из ' . count($all_offers) . '<br>';
}

if ($description_price > 0) {
    echo 'Товаров, где в описании есть стоп-слово ' . '<span style="color: red; ">' . 'цена' . '</span>' . ': ' . '<span style="color: red; font-weight: bold;">' . $description_price . '</span>' . ' из ' . count($all_offers) . '<br>';
}

if ($description_price2 > 0) {
    echo 'Товаров, где в описании есть стоп-слово ' . '<span style="color: red; ">' . 'стоимость' . '</span>' . ': ' . '<span style="color: red; font-weight: bold;">' . $description_price2 . '</span>' . ' из ' . count($all_offers) . '<br>';
}

if ($description_manager > 0) {
    echo 'Товаров, где в описании есть стоп-слово ' . '<span style="color: red; ">' . 'менеджер' . '</span>' . ': ' . '<span style="color: red; font-weight: bold;">' . $description_manager . '</span>' . ' из ' . count($all_offers) . '<br>';
}

if ($description_proposal > 0) {
    echo 'Товаров, где в описании есть стоп-слово ' . '<span style="color: red; ">' . 'заявк' . '</span>' . '(про заявку)' . ': ' . '<span style="color: red; font-weight: bold;">' . $description_proposal . '</span>' . ' из ' . count($all_offers) . '<br>';
}

if ($description_call > 0) {
    echo 'Товаров, где в описании есть стоп-слово ' . '<span style="color: red; ">' . 'позвонит' . '</span>' . '(про позвоните)' . ': ' . '<span style="color: red; font-weight: bold;">' . $description_call . '</span>' . ' из ' . count($all_offers) . '<br>';
}

if ($description_contact > 0) {
    echo 'Товаров, где в описании есть стоп-слово ' . '<span style="color: red; ">' . 'обраща' . '</span>' . '(про обращайтесь)' . ': ' . '<span style="color: red; font-weight: bold;">' . $description_contact . '</span>' . ' из ' . count($all_offers) . '<br>';
}

if ($description_variation > 0) {
    echo 'Товаров, где в описании есть стоп-слово ' . '<span style="color: red; ">' . 'вариа' . '</span>' . '(про вариант)' . ': ' . '<span style="color: red; font-weight: bold;">' . $description_variation . '</span>' . ' из ' . count($all_offers) . '<br>';
}

if ($description_order > 0) {
    echo 'Товаров, где в описании есть стоп-слово ' . '<span style="color: red; ">' . 'заказ' . '</span>' . ': ' . '<span style="color: red; font-weight: bold;">' . $description_order . '</span>' . ' из ' . count($all_offers) . '<br>';
}
    
    if ($description_stop_sum > 0) {
        echo '<hr>';
    }

    foreach ($xml->shop->offers->offer as $offer) {
        $offer->description = str_replace("магазин", '<span style="color: #f00; font-weight: bold;">' . 'МАГАЗИН' . '</span>', $offer->description);
        $offer->description = str_replace("оплат", '<span style="color: #f00; font-weight: bold;">' . 'ОПЛАТ' . '</span>', $offer->description);
        $offer->description = str_replace("доставк", '<span style="color: #f00; font-weight: bold;">' . 'ДОСТАВК' . '</span>', $offer->description);
        $offer->description = str_replace("купит", '<span style="color: #f00; font-weight: bold;">' . 'КУПИТ' . '</span>', $offer->description);
        $offer->description = str_replace("тел.", '<span style="color: #f00; font-weight: bold;">' . "ТЕЛ." . '</span>', $offer->description);
        $offer->description = str_replace("грн", '<span style="color: #f00; font-weight: bold;">' . "ГРН" . '</span>', $offer->description);
        $offer->description = str_replace("сайт", '<span style="color: #f00; font-weight: bold;">' . 'САЙТ' . '</span>', $offer->description);
        $offer->description = str_replace("цена", '<span style="color: #f00; font-weight: bold;">' . 'ЦЕНА' . '</span>', $offer->description);
        $offer->description = str_replace("стоимость", '<span style="color: #f00; font-weight: bold;">' . 'СТОИМОСТЬ' . '</span>', $offer->description);
        $offer->description = str_replace("менеджер", '<span style="color: #f00; font-weight: bold;">' . 'МЕНЕДЖЕР' . '</span>', $offer->description);
        $offer->description = str_replace("заявк", '<span style="color: #f00; font-weight: bold;">' . 'ЗАЯВК' . '</span>', $offer->description);
        $offer->description = str_replace("позвонит", '<span style="color: #f00; font-weight: bold;">' . 'ПОЗВОНИТ' . '</span>', $offer->description);
        $offer->description = str_replace("обраща", '<span style="color: #f00; font-weight: bold;">' . 'ОБРАЩА' . '</span>', $offer->description);
        $offer->description = str_replace("вариа", '<span style="color: #f00; font-weight: bold;">' . 'ВАРИА' . '</span>', $offer->description);
        $offer->description = str_replace("заказ", '<span style="color: #f00; font-weight: bold;">' . 'ЗАКАЗ' . '</span>', $offer->description);
        $offer->description = str_replace("Магазин", '<span style="color: #f00; font-weight: bold;">' . 'МАГАЗИН' . '</span>', $offer->description);
        $offer->description = str_replace("Оплат", '<span style="color: #f00; font-weight: bold;">' . 'ОПЛАТ' . '</span>', $offer->description);
        $offer->description = str_replace("Доставк", '<span style="color: #f00; font-weight: bold;">' . 'ДОСТАВК' . '</span>', $offer->description);
        $offer->description = str_replace("Купит", '<span style="color: #f00; font-weight: bold;">' . 'КУПИТ' . '</span>', $offer->description);
        $offer->description = str_replace("Тел.", '<span style="color: #f00; font-weight: bold;">' . "ТЕЛ." . '</span>', $offer->description);
        $offer->description = str_replace("Грн", '<span style="color: #f00; font-weight: bold;">' . "ГРН" . '</span>', $offer->description);
        $offer->description = str_replace("Сайт", '<span style="color: #f00; font-weight: bold;">' . 'САЙТ' . '</span>', $offer->description);
        $offer->description = str_replace("Цена", '<span style="color: #f00; font-weight: bold;">' . 'ЦЕНА' . '</span>', $offer->description);
        $offer->description = str_replace("Стоимость", '<span style="color: #f00; font-weight: bold;">' . 'СТОИМОСТЬ' . '</span>', $offer->description);
        $offer->description = str_replace("Менеджер", '<span style="color: #f00; font-weight: bold;">' . 'МЕНЕДЖЕР' . '</span>', $offer->description);
        $offer->description = str_replace("Заявк", '<span style="color: #f00; font-weight: bold;">' . 'ЗАЯВК' . '</span>', $offer->description);
        $offer->description = str_replace("Позвонит", '<span style="color: #f00; font-weight: bold;">' . 'ПОЗВОНИТ' . '</span>', $offer->description);
        $offer->description = str_replace("Обраща", '<span style="color: #f00; font-weight: bold;">' . 'ОБРАЩА' . '</span>', $offer->description);
        $offer->description = str_replace("Вариа", '<span style="color: #f00; font-weight: bold;">' . 'ВАРИА' . '</span>', $offer->description);
        $offer->description = str_replace("Заказ", '<span style="color: #f00; font-weight: bold;">' . 'ЗАКАЗ' . '</span>', $offer->description);
        $offer->description = str_replace("МАГАЗИН", '<span style="color: #f00; font-weight: bold;">' . 'МАГАЗИН' . '</span>', $offer->description);
        $offer->description = str_replace("ОПЛАТ", '<span style="color: #f00; font-weight: bold;">' . 'ОПЛАТ' . '</span>', $offer->description);
        $offer->description = str_replace("ДОСТАВК", '<span style="color: #f00; font-weight: bold;">' . 'ДОСТАВК' . '</span>', $offer->description);
        $offer->description = str_replace("КУПИТ", '<span style="color: #f00; font-weight: bold;">' . 'КУПИТ' . '</span>', $offer->description);
        $offer->description = str_replace("ТЕЛ.", '<span style="color: #f00; font-weight: bold;">' . "ТЕЛ." . '</span>', $offer->description);
        $offer->description = str_replace("ГРН", '<span style="color: #f00; font-weight: bold;">' . "ГРН" . '</span>', $offer->description);
        $offer->description = str_replace("САЙТ", '<span style="color: #f00; font-weight: bold;">' . 'САЙТ' . '</span>', $offer->description);
        $offer->description = str_replace("ЦЕНА", '<span style="color: #f00; font-weight: bold;">' . 'ЦЕНА' . '</span>', $offer->description);
        $offer->description = str_replace("СТОИМОСТЬ", '<span style="color: #f00; font-weight: bold;">' . 'СТОИМОСТЬ' . '</span>', $offer->description);
        $offer->description = str_replace("МЕНЕДЖЕР", '<span style="color: #f00; font-weight: bold;">' . 'МЕНЕДЖЕР' . '</span>', $offer->description);
        $offer->description = str_replace("ЗАЯВК", '<span style="color: #f00; font-weight: bold;">' . 'ЗАЯВК' . '</span>', $offer->description);
        $offer->description = str_replace("ПОЗВОНИТ", '<span style="color: #f00; font-weight: bold;">' . 'ПОЗВОНИТ' . '</span>', $offer->description);
        $offer->description = str_replace("ОБРАЩА", '<span style="color: #f00; font-weight: bold;">' . 'ОБРАЩА' . '</span>', $offer->description);
        $offer->description = str_replace("ВАРИА", '<span style="color: #f00; font-weight: bold;">' . 'ВАРИА' . '</span>', $offer->description);
        $offer->description = str_replace("ЗАКАЗ", '<span style="color: #f00; font-weight: bold;">' . 'ЗАКАЗ' . '</span>', $offer->description);
        
        $description_strrpos = 0; // !!!!!!!!не трогать должно обнулять в цикле foreach каждый раз
        $lower_description = mb_strtolower("$offer->description");
        if (strrpos($lower_description, 'магазин') !== false)
        {
            $description_strrpos++;
        }
        
       if (strrpos($lower_description, 'оплат') !== false)
        {
            $description_strrpos++;
        }
        
       if (strrpos($lower_description, 'доставк') !== false)
        {
            $description_strrpos++;
        }
        
       if (strrpos($lower_description, 'купит') !== false)
        {
            $description_strrpos++;
        }
        
       if (strrpos($lower_description, 'тел.') !== false)
        {
            $description_strrpos++;
        }
        
       if (strrpos($lower_description, 'грн') !== false)
        {
            $description_strrpos++;
        }
        
        if (strrpos($lower_description, 'сайт') !== false)
        {
            $description_strrpos++;
        }
        
        if (strrpos($lower_description, 'цена') !== false)
        {
            $description_strrpos++;
        }
        
        if (strrpos($lower_description, 'стоимость') !== false)
        {
            $description_strrpos++;
        }
        
       if (strrpos($lower_description, 'менеджер') !== false)
        {
            $description_strrpos++;
        }
        
       if (strrpos($lower_description, 'заявк') !== false)
        {
            $description_strrpos++;
        }
        
       if (strrpos($lower_description, 'позвонит') !== false)
        {
            $description_strrpos++;
        }
        
       if (strrpos($lower_description, 'обраща') !== false)
        {
            $description_strrpos++;
        }
        
       if (strrpos($lower_description, 'вариа') !== false)
        {
            $description_strrpos++;
        }
        
       if (strrpos($lower_description, 'заказ') !== false)
        {
            $description_strrpos++;
        }
        
        if ($description_strrpos > 0) {
?>	    
          <div class="discriptionLinksStopWord">
            <?php
            echo '<span class="offer_id_color">' .'Offer id: '.'</span>'.$offer['id']; if(empty(strip_tags(trim($offer['id'])))) {echo '<span class="offer-id-not-write">'.'offer id не указан'.'</span>';}; echo '<span class="name_color">'. ' Название: ' .'</span>'.$offer->name . '&nbsp;' . '&nbsp;' . '<span class="model_color">'.$offer->model.'</span>'; if(empty(strip_tags(trim("$offer->name"))) and empty(strip_tags(trim("$offer->model")))) {echo '<span class="name-not-write">'.'название товара не указано'.'</span>';}; echo'<br>';
            echo $offer->description;
            $description_stop++;
?>
          </div>
          <?php
        }
        
       if (strrpos($lower_description, 'магазин') !== false)
        {
            $description_store_list++;
            $description_stop_list++;
?>
          <br>
          <div class="alarm">
            <div class="alarm-icon icon"></div>
            <p class="alarm-text-name">В описании есть слово <span style="color: red; font-weight: bold;">м-а-г-а-з-и-н</span></p>
          </div>
          <?php
        }
        
       if (strrpos($lower_description, 'оплат') !== false)
        {
            $description_pay_list++;
            $description_stop_list++;
?>
          <br>
          <div class="alarm">
            <div class="alarm-icon icon"></div>
            <p class="alarm-text-name">В описании есть слово <span style="color: red; font-weight: bold;">о-п-л-а-т(про о-п-л-а-т-и-т-ь)</span></p>
          </div>
          <?php
        }
        
       if (strrpos($lower_description, 'доставк') !== false)
        {
            $description_delivery_list++;
            $description_stop_list++;
?>
          <br>
          <div class="alarm">
            <div class="alarm-icon icon"></div>
            <p class="alarm-text-name">В описании есть слово <span style="color: red; font-weight: bold;">д-о-с-т-а-в-к(про д-о-с-т-а-в-к-у)</span></p>
          </div>
          <?php
        }
        
      if (strrpos($lower_description, 'купит') !== false)
        {
            $description_buy_list++;
            $description_stop_list++;
?>
          <br>
          <div class="alarm">
            <div class="alarm-icon icon"></div>
            <p class="alarm-text-name">В описании есть слово <span style="color: red; font-weight: bold;">к-у-п-и-т(про к-у-п-и-т-ь)</span></p>
          </div>
          <?php
        }
        
       if (strrpos($lower_description, 'тел.') !== false)
        {
            $description_phone_list++;
            $description_stop_list++;
?>
          <br>
          <div class="alarm">
            <div class="alarm-icon icon"></div>
            <p class="alarm-text-name">В описании есть слово <span style="color: red; font-weight: bold;">т-е-л.</span></p>
          </div>
          <?php
        }
        
      if (strrpos($lower_description, 'грн') !== false)
        {
            $description_uah_list++;
            $description_stop_list++;
?>
          <br>
          <div class="alarm">
            <div class="alarm-icon icon"></div>
            <p class="alarm-text-name">В описании есть слово <span style="color: red; font-weight: bold;">г-р-н</span></p>
          </div>
          <?php
        }
        
       if (strrpos($lower_description, 'сайт') !== false)
        {
            $description_site_list++;
            $description_stop_list++;
?>
          <br>
          <div class="alarm">
            <div class="alarm-icon icon"></div>
            <p class="alarm-text-name">В описании есть слово <span style="color: red; font-weight: bold;">с-а-й-т</span></p>
          </div>
          <?php
        }
        
       if (strrpos($lower_description, 'цена') !== false)
        {
            $description_price_list++;
            $description_stop_list++;
?>
          <br>
          <div class="alarm">
            <div class="alarm-icon icon"></div>
            <p class="alarm-text-name">В описании есть слово <span style="color: red; font-weight: bold;">ц-е-н-а</span></p>
          </div>
          <?php
        }
        
       if (strrpos($lower_description, 'стоимость') !== false)
        {
            $description_price2_list++;
            $description_stop_list++;
?>
          <br>
          <div class="alarm">
            <div class="alarm-icon icon"></div>
            <p class="alarm-text-name">В описании есть слово <span style="color: red; font-weight: bold;">с-т-о-и-м-о-с-т-ь</span></p>
          </div>
          <?php
        }
        
        if (strrpos($lower_description, 'менеджер') !== false)
        {
            $description_manager_list++;
            $description_stop_list++;
?>
          <br>
          <div class="alarm">
            <div class="alarm-icon icon"></div>
            <p class="alarm-text-name">В описании есть слово <span style="color: red; font-weight: bold;">м-е-н-е-д-ж-е-р</span></p>
          </div>
          <?php
        }
        
       if (strrpos($lower_description, 'заявк') !== false)
        {
            $description_proposal_list++;
            $description_stop_list++;
?>
          <br>
          <div class="alarm">
            <div class="alarm-icon icon"></div>
            <p class="alarm-text-name">В описании есть слово <span style="color: red; font-weight: bold;">з-а-я-в-к(про з-а-я-в-к-у)</span></p>
          </div>
          <?php
        }
        
       if (strrpos($lower_description, 'позвонит') !== false)
        {
            $description_call_list++;
            $description_stop_list++;
?>
          <br>
          <div class="alarm">
            <div class="alarm-icon icon"></div>
            <p class="alarm-text-name">В описании есть слово <span style="color: red; font-weight: bold;">п-о-з-в-о-н-и-т(про п-о-з-в-о-н-и-т-е)</span></p>
          </div>
          <?php
        }
        
        if (strrpos($lower_description, 'обраща') !== false)
        {
            $description_contact_list++;
            $description_stop_list++;
?>
          <br>
          <div class="alarm">
            <div class="alarm-icon icon"></div>
            <p class="alarm-text-name">В описании есть слово <span style="color: red; font-weight: bold;">о-б-р-а-щ-а(про о-б-р-а-щ-а-й-т-е-с-ь)</span></p>
          </div>
          <?php
        }
        
        if (strrpos($lower_description, 'вариа') !== false)
        {
            $description_variation_list++;
            $description_stop_list++;
?>
          <br>
          <div class="alarm">
            <div class="alarm-icon icon"></div>
            <p class="alarm-text-name">В описании есть слово <span style="color: red; font-weight: bold;">в-а-р-и-а(про в-а-р-и-а-н-т)</span></p>
          </div>
          <?php
        }
        
       if (strrpos($lower_description, 'заказ') !== false)
        {
            $description_order_list++;
            $description_stop_list++;
?>
          <br>
          <div class="alarm">
            <div class="alarm-icon icon"></div>
            <p class="alarm-text-name">В описании есть слово <span style="color: red; font-weight: bold;">з-а-к-а-з</span></p>
          </div>
          <?php
        }
        
        if ($description_strrpos > 0) {
            echo '<hr>';
        }
    }
    ;
    if ($description_stop_list > 0) {
        echo 'Товаров с наличием стоп-слов в описании ' . '<span style="color: red; font-weight: bold;">' . $description_stop . '</span>' . ' из ' . count($all_offers);
    }
    
?><br><br><?php
    echo '<a href="#description_list_up" title="Вернуться к началу" class="hide-button scrollto">Вернуться к началу спойлера</a>' . '<br>' . '<br>';
?>
        </div>         <!--spoiler_body grey1 close стоп-слово-->

        <?php
}

?>
<div class="title_list">В дальнейшем адрес ссылки на xml файл и номера offer id не должны меняться. Номера offer id должны быть уникальными.</div>

</div> <!--result-list close-->

</div> <!--result_not_list close-->

<!--вывод фразы Замечаний по xml файлу нет-->
<script>
    const resultNotList = document.querySelector('.result_not_list');
    if(resultNotList.offsetHeight < 52){
      resultNotList.insertAdjacentHTML('beforeend', '<p class="no-mistakes">Замечаний по xml файлу нет.</p>')
    }
</script>

<div class="wrapper-spoiler">
    <hr>
        <div class="spoiler_body1 spoiler_open">
          <?php
          
// Вывод используемых категорий
$x = 0;
foreach ($xml->shop->categories->category as $category) {
    $array_category_id_categories[] = "$category[id]";
    $array_category_categories[]    = "$category";
}

$array_combine_categories = array_combine($array_category_id_categories, $array_category_categories);
foreach ($xml->shop->offers->offer as $offer) {
    $sort_categoryId[] = "$offer->categoryId";
    $result = array_unique($sort_categoryId);
}
$count_sort_categoryId_spoler = array_count_values($sort_categoryId);

sort($result);
echo 'Всего категорий в xml ' . $count_category . '. Из них товар представлен в ' . '<span style="color: purple; font-weight: bold;">' . count($result) . '</span>' . '.' . ' ' . 'В скобках пишется количество товара по каждой категории.' . '<br>';
?>
          <div class="column">
            <?php
foreach ($xml->shop->categories->category as $category) {
    for ($y = 0; $y < count($result); $y++) {
        if ($category['id'] == $result[$y]) {
?> 
            <div class="column"> <?php
            $x++;
echo '<span style="color: purple; font-weight: bold;">' . $x . ')' . '</span>';
echo '&nbsp;' . '&nbsp;' . $result[$y] . ' ::: ' . $category;
            echo ' (' . '<span style="color: #4aa7ed; font-weight: bold;">' . $count_sort_categoryId_spoler[$result[$y]] . '</span>' . ')' . '<br>';
?></div>
            <?php
        }
    }
}
?>
          </div>
          
          <?php
// }
// Вывод используемых вендоров.
foreach ($xml->shop->offers->offer as $offer) {
    $sort_vendor[] = "$offer->vendor";
}

$count_vendor_spoler = array_count_values($sort_vendor);
ksort($count_vendor_spoler);
$count_vendor_spoler_sort = array_values($count_vendor_spoler);
$vendor_unique            = array_unique($sort_vendor);
sort($vendor_unique);
echo '<hr>' . 'Всего вендоров: ' . '<span style="color: green; font-weight: bold;">' . count($vendor_unique) . '</span>' . '. ' . 'В скобках пишется количество товара по каждому вендору.' . '<br>';
?>
          <div class="columnOf4">
            <?php
$vv = 0;

for ($v = 0; $v < count($vendor_unique); $v++) {
    $vv++;
?> 
            <div class="columnOf4"> <?php
    echo '<span style="color: green; font-weight: bold;">' . $vv . ')' . '</span>';
    echo '&nbsp;' . '&nbsp;';
    echo $vendor_unique[$v] . '(' . '<span style="color: #4aa7ed; font-weight: bold;">' . $count_vendor_spoler_sort[$v] . '</span>' . ')';
    if (empty(strip_tags(trim($vendor_unique[$v])))) {
        echo '<span style="color: red; ">' . '&nbsp;' . '&nbsp;' . "Не указан производитель через vendor" . '</span>';
    }
    echo '<br>';
?>
</div>
<?php         
}
echo '<br>';
?>
</div>
<div class="alphabetical-scrolling"></div>
<hr>

          
          
          <?php
if(count($all_offers) < 20000) { 
// Вывод используемых названий товаров по алфавиту.
//////////////////////////////////////////////////////////////////////////////////
          ?>
          <div class="spoiler_links blue" id="alphabet-list-offers">Вывод используемых названий товаров по алфавиту</div>
          <div class="spoiler_body-list">
          <button class="hide-button" onclick=$('.spoiler_body-list').hide('normal')>Закрыть спойлер</button>
            <?php
foreach ($xml->shop->offers->offer as $offer) {
    $sort_name[]  = "$offer->name";
    $sort_model[] = "$offer->model";
}
$name_unique = array_unique($sort_name);
sort($name_unique);
$model_unique = array_unique($sort_model);
sort($model_unique);
echo '<div class="count-all-offers">'.'Всего товаров: ' . count($all_offers) .'</div>';
if (count($name_unique) > 0 and count($model_unique) == 1) {
    echo 'Всего уникальных названий товаров через name: ' . count($name_unique) . '<br>';
}
if (count($model_unique) > 0 and count($name_unique) == 1) {
    echo 'Всего уникальных названий товаров через model: ' . count($model_unique) . '<br>';
}
echo '<br>';

function sortOffers_name($c1, $c2)
{
    return strcmp($c1->name, $c2->name);
}
uasort($offers, 'sortOffers_name'); // categoryId=61;categoryId=62;categoryId=63,etc.

foreach ($xml->shop->offers->offer as $offer) {
    $offers_categoryId_list[] = "$offer->categoryId";
    $offers_name_list[]       = "$offer->name";
    $offers_model_list[]      = "$offer->model";
}
if (count($offers_name_list) >= count($offers_model_list)) {
    $combine_name_model = array_combine($offers_name_list, $offers_model_list);
    ksort($combine_name_model);
    $combine_keys_name  = array_keys($combine_name_model);
    $combine_keys_model = array_values($combine_name_model);
} else {
    $combine_name_model = array_combine($offers_model_list, $offers_name_list);
    asort($combine_name_model);
    $combine_keys_name  = array_values($combine_name_model);
    $combine_keys_model = array_keys($combine_name_model);
}
$offers_number = 1;

foreach ($offers as $offer) {
    
?>
            <div class="common-offers-list-wrapper">
              <div class="offers-number"><?php
    echo $offers_number++ . ')' . '&nbsp;' . '&nbsp;';
?></div>
              <div class="offers-category"></div>
              <div class="offers-name"><?php
        if (empty(strip_tags(trim("$offer->name"))) and empty(strip_tags(trim("$offer->model")))) {
        echo '<span style="color: red; text-decoration: none; ">' . ' Не указано название' . '</span>';
    }
    echo '&nbsp;' . '&nbsp;' . $offer->name . '&nbsp;' . '&nbsp;';
    echo '<span style="color: #2e47ff; font-weight: bold;">' . $offer->model . '</span>';
?></div>
            </div>
<?php          
}
// echo '<a href="#alphabet-list-offers" title="Вернуться к началу" class="hide-button scrollto">Вернуться к началу спойлера</a>';
    ?>
    <button class="hide-button marginButton" onclick="closeAndScrollSpoilerBodyList()">Закрыть спойлер</button>
     <?php


// ===============================================================================================================================
// ===============================================================================================================================
// ===============================================================================================================================
// ===============================================================================================================================
// ===============================================================================================================================
  
?>
</div> <!--spoiler_body-list close Вывод используемых названий товаров по алфавиту-->



<div class="spoiler_links blue" id="common-list-offers">Вывод списка товаров в формате Категория-Название-Производитель</div>    

          
          <div class="spoiler_body-list">
            <button class="hide-button" onclick=$('.spoiler_body-list').hide('normal')>Закрыть спойлер</button>
            <?php
// Вывод списка товаров в формате Категория-Название-Производитель.
foreach ($xml->shop->offers->offer as $offer) {
    $sort_name[]  = "$offer->name";
    $sort_model[] = "$offer->model";
}
$name_unique = array_unique($sort_name);
sort($name_unique);
$model_unique = array_unique($sort_model);
sort($model_unique);
echo '<div class="count-all-offers">'.'Всего товаров: ' . count($all_offers) .'</div>';
if (count($name_unique) > 0 and count($model_unique) == 1) {
    echo 'Всего уникальных названий товаров через name: ' . count($name_unique) . '<br>';
}

if (count($model_unique) > 0 and count($name_unique) == 1) {
    echo 'Всего уникальных названий товаров через model: ' . count($model_unique) . '<br>';
}
echo '<br>';

$offers_number = 1;
function sortOffers_ccategoryId($c1, $c2)
{
    return strcmp($c1->categoryId, $c2->categoryId);
}
uasort($offers, 'sortOffers_ccategoryId'); // categoryId=61;categoryId=62;categoryId=63,etc.

foreach ($offers as $offer) {
?>
            <div class="common-offers-list-wrapper">
              <div class="offers-number"><?php
    echo $offers_number++ . ')' . '&nbsp;' . '&nbsp;';
?></div>
              <div class="offers-category"><?php
    foreach ($xml->shop->categories->category as $category) {
        if ($category['id'] == "$offer->categoryId") {
            // 4169E1
            echo '<div class="category-color">' . $offer->categoryId . ' ::: ' . $category .'</div>';
            break;
        }
        ;
    }
    ;
    if (empty(strip_tags(trim("$offer->categoryId")))) {
        echo '<span style="color: red; text-decoration: none; ">' . 'Не указана категория.' . '</span>';
    }
    ;
?></div>
              <div class="offers-name"><?php
    if (empty(strip_tags(trim("$offer->name"))) and empty(strip_tags(trim("$offer->model")))) {
        echo '<span style="color: red; text-decoration: none; ">' . '&nbsp;' . ' Не указано название' . '</span>';
    }
    ;
    
    
    echo '&nbsp;' . '&nbsp;' . $offer->name . '&nbsp;' . '&nbsp;' . '<span style="color: #2e47ff; font-weight: bold;">' . $offer->model . '</span>';
    echo '&nbsp;' . '&nbsp;' . '<span style="color: green; font-weight: bold;">' . '&nbsp;' . '&nbsp;' . "$offer->vendor" . '</span>';
    
        if (empty(strip_tags(trim("$offer->vendor")))) {
        echo '<span style="color: red; text-decoration: none; ">' . 'Не указан производитель.' . '</span>';
    }
    
    
?>
              </div>
<?php            
?>
<div class="offers-picture">
<?php
?>
</div>
<?php
// }           
?>
</div>
<?php
}
// echo '<a href="#common-list-offers" title="Вернуться к началу" class="hide-button scrollto">Вернуться к началу спойлера</a>' ;
  ?>
    <button class="hide-button marginButton" onclick="closeAndScrollSpoilerBodyList()">Закрыть спойлер</button>
     <?php
}
?>
          </div><!--spoiler_body-list close-->

      </div> <!--spoiler_body1 spoiler_open close -->
      
</div> <!--wrapper-spoiler close--> 

    </div> <!--result-wrapper close-->

    <?php
// подключаю раздел вывода карточек товара
include("body.php");
?>	
    <a href="#" title="Сменить тему" class="themebutton"></a>
    
    <a href="#result" title="Вернуться к началу" class="upbutton scrolltofoursec">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 53 53.1">
	<style>
		.st0{fill:#a3cbf9}
	</style>
	<path class="st0" d="M45.2 7.8c10.3 10.3 10.3 27.2 0 37.5-10.4 10.4-27.2 10.3-37.5 0s-10.4-27.1 0-37.5c10.4-10.4 27.2-10.4 37.5 0z" />
	<path d="M50.7 26.5c0 13.4-10.8 24.2-24.2 24.2S2.3 39.9 2.3 26.5 13.1 2.3 26.5 2.3s24.2 10.8 24.2 24.2z" fill="#a3cbf9" stroke="#a3cbf9" stroke-width=".722" />
	<path class="st0" d="M26.5 2.3C13.1 2.3 2.3 13.2 2.3 26.5 2.3 32.9 4.9 38.7 9 43c2.1-17.5 16.9-31.1 35-31.1.5 0 .9.1 1.4.1-4.5-5.8-11.1-9.7-18.9-9.7z" />
	<linearGradient id="SVGID_1_" gradientUnits="userSpaceOnUse" x1="-691.692" y1="-269.08" x2="-690.86" y2="-268.197" gradientTransform="matrix(0 19.994 -31.582 0 -8453.919 13851.304)">
		<stop offset="0" stop-color="#fff" stop-opacity=".727" />
		<stop offset="1" stop-color="#fff" />
	</linearGradient>
	<path class="arrowColor" d="M43.2 34l-4.1 4.1-11.7-11.6-11.6 11.6-4.2-4.2 15.7-15.7L43.2 34z" fill="url(#SVGID_1_)" />
</svg>
    </a>
    
    <a href="#theend" title="Перейти в конец" class="downbutton scrolltofoursec">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 53 53.1">
	<style>
		.st0{fill:#a3cbf9}
	</style>
	<path class="st0" d="M45.2 7.8c10.3 10.3 10.3 27.2 0 37.5-10.4 10.4-27.2 10.3-37.5 0s-10.4-27.1 0-37.5c10.4-10.4 27.2-10.4 37.5 0z" />
	<path d="M50.7 26.5c0 13.4-10.8 24.2-24.2 24.2S2.3 39.9 2.3 26.5 13.1 2.3 26.5 2.3s24.2 10.8 24.2 24.2z" fill="#a3cbf9" stroke="#a3cbf9" stroke-width=".722" />
	<path class="st0" d="M26.5 2.3C13.1 2.3 2.3 13.2 2.3 26.5 2.3 32.9 4.9 38.7 9 43c2.1-17.5 16.9-31.1 35-31.1.5 0 .9.1 1.4.1-4.5-5.8-11.1-9.7-18.9-9.7z" />
	<linearGradient id="SVGID_1_2" gradientUnits="userSpaceOnUse" x1="-691.692" y1="-269.08" x2="-690.86" y2="-268.197" gradientTransform="matrix(0 -19.994 31.582 0 8508.621 -13794.906)">
		<stop offset="0" stop-color="#fff" stop-opacity=".727" />
		<stop offset="1" stop-color="#fff" />
	</linearGradient>
	<path class="arrowColor" d="M11.6 22.3l4.1-4.1 11.7 11.6L39 18.2l4.2 4.2-15.7 15.7-15.9-15.8z" fill="url(#SVGID_1_2)" />
</svg>
    </a>

    <div class="footer" id="theend">
    
    <button class="allPhotoLoad">Загрузить все фото</button>
    <span class="wrapperDownloadedPhoto">Загружено фото: <span class="downloadedPhoto"></span> из <span class="numberAllPhoto"></span></span>
    <div class="lds-spinner hidden">
              <div></div>
              <div></div>
              <div></div>
              <div></div>
              <div></div>
              <div></div>
              <div></div>
              <div></div>
              <div></div>
              <div></div>
              <div></div>
              <div></div>
              </div>
              
<div class="brokenPicture hidden">Битые ссылки фото:</div>
<div class="smallPicture hidden">Фото с шириной меньше 220px:</div>

<form method="post" action="./checkPhoto.php" target="_blank" rel="noopener noreferrer">
    <input type="hidden" name="url" value="<?php echo $url_xml_for_photo ?>">
    <input class="button-to-photo"type="submit" value="Увидеть котика">
    </form>

</div> <!--footer close-->
<script src="theme.js"></script>

</body>
</html>