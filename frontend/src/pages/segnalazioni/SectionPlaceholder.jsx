import { useEffect, useState } from 'react';
import { segnalazioniApi } from '../../services/api';

export function Placeholder({ domain, section }) {
  const [count, setCount] = useState(0);

  useEffect(() => {
    segnalazioniApi.section(section)
      .then((rows) => setCount(Array.isArray(rows) ? rows.length : 0))
      .catch(() => setCount(0));
  }, [section]);

  return <p>{domain}/{section} - record caricati: {count}</p>;
}
