"use strict";

const users = [
  {
    id: "701b29c3-b35d-4cf1-a5f6-8b12b29a5081",
    name: "Moore Hensley",
    email: "moorehensley@indexia.com",
    eyeColor: "blue",
    phone: "+1 (848) 556-2344",
    friends: ["Sharron Pace"],
    isActive: false,
    balance: 2811,
    skills: ["ipsum", "lorem"],
    gender: "male",
    age: 37
  },
  {
    id: "7a3cbd18-57a1-4534-8e12-1caad921bda1",
    name: "Sharlene Bush",
    email: "sharlenebush@tubesys.com",
    eyeColor: "blue",
    phone: "+1 (855) 582-2464",
    friends: ["Briana Decker", "Sharron Pace"],
    isActive: true,
    balance: 3821,
    skills: ["tempor", "mollit", "commodo", "veniam", "laborum"],
    gender: "female",
    age: 34
  },
  {
    id: "88beb2f3-e4c2-49f3-a0a0-ecf957a95af3",
    name: "Ross Vazquez",
    email: "rossvazquez@xinware.com",
    eyeColor: "green",
    phone: "+1 (814) 593-3825",
    friends: ["Marilyn Mcintosh", "Padilla Garrison", "Naomi Buckner"],
    isActive: false,
    balance: 3793,
    skills: ["nulla", "anim", "proident", "ipsum", "elit"],
    gender: "male",
    age: 24
  },
  {
    id: "249b6175-5c30-44c6-b154-f120923736f5",
    name: "Elma Head",
    email: "elmahead@omatom.com",
    eyeColor: "green",
    phone: "+1 (909) 547-2687",
    friends: ["Goldie Gentry", "Aisha Tran"],
    isActive: true,
    balance: 2278,
    skills: ["adipisicing", "irure", "velit"],
    gender: "female",
    age: 21
  },
  {
    id: "334f8cb3-eb04-45e6-abf4-4935dd439b70",
    name: "Carey Barr",
    email: "careybarr@nurali.com",
    eyeColor: "blue",
    phone: "+1 (956) 512-2693",
    friends: ["Jordan Sampson", "Eddie Strong"],
    isActive: true,
    balance: 3951,
    skills: ["ex", "culpa", "nostrud"],
    gender: "male",
    age: 27
  },
  {
    guid: "150b00fb-dd82-427d-9faf-2879ea87c695",
    name: "Blackburn Dotson",
    email: "blackburndotson@furnigeer.com",
    eyeColor: "brown",
    phone: "+1 (876) 411-2433",
    friends: ["Jacklyn Lucas", "Linda Chapman"],
    isActive: false,
    balance: 1498,
    skills: ["non", "amet", "ipsum"],
    gender: "male",
    age: 38
  },
  {
    id: "e1bf46ab-7168-491e-925e-f01e21394812",
    name: "Sheree Anthony",
    email: "shereeanthony@kog.com",
    eyeColor: "brown",
    phone: "+1 (979) 504-2554",
    friends: ["Goldie Gentry", "Briana Decker"],
    isActive: true,
    balance: 2764,
    skills: ["lorem", "veniam", "culpa"],
    gender: "female",
    age: 39
  }
];
// *********************************************************************************************************************
// Задание 5.1
// *********************************************************************************************************************
/**
 * Получить массив имен (поле name) всех пользователей
 */
const getAllNames = arr => {
  return arr.map(num => num.name);
};
console.log("массив имен (поле name) всех пользователей", getAllNames(users));
// [ 'Moore Hensley', 'Sharlene Bush', 'Ross Vazquez', 'Elma Head', 'Carey Barr', 'Blackburn Dotson', 'Sheree Anthony' ]
// *********************************************************************************************************************
// Задание 5.2
// *********************************************************************************************************************
/**
 * Получить массив объектов пользователей по цвету глаз (поле eyeColor)
 */
const getUsersByEyeColor = (arr, color) => {
  return arr.filter(num => num.eyeColor === color);
};
console.log(
  "массив объектов пользователей по цвету глаз (поле eyeColor)",
  getUsersByEyeColor(users, "blue")
); // [объект Moore Hensley, объект Sharlene Bush, объект Carey Barr]
// *********************************************************************************************************************
// Задание 5.3
// *********************************************************************************************************************
/**
 * Получить массив имен пользователей по полу (поле gender)
 */
const getUsersByGender = (arr, gender) => {
  return arr.filter(num => num.gender === gender).map(num => num.name);
};
console.log(
  "массив имен пользователей по полу (поле gender)",
  getUsersByGender(users, "male")
); // [ 'Moore Hensley', 'Ross Vazquez', 'Carey Barr', 'Blackburn Dotson' ]
// *********************************************************************************************************************
// Задание 5.4
// *********************************************************************************************************************
/**
 * Получить массив только неактивных пользователей (поле isActive)
 */
const getInactiveUsers = arr => {
  return arr.filter(num => num.isActive === false);
};
console.log(
  "массив только неактивных пользователей (поле isActive)",
  getInactiveUsers(users)
); // [объект Moore Hensley, объект Ross Vazquez, объект Blackburn Dotson]
// *********************************************************************************************************************
// Задание 5.5
// *********************************************************************************************************************
/**
 * Получить пользоваля (не массив) по email (поле email, он уникальный)
 */
const getUserByEmail = (arr, email) => {
  return arr.find(num => num.email === email);
};
console.log(
  "пользователь (не массив) по email (поле email, он уникальный)",
  getUserByEmail(users, "shereeanthony@kog.com")
); // {объект пользователя Sheree Anthony}
console.log(
  "пользователь (не массив) по email (поле email, он уникальный)",
  getUserByEmail(users, "elmahead@omatom.com")
); // {объект пользователя Elma Head}
// *********************************************************************************************************************
// Задание 5.6
// *********************************************************************************************************************
/**
 * Получить массив пользователей попадающих в возрастную категорию от min до max лет (поле age)
 */
const getUsersWithAge = (arr, min, max) => {
  return arr.filter(num => num.age > min && num.age < max);
};
console.log(
  "массив пользователей попадающих в возрастную категорию от min до max лет (поле age)",
  getUsersWithAge(users, 20, 30)
);
// [объект Ross Vazquez, объект Elma Head, объект Carey Barr]
console.log(
  "массив пользователей попадающих в возрастную категорию от min до max лет (поле age)",
  getUsersWithAge(users, 30, 40)
);
// [объект Moore Hensley, объект Sharlene Bush, объект Blackburn Dotson, объект Sheree Anthony]
// *********************************************************************************************************************
// Задание 5.7
// *********************************************************************************************************************
/**
 * Получить общую сумму баланса (поле balance) всех пользователей
 */
const getTotalBalance = arr => {
  return arr.reduce((acc, value) => acc + value.balance, 0);
};
console.log(
  "общая сумму баланса (поле balance) всех пользователей",
  getTotalBalance(users)
); // 20916
// *********************************************************************************************************************
// Задание 5.8
// *********************************************************************************************************************
/**
 * Массив имен всех пользователей у которых есть друг с указанным именем
 */
const getUsersByFriend = (arr, name) => {
  return arr.filter(num => num.friends.includes(name)).map(num => num.name);
};

console.log(
  "Массив имен всех пользователей у которых есть друг с указанным именем",
  getUsersByFriend(users, "Briana Decker")
); // [ 'Sharlene Bush', 'Sheree Anthony' ]
console.log(
  "Массив имен всех пользователей у которых есть друг с указанным именем",
  getUsersByFriend(users, "Goldie Gentry")
); // [ 'Elma Head', 'Sheree Anthony' ]
// *********************************************************************************************************************
// Дополнительное задание 1
// *********************************************************************************************************************
/**
 * Получить массив всех скиллов всех пользователей (поле skills), при этом не должно быть
 * повторяющихся скиллов и они должны быть отсортированы в алфавитном порядке
 */
const getAllSkills = arr => {
  return arr.reduce(
    (acc, value) =>
      (value.skills ? acc.concat(value.skills) : acc)
        .reduce(
          (acc, value) => (acc.includes(value) ? acc : acc.concat(value)),
          []
        )
        .sort(),
    []
  );
};
console.log(
  "массив всех скиллов всех пользователей (поле skills) без повторений",
  getAllSkills(users)
);
// [ 'adipisicing', 'amet', 'anim', 'commodo', 'culpa', 'elit', 'ex', 'ipsum', 'irure', 'laborum', 'lorem', 'mollit', 'non', 'nostrud', 'nulla', 'proident', 'tempor', 'velit', 'veniam' ]
// *********************************************************************************************************************
// Дополнительное задание 2
// *********************************************************************************************************************
/**
 * Массив имен (поле name) людей, отсортированных в зависимости от количества их друзей (поле friends)
 */
// arr.map(num=> num.friends)
// console.log('arr.map(num=> num.friends): ', arr.map(num=> num.friends));
const getUserNamesSortedByFriendsCount = arr => {
  return arr
    .sort((a, b) => a.friends.length - b.friends.length)
    .map(num => num.name);
};
console.log(
  "Массив имен (поле name) людей, отсортированных в зависимости от количества их друзей (поле friends)",
  getUserNamesSortedByFriendsCount(users)
);
// [ 'Moore Hensley', 'Sharlene Bush', 'Elma Head', 'Carey Barr', 'Blackburn Dotson', 'Sheree Anthony', 'Ross Vazquez' ]
// *********************************************************************************************************************
