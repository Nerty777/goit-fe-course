"use strict";
const logins = ["Mango", "robotGoogles", "Poly", "Aj4x1sBozz", "qwerty123"];

const isLoginValid = login => {
  return login.length >= 4 && login.length <= 16;
};

const isLoginUnique = (login, logins) => {
  return logins.includes(login);
};

const addLogin = function(login, logins) {
  if (!isLoginValid(login)) {
    return alert("Ошибка! Логин должен быть от 4 до 16 символов.");
  }
  if (isLoginUnique(login, logins)) {
    return alert(`Логин ${login} уже используется!`);
  }
  logins.push(login);
  alert(`Логин ${login} успешно добавлен!`);
  return true;
};

do {
  let login = prompt("Введите логин");

  if (login === null) {
    alert("Отменено пользователем");
    break;
  }

  if (addLogin(login, logins)) {
    break;
  }
} while (true);
