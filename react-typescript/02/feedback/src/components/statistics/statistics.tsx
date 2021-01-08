import React from 'react';

const Statistics = ({ good, neutral, bad, total = 0, positivePercentage = 0 }: Props): JSX.Element => {
  return (
    <div>
      <ul>
        <li>Good: {good}</li>
        <li>Neutral: {neutral}</li>
        <li>Bad: {bad}</li>
        <li>Total: {total}</li>
        <li>PositivePercentage: {positivePercentage}%</li>
      </ul>
    </div>
  )
}

interface Props {
  good: number
  neutral: number
  bad: number
  total: number
  positivePercentage: number
}

export default Statistics
