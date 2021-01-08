import galleryItems from './gallery-items.js'

const gallery = document.querySelector('.js-gallery')
const lightbox = document.querySelector('.js-lightbox')
const lightboxImage = document.querySelector('img.lightbox__image')
const closeBtn = document.querySelector('[data-action="close-lightbox"]')

gallery.addEventListener('click', handleImage)
closeBtn.addEventListener('click', handleClose)
lightbox.addEventListener('click', handleLightbox)
window.addEventListener('keydown', handleEsc)
lightboxImage.addEventListener('click', handlePrevNextClick)

const template = array => {
  return array
    .map(({ original, preview, description }, index) => {
      return `
        <li class="gallery__item">
          <a
          class="gallery__link"
          href=${original}
          >
            <img
            class="gallery__image"
            src=${original}
            data-index=${index}
            data-source=${preview}
            alt=${description}
            />
          </a>
        </li>
      `
    })
    .join('')
}

gallery.insertAdjacentHTML('afterbegin', template(galleryItems))

function handleImage(event) {
  event.preventDefault()
  if (event.target.nodeName !== 'IMG') {
    return
  }

  lightbox.classList.add('is-open')
  lightboxImage.src = event.target.src
  lightboxImage.alt = event.target.alt
  lightboxImage.setAttribute(
    'data-index',
    event.target.getAttribute('data-index'),
  )
}

function handleClose() {
  lightbox.classList.remove('is-open')
  lightboxImage.src = ''
}

function handleLightbox(event) {
  if (event.target.nodeName !== 'DIV') {
    return
  }

  handleClose()
}

function handleEsc(event) {
  const currentIndexLightboxImage = Number(
    lightboxImage.getAttribute('data-index'),
  )

  switch (event.code) {
    case 'Escape':
      handleClose()
      break
    case 'ArrowLeft':
      prevImage(currentIndexLightboxImage)
      break
    case 'ArrowRight':
      nextImage(currentIndexLightboxImage)
      break
    default:
  }
}

function handlePrevNextClick(event) {
  const clickTarget = event.target
  const clickTargetWidth = clickTarget.offsetWidth
  const xCoordInClickTarget =
    event.clientX - clickTarget.getBoundingClientRect().left

  const currentIndexLightboxImage = Number(
    lightboxImage.getAttribute('data-index'),
  )

  if (clickTargetWidth / 2 > xCoordInClickTarget) {
    prevImage(currentIndexLightboxImage)
  } else {
    nextImage(currentIndexLightboxImage)
  }
}

function prevImage(index) {
  if (!index) {
    return
  }

  lightboxImage.src = galleryItems[index - 1].original
  lightboxImage.alt = galleryItems[index - 1].description
  lightboxImage.setAttribute('data-index', index - 1)
}

function nextImage(index) {
  if (index === galleryItems.length - 1) {
    return
  }

  lightboxImage.src = galleryItems[index + 1].original
  lightboxImage.alt = galleryItems[index + 1].description
  lightboxImage.setAttribute('data-index', index + 1)
}
