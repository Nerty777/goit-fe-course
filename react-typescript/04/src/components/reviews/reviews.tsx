import React, { Component } from 'react'
import { RouteComponentProps } from 'react-router-dom'
import Loader from 'react-loader-spinner'

import { TParams, IReview } from '../../types/types'
import { getReviews } from '../../services/api'

import s from './reviews.module.scss'

interface State {
  reviews: IReview[]
  isLoading: boolean
  error: string | null
  isNotFound: boolean
}

export default class Reviews extends Component<RouteComponentProps<TParams>, State> {
  state: State = {
    reviews: [],
    isLoading: false,
    error: null,
    isNotFound: false,
  }

  async componentDidMount(): Promise<void> {
    try{
      this.setState({
        isLoading: true,
        error: null,
        isNotFound: false
      })

      const movieId = this.props.match.params.movieId
      const response = await getReviews(Number(movieId))

      if (!response.length) {
        this.setState({
          isNotFound: true
        })
      }

      const result = response.map(item => {
        return {...item, isShowReview: false}
      })
  
      this.setState({ reviews: [...result] })
    } catch(error) {
      this.setState({
        error: error.message
      })
    } finally {
      this.setState({
        isLoading: false
      })
    }
  }

  handleButton = (id: string):void => {
    this.setState((prevState)=> {
      const reviews = [...prevState.reviews].map(item => {
        if(item.id === id) {
          return {...item, isShowReview: !item.isShowReview}
        }
        return item
      })

      return {reviews}
    })
  }

  render() {
    const { reviews, isLoading, error, isNotFound } = this.state

    const isShowFullReview = (item: IReview) => item.isShowReview || item.content.length < 300

    return (
      <>
        {isLoading && <div className={s.center}>
          <Loader
            type="Puff"
            color="#00BFFF"
            height={50}
            width={50}
          />
        </div>}
        {error && <div className={s.center}>Opps, {error}</div>}
        {isNotFound && (<p className={s.center}>We don't have any reviews for this movie.</p>)}
        {reviews.length > 0 && <ul className={s.list}>
          {reviews.map(item => (
            <li
              className={s.item}
              key={item.id}
            >
              <h3>Author: {item.author}</h3>
              <div className={s.content}>
                <p>{isShowFullReview(item) ? item.content : `${item.content.slice(0, 300)}...`}</p>
                {item.content.length > 300 && <button
                  className={s.button}
                  type="button"
                  onClick={() => this.handleButton(item.id)}
                >
                  {item.isShowReview ? 'hide review' : 'show full review'}
                </button>}
              </div>
            </li>
          ))}
        </ul>}
      </>
    )
  }
}