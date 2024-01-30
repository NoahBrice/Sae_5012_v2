import "../styles/stylesMenu.css";
import React, { useState } from "react";
import Content from "./Content";
import { useMediaQuery } from 'react-responsive';


export default function Menu() {
  const [selectedMenu, setSelectedMenu] = useState(null);
  const isMobile = useMediaQuery({ maxWidth: 1000 });

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
        <ul className={`sidebar-list ${sidebarOpen ? "open" : "closed"}`} style={isMobile ? { width: "100%" } : null}>
          <li>
            <a href="#" onClick={() => handleMenuClick("Visualisation")} style={isMobile ? { textAlign: "center" } : null}>
              Visualisation
            </a>
          </li>
          <li>
            <a href="#" onClick={() => handleMenuClick("Accueil")} style={isMobile ? { textAlign: "center" } : null}> Accueil </a>
          </li>
          <li>
            <a href="#" onClick={() => handleMenuClick("Sites")} style={isMobile ? { textAlign: "center" } : null}> Sites </a>
          </li>
          <li>
            <a href="#" onClick={() => handleMenuClick("Pages")} style={isMobile ? { textAlign: "center" } : null}> Pages </a>
          </li>
          <li>
            <a href="#" onClick={() => handleMenuClick("Articles")} style={isMobile ? { textAlign: "center" } : null}> Articles </a>
          </li>
          <li>
            <a href="#" style={isMobile ? { textAlign: "center" } : null}> Commentaires </a>
          </li>
          <li>
            <a href="#" onClick={() => handleMenuClick("Thèmes")} style={isMobile ? { textAlign: "center" } : null}> Thèmes </a>
          </li>
          <li>
            <a href="#" style={isMobile ? { textAlign: "center" } : null}> Data Sets </a>
          </li>
          <li>
            <a href="#" style={isMobile ? { textAlign: "center" } : null}> Utilisateurs </a>
          </li>
          <li>
            <a href="#" style={isMobile ? { textAlign: "center" } : null}> Media </a>
          </li>
          <li>
            <a href="#" onClick={() => handleMenuClick("Créer une page")} style={isMobile ? { textAlign: "center" } : null}> Créer une page </a>
          </li>
        </ul>
      </div>
      <Content selectedMenu={selectedMenu} />
    </>
  );
}
