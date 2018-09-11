"use strict";

let countClickPrev = 9;
let countClickNext = 0;

const galleryItems = [
  {
    preview: "img/preview-1.jpg",
    fullview: "img/fullview-1.jpg",
    alt: "alt text 1"
  },
  {
    preview: "img/preview-2.jpg",
    fullview: "img/fullview-2.jpg",
    alt: "alt text 2"
  },
  {
    preview: "img/preview-3.jpg",
    fullview: "img/fullview-3.jpg",
    alt: "alt text 3"
  },
  {
    preview: "img/preview-4.jpg",
    fullview: "img/fullview-4.jpg",
    alt: "alt text 4"
  },
  {
    preview: "img/preview-5.jpg",
    fullview: "img/fullview-5.jpg",
    alt: "alt text 5"
  },
  {
    preview: "img/preview-6.jpg",
    fullview: "img/fullview-6.jpg",
    alt: "alt text 6"
  },
  {
    preview: "img/preview-7.jpg",
    fullview: "img/fullview-7.jpg",
    alt: "alt text 7"
  },
  {
    preview: "img/preview-8.jpg",
    fullview: "img/fullview-8.jpg",
    alt: "alt text 8"
  }
];

const fullview = document.createElement("div");
fullview.classList.add("fullview");

const fullviewImg = document.createElement("img");
fullviewImg.setAttribute("src", "img/fullview-1.jpg");
fullviewImg.setAttribute("alt", "alt text 1");

const preview = document.createElement("ul");
preview.classList.add("preview");

const array_preview = galleryItems.map(item => {
  const previewItem = document.createElement("li");
  const previewImg = document.createElement("img");
  previewImg.setAttribute("src", `${item.preview}`);
  previewImg.setAttribute("data-fullview", `${item.fullview}`);
  previewImg.setAttribute("alt", `${item.alt}`);

  fullview.append(fullviewImg);
  previewItem.append(previewImg);
  preview.append(previewItem);
  fullview.append(preview);
});

const imageGallery = document.querySelector(".js-image-gallery");
imageGallery.append(fullview, preview);

preview.addEventListener("click", handlePreviewClick);

// Задаю первому элементу коллекции картинок прозрачность 1
preview.firstElementChild.style.opacity = 1;

function handlePreviewClick(event) {
  event.preventDefault();

  const target = event.target;
  // console.log("event target: ", target); // посмотрите что тут

  // Проверяем тип узла, если не картинка выходим из функции
  if (target.nodeName !== "IMG") return;
  setActiveLink(target);

  // всем превью(preview_li) устанавливаем прозрачность 0.3
  const preview_li = target.parentNode.parentNode.children;
  for (let i = 0; i < preview_li.length; i += 1) {
    preview_li[i].style.opacity = 0.3;
  }

  //  таргет-превью прозрачность задаем 1
  target.parentNode.style.opacity = 1;

  // передаем на определения среднего цвета на фото
  imageByTarget(target);
  console.log("target: ", target);
}

// результат работы функции попадет в переменную
function setActiveLink(nextActiveLink) {
  const srcFullview = document.querySelector(".fullview img");
  srcFullview.setAttribute("src", nextActiveLink.dataset.fullview);
  srcFullview.setAttribute("alt", nextActiveLink.alt);
  nextActiveLink.parentNode.style.opacity = 1;
}

// создаю кнопки
const buttonWrapper = document.createElement("div");
buttonWrapper.classList.add("button_wrapper");

const buttonPrev = document.createElement("button");
buttonPrev.classList.add("button_prev");

const buttonNext = document.createElement("button");
buttonNext.classList.add("button_next");
buttonWrapper.append(buttonPrev, buttonNext);
fullview.append(buttonWrapper);

// задаю смещение ul через translateX 0px
preview.style.transform = `translateX(-${0}px)`;

//buttonNext
buttonNext.addEventListener("click", handleButtonNextClick);

function handleButtonNextClick(event) {
  event.preventDefault();
  const target = event.target;
  // Проверяем тип узла, если не кнопка выходим из функции
  if (target.nodeName !== "BUTTON") return;
  let addPictureNext = `<li><img src="img/preview-${countClickNext +
    1}.jpg" data-fullview="img/fullview-${countClickNext +
    1}.jpg" alt="alt text ${countClickNext + 1}"></li>`;
  countClickNext += 1;
  // считаем количество кликов на кнопку Next и если равно количеству фото в массиве galleryItems (countClickNext == galleryItems.length), то обнуляем (countClickNext = 0)
  if (countClickNext == galleryItems.length) {
    countClickNext = 0;
  }
  preview.insertAdjacentHTML("beforeend", addPictureNext);
  setActiveButtonNext(target);
}
function setActiveButtonNext(nextActiveButton) {
  const step = preview.firstElementChild.offsetWidth + 10;
  preview.style.transform += `translateX(-${step}px)`;
}

//buttonPrev
buttonPrev.addEventListener("click", handleButtonPrevClick);
function handleButtonPrevClick(event) {
  event.preventDefault();
  const target = event.target;
  // Проверяем тип узла, если не кнопка выходим из функции
  if (target.nodeName !== "BUTTON") return;
  let addPicturePrev = `<li><img src="img/preview-${countClickPrev -
    1}.jpg" data-fullview="img/fullview-${countClickPrev -
    1}.jpg" alt="alt text ${countClickPrev - 1}"></li>`;
  countClickPrev -= 1;
  // считаем количество кликов на кнопку Prev и если равно 1, то countClickNext = galleryItems.length + 1
  if (countClickPrev == 1) {
    countClickPrev = galleryItems.length + 1;
  }
  preview.insertAdjacentHTML("afterbegin", addPicturePrev);
}

// modal
const modalWindow = document.createElement("div");
modalWindow.classList.add("modalWindow");
modalWindow.classList.add("hidden");

const buttonModalPrev = document.createElement("button");
buttonModalPrev.classList.add("buttonModalPrev");

const buttonModalNext = document.createElement("button");
buttonModalNext.classList.add("buttonModalNext");

const buttonModalClose = document.createElement("button");
buttonModalClose.classList.add("buttonModalClose");

const fullViewModal = document.querySelector(".fullview img");

fullViewModal.addEventListener("click", handleModalClick);

function handleModalClick(event) {
  event.preventDefault();

  const target = event.target;
  if (target.nodeName !== "IMG") return;
  let clone = target.cloneNode(true);

  modalWindow.append(clone, buttonModalPrev, buttonModalNext, buttonModalClose);
  imageGallery.append(modalWindow);
  modalWindow.classList.remove("hidden");
}

/// //////buttonModalClose
buttonModalClose.addEventListener("click", handleModalClose);
function handleModalClose(event) {
  event.preventDefault();
  const target = event.target;
  // Проверяем тип узла, если не кнопка выходим из функции
  if (target.nodeName !== "BUTTON") return;

  modalWindow.classList.add("hidden");
  modalWindow.removeChild(modalWindow.firstElementChild);
}

////////// buttonModalNext
buttonModalNext.addEventListener("click", handleModalNext);
function handleModalNext(event) {
  event.preventDefault();
  const target = event.target;
  // Проверяем тип узла, если не кнопка выходим из функции
  if (target.nodeName !== "BUTTON") return;
  let numberPhoto = modalWindow.firstElementChild.alt.slice(-1);
  numberPhoto = +numberPhoto + 1;
  if (numberPhoto == galleryItems.length + 1) {
    numberPhoto = 1;
  }
  modalWindow.firstElementChild.src = `img/fullview-${numberPhoto}.jpg`;
  modalWindow.firstElementChild.alt = `alt text ${numberPhoto}`;
}

////////// buttonModalPrev
buttonModalPrev.addEventListener("click", handleModalPrev);
function handleModalPrev(event) {
  event.preventDefault();
  const target = event.target;
  // Проверяем тип узла, если не кнопка выходим из функции
  if (target.nodeName !== "BUTTON") return;
  let numberPhoto = modalWindow.firstElementChild.alt.slice(-1);
  numberPhoto = +numberPhoto - 1;
  if (numberPhoto == 0) {
    numberPhoto = galleryItems.length;
  }
  modalWindow.firstElementChild.src = `img/fullview-${numberPhoto}.jpg`;
  modalWindow.firstElementChild.alt = `alt text ${numberPhoto}`;
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Дальше оформительный js, проверять не нужно
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////convert image into base64
function toDataURL(url, callback) {
  var xhr = new XMLHttpRequest();
  xhr.onload = function() {
    var reader = new FileReader();
    reader.onloadend = function() {
      callback(reader.result);
    };
    reader.readAsDataURL(xhr.response);
  };
  xhr.open("GET", url);
  xhr.responseType = "blob";
  xhr.send();
}

let imageByTarget = function getRezult(iimage) {
  toDataURL(iimage.src, function(dataUrl) {
    ///получения среднего цвета изображения
    fullview.firstElementChild.setAttribute("id", "i");

    var rgb = getAverageRGB(iimage);

    document.body.style.backgroundColor =
      "rgb(" + rgb.r + "," + rgb.g + "," + rgb.b + ")";

    function getAverageRGB(imgEl) {
      var blockSize = 5, // only visit every 5 pixels
        defaultRGB = { r: 0, g: 0, b: 0 }, // for non-supporting envs
        canvas = document.createElement("canvas"),
        context = canvas.getContext && canvas.getContext("2d"),
        data,
        width,
        height,
        i = -4,
        length,
        rgb = { r: 0, g: 0, b: 0 },
        count = 0;

      if (!context) {
        return defaultRGB;
      }

      height = canvas.height =
        imgEl.naturalHeight || imgEl.offsetHeight || imgEl.height;
      width = canvas.width =
        imgEl.naturalWidth || imgEl.offsetWidth || imgEl.width;

      context.drawImage(imgEl, 0, 0);

      try {
        data = context.getImageData(0, 0, width, height);
      } catch (e) {
        /* security error, img on diff domain */ alert("x");
        return defaultRGB;
      }

      length = data.data.length;

      while ((i += blockSize * 4) < length) {
        ++count;
        rgb.r += data.data[i];
        rgb.g += data.data[i + 1];
        rgb.b += data.data[i + 2];
      }

      // ~~ used to floor values
      rgb.r = ~~(rgb.r / count);
      rgb.g = ~~(rgb.g / count);
      rgb.b = ~~(rgb.b / count);

      // console.log("rgb: ", rgb);
      return rgb;
    }
  });
};

// определяем цвет фона первого фото
imageByTarget(preview.firstElementChild.firstElementChild);
