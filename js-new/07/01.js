const categories = document.querySelectorAll('li.item')
console.log(`В списке ${categories.length} категории.`)

categories.forEach(({ children }) => {
  const [title, elements] = children
  console.log(`
    Категория: ${title.textContent}
    Количество элементов: ${elements.children.length}
  `)
})
