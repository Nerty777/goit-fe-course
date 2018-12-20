let numberBrokenLinkPhoto = 0;
let numberSmallLinkPhoto = 0;
let numberDownloadedPicture = 0;

// проверка битых ссылок фото
function brokenPictureFunc(url) {
    if (url.width === 1) {
        url.src = 'icon/error404.svg';
        numberBrokenLinkPhoto += 1;
        const brokenPicture = document.querySelector(".brokenPicture");
        brokenPicture.classList.remove("hidden");
        const rootBrokenPhoto = document.createElement("div");
        let linkBrokenPhoto = document.createElement("a");
        const numberBrokenPhoto = document.createElement("span");
        rootBrokenPhoto.style.marginLeft = '5px';
        linkBrokenPhoto.href = url.title;
        linkBrokenPhoto.style.fontSize = '14px';
        if (url.title === ' ') {
            url.title = 'Ссылка не указана.';
            linkBrokenPhoto = document.createElement("span");
        };
        linkBrokenPhoto.textContent = url.title;
        linkBrokenPhoto.target = '_blank';
        numberBrokenPhoto.textContent = numberBrokenLinkPhoto + ') ';
        numberBrokenPhoto.style.margin = '2px';
        rootBrokenPhoto.append(numberBrokenPhoto, linkBrokenPhoto);
        brokenPicture.append(rootBrokenPhoto);
    };
};

// проверка маленьких фото
function smallPictureFunc(url) {
    if (url.width > 1 && url.width < 220) {
        numberSmallLinkPhoto += 1;
        const smallPicture = document.querySelector(".smallPicture");
        smallPicture.classList.remove("hidden");
        const rootSmallPhoto = document.createElement("div");
        const linkSmallPhoto = document.createElement("a");
        const numberSmallPhoto = document.createElement("span");
        const widthSmallPhoto = document.createElement("span");
        widthSmallPhoto.textContent = ' ' + url.width + 'px' + ' на ' + url.height + 'px';
        rootSmallPhoto.style.marginLeft = '5px';
        linkSmallPhoto.href = url.title;
        linkSmallPhoto.style.fontSize = '14px';
        linkSmallPhoto.textContent = url.title;
        linkSmallPhoto.target = '_blank';
        numberSmallPhoto.textContent = numberSmallLinkPhoto + ') ';
        numberSmallPhoto.style.margin = '2px';
        rootSmallPhoto.append(numberSmallPhoto, linkSmallPhoto, widthSmallPhoto);
        smallPicture.append(rootSmallPhoto);
    };
};

// вывод текста "Загрузка всех фото на странице завершена"
function createTextDownloadedAllPicture() {
    const doneLoadAllPhoto = document.createElement("div");
    doneLoadAllPhoto.classList.add('doneLoadAllPhoto');
    doneLoadAllPhoto.textContent = 'Загрузка всех фото на странице завершена.';
    // doneLoadAllPhoto.style.margin = '10px';
    const footer = document.querySelector(".footer");
    footer.append(doneLoadAllPhoto);
}

//показ кнопки проверить фото
function appearanceButtonCheckPhoto() {
    const buttonToPhoto = document.querySelector(".button-to-photo");
    buttonToPhoto.style.display = 'block';
}

// функция запуска функций проверки битых ссылок и маленьких фото
function allPhotoLoadfuncFull() {
    const footer = document.querySelector(".footer");
    const allPhotoLoad = document.querySelector(".allPhotoLoad");
    createTextDownloadedAllPicture();
    if (allPhotoLoad) {
        allPhotoLoad.remove();
    }
    const nodeListAllPhoto = document.querySelectorAll(".picture img");
    nodeListAllPhoto.forEach(url => {
        brokenPictureFunc(url);
        smallPictureFunc(url);
    });
    const spinnerFooter = document.querySelector(".lds-spinner");
    spinnerFooter.classList.add("hidden");
    deleteDownLoadPictureStatus();
    const arrowColor = document.querySelectorAll(".arrowColor");
    arrowColor.forEach(arrow => arrow.style.fill = '#a9fd00');
    appearanceButtonCheckPhoto();
};

// вывод статусбара загрузки количества фото
function downloadPictureStatus() {
    const nodeListAllPhoto = document.querySelectorAll(".picture img");
    const countAllPicture = nodeListAllPhoto.length;
    numberDownloadedPicture += 1;
    const downloadedPhoto = document.querySelector(".downloadedPhoto");
    downloadedPhoto.textContent = numberDownloadedPicture;
    const numberAllPhoto = document.querySelector(".numberAllPhoto");
    numberAllPhoto.textContent = countAllPicture;
}

// удаление статусбара загрузки количества фото
function deleteDownLoadPictureStatus() {
    const wrapperDownloadedPhoto = document.querySelector(".wrapperDownloadedPhoto");
    wrapperDownloadedPhoto.remove();
}

$(function() {
    // при клике на кнопку "Загрузить все фото" загружать все фото
    $('button.allPhotoLoad').click(function() {
        const allPhotoLoad = document.querySelector(".allPhotoLoad");
        if (allPhotoLoad) {
            allPhotoLoad.remove();
        }
        const spinnerFooter = document.querySelector(".lds-spinner");
        spinnerFooter.classList.remove("hidden");

        $('.lazy').lazy({
            bind: "event",
            delay: 0,
            afterLoad: function() {
                downloadPictureStatus();
            },
            onFinishedAll: function() {
                allPhotoLoadfuncFull();
            },
        });
    });

    // если количество фото меньше чем 1000, то загружать все фото
    const nodeListAllPhoto = document.querySelectorAll(".picture img");
    if (nodeListAllPhoto.length <= 1000) {
        $('.lazy').lazy({
            bind: "event",
            delay: 0,
            afterLoad: function() {
                downloadPictureStatus();
            },
            onFinishedAll: function() {
                allPhotoLoadfuncFull();
            },
        });
    }

    // если доскролил до фото 20000px, то загружать это фото
    $('.lazy').Lazy({
        threshold: 20000,
        afterLoad: function() {
            downloadPictureStatus();
        },
        onFinishedAll: function() {
            allPhotoLoadfuncFull();
        },
        combined: true,
    });

});