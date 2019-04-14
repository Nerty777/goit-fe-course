import React from 'react';
import userAvatar from '../../modules/user/UserMenu/userAvatar.jpg';

const Account = () => (
  <section className="account">
    <div className="text">
      <div>
        <img src={userAvatar} alt="user avatar" title="User profile" />
        <p>Name: Bob Ross</p>
        <p>Phone: +38-093-111-11-11</p>
        <p>Email: email@email.com</p>
      </div>
    </div>
  </section>
);

export default Account;
