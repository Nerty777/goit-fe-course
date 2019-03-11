import React from 'react';
import MenuCard from '../MenuCard/MenuCard';
import s from './MenuPageListView.module.css';

const MenuPageListView = ({
  filteredMenu,
  match,
  handleDeleteCard,
  handleShowMoreInfo,
}) => (
  <ul className={s.list}>
    {filteredMenu.map(item => {
      const {
        id,
        name,
        image,
        price,
        description,
        ingredients,
        category,
      } = item;
      return (
        <li className={s.item} key={id}>
          <MenuCard
            match={match}
            id={id}
            name={name}
            image={image}
            price={price}
            category={category}
            description={description}
            ingredients={ingredients}
            onShowMoreInfo={() => handleShowMoreInfo(id)}
            onDeleteCard={() => handleDeleteCard(id)}
          />
        </li>
      );
    })}
  </ul>
);

export default MenuPageListView;
