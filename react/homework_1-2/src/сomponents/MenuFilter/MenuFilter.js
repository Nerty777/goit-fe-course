import React from 'react';

const MenuFilter = ({ filter, handleFilterChange }) => (
  <form>
    <input
      type="text"
      placeholder="filter name"
      value={filter}
      onChange={handleFilterChange}
    />
  </form>
);

export default MenuFilter;
