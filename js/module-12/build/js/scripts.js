"use strict";

var bookmarksList = [];
var bookmarks = document.querySelector(".bookmarks");
var loader = document.querySelector(".loader");
var modal = document.querySelector(".modal");
var form = document.querySelector(".form");
var source = document.querySelector("#template").innerHTML.trim();
var template = Handlebars.compile(source);
var bookmarksFromLocalStorage = JSON.parse(localStorage.getItem("bookmarks"));

if (bookmarksFromLocalStorage) {
  bookmarksList = bookmarksFromLocalStorage;
  makeMarkup(bookmarksFromLocalStorage);
}

function makeMarkup(array) {
  var markup = array.reduce(function (acc, bookmark) {
    return acc + template(bookmark);
  }, "");
  bookmarks.innerHTML = markup;
}

form.addEventListener("submit", handleButtonAddUrl);

function handleButtonAddUrl(event) {
  event.preventDefault();
  var target = event.target;
  if (target.nodeName !== "FORM") return;
  var formInput = document.querySelector(".form__input");
  var url = formInput.value;
  validateUrl(url);
  form.reset();
}

function validateUrl(url) {
  var pattern = /^(https?:\/\/)?([\da-zа-яё0-9\.:-]+)\.([a-zа-яё\.]{2,6})([\/\w \.\/_|?!%@=&#:-]*)*\/?$/gi;

  if (!pattern.test(url)) {
    modalError("Invalid url", "img/invalid.svg", "invalid url", "2rem");
    return;
  }

  linkpreview(url);
}

function modalError(text, src, alt, sizeIcon) {
  modal.style.top = "50%";
  var errorText = document.querySelector(".modal__text");
  var errorIcon = document.querySelector(".modal__icon");
  errorText.textContent = text;
  errorIcon.setAttribute("src", src);
  errorIcon.setAttribute("alt", alt);
  errorIcon.style.width = sizeIcon;
  errorIcon.style.height = sizeIcon;
  setTimeout(function () {
    modal.style.top = "-100%";
  }, 3000);
}

function removeHidden() {
  bookmarks.style.opacity = 0.3;
  form.style.opacity = 0.3;
  loader.classList.remove("hidden");
}

function addHidden() {
  bookmarks.style.opacity = 1;
  form.style.opacity = 1;
  loader.classList.add("hidden");
}

function linkpreview(url) {
  var key = "5bb920a205cea06f38e7909709a72b521a4a9d1c05841";
  removeHidden();
  fetch("https://api.linkpreview.net/?key=".concat(key, "&q=").concat(url)).then(function (response) {
    if (response.ok) {
      return response.json();
    }

    throw new Error("Error fetching data");
  }).then(function (urlInfo) {
    makeBookmarks(urlInfo);
  }).catch(function (error) {
    if (error.message === "Error fetching data") {
      var pattern = /^(?:https?:\/\/)?(?:[^@\n]+@)?(?:www\.)?([^:\/\n?]+)/gim;
      var host = pattern.exec(url);
      host = host[1];
      var urlInfo = {
        url: url,
        title: host
      };
      makeBookmarks(urlInfo);
    }
  });
} // create bookmark


function makeBookmarks(urlInfo) {
  var double = bookmarksList.filter(function (bookmark) {
    return bookmark.url === urlInfo.url;
  });

  if (double.length) {
    addHidden();
    setTimeout(function () {
      modalError("This url is already set in bookmarks!", "img/copy.svg", "copy url", "5rem");
    }, 100);
    return;
  }

  bookmarksList.unshift(urlInfo);
  makeMarkup(bookmarksList);
  localStorage.setItem("bookmarks", JSON.stringify(bookmarksList));
  addHidden();
} // delete bookmark


var deleteBtn = document.querySelector(".delete");
bookmarks.addEventListener("click", handleButtonDelete);

function handleButtonDelete(event) {
  var target = event.target;
  if (target.nodeName !== "BUTTON") return;
  event.preventDefault();
  var bookmarkItem = target.parentNode;
  var bookmarkItemUrl = bookmarkItem.querySelector(".bookmark__link");
  var urlBookmark = bookmarkItemUrl.textContent;
  var deleteBookmark = bookmarksList.filter(function (bookmark) {
    return bookmark.url !== urlBookmark;
  });
  bookmarksList = deleteBookmark;
  makeMarkup(deleteBookmark);
  localStorage.setItem("bookmarks", JSON.stringify(deleteBookmark));
}