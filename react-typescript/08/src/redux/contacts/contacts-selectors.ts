import { createSelector } from '@reduxjs/toolkit'
import { AppStateType } from '../../types/types'

export const getIsLoading = (state: AppStateType) => state.contacts.loading
export const getError = (state: AppStateType) => state.contacts.error
export const getFilter = (state: AppStateType) => state.contacts.filter
export const getContacts = (state: AppStateType) => state.contacts.items

export const getVisibleContacts = createSelector(
  [getContacts, getFilter], (contacts, filter) => {
    const normalizeFilter = filter.toLowerCase()

    return contacts.filter(contact =>
      contact.name.toLowerCase().includes(normalizeFilter),
    )
  }
)