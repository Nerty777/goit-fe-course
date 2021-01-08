import React from 'react';

import s from './statistics.module.scss'

const Statistics = ({ title, stats }: Props): JSX.Element => (
  <section className={s.statistics}>
    <h2 className={s.title}>{title}</h2>
    <ul className={s.statList}>
      {stats.map(stat => (
        <li className={s.item} key={stat.id}>
          <span>{stat.label}</span>
          <span className={s.percentage}>{stat.percentage}</span>
        </li>
      )
      )}
    </ul>
  </section>
)

interface Props {
  title: string
  stats: Stats[]
}

interface Stats {
  id: string
  label: string
  percentage: number
}

export default Statistics