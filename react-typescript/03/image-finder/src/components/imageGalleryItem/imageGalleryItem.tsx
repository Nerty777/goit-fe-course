import React from 'react'
import { Image } from '../../types/types'

interface Props {
  image: Image
  onClick: () => void
  setCurrentImageUrl: (url: string, alt: string) => void
}

const ImageGalleryItem = ({ image, onClick, setCurrentImageUrl }: Props): JSX.Element => {
  const { webformatURL, tags = '', largeImageURL = '' } = image

  const handleClick = (): void => {
    onClick()
    setCurrentImageUrl(largeImageURL, tags)
  }

  return (
    <li className="ImageGalleryItem" onClick={handleClick}>
      <img src={webformatURL} alt={tags} className="ImageGalleryItem-image" />
    </li>
  )
}

export default ImageGalleryItem