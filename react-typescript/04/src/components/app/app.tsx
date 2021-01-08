import React, { Suspense, lazy } from 'react'
import { Switch, Route, Redirect } from 'react-router-dom'
import Loader from 'react-loader-spinner'

import { Routes } from '../../routes/routes'
import Navigation from '../navigation/navigation'

import s from './app.module.scss'

const HomePage = lazy(() => import(
  '../homePage/homePage' /* webpackChunkName: "home-page" */
))
const MoviesPage = lazy(() => import(
  '../moviesPage/moviesPage' /* webpackChunkName: "movies-page" */
))
const MovieDetailsPage = lazy(() => import(
  '../movieDetailsPage/movieDetailsPage' /* webpackChunkName: "movie-details-page" */
))

const App = () => {
  return (
    <>
      <Navigation />
      <Suspense fallback={<div className={s.loader}>
        <Loader
          type="Puff"
          color="#00BFFF"
          height={50}
          width={50}
        />
      </div>}>
        <Switch>
          <Route path={Routes.homePage} exact component={HomePage} />
          <Route path={Routes.movieDetailsPage} component={MovieDetailsPage} />
          <Route path={Routes.moviesPage} component={MoviesPage} />
          <Redirect to="/" />
        </Switch>
      </Suspense>
    </>
  )
}

export default App
