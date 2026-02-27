import { Outlet } from 'react-router-dom';
import { Navbar } from '../common/Navbar';
import { Footer } from '../common/Footer';

export function MainLayout() {
  return (
    <div className="app-shell">
      <Navbar />
      <main className="content"><Outlet /></main>
      <Footer />
    </div>
  );
}
