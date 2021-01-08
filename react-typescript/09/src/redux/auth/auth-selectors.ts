import { AppStateType } from '../../types/types'

const getIsAuthenticated = (state: AppStateType) => state.auth.isAuthenticated

const getUsername = (state: AppStateType) => state.auth.user.name

const auth_selectors = {
  getIsAuthenticated,
  getUsername,
}

export default auth_selectors
