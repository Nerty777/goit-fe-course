import { combineReducers } from 'redux';
import menuReducer from './menu/menuReducer';
import cartReducer from './cart/components/Cart/cartReducer';

export default combineReducers({
  menu: menuReducer,
  cart: cartReducer,
});
