import React from 'react';
import Header from './Components/Header.jsx';
import Menu from './Components/Menu.jsx';
import Login from './Components/Login.jsx';
import { useState } from 'react';
import { useMediaQuery } from 'react-responsive';
import ThemeManager from './ComponentsMenu/Themes.jsx'; // Import ThemeManager
import { ThemeProvider } from './ComponentsMenu/ThemeContext.jsx';

export default function App() {
  const [isLoggedIn, setIsLoggedIn] = useState(false);
  const [user, setUser] = useState(null);

  const isMobile = useMediaQuery({ maxWidth: 1000 });

  const handleLogin = (userData) => {
    setIsLoggedIn(true);
    setUser(userData);
  };

  const handleLogout = () => {
    setIsLoggedIn(false);
    setUser(null);
  };

  return (
    <div className="App">
      <ThemeProvider>
        <Header user={user} onLogout={handleLogout} />
        {isLoggedIn ? (
          <div style={isMobile ? { width: '100%' } : { display: 'flex' }}>
            <Menu />
          </div>
        ) : (
          <Login onLogin={handleLogin} />
        )}
        {/* <ThemeManager /> Render ThemeManager within ThemeProvider */}
      </ThemeProvider>
    </div>
  );
}


