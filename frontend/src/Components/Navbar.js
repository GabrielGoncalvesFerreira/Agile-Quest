// src/components/Navbar.js
import React from 'react';
import { Navbar, Nav } from 'react-bootstrap';
import { LinkContainer } from 'react-router-bootstrap';
import logo from './Logo_Agile.png';
import './Navbar.css';

const CustomNavbar = () => {
  return (
    <Navbar bg="light" expand="lg" className="custom-navbar">
      <LinkContainer to="/">
        <Navbar.Brand>
          <img src={logo} alt="Logo" className="navbar-logo" />
        </Navbar.Brand>
      </LinkContainer>
      <Navbar.Collapse id="basic-navbar-nav">
        <Nav className="ms-auto">
          <LinkContainer to="/home">
            <Nav.Link>Home</Nav.Link>
          </LinkContainer>
          <LinkContainer to="/quiz">
            <Nav.Link>Quiz</Nav.Link>
          </LinkContainer>
        </Nav>
      </Navbar.Collapse>
    </Navbar>
  );
};

export default CustomNavbar;
