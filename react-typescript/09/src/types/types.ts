import store from '../store/store'

export interface Contact {
  name: string
  number: string
}

export interface User extends Contact {
  id: string
}

export interface Register {
  name: string
  email: string
  password: string
}

export interface UserWithToken {
  user: {
    name: string
    email: string
  }
  token: string
}

export interface LogIn {
  email: string
  password: string
}

export type AppStateType = {
  auth: {
    user: Contact
    loading: boolean
    error: null | boolean
    token: string
    isAuthenticated: boolean
  }
  contacts: {
    items: User[]
    filter: string
    loading: boolean
    error: null | boolean
  }
}

export type AppDispatchType = typeof store.store.dispatch
