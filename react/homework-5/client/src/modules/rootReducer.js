import { combineReducers } from 'redux';
import menuReducer from './menu/menuReducer';
import cartReducer from './cart/components/Cart/cartReducer';
import authReducer from './auth/authReducer';

export default combineReducers({
  menu: menuReducer,
  cart: cartReducer,
  session: authReducer,
});
