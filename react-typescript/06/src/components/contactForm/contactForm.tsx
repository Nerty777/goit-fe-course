import React, { Component } from 'react'
import { v4 as uuidv4 } from 'uuid'
import { connect } from 'react-redux'

import { User, Contact, AppDispatchType, AppStateType } from '../../types/types'
import { createContact } from '../../redux/contacts/contacts-actions'

import s from './contactForm.module.scss'

interface Props {
  createContact: (contact: Contact) => void
  contacts: User[]
}

const INITIALSTATE: Contact = {
  name: '',
  number: '',
}

class ContactForm extends Component<Props, Contact> {
  state: Contact = { ...INITIALSTATE }

  handleInput = ({ target }: React.ChangeEvent<HTMLInputElement>): void => {
    const { name, value } = target

    this.setState({ [name]: value } as Pick<Contact, keyof Contact>)
  }

  handleSubmit = (e: React.FormEvent<HTMLFormElement>): void => {
    e.preventDefault()

    if (this.isDoubleContacts(this.state)) {
      alert(`${this.state.name} is already in contacts`)
      return
    }

    const { createContact } = this.props
    createContact({ ...this.state })

    this.resetForm()
  }

  resetForm = (): void => {
    this.setState({
      ...INITIALSTATE,
    })
  }

  isDoubleContacts = (contact: Contact): boolean => {
    return this.props.contacts.some(user => user.name === contact.name)
  }

  render() {
    const { name, number } = this.state

    const idName = uuidv4()
    const idNumber = uuidv4()

    return (
      <form onSubmit={this.handleSubmit}>
        <label className={s.label} htmlFor={idName}>
          Name
          <input
            className={s.input}
            type="text"
            name="name"
            value={name}
            id={idName}
            onChange={this.handleInput}
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
            onChange={this.handleInput}
            required
          />
        </label>
        <button className={s.button} type="submit">
          Add contact
        </button>
      </form>
    )
  }
}

const mapStateToProps = (state: AppStateType) => ({
  contacts: state.contacts.items,
})

const mapDispatchToProps = (dispatch: AppDispatchType) => ({
  createContact: (contact: Contact) => dispatch(createContact(contact)),
})

export default connect(mapStateToProps, mapDispatchToProps)(ContactForm)
