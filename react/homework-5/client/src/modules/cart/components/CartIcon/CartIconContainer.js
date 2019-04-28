import { connect } from 'react-redux';
import CartIcon from './CartIcon';
import cartSelectors from '../Cart/cartSelectors';

const mapState = state => ({
  amount: cartSelectors.getCartMenuAmount(state),
});

export default connect(mapState)(CartIcon);
