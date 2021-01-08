import { useSelector } from 'react-redux'

import Filter from '../../components/filter/filter'
import ContactForm from '../../components/contactForm/contactForm'
import ContactList from '../../components/contactList/contactList'
import { getIsLoading, getError } from '../../redux/contacts/contacts-selectors'

import s from './contacts.module.scss'

export default function Contacts(): JSX.Element {
  const isLoading = useSelector(getIsLoading)
  const error = useSelector(getError)

  return (
    <div>
      {isLoading && <div className={s.loading}>Loading</div>}
      {error && <div className={s.error}>Error</div>}
      <h1>Phonebook</h1>
      <ContactForm />
      <>
        <Filter />
        <ContactList />
      </>
    </div>
  )
}
