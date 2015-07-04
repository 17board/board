import React from 'react';
import {Styles} from 'material-ui';
import Sidebar from './sidebar';

const ThemeManager = new Styles.ThemeManager();
const Colors = Styles.Colors;

class BoardApp extends React.Component {
  getChildContext() {
    return {
      muiTheme: ThemeManager.getCurrentTheme()
    };
  }

  componentWillMount() {
    ThemeManager.setPalette({
      accent1Color: Colors.deepOrange500
    });
  }

  render() {
    return (
      <main>
        <Sidebar />
      </main>
    );
  }
}

BoardApp.childContextTypes = {
  muiTheme: React.PropTypes.object
};

export default BoardApp;