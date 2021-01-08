import * as basicLightbox from 'basiclightbox'
import { fetchPictures } from './api'
import cardTemplate from '../templates/card.hbs'

const searchForm = document.querySelector('#search-form')
const gallery = document.querySelector('.gallery')
const spinner = document.querySelector('.spinner')
const loadMore = document.querySelector('.load-more')

searchForm.addEventListener('submit', handleSearchForm)
gallery.addEventListener('click', handleImgClick)

const search = {
  value: '',
  page: 1,
}

async function handleSearchForm(event) {
  event.preventDefault()

  try {
    galleryReset()
    spinner.classList.remove('hidden')
    loadMore.classList.add('hidden')
    search.value = searchForm.elements.query.value
    search.page = 1
    const { data } = await fetchPictures(search.value, search.page)
    console.log('data: ', data)
    spinner.classList.add('hidden')
    loadMore.classList.remove('hidden')
    renderGallery(data)
  } catch (e) {
    console.log('e: ', e)
  }
}

function renderGallery(data) {
  const template = cardTemplate(data.hits)
  gallery.insertAdjacentHTML('beforeend', template)
}

function handleImgClick(event) {
  if (event.target.nodeName !== 'IMG') {
    return
  }

  showModal(event.target.src)
}

function showModal(src) {
  const instance = basicLightbox.create(`
    <img src=${src} width="800" height="auto">
`)

  instance.show()
}

function galleryReset() {
  gallery.innerHTML = ''
}

function onEntry(entries) {
  entries.forEach(async entry => {
    if (entry.isIntersecting) {
      search.page += 1
      spinner.classList.remove('hidden')
      const { data } = await fetchPictures(search.value, search.page)
      spinner.classList.add('hidden')
      renderGallery(data)
    }
  })
}

const options = {
  rootMargin: '300px',
}

const io = new IntersectionObserver(onEntry, options)

io.observe(loadMore)
