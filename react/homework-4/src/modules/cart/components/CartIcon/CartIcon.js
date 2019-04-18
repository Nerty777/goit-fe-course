import React from 'react';
import { Link } from 'react-router-dom';
import s from './CartIcon.module.css';

const CartIcon = ({ amount = 7 }) => (
  <div className={s.container}>
    <Link to="/cart">
      <img
        src="https://image.flaticon.com/icons/svg/263/263142.svg"
        width="50"
        alt=""
      />
      <span className={s.amount}>{amount}</span>
    </Link>
  </div>
);

export default CartIcon;
