import './bootstrap';
import '../css/app.css'

// resources/js/app.js
import Swal from "sweetalert2";
window.Swal = Swal;

// Leaflet
import L from "leaflet";
window.L = L;

// CSS Leaflet (puoi metterlo anche in app.css, vedi sotto)
import "leaflet/dist/leaflet.css";

// FIX icone marker (se non lo fai, spesso non vedi i marker)
import iconRetinaUrl from "leaflet/dist/images/marker-icon-2x.png";
import iconUrl from "leaflet/dist/images/marker-icon.png";
import shadowUrl from "leaflet/dist/images/marker-shadow.png";

L.Icon.Default.mergeOptions({
  iconRetinaUrl,
  iconUrl,
  shadowUrl,
});

// (opzionale) CSS SweetAlert2 se vuoi il tema base
import "sweetalert2/dist/sweetalert2.min.css";
