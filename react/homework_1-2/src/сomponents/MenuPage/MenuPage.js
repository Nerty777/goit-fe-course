import React, { Component, Fragment } from 'react';
import * as API from '../services/api';
import MenuCard from '../MenuCard/MenuCard';
import MenuFilter from '../MenuFilter/MenuFilter';
import Modal from '../Modal/Modal-menu-page';

const BASE_MENU_URL = 'http://localhost:3001/menu';
let showMoreInfoCard = {};

const styles = {
  backdrop: {
    position: 'fixed',
    top: 0,
    left: 0,
    width: '100vw',
    height: '100vh',
    fontSize: '70px',
    color: 'blue',
    display: 'flex',
    justifyContent: 'center',
    alignItems: 'center',
  },
  modal: {
    maxWidth: 600,
    minHeight: 300,
    backgroundColor: '#fff',
    padding: 16,
  },
  red: {
    color: 'red',
    fontSize: '40px',
  },
};

const filterMenu = (menu, filter) =>
  menu.filter(menuItem => {
    return menuItem.name.toLowerCase().includes(filter.toLowerCase());
  });

export default class MenuPage extends Component {
  state = {
    menuList: [],
    isModalOpen: false,
    filter: '',
    isLoading: false,
    error: null,
    isLoadingModal: false,
  };

  componentDidMount() {
    this.setState({ isLoading: true });
    API.getAllItems(BASE_MENU_URL)
      .then(menuList => {
        this.setState({ menuList, isLoading: false });
      })
      .catch(error => this.setState({ error, isLoading: false }));
  }

  handleFilterChange = e => {
    this.setState({
      filter: e.target.value,
    });
  };

  handleDeleteCard = id => {
    API.deleteItem(BASE_MENU_URL, id)
      .then(isOk => {
        if (!isOk) return;
        this.setState(state => ({
          menuList: state.menuList.filter(item => item.id !== id),
        }));
      })
      .catch(error => this.setState({ error, isLoading: false }));
  };

  onShowMoreInfo = id => {
    this.setState({ isLoadingModal: true });
    API.getItemById(BASE_MENU_URL, id)
      .then(isOk => {
        if (!isOk) return;
        showMoreInfoCard = isOk;
        setTimeout(() => {
          this.openModal();
        }, 500);
      })
      .catch(error =>
        this.setState({ error, isLoading: false, isLoadingModal: false }),
      );
  };

  handleAddNewMenuCard = () => {
    const item = {
      name: `Name ${Date.now()}`,
      price: Math.round(Math.random() * 100),
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

    API.addItem(BASE_MENU_URL, item)
      .then(newItem => {
        this.setState(state => ({
          menuList: [...state.menuList, newItem],
        }));
      })
      .catch(error => this.setState({ error, isLoading: false }));
  };

  openModal = () => {
    this.setState({
      isModalOpen: true,
      isLoadingModal: false,
    });
  };

  closeModal = () => {
    this.setState({
      isModalOpen: false,
    });
  };

  render() {
    const {
      menuList,
      filter,
      isLoading,
      isModalOpen,
      error,
      isLoadingModal,
    } = this.state;
    const filteredMenu = filterMenu(menuList, filter);
    return (
      <Fragment>
        <MenuFilter
          filter={filter}
          handleFilterChange={this.handleFilterChange}
        />
        {error && <p style={styles.red}>{error.message}</p>}
        {isLoading && <p>Loading...</p>}
        {isLoadingModal && (
          <p className="isLoadingModal" style={styles.backdrop}>
            Loading...
          </p>
        )}
        <ul>
          {filteredMenu.map(item => {
            const { id, name, image, price, description, ingredients } = item;
            return (
              <li key={id}>
                <MenuCard
                  name={name}
                  image={image}
                  price={price}
                  description={description}
                  ingredients={ingredients}
                  onShowMoreInfo={() => this.onShowMoreInfo(id)}
                  onDeleteCard={() => this.handleDeleteCard(id)}
                />
              </li>
            );
          })}
        </ul>
        <button type="button" onClick={this.handleAddNewMenuCard}>
          New menu card
        </button>
        {isModalOpen && (
          <Modal onClose={this.closeModal} text={showMoreInfoCard} />
        )}
      </Fragment>
    );
  }
}
