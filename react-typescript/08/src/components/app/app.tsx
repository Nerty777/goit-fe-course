import React, { useEffect, Suspense, lazy } from 'react'
import { Switch } from 'react-router-dom';
import { connect } from 'react-redux'

import AppBar from '../appBar/appBar'
import { authOperations } from '../../redux/auth/'
import PrivateRoute from '../privateRoute/privateRoute'
import PublicRoute from '../publicRoute/publicRoute'

interface Props {
  onGetCurrentUser: () => void
}

const Home = lazy(() => import('../../pages/home/home'));
const Register = lazy(() => import('../../pages/register/register'));
const Login = lazy(() => import('../../pages/login/login'));
const Contacts = lazy(() => import('../../pages/contacts/contacts'));

const App = ({ onGetCurrentUser }: Props): JSX.Element => {
  useEffect(() => {
    onGetCurrentUser()
  }, [onGetCurrentUser])

  return (
    <div>
      <AppBar />
      <Suspense fallback={<p>Loading...</p>}>
        <Switch>
          <PublicRoute path="/" exact component={Home} redirectTo="/" />
          <PublicRoute path="/register" component={Register} restricted redirectTo="/contacts" />
          <PublicRoute path="/login" component={Login} restricted redirectTo="/contacts" />
          <PrivateRoute path="/contacts" component={Contacts} redirectTo="/login" />
        </Switch>
      </Suspense>
    </div>
  )
}

const mapDispatchToProps = {
  onGetCurrentUser: authOperations.getCurrentUser,
};

export default connect(null, mapDispatchToProps)(App);
