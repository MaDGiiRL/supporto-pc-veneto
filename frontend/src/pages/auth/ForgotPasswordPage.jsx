export function ForgotPasswordPage() {
  return (
    <>
      <h1>Recupero password</h1>
      <form className="form-grid">
        <input placeholder="Email" type="email" />
        <button type="button">Invia link</button>
      </form>
    </>
  );
}
