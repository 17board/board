import React from 'react';
import { LeftNav } from 'material-ui';

const menuItems = [
  { route: 'overview', text: 'Overview' },
  { route: 'only-me', text: 'Only Me' },
  { route: 'members', text: 'Members' },
  { route: 'logout', text: 'Logout' }
];

class Sidebar extends React.Component {
  render() {
    return <LeftNav menuItems={menuItems} />;
  }
}

Sidebar.contextTypes = {
  router: React.PropTypes.func
};

export default Sidebar;