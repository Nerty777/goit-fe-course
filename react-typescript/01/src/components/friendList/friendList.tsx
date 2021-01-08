import React from 'react';
import s from './friendList.module.scss'

import FriendListItem from '../friendListItem/friendListItem'

const FriendList = ({ friends }: Props): JSX.Element => (
  <ul className={s.friendList}>
    {friends.map(friend => (
      <FriendListItem
        key={friend.id}
        avatar={friend.avatar}
        name={friend.name}
        isOnline={friend.isOnline} />
    ))}
  </ul>
)

interface Props {
  friends: Friend[]
}

interface Friend {
  avatar: string
  name: string
  isOnline: boolean
  id: number
}

export default FriendList