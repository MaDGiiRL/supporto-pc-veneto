import { NavLink, Navigate, Route, Routes } from 'react-router-dom';
import { FormazioneSection } from './FormazioneSection';

const sections = [
  'corsi',
  'corsi-in-corso',
  'corsi-terminati',
  'iscrizioni',
  'presenze',
  'libretto',
  'distanze',
  'eccezioni-attestati',
  'export'
];

export function FormazionePage() {
  return (
    <div className="container">
      <h1>Applicativo Formazione</h1>
      <nav className="tabs">{sections.map((s) => <NavLink key={s} to={s}>{s}</NavLink>)}</nav>
      <Routes>
        {sections.map((section) => (
          <Route key={section} path={section} element={<FormazioneSection section={section} />} />
        ))}
        <Route path="*" element={<Navigate to="corsi" replace />} />
      </Routes>
    </div>
  );
}
