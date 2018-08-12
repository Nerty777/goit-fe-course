"use strict";
const logins = ["Mango", "robotGoogles", "Poly", "Aj4x1sBozz", "qwerty123"];
let allLogins = logins;

do {
  let login = prompt("Введите логин");

  if (login === null) {
    alert("Отменено пользователем");
    break;
  }

  if (+login === 0 && login !== "0") {
    alert("Не был введен логин, попробуйте еще раз");
    continue;
  }

  const isLoginValid = function(login) {
    if (login.length >= 4 && login.length <= 16) {
      return true;
    }
    return false;
  };

  const isLoginUnique = function(login, allLogins = logins) {
    if (allLogins.includes(login)) {
      return false;
    }
    return true;
  };

  const addLogin = function(login, allLogins = logins) {
    if (isLoginValid(login) === false) {
      return console.log(
        `Ошибка! Логин должен быть от 4 до 16 символов. Вы ввели ${
          login.length
        } указав логин ${login}`
      );
    }
    if (isLoginUnique(login, allLogins) === false) {
      return console.log(`Логин ${login} уже используется!`);
    }
    logins.push(login);
    return console.log(`Логин ${login} успешно добавлен!`);
  };

  addLogin(login, allLogins);

  // Вызовы функции для проверки
  addLogin("Ajax"); // 'Логин успешно добавлен!'
  addLogin("robotGoogles"); // 'Такой логин уже используется!'
  addLogin("Zod"); // 'Ошибка! Логин должен быть от 4 до 16 символов'
  addLogin("jqueryisextremelyfast"); // 'Ошибка! Логин должен быть от 4 до 16 символов'
} while (true);
