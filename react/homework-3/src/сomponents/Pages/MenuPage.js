import React from 'react';
import MenuPageListContainer from '../../modules/menu/MenuPageListContainer';

const MenuPage = ({ location, history }) => (
  <section className="menupage">
    <MenuPageListContainer location={location} history={history} />
  </section>
);

export default MenuPage;
