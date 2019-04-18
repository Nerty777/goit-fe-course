import React from 'react';
import Logo from '../Logo/Logo';
import Nav from '../Nav/Nav';
import UserMenu from '../../modules/user/UserMenu/UserMenu';
import CartIcon from '../../modules/cart/components/CartIcon/CartIconContainer';
import logoImg from '../Logo/logo.png';
import appNavItems from '../../configs/main-nav';
import s from './AppHeader.module.css';

const AppHeader = () => (
  <header className={s.header}>
    <div className={s.logo}>
      <Logo logoImg={logoImg} width={80} height={80} />
    </div>
    <Nav appNavItems={appNavItems} />
    <CartIcon />
    <div className={s.usermenu}>
      <UserMenu />
    </div>
  </header>
);

export default AppHeader;
