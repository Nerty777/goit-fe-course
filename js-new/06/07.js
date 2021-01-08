import users from './users.js'
const calculateTotalBalance = users => {
  return users.reduce((acc, user) => {
    return acc + user.balance
  }, 0)
}

console.log(calculateTotalBalance(users)) // 20916
