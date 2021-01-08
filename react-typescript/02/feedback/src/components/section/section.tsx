import React from 'react';

const Section = ({ title, children }: Props) => {
  return (
    <>
      <h2>{title}</h2>
      {children}
    </>
  )
}

interface Props {
  title: string
  children: React.ReactNode
}

export default Section