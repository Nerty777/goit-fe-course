import React from 'react';
import { Route, Redirect, RouteProps } from 'react-router-dom'
import { connect } from 'react-redux'

import { AppStateType } from '../../types/types'
import { authSelectors } from '../../redux/auth'

interface PrivateRouteProps extends RouteProps {
  redirectTo: string
  isAuthenticated: boolean
  component: any
}

const PrivateRoute = ({
  component: Component,
  isAuthenticated,
  redirectTo,
  ...routeProps
}: PrivateRouteProps) => (
  <Route
    {...routeProps}
    render={
      props => isAuthenticated
        ? <Component {...props} />
        : <Redirect to={redirectTo} />
    }
  />
)

const mapStateToProps = (state: AppStateType) => ({
  isAuthenticated: authSelectors.getIsAuthenticated(state),
})

export default connect(mapStateToProps)(PrivateRoute)
