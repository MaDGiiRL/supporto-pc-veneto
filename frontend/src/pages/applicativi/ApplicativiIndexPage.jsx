import { Link } from 'react-router-dom';

const apps = [
  { slug: 'segnalazioni', name: 'Segnalazioni SOR' },
  { slug: 'formazione', name: 'Formazione' }
];

export function ApplicativiIndexPage() {
  return (
    <div className="container">
      <h1>Applicativi</h1>
      <ul>{apps.map((app) => <li key={app.slug}><Link to={`/applicativi/${app.slug}`}>{app.name}</Link></li>)}</ul>
    </div>
  );
}
