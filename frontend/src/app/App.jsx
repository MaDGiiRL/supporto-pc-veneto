import { Navigate, Route, Routes } from 'react-router-dom';
import { MainLayout } from '../components/layout/MainLayout';
import { AuthLayout } from '../components/layout/AuthLayout';
import { HomePage } from '../pages/HomePage';
import { LoginPage } from '../pages/auth/LoginPage';
import { RegisterPage } from '../pages/auth/RegisterPage';
import { ForgotPasswordPage } from '../pages/auth/ForgotPasswordPage';
import { ResetPasswordPage } from '../pages/auth/ResetPasswordPage';
import { CartografiePage } from '../pages/cartografie/CartografiePage';
import { PercezionePage } from '../pages/percezione/PercezionePage';
import { ApplicativiIndexPage } from '../pages/applicativi/ApplicativiIndexPage';
import { ApplicativoShowPage } from '../pages/applicativi/ApplicativoShowPage';
import { SegnalazioniPage } from '../pages/segnalazioni/SegnalazioniPage';
import { FormazionePage } from '../pages/formazione/FormazionePage';
import { AdminUsersPage } from '../pages/admin/AdminUsersPage';
import { AdminUserEditPage } from '../pages/admin/AdminUserEditPage';
import { ForbiddenPage } from '../pages/ForbiddenPage';

export function App() {
  return (
    <Routes>
      <Route element={<MainLayout />}>
        <Route path="/" element={<HomePage />} />
        <Route path="/cartografie" element={<CartografiePage />} />
        <Route path="/percezione" element={<PercezionePage />} />
        <Route path="/applicativi" element={<ApplicativiIndexPage />} />
        <Route path="/applicativi/:slug" element={<ApplicativoShowPage />} />
        <Route path="/applicativi/segnalazioni/*" element={<SegnalazioniPage />} />
        <Route path="/applicativi/formazione/*" element={<FormazionePage />} />
        <Route path="/admin/users" element={<AdminUsersPage />} />
        <Route path="/admin/users/:id/edit" element={<AdminUserEditPage />} />
        <Route path="/403" element={<ForbiddenPage />} />
      </Route>

      <Route element={<AuthLayout />}>
        <Route path="/login" element={<LoginPage />} />
        <Route path="/register" element={<RegisterPage />} />
        <Route path="/forgot-password" element={<ForgotPasswordPage />} />
        <Route path="/reset-password" element={<ResetPasswordPage />} />
      </Route>

      <Route path="*" element={<Navigate to="/" replace />} />
    </Routes>
  );
}
