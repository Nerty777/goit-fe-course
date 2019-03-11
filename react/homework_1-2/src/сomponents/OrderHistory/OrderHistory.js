import React, { Component, Fragment } from 'react';
import * as API from '../services/api';
import OrderHistoryEditor from '../OrderHistoryEditor/OrderHistoryEditor';
import Modal from '../Modal/Modal-order-history';

const BASE_ORDER_HISTORY_URL = 'http://localhost:3001/order-history';
let showMoreInfoCard = {};

const styles = {
  backdrop: {
    position: 'fixed',
    top: 0,
    left: 0,
    width: '100vw',
    height: '100vh',
    fontSize: '70px',
    color: 'blue',
    display: 'flex',
    justifyContent: 'center',
    alignItems: 'center',
  },
  red: {
    color: 'red',
    fontSize: '40px',
  },
};

export default class OrderHistory extends Component {
  state = {
    orderHistoryList: [],
    isModalOpen: false,
    isLoading: false,
    error: null,
    isLoadingModal: false,
  };

  componentDidMount() {
    API.getAllItems(BASE_ORDER_HISTORY_URL)
      .then(orderHistoryList => {
        this.setState({
          orderHistoryList,
          isLoading: false,
        });
      })
      .catch(error => this.setState({ error, isLoading: false }));
  }

  handleDeleteCard = id => {
    API.deleteItem(BASE_ORDER_HISTORY_URL, id).then(isOk => {
      if (!isOk) return;
      this.setState(state => ({
        orderHistoryList: state.orderHistoryList.filter(item => item.id !== id),
      }));
    });
  };

  onShowMoreInfo = id => {
    this.setState({ isLoadingModal: true });
    API.getItemById(BASE_ORDER_HISTORY_URL, id)
      .then(isOk => {
        if (!isOk) return;
        showMoreInfoCard = isOk;
        setTimeout(() => {
          this.openModal();
        }, 500);
      })
      .catch(error =>
        this.setState({ error, isLoading: false, isLoadingModal: false }),
      );
  };

  handleAddNewOrderHistoryCard = (address, rating, price) => {
    const date = new Date();
    const year = date.getFullYear();
    const month = date.getMonth() + 1;
    const dateNumber = date.getDate();
    const newItemOrderHistory = {
      date: `${month}/${dateNumber}/${year}`,
      price: `${price}.00`,
      address: `${address}`,
      rating: `${rating}`,
    };
    API.addItem(BASE_ORDER_HISTORY_URL, newItemOrderHistory)
      .then(newItem => {
        this.setState(state => ({
          orderHistoryList: [...state.orderHistoryList, newItem],
        }));
      })
      .catch(error =>
        this.setState({ error, isLoading: false, isLoadingModal: false }),
      );
  };

  openModal = () => {
    this.setState({
      isModalOpen: true,
      isLoadingModal: false,
    });
  };

  closeModal = () => {
    this.setState({
      isModalOpen: false,
    });
  };

  render() {
    const {
      orderHistoryList,
      isModalOpen,
      isLoading,
      error,
      isLoadingModal,
    } = this.state;
    return (
      <Fragment>
        <hr />
        {error && <p style={styles.red}>{error.message}</p>}
        {isLoading && <p>Loading...</p>}
        {isLoadingModal && (
          <p className="isLoadingModal" style={styles.backdrop}>
            Loading...
          </p>
        )}
        <table border="1">
          <tbody>
            <tr>
              <th>Date</th>
              <th>Price</th>
              <th>Delivery address</th>
              <th>Rating</th>
            </tr>
            {orderHistoryList.map(item => {
              const { id, date, price, address, rating } = item;
              return (
                <tr key={id}>
                  <td>{date}</td>
                  <td>{price}$</td>
                  <td>{address}</td>
                  <td>{rating}/10</td>
                  <td>
                    <button
                      type="button"
                      onClick={() => this.onShowMoreInfo(id)}
                    >
                      More info
                    </button>
                  </td>
                  <td>
                    <button
                      type="button"
                      onClick={() => this.handleDeleteCard(id)}
                    >
                      Delete
                    </button>
                  </td>
                </tr>
              );
            })}
          </tbody>
        </table>
        <br />
        <OrderHistoryEditor onSubmit={this.handleAddNewOrderHistoryCard} />
        {isModalOpen && (
          <Modal onClose={this.closeModal} text={showMoreInfoCard} />
        )}
      </Fragment>
    );
  }
}
