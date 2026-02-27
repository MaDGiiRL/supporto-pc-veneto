import { Outlet } from 'react-router-dom';

export function AuthLayout() {
  return (
    <div className="auth-shell">
      <div className="auth-card">
        <Outlet />
      </div>
    </div>
  );
}
