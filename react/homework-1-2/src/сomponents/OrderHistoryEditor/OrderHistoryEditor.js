import React, { Component } from 'react';

const INITIAL_STATE = {
  address: '',
  rating: '',
  price: '',
};

export default class OrderHistoryEditor extends Component {
  state = { address: '', rating: '', price: '' };

  handleChange = ({ target }) => {
    const { name, value } = target;
    this.setState({ [name]: value });
  };

  handleSubmit = evt => {
    evt.preventDefault();
    const { address, rating, price } = this.state;
    const { onSubmit } = this.props;
    onSubmit(address, rating, price);
    this.reset();
  };

  reset = () => {
    this.setState({ ...INITIAL_STATE });
  };

  render() {
    const { address, rating, price } = this.state;
    return (
      <form onSubmit={this.handleSubmit}>
        <label htmlFor="address">
          Address
          <input
            id="address"
            type="text"
            placeholder="Enter address"
            name="address"
            value={address}
            onChange={this.handleChange}
          />
        </label>
        <br />
        <label htmlFor="price">
          Price
          <input
            id="price"
            type="number"
            placeholder="Enter price"
            name="price"
            value={price}
            onChange={this.handleChange}
          />
        </label>
        <br />
        <span htmlFor="rating">
          Rating
          <select
            id="rating"
            name="rating"
            value={rating}
            onChange={this.handleChange}
          >
            <option value="" disabled>
              ...
            </option>
            <option value="0">0</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
          </select>
        </span>
        <br />
        <button type="submit">Add comment</button>
      </form>
    );
  }
}
