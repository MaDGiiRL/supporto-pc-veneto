export function ResetPasswordPage() {
  return (
    <>
      <h1>Reset password</h1>
      <form className="form-grid">
        <input placeholder="Token" />
        <input placeholder="Nuova password" type="password" />
        <button type="button">Aggiorna password</button>
      </form>
    </>
  );
}
