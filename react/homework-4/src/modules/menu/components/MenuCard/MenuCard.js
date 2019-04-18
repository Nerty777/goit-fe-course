import React from 'react';
import { Link, withRouter } from 'react-router-dom';
import s from './MenuCard.module.css';

const MenuCard = ({
  id,
  name,
  image,
  price,
  category,
  description,
  ingredients,
  onShowMoreInfo,
  onDeleteCard,
  match,
  location,
  addToCart,
}) => (
  <div className={s.container}>
    <Link
      to={{
        pathname: `${match.url}/${id}`,
        state: { from: location },
      }}
    >
      <img className={s.img} src={image} alt={name} width="150" height="auto" />
    </Link>
    <div className={s.name}>{name}</div>
    <div className={s.price}>{price}$</div>
    <div className={s.category}>Категория: {category}</div>
    <div className={s.description}>Описание: {description}</div>
    <div className={s.ingredients}>
      Состав: {ingredients.map(ingredient => `${ingredient} `)}
    </div>
    <div className="actions">
      <button type="button" onClick={onShowMoreInfo}>
        More info
      </button>
      <button type="button" onClick={onDeleteCard}>
        Delete
      </button>
      <button type="button" onClick={addToCart}>
        Add to cart
      </button>
    </div>
  </div>
);

export default withRouter(MenuCard);
