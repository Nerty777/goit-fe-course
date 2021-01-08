const credits = 23580
const pricePerDroid = 3000
let totalPrice = 0

const result = prompt('Укажите количество дроидов, которые хотите купить')
if (!result) {
  console.log('Отменено пользователем!')
} else {
  totalPrice = Number(result) * pricePerDroid

  if (totalPrice < credits) {
    console.log(
      `Вы купили ${result} дроидов, на счету осталось ${
        credits - totalPrice
      } кредитов.`,
    )
  } else {
    console.log('Недостаточно средств на счету!')
  }
}
