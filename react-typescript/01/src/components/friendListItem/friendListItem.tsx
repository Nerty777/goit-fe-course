import React from 'react';

import s from './friendListItem.module.scss'

const FriendListItem = ({ avatar, name, isOnline }: Props): JSX.Element => {
  return (<li className={s.item}>
    <span className={isOnline ? s.online : s.offline}></span>
    <img className={s.avatar} src={avatar} alt={name} width={70} />
    <p className="name">{name}</p>
  </li>)
}

interface Props {
  avatar: string
  name: string
  isOnline: boolean
}

export default FriendListItem