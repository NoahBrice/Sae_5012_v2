import React, { useState } from "react";
import ThreeScene from './ThreeScene.jsx';
import "../styles/stylesLogin.css";

const Login = ({ onLogin }) => {
  const [username, setUsername] = useState("");
  const [password, setPassword] = useState("");

  const handleSubmit = async (e) => {
    e.preventDefault();

    try {
      const response = await fetch("http://localhost:8000/auth", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          email: username,
          password: password,
        }),
      });

      if (response.ok) {
        const data = await response.json();
        const { token } = data;

        // pas giga safe mais vasi pour test
        localStorage.setItem("token", token);

        // Now, you can use the token for future authenticated requests
        // Example: fetch("http://localhost:8000/some-protected-endpoint", {
        //   headers: {
        //     Authorization: `Bearer ${token}`,
        //   },
        // });

        onLogin(); // You might want to pass user information to onLogin if needed
      } else {
        console.error("Authentication failed");
      }
    } catch (error) {
      console.error("Error during authentication:", error);
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
            <b> Connect </b>
          </p>
          <div className="connect-box">
            <div className="login-inputs">
              <label htmlFor="username">
                <b>Email :</b>
              </label>
              <input
                type="text"
                id="username"
                value={username}
                onChange={(e) => setUsername(e.target.value)}
              />
              <label htmlFor="password">
                <b> Password :</b>
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
            Login
          </button>
        </div>
      </div>
      <ThreeScene />
    </div>
  );
};

export default Login;
