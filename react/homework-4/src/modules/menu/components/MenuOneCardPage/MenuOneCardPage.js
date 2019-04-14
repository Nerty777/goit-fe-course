import React from 'react';
import s from './MenuOneCardPage.module.css';

const MenuCardPage = ({ menuOneItem, handleGoBack }) => (
  <div className={s.container}>
    <div className="wrapper">
      <button className={s.button} type="button" onClick={handleGoBack}>
        Back to menu
      </button>
      <img
        className={s.img}
        src={menuOneItem.image}
        alt={menuOneItem.name}
        width="150"
        height="auto"
      />
      <div className={s.id}>ID: {menuOneItem.id}</div>
      <div className={s.name}>Название: {menuOneItem.name}</div>
      <div className={s.price}>Цена: {menuOneItem.price}$</div>
      <div className={s.category}>Категория: {menuOneItem.category}</div>
      <div className={s.description}>Описание: {menuOneItem.description}</div>
      {menuOneItem.ingredients && (
        <div className={s.ingredients}>
          Состав: {menuOneItem.ingredients.map(ingredient => `${ingredient}. `)}
        </div>
      )}
    </div>
  </div>
);

export default MenuCardPage;
