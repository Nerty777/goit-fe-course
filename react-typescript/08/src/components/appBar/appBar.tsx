import React from 'react'
import { connect } from 'react-redux'

import Navigation from '../navigation/navigation'
import UserMenu from '../userMenu/userMenu'
import AuthNav from '../authNav/authNav'
import { authSelectors } from '../../redux/auth'
import { AppStateType } from '../../types/types'

import s from './appBar.module.scss'

interface Props {
  isAuthenticated: boolean
}

const AppBar = ({ isAuthenticated }: Props): JSX.Element => (
  <header className={s.header}>
    <Navigation />
    {isAuthenticated ? <UserMenu /> : <AuthNav />}
  </header>
)

const mapStateToProps = (state: AppStateType) => ({
  isAuthenticated: authSelectors.getIsAuthenticated(state),
})

export default connect(mapStateToProps)(AppBar)