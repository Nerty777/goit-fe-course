let counterValue = 0

const decrement = document.querySelector('button[data-action="decrement"]')
const increment = document.querySelector('button[data-action="increment"]')
const counter = document.querySelector('#value')

decrement.addEventListener('click', handleDecrement)
increment.addEventListener('click', handleIncrement)

function handleDecrement() {
  counterValue -= 1
  counter.textContent = counterValue
}

function handleIncrement() {
  counterValue += 1
  counter.textContent = counterValue
}
