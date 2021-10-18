
import { useEffect } from 'react';
import './App.css';
import Main from './components/main/Main.js';

function App() {
  useEffect(() => {
    document.title = "uneo";
  }, [])
  return (
    <div className="App">
      <Main />
    </div>
  );
}

export default App;
