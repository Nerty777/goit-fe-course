import React, { useEffect, Suspense, lazy } from 'react'
import { Switch } from 'react-router-dom'
import { useDispatch } from 'react-redux'

import AppBar from '../appBar/appBar'
import { authOperations } from '../../redux/auth/'
import PrivateRoute from '../privateRoute/privateRoute'
import PublicRoute from '../publicRoute/publicRoute'

const Home = lazy(() => import('../../pages/home/home'))
const Register = lazy(() => import('../../pages/register/register'))
const Login = lazy(() => import('../../pages/login/login'))
const Contacts = lazy(() => import('../../pages/contacts/contacts'))

export default function App(): JSX.Element {
  const dispatch = useDispatch()

  useEffect(() => {
    dispatch(authOperations.getCurrentUser())
  }, [dispatch])

  return (
    <div>
      <AppBar />
      <Suspense fallback={<p>Loading...</p>}>
        <Switch>
          <PublicRoute path="/" exact redirectTo="/">
            <Home />
          </PublicRoute>
          <PublicRoute path="/register" restricted redirectTo="/contacts">
            <Register />
          </PublicRoute>
          <PublicRoute path="/login" restricted redirectTo="/contacts">
            <Login />
          </PublicRoute>
          <PrivateRoute path="/contacts" redirectTo="/login">
            <Contacts />
          </PrivateRoute>
        </Switch>
      </Suspense>
    </div >
  )
}
