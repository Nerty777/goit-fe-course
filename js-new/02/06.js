let input
let total = 0
const numbers = []

do {
  input = prompt('Введите число')
  if (Number.isNaN(Number(input))) {
    console.log('Было введено не число, попробуйте еще раз')
    continue
  }

  numbers.push(Number(input))
} while (input !== null)

for (const num of numbers) {
  total += num
}

console.log(`Общая сумма чисел равна ${total}`)
