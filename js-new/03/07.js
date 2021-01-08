/*
 * Типов транзацкий всего два.
 * Можно положить либо снять деньги со счета.
 */
const Transaction = {
  DEPOSIT: 'deposit',
  WITHDRAW: 'withdraw',
}

/*
 * Каждая транзакция это объект со свойствами: id, type и amount
 */

let id = 0

const account = {
  // Текущий баланс счета
  balance: 0,

  // История транзакций
  transactions: [],

  /*
   * Метод создает и возвращает объект транзакции.
   * Принимает сумму и тип транзакции.
   */
  createTransaction(amount, type) {
    id += 1
    return { id, amount, type }
  },

  /*
   * Метод отвечающий за добавление суммы к балансу.
   * Принимает сумму танзакции.
   * Вызывает createTransaction для создания объекта транзакции
   * после чего добавляет его в историю транзакций
   */
  deposit(amount) {
    const transaction = this.createTransaction(amount, Transaction.DEPOSIT)
    this.transactions.push(transaction)
    this.balance += amount
  },

  /*
   * Метод отвечающий за снятие суммы с баланса.
   * Принимает сумму танзакции.
   * Вызывает createTransaction для создания объекта транзакции
   * после чего добавляет его в историю транзакций.
   *
   * Если amount больше чем текущий баланс, выводи сообщение
   * о том, что снятие такой суммы не возможно, недостаточно средств.
   */
  withdraw(amount) {
    if (amount > this.balance) {
      console.log('снятие такой суммы не возможно, недостаточно средств')
      return
    }
    const transaction = this.createTransaction(amount, Transaction.WITHDRAW)
    this.transactions.push(transaction)
    this.balance -= amount
  },

  /*
   * Метод возвращает текущий баланс
   */
  getBalance() {
    return this.balance
  },

  /*
   * Метод ищет и возвращает объект транзации по id
   */
  getTransactionDetails(id) {
    return this.transactions.find(transaction => transaction.id === id)
  },

  /*
   * Метод возвращает количество средств
   * определенного типа транзакции из всей истории транзакций
   */
  getTransactionTotal(type) {
    let result = 0

    this.transactions
      .filter(t => t.type === type)
      .map(t => {
        result += t.amount
      })

    return result
  },
}

account.deposit(10)
account.deposit(30)
account.deposit(50)
account.withdraw(5)
account.withdraw(10)
account.withdraw(500)

console.log(
  'account.getTransactionDetails(1): ',
  account.getTransactionDetails(1),
)

console.log('account.transactions: ', account.transactions)

console.log('account.getBalance(): ', account.getBalance())
console.log(
  'account.getTransactionTotal(Transaction.DEPOSIT): ',
  account.getTransactionTotal(Transaction.DEPOSIT),
)
console.log(
  'account.getTransactionTotal(Transaction.WITHDRAW): ',
  account.getTransactionTotal(Transaction.WITHDRAW),
)
