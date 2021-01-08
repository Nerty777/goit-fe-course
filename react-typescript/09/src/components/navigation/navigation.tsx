import { useSelector } from 'react-redux'
import { NavLink } from 'react-router-dom'

import { authSelectors } from '../../redux/auth'

import s from './navigation.module.scss'

export default function Navigation(): JSX.Element {
  const isAuthenticated = useSelector(authSelectors.getIsAuthenticated)

  return (
    <nav>
      <NavLink
        to="/"
        exact
        className={s.link}
        activeClassName={s.activeLink}>
        Main
    </NavLink>
      {isAuthenticated && <NavLink
        to="/contacts"
        exact
        className={s.link}
        activeClassName={s.activeLink}
      >
        Contacts
    </NavLink>}
    </nav>
  )
}