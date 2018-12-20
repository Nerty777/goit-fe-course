const body = document.querySelector("body");
const card = document.querySelectorAll(".card");
const wrapperBody = document.querySelectorAll(".wrapper-body");
const demandsXmlWrapper = document.querySelector(".demandsxml-wrapper");
const wrapperSpoiler = document.querySelector(".wrapper-spoiler");
const resultWrapper = document.querySelector(".result-wrapper");
const wrapperPicture = document.querySelectorAll(".wrapper-picture");
const bodyCategory = document.querySelectorAll(".body-category");
const themeButton = document.querySelector(".themebutton");

const category = document.querySelectorAll(".category");
const name = document.querySelectorAll(".name");
const vendor = document.querySelectorAll(".vendor");
const price = document.querySelectorAll(".price");
const available = document.querySelectorAll(".available");
const stock_quantity = document.querySelectorAll(".stock_quantity");
const offer_id = document.querySelectorAll(".offer_id");
const number = document.querySelectorAll(".number");
const attention = document.querySelectorAll(".attention");
const attentionNotLink = document.querySelectorAll(".attention-not-link");

const links = document.querySelectorAll(".links");
const description = document.querySelectorAll(".description");
const picture = document.querySelectorAll(".picture");
const footer = document.querySelector(".footer");
const linkWordlink = document.querySelectorAll(".linkwordlink");
const spoilerBody = document.querySelectorAll(".spoiler_body");
const spoilerBodyList = document.querySelectorAll(".spoiler_body-list");
const paramName = document.querySelectorAll(".param_name");

themeButton.addEventListener("click", handleButtonTheme);

theme = JSON.parse(localStorage.getItem("theme"));
if(theme){
    handleButtonTheme();
}

function handleButtonTheme(event) {
if(event){event.preventDefault()};
const nameColorLink = document.querySelectorAll(".name-color_link");
    
if(theme === "dark"){
themeButton.style.background = 'url("./../~xml104/icon/whiteThemeSun.svg") no-repeat center';
body.style.background = "#17141F";
body.style.color = "#b8b5c0";
changeBackground("#392E5C", ...bodyCategory,...description, ...picture, ...spoilerBodyList, ...spoilerBody);
changeBackground("#201C2B", ...card, ...wrapperBody, demandsXmlWrapper, wrapperSpoiler, resultWrapper, ...wrapperPicture);
changeBorderColor("#392E5C", ...card, ...wrapperBody, demandsXmlWrapper, wrapperSpoiler, resultWrapper, ...wrapperPicture);


// changeBackground("#201C2B", ...card, ...wrapperBody, wrapperSpoiler, resultWrapper, ...wrapperPicture);
// changeBorderColor("#392E5C", ...card, ...wrapperBody, wrapperSpoiler, resultWrapper, ...wrapperPicture);

changeBackground("#201C2B", ...category, ...name, ...vendor, ...price, ...available, ...stock_quantity, ...offer_id, ...number, ...attention, ...links, footer , ...linkWordlink);
changeBorderColor("#392E5C", ...category, ...name, ...vendor, ...price, ...available, ...stock_quantity, ...offer_id, ...number, ...attention, ...links, footer , ...linkWordlink);
changeColor("#b8b5c0", ...nameColorLink);
changeColor("#b19dd8", ...paramName);
localStorage.setItem( "theme", JSON.stringify(theme) ); 
theme = "white";
} else {
themeButton.style.background = 'url("./../~xml104/icon/darkThemeMoon.svg") no-repeat center';
body.style.backgroundColor = "#f7f7f7";
body.style.color = "#000000"; 
changeBackground("#ffffff", ...card, ...wrapperBody, demandsXmlWrapper, wrapperSpoiler, resultWrapper, ...wrapperPicture, ...category, ...name, ...vendor, ...price, ...available, ...stock_quantity, ...offer_id, ...number, ...attention, ...links, ...linkWordlink);
changeBorderColor("#f7f7f7", ...card, ...wrapperBody, demandsXmlWrapper, wrapperSpoiler, resultWrapper, ...wrapperPicture, ...bodyCategory);


// changeBackground("#ffffff", ...card, ...wrapperBody, wrapperSpoiler, resultWrapper, ...wrapperPicture, ...category, ...name, ...vendor, ...price, ...available, ...stock_quantity, ...offer_id, ...number, ...attention, ...links, ...linkWordlink);
// changeBorderColor("#f7f7f7", ...card, ...wrapperBody, wrapperSpoiler, resultWrapper, ...wrapperPicture, ...bodyCategory);

if(attentionNotLink) {
    changeBorderColor("#f7f7f7", ...attentionNotLink);
}

changeBackgroundColor("#f7f7f7", ...bodyCategory, ...description, ...picture);
changeBackground("#f7f7f7", ...spoilerBody, ...spoilerBodyList);
footer.style.backgroundColor = "#bbdefb";
changeColor("#000000", ...nameColorLink, ...paramName);
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

