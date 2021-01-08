const input = document.querySelector('#validation-input')
const dataLength = Number(input.getAttribute('data-length'))

input.addEventListener('blur', handleInputBlur)
input.addEventListener('focus', removeClass)

function handleInputBlur({ target }) {
  if (!target.value.length) {
    removeClass()
    return
  }
  if (target.value.length >= dataLength) {
    input.classList.add('valid')
    return
  }
  input.classList.add('invalid')
}

function removeClass() {
  input.classList.remove('invalid', 'valid')
}
