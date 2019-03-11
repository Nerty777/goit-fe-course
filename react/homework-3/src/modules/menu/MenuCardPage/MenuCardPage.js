import React, { Component } from 'react';
import s from './MenuCardPage.module.css';
import * as API from '../../../services/api';

export default class MenuCardPage extends Component {
  state = {
    id: null,
    image: null,
    name: null,
    price: null,
    category: null,
    description: null,
    ingredients: null,
    isLoading: false,
    error: null,
  };

  async componentDidMount() {
    const { match } = this.props;
    this.setState({ isLoading: true });
    try {
      const article = await API.getMenuItemById(match.params.id);
      if (!article) return;
      this.setState({ ...article, isLoading: false });
    } catch (error) {
      this.setState({ error, isLoading: false });
    }
  }

  handleGoBack = () => {
    const { category } = this.state;
    const { history, location } = this.props;

    if (location.state) {
      return history.push(location.state.from);
    }

    return history.push({
      pathname: '/menu',
      search: `?category=${category}`,
    });
  };

  render() {
    const {
      id,
      name,
      image,
      price,
      category,
      description,
      ingredients,
      isLoading,
      error,
    } = this.state;

    return (
      <div className={s.container}>
        {error && <p className={s.red}>{error.message}</p>}
        {isLoading && <p>Loading...</p>}
        {!error && (
          <div className="wrapper">
            <button type="button" onClick={this.handleGoBack}>
              Back to menu
            </button>
            <img
              className={s.img}
              src={image}
              alt={name}
              width="150"
              height="auto"
            />
            <div className={s.id}>ID: {id}</div>
            <div className={s.name}>Название: {name}</div>
            <div className={s.price}>Цена: {price}$</div>
            <div className={s.category}>Категория: {category}</div>
            <div className={s.description}>Описание: {description}</div>
            {ingredients && (
              <div className={s.ingredients}>
                Состав: {ingredients.map(item => `${item}. `)}
              </div>
            )}
          </div>
        )}
      </div>
    );
  }
}
