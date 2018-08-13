"use strict";
const logins = ["Mango", "robotGoogles", "Poly", "Aj4x1sBozz", "qwerty123"];
let allLogins = logins;
let success = 0;

const isLoginValid = login => {
  return login.length >= 4 && login.length <= 16;
};

const isLoginUnique = (login, allLogins = logins) => {
  return allLogins.includes(login);
};

const addLogin = function(login, allLogins = logins) {
  if (!isLoginValid(login)) {
    return alert(
      `Ошибка! Логин должен быть от 4 до 16 символов. Вы ввели ${
        login.length
      } указав логин ${login}`
    );
  }
  if (isLoginUnique(login, allLogins)) {
    return alert(`Логин ${login} уже используется!`);
  }
  logins.push(login);
  success = 1;
  return alert(`Логин ${login} успешно добавлен!`);
};

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

  addLogin(login, allLogins);
} while (success === 0);

// Вызовы функции для проверки
addLogin("Ajax"); // 'Логин успешно добавлен!'
addLogin("robotGoogles"); // 'Такой логин уже используется!'
addLogin("Zod"); // 'Ошибка! Логин должен быть от 4 до 16 символов'
addLogin("jqueryisextremelyfast"); // 'Ошибка! Логин должен быть от 4 до 16 символов'
