import axios from 'axios'

import { Contact, AppDispatchType } from '../../types/types'
import actions from './contacts-actions'

axios.defaults.baseURL = 'http://localhost:3001'

const ERROR_DURATION = 2000

export const fetchContacts = () => async (dispatch: AppDispatchType) => {
  dispatch(actions.fetchContactsRequest())

  try {
    const { data } = await axios.get('/contacts/')
    dispatch(actions.fetchContactsSuccess(data))
  } catch (error) {
    dispatch(actions.fetchContactsError(error))

    setTimeout(() => {
      dispatch(actions.resetError())
    }, ERROR_DURATION)
  }
}

export const addContact = (contact: Contact) => async (dispatch: AppDispatchType) => {
  const newContact = {
    ...contact,
  }

  dispatch(actions.addContactRequest())

  try {
    const { data } = await axios.post('/contacts/', newContact)
    dispatch(actions.addContactSuccess(data))
  } catch (error) {
    dispatch(actions.addContactError(error))

    setTimeout(() => {
      dispatch(actions.resetError())
    }, ERROR_DURATION)
  }
}

export const deleteContact = (id: string) => async (dispatch: AppDispatchType) => {
  dispatch(actions.deleteContactRequest())

  try {
    await axios.delete(`/contacts/${id}`)
    dispatch(actions.deleteContactSuccess(id))
  } catch (error) {
    dispatch(actions.deleteContactError(error))

    setTimeout(() => {
      dispatch(actions.resetError())
    }, ERROR_DURATION)
  }
}