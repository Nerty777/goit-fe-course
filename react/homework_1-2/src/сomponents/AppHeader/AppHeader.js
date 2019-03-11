import React from 'react';
import Logo from '../Logo/Logo';
import Nav from '../Nav/Nav';
import UserMenu from '../UserMenu/UserMenu';
import logoImg from '../Logo/logo.png';
import userAvatar from '../UserMenu/userAvatar.jpg';

const userName = 'Bob Ross';
const appNavItems = ['Menu', 'About', 'Contacts', 'Delivery'];

const AppHeader = () => (
  <header>
    <div className="logo">
      <Logo logoImg={logoImg} />
    </div>
    <div className="nav">
      <Nav appNavItems={appNavItems} />
    </div>
    <div className="usermenu">
      <UserMenu userAvatar={userAvatar} userName={userName} />
    </div>
  </header>
);

export default AppHeader;
