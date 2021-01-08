import { createReducer, combineReducers } from '@reduxjs/toolkit'
import authActions from './auth-actions'

const initialUserState = {
  name: null,
  email: null
}

const user = createReducer(initialUserState, {
  [authActions.registerSuccess.type]: (_, { payload }) => payload.user,
  [authActions.loginSuccess.type]: (_, { payload }) => payload.user,
  [authActions.logoutSuccess.type]: () => initialUserState,
  [authActions.getCurrentUserSuccess.type]: (_, { payload }) => payload,
})

const token = createReducer(null, {
  [authActions.registerSuccess.type]: (_, { payload }) => payload.token,
  [authActions.loginSuccess.type]: (_, { payload }) => payload.token,
  [authActions.logoutSuccess.type]: () => null,
})

const error = createReducer<null | boolean>(null, {
  [authActions.registerError.type]: () => true,
  [authActions.loginError.type]: () => true,
  [authActions.logoutError.type]: () => true,
  [authActions.getCurrentUserError.type]: () => true,
})

const isAuthenticated = createReducer(false, {
  [authActions.registerSuccess.type]: () => true,
  [authActions.loginSuccess.type]: () => true,
  [authActions.getCurrentUserSuccess.type]: () => true,
  [authActions.registerError.type]: () => false,
  [authActions.loginError.type]: () => false,
  [authActions.getCurrentUserError.type]: () => false,
  [authActions.logoutSuccess.type]: () => false,
})

export default combineReducers({
  user,
  token,
  error,
  isAuthenticated,
})
