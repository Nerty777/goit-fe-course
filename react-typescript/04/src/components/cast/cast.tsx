import React, { Component } from 'react'
import { RouteComponentProps } from 'react-router-dom'
import Loader from 'react-loader-spinner'

import { TParams, ICast } from '../../types/types'
import { getCast } from '../../services/api'
import poster from '../../assets/poster.svg'

import s from './cast.module.scss'

interface State {
  cast: ICast[]
  isLoading: boolean
  error: string | null
  isNotFound: boolean
}

export default class Cast extends Component<RouteComponentProps<TParams>, State> {
  state: State = {
    cast: [],
    isLoading: false,
    error: null,
    isNotFound: false,
  }

  async componentDidMount(): Promise<void> {
    try {
      this.setState({
        isLoading: true,
        error: null,
        isNotFound: false
      })

      const movieId = this.props.match.params.movieId
      const response = await getCast(Number(movieId))

      if (!response.length) {
        this.setState({
          isNotFound: true
        })
      }

      this.setState({ cast: [...response] })
    } catch (error) {
      this.setState({
        error: error.message
      })
    }
    finally {
      this.setState({
        isLoading: false
      })
    }
  }

  render() {
    const { cast, isLoading, error, isNotFound } = this.state

    return (
      <>
        {isLoading && <div className={s.center}>
          <Loader
            type="Puff"
            color="#00BFFF"
            height={50}
            width={50}
          />
        </div>}
        {error && <div className={s.center}>Opps, {error}</div>}
        {isNotFound && <div className={s.center}>Opps, not found</div>}
        {cast.length > 0 && <ul className={s.list}>
          {cast.map(item => (
            <li
              className={s.item}
              key={item.cast_id}
            >
              <img
                src={
                  item.profile_path ? `https://image.tmdb.org/t/p/w500/${item.profile_path}` : poster
                }
                alt={item.name}
                width={100}
              />
              <h3>{item.name}</h3>
              {item.character && <p>Character: {item.character}</p>}
            </li>
          ))}
        </ul>}
      </>
    )
  }
}