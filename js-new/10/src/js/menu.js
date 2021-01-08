import menuTemplate from '../templates/menu.hbs';
import menuData from '../menu.json';

const menu = document.querySelector('.js-menu');
menu.insertAdjacentHTML('afterbegin', menuTemplate(menuData));
