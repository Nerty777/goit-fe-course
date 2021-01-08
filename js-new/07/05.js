const input = document.querySelector('#name-input')
const nameOutput = document.querySelector('#name-output')

input.addEventListener('input', handleInput)

function handleInput({ target }) {
  nameOutput.textContent = target.value ? target.value : 'незнакомец'
}
