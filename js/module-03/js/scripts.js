"use strict";
const logins = ["Mango", "robotGoogles", "Poly", "Aj4x1sBozz", "qwerty123"];
let allLogins = logins;
let success = 0;
const symbol = "символ";
const symbol2 = "символа";
const symbol3 = "символов";

const isLoginValid = login => {
  return login.length >= 4 && login.length <= 16;
};

// функция склонение существительных с числительными для вывода правильного окончания "символ" или "символа" или "символов"
const pluralForm = function(login, symbol, symbol2, symbol3) {
  let length = login.length;
  length = length % 100;
  const $n1 = length % 10;
  if (length > 10 && length < 20) return symbol3;
  if ($n1 > 1 && $n1 < 5) return symbol2;
  if ($n1 == 1) return symbol;
  return symbol3;
};

const isLoginUnique = (login, allLogins = logins) => {
  return allLogins.includes(login);
};

const addLogin = function(login, allLogins = logins) {
  if (!isLoginValid(login)) {
    const theend = pluralForm(login, symbol, symbol2, symbol3);
    return alert(
      `Ошибка! Логин должен быть от 4 до 16 символов. Вы ввели ${
        login.length
      } ${theend} указав логин ${login}`
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
