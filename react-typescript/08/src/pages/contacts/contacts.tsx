import React from 'react'
import { connect } from 'react-redux'

import Filter from '../../components/filter/filter'
import ContactForm from '../../components/contactForm/contactForm'
import ContactList from '../../components/contactList/contactList'
import { AppStateType } from '../../types/types'
import { getIsLoading, getError } from '../../redux/contacts/contacts-selectors'

import s from './contacts.module.scss'

interface Props {
  isLoading: boolean
  error: null | boolean
}

const Contacts = ({ isLoading, error }: Props): JSX.Element => {

  return (
    <div>
      {isLoading && <div className={s.loading}>Loading</div>}
      {error && <div className={s.error}>Error</div>}
      <h1>Phonebook</h1>
      <ContactForm />
      <Filter />
      <ContactList />
    </div>
  )
}

const mapStateToProps = (state: AppStateType) => ({
  isLoading: getIsLoading(state),
  error: getError(state),
})

export default connect(mapStateToProps)(Contacts)
