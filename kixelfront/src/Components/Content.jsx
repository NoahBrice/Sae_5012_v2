// Content.js
import React from "react";
import ThemeManager from '../ComponentsMenu/Themes.jsx';
import Articles from '../ComponentsMenu/Articles.jsx';
import Pages from '../ComponentsMenu/Pages.jsx';
import PageCreation from '../ComponentsMenu/CreerPage.jsx';

const Content = ({ selectedMenu }) => {
  switch (selectedMenu) {
    case "Visualisation":
      return <h1>Visualisation Content</h1>;
    case "Accueil":
      return <h1>Accueil Content</h1>;
    case "Sites":
      return <h1>Sites Content</h1>;
    case "Pages":
      return <Pages />;
    case "Articles":
      return <Articles/>;
    case "Commentaires":
      return <h1>Commentaires Content</h1>;
    case "Thèmes":
      return <ThemeManager/>;
    case "Data Sets":
      return <h1>Data Sets Content</h1>;
    case "Utilisateurs":
      return <h1>Utilisateurs Content</h1>;
    case "Media":
      return <h1>Media Content</h1>;
    case "Créer une page":
      return <PageCreation />;
    default:
      return (
        <img
          src="../img/logo_gris.png"
          alt="Default Content"
          style={{ maxWidth: "100%" }}
        />
      );
  }
};

export default Content;
