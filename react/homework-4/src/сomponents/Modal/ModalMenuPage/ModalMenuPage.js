import React from 'react';
import s from './ModalMenuPage.module.css';

const ModalMenuPage = ({ menuOneItemForModal, onClose }) => (
  <div className={s.modal}>
    <img
      src={menuOneItemForModal.image}
      alt={menuOneItemForModal.name}
      width="150"
      height="auto"
    />
    <p className="modal__text">id: {menuOneItemForModal.id}</p>
    <p className="modal__text">Название: {menuOneItemForModal.name}</p>
    <p className="modal__text">Цена: {menuOneItemForModal.price}$</p>
    <p className="modal__text">Описание: {menuOneItemForModal.description}</p>
    <p className="modal__text">
      Состав:{' '}
      {menuOneItemForModal.ingredients &&
        menuOneItemForModal.ingredients.map(item => `${item}. `)}
    </p>
    <button type="button" onClick={onClose}>
      Close
    </button>
  </div>
);

export default ModalMenuPage;
