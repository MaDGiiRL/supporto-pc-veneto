import { Link } from 'react-router-dom';

const links = [
  { to: '/', label: 'Home' },
  { to: '/cartografie', label: 'Cartografie' },
  { to: '/percezione', label: 'Percezione sismica' },
  { to: '/applicativi', label: 'Applicativi' }
];

export function Navbar() {
  return (
    <header className="navbar">
      <strong>Supporto PC Veneto</strong>
      <nav>
        {links.map((link) => (
          <Link key={link.to} to={link.to}>{link.label}</Link>
        ))}
      </nav>
    </header>
  );
}
