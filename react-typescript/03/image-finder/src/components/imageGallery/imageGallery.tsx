import React from 'react'
import ImageGalleryItem from '../imageGalleryItem/imageGalleryItem'
import { Image } from '../../types/types'

interface Props {
  images: Image[]
  onClick: () => void
  setCurrentImageUrl: (url: string, alt: string) => void
}

const ImageGallery = ({ images, onClick, setCurrentImageUrl }: Props): JSX.Element => {
  return (
    <ul className="ImageGallery">
      {images.map((image: Image, index) => (
        <ImageGalleryItem
          key={index}
          image={image}
          onClick={onClick}
          setCurrentImageUrl={setCurrentImageUrl}
        />
      ))}
    </ul>
  )
}

export default ImageGallery