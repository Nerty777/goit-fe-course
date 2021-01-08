import { createAction } from '@reduxjs/toolkit'

import { UserWithToken } from '../../types/types'

const registerRequest = createAction('auth/registerRequest')
const registerSuccess = createAction<UserWithToken>('auth/registerSuccess')
const registerError = createAction<string>('auth/registerError')

const loginRequest = createAction('auth/loginRequest')
const loginSuccess = createAction<UserWithToken>('auth/loginSuccess')
const loginError = createAction<string>('auth/loginError')

const logoutRequest = createAction('auth/logoutRequest')
const logoutSuccess = createAction('auth/logoutSuccess')
const logoutError = createAction<string>('auth/logoutError')

const getCurrentUserRequest = createAction('auth/getCurrentUserRequest')
const getCurrentUserSuccess = createAction<string>('auth/getCurrentUserSuccess')
const getCurrentUserError = createAction<string>('auth/getCurrentUserError')

export default {
  registerRequest,
  registerSuccess,
  registerError,
  logoutRequest,
  logoutSuccess,
  logoutError,
  loginRequest,
  loginSuccess,
  loginError,
  getCurrentUserRequest,
  getCurrentUserSuccess,
  getCurrentUserError,
}