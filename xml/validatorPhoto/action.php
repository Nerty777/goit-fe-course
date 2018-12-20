<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Merry Christmas</title>
<link rel="shortcut icon" href="./favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="./css/main.css">
<style>

body {
    margin: 0;
    padding: 7px;
    font-size: 13px;
    font-family: arial;
}
   


</style>
</head>
<body>
    
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
<script src="theme.js"></script>
    
<?php
$url = $_POST["url"];

$found_google_drive_not_direct_link = stripos($url, 'https://drive.google.com/file');
if ($found_google_drive_not_direct_link !== false) {
$keywords = preg_split("/https:\/\/drive.google.com\/file\/d\//", $url);
$google_drive_id = preg_split("/\/view/", $keywords[1]);
$google_drive_id = $google_drive_id[0];
$url = 'https://docs.google.com/uc?export=download&id='.$google_drive_id;
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
		echo 'Всего товаров: '.count($all_offers).'. '.'<br>';
		
        foreach ($xml->shop->offers->offer as $offer)
		{ 
		foreach ($offer->picture as $picture_all) {
		$count_of_picture_all[] = "$picture_all";}};
		$count_all_picture = count($count_of_picture_all);
		echo 'Всего фото: '.$count_all_picture.'<br>';
		
		$u = $xml->shop->url;
$data = date('l, d F Y, H:i:s');
echo ("Ссылка на сайт: <a href='$u' target='_blank' rel='noopener noreferrer'>$u</a>"). "<br>";
echo("Ссылка на xml: <a href='$url' target='_blank' rel='noopener noreferrer'>$url</a>").'<br>';
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
echo("Ссылка на pro.similarweb.com: <a href='https://pro.similarweb.com/#/website/audience-overview/$url_without_http/*/999/3m/?webSource=Total' target='_blank' rel='noopener noreferrer'>https://pro.similarweb.com/#/website/audience-overview/$url_without_http/*/999/3m/?webSource=Total</a>").'<br>'.'<hr>';
?>
<div class="range"></div>

<?php
//создается файл 111.txt и в него прописываются все вводимые через форму хмл
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
$current = file_get_contents('111.html');
$numberok = substr_count($current, "\n") +1;
$dot= '.';
$allpicture = "<span style='color: #e0157a; font-weight: bold;'>$count_all_picture</span>";
$file_data_max = "$wrapper_xml_list_open $wrapper_open $numberok $dot $data $space $span_open_ip $ip $city $span_open_country $country $span_close_country $org $span_close_ip $wrapper_close $space $span_open_count_offers $count_offers $span_close_count_offers $space $allpicture $space $wrapper_open $url_site $wrapper_close $space $url_xml $wrapper_xml_list_close\n";
$file_data_min = "$wrapper_xml_list_open $wrapper_open $numberok $dot $data $space $wrapper_close $span_open_count_offers $count_offers $span_close_count_offers $space $allpicture $space $wrapper_open $url_site $wrapper_close $space $url_xml $wrapper_xml_list_close\n";
if ($ip == "95.164.82.34"){}
elseif($ip == "88.81.226.126"){$file_data_min .= file_get_contents('111.html'); file_put_contents('111.html',$file_data_min);}
else{$file_data_max .= file_get_contents('111.html'); file_put_contents('111.html',$file_data_max);}


		$photo_200 = 0;
		$foto = 0;
		$photo_number = 1;
		$broken_link = [];
		$small_photo = [];
        $wrapper_open = '<span style="white-space: nowrap;">';
        $wrapper_close = '</span>';
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
		echo 'Offer id товара: '.$offer['id'].'.'.'&nbsp;'.' Название товара: '.$offer->name.'&nbsp;'.'<span style="color: #0000ff;">'.$offer->model.'</span>';
		echo '&nbsp;'.'&nbsp;'.'&nbsp;'.'Разрешение фото: '.$picsize[0].' на '.$picsize[1].'&nbsp;';
		echo("<a href='$picture' target='_blank' rel='noopener noreferrer'>$picture</a>").$wrapper_close.'<br>';}; 
  

        // битая ссылка
        if(!$picsize[0])
		{
		$photo_200++;array_push($broken_link, $url_foto);
		echo $wrapper_open.'&nbsp;'.'&nbsp;'.'<span style="color: #4aa7ed; font-weight: bold;">'.'Битая ссылка. '.'</span>';
		echo 'Offer id товара: '.$offer['id'].'.'.'&nbsp;'.' Название товара: '.$offer->name.'&nbsp;'.'<span style="color: #0000ff;">'.$offer->model.'</span>'.'&nbsp;';
		echo("<a href='$url_foto' target='_blank' rel='noopener noreferrer'>$url_foto</a>").$wrapper_close.'<br>';
        }; 
        };
		};
        echo '<br>'.'<span class="numer_of_picture_complete" style="color: #e0157a; font-weight: bold;">'.'Обработано 100% фото. Обработка завершена'.'</span>'.'<br>'.'<br>'; 
        
        // };

        
		if ($photo_200 > 0) {
        echo '<br>'; echo '<span style="color: #4aa7ed; font-weight: bold;">'.'Количество фото, где ссылка битая: '.'</span>'.'<span style="color: red; font-weight: bold;">'.$photo_200.'</span>'.' из '. $count_all_picture.'<br>'; 
        
// вывод списка битых ссылок 
foreach ($broken_link as &$value) {
 echo ("<a href='$value' target='_blank' rel='noopener noreferrer' style='color: #4aa7ed;'>$value</a>").'<br>';
}
        } 
        if ($photo_200 == 0) echo '<br>'.'<span style="color: green;">'.'Все фото загружаются.'.'</span>'.'<br>'.'<br>';
		echo '<br>';
        if ($foto > 0) {
        echo '<br>'; echo '<span style="color: #FFA500; font-weight: bold;">'.'Количество фото, где разрешение ширины или длины фото меньше 300 пикселей: '.'</span>'.'<span style="color: red; font-weight: bold;">'.$foto.'</span>'.' из '. $count_all_picture.'<br>'; 

// вывод списка маленьких фото
foreach ($small_photo as &$value2) {
 echo ("<a href='$value2' target='_blank' rel='noopener noreferrer' style='color: #FFA500;'>$value2</a>").'<br>';
}

        } 
		if ($foto == 0) echo '<span style="color: green;">'.'Нет фото с разрешением ширины или длины меньше 300 пикселей.'.'</span>'.'<br>'.'<br>';

 ?>

     
	<script>
	window.onload = function() {
	    const percentArray = document.querySelectorAll('.percent');
	    percentArray.forEach(percent => percent.remove());
	}
	</script>
		</body>
		</html>
	