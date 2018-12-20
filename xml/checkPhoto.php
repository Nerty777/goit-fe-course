<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>Merry Christmas</title>
<link rel="shortcut icon" href="./favicon.ico" type="image/x-icon">
<style>

body {
    /*position: relative;*/
    margin: 0;
    font-size: 13px;
    font-family: Arial;
    line-height: 1.5;
}

a {
	text-decoration: none;
	    color: #2e47ff;
}

a:visited {
	color: rgba(0, 0, 238, 0.7);
	/* Цвет посещенной ссылки */
	    /*color: #006699;*/
	    color: #2e47ff;
}

hr {
    user-select: none;
}

.wrapper {
    padding: 10px;
}

.preload {
    position: absolute;
    width: 100vw;
    height: 100vh;
    background-repeat: no-repeat;
    background-position: center;
    background-size: cover;
    z-index: 2;
    
}

.themebutton {
    display: block;
	background: url("./../icon/whiteThemeSun.svg") no-repeat center;
	width: 10px;
	height: 10px;
	border: 2px solid transparent;
	text-align: center;
	padding: 10px;
	position: fixed;
	bottom: 80px;
	right: 20px;
	cursor: pointer;
	color: #333;
	border-radius: 5px;
    z-index: 1;
}

.copy-button {
	position: absolute;
	top: 4px;
	left: -40px;
	display: block;
	padding: 1px;
	border: none;
	outline: none;
	width: 27px;
	height: 27px;
	background: url(../~xml104/icon/copy.svg) no-repeat;
	user-select: none;
}

.copy-button:hover, .copy-button:focus {
	cursor: pointer;
}


.site-logo {
    display: inline-block;
	margin-left: 5px;
	position: absolute;
	width: 65px;
    height: 65px;
    padding: 2px;
    background-image: url(../~xml104/icon/result.svg);
    background-repeat: no-repeat;
    background-position: center;
    background-size: 65px auto;
}


.result-links {
    position: relative;
    margin-left: 89px;
}

.percent {
    position: absolute;
    top: 2px;
    left: 250px;
    background: #ffffff;
    padding: 5px;
    /*color: #e0157a;*/
    color: green;
    font-weight: bold;
    font-size: 14px;
}

.link-broken-photo, .link-small-photo {
    margin-left: 10px;
}

.all-photo-download, .all-photo-big{
    user-select: none;
}

.numer_of_picture_complete {
    margin: 10px 0px;
}

.final-result {
    position: relative;
    margin-left: 50px;
}

.offer-id-not-write, .name-not-write, .url-photo-not-write {
    font-weight: 700;
    color: #ff0000;
}

.number-all-offers-count {
    color: #4aa7ed;
    font-weight: bold;
}

.number-all-photo-count {
    color: #e0157a;
    font-weight: bold;
}

.numer_of_picture_complete {
    color: green;
    font-weight: bold;
}

</style>
</head>
<body>
<div class="preload"></div>  

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
<a href="#" title="Сменить тему" class="themebutton"></a>
<script src="themeCheckPhoto.js"></script>    
    
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

<!--показ картинки котика-->
<script>
const API_KEY_PIXABEY = "10322241-9acdecaf66598a52f4905bab5";
const namePixabaySearch = 'kitty';
// функция рандом числа в промежутке
function randomInteger(min, max) {
    let rand = min - 0.5 + Math.random() * (max - min + 1)
    rand = Math.round(rand);
    return rand;
  }
const apiImages = (namePixabaySearch, page) => {
  return axios
    .get(`https://pixabay.com/api/?key=${API_KEY_PIXABEY}&q=${namePixabaySearch}&image_type=photo&per_page=200&page=${page}`)
    .then(res => {
 let randomNumber = randomInteger(1, 200);
        preloadImg = res.data.hits[randomNumber].largeImageURL;
        const preload = document.querySelector('.preload');
        preload.style.backgroundImage = `url(${preloadImg})`;
        setTimeout(() => {
    preload.remove();
  }, 7000);
    })
    .catch(err => console.log(`axios err : ${err}`));
}
let page = randomInteger(1, 3);
apiImages(namePixabaySearch, page);
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

<div class="wrapper">
<div class="site-logo"></div>
<div class="result-links">

<?php
$url = $_POST["url"];

// конвертор punycode
// header('Content-Type: text/html; charset=utf-8');
include('idna_convert.class.php');
function coderurl($url) {
$idn = new idna_convert(array('idn_version'=>2008));
$url=(stripos($url, 'xn--')!==false) ? $idn->decode($url) : $idn->encode($url);
return $url;
}

$fail = '<br>'.'<br>'.'<br>'.'<br>'.'&emsp;'.'<span style="color: red; font-weight: bold;">' . 'Н' . '</span>' . 'ет связи с сервером xml.' . '<br>';
$xml_link = "&emsp;" . "Проверьте, чтоб ссылка на xml файл открывалась в браузере без ошибок <a href='$url' target='_blank' rel='noopener noreferrer'>$url</a>" . '<br>';
$xmlreturn = "&emsp;" ."Вернутся на главную страницу сайта "."<a href='https://195.16.88.10/~xml104'>https://195.16.88.10/~xml104</a>";
$xml_background = '<div style="background: linear-gradient(5deg, #201C2B, #201C2B); color: #ffffff; height: 100vh; font-size: 14px; font-family: arial; line-height: 1.5;" id="particles-js">';
$xml_background2 = '</div>';
$xml = simplexml_load_file($url) or exit("$xml_background $fail $xml_link $xmlreturn $xml_background2");

        foreach ($xml->shop->offers->offer as $offer)
		{ 
		$all_offers[] = $offer;
		}
		echo '<div class="all-offers-count">'.'Всего товаров: '.'<span class="number-all-offers-count">'.count($all_offers).'</span>'.'</div>';
		
        foreach ($xml->shop->offers->offer as $offer)
		{ 
		foreach ($offer->picture as $picture_all) {
		$count_of_picture_all[] = "$picture_all";
		}
		}
		$count_all_picture = count($count_of_picture_all);
		echo '<div class="all-photo-count">'.'Всего фото: '.'<span class="number-all-photo-count">'.$count_all_picture.'</span>'.'</div>';
		
		$u = $xml->shop->url;
$data = date('l, d F Y, H:i:s');
$сyrillic_url = stripos($u, '//xn--');
  if($сyrillic_url) {
    $u = coderurl($u); 
 } 
 $url = coderurl($url);
echo "<div class='wrapper-site-link'>"."Ссылка на сайт: <a class='site-link' href='$u' target='_blank' rel='noopener noreferrer'>$u</a>"."</div>";
echo "Ссылка на xml: <a class='xml-link' href='$url' target='_blank' rel='noopener noreferrer'>$url</a>" . '<br>';
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

//функция получения хоста с url сайта
function stripToDomainName($uri = '')
{
	$uri = strtolower(trim($uri));
	
	$uri = preg_replace('%^(http:\/\/)*(www.)*%usi', '', $uri);
	$uri = preg_replace('%^(https:\/\/)*(www.)*%usi', '', $uri);
	
	$uri = preg_replace('%\/.*$%usi' , '', $uri);
	
	return $uri;
}
$url_without_http =  stripToDomainName($u);
echo "<div class='similarweb-url'>"."Ссылка на pro.similarweb.com: <a href='https://pro.similarweb.com/#/website/audience-overview/$url_without_http/*/999/3m/?webSource=Total' target='_blank' rel='noopener noreferrer'>https://pro.similarweb.com/#/website/audience-overview/$url_without_http/*/999/3m/?webSource=Total</a>"."</div>";
?>
</div> <!--result-links close-->
<hr>
<div class="range"></div>

<?php
//создается файл 222.html и в него прописываются все вводимые через форму хмл
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
$span_open_count_offers = '<span style="color: #4aa7ed; font-weight: bold;">';
$span_close_count_offers =  '</span>';
$span_open_ip = '<span style="color: #000; font-weight: bold;">';
$span_close_ip =  '</span>';
$span_open_country = '<span style="color: #FFA07A; font-weight: bold;">';
$span_close_country =  '</span>';
$count_offers = count($all_offers); 
$url_site = "<a href='$u' target='_blank' class='url_site_valid_photo' rel='noopener noreferrer' style='color: #228B22; white-space: nowrap;'>$u</a>";
$url_xml = "<a href='$url' target='_blank' class='url_xml_valid_photo' rel='noopener noreferrer' style='color: #2e47ff; white-space: nowrap;'>$url</a>";
$wrapper_xml_list_open = '<div style="display:flex; flex-wrap: nowrap;">';
$wrapper_xml_list_close ='</div>';
$wrapper_open = '<span style="white-space: nowrap;">';
$wrapper_close ='</span>';
$space = '&nbsp;';
$numberok = 0;
$current = file_get_contents('222.html');
$numberok = substr_count($current, "\n") +1;
$dot= '.';
$allpicture = "<span style='color: #e0157a; font-weight: bold;'>$count_all_picture</span>";
$file_data_max = "$wrapper_xml_list_open $wrapper_open $numberok $dot $data $space $span_open_ip $ip $city $span_open_country $country $span_close_country $org $span_close_ip $wrapper_close $space $span_open_count_offers $count_offers $span_close_count_offers $space $allpicture $space $wrapper_open $url_site $wrapper_close $space $url_xml $wrapper_xml_list_close\n";
$file_data_min = "$wrapper_xml_list_open $wrapper_open $numberok $dot $data $space $wrapper_close $span_open_count_offers $count_offers $span_close_count_offers $space $allpicture $space $wrapper_open $url_site $wrapper_close $space $url_xml $wrapper_xml_list_close\n";
if ($ip == "95.164.82.34"){}
elseif($ip == "88.81.226.126"){$file_data_min .= file_get_contents('222.html'); file_put_contents('222.html',$file_data_min);}
else{$file_data_max .= file_get_contents('222.html'); file_put_contents('222.html',$file_data_max);}


		$photo_200 = 0;
		$foto = 0;
		$photo_number = 1;
		$broken_link = [];
		$small_photo = [];
        $wrapper_open = '<div style="white-space: nowrap;">';
        $wrapper_close = '</div>';
		$number_photo = 0;
        foreach ($xml->shop->offers->offer as $offer){
        foreach ($offer->picture as $picture){
            
        $number_photo++;
        $download_status_str = '<div class="percent">'.'Обработано фото: '.$number_photo.' из '.$count_all_picture.'&nbsp;'.'<br>'.'</div>';
        $download_status_str_fake = '<div class="percent">'.'</div>';
        echo $download_status_str_fake; echo $download_status_str; echo str_repeat(' ',1024*64); flush();
        
        // Маленькое фото
        $url_foto = $picture;
        $url_foto = trim("$picture", "\n");
        $picsize = getimagesize($url_foto);
		if(($picsize[0] < 300 or $picsize[1] < 300) and $picsize !== false) {$foto++ ;array_push($small_photo, $picture);
		echo $wrapper_open.'&nbsp;'.'&nbsp;'.'<span style="color: #FFA500; font-weight: bold;">'.'Маленькое фото. '.'</span>';
		echo 'Offer id товара: '.$offer['id'].'&nbsp;'; if(empty(strip_tags(trim($offer['id'])))) {echo '<span class="offer-id-not-write">'.'offer id не указан'.'</span>';}; echo ' Название товара: '.$offer->name.'&nbsp;'.'<span style="color: #0000ff;">'.$offer->model.'</span>';
		echo '&nbsp;'.'&nbsp;'.'&nbsp;'.'Разрешение фото: '.$picsize[0].' на '.$picsize[1].'&nbsp;';
		echo("<a href='$picture' target='_blank' rel='noopener noreferrer'>$picture</a>").$wrapper_close;}; 
  

        // битая ссылка
        if(!$picsize[0])
		{
		$photo_200++;array_push($broken_link, $url_foto);
		echo $wrapper_open.'&nbsp;'.'&nbsp;'.'<span style="color: #5F9EA0; font-weight: bold;">'.'Битая ссылка. '.'</span>';
		echo 'Offer id товара: '.$offer['id'].'&nbsp;'; if(empty(strip_tags(trim($offer['id'])))) {echo '<span class="offer-id-not-write">'.'offer id не указан'.'</span>';};
		echo ' Название товара: '.$offer->name.'&nbsp;'.'<span style="color: #0000ff;">'.$offer->model.'</span>'.'&nbsp;';
		if(empty(strip_tags(trim("$offer->name"))) and empty(strip_tags(trim("$offer->model")))) {echo '<span class="name-not-write">'.'название товара не указано '.'</span>';};
		echo "<a href='$url_foto' target='_blank' rel='noopener noreferrer'>$url_foto</a>";
		if(empty(strip_tags(trim("$url_foto")))) {echo '<span class="url-photo-not-write">'.'пустая ссылка '.'</span>';};
		echo $wrapper_close;
        }
        }
		}
        echo '<hr>';
        echo '<div class="numer_of_picture_complete">'.'Обработано 100% фото. Обработка завершена.'.'</div>'; 
        ?>
        
        <div class="final-result">
        <button class="copy-button" title="скопировать" onclick="onCopyHandle(event)"></button>
            

        
        <?php
		if ($photo_200 > 0) {
         echo '<div class="count-broken-photo">'.'<span style="color: #5F9EA0; font-weight: bold;">'.'Количество фото, где ссылка битая: '.'</span>'.'<span style="color: red; font-weight: bold;">'.$photo_200.'</span>'.' из '. $count_all_picture.'</div>'; 
        
// вывод списка битых ссылок 
foreach ($broken_link as &$value) {
 echo '<div class="link-broken-photo">'."<a href='$value' target='_blank' rel='noopener noreferrer' style='color: #5F9EA0;'>$value</a>".'</div>';
}
        } 
        if ($photo_200 == 0) echo '<div class="all-photo-download" style="color: green; font-weight: bold;">'.'Все фото загружаются.'.'</div>';
        if ($foto > 0) {
        echo '<div class="small-photo">'.'<span style="color: #FFA500; font-weight: bold;">'.'Количество фото, где разрешение ширины или длины фото меньше 300 пикселей: '.'</span>'.'<span style="color: red; font-weight: bold;">'.$foto.'</span>'.' из '. $count_all_picture.'</div>'; 

// вывод списка маленьких фото
foreach ($small_photo as &$value2) {
 echo '<div class="link-small-photo">'."<a href='$value2' target='_blank' rel='noopener noreferrer' style='color: #FFA500;'>$value2</a>".'</div>';
}
} 
if ($foto == 0) echo '<div class="all-photo-big" style="color: green; font-weight: bold;">'.'Нет фото с разрешением ширины или длины меньше 300 пикселей.'.'</div>';
?>
 
</div> <!--final-result close-->
        
<!--удаление статуса проверки фото        -->
<script>
	window.onload = function() {
	    const percentArray = document.querySelectorAll('.percent');
	    percentArray.forEach(percent => percent.remove());
	}
</script>

<!--не показывать кнопку копировать при отсуствии фейл фото	-->
<script>
	const finalResult = document.querySelector('.final-result');
	const copyButton = document.querySelector('.copy-button');
	 const finalResultHeight = finalResult.offsetHeight;
	 if(finalResultHeight < 40) {
	  copyButton.remove();
	  finalResult.style.margin = '0px';
	 }
</script>
	
</div>	<!--wrapper close-->
</body>
</html>
	