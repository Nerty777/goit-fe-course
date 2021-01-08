import React, { Component } from 'react'
import Loader from 'react-loader-spinner'

import { getMovieTrending } from '../../services/api'
import { Film } from '../../types/types'
import MovieList from '../movieList/movieList'

import s from './homePage.module.scss'

interface State {
  films: Film[]
  error: string | null
  isLoading: boolean
}

export default class HomePage extends Component<{}, State> {
  state: State = {
    films: [],
    error: null,
    isLoading: false,
  }

  async componentDidMount(): Promise<void> {
    try {
      this.setState({
        isLoading: true
      })

      const films = await getMovieTrending()

      this.setState({ films })
    } catch (error) {
      this.setState({
        error: error.message
      })
    } finally {
      this.setState({
        isLoading: false
      })
    }
  }

  render() {
    const { films, error, isLoading } = this.state

    return (
      <div>
        <h2 className={s.title}>Trending today</h2>
        {isLoading && <div className={s.loader}>
          <Loader
            type="Puff"
            color="#00BFFF"
            height={50}
            width={50}
          />
        </div>}
        {error && <div>Opps, {error}</div>}
        {films.length > 0 && <MovieList films={films} />}
      </div>
    )
  }
}
