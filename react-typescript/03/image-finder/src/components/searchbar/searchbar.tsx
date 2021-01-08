import React, { Component } from 'react';
import { Search } from '../../types/types'

interface Props {
  onSubmit: (search: string) => Promise<any>
}

export default class Searchbar extends Component<Props, Search> {
  state: Search = {
    search: ''
  }

  handleInput = ({ target: { name, value } }: React.ChangeEvent<HTMLInputElement>) => {
    this.setState(
      { [name]: value } as Pick<Search, keyof Search>)
  }

  handleSubmit = (e: React.FormEvent<HTMLFormElement>) => {
    e.preventDefault()

    this.props.onSubmit(this.state.search)
  }

  render() {
    const { search } = this.state

    return (
      <header className="Searchbar">
        <form className="SearchForm" onSubmit={this.handleSubmit}>
          <button type="submit" className="SearchForm-button">
            <span className="SearchForm-button-label">Search</span>
          </button>

          <input
            value={search}
            name="search"
            className="SearchForm-input"
            type="text"
            autoComplete="off"
            autoFocus
            placeholder="Search images and photos"
            onChange={this.handleInput}
          />
        </form>
      </header>
    )
  }
}
