import { configureStore, getDefaultMiddleware } from '@reduxjs/toolkit'
import {
  persistStore,
  persistReducer,
  FLUSH,
  REHYDRATE,
  PAUSE,
  PERSIST,
  PURGE,
  REGISTER,
} from 'redux-persist'
import storage from 'redux-persist/lib/storage'
import contactsReducer from '../redux/contacts/contacts-reducer'

const middleware = [
  ...getDefaultMiddleware({
    serializableCheck: {
      ignoredActions: [FLUSH, REHYDRATE, PAUSE, PERSIST, PURGE, REGISTER],
    },
  }),
]

const todosPersistConfig = {
  key: 'contacts',
  storage,
}

const store = configureStore({
  reducer: {
    contacts: persistReducer(todosPersistConfig, contactsReducer),
  },
  middleware,
  devTools: process.env.NODE_ENV === 'development',
})

const persistor = persistStore(store)

export default { store, persistor }
