import { Location } from 'history';

export interface Film {
  original_name?: string
  original_title?: string
  id: number | null
  poster_path?: string
}

export interface TParams {
  movieId: string
}

export interface LocationProps {
  from: Location;
};

export interface ICast {
  name: string
  cast_id: number
  character: string
  profile_path: string
}

export interface IReview {
  id: string
  author: string
  content: string
  isShowReview: boolean
}