import React, { Component } from 'react';
import { connect } from 'react-redux';
import { compose } from 'redux';
import { withRouter } from 'react-router-dom';
import menuOperations from '../../menuOperations';
import menuSelectors from '../../menuSelectors';
import MenuCardPage from './MenuOneCardPage';
import routes from '../../../../configs/routes';

class MenuCardPageContainer extends Component {
  componentDidMount() {
    const { match, fetchItemById } = this.props;
    fetchItemById(match.params.id);
  }

  handleGoBack = () => {
    const { location, history, category } = this.props;
    if (location.state) {
      history.push(location.state.from);
    } else {
      history.push({ pathname: routes.MENU, search: `category=${category}` });
    }
  };

  render() {
    const { menuOneItem } = this.props;
    return (
      <MenuCardPage
        menuOneItem={menuOneItem}
        handleGoBack={this.handleGoBack}
      />
    );
  }
}

const mapStateToProps = state => ({
  menuOneItem: menuSelectors.getMenuOneItem(state),
});

const mapDispatchToProps = {
  fetchItemById: menuOperations.fetchMenuOneItem,
};

export default compose(
  withRouter,
  connect(
    mapStateToProps,
    mapDispatchToProps,
  ),
)(MenuCardPageContainer);
