import React, { Component } from 'react';

const INITIAL_STATE = {
  login: '',
  email: '',
  phone: '',
  password: '',
  password2: '',
};

export default class SignUpForm extends Component {
  state = { ...INITIAL_STATE };

  handleChange = ({ target }) => {
    const { name, value } = target;
    this.setState({ [name]: value });
  };

  handleSubmit = evt => {
    evt.preventDefault();
    const { login, email, phone, password, password2 } = this.state;
    console.log(`
      Login: ${login}
      Email: ${email}
      Phone: ${phone}
      Password: ${password}
      Password2: ${password2}
    `);
    this.reset();
  };

  reset = () => {
    this.setState({ ...INITIAL_STATE });
  };

  render() {
    const { login, email, phone, password, password2 } = this.state;
    return (
      <form onSubmit={this.handleSubmit}>
        <label htmlFor="login">
          Name
          <input
            id="login"
            type="text"
            placeholder="Enter login"
            name="login"
            value={login}
            onChange={this.handleChange}
          />
        </label>
        <br />
        <label htmlFor="email">
          Email
          <input
            id="email"
            type="email"
            placeholder="Enter email"
            name="email"
            value={email}
            onChange={this.handleChange}
          />
        </label>
        <br />
        <label htmlFor="phoneFormIn2">
          Phone
          <input
            id="phoneFormIn2"
            type="phone"
            placeholder="Enter phone"
            name="phone"
            value={phone}
            onChange={this.handleChange}
          />
        </label>
        <br />
        <label htmlFor="password">
          Password
          <input
            id="password"
            type="password"
            placeholder="Enter password"
            name="password"
            value={password}
            onChange={this.handleChange}
          />
        </label>
        <br />
        <label htmlFor="passwordFormIn2">
          Password
          <input
            id="passwordFormIn2"
            type="password"
            placeholder="Enter password"
            name="password2"
            value={password2}
            onChange={this.handleChange}
          />
        </label>
        <br />
        <button type="submit">Sign Up</button>
      </form>
    );
  }
}
