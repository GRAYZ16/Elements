import React, {Component} from 'react'
import TopBar from './components/TopBar';
import NavBar from './components/NavBar';

class App extends Component {
    
    render() {

      return (
        <div className="App">
          <h1>Hello, React</h1>
          <TopBar />
          <NavBar />
        </div>
      )

    }
}

export default App;