import React from 'react'

import TransactionHistory from './components/transactionHistory/transactionHistory'
import transactions from './assets/transactions.json'

import FriendList from './components/friendList/friendList'
import friends from './assets/friends.json'

import Statistics from './components/statistics/statistics'
import statisticalData from './assets/statistical-data.json'

import Profile from './components/profile/profile'
import user from './assets/user.json'

function App() {
  return (
    <div className="App">
      <TransactionHistory items={transactions} />
      <FriendList friends={friends} />
      <Statistics title="Upload stats" stats={statisticalData} />
      <Profile
        name={user.name}
        tag={user.tag}
        location={user.location}
        avatar={user.avatar}
        stats={user.stats}
      />
    </div>
  )
}

export default App;
