import React, { Component, lazy, Suspense } from 'react';
import { Route, Switch } from 'react-router-dom';
import v4 from 'uuid/v4';
import AppHeader from '../AppHeader/AppHeader';
// import SignInForm from '../SignInForm/SignInForm';
// import SignUpForm from '../SignUpForm/SignUpForm';

import routes from '../../configs/routes';
// import s from './App.module.css';

const AsyncHomePage = lazy(() =>
  import('../Pages/Home' /* webpackChunkName: "home-page" */),
);
const AsyncMenuPage = lazy(() =>
  import('../Pages/MenuPage' /* webpackChunkName: "menu-page" */),
);
const AsyncOrderHistory = lazy(() =>
  import('../Pages/OrderHistory' /* webpackChunkName: "order-history-page" */),
);
const AsyncMenuAddItem = lazy(() =>
  import('../../modules/menu/MenuAddItem/MenuAddItem' /* webpackChunkName: "menu-add-item-page" */),
);
const AsyncMenuCardPage = lazy(() =>
  import('../../modules/menu/MenuCardPage/MenuCardPage' /* webpackChunkName: "menu-card-page" */),
);
const AsyncAboutPage = lazy(() =>
  import('../Pages/About' /* webpackChunkName: "about-page" */),
);
const AsyncContactsPage = lazy(() =>
  import('../Pages/Contacts' /* webpackChunkName: "contacts-page" */),
);
const AsyncDeliveryPage = lazy(() =>
  import('../Pages/Delivery' /* webpackChunkName: "delivery-page" */),
);
const AsyncAccountPage = lazy(() =>
  import('../Pages/Account' /* webpackChunkName: "account-page" */),
);
const AsyncPlannerPage = lazy(() =>
  import('../Pages/Planner' /* webpackChunkName: "planner-page" */),
);
const AsyncNotFoundPage = lazy(() =>
  import('../Pages/NotFound' /* webpackChunkName: "not-found-page" */),
);

export default class App extends Component {
  state = {
    orderHistory: [],
  };

  handleAddComment = (address, rating, price) => {
    this.setState(prevState => ({
      orderHistory: [
        { id: v4(), address, price, rating },
        ...prevState.orderHistory,
      ],
    }));
  };

  handleDeleteComment = id => {
    this.setState(prevState => ({
      orderHistory: prevState.orderHistory.filter(comment => comment.id !== id),
    }));
  };

  render() {
    return (
      <>
        <AppHeader
          logo={<p>Logo</p>}
          nav={<p>Nav</p>}
          usermenu={<p>UserMenu</p>}
        />
        {/* <SignInForm />
        <SignUpForm /> */}
        <Suspense fallback={<div>Loading...</div>}>
          <Switch>
            <Route exact path={routes.HOME} component={AsyncHomePage} />
            <Route exact path={routes.MENU} component={AsyncMenuPage} />
            <Route
              exact
              path={routes.MENU_ADD_ITEM}
              component={AsyncMenuAddItem}
            />
            <Route path="/menu/:id" component={AsyncMenuCardPage} />
            <Route path={routes.ABOUT} component={AsyncAboutPage} />
            <Route path={routes.CONTACTS} component={AsyncContactsPage} />
            <Route path={routes.DELIVERY} component={AsyncDeliveryPage} />
            <Route path={routes.ORDER_HISTORY} component={AsyncOrderHistory} />
            <Route path={routes.ACCOUNT} component={AsyncAccountPage} />
            <Route path={routes.PLANNER} component={AsyncPlannerPage} />
            <Route component={AsyncNotFoundPage} />
            {/* <ProtectedRoute exact path={routes.CART} component={Cart} />
            <Route exact path={routes.SIGNUP} component={SignUpPage} />
            <Route exact path={routes.SINGIN} component={SignInPage} /> */}
          </Switch>
        </Suspense>
      </>
    );
  }
}
