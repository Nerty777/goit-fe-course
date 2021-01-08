import React from 'react'

interface Props {
  onClick: () => Promise<any>
}

const Button = ({ onClick }: Props): JSX.Element => {
  return (
    <button
      onClick={onClick}
      className="Button"
      type="button"
    >
      Load More
    </button>
  )
}

export default Button