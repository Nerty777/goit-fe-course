import React, { Component } from 'react';

const INITIAL_STATE = {
  email: '',
  password: '',
};

export default class SignInForm extends Component {
  state = { ...INITIAL_STATE };

  handleChange = ({ target }) => {
    const { name, value } = target;
    this.setState({ [name]: value });
  };

  handleSubmit = evt => {
    evt.preventDefault();
    const { email, password } = this.state;
    console.log(`
      Email: ${email}
      Password: ${password}
    `);
    this.reset();
  };

  reset = () => {
    this.setState({ ...INITIAL_STATE });
  };

  render() {
    const { email, password } = this.state;
    return (
      <form onSubmit={this.handleSubmit}>
        <label htmlFor="emailFormIn">
          Email
          <input
            id="emailFormIn"
            type="email"
            placeholder="Enter email"
            name="email"
            value={email}
            onChange={this.handleChange}
          />
        </label>
        <br />
        <label htmlFor="passwordFormIn">
          Password
          <input
            id="passwordFormIn"
            type="password"
            placeholder="Enter password"
            name="password"
            value={password}
            onChange={this.handleChange}
          />
        </label>
        <br />
        <button type="submit">Sign in</button>
      </form>
    );
  }
}
