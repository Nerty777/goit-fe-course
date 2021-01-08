const input = document.querySelector('#controls>input')
const createBtn = document.querySelector('[data-action="render"]')
const destroyBtn = document.querySelector('[data-action="destroy"]')
const boxes = document.querySelector('#boxes')

createBtn.addEventListener('click', handleCreateBtn)
destroyBtn.addEventListener('click', destroyBoxes)

function handleCreateBtn({ target }) {
  const value = Number(input.value)
  if (value) {
    createBoxes(value)
  }
}

function createBoxes(amount) {
  let width = 30
  let height = 30
  const template = []

  for (let i = 0; i < amount; i += 1) {
    const div = document.createElement('div')
    div.style.backgroundColor = `rgb(
      ${randomInteger(0, 256)},
      ${randomInteger(0, 256)},
      ${randomInteger(0, 256)}
    )`
    div.style.width = width + i * 10 + 'px'
    div.style.height = height + i * 10 + 'px'
    template.push(div)
  }

  boxes.append(...template)
}

function destroyBoxes() {
  input.value = ''
  boxes.textContent = ''
}

function randomInteger(min, max) {
  const rand = min + Math.random() * (max - min)

  return Math.round(rand)
}
