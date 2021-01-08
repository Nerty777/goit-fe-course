import '@pnotify/core/dist/PNotify.css'
import '@pnotify/core/dist/BrightTheme.css'
import debounce from './debounce.js'
import * as PNotify from '@pnotify/core'

import countriesTemplate from '../templates/countries.hbs'
import countryTemplate from '../templates/country.hbs'

const input = document.querySelector('[data-input="countries"]')
const countries = document.querySelector('.countries')
const spinner = document.querySelector('.spinner')

input.addEventListener('input', debounce(handleInput, 500))

function handleInput(event) {
  event.preventDefault()
  spinner.classList.remove('hidden')

  const inputValue = event.target.value
  const url = `https://restcountries.eu/rest/v2/name/${inputValue}`

  fetch(url)
    .then(response => response.json())
    .then(data => mockup(data))
    .catch(e => console.error(e.message))
    .finally(() => {
      spinner.classList.add('hidden')
    })
}

function mockup(data) {
  resetCountries()
  PNotify.defaultStack.close()

  if (data.status) {
    renderError('No matches found.', 'Please enter a more specific query!')
    return
  } else if (data.length > 10) {
    renderError(
      'Too many matches found.',
      'Please enter a more specific query!',
    )
    return
  } else if (data.length > 2 && data.length < 10) {
    renderCountries(data)
    return
  }

  renderCountry(data)
}

function resetCountries() {
  countries.innerHTML = ''
}

function renderCountry(data) {
  countries.innerHTML = countryTemplate(data)
}

function renderCountries(data) {
  countries.innerHTML = countriesTemplate(data)
}

function renderError(title, text) {
  PNotify.error({
    title,
    text,
    delay: 2000,
    closer: false,
    sticker: false,
  })
}
