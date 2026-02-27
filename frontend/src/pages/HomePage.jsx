import { Link } from 'react-router-dom';
import { PageSection } from '../components/common/PageSection';

export function HomePage() {
  return (
    <div className="container">
      <h1>Portale di supporto alla Protezione Civile del Veneto</h1>
      <p>Nuova homepage React/Vite che sostituisce la vista Blade.</p>
      <PageSection title="Accessi rapidi">
        <div className="grid">
          <Link to="/cartografie">Cartografie</Link>
          <Link to="/applicativi">Applicativi informatici</Link>
          <Link to="/percezione">Percezione sismica</Link>
        </div>
      </PageSection>
    </div>
  );
}
