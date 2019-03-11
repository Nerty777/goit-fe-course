import React from 'react';

export default ({
  name,
  image,
  price,
  description,
  ingredients,
  onShowMoreInfo,
  onDeleteCard,
}) => (
  <div>
    <img src={image} alt={name} width="150" height="auto" />
    <div>{name}</div>
    <div>{price}$</div>
    <div>Описание: {description}</div>
    <div>Состав: {ingredients.map(ingredient => `${ingredient}. `)}</div>
    <div className="actions">
      <button type="button" onClick={onShowMoreInfo}>
        More info
      </button>
      <button type="button" onClick={onDeleteCard}>
        Delete
      </button>
      <br />
      <br />
    </div>
  </div>
);
