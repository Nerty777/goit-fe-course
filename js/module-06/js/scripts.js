"use strict";

class Hamburger {
  constructor(size, stuffing) {
    this._size = size;
    this._stuffing = stuffing;
    this._toppings = [];
  }

  get size() {
    return this._size;
  }

  get stuffing() {
    return this._stuffing;
  }

  get toppings() {
    return this._toppings;
  }

  get price() {
    return this._price;
  }

  get calories() {
    return this._calories;
  }

  addTopping(topping) {
    return this._toppings.includes(topping)
      ? this._toppings
      : (this._toppings = this._toppings.concat(topping));
  }
  removeTopping(topping) {
    return this._toppings.includes(topping)
      ? (this._toppings = this._toppings.filter(num => num !== topping))
      : this._toppings;
  }
  getToppings() {
    return this._toppings;
  }
  getSize() {
    return this._size;
  }
  getStuffing() {
    return this._stuffing;
  }
  calculatePrice() {
    this._price =
      Hamburger.SIZES[this.size].price +
      Hamburger.STUFFINGS[this.stuffing].price +
      this.toppings.reduce(
        (acc, topping_from_array_this_toppings) =>
          Hamburger.TOPPINGS[topping_from_array_this_toppings].price + acc,
        0
      );
    return this._price;
  }
  calculateCalories() {
    this._calories =
      Hamburger.SIZES[this.size].calories +
      Hamburger.STUFFINGS[this.stuffing].calories +
      this.toppings.reduce(
        (acc, topping_from_array_this_toppings) =>
          Hamburger.TOPPINGS[topping_from_array_this_toppings].calories +
          acc,
        0
      );
    return this._calories;
  }
}

Hamburger.SIZE_SMALL = "SIZE_SMALL";
Hamburger.SIZE_LARGE = "SIZE_LARGE";

Hamburger.SIZES = {
  [Hamburger.SIZE_SMALL]: {
    price: 30,
    calories: 50
  },

  [Hamburger.SIZE_LARGE]: {
    price: 50,
    calories: 100
  }
};

Hamburger.STUFFING_CHEESE = "STUFFING_CHEESE";
Hamburger.STUFFING_SALAD = "STUFFING_SALAD";
Hamburger.STUFFING_MEAT = "STUFFING_MEAT";

Hamburger.STUFFINGS = {
  [Hamburger.STUFFING_CHEESE]: {
    price: 15,
    calories: 20
  },

  [Hamburger.STUFFING_SALAD]: {
    price: 20,
    calories: 5
  },

  [Hamburger.STUFFING_MEAT]: {
    price: 35,
    calories: 15
  }
};

Hamburger.TOPPING_SPICE = "TOPPING_SPICE";
Hamburger.TOPPING_SAUCE = "TOPPING_SAUCE";

Hamburger.TOPPINGS = {
  [Hamburger.TOPPING_SPICE]: {
    price: 10,
    calories: 0
  },

  [Hamburger.TOPPING_SAUCE]: {
    price: 15,
    calories: 5
  }
};

// Маленький гамбургер с начинкой из сыра
// const hamburger = new Hamburger(Hamburger.SIZE_SMALL, Hamburger.STUFFING_CHEESE);
const hamburger = new Hamburger(Hamburger.SIZE_LARGE, Hamburger.STUFFING_MEAT);

// Добавка из приправы
hamburger.addTopping(Hamburger.TOPPING_SPICE);

// Спросим сколько там калорий
console.log("Calories: ", hamburger.calculateCalories());

// Сколько стоит?
console.log("Price: ", hamburger.calculatePrice());

// Я тут передумал и решил добавить еще соус
hamburger.addTopping(Hamburger.TOPPING_SAUCE);

// А сколько теперь стоит?
console.log("Price with sauce: ", hamburger.calculatePrice());

// Проверить, большой ли гамбургер?
console.log(
  "Is hamburger large: ",
  hamburger.getSize() === Hamburger.SIZE_LARGE
); // -> false

// Убрать добавку
hamburger.removeTopping(Hamburger.TOPPING_SPICE);

// Смотрим сколько добавок
console.log("Hamburger has %d toppings", hamburger.getToppings().length); // 1
