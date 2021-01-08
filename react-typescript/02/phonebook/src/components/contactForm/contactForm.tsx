import React, { Component } from 'react';
import { v4 as uuidv4 } from 'uuid';

import { Contact } from '../../types/types'
import s from './contactForm.module.scss'

interface Props {
  createContact: (e: React.FormEvent<HTMLFormElement>, contact: Contact) => void
}

const INITIALSTATE: Contact = {
  name: '',
  number: ''
}

export default class ContactForm extends Component<Props, Contact> {
  state: Contact = { ...INITIALSTATE }

  handleInput = ({ target }: React.ChangeEvent<HTMLInputElement>): void => {
    const { name, value } = target

    this.setState({ [name]: value } as Pick<Contact, keyof Contact>)
  }

  handleSubmit = (e: React.FormEvent<HTMLFormElement>): void => {
    e.preventDefault()

    const { createContact } = this.props
    createContact(e, { ...this.state })

    this.resetForm()
  }

  resetForm = (): void => {
    this.setState({
      ...INITIALSTATE
    })
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
          />
        </label>
        <button className={s.button} type="submit">
          Add contact
        </button>
      </form>
    );
  }
}
