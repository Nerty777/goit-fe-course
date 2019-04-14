import React from 'react';

const AppNav = ({ appNavItems }) => (
  <nav>
    <ul>
      {appNavItems.map(item => (
        <li key={item}>
          <a href="/">{item}</a>
        </li>
      ))}
    </ul>
  </nav>
);

export default AppNav;
