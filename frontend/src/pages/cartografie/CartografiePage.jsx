import { useEffect, useState } from 'react';
import { cartografieApi } from '../../services/api';

export function CartografiePage() {
  const [layers, setLayers] = useState([]);

  useEffect(() => {
    cartografieApi.index().then(setLayers).catch(() => setLayers([]));
  }, []);

  return (
    <div className="container">
      <h1>Cartografie</h1>
      <ul>{layers.map((layer) => <li key={layer.id}>{layer.nome}</li>)}</ul>
    </div>
  );
}
