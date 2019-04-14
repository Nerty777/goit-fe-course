import React, { Component, createRef } from 'react';

const styles = {
  backdrop: {
    position: 'fixed',
    top: 0,
    left: 0,
    width: '100vw',
    height: '100vh',
    backgroundColor: 'rgba(0, 0, 0, 0.5)',
    display: 'flex',
    justifyContent: 'center',
    alignItems: 'center',
  },
  modal: {
    maxWidth: 600,
    minHeight: 300,
    backgroundColor: '#fff',
    padding: 16,
  },
};

export default class Modal extends Component {
  backdropRef = createRef();

  componentDidMount() {
    window.addEventListener('click', this.handleWindowClick);
    window.addEventListener('keydown', this.handleEscClick);
  }

  componentWillUnmount() {
    window.removeEventListener('click', this.handleWindowClick);
    window.removeEventListener('keydown', this.handleEscClick);
  }

  handleWindowClick = e => {
    const { onClose } = this.props;
    if (this.backdropRef.current !== e.target) {
      return;
    }
    onClose();
  };

  handleEscClick = e => {
    const { onClose } = this.props;
    if (e.code !== 'Escape') {
      return;
    }
    onClose();
  };

  render() {
    const { onClose } = this.props;

    return (
      <div className="backdrop" style={styles.backdrop} ref={this.backdropRef}>
        <div className="modal" style={styles.modal}>
          <p className="modal__text">
            Lorem ipsum dolor, sit amet consectetur adipisicing elit. ipsum
            obcaecati maiores ipsam harum distinctio quia, soluta voluptatibus
            iste deserunt consectetur totam quas quidem, voluptatem nisi, nobis
            expedita quis?
          </p>
          <button type="button" onClick={onClose}>
            Close
          </button>
        </div>
      </div>
    );
  }
}
