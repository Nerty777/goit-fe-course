import React from 'react'
import { Route, Redirect, RouteProps } from 'react-router-dom'
import { connect } from 'react-redux'

import { AppStateType } from '../../types/types'
import { authSelectors } from '../../redux/auth'

interface PrivateRouteProps extends RouteProps {
  redirectTo: string
  isAuthenticated: boolean
  component: any
  restricted?: boolean
}

const PublicRoute = ({
  component: Component,
  isAuthenticated,
  redirectTo,
  ...routeProps
}: PrivateRouteProps) => (
  <Route
    {...routeProps}
    render={props =>
      isAuthenticated && routeProps.restricted
        ? <Redirect to={redirectTo} />
        : <Component {...props} />
    }
  />
);

const mapStateToProps = (state: AppStateType) => ({
  isAuthenticated: authSelectors.getIsAuthenticated(state),
});

export default connect(mapStateToProps)(PublicRoute)