// src/App.js
import './App.css';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import Home from './Pages/Home';
import Quiz from './Pages/Quiz';
import Login from './Pages/Login';
import MainLayout from './Components/MainLayout';
import ProtectedRoute from './Components/Route';

function App() {
  return (
    <Router>
      <Routes>
        <Route path="/" element={<Login />} />
        <Route
          path="/home"
          element={
            <ProtectedRoute>
              <MainLayout>
                <Home />
              </MainLayout>
            </ProtectedRoute>
          }
        />
        <Route
          path="/quiz"
          element={
            <ProtectedRoute>
              <MainLayout>
                <Quiz />
              </MainLayout>
            </ProtectedRoute>
          }
        />
      </Routes>
    </Router>
  );
}
export default App;
