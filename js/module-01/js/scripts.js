"use strict";

const adminLogin = "admin";
const adminPassword = "m4ngo1zh4ackz0r";
const cancel = "Отменено пользователем!";
const error = "Доступ запрещен!";
const welcome = "Добро пожаловать!";
let password;
const login = prompt("Введите свой логин");

//Вариант через else if
if (login === null) {
  alert(cancel);
} else if (login !== adminLogin) {
  alert(error);
} else if (login === adminLogin) {
  password = prompt("Введите свой пароль");
  if (password === null) {
    alert(cancel);
  } else if (password !== adminPassword) {
    alert(error);
  } else if (password === adminPassword) {
    alert(welcome);
  }
}

//Вариант через switch
// switch (login) {
//   case null:
//     alert(cancel);
//     break;
//   case adminLogin:
//     password = prompt("Введите свой пароль");

//     switch (password) {
//       case null:
//         alert(cancel);
//         break;
//       case adminPassword:
//         alert(welcome);
//         break;
//       default:
//         alert(error);
//     }
//     break;
//   default:
//     alert(error);
// }

// ДОПОЛНИТЕЛЬНОЕ ЗАДАНИЕ
const sharm = 15;
const hurgada = 25;
const taba = 6;
const number = prompt("Введите число необходимых мест");

if (number % 1 !== 0 || number <= 0) {
  alert("Ошибка ввода");
  //   if ( Number.isNaN( number ) ||
  //   number <=0 ||
  //   !Number.isInteger( number ) ){
  // alert('Ошибка ввода!');
  // }
} else {
  if (number <= taba) {
    const taba_room = confirm(
      "Есть место в taba, согласен ли пользователь быть в этой группе"
    );
    if (taba_room === true) {
      alert("Приятного путешествия в группе taba");
    } else {
      alert("Нам очень жаль, приходите еще!");
    }
  } else if (number >= taba && number <= sharm) {
    const sharm_room = confirm(
      "Есть место в sharm, согласен ли пользователь быть в этой группе"
    );
    if (sharm_room === true) {
      alert("Приятного путешествия в группе sharm");
    } else {
      alert("Нам очень жаль, приходите еще!");
    }
  } else if (number >= sharm && number <= hurgada) {
    const hurgada_room = confirm(
      "Есть место в hurgada, согласен ли пользователь быть в этой группе"
    );
    if (hurgada_room === true) {
      alert("Приятного путешествия в группе hurgada");
    } else {
      alert("Нам очень жаль, приходите еще!");
    }
  } else if (number >= hurgada) {
    alert("Извините, столько мест нет ни в одной группе!");
  }
}
