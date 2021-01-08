const result = prompt('Укажите страну для доставки')

if (result) {
  const country = result.toLowerCase()
  const resultCountry = country.slice(0, 1).toUpperCase() + country.slice(1)

  switch (country) {
    case 'китай':
      alert(`Доставка в ${resultCountry} будет стоить 100 кредитов`)
      break
    case 'чили':
      alert(`Доставка в ${resultCountry} будет стоить 250 кредитов`)
      break
    case 'австралия':
      alert(`Доставка в ${resultCountry} будет стоить 170 кредитов`)
      break
    case 'индия':
      alert(`Доставка в ${resultCountry} будет стоить 80 кредитов`)
      break
    case 'ямайка':
      alert(`Доставка в ${resultCountry} будет стоить 120 кредитов`)
      break
    default:
      alert('В вашей стране доставка не доступна')
  }
} else {
  alert('Вы не указали страну')
}
