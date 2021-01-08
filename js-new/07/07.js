const input = document.querySelector('#font-size-control')
const text = document.querySelector('#text')

input.addEventListener('input', handleInput)

function handleInput({ target }) {
  const value = Number(target.value)

  if (!value) {
    return
  }

  text.style.fontSize = target.value + 'px'
}
