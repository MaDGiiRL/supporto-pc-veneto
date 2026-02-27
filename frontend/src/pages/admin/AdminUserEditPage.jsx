import { useParams } from 'react-router-dom';

export function AdminUserEditPage() {
  const { id } = useParams();
  return (
    <div className="container">
      <h1>Modifica utente #{id}</h1>
    </div>
  );
}
