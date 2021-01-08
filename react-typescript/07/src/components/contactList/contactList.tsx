import React, { Component } from 'react'
import { connect } from 'react-redux'

import { User, AppStateType, AppDispatchType } from '../../types/types'
import { fetchContacts, deleteContact } from '../../redux/contacts/contacts-operations'
import { getVisibleContacts } from '../../redux/contacts/contacts-selectors'


import s from './contactList.module.scss'

interface Props {
  filteredContacts: User[]
  deleteContact: (id: string) => void
  fetchContacts: () => void
}

class ContactList extends Component<Props> {
  componentDidMount(): void {
    this.props.fetchContacts()
  }

  render() {
    const { filteredContacts } = this.props

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
  filteredContacts: getVisibleContacts(state)
})

const mapDispatchToProps = (dispatch: AppDispatchType) => ({
  deleteContact: (id: string) => dispatch(deleteContact(id)),
  fetchContacts: () => dispatch(fetchContacts()),
})

export default connect(mapStateToProps, mapDispatchToProps)(ContactList)
