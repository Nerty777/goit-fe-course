import React from 'react';
import { OptionsType } from '../../App'
import { OptionType } from '../../App'
import s from './feedbackOptions.module.scss'

const FeedbackOptions = ({ options, onLeaveFeedback }: Props): JSX.Element => {
  return (<>
    <ul className={s.list}>
      {options.map(option => {
        return <li key={option}>
          <button className={s.button}
            type="button"
            onClick={() => onLeaveFeedback(option)}
          >
            {option}
          </button>
        </li>
      })}
    </ul>
  </>)
}

interface Props {
  options: OptionsType
  onLeaveFeedback: (option: OptionType) => void
}


export default FeedbackOptions