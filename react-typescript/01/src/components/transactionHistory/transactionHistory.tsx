import React from 'react'

import s from './transactionHistory.module.scss'

const TransactionHistory = ({ items }: Props): JSX.Element => {
  return (
    <div className={s.wrapper}>
      <table className={s.transactionHistory}>
        <thead>
          <tr>
            <th>Type</th>
            <th>Amount</th>
            <th>Currency</th>
          </tr>
        </thead>

        <tbody>
          {items.map(item => {
            return (
              <tr key={item.id} className={s.item}>
                <td>{item.type}</td>
                <td>{item.amount}</td>
                <td>{item.currency}</td>
              </tr>
            )
          })}
        </tbody>
      </table>
    </div>

  )
}

interface Props {
  items: Transaction[]
}

interface Transaction {
  id: string
  type: string
  amount: string
  currency: string
}

export default TransactionHistory