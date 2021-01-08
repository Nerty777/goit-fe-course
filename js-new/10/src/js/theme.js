const switchInput = document.querySelector('.js-switch-input');
const body = document.querySelector('body');

const Theme = {
  LIGHT: 'light-theme',
  DARK: 'dark-theme',
};

switchInput.addEventListener('click', handleClick);

const theme = localStorage.getItem('theme');

if (!theme || theme === Theme.LIGHT) {
  applyLightTheme();
} else {
  switchInput.checked = true;
  applyDarkTheme();
}

function handleClick({ target: { checked } }) {
  if (checked) {
    applyDarkTheme();
  } else {
    applyLightTheme();
  }
}

function applyDarkTheme() {
  localStorage.setItem('theme', Theme.DARK);
  body.classList.remove('light-theme');
  body.classList.add('dark-theme');
}

function applyLightTheme() {
  localStorage.setItem('theme', Theme.LIGHT);
  body.classList.remove('dark-theme');
  body.classList.add('light-theme');
}
