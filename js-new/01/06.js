let input
let total = 0

do {
  input = prompt('Введите число')

  if (input) {
    if (input == Number(input)) {
      total += Number(input)
    }
  } else if (!input && !total) {
    alert('Не было указано число')
  } else {
    alert(`Общая сумма чисел равна ${total}`)
  }
} while (input || (!input && !total))
