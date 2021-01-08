import React from 'react'
import { Link, withRouter, RouteComponentProps } from 'react-router-dom'

import { Film } from '../../types/types'
import { Routes } from '../../routes/routes'
import poster from '../../assets/poster.svg'

import s from './movieList.module.scss'

interface Props extends RouteComponentProps {
  films: Film[]
}

const MovieList = ({ films, location }: Props): JSX.Element => {
  return (
    <ul className={s.list}>
      {films.map(film => (
        <li key={film.id} className={s.item}>
          <Link className={s.link} to={{
            pathname: `${Routes.moviesPage}/${film.id}`,
            state: {
              from: location
            }
          }}>
            <img
              src={
                film.poster_path ? `https://image.tmdb.org/t/p/w500/${film.poster_path}` : poster
              }
              alt={film.original_name || film.original_title}
              width={100}
            />
            {film.original_name || film.original_title}
          </Link>
        </li>
      ))}
    </ul>
  )
}

export default withRouter(MovieList)