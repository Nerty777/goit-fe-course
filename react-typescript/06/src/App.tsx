import React from 'react'

import Filter from './components/filter/filter'
import ContactForm from './components/contactForm/contactForm'
import ContactList from './components/contactList/contactList'

const App = (): JSX.Element => {
  return (
    <div>
      <h1>Phonebook</h1>
      <ContactForm />
      <Filter />
      <ContactList />
    </div>
  )
}

export default App
