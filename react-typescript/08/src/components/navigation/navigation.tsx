import React from 'react'
import { connect } from 'react-redux'
import { NavLink } from 'react-router-dom'

import { authSelectors } from '../../redux/auth'
import { AppStateType } from '../../types/types'

import s from './navigation.module.scss'

const Navigation = () => (
  <nav>
    <NavLink
      to="/"
      exact
      className={s.link}
      activeClassName={s.activeLink}>
      Main
    </NavLink>

    <NavLink
      to="/contacts"
      exact
      className={s.link}
      activeClassName={s.activeLink}
    >
      Contacts
    </NavLink>
  </nav>
)
const mapStateToProps = (state: AppStateType) => ({
  isAuthenticated: authSelectors.getIsAuthenticated(state),
})

export default connect(mapStateToProps)(Navigation)