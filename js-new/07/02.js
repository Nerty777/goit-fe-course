const ingredients = [
  'Картошка',
  'Грибы',
  'Чеснок',
  'Помидоры',
  'Зелень',
  'Приправы',
]

const ingredientList = document.querySelector('#ingredients')

const ingredient = document.createElement('li')
ingredient.classList.add('ingredient')

const template = []

ingredients.forEach(i => {
  ingredient.textContent = i
  template.push(ingredient.cloneNode(true))
})

ingredientList.append(...template)
