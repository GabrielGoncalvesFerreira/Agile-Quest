// src/components/MainLayout.js
import React from 'react';
import CustomNavbar from './Navbar';
import './MainLayout.css';

const MainLayout = ({ children }) => {
  return (
    <div className="main-layout">
      <CustomNavbar />
      <main className="main-content">
        {children}
      </main>
    </div>
  );
};

export default MainLayout;
