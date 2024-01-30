import "../styles/stylesHeader.css";
import { useState, useEffect } from "react";

export default function Header() {
  // const [utilisateur, setUtilisateur] = useState("user");
  // useEffect(() => {
  //   fetch("http://localhost:8000/api/users/1")
  //     .then((response) => {
  //       return response.json();
  //     })
  //     .then((data) => {
  //       setUtilisateur(data.nom);
  //       console.log(data.nom);
  //     });
  // });
  return (
    <div className="header">
      <img
        src="../img/logo1.png"
        alt="logo"
        style={{ maxWidth: "3%", maxHeight: "3%" }}
      />
      <div className="info_compte_utilisateur" style={{ display: "flex" }}>
        <img src="#" alt="" />

        <p>  </p>
      </div>
    </div>
  );
}
