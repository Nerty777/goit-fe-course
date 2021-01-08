import React from 'react'
import s from './profile.module.scss'

const Profile = ({ name, tag, location, avatar, stats }: Props): JSX.Element => {

  return (
    <div className={s.profile}>
      <div className={s.description}>
        <img
          src={avatar}
          alt="user avatar"
          className="avatar"
          width={200}
        />
        <p className="name">{name}</p>
        <p className="tag">{tag}</p>
        <p className="location">{location}</p>
      </div>

      <ul className={s.stats}>
        <li className={s.item}>
          <span className="label">Followers</span>
          <span className="quantity">{stats.followers}</span>
        </li>
        <li className={s.item}>
          <span className="label">Views</span>
          <span className="quantity">{stats.views}</span>
        </li>
        <li className={s.item}>
          <span className="label">Likes</span>
          <span className="quantity">{stats.likes}</span>
        </li>
      </ul>
    </div>
  )
}

export default Profile;

interface Props {
  name: string
  tag: string
  location: string
  avatar: string
  stats: Stats
}

interface Stats {
  followers: number
  views: number
  likes: number
}