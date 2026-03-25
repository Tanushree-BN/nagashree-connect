<?php
require_once __DIR__ . '/../functions/helpers.php';
require_admin_auth();

$pageTitle = 'Contact Messages';
$currentPath = '/admin/messages';
$isAdminLayout = true;
require_once __DIR__ . '/../includes/header.php';
$adminPath = '/admin/messages';
$messages = get_messages();
$unseen = count(array_filter($messages, static fn($m) => (int) $m['seen'] === 0));
?>
<div class="min-h-screen bg-muted flex admin-layout-mobile-stack">
  <?php include __DIR__ . '/../includes/sidebar.php'; ?>
  <main class="flex-1 p-8 overflow-auto admin-main-content">
    <div class="flex items-center justify-between mb-6">
      <div>
        <h1 class="font-display text-2xl font-bold text-foreground">Contact Messages</h1>
        <?php if ($unseen > 0): ?><p class="text-gold text-sm mt-1"><?= $unseen ?> new message<?= $unseen > 1 ? 's' : '' ?></p><?php endif; ?>
      </div>
    </div>

    <?php if (count($messages) === 0): ?>
      <div class="bg-card rounded-xl border border-border p-12 text-center"><i data-lucide="mail" class="w-12 h-12 text-muted-foreground mx-auto mb-3"></i><p class="text-muted-foreground">No messages yet. Messages sent via the Contact page will appear here.</p></div>
    <?php else: ?>
      <div class="space-y-3">
        <?php foreach ($messages as $msg): ?>
          <div class="bg-card rounded-xl border <?= (int) $msg['seen'] === 1 ? 'border-border' : 'border-gold' ?> overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4">
              <div class="flex items-center gap-3"><i data-lucide="<?= (int) $msg['seen'] === 1 ? 'mail-open' : 'mail' ?>" class="w-4 h-4 <?= (int) $msg['seen'] === 1 ? 'text-muted-foreground' : 'text-gold' ?>"></i><div><span class="font-medium text-sm text-foreground"><?= h($msg['name']) ?></span><span class="text-muted-foreground text-xs ml-3"><?= h($msg['subject']) ?></span></div></div>
              <div class="flex items-center gap-2"><span class="text-muted-foreground text-xs"><?= h(date('d/m/Y', strtotime($msg['created_at']))) ?></span><button data-delete-message="<?= h((string) $msg['id']) ?>" class="p-1 text-muted-foreground hover:text-destructive"><i data-lucide="trash-2" class="w-4 h-4"></i></button></div>
            </div>
            <div class="px-5 pb-5 border-t border-border pt-4 space-y-2 text-sm">
              <p><span class="text-muted-foreground">Email:</span> <span class="text-foreground"><?= h($msg['email']) ?></span></p>
              <?php if (!empty($msg['phone'])): ?><p><span class="text-muted-foreground">Phone:</span> <span class="text-foreground"><?= h($msg['phone']) ?></span></p><?php endif; ?>
              <p class="text-foreground leading-relaxed mt-3"><?= nl2br(h($msg['message'])) ?></p>
              <?php if ((int) $msg['seen'] === 0): ?><button data-mark-message="<?= h((string) $msg['id']) ?>" class="mt-2 text-gold text-sm font-medium hover:text-gold-dark">Mark as read</button><?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </main>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('[data-mark-message]').forEach((button) => {
    button.addEventListener('click', async function() {
      const data = new FormData();
      data.append('action', 'mark_message_seen');
      data.append('id', button.getAttribute('data-mark-message'));
      const result = await fetch(window.appUrl('/api/update-data.php'), { method: 'POST', body: data }).then((r) => r.json());
      if (result.success) location.reload();
    });
  });

  document.querySelectorAll('[data-delete-message]').forEach((button) => {
    button.addEventListener('click', async function() {
      if (!confirm('Delete this message?')) return;
      const data = new FormData();
      data.append('action', 'delete_message');
      data.append('id', button.getAttribute('data-delete-message'));
      const result = await fetch(window.appUrl('/api/update-data.php'), { method: 'POST', body: data }).then((r) => r.json());
      if (result.success) location.reload();
    });
  });
});
</script>
<script src="https://unpkg.com/lucide@latest"></script>
<script>window.lucide && window.lucide.createIcons();</script>
</body></html>
