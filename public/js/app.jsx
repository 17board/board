import React from 'react';
import injectTapEventPlugin from 'react-tap-event-plugin';
import BoardApp from './components/board-app';

window.React = React;

injectTapEventPlugin();

React.render(
  <BoardApp />,
  document.getElementById('board-app')
);