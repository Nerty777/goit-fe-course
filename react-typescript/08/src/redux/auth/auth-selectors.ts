import { AppStateType } from '../../types/types'

const getIsAuthenticated = (state: AppStateType) => state.auth.isAuthenticated

const getUsername = (state: AppStateType) => state.auth.user.name

export default {
  getIsAuthenticated,
  getUsername,
}