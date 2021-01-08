import { createAction } from '@reduxjs/toolkit'
import { v4 as uuidv4 } from 'uuid'

import { User, Contact } from '../../types/types'

export const createContact = createAction(
  'contact/create',
  (contact: Contact) => ({
    payload: {
      id: uuidv4(),
      ...contact,
    } as User,
  }),
)

export const deleteContact = createAction<string>('contact/delete')

export const changeFilter = createAction<string>('contact/changeFilter')
