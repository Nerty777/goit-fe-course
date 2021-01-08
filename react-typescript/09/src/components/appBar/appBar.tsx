import { useSelector } from 'react-redux'

import Navigation from '../navigation/navigation'
import UserMenu from '../userMenu/userMenu'
import AuthNav from '../authNav/authNav'
import { authSelectors } from '../../redux/auth'

import s from './appBar.module.scss'

export default function AppBar(): JSX.Element {
  const isAuthenticated = useSelector(authSelectors.getIsAuthenticated)

  return (
    <header className={s.header}>
      <Navigation />
      {isAuthenticated ? <UserMenu /> : <AuthNav />}
    </header>
  )
}