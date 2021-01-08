import React, { Component } from 'react'
import { v4 as uuidv4 } from 'uuid'

import Filter from './components/filter/filter'
import ContactForm from './components/contactForm/contactForm'
import ContactList from './components/contactList/contactList'
import { User, Contact } from './types/types'

interface State {
  contacts: User[],
  filter: string
}

export default class App extends Component<{}, State> {
  state: State = {
    contacts: [
      { id: 'id-1', name: 'Rosie Simpson', number: '459-12-56' },
      { id: 'id-2', name: 'Hermione Kline', number: '443-89-12' },
      { id: 'id-3', name: 'Eden Clements', number: '645-17-79' },
      { id: 'id-4', name: 'Annie Copeland', number: '227-91-26' },
    ],
    filter: ''
  }

  componentDidMount(): void {
    const contacts = localStorage.getItem('contacts')

    if (contacts) {
      this.setState({ contacts: JSON.parse(contacts) })
    }
  }

  componentDidUpdate(prevProps: {}, prevState: State): void {
    if (this.state.contacts !== prevState.contacts) {
      localStorage.setItem('contacts', JSON.stringify(this.state.contacts))
    }
  }

  handleFilter = (e: React.ChangeEvent<HTMLInputElement>): void => {
    this.setState({ filter: e.target.value })
  }


  deleteContact = (id: string): void => {
    this.setState((prevState: State) => {
      return {
        contacts: prevState.contacts.filter(contact => contact.id !== id)
      }
    })
  }

  isDoubleContacts = (contact: Contact): boolean => {
    return this.state.contacts.some(user => user.name === contact.name)
  }

  createContact = (e: React.FormEvent<HTMLFormElement>, contact: Contact): void => {
    if (this.isDoubleContacts(contact)) {
      alert(`${contact.name} is already in contacts`)
      return
    }

    const user = { ...contact, id: uuidv4() }

    this.setState((prevState: State) => {
      return {
        contacts: [user, ...prevState.contacts]
      }
    }
    )
  }

  getVisibleContacts = (): User[] => {
    const { contacts, filter } = this.state

    const normalizeFilter = filter.toLowerCase()

    return contacts.filter(
      contact => contact.name.toLowerCase().includes(normalizeFilter)
    )
  }

  render() {
    const { contacts, filter } = this.state

    const filteredContacts = this.getVisibleContacts()

    return (
      <div>
        <h1>Phonebook</h1>
        <ContactForm createContact={this.createContact} />
        {contacts.length > 1 &&
          <Filter value={filter} handleFilter={this.handleFilter} />
        }
        {contacts.length > 0 &&
          <>
            <h2>Contacts</h2>
            <ContactList
              deleteContact={this.deleteContact}
              contacts={filteredContacts}
            />
          </>}
      </div>
    )
  }
}

