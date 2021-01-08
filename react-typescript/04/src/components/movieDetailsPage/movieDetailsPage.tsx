import React, { Component, Suspense, lazy } from 'react'
import { RouteComponentProps, NavLink, Route, Switch } from "react-router-dom"
import Loader from 'react-loader-spinner'

import { detailsMovie } from '../../services/api'
import { Film, LocationProps, TParams } from '../../types/types'
import poster from '../../assets/poster.svg'
import { Routes } from '../../routes/routes'

import s from './movieDetailsPage.module.scss'

const Cast = lazy(() => import(
  '../cast/cast' /* webpackChunkName: "cast-page" */
))
const Reviews = lazy(() => import(
  '../reviews/reviews' /* webpackChunkName: "reviews-page" */
))

interface Genres {
  name: string
  id: number
}

interface State extends Film {
  isLoading: boolean
  error: string | null
  overview: string | null
  genres: Genres[]
  vote_average: number
  location: string
}

export default class MovieDetailsPage extends Component<RouteComponentProps<TParams, any, LocationProps>, State> {
  state: State = {
    original_name: '',
    original_title: '',
    id: null,
    poster_path: '',
    isLoading: true,
    error: null,
    overview: '',
    genres: [],
    vote_average: 0,
    location: ''
  }

  async componentDidMount(): Promise<void> {
    try {
      this.setState({
        isLoading: true,
        error: null,
      })

      if (this.props.location?.state?.from?.pathname) {
        this.setState({
          location: `${this.props.location.state.from.pathname}${this.props.location.state.from.search}`
        })
      }

      const response = await detailsMovie(Number(this.props.match.params.movieId))

      this.setState({ ...response })
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

  handleButton = (): void => {
    if (this.props.location?.state?.from) {
      this.props.history.push(this.state.location)
      return
    }
    this.props.history.push(Routes.homePage)
  }

  render() {
    const { isLoading,
      error,
      original_name,
      original_title,
      poster_path,
      overview,
      genres,
      vote_average,
      location,
    } = this.state

    return (
      <div className={s.container}>
        {isLoading && <div className={s.loader}>
          <Loader
            type="Puff"
            color="#00BFFF"
            height={50}
            width={50}
          />
        </div>}

        <button className={s.button} type="button" onClick={this.handleButton}>&#8592; Go back</button>

        {error && <div>Opps, {error}</div>}

        <div className={s.card}>
          <img
            src={
              poster_path ? `https://image.tmdb.org/t/p/w500/${poster_path}` : poster
            }
            alt={original_name || original_title}
            className={s.img}
          />
          <div className={s.description}>
            <h2>{original_name || original_title}</h2>
            <p>User Score: {vote_average * 10}%</p>
            <h4>Genres</h4>
            <ul>
              {genres.map(genre => <li key={genre.id}>{genre.name}</li>)}
            </ul>
            <h4>Overview</h4>
            <p className={s.overview}>{overview}</p>
            <ul>
              <li>
                <NavLink
                  to={{
                    pathname: `${this.props.match.url}/reviews`,
                    state: { from: location },
                  }}
                  className={s.link}
                  activeClassName={s.activeLink}
                >
                  Reviews
                </NavLink>
              </li>
              <li>
                <NavLink
                  to={{
                    pathname: `${this.props.match.url}/cast`,
                    state: { from: location },
                  }}
                  className={s.link}
                  activeClassName={s.activeLink}
                >
                  Cast
                </NavLink>
              </li>
            </ul>
          </div>
        </div>
        <Suspense fallback={<div className={s.loader}>
          <Loader
            type="Puff"
            color="#00BFFF"
            height={50}
            width={50}
          />
        </div>}>
          <Switch>
            <Route path={Routes.cast} component={Cast} />
            <Route path={Routes.reviews} component={Reviews} />
          </Switch>
        </Suspense>
      </div >
    )
  }
}