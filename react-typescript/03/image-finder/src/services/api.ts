import axios from 'axios'

import { imagesPerPage } from '../config/config'
import { Image } from '../types/types'

const apiKey = '17822127-e9a9a0a140ac0dca1ff979a25';
axios.defaults.baseURL = 'https://pixabay.com/api/'

export const getPicture = async (query: string, page: number): Promise<Image[]> => {
  try {
    const response = await axios.get(
      `?q=${query}&page=${page}&key=${apiKey}&image_type=photo&orientation=horizontal&per_page=${imagesPerPage}`
    )
    return response.data.hits
  } catch (error) {
    console.log('error: ', error);
    return error.message
  }
}
