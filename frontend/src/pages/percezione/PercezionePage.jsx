import { useEffect, useState } from 'react';
import { percezioneApi } from '../../services/api';

export function PercezionePage() {
  const [items, setItems] = useState([]);

  useEffect(() => {
    percezioneApi.index().then(setItems).catch(() => setItems([]));
  }, []);

  return (
    <div className="container">
      <h1>Percezione sismica</h1>
      <p>Segnalazioni ricevute: {items.length}</p>
    </div>
  );
}
