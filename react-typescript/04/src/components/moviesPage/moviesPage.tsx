import React, { Component } from 'react'
import { RouteComponentProps } from "react-router-dom"
import Loader from 'react-loader-spinner'
import qs from 'qs'

import { searchMovie } from '../../services/api'
import { Film, LocationProps } from '../../types/types'
import MovieList from '../movieList/movieList'

import s from './moviesPage.module.scss'

interface Search {
  search: string
}

interface State extends Search {
  films: Film[]
  isLoading: boolean
  error: string | null
  isNotFound: boolean
}

const INITIALSTATE: State = {
  search: '',
  films: [],
  error: null,
  isLoading: false,
  isNotFound: false
}

export default class MoviesPage extends Component<RouteComponentProps<{}, any, LocationProps>, State> {
  state: State = {
    ...INITIALSTATE
  }

  async componentDidMount() {
    if (this.props.location.search) {
      const prefixed = qs.parse(this.props.location.search, { ignoreQueryPrefix: true });
      const search = prefixed['query'] as string

      await this.setState({
        search,
      })

      await this.fetchMovies()
    }
  }

  handleInput = ({ target }: React.ChangeEvent<HTMLInputElement>): void => {
    const { name, value } = target

    this.setState(
      { [name]: value } as Pick<Search, keyof Search>
    )
  }

  fetchMovies = async () => {
    try {
      this.setState({
        isLoading: true,
        error: null,
        isNotFound: false
      })

      if (!this.state.search) {
        return
      }

      const films = await searchMovie(this.state.search)

      if (!films.length) {
        this.setState({
          isNotFound: true
        })
      }

      this.setState({ films })

      this.props.history.push(`${this.props.match.url}?query=${this.state.search}`)

      this.resetForm()
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

  handleSubmit = async (e: React.FormEvent<HTMLFormElement>): Promise<void> => {
    e.preventDefault()
    this.fetchMovies()
  }

  resetForm = (): void => {
    this.setState({
      search: ''
    })
  }

  render() {
    const { search, films, error, isLoading, isNotFound } = this.state

    return (
      <>
        <form className={s.form} onSubmit={this.handleSubmit}>
          <input
            className={s.input}
            name="search"
            type="text"
            value={search}
            onChange={this.handleInput}
            autoFocus
            placeholder="Enter movie name"
          />
          <button type="submit" className={s.button}>Search</button>
        </form>
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
        {films.length > 0 && <MovieList films={films} />}
      </>
    )
  }
}