import React, { Component } from 'react';
import PageList from '../../modules/menu/components/MenuPageList';

export default class MenuPage extends Component {
  state = {};

  render() {
    const { location, history } = this.props;
    return (
      <section className="menupage">
        <PageList location={location} history={history} />
      </section>
    );
  }
}
