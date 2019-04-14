import { combineReducers } from 'redux';
import menuReducer from './menu/menuReducer';

export default combineReducers({
  menu: menuReducer,
});

// let store = {
//   menu: {
//     items: [],
//     filter: "",
//     category: []
//     isLoading: false,
//     error: null,
//     modalStatus,
//   },
// };
