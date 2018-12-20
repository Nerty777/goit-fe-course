const body = document.querySelector("body");
const themeButton = document.querySelector(".themebutton");

themeButton.addEventListener("click", handleButtonTheme);

theme = JSON.parse(localStorage.getItem("theme"));
if(theme){
    handleButtonTheme();
}

function handleButtonTheme(event) {
if(event){event.preventDefault()};
const nameColorLink = document.querySelectorAll(".name-color_link");
if(theme === "dark"){
themeButton.style.background = 'url("./icon/whiteThemeSun.svg") no-repeat center';
body.style.background = "#201C2B";
body.style.color = "#b8b5c0";
percentElem = document.querySelectorAll('.percent');
percentElem.forEach(item => item.style.background = '#201C2B');
localStorage.setItem( "theme", JSON.stringify(theme) ); 
theme = "white";
} else {
themeButton.style.background = 'url("./icon/darkThemeMoon.svg") no-repeat center';
body.style.backgroundColor = "#ffffff";
body.style.color = "#000000";
percentElem = document.querySelectorAll('.percent');
percentElem.forEach(item => item.style.background = '#ffffff');
localStorage.setItem( "theme", JSON.stringify(theme) ); 
theme = "dark";
};
};
