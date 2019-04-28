import { connect } from 'react-redux';
import cartActions from './cartActions';
import cartSelectors from './cartSelectors';

import Cart from './Cart';

const mapStateToProps = state => ({
  menu: cartSelectors.getCartMenu(state),
  totalPrice: cartSelectors.totalPrice(state),
});

const mapDispatchToProps = {
  removeFromCart: cartActions.removeFromCart,
  onIncrease: cartActions.increaseAmount,
  onDecrease: cartActions.decreaseAmount,
};

export default connect(
  mapStateToProps,
  mapDispatchToProps,
)(Cart);
