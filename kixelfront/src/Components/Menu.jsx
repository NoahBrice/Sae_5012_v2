import "../styles/stylesMenu.css";
import React, { useState } from "react";
import Content from "./Content";

<<<<<<< HEAD
=======

>>>>>>> 9aaf47f5d37db067f456b40836d14b057cd35da6

export default function Menu() {
  const [selectedMenu, setSelectedMenu] = useState(null);

  const handleMenuClick = (menu) => {
    setSelectedMenu(menu);
  };
  const [sidebarOpen, setSidebarOpen] = useState(true);

  const toggleSidebar = () => {
    setSidebarOpen(!sidebarOpen);
  };
  return (
    <>
      <div style={{ display: "flex", flexDirection: "column" }}>
        <div
          className={`toggle-button ${sidebarOpen ? "open" : "closed"}`}
          onClick={toggleSidebar}
        >
          {sidebarOpen ? "◁" : "▷"}
        </div>
        <ul className={`sidebar-list ${sidebarOpen ? "open" : "closed"}`}>
          <li>
            <a href="#" onClick={() => handleMenuClick("Visualisation")}>
              Visualisation
            </a>
          </li>
          <li>
            <a href="#"> Accueil </a>
          </li>
          <li>
            <a href="#"> Sites </a>
          </li>
          <li>
            <a href="#"> Pages </a>
          </li>
          <li>
            <a href="#"> Articles </a>
          </li>
          <li>
            <a href="#"> Commentaires </a>
          </li>
          <li>
            <a href="#" onClick={() => handleMenuClick("Thèmes")}> Thèmes </a>
          </li>
          <li>
            <a href="#"> Data Sets </a>
          </li>
          <li>
            <a href="#"> Statistiques </a>
          </li>
          <li>
            <a href="#"> Mails </a>
          </li>
          <li>
            <a href="#"> Utilisateurs </a>
          </li>
          <li>
            <a href="#"> Media </a>
          </li>
          <li>
            <a href="#"> Créer une page </a>
          </li>
        </ul>
      </div>
      <Content selectedMenu={selectedMenu} />
    </>
  );
}
