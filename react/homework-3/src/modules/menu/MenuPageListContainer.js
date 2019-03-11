import React, { Component } from 'react';
import { NavLink } from 'react-router-dom';
import queryString from 'query-string';
import * as API from '../../services/api';
import MenuPageListView from './MenuPageList/MenuPageListView';
import MenuFilter from './MenuFilter/MenuFilter';
import ModalMenuPage from '../../сomponents/Modal/ModalMenuPage';
import MenuCategorySelector from './MenuCategorySelector/MenuCategorySelector';
import routes from '../../configs/routes';
import s from './MenuPageListContainer.module.css';

let showMoreInfoCard = {};

const getCategoryFromProps = props =>
  queryString.parse(props.location.search).category;

const filterMenu = (menu, filter) =>
  menu.filter(menuItem => {
    return menuItem.name.toLowerCase().includes(filter.toLowerCase());
  });

export default class MenuPageListContainer extends Component {
  state = {
    menuList: [],
    isModalOpen: false,
    filter: '',
    isLoading: false,
    error: null,
    categories: [],
  };

  async componentDidMount() {
    this.setState({ isLoading: true });
    const category = getCategoryFromProps(this.props);
    try {
      const categories = await API.getAllCategoryItems();
      this.setState(() => ({
        categories,
        isLoading: false,
      }));
    } catch (error) {
      this.setState({ error, isLoading: false });
    }

    if (!category) {
      const { history, location } = this.props;
      return history.replace({
        pathname: location.pathname,
        search: 'category=all',
      });
    }
    return this.fetchMenuByCategory(category);
  }

  componentDidUpdate(prevProps) {
    const prevCategory = getCategoryFromProps(prevProps);
    const nextCategory = getCategoryFromProps(this.props);
    if (prevCategory === nextCategory) return;
    if (prevCategory && !nextCategory) {
      const { history, location } = this.props;
      history.replace({
        pathname: location.pathname,
        search: 'category=all',
      });
      return;
    }
    this.fetchMenuByCategory(nextCategory);
  }

  handleFilterChange = e => {
    this.setState({
      filter: e.target.value,
    });
  };

  handleDeleteCard = async id => {
    this.setState({ isLoading: true });
    try {
      const isOk = await API.deleteItem(id);
      if (!isOk) return;
      this.setState(state => ({
        menuList: state.menuList.filter(item => item.id !== id),
        isLoading: false,
      }));
    } catch (error) {
      this.setState({ error, isLoading: false });
    }
  };

  handleShowMoreInfo = async id => {
    this.setState({ isLoading: true });
    try {
      const isOk = await API.getMenuItemById(id);
      if (!isOk) return;
      showMoreInfoCard = isOk;
      setTimeout(() => {
        this.openModal();
        this.setState({
          isLoading: false,
        });
      }, 500);
    } catch (error) {
      this.setState({ error, isLoading: false });
    }
  };

  handleAddNewMenuCard = async () => {
    const item = {
      name: `Name ${Date.now()}`,
      price: Math.round(Math.random() * 100),
      category: 'salad',
      ingredients: [
        'Сливочное масло',
        'Пшеничная мука',
        'Голубика',
        'Ванильный экстракт',
        'Мускатный орех',
      ],
      description:
        'Культовая ягода, которую научились производить круглый год, в сочетании с рыхлым тестом — это абсолютно беспроигрышный вариант. Маффины с голубикой стали популярным десертом в Англии и Америке, хотя происхождение их французское. Да и вообще эти маленькие сладкие кексы, какими мы их знаем сейчас, задумывались как обычный хлеб и на вкус были нейтральны.',
      image:
        'https://s1.eda.ru/StaticContent/Photos/120214131925/120214132229/p_O.jpg',
    };

    this.setState({ isLoading: true });
    try {
      const newItem = await API.addItem(item);
      this.setState(state => ({
        menuList: [...state.menuList, newItem],
        isLoading: false,
      }));
    } catch (error) {
      this.setState({ error, isLoading: false });
    }
  };

  openModal = () => {
    this.setState({
      isModalOpen: true,
      isLoading: true,
    });
  };

  closeModal = () => {
    this.setState({
      isModalOpen: false,
    });
  };

  fetchMenuByCategory = async category => {
    try {
      const menuList = await API.getMenuItemsWithCategory(category);
      this.setState({
        menuList,
        isLoading: false,
      });
    } catch (error) {
      this.setState({ error, isLoading: false });
    }
  };

  handleCategoryChange = category => {
    const { history, location } = this.props;
    history.push({
      pathname: location.pathname,
      search: `category=${category}`,
    });
  };

  render() {
    const {
      menuList,
      filter,
      isLoading,
      isModalOpen,
      error,
      categories,
    } = this.state;

    const currentCategory = getCategoryFromProps(this.props);
    const { match } = this.props;
    const filteredMenu = filterMenu(menuList, filter);

    return (
      <section className={s.menupage}>
        <MenuFilter
          filter={filter}
          handleFilterChange={this.handleFilterChange}
        />
        {error && <p className={s.red}>{error.message}</p>}
        {isLoading && <p className={s.loading}>Loading...</p>}
        <MenuCategorySelector
          options={['all', ...categories.map(item => item.name)]}
          value={currentCategory}
          onChange={this.handleCategoryChange}
        />
        <NavLink
          className={s.link}
          activeClassName={s.link_hover}
          to={routes.MENU_ADD_ITEM}
        >
          +Add new menu card
        </NavLink>
        <MenuPageListView
          filteredMenu={filteredMenu}
          match={match}
          handleDeleteCard={this.handleDeleteCard}
          handleShowMoreInfo={this.handleShowMoreInfo}
        />
        <button type="button" onClick={this.handleAddNewMenuCard}>
          Add new menu card
        </button>
        {isModalOpen && (
          <ModalMenuPage onClose={this.closeModal} text={showMoreInfoCard} />
        )}
      </section>
    );
  }
}
