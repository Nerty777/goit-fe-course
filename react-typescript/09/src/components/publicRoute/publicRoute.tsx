import { Route, Redirect, RouteProps } from 'react-router-dom'
import { useSelector } from 'react-redux'

import { authSelectors } from '../../redux/auth'

interface PrivateRouteProps extends RouteProps {
  redirectTo: string
  restricted?: boolean
  children: JSX.Element
}

export default function PublicRoute({
  redirectTo,
  children,
  ...routeProps
}: PrivateRouteProps) {
  const isAuthenticated = useSelector(authSelectors.getIsAuthenticated)

  return (
    <Route {...routeProps}>
      {isAuthenticated && routeProps.restricted ? (
        <Redirect to={redirectTo} />
      ) : (
          children
        )}
    </Route>
  )
}
