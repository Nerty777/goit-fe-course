import React, { useState } from 'react'
import { v4 as uuidv4 } from 'uuid'
import { useDispatch, useSelector } from 'react-redux'

import { Contact } from '../../types/types'
import { addContact } from '../../redux/contacts/contacts-operations'
import { getContacts } from '../../redux/contacts/contacts-selectors'

import s from './contactForm.module.scss'

export default function ContactForm() {
  const dispatch = useDispatch()

  const contacts = useSelector(getContacts)

  const [name, setName] = useState('')
  const [number, setNumber] = useState('')

  const handleName = ({ target }: React.ChangeEvent<HTMLInputElement>): void => {
    const { value } = target
    setName(value)
  }

  const handleNumber = ({ target }: React.ChangeEvent<HTMLInputElement>): void => {
    const { value } = target
    setNumber(value)
  }

  const handleSubmit = (e: React.FormEvent<HTMLFormElement>): void => {
    e.preventDefault()

    if (isDoubleContacts({ name, number })) {
      alert(`${name} is already in contacts`)
      return
    }

    dispatch(addContact({ name, number }))
    resetForm()
  }

  const resetForm = (): void => {
    setName('')
    setNumber('')
  }

  const isDoubleContacts = (contact: Contact): boolean => {
    const { name } = contact
    return contacts.some(user => user.name === name)
  }

  const idName = uuidv4()
  const idNumber = uuidv4()

  return (
    <form onSubmit={handleSubmit}>
      <label className={s.label} htmlFor={idName}>
        Name
      <input
          className={s.input}
          type="text"
          name="name"
          value={name}
          id={idName}
          onChange={handleName}
          required
        />
      </label>
      <label className={s.label} htmlFor={idNumber}>
        Number
      <input
          className={s.input}
          type="tel"
          name="number"
          value={number}
          id={idNumber}
          onChange={handleNumber}
          required
        />
      </label>
      <button className={s.button} type="submit">
        Add contact
    </button>
    </form>
  )
}
