"use strict";

const laptops = [
  {
    size: 13,
    color: "white",
    price: 28000,
    release_date: 2015,
    name: 'Macbook Air White 13"',
    img: "img/air.jpg",
    descr:
      "Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat, beatae."
  },
  {
    size: 13,
    color: "gray",
    price: 32000,
    release_date: 2016,
    name: 'Macbook Air Gray 13"',
    img: "img/air.jpg",
    descr:
      "Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat, beatae."
  },
  {
    size: 13,
    color: "black",
    price: 35000,
    release_date: 2017,
    name: 'Macbook Air Black 13"',
    img: "img/air.jpg",
    descr:
      "Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat, beatae."
  },
  {
    size: 15,
    color: "white",
    price: 45000,
    release_date: 2015,
    name: 'Macbook Air White 15"',
    img: "img/air.jpg",
    descr:
      "Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat, beatae."
  },
  {
    size: 15,
    color: "gray",
    price: 55000,
    release_date: 2016,
    name: 'Macbook Pro Gray 15"',
    img: "img/pro15_silver.jpg",
    descr:
      "Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat, beatae."
  },
  {
    size: 15,
    color: "black",
    price: 45000,
    release_date: 2017,
    name: 'Macbook Pro Black 15"',
    img: "img/pro15_black.jpg",
    descr:
      "Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat, beatae."
  },
  {
    size: 17,
    color: "white",
    price: 65000,
    release_date: 2015,
    name: 'Macbook Air White 17"',
    img: "img/air.jpg",
    descr:
      "Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat, beatae."
  },
  {
    size: 17,
    color: "gray",
    price: 75000,
    release_date: 2016,
    name: 'Macbook Pro Gray 17"',
    img: "img/pro17_silver.jpg",
    descr:
      "Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat, beatae."
  },
  {
    size: 17,
    color: "black",
    price: 80000,
    release_date: 2017,
    name: 'Macbook Pro Black 17"',
    img: "img/pro17_black.jpg",
    descr:
      "Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat, beatae."
  }
];

const offers = document.querySelector(".offers");
const source = document.querySelector("#template").innerHTML.trim();
const template = Handlebars.compile(source);
const markup = laptops.reduce((acc, laptop) => acc + template(laptop), "");
offers.innerHTML = markup;

const filter = {
  size: [],
  color: [],
  releaseDate: []
};

function objFilter(checkedSize, param, parametr) {
  if (checkedSize.length) {
    checkedSize.forEach(item => {
      const value = item.value;
      param.push(value);
      filter[parametr] = param;
    });
  } else {
    filter[parametr] = [];
  }
}

const makeFilter = e => {
  const target = e.target;
  if (target.nodeName !== "INPUT") return;
  const checkedSize = document.querySelectorAll("[name = size]:checked");
  const checkedColor = document.querySelectorAll("[name = color]:checked");
  const checkedReleaseDate = document.querySelectorAll(
    "[name = release_date]:checked"
  );
  const size = [];
  const color = [];
  const releaseDate = [];
  objFilter(checkedSize, size, "size");
  objFilter(checkedColor, color, "color");
  objFilter(checkedReleaseDate, releaseDate, "releaseDate");
  getFilteredCards(filter);
};

function getFilteredCards(filter) {
  const resultFilter = function(laptops, filter) {
    let filteredLaptops = laptops;
    function filterLaptops(param, keyLaptop) {
      if (filter[param].length) {
        filteredLaptops = filteredLaptops.filter(laptop =>
          filter[param].includes(String(laptop[keyLaptop]))
        );
      }
    }
    filterLaptops("size", "size");
    filterLaptops("color", "color");
    filterLaptops("releaseDate", "release_date");
    const markup = filteredLaptops.reduce(
      (acc, laptop) => acc + template(laptop),
      ""
    );
    offers.innerHTML = markup;
    if (!filteredLaptops.length) {
      offers.innerHTML =
        '<p class="error">Sorry, but your choiced filter not found laptops</p>';
    }
  };
  resultFilter(laptops, filter);
}

function clearButton(e) {
  const target = e.target;
  if (target.nodeName !== "BUTTON") return;
  const markup = laptops.reduce((acc, laptop) => acc + template(laptop), "");
  offers.innerHTML = markup;
}

const form = document.querySelector(".js-form");
form.addEventListener("click", makeFilter);

const button = document.querySelector(".button_submit");
button.addEventListener("click", clearButton);

// анимация карандаша START
document.addEventListener("DOMContentLoaded", function() {
  var q = document.querySelectorAll(".cb");
  for (var i in q) {
    if (+i < q.length) {
      q[i].addEventListener("click", function() {
        let c = this.classList,
          p = "pristine";
        if (c.contains(p)) {
          c.remove(p);
        }
      });
    }
  }
});
// анимация карандаша STOP
