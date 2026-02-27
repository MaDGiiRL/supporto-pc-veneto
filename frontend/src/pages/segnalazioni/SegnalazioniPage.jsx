import { NavLink, Navigate, Route, Routes } from 'react-router-dom';
import { Placeholder } from './SectionPlaceholder';

const sections = [
  'dashboard',
  'sinottico',
  'coordinamento',
  'segnalazioni-eventi',
  'tabella-riassuntiva',
  'apertura-chiusura-coc',
  'apertura-chiusura-sor',
  'monitoraggio-coc',
  'log'
];

export function SegnalazioniPage() {
  return (
    <div className="container">
      <h1>Applicativo Segnalazioni SOR</h1>
      <nav className="tabs">{sections.map((s) => <NavLink key={s} to={s}>{s}</NavLink>)}</nav>
      <Routes>
        {sections.map((section) => (
          <Route key={section} path={section} element={<Placeholder domain="segnalazioni" section={section} />} />
        ))}
        <Route path="*" element={<Navigate to="dashboard" replace />} />
      </Routes>
    </div>
  );
}
