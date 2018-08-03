"use strict";

let userInput;
const numbers = [];
let total = 0;

do {
  userInput = prompt("Введите число");

  if (userInput === null) {
    break;
  } else if (Number.isNaN(Number(userInput))) {
    alert("Было введено не число, попробуйте еще раз");
  } else if (true) {
    userInput = Number(userInput);
    numbers.push(userInput);
  }
} while (true);

for (const value of numbers) {
  total += Number(value);
}

alert(`Общая сумма чисел равна ${total}`);

//ДОПОЛНИТЕЛЬНОЕ ЗАДАНИЕ
const passwords = ["qwerty", "111qwe", "123123", "r4nd0mp4zzw0rd"];
let attempts = 3;
let cancel = 0;

do {
  const userPassword = prompt("Введите пароль");
  if (userPassword === null) {
    alert("Прервано пользователем");
    break;
  }
  if (userPassword !== null) {
    for (const item of passwords) {
      if (userPassword === item && attempts <= 3) {
        alert("Добро пожаловать!");
        cancel = 1;
        break;
      } else if (userPassword !== item) {
        attempts -= 1;
        if (attempts === 0) {
          break;
        }
        alert(`Неверный пароль, у вас осталось ${attempts} попыток`);
        break;
      }
    }
  }
  if (attempts === 0) {
    alert("У вас закончились попытки, аккаунт заблокирован!");
    break;
  }
  if (cancel === 1) {
    break;
  }
} while (true);
