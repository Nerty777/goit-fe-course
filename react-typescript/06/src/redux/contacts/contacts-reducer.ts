import { createReducer, combineReducers } from '@reduxjs/toolkit'

import { createContact, deleteContact, changeFilter } from './contacts-actions'
import { User } from '../../types/types'

const items = createReducer([] as User[], {
  [createContact.type]: (state, { payload }) => [...state, payload],
  [deleteContact.type]: (state, { payload }) =>
    state.filter(({ id }) => id !== payload),
})

const filter = createReducer('', {
  [changeFilter.type]: (_, { payload }) => payload,
})

export default combineReducers({
  items,
  filter,
})
