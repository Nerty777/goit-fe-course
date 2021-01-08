import React from 'react'
import { connect } from 'react-redux'

import Filter from '../filter/filter'
import ContactForm from '../contactForm/contactForm'
import ContactList from '../contactList/contactList'
import { AppStateType } from '../../types/types'
import { getIsLoading, getError } from '../../redux/contacts/contacts-selectors'

import s from './app.module.scss'

interface Props {
  isLoading: boolean
  error: null | boolean
}

const App = ({ isLoading, error }: Props): JSX.Element => {

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

export default connect(mapStateToProps)(App)
