import React, { useEffect } from 'react'
import { useDispatch, useSelector } from 'react-redux'

import { fetchContacts, deleteContact } from '../../redux/contacts/contacts-operations'
import { getVisibleContacts } from '../../redux/contacts/contacts-selectors'

import s from './contactList.module.scss'

export default function ContactList(): JSX.Element {
  const dispatch = useDispatch()
  const filteredContacts = useSelector(getVisibleContacts)

  useEffect(() => {
    dispatch(fetchContacts())
  }, [dispatch])

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
                      onClick={() => dispatch(deleteContact(contact.id))}
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
