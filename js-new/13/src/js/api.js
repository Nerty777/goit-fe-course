import axios from 'axios'

axios.defaults.baseURL = `https://pixabay.com/api/?image_type=photo&orientation=horizontal`

const apiKey = '18198238-415cec3f9ecdd7367e0980e97'

export function fetchPictures(query, page = 1) {
  return axios.get(`&q=${query}&page=${page}&per_page=12&key=${apiKey}`)
}
