import React, { Component } from 'react'
import { connect } from 'react-redux'

import { User, AppStateType, AppDispatchType } from '../../types/types'
import { deleteContact } from '../../redux/contacts/contacts-actions'

import s from './contactList.module.scss'

interface Props {
  filter: string
  contacts: User[]
  deleteContact: (id: string) => void
}

class ContactList extends Component<Props> {
  componentDidMount(): void {
    const contacts = localStorage.getItem('persist:contacts')

    if (contacts) {
      this.setState({ contacts: JSON.parse(contacts) })
    }
  }

  getVisibleContacts = (): User[] => {
    const { contacts, filter } = this.props
    const normalizeFilter = filter.toLowerCase()

    return contacts.filter(contact =>
      contact.name.toLowerCase().includes(normalizeFilter),
    )
  }

  render() {
    const filteredContacts = this.getVisibleContacts()

    return (
      <>
        {filteredContacts.length > 0 && (
          <>
            <h2>Contacts</h2>
            <ul>
              {filteredContacts.map(contact => {
                return (
                  <li key={contact.id}>
                    <p>
                      <span
                        className={s.contact}
                      >{`${contact.name} ${contact.number}`}</span>
                      <button
                        className={s.button}
                        type="button"
                        onClick={() => this.props.deleteContact(contact.id)}
                      >
                        Delete
                      </button>
                    </p>
                  </li>
                )
              })}
            </ul>
          </>
        )}
      </>
    )
  }
}

const mapStateToProps = (state: AppStateType) => ({
  contacts: state.contacts.items,
  filter: state.contacts.filter,
})

const mapDispatchToProps = (dispatch: AppDispatchType) => ({
  deleteContact: (id: string) => dispatch(deleteContact(id)),
})

export default connect(mapStateToProps, mapDispatchToProps)(ContactList)
