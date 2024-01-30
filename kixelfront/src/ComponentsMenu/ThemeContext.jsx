// ThemeContext.js
import React, { createContext, useState, useContext, useEffect } from 'react';

export const ThemeContext = createContext();

export const useTheme = () => {
  return useContext(ThemeContext);
};

export const ThemeProvider = ({ children }) => {
  const [theme, setTheme] = useState(() => {
    // Read the selected theme from local storage or set a default theme
    return localStorage.getItem('theme') || 'default';
  });

  useEffect(() => {
    // Save the selected theme to local storage whenever it changes
    localStorage.setItem('theme', theme);
  }, [theme]);

  const themes = {
    default: {
      backgroundColor: 'white',
      textColor: 'black',
    },
    yellow: {
      backgroundColor: 'yellow',
      textColor: 'white',
    },
    // Add more themes as needed
  };

  const changeTheme = (selectedTheme) => {
    setTheme(selectedTheme);
  };

  const addTheme = (themeName, backgroundColor, textColor) => {
    themes[themeName] = { backgroundColor, textColor };
    setTheme(themeName);
  };

  return (
    <ThemeContext.Provider value={{ theme, changeTheme, themes, addTheme }}>
      {children}
    </ThemeContext.Provider>
  );
};


