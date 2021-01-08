import axios from 'axios'
import authActions from './auth-actions'

import { AppDispatchType, AppStateType, Register, LogIn, UserWithToken } from '../../types/types'

axios.defaults.baseURL = 'https://goit-phonebook-api.herokuapp.com'

const token = {
  set(token: string) {
    axios.defaults.headers.common.Authorization = `Bearer ${token}`
  },
  unset() {
    axios.defaults.headers.common.Authorization = ''
  },
}

const register = (credentials: Register) => async (dispatch: AppDispatchType) => {
  dispatch(authActions.registerRequest())

  try {
    const { data } = await axios.post('/users/signup', credentials)
    console.log('data: ', data);

    token.set(data.token)
    dispatch(authActions.registerSuccess(data as UserWithToken))
  } catch (error) {
    dispatch(authActions.registerError(error.message))
  }
}

const logIn = (credentials: LogIn) => async (dispatch: AppDispatchType) => {
  dispatch(authActions.loginRequest())

  try {
    const { data } = await axios.post('/users/login', credentials)

    token.set(data.token)
    dispatch(authActions.loginSuccess(data as UserWithToken))
  } catch (error) {
    dispatch(authActions.loginError(error.message))
  }
}

const logOut = () => async (dispatch: AppDispatchType) => {
  dispatch(authActions.logoutRequest())

  try {
    await axios.post('/users/logout')

    token.unset()
    dispatch(authActions.logoutSuccess())
  } catch (error) {
    dispatch(authActions.logoutError(error.message))
  }
}

const getCurrentUser = () => async (dispatch: AppDispatchType, getState: () => AppStateType) => {
  const {
    auth: { token: persistedToken },
  } = getState()

  if (!persistedToken) {
    return
  }

  token.set(persistedToken)
  dispatch(authActions.getCurrentUserRequest())

  try {
    const { data } = await axios.get('/users/current')

    dispatch(authActions.getCurrentUserSuccess(data))
  } catch (error) {
    dispatch(authActions.getCurrentUserError(error.message))
  }
}

export default { register, logOut, logIn, getCurrentUser }