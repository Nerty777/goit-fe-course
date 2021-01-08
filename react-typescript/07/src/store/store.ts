import { configureStore, getDefaultMiddleware } from '@reduxjs/toolkit'
import {
  FLUSH,
  REHYDRATE,
  PAUSE,
  PERSIST,
  PURGE,
  REGISTER,
} from 'redux-persist'
import contactsReducer from '../redux/contacts/contacts-reducer'

const middleware = [
  ...getDefaultMiddleware({
    serializableCheck: {
      ignoredActions: [FLUSH, REHYDRATE, PAUSE, PERSIST, PURGE, REGISTER],
    },
  }),
]

export const store = configureStore({
  reducer: {
    contacts: contactsReducer,
  },
  middleware,
  devTools: process.env.NODE_ENV === 'development',
})
