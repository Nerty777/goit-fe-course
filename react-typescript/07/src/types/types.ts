import { store } from '../store/store'

export interface Contact {
  name: string
  number: string
}

export interface User extends Contact {
  id: string
}

export type AppStateType = {
  contacts: {
    items: User[]
    filter: string
    loading: boolean
    error: null | boolean
  }
}
export type AppDispatchType = typeof store.dispatch
