import { useParams, Link } from 'react-router-dom';

export function ApplicativoShowPage() {
  const { slug } = useParams();
  return (
    <div className="container">
      <h1>Applicativo: {slug}</h1>
      {slug === 'segnalazioni' && <Link to="/applicativi/segnalazioni/dashboard">Apri modulo</Link>}
      {slug === 'formazione' && <Link to="/applicativi/formazione/corsi">Apri modulo</Link>}
    </div>
  );
}
