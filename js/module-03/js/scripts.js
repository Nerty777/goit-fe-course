"use strict";
const logins = ["Mango", "robotGoogles", "Poly", "Aj4x1sBozz", "qwerty123"];

const isLoginValid = login => login.length >= 4 && login.length <= 16;

const isLoginUnique = (login, logins) => logins.includes(login);

const addLogin = function(login, logins) {
  if (!isLoginValid(login)) {
    alert(`Ошибка! Логин ${login} должен быть от 4 до 16 символов.`);
    return;
  }
  if (isLoginUnique(login, logins)) {
    alert(`Логин ${login} уже используется!`);
    return;
  }
  logins.push(login);
  alert(`Логин ${login} успешно добавлен!`);
  return true;
};

// Вызовы функции для проверки
addLogin("Ajax", logins); // 'Логин успешно добавлен!'
addLogin("robotGoogles", logins); // 'Такой логин уже используется!'
addLogin("Zod", logins); // 'Ошибка! Логин должен быть от 4 до 16 символов'
addLogin("jqueryisextremelyfast", logins); // 'Ошибка! Логин должен быть от 4 до 16 символов'
