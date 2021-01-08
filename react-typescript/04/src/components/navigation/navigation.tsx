import React from 'react'
import { NavLink } from 'react-router-dom'

import { Routes } from '../../routes/routes'

import s from './navigation.module.scss'

const Navigation = (): JSX.Element => {
  return (
    <nav className={s.nav}>
      <ul className={s.list}>
        <li className={s.item}>
          <NavLink
            className={s.link}
            activeClassName={s.activeLink}
            exact
            to={Routes.homePage}
          >
            Home
        </NavLink>
        </li>
        <li className={s.item}>
          <NavLink
            className={s.link}
            activeClassName={s.activeLink}
            to={Routes.moviesPage}
          >
            Movies
        </NavLink>
        </li>
      </ul>
    </nav>
  )
}

export default Navigation