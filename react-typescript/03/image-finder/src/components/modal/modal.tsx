import React, { Component, MouseEvent } from 'react'
import { createPortal } from 'react-dom';

interface Props {
  onClose: () => void
  children: React.ReactNode
}

const modalRoot = document.querySelector('#modal-root') as HTMLDivElement

export default class Modal extends Component<Props> {
  componentDidMount() {
    window.addEventListener('keydown', this.handleKeyDown)
  }

  componentWillUnmount() {
    window.removeEventListener('keydown', this.handleKeyDown)
  }

  handleKeyDown = (e: KeyboardEvent) => {
    if (e.code === 'Escape') {
      this.props.onClose();
    }
  }

  handleBackdropClick = (e: MouseEvent<HTMLDivElement>) => {
    if (e.currentTarget === e.target) {
      this.props.onClose();
    }
  }

  render() {
    const { children } = this.props

    return createPortal(
      <div className="Overlay" onClick={this.handleBackdropClick}>
        <div className="Modal">
          {children}
        </div>
      </div>,
      modalRoot,
    );
  }
}
