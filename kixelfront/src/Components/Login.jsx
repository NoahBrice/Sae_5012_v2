import React, { useState } from "react";
import ThreeScene from './ThreeScene.jsx';
import "../styles/stylesLogin.css";

const Login = ({ onLogin }) => {
  const [username, setUsername] = useState("");
  const [password, setPassword] = useState("");

  const handleSubmit = async (e) => {
    e.preventDefault();

    try {
      const response = await fetch("http://localhost:8000/api/users/1"); // test

      if (response.ok) {
        const userData = await response.json();

        // on test
        if (userData.nom === username && userData.email === password) {
          onLogin(userData);
        } else {
          console.error("Erreur d'authentification");
        }
      } else {
        console.error("Impossible de recevoir les donnees");
      }
    } catch (error) {
      console.error("Erreur durant authentification:", error);
    }
  };

  return (
    <div className="login-container">
      <div className="login-content">
        <div className="logo-area">
          <img
            src="../img/logo2.png"
            alt="Logo"
            style={{ maxWidth: "30%", maxHeight: "30%" }}
          />
        </div>
        <div className="login-form-area">
          <p className="connect">
            <b>Se connecter</b>
          </p>
          <div className="connect-box">
            <div className="login-inputs">
              <label htmlFor="username">
                <b>ID :</b>
              </label>
              <input
                type="text"
                id="username"
                value={username}
                onChange={(e) => setUsername(e.target.value)}
              />
              <label htmlFor="password">
                <b>Mot de passe :</b>
              </label>
              <input
                type="password"
                id="password"
                value={password}
                onChange={(e) => setPassword(e.target.value)}
              />
            </div>
          </div>
          <button type="submit" onClick={handleSubmit}>
            Valider
          </button>
        </div>
      </div>
      <ThreeScene />
    </div>
  );
};

export default Login;
