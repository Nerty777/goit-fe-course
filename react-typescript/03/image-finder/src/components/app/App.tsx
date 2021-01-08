import React, { Component } from 'react'
import Loader from 'react-loader-spinner'

import "react-loader-spinner/dist/loader/css/react-spinner-loader.css"

import Searchbar from '../searchbar/searchbar'
import ImageGallery from '../imageGallery/imageGallery'
import Button from '../button/button'
import Modal from '../modal/modal'

import { Search, Image } from '../../types/types'
import { getPicture } from '../../services/api'
import { imagesPerPage } from '../../config/config'

interface CurrentImage {
  url: string
  alt: string
  isLoadImage: boolean
}

interface State extends Search {
  images: Image[],
  page: number,
  isLoading: boolean
  error: string | null
  isEndOfImageUpload: boolean
  isNotFound: boolean
  showModal: boolean
  currentImage: CurrentImage
}

const INITIALSTATE = {
  search: '',
  images: [],
  page: 1,
  isLoading: false,
  error: null,
  isEndOfImageUpload: false,
  isNotFound: false,
  showModal: false,
  currentImage: {
    url: '',
    alt: '',
    isLoadImage: false
  }
}

export default class App extends Component<{}, State> {
  state: State = {
    ...INITIALSTATE
  }

  checkErrorLoadImages = (images: Image[]): boolean => {
    if (typeof images === 'string') {
      this.setState({
        error: images
      })
      return true
    }
    return false
  }

  handleSearch = async (search: string): Promise<any> => {
    if (search === this.state.search) {
      return
    }

    try {
      this.setState({
        isLoading: true
      })
      const images = await getPicture(search, INITIALSTATE.page)

      if (this.checkErrorLoadImages(images)) {
        return
      }

      this.setState({
        ...INITIALSTATE,
        images,
        search,
        isNotFound: !images.length ? true : false,
      })
    } catch (e) {
      this.setState({
        error: e.message
      })
    } finally {
      this.setState({
        isLoading: false
      })
    }
  }

  scrollToMoreLoad = (): void => {
    window.scrollTo({
      top: document.documentElement.scrollHeight,
      behavior: 'smooth',
    })
  }

  calculateEndOfImageUpload = (images: Image[]): void => {
    if (images.length < imagesPerPage) {
      this.setState({
        isEndOfImageUpload: true
      })
    }
  }

  loadMore = async (): Promise<any> => {
    try {
      const { search, page } = this.state
      this.setState({
        isLoading: true
      })

      const images = await getPicture(search, page + 1)

      this.setState(prevState => {
        return {
          images: [...prevState.images, ...images],
          page: prevState.page + 1
        } as State
      })

      this.calculateEndOfImageUpload(images)

      this.scrollToMoreLoad()

    } catch (e) {
      this.setState({
        error: e.message
      })
    } finally {
      this.setState({
        isLoading: false
      })
    }
  }

  openModal = (): void => {
    this.setState({
      showModal: true,
    })
  }

  closeModal = (): void => {
    this.setState({
      showModal: false,
    })
  }

  setCurrentImageUrl = (url: string, alt: string): void => {
    this.setState({
      currentImage: {
        url,
        alt,
        isLoadImage: true
      },
    })
  }

  handleLoadImage = (): void => {
    this.setState((prevState) => {
      return {
        currentImage: {
          ...prevState.currentImage,
          isLoadImage: false
        }
      }
    })
  }

  render() {
    const {
      images,
      isLoading,
      error,
      isEndOfImageUpload,
      isNotFound,
      currentImage,
      showModal
    } = this.state
    const isVisibleLoadMore = images.length > 0 && isEndOfImageUpload === false && !isLoading
    const isVisibleGallery = images.length > 0

    return (
      <div className="App">
        <Searchbar onSubmit={this.handleSearch} />

        {error && <div className="Error">Opps, {error}</div>}

        {isNotFound && <div className="Error">Opps, not found</div>}

        { isVisibleGallery &&
          <ImageGallery
            images={images}
            onClick={this.openModal}
            setCurrentImageUrl={this.setCurrentImageUrl}
          />}

        {isLoading &&
          <div className="Loader">
            <Loader
              type="ThreeDots"
              color="#3f51b5"
              height={50}
              width={50}
            />
          </div>}

        {isVisibleLoadMore && <Button onClick={this.loadMore} />}

        {showModal && <Modal onClose={this.closeModal}>
          <img
            src={currentImage.url}
            alt={currentImage.alt}
            onLoad={this.handleLoadImage}
          />
          {currentImage.isLoadImage &&
            <div className="LoaderCenter">
              <Loader
                type="ThreeDots"
                color="#3f51b5"
                height={50}
                width={50}
              />
            </div>}
        </Modal>}
      </div>
    )
  }
}
