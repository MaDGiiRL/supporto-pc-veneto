export function RegisterPage() {
  return (
    <>
      <h1>Registrazione</h1>
      <form className="form-grid">
        <input placeholder="Nome" />
        <input placeholder="Email" type="email" />
        <input placeholder="Password" type="password" />
        <button type="button">Crea account</button>
      </form>
    </>
  );
}
