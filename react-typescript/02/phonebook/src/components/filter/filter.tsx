import React from 'react'

interface Props {
  handleFilter: (e: React.ChangeEvent<HTMLInputElement>) => void
  value: string
}


const Filter = ({ handleFilter, value }: Props): JSX.Element => {

  return (
    <label htmlFor="filter">
      <p>Find contacts by name</p>
      <input
        type="text"
        value={value}
        name="filter"
        id="filter"
        onChange={handleFilter}
      />
    </label>
  )
}

export default Filter