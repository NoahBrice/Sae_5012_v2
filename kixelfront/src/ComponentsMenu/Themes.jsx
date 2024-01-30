// ThemeManager.js
import React, { useState } from 'react';
import { useTheme } from './ThemeContext';

const ThemeManager = () => {
  const { theme, changeTheme, themes, addTheme } = useTheme();
  const [newThemeName, setNewThemeName] = useState('');
  const [newThemeBackgroundColor, setNewThemeBackgroundColor] = useState('');
  const [newThemeTextColor, setNewThemeTextColor] = useState('');

  const handleAddTheme = (e) => {
    e.preventDefault();
    addTheme(newThemeName, newThemeBackgroundColor, newThemeTextColor);
    setNewThemeName('');
    setNewThemeBackgroundColor('');
    setNewThemeTextColor('');
  };

  return (
    <div>
      <h2>Theme Manager</h2>
      <div>
        {Object.keys(themes).map((themeName) => (
          <button
            key={themeName}
            onClick={() => changeTheme(themeName)}
            style={{
              backgroundColor: themes[themeName].backgroundColor,
              color: themes[themeName].textColor,
            }}
          >
            {themeName}
          </button>
        ))}
      </div>
      <form onSubmit={handleAddTheme}>
        <input
          type="text"
          placeholder="Theme Name"
          value={newThemeName}
          onChange={(e) => setNewThemeName(e.target.value)}
        />
        <input
          type="color"
          value={newThemeBackgroundColor}
          onChange={(e) => setNewThemeBackgroundColor(e.target.value)}
        />
        <input
          type="color"
          value={newThemeTextColor}
          onChange={(e) => setNewThemeTextColor(e.target.value)}
        />
        <button type="submit">Create Theme</button>
      </form>
    </div>
  );
};

export default ThemeManager;





