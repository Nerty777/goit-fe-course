import React from 'react'
import { User } from '../../types/types'
import s from './contactList.module.scss'

interface Props {
  contacts: User[]
  deleteContact: (id: string) => void
}

const ContactList = ({ contacts, deleteContact }: Props): JSX.Element => {
  return (
    <ul>
      {contacts.map(contact => {
        return <li key={contact.id}>
          <p>
            <span className={s.contact}>{`${contact.name} ${contact.number}`}</span>
            <button
              className={s.button}
              type="button"
              onClick={() => deleteContact(contact.id)}
            >
              Delete
            </button>
          </p>
        </li>
      })}
    </ul>
  )
}

export default ContactList