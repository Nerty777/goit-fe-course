import { useSelector, useDispatch } from 'react-redux'

import { authSelectors, authOperations } from '../../redux/auth'
import defaultAvatar from './default-avatar.png'

import s from './userMenu.module.scss'

export default function UserMenu(): JSX.Element {
  const dispatch = useDispatch()
  const name = useSelector(authSelectors.getUsername)
  const logOut = () => dispatch(authOperations.logOut())

  return (
    <div className={s.container}>
      <img src={defaultAvatar} alt="" width="32" className={s.avatar} />
      <span className={s.name}>Welcome, {name}</span>
      <button type="button" onClick={logOut}>
        Logout
    </button>
    </div>
  )
}