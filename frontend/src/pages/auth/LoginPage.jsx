export function LoginPage() {
  return (
    <>
      <h1>Login</h1>
      <form className="form-grid">
        <input placeholder="Email" type="email" />
        <input placeholder="Password" type="password" />
        <button type="button">Accedi</button>
      </form>
    </>
  );
}
