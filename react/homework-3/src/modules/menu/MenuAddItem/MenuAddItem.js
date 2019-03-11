import React, { Component } from 'react';
import * as API from '../../../services/api';
import s from './MenuAddItem.module.css';

export default class AddItemMenu extends Component {
  state = {
    name: '',
    image: '',
    price: '',
    category: '',
    description: '',
    ingredients: [],
    categories: [],
    isLoading: false,
    error: '',
  };

  async componentDidMount() {
    this.setState({ isLoading: true });
    try {
      const categories = await API.getAllCategoryItems();
      this.setState(() => ({
        categories,
        isLoading: false,
      }));
    } catch (error) {
      this.setState({ error, isLoading: false });
    }
  }

  handleChange = ({ target }) => {
    const { name, value } = target;
    if (name === 'ingredients') {
      value.split(' ');
      this.setState({ [name]: [value] });
      return;
    }
    this.setState({ [name]: value });
  };

  handleSubmit = async evt => {
    evt.preventDefault();
    const {
      name,
      image,
      price,
      category,
      description,
      ingredients,
    } = this.state;

    const { history } = this.props;

    const item = {
      name,
      price,
      category,
      ingredients,
      description,
      image,
    };
    this.setState({ isLoading: true });
    try {
      const isOk = await API.addItem(item);
      if (!isOk) return;
      this.setState(() => ({
        isLoading: false,
      }));
      setTimeout(() => {
        history.push({
          pathname: '/menu',
        });
      }, 100);
    } catch (error) {
      this.setState({ error, isLoading: false });
    }
  };

  render() {
    const {
      name,
      image,
      price,
      category,
      description,
      ingredients,
      categories,
      error,
      isLoading,
    } = this.state;
    return (
      <>
        {error && <p className={s.red}>{error.message}</p>}
        {isLoading && <p className={s.loading}>Loading...</p>}
        <form className={s.form} onSubmit={this.handleSubmit}>
          <label htmlFor="name" className={s.label}>
            Name
            <input
              className={s.input}
              id="name"
              type="text"
              placeholder="Enter name"
              name="name"
              value={name}
              onChange={this.handleChange}
            />
          </label>
          <br />
          <label htmlFor="url" className={s.label}>
            Photo url
            <input
              className={s.input}
              id="url"
              type="text"
              placeholder="Enter photo url"
              name="image"
              value={image}
              onChange={this.handleChange}
            />
          </label>
          <br />
          <label htmlFor="price" className={s.label}>
            Price
            <input
              className={s.input}
              id="price"
              type="number"
              placeholder="Enter price"
              name="price"
              value={price}
              onChange={this.handleChange}
            />
          </label>
          <br />
          <span htmlFor="category">
            Category
            <select
              id="category"
              name="category"
              value={category}
              onChange={this.handleChange}
            >
              <option value="" disabled>
                ...
              </option>
              {categories.map(item => (
                <option key={item.name} value={item.name}>
                  {item.name}
                </option>
              ))}
            </select>
          </span>
          <br />
          <label htmlFor="description" className={s.label}>
            Description
            <textarea
              rows="10"
              cols="45"
              id="description"
              type="text"
              placeholder="Enter description"
              name="description"
              value={description}
              onChange={this.handleChange}
            />
          </label>
          <br />
          <label htmlFor="ingredients" className={s.label}>
            Ingredients
            <input
              className={s.input}
              id="ingredients"
              type="text"
              placeholder="Enter Ingredients through the gap"
              name="ingredients"
              value={ingredients}
              onChange={this.handleChange}
            />
          </label>
          <br />
          <button type="submit">Add menu card</button>
        </form>
      </>
    );
  }
}
