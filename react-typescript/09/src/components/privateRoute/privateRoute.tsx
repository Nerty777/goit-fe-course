import { Route, Redirect, RouteProps } from 'react-router-dom'
import { useSelector } from 'react-redux'

import { authSelectors } from '../../redux/auth'

interface PrivateRouteProps extends RouteProps {
  redirectTo: string
  children: JSX.Element
}

export default function PrivateRoute({
  redirectTo,
  children,
  ...routeProps
}: PrivateRouteProps) {
  const isAuthenticated = useSelector(authSelectors.getIsAuthenticated)

  return (
    <Route {...routeProps}>
      {isAuthenticated ? children : <Redirect to={redirectTo} />}
    </Route>
  )
}

