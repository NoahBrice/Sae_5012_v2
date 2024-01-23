// Themes.js
import React, { useState, useEffect } from 'react';
import './ComponentsStyles/Themes.css'; 

const Themes = () => {
  const [themes, setThemes] = useState([]);
  const [selectedFilter, setSelectedFilter] = useState('chronologic'); 

  useEffect(() => {
    // Fetch themes API
    fetch('http://localhost:8000/api/themes')
      .then((response) => response.json())
      .then((data) => setThemes(data["hydra:member"]))
<<<<<<< HEAD
=======
      // console.log(response)
>>>>>>> 9aaf47f5d37db067f456b40836d14b057cd35da6
      .catch((error) => console.error('Error fetching themes:', error));
  }, []); 

  // changement filtre test
  const handleFilterChange = (event) => {
    setSelectedFilter(event.target.value);
  };

  return (
    <div className="themes-container">
      <h1>Themes</h1>
      <p>Select a filter:</p>

      <div className="filter-element">      <select value={selectedFilter} onChange={handleFilterChange}>
        <option value="chronologic">Chronologic</option>
        {/* options */}
      </select></div>
    
      <div className="themes-list">
        {themes.map((theme) => (
          <div key={theme.id} className="theme-item">
            <img src="#" alt="img" />
            <div>
              <h2>{theme.nom}</h2>
              <p>{theme.site}</p>
            </div>
          </div>
        ))}
      </div>
    </div>
  );
};

export default Themes;
