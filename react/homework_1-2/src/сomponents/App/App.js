import React, { Component, Fragment } from 'react';
import v4 from 'uuid/v4';
import AppHeader from '../AppHeader/AppHeader';
import OrderHistory from '../OrderHistory/OrderHistory';
import MenuPage from '../MenuPage/MenuPage';
import SignInForm from '../SignInForm/SignInForm';
import SignUpForm from '../SignUpForm/SignUpForm';
import Modal from '../Modal/Modal';

export default class App extends Component {
  state = {
    orderHistory: [],
    isModalOpen: false,
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

  openModal = () => {
    this.setState({
      isModalOpen: true,
    });
  };

  closeModal = () => {
    this.setState({
      isModalOpen: false,
    });
  };

  render() {
    const { isModalOpen } = this.state;

    return (
      <Fragment>
        <AppHeader
          logo={<p>Logo</p>}
          nav={<p>Nav</p>}
          usermenu={<p>UserMenu</p>}
        />
        <OrderHistory />
        <br />
        <hr />
        <MenuPage />
        <hr />
        <SignInForm />
        <hr />
        <SignUpForm />
        <br />
        <button type="button" onClick={this.openModal}>
          Open modal
        </button>
        {isModalOpen && <Modal onClose={this.closeModal} />}
        <br />
        <br />
      </Fragment>
    );
  }
}
