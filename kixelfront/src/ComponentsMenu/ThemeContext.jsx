// ThemeContext.js
import { createContext, useState, useContext } from 'react';

export const ThemeContext = createContext();

export const useTheme = () => {
  return useContext(ThemeContext);
};

export const ThemeProvider = ({ children }) => {
  const [theme, setTheme] = useState('default');

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

  return (
    <ThemeContext.Provider value={{ theme, changeTheme, themes }}>
      {children}
    </ThemeContext.Provider>
  );
};
