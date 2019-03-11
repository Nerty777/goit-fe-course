import React, { Component } from "react";
import ListOffers from "./ListOffers";

const INITIAL_STATE = {
  xmlUrl: "",
  url: ""
};

export default class Form extends Component {
  state = { ...INITIAL_STATE, xmlUrl: "" };

  handleChange = ({ target }) => {
    const { name, value } = target;
    this.setState({ [name]: value });
  };

  handleSubmit = e => {
    e.preventDefault();
    const { url } = this.state;
    this.setState({ xmlUrl: url });
    this.setState({ url: '' });
    this.resetForm();
  };

  resetForm = () => {
       this.setState({ url: '' });
  };

  render() {
    const { url, xmlUrl } = this.state;
    return (
      <>
        {!xmlUrl && <form onSubmit={this.handleSubmit}>
          <label htmlFor="url">
            Enter url xml
            <input
              id="url"
              type="text"
              placeholder="Enter url xml"
              name="url"
              value={url}
              onChange={this.handleChange}
            />
          </label>
          <br />
          <button type="submit">Go</button>
        </form>}
        { xmlUrl && <ListOffers xmlUrl={ xmlUrl } />}
      </>
    );
  }
}
