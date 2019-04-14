import React, { Fragment } from 'react';

const UserMenu = ({ userAvatar, userName }) => (
  <Fragment>
    <img className="image" src={userAvatar} alt="user logo" title="user logo" />
    <span>{userName}</span>
  </Fragment>
);

export default UserMenu;
