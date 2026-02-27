import { http } from './http';
import { endpoints } from '../config/endpoints';

const getData = async (url) => {
  const { data } = await http.get(url);
  return data?.data ?? data ?? [];
};

export const cartografieApi = {
  index: () => getData(endpoints.cartografie)
};

export const percezioneApi = {
  index: () => getData(endpoints.percezione)
};

export const adminUsersApi = {
  index: () => getData(endpoints.adminUsers)
};

export const segnalazioniApi = {
  section: (section) => getData(`${endpoints.segnalazioni}/${section}`),
  store: (payload) => http.post(endpoints.segnalazioni, payload),
  destroy: (id) => http.delete(`${endpoints.segnalazioni}/${id}`)
};

export const formazioneApi = {
  section: (section) => getData(`${endpoints.formazione}/${section}`)
};

export const sorApi = {
  eventi: () => getData(endpoints.eventi),
  comunicazioni: () => getData(endpoints.comunicazioni),
  coordinamento: () => getData(endpoints.coordinamento)
};

export const cocApi = {
  index: () => getData(endpoints.coc)
};
