import axios from 'axios'

import { Film, ICast, IReview } from '../types/types'

axios.defaults.baseURL = 'https://api.themoviedb.org/3/'
const apiKey = "a874a20001c1a2b686b34f1eba843c8d"

export const getMovieTrending = async (): Promise<Film[]> => {
  const response = await axios.get(`trending/movie/day?api_key=${apiKey}`)

  return response.data.results
}

export const detailsMovie = async (movieId: number): Promise<Film> => {
  const response = await axios.get(`movie/${movieId}?api_key=${apiKey}&language=en-US`)

  return response.data
}

export const searchMovie = async (query: string): Promise<Film[]> => {
  const response = await axios.get(
    `search/movie?api_key=${apiKey}&query=${query}&language=en-US&page=1&include_adult=false`
  )

  return response.data.results
}

export const getCast = async (movieId: number): Promise<ICast[]> => {
  const response = await axios.get(
    `movie/${movieId}/credits?api_key=${apiKey}`
  )

  return response.data.cast
}

export const getReviews = async (movieId: number): Promise<IReview[]> => {
  const response = await axios.get(
    `movie/${movieId}/reviews?api_key=${apiKey}&language=en-US&page=1`
  )

  return response.data.results
}
