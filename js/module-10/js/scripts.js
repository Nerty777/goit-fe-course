"use strict";
const formDetail = document.querySelector(".form-detail");
const formGetUserById = document.querySelector(".form-getbyid");
const formDeleteUserById = document.querySelector(".form-removeuser");
const formAddUserById = document.querySelector(".form-adduser");
const formUpdateUser = document.querySelector(".form-updateuser");
const resultAllUsersList = document.querySelector(".js-result-all-users-list");

// получение всех пользователей
const getAllUsers = event => {
  fetch("https://test-users-api.herokuapp.com/users/", {
    method: "GET",
    headers: {
      Accept: "application/json",
      "Content-Type": "application/json"
    }
  })
    .then(response => {
      if (response.ok) return response.json();
      throw new Error("Error fetching data");
    })
    .then(users => {
      if (event.textContent === "Get All Users List") {
        resultAllUsersList.textContent = "";
        let number = 0;
        const arrayAllUsers = [];
        users.data.map(user => {
          const ItemFromAllUsersList = document.createElement("li");
          const userId = document.createElement("p");
          userId.classList.add("id_user");
          const userIdNumber = document.createElement("span");
          userIdNumber.classList.add("id_user_number");
          const copyImg = document.createElement("img");
          copyImg.setAttribute("src", "copy.svg");
          copyImg.setAttribute("alt", "copy");
          copyImg.setAttribute("width", "20");
          copyImg.setAttribute("height", "20");
          copyImg.classList.add("copy");
          const userName = document.createElement("p");
          const userAge = document.createElement("p");
          const numberUser = document.createElement("p");
          numberUser.textContent = `User ${(number += 1)}`;
          const id = document.createElement("span");
          id.textContent = "ID: ";
          id.classList.add("id");
          const name = document.createElement("span");
          name.textContent = "Name: ";
          name.classList.add("name");
          const age = document.createElement("span");
          age.textContent = "Age: ";
          age.classList.add("age");
          userIdNumber.textContent = JSON.stringify(user.id);
          userName.textContent = JSON.stringify(user.name);
          userAge.textContent = JSON.stringify(user.age);
          userId.append(id);
          userName.prepend(name);
          userAge.prepend(age);
          userId.append(userIdNumber);
          userId.append(copyImg);
          ItemFromAllUsersList.append(numberUser, userId, userName, userAge);
          arrayAllUsers.push(`${ItemFromAllUsersList.outerHTML}`);
        });
        resultAllUsersList.insertAdjacentHTML(
          "afterbegin",
          arrayAllUsers.join("")
        );
      }
      // скрытие списка пользователей при нажатии кнопки Hide All Users List
      if (event.textContent === "Hide All Users List") {
        resultAllUsersList.textContent = "";
      }
    })
    .catch(error => {
      console.error("Error: ", error);
    });
};

// работа с буфером обмена через кнопки скопировать/вставить
resultAllUsersList.addEventListener("click", onClickCopy);
function onClickCopy(event) {
  event.preventDefault();
  const target = event.target;
  if (target.nodeName !== "IMG") return;
  const userCard = target.parentNode;

  let inputValue = userCard.querySelector(".id_user_number").textContent;
  const imgCopy = userCard.querySelector(".copy");
  inputValue = inputValue.slice(1, 25);
  if (inputValue) {
    const textCopy = document.createElement("span");
    textCopy.textContent = "Copy";
    textCopy.classList.add("copy-text", "green");
    imgCopy.after(textCopy);
    setTimeout(function() {
      textCopy.classList.remove("copy-text");
      textCopy.classList.remove("green");
      textCopy.textContent = "";
      navigator.clipboard
        .writeText(inputValue)
        .then(() => {})
        .catch(err => {
          console.log("Something went wrong", err);
        });
    }, 2000);
  }
}

// получение данных пользователя по конкретному User ID
const getUserById = id => {
  const jsResultGetUser = document.querySelector(".js-result-getuser");
  if (id === "") {
    jsResultGetUser.textContent = "Не введенно значение User Id";
    jsResultGetUser.classList.add("red");
    setTimeout(function() {
      jsResultGetUser.textContent = "";
    }, 2000);
    return;
  }
  fetch(`https://test-users-api.herokuapp.com/users/${id}`, {
    method: "GET",
    headers: {
      Accept: "application/json",
      "Content-Type": "application/json"
    }
  })
    .then(response => {
      if (response.ok) return response.json();
      throw new Error("Error fetching data");
    })
    .then(users => {
      if (users.status === 500 || users.status === 404) {
        jsResultGetUser.textContent = "Введен не существующий User Id";
        jsResultGetUser.classList.add("red");
        setTimeout(function() {
          jsResultGetUser.textContent = "";
          formGetUserById.reset();
        }, 2000);
        return;
      }
      jsResultGetUser.classList.remove("red");
      jsResultGetUser.textContent = "";
      const userId = document.createElement("p");
      const userName = document.createElement("p");
      const userAge = document.createElement("p");
      const id = document.createElement("span");
      id.textContent = "ID: ";
      id.classList.add("id");
      const name = document.createElement("span");
      name.textContent = "Name: ";
      name.classList.add("name");
      const age = document.createElement("span");
      age.textContent = "Age: ";
      age.classList.add("age");
      userId.textContent = JSON.stringify(users.data.id);
      userName.textContent = JSON.stringify(users.data.name);
      userAge.textContent = JSON.stringify(users.data.age);
      userId.prepend(id);
      userName.prepend(name);
      userAge.prepend(age);
      jsResultGetUser.append(userId, userName, userAge);
      // очистка инпута js-input-byid
      formGetUserById.reset();
    })
    .catch(error => {
      console.error("Error: ", error);
    });
};

// удаление данных по User ID
const removeUser = id => {
  const jsResultIdRemove = document.querySelector(".js-result-remove-user");
  fetch(`https://test-users-api.herokuapp.com/users/${id}`, {
    method: "DELETE",
    headers: {
      Accept: "application/json",
      "Content-Type": "application/json"
    }
  })
    .then(response => {
      if (response.ok) return response.json();
      throw new Error("Error fetching data");
    })
    .then(users => {
      if (users.status === 500 || users.data === null) {
        jsResultIdRemove.textContent = "Введен не существующий User Id";
        jsResultIdRemove.classList.add("red");
        setTimeout(function() {
          jsResultIdRemove.textContent = "";
          formDeleteUserById.reset();
        }, 2000);
        return;
      }
      jsResultIdRemove.textContent = `Пользователь с User Id ${id} удален`;
      jsResultIdRemove.classList.add("green");
      setTimeout(function() {
        jsResultIdRemove.textContent = "";
        jsResultIdRemove.classList.remove("green");
        formDeleteUserById.reset();
      }, 2000);
    })
    .catch(error => {
      console.error("Error: ", error);
    });
};

//Добавление пользователя с именем и возрастом
const addUser = (name, age) => {
  const jsResultAddUser = document.querySelector(".js-result-add-user");
  const ageNumber = +age;
  //проверка, что в имени нет цифр
  if (
    name.includes(0) ||
    name.includes(1) ||
    name.includes(2) ||
    name.includes(3) ||
    name.includes(4) ||
    name.includes(5) ||
    name.includes(6) ||
    name.includes(7) ||
    name.includes(8) ||
    name.includes(9)
  ) {
    jsResultAddUser.textContent = "Введенное имя должно содержать только буквы";
    jsResultAddUser.classList.add("red");
    setTimeout(function() {
      jsResultAddUser.textContent = "";
      jsResultAddUser.classList.remove("red");
    }, 2000);
    return;
  }
  // проверка, что введенный возраст число
  if (!ageNumber) {
    const age = document.createElement("div");
    age.textContent = "Введенный возраст не число";
    age.classList.add("red");
    jsResultAddUser.append(age);
    setTimeout(function() {
      age.textContent = "";
      age.classList.remove("red");
    }, 2000);
    return;
  }
  fetch("https://test-users-api.herokuapp.com/users/", {
    method: "POST",
    body: JSON.stringify({ name: `${name}`, age: `${age}` }),
    headers: {
      Accept: "application/json",
      "Content-Type": "application/json"
    }
  })
    .then(response => {
      if (response.ok) return response.json();
      throw new Error("Error fetching data");
    })
    .then(users => {
      const createUser = document.createElement("p");
      createUser.textContent = "Пользователь успешно создан ";
      createUser.classList.add("green");
      const hr = document.createElement("hr");
      const userId = document.createElement("p");
      const userName = document.createElement("p");
      const userAge = document.createElement("p");
      const id = document.createElement("span");
      id.textContent = "ID: ";
      id.classList.add("id");
      const name = document.createElement("span");
      name.textContent = "Name: ";
      name.classList.add("name");
      const age = document.createElement("span");
      age.textContent = "Age: ";
      age.classList.add("age");
      userId.textContent = JSON.stringify(users.data._id);
      userName.textContent = JSON.stringify(users.data.name);
      userAge.textContent = JSON.stringify(users.data.age);
      userId.prepend(id);
      userName.prepend(name);
      userAge.prepend(age);
      jsResultAddUser.append(createUser, userId, userName, userAge, hr);
      // очистка инпутов
      formAddUserById.reset();
      setTimeout(function() {
        jsResultAddUser.textContent = "";
      }, 3000);
    })
    .catch(error => {
      console.error("Error: ", error);
    });
};

// обновление пользователя
const updateUser = (id, user) => {
  const jsResultUpdateUser = document.querySelector(".js-result-update-user");
  const name = user.name;
  const age = user.age;
  const ageNumber = +age;
  //проверка, что в имени нет цифр
  if (
    name.includes(0) ||
    name.includes(1) ||
    name.includes(2) ||
    name.includes(3) ||
    name.includes(4) ||
    name.includes(5) ||
    name.includes(6) ||
    name.includes(7) ||
    name.includes(8) ||
    name.includes(9)
  ) {
    jsResultUpdateUser.textContent =
      "Введенное имя должно содержать только буквы";
    jsResultUpdateUser.classList.add("red");
    setTimeout(function() {
      jsResultUpdateUser.textContent = "";
      jsResultUpdateUser.classList.remove("red");
      // formUpdateUser.reset();
    }, 2000);
    return;
  }
  // проверка, что введенный возраст число
  if (!ageNumber) {
    const age = document.createElement("div");
    age.textContent = "Введенный возраст не число";
    age.classList.add("red");
    jsResultUpdateUser.append(age);
    setTimeout(function() {
      age.textContent = "";
      age.classList.remove("red");
    }, 2000);
    return;
  }
  const userToUpdate = {
    id: id,
    name: name,
    age: age
  };
  fetch(`https://test-users-api.herokuapp.com/users/${id}`, {
    method: "PUT",
    body: JSON.stringify(userToUpdate),
    headers: {
      Accept: "application/json",
      "Content-Type": "application/json"
    }
  })
    .then(response => {
      if (response.ok) return response.json();
      throw new Error("Error fetching data");
    })
    .then(users => {
      if (users.status === 500 || users.status === 404) {
        jsResultUpdateUser.textContent = "Введен не существующий User Id";
        jsResultUpdateUser.classList.add("red");
        setTimeout(function() {
          jsResultUpdateUser.textContent = "";
        }, 3000);
        return;
      }
      const createUser = document.createElement("p");
      createUser.textContent = "Пользователь успешно обновлен ";
      createUser.classList.add("green");
      const userId = document.createElement("p");
      const userName = document.createElement("p");
      const userAge = document.createElement("p");
      const id = document.createElement("span");
      id.textContent = "ID: ";
      id.classList.add("id");
      const name = document.createElement("span");
      name.textContent = "Name: ";
      name.classList.add("name");
      const age = document.createElement("span");
      age.textContent = "Age: ";
      age.classList.add("age");
      userId.textContent = JSON.stringify(users.data.id);
      userName.textContent = JSON.stringify(users.data.name);
      userAge.textContent = JSON.stringify(users.data.age);
      userId.prepend(id);
      userName.prepend(name);
      userAge.prepend(age);
      jsResultUpdateUser.append(createUser, userId, userName, userAge);
      // очистка инпутов
      formUpdateUser.reset();
      setTimeout(function() {
        jsResultUpdateUser.textContent = "";
      }, 4000);
    })
    .catch(error => {
      console.error("Error: ", error);
    });
};

formDetail.addEventListener("click", handleButtonClick);
function handleButtonClick(event) {
  event.preventDefault();
  const target = event.target;
  if (target.nodeName !== "BUTTON") return;
  getAllUsers(target);
}

formGetUserById.addEventListener("submit", handleButtonGetById);
function handleButtonGetById(event) {
  event.preventDefault();
  const InputId = formGetUserById.querySelector(".js-input-byid");
  const id = InputId.value;
  getUserById(id);
}

formDeleteUserById.addEventListener("submit", handleButtonDeleteById);
function handleButtonDeleteById(event) {
  event.preventDefault();
  const InputId = formDeleteUserById.querySelector(".js-input-remove");
  const id = InputId.value;
  removeUser(id);
}

formAddUserById.addEventListener("submit", handleButtonAddUserById);
function handleButtonAddUserById(event) {
  event.preventDefault();
  const InputName = formAddUserById.querySelector(".js-inputaddname");
  const InputAge = formAddUserById.querySelector(".js-inputaddage");
  const name = InputName.value;
  const age = InputAge.value;
  addUser(name, age);
}

formUpdateUser.addEventListener("submit", handleButtonUpdateUser);
function handleButtonUpdateUser(event) {
  event.preventDefault();
  const InputId = formUpdateUser.querySelector(".js-input-update-id");
  const InputName = formUpdateUser.querySelector(".js-input-update-name");
  const InputAge = formUpdateUser.querySelector(".js-input-update-age");
  const id = InputId.value;
  const name = InputName.value;
  const age = InputAge.value;
  const user = {
    name: name,
    age: age
  };
  updateUser(id, user);
}
