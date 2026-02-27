import { useEffect, useState } from 'react';
import { adminUsersApi } from '../../services/api';

export function AdminUsersPage() {
  const [users, setUsers] = useState([]);

  useEffect(() => {
    adminUsersApi.index().then(setUsers).catch(() => setUsers([]));
  }, []);

  return (
    <div className="container">
      <h1>Gestione utenti</h1>
      <ul>{users.map((u) => <li key={u.id}>{u.name}</li>)}</ul>
    </div>
  );
}
