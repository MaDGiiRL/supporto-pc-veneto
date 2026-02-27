import { useEffect, useState } from 'react';
import { formazioneApi } from '../../services/api';

export function FormazioneSection({ section }) {
  const [items, setItems] = useState([]);

  useEffect(() => {
    formazioneApi.section(section).then(setItems).catch(() => setItems([]));
  }, [section]);

  return <p>Sezione {section} - elementi: {items.length}</p>;
}
