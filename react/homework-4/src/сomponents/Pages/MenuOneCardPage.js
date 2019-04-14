import React, { Component } from 'react';
import MenuCard from '../../modules/menu/components/MenuOneCardPage';

export default class MenuPage extends Component {
  state = {};

  render() {
    const { location, history } = this.props;
    return (
      <section className="menupage">
        <MenuCard location={location} history={history} />
      </section>
    );
  }
}
