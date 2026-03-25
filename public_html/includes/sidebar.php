<?php
$adminPath = $adminPath ?? '/admin/dashboard';
$items = [
    ['label' => 'Gallery', 'path' => '/admin/gallery', 'icon' => 'image'],
  ['label' => 'Daily Updates', 'path' => '/admin/daily-updates', 'icon' => 'calendar-days'],
    ['label' => 'Faculties', 'path' => '/admin/faculties', 'icon' => 'users'],
    ['label' => 'Messages', 'path' => '/admin/messages', 'icon' => 'message-square'],
    ['label' => 'Admissions', 'path' => '/admin/admissions', 'icon' => 'file-text'],
];
?>
<aside class="w-full lg:w-64 gradient-navy text-primary-foreground flex flex-col shrink-0 admin-sidebar">
  <div class="p-6 border-b border-primary-foreground/10">
    <h2 class="font-display text-lg font-bold">Admin Panel</h2>
    <p class="text-primary-foreground/60 text-xs mt-1">Nagashree English School</p>
  </div>
  <div class="p-4 space-y-1 border-b border-primary-foreground/10 admin-sidebar-actions">
    <a href="/" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium text-primary-foreground/70 hover:bg-primary-foreground/10 transition-colors">
      <i data-lucide="home" class="w-4 h-4"></i> Back to Website
    </a>
    <a href="/logout" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium text-primary-foreground/70 hover:bg-primary-foreground/10 transition-colors w-full">
      <i data-lucide="log-out" class="w-4 h-4"></i> Logout
    </a>
  </div>
  <div class="px-4 pt-3 lg:hidden">
    <button type="button" id="admin-menu-toggle" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg border border-primary-foreground/20 text-sm font-medium text-primary-foreground/80 hover:bg-primary-foreground/10 transition-colors">
      <i data-lucide="menu" class="w-4 h-4"></i> Menu
    </button>
  </div>
  <nav id="admin-menu-panel" class="hidden lg:block flex-1 p-4 space-y-1 admin-sidebar-nav">
    <?php foreach ($items as $item): ?>
      <a href="<?= h($item['path']) ?>" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-colors <?= $adminPath === $item['path'] ? 'bg-gold text-secondary-foreground' : 'text-primary-foreground/70 hover:bg-primary-foreground/10' ?>">
        <i data-lucide="<?= h($item['icon']) ?>" class="w-4 h-4"></i>
        <?= h($item['label']) ?>
      </a>
    <?php endforeach; ?>
  </nav>
</aside>
<script>
document.addEventListener('DOMContentLoaded', function () {
  var adminMenuToggle = document.getElementById('admin-menu-toggle');
  var adminMenuPanel = document.getElementById('admin-menu-panel');
  if (!adminMenuToggle || !adminMenuPanel) return;

  adminMenuToggle.addEventListener('click', function () {
    adminMenuPanel.classList.toggle('hidden');
  });
});
</script>
