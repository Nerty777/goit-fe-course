import React from 'react';

const Notification = ({ message }: Props): JSX.Element => {
  return (
    <div>{message}</div>
  )
}

interface Props {
  message: string
}

export default Notification