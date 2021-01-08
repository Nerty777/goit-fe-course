import React, { Component } from 'react';
import Section from './components/section/section'
import FeedbackOptions from './components/feedbackOptions/feedbackOptions'
import Statistics from './components/statistics/statistics'
import Notification from './components/notification/notification'

export default class App extends Component {
  state: State = {
    good: 0,
    neutral: 0,
    bad: 0
  }

  countTotalFeedback = (): number => {
    return Object.values(this.state).reduce((acc, value) => acc + value, 0)
  }

  countPositiveFeedbackPercentage = (): number => {
    return Math.floor(this.state.good * 100 / this.countTotalFeedback()) || 0
  }

  onLeaveFeedback = (option: OptionType): void => {
    this.setState((state: State) => (
      { [option]: state[option] + 1 }
    ))
  }

  render() {
    const { good, neutral, bad } = this.state
    const options = Object.keys(this.state)
    const total = this.countTotalFeedback()
    const positivePercentage = this.countPositiveFeedbackPercentage()

    return (
      <>
        <Section title="Please Leave Feedback">
          <FeedbackOptions
            options={options as OptionsType}
            onLeaveFeedback={this.onLeaveFeedback}
          />
        </Section>
        {total > 0 ? (
          <Section title="Statistics">
            <Statistics
              good={good}
              neutral={neutral}
              bad={bad}
              total={total}
              positivePercentage={positivePercentage}
            />
          </Section>
        ) : (
            <Notification message="No feedback given" />
          )}
      </>
    )
  }
}

export interface State {
  good: number,
  neutral: number,
  bad: number
}

export type OptionsType = Array<keyof State>
export type OptionType = keyof State

