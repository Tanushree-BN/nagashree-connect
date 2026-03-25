<?php
require_once __DIR__ . '/../functions/helpers.php';
require_admin_auth();

$pageTitle = 'Daily Updates Management';
$currentPath = '/admin/daily-updates';
$isAdminLayout = true;
require_once __DIR__ . '/../includes/header.php';
$adminPath = '/admin/daily-updates';
$updates = get_daily_updates();
?>
<div class="min-h-screen bg-muted flex admin-layout-mobile-stack">
  <?php include __DIR__ . '/../includes/sidebar.php'; ?>
  <main class="flex-1 p-8 overflow-auto admin-main-content">
    <div class="flex items-center justify-between mb-6">
      <div>
        <h1 class="font-display text-2xl font-bold text-foreground">Daily Updates Management</h1>
        <p class="text-sm text-muted-foreground mt-1">Manage homepage daily updates.</p>
      </div>
    </div>

    <form id="daily-update-form" class="bg-card rounded-xl p-6 border border-border mb-6 space-y-4">
      <h3 id="daily-update-form-title" class="font-semibold text-foreground">Add Daily Update</h3>
      <input type="hidden" id="daily-update-id" name="id" value="" />

      <div class="grid sm:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-foreground mb-1">Title *</label>
          <input name="title" required class="w-full px-3 py-2 rounded-lg border border-input bg-background text-foreground text-sm" placeholder="e.g. Activities" />
        </div>
        <div class="sm:col-span-2">
          <label class="block text-sm font-medium text-foreground mb-1">Description *</label>
          <textarea name="description" required rows="4" class="w-full px-3 py-2 rounded-lg border border-input bg-background text-foreground text-sm" placeholder="Enter update details..."></textarea>
        </div>
      </div>

      <div class="flex gap-3">
        <button type="submit" id="daily-update-submit-btn" class="inline-flex items-center gap-2 px-6 py-2 rounded-lg bg-gold text-secondary-foreground text-sm font-semibold hover:bg-gold-dark transition-colors"><i data-lucide="save" class="w-4 h-4"></i> Add</button>
        <button type="button" id="daily-update-cancel-edit" class="hidden px-6 py-2 rounded-lg border border-border text-sm font-medium hover:bg-muted transition-colors">Cancel Edit</button>
      </div>
    </form>

    <div class="bg-card rounded-xl border border-border p-4 sm:p-6">
      <?php if (count($updates) === 0): ?>
        <p class="text-center py-8 text-muted-foreground">No daily updates yet.</p>
      <?php else: ?>
        <div class="space-y-3">
          <?php foreach ($updates as $item): ?>
            <article class="rounded-xl border border-border bg-background p-4">
              <div class="flex items-start justify-between gap-3">
                <div class="min-w-0">
                  <p class="text-sm font-semibold text-foreground"><?= h($item['title'] ?? '') ?></p>
                  <p class="text-sm text-muted-foreground mt-1 leading-relaxed"><?= h($item['description'] ?? '') ?></p>
                </div>
                <div class="flex items-center gap-1 shrink-0">
                  <button data-edit-daily-update="1" data-update-id="<?= h((string) ($item['id'] ?? '')) ?>" data-update-title="<?= h((string) ($item['title'] ?? '')) ?>" data-update-description="<?= h((string) ($item['description'] ?? '')) ?>" class="p-1.5 rounded text-muted-foreground hover:text-gold"><i data-lucide="edit-2" class="w-4 h-4"></i></button>
                  <button data-delete-daily-update="<?= h((string) ($item['id'] ?? '')) ?>" class="p-1.5 rounded text-muted-foreground hover:text-destructive"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                </div>
              </div>
            </article>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </main>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
  const form = document.getElementById('daily-update-form');
  const formTitle = document.getElementById('daily-update-form-title');
  const submitBtn = document.getElementById('daily-update-submit-btn');
  const cancelEditBtn = document.getElementById('daily-update-cancel-edit');
  const idInput = document.getElementById('daily-update-id');

  const postToApi = async function(data) {
    const response = await fetch(window.appUrl('/api/update-data.php'), { method: 'POST', body: data });
    const result = await response.json();
    if (!response.ok || !result || result.success !== true) {
      throw new Error((result && result.message) || 'Request failed');
    }
    return result;
  };

  const resetFormMode = function() {
    formTitle.textContent = 'Add Daily Update';
    submitBtn.innerHTML = '<i data-lucide="save" class="w-4 h-4"></i> Add';
    cancelEditBtn.classList.add('hidden');
    idInput.value = '';
    form.reset();
    if (window.lucide) window.lucide.createIcons();
  };

  if (cancelEditBtn) {
    cancelEditBtn.addEventListener('click', function() {
      resetFormMode();
    });
  }

  if (form) {
    form.addEventListener('submit', async function(event) {
      event.preventDefault();
      try {
        const data = new FormData(form);
        data.append('action', idInput.value ? 'update_daily_update' : 'add_daily_update');
        await postToApi(data);
        location.reload();
      } catch (error) {
        alert(error && error.message ? error.message : 'Server error');
      }
    });
  }

  document.querySelectorAll('[data-edit-daily-update]').forEach((button) => {
    button.addEventListener('click', function() {
      idInput.value = button.getAttribute('data-update-id') || '';
      form.querySelector('[name="title"]').value = button.getAttribute('data-update-title') || '';
      form.querySelector('[name="description"]').value = button.getAttribute('data-update-description') || '';

      formTitle.textContent = 'Edit Daily Update';
      submitBtn.innerHTML = '<i data-lucide="save" class="w-4 h-4"></i> Update';
      cancelEditBtn.classList.remove('hidden');
      if (window.lucide) window.lucide.createIcons();
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  });

  document.querySelectorAll('[data-delete-daily-update]').forEach((button) => {
    button.addEventListener('click', async function() {
      if (!confirm('Delete this daily update?')) return;
      try {
        const data = new FormData();
        data.append('action', 'delete_daily_update');
        data.append('id', button.getAttribute('data-delete-daily-update') || '');
        await postToApi(data);
        location.reload();
      } catch (error) {
        alert(error && error.message ? error.message : 'Server error');
      }
    });
  });
});
</script>
<script src="https://unpkg.com/lucide@latest"></script>
<script>window.lucide && window.lucide.createIcons();</script>
</body></html>
