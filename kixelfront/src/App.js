import "./styles/styles.css";

import Header from "./Components/Header.jsx";
import Menu from "./Components/Menu.jsx";
import Login from "./Components/Login.jsx";
import { useState } from "react";

export default function App() {
  const [isLoggedIn, setIsLoggedIn] = useState(false);
  const [user, setUser] = useState(null);

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
      <Header user={user} onLogout={handleLogout} />
      {isLoggedIn ? (
        <div style={{ display: "flex" }}>
          <Menu />
        </div>
      ) : (
        <Login onLogin={handleLogin} />
      )}
    </div>
  );
}

