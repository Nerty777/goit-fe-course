<!DOCTYPE html>
    <html lang="ru">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content=" проверка xml yml, xml в яндекс формате, маркетплейс">
    <link rel="shortcut icon" href="./favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/main.css">
    <title>New Year!</title>
    
    <style>
body {
	background: #ffffff;
}

::placeholder {
    color: #96cff7;
    opacity: 1; /* Firefox */
}

#particles-js {
	padding: 0;
	margin: 0;
	width: auto;
	height: 99.4vh;
	/*height: 100vh;*/
	background: linear-gradient(5deg, #fff, #e4f0fc);
}

span:first-letter {
	color: red;
	/* Красный цвет первой буквы */
}

p,
a {
	font-size: 14px;
	line-height: 1.5;
}

.wrapper-index {
	width: 100%;
	position: absolute;
	top: 50%;
	left: 50%;
	transform: translate(-50%, -50%);
	z-index: 5;
}

.index_input {
	display: block;
	width: 50%;
	max-width: 702px;
	min-width: 250px;
	height: 35px;
	border: 2px solid #96cff7;
	margin-right: 5px;
	margin-left: 5px;
	margin-bottom: 29px;
	margin-top: 150px;
	font-size: 15px;
	background-color: transparent;
	padding-left: 5px;
}

.index_input:focus,
.index_input:active {
	outline: none;
	background-color: transparent;
}

.index_input:hover {
	background-color: transparent;
}

.index_input:-webkit-autofill {
	box-shadow: 0 0 0 30px #edf5fd inset;
}

.download,
.clear {
	padding: 7px 46px;
	background-color: transparent;
	color: #96cff7;
	border: 2px solid #96cff7;
	font-family: arial;
	font-size: 16px;
	margin-left: 0px;
	border-radius: 24px;
}

.download:hover,
.clear:hover,
.download:focus,
.clear:focus {
	background-color: #bbdefb;
	color: #ffffff;
	border: 2px solid #bbdefb;
	cursor: pointer;
	outline: none;
}


/*видеобекграунд START*/

.bg-video {
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	z-index: -1;
	overflow: hidden
}

.bg-video__content {
	width: 100%;
	height: 100%;
	object-fit: cover;
}


/*видеобекграунд END*/


/*=============DARK THEME START====================*/


/*body {*/
/*         background: #17141F;*/
/*         color: #b8b5c0;*/
/*}*/
      
/*     #particles-js {*/
/*         background: #17141F;*/
/*         color: #b8b5c0;*/
/*     } */
     
/*.download:hover,*/
/*.clear:hover,*/
/*.download:focus,*/
/*.clear:focus {*/
/*	background-color: #4aa7ed;*/
/*	color: #ffffff;*/
/*	border: 2px solid #4aa7ed;*/
/*}*/

/*.index_input:-webkit-autofill {*/
/*	box-shadow: 0 0 0 30px #392E5C inset;*/
/*}*/

/*.index_input, .index_input:focus {*/
/*	color: #ffffff !important;   */
/*}*/
     
/*=============DARK THEME END====================*/
    </style> 
    
  </head>
  <body>
    <?php
    // подключаю гугл аналитику
      ?>
      
    
    
<?php
$ip_user = getenv('HTTP_CLIENT_IP')?:
getenv('HTTP_X_FORWARDED_FOR')?:
getenv('HTTP_X_FORWARDED')?:
getenv('HTTP_FORWARDED_FOR')?:
getenv('HTTP_FORWARDED')?:
getenv('REMOTE_ADDR');
?>

<?php  
// $igor_ip = "88.81.226.126";
$igor_ip = "88.81.226.1265";
$me_ip = "95.164.82.34";
?>


<?php  
if($ip_user == $igor_ip) {
?>
<!--видеобекграунд START-->
      <div class="bg-video">
      <!--<video class="bg-video__content" autoplay="autoplay" loop="loop" muted="muted">-->
          <video class="bg-video__content" autoplay="autoplay"  muted="muted">
        <source src="Code - 14214.mp4" type="video/mp4"/>
      </video>
    </div>
<!--видеобекграунд END-->
<?php
}
?>
<?php  
if($ip_user !== $igor_ip) {
?>
    <div id="particles-js"></div>
<?php
}
?>  
    
    <div class="wrapper-index">
        

<?php  
if($ip_user !== $igor_ip) {
?>     
<main>
      <center>
        <form action="action.php" method="post" id="form">
            <label for="url" style="display: none;">xml validator</label>
          <input class="index_input" id="url" type="text" name="url" placeholder="Введите ссылку на xml файл и нажмите Загрузить"
            autofocus>
          <br>
          <br>
          <div>
          <input class="download" style="cursor:pointer;" type="submit" name="submit" value="Загрузить"
            />
          <span>&emsp;&emsp;</span>
          <!--<input class="clear" style="cursor:pointer; webkit-appearance: none;" type="reset" value="Очистить" onclick="form.reset()">-->
           <input class="clear" style="cursor:pointer;" type="reset" value="Очистить" onclick="form.reset()">
          </div>
        </form>
      </center>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br> 
      <br>
      <br>
      </main>
      <footer>
      <center>
<br>
<a href="https://195.16.88.10/~xml104/" target="_blank" rel="noopener noreferrer">Основной сайт</a>

        <div>2017-2018, All rights reserved &copy;</div>
        <a href="mailto:nerty777@gmail.com">nerty777 собачка gmail.com</a>
      </center>
      <a href="#" title="Сменить тему" class="themebutton"></a>
      </footer>
<?php
}
?>
</div>
<script src="particles.js"></script>
<script src="app.js"></script>

<!--очистка формы-->
<script>form.reset();</script>

<script>
const body = document.querySelector("body");
const themeButton = document.querySelector(".themebutton");
const particlesJs = document.querySelector("#particles-js");
const indexInput = document.querySelector(".index_input");

themeButton.addEventListener("click", handleButtonTheme);

let theme = 'white';
theme = JSON.parse(localStorage.getItem("theme"));
if(theme){
    handleButtonTheme();
} else {
    theme = 'white';
    handleButtonTheme();
}

function handleButtonTheme(event) {
if(event){event.preventDefault()};

if(theme === "dark"){
    indexInput.style.color = "#ffffff";
    
document.querySelector(".index_input").onmouseover = function() 
{
    this.style.color = "#ffffff";
}

document.querySelector(".index_input").onblur = function() 
{
    this.style.background = "transparent";
}
    
document.querySelector(".download").onmouseover = function() 
{
    this.style.background = "#4aa7ed";
    this.style.color = "#ffffff";
    this.style.border = "2px solid #4aa7ed"
}

document.querySelector(".clear").onmouseover = function() 
{
    this.style.background = "#4aa7ed";
    this.style.color = "#ffffff";
    this.style.border = "2px solid #4aa7ed"
}

document.querySelector(".download").onmouseout = function() 
{
    this.style.background = "transparent";
    this.style.color = "#96cff7";
    this.style.border = "2px solid #96cff7"
}

document.querySelector(".clear").onmouseout = function() 
{
    this.style.background = "transparent";
    this.style.color = "#96cff7";
    this.style.border = "2px solid #96cff7"
}
    
themeButton.style.background = 'url("./../icon/whiteThemeSun.svg") no-repeat center';
body.style.background = "#201C2B";
body.style.color = "#b8b5c0";
particlesJs.style.background = "#201C2B";
particlesJs.style.color = "#b8b5c0";
localStorage.setItem( "theme", JSON.stringify(theme) ); 
theme = "white";
} else {
    
indexInput.style.background = "transparent";
indexInput.style.color = "#000000";
    
document.querySelector(".index_input").onmouseover = function() 
{
    this.style.background = "transparent";
    this.style.color = "#000000";
}

document.querySelector(".index_input").onfocus = function() 
{
    this.style.background = "transparent";
}

document.querySelector(".index_input").onblur = function() 
{
    this.style.background = "transparent";
}

document.querySelector(".download").onmouseover = function() 
{
    this.style.background = "#bbdefb";
    this.style.color = "#ffffff";
    this.style.border = "2px solid #bbdefb"
}

document.querySelector(".clear").onmouseover = function() 
{
    this.style.background = "#bbdefb";
    this.style.color = "#ffffff";
    this.style.border = "2px solid #bbdefb"
}      
    
document.querySelector(".download").onmouseout = function() 
{
    this.style.background = "transparent";
    this.style.color = "#96cff7";
    this.style.border = "2px solid #96cff7"
}

document.querySelector(".clear").onmouseout = function() 
{
    this.style.background = "transparent";
    this.style.color = "#96cff7";
    this.style.border = "2px solid #96cff7"
}

themeButton.style.background = 'url("./../icon/darkThemeMoon.svg") no-repeat center';
body.style.background = "#ffffff";
body.style.color = "#000000"; 
particlesJs.style.background = "linear-gradient(5deg, #fff, #e4f0fc)";
localStorage.setItem( "theme", JSON.stringify(theme) ); 
theme = "dark";
};
};

function changeBackgroundColor(color, ...array) {
    array.forEach(elem => elem.style.backgroundColor = color);
};

function changeColor(color, ...array) {
    array.forEach(elem => elem.style.color = color);
};

function changeBackground(color, ...array) {
    array.forEach(elem => elem.style.background = color);
};

function changeBorderColor(color, ...array) {
    array.forEach(elem => elem.style.borderColor = color);
};
    
</script>

  </body>
</html>