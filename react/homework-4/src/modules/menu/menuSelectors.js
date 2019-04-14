import { createSelector } from 'reselect';

const getMenuItems = state => state.menu.items;
const getMenuOneItem = state => state.menu.menuOneItem;
const getAllCategories = state => state.menu.categories;
const modalStatus = state => state.menu.modalStatus;
const getFilter = state => state.menu.filter.toLowerCase();

export const getFilteredMenuItems = createSelector(
  [getMenuItems, getFilter],
  (itemsArray, filter) =>
    itemsArray.filter(e => e.name.toLowerCase().includes(filter)),
);

export const getMenuOneItemForModal = createSelector(
  [getMenuItems, getMenuOneItem],
  (itemsArray, id) => itemsArray.find(item => item.id === id),
);

export default {
  getMenuItems,
  getMenuOneItem,
  getAllCategories,
  modalStatus,
  getFilteredMenuItems,
  getMenuOneItemForModal,
};
