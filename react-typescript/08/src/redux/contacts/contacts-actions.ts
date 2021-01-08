import { createAction } from '@reduxjs/toolkit'

import { Contact } from '../../types/types'

const fetchContactsRequest = createAction('contacts/fetchContactsRequest')
const fetchContactsSuccess = createAction<Contact[]>('contacts/fetchContactsSuccess')
const fetchContactsError = createAction<string>('contacts/fetchContactsError')

const addContactRequest = createAction('contacts/addContactRequest')
const addContactSuccess = createAction<Contact>('contacts/addContactSuccess')
const addContactError = createAction<string>('contacts/addContactError')

const deleteContactRequest = createAction('contacts/deleteContactRequest')
const deleteContactSuccess = createAction<string>('contacts/deleteContactSuccess')
const deleteContactError = createAction<string>('contacts/deleteContactError')

const resetError = createAction('contact/resetError')

const changeFilter = createAction<string>('contact/changeFilter')

const actions = {
  fetchContactsRequest,
  fetchContactsSuccess,
  fetchContactsError,
  addContactRequest,
  addContactSuccess,
  addContactError,
  deleteContactRequest,
  deleteContactSuccess,
  deleteContactError,
  resetError,
  changeFilter,
}

export default actions
