import React, { Component } from 'react';
import MenuAddItem from '../../modules/menu/components/MenuAddItem';

export default class MenuAddItemPage extends Component {
  state = {};

  render() {
    const { location, history } = this.props;
    return (
      <section className="menupage">
        <MenuAddItem location={location} history={history} />
      </section>
    );
  }
}
