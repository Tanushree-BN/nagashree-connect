<?php
$pageTitle = 'Register Admin - Nagashree English School';
$currentPath = '/register';
require_once __DIR__ . '/includes/header.php';
?>
<div class="min-h-screen bg-muted flex items-center justify-center px-4">
  <div class="bg-card rounded-2xl p-10 max-w-md w-full shadow-xl border border-border">
    <h1 class="font-display text-2xl font-bold text-foreground mb-2 text-center">Register Admin</h1>
    <p class="text-sm text-muted-foreground text-center mb-6">Create an admin account</p>
    <div id="register-message" class="hidden rounded-lg p-3 mb-4 text-sm text-center"></div>
    <form id="admin-register-form" class="space-y-4">
      <input type="text" name="username" required class="w-full px-4 py-3 rounded-lg border border-input bg-background text-foreground text-sm" placeholder="Username" />
      <input type="password" name="password" required class="w-full px-4 py-3 rounded-lg border border-input bg-background text-foreground text-sm" placeholder="Password" />
      <button type="submit" class="w-full py-3 rounded-lg bg-gold text-secondary-foreground font-semibold hover:bg-gold-dark transition-colors">Register</button>
    </form>
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
  const form = document.getElementById('admin-register-form');
  const message = document.getElementById('register-message');
  form.addEventListener('submit', async function(event) {
    event.preventDefault();
    const data = await fetch(window.appUrl('/api/register.php'), { method: 'POST', body: new FormData(form) }).then((r) => r.json());
    message.classList.remove('hidden');
    if (data.success) {
      message.className = 'rounded-lg p-3 mb-4 text-sm text-center bg-gold/10 text-gold';
      message.textContent = data.message;
      form.reset();
    } else {
      message.className = 'rounded-lg p-3 mb-4 text-sm text-center bg-destructive/10 text-destructive';
      message.textContent = data.message || 'Registration failed';
    }
  });
});
</script>
<?php include __DIR__ . '/includes/footer.php'; ?>
