import React from 'react'
import { connect } from 'react-redux'
import { authSelectors, authOperations } from '../../redux/auth'
import defaultAvatar from './default-avatar.png'
import { AppStateType } from '../../types/types'

import s from './userMenu.module.scss'

interface Props {
  avatar: string
  name: string
  onLogout: () => void
}

const UserMenu = ({ avatar, name, onLogout }: Props): JSX.Element => (
  <div className={s.container}>
    <img src={avatar} alt="" width="32" className={s.avatar} />
    <span className={s.name}>Welcome, {name}</span>
    <button type="button" onClick={onLogout}>
      Logout
    </button>
  </div>
)
const mapStateToProps = (state: AppStateType) => ({
  name: authSelectors.getUsername(state),
  avatar: defaultAvatar,
})

const mapDispatchToProps = {
  onLogout: authOperations.logOut,
}

export default connect(mapStateToProps, mapDispatchToProps)(UserMenu)