const findLongestWord = function (string) {
  const words = string.split(' ')
  let maxWord = words[0]
  for (const el of words) {
    maxWord = el.length > maxWord.length ? el : maxWord
  }

  return maxWord
}

/*
 * Вызовы функции для проверки работоспособности твоей реализации.
 */
console.log(findLongestWord('The quick brown fox jumped over the lazy dog')) // 'jumped'

console.log(findLongestWord('Google do a roll')) // 'Google'

console.log(findLongestWord('May the force be with you')) // 'force'
