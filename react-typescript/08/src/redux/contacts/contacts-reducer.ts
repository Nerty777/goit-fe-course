import { createReducer, combineReducers } from '@reduxjs/toolkit'

import actions from './contacts-actions'
import { User } from '../../types/types'

const {
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
} = actions

const items = createReducer([] as User[], {
  [fetchContactsSuccess.type]: (_, { payload }) => payload,
  [addContactSuccess.type]: (state, { payload }) => [...state, payload],
  [deleteContactSuccess.type]: (state, { payload }) =>
    state.filter(({ id }) => id !== payload),
})

const filter = createReducer('', {
  [changeFilter.type]: (_, { payload }) => payload,
})

const loading = createReducer(false, {
  [fetchContactsRequest.type]: () => true,
  [fetchContactsSuccess.type]: () => false,
  [fetchContactsError.type]: () => false,

  [addContactRequest.type]: () => true,
  [addContactSuccess.type]: () => false,
  [addContactError.type]: () => false,

  [deleteContactRequest.type]: () => true,
  [deleteContactSuccess.type]: () => false,
  [deleteContactError.type]: () => false,
})

const error = createReducer<null | boolean>(null, {
  [fetchContactsError.type]: () => true,
  [addContactError.type]: () => true,
  [deleteContactError.type]: () => true,
  [resetError.type]: () => false,
})

export default combineReducers({
  items,
  filter,
  loading,
  error,
})
