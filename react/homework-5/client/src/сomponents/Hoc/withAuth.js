import React, { Component } from 'react';
import { connect } from 'react-redux';
import * as selectors from '../../modules/auth/authSelectors';

const withAuth = WrapperComponent => {
  class WithAuth extends Component {

    componentDidUpdate() {
      if (this.props.isAuthenticated) {
        const { from } = this.props.location.state || { from: { pathname: "/" } };
        this.props.history.replace(from);
      }
    }

    render() {
      return <WrapperComponent {...this.props} />;
    }
  }

  const mapState = state => ({
    isAuthenticated: selectors.isAuthenticated(state),
  });

  return connect(mapState)(WithAuth);
};

export default withAuth;
