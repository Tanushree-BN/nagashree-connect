<?php
$pageTitle = 'Admin Login - Nagashree English School';
$currentPath = '/admin/login';
require_once __DIR__ . '/../includes/header.php';
if (is_admin_logged_in()) {
  redirect_to('/admin/dashboard');
}
?>
<div class="min-h-screen gradient-navy flex items-center justify-center px-4">
  <div class="bg-card rounded-2xl p-10 max-w-md w-full shadow-xl">
    <div class="text-center mb-8">
      <div class="w-16 h-16 rounded-full bg-gold/10 text-gold flex items-center justify-center mx-auto mb-4"><i data-lucide="lock" class="w-8 h-8"></i></div>
      <h1 class="font-display text-2xl font-bold text-foreground">Admin Login</h1>
      <p class="text-muted-foreground text-sm mt-2">Nagashree English School</p>
    </div>

    <div id="admin-login-error" class="hidden bg-destructive/10 text-destructive rounded-lg p-3 mb-6 text-sm text-center"></div>

    <form id="admin-login-form" class="space-y-5">
      <div>
        <label class="block text-sm font-medium text-foreground mb-1.5">Username</label>
        <div class="relative">
          <i data-lucide="user" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-muted-foreground"></i>
          <input type="text" name="username" required class="w-full pl-10 pr-4 py-3 rounded-lg border border-input bg-background text-foreground text-sm focus:outline-none focus:ring-2 focus:ring-ring" placeholder="Enter username" />
        </div>
      </div>
      <div>
        <label class="block text-sm font-medium text-foreground mb-1.5">Password</label>
        <div class="relative">
          <i data-lucide="lock" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-muted-foreground"></i>
          <input type="password" name="password" required class="w-full pl-10 pr-4 py-3 rounded-lg border border-input bg-background text-foreground text-sm focus:outline-none focus:ring-2 focus:ring-ring" placeholder="Enter password" />
        </div>
      </div>
      <button type="submit" class="w-full py-3.5 rounded-lg bg-gold text-secondary-foreground font-semibold hover:bg-gold-dark transition-colors">Sign In</button>
    </form>
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
  const form = document.getElementById('admin-login-form');
  const errorBox = document.getElementById('admin-login-error');
  form.addEventListener('submit', async function(event) {
    event.preventDefault();
    const formData = new FormData(form);
    const response = await fetch(window.appUrl('/api/login.php'), { method: 'POST', body: formData });
    const data = await response.json();
    if (data.success) {
      window.location.href = window.appUrl('/admin/dashboard');
      return;
    }
    errorBox.textContent = data.message || 'Invalid username or password';
    errorBox.classList.remove('hidden');
  });
});
</script>
<?php include __DIR__ . '/../includes/footer.php'; ?>
