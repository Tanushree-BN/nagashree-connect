<?php
require_once __DIR__ . '/../functions/helpers.php';
require_admin_auth();

$pageTitle = 'Faculty Management';
$currentPath = '/admin/faculties';
$isAdminLayout = true;
require_once __DIR__ . '/../includes/header.php';
$adminPath = '/admin/faculties';
$list = get_faculties();
?>
<div class="min-h-screen bg-muted flex admin-layout-mobile-stack">
  <?php include __DIR__ . '/../includes/sidebar.php'; ?>
  <main class="flex-1 p-8 overflow-auto admin-main-content">
    <div class="flex items-center justify-between mb-6"><h1 class="font-display text-2xl font-bold text-foreground">Faculty Management</h1></div>

    <form id="faculty-form" class="bg-card rounded-xl p-6 border border-border mb-6 space-y-4">
      <h3 id="faculty-form-title" class="font-semibold text-foreground">Add New Faculty</h3>
      <input type="hidden" id="faculty-id" name="id" value="" />
      <input type="hidden" id="faculty-image" name="image" value="" />
      <div class="grid sm:grid-cols-2 gap-4">
        <div><label class="block text-sm font-medium text-foreground mb-1">Name *</label><input name="name" required class="w-full px-3 py-2 rounded-lg border border-input bg-background text-foreground text-sm" /></div>
        <div><label class="block text-sm font-medium text-foreground mb-1">Role *</label><input name="role" required class="w-full px-3 py-2 rounded-lg border border-input bg-background text-foreground text-sm" /></div>
        <div><label class="block text-sm font-medium text-foreground mb-1">Subject *</label><input name="subject" required class="w-full px-3 py-2 rounded-lg border border-input bg-background text-foreground text-sm" /></div>
        <div><label class="block text-sm font-medium text-foreground mb-1">Experience *</label><input name="experience" required class="w-full px-3 py-2 rounded-lg border border-input bg-background text-foreground text-sm" /></div>
        <div class="sm:col-span-2">
          <label class="block text-sm font-medium text-foreground mb-1">Profile Image Upload</label>
          <div id="faculty-upload-box" class="rounded-lg border border-dashed border-input bg-background p-5 text-center transition-colors">
            <img id="faculty-preview" alt="Selected faculty preview" class="hidden mx-auto mb-3 h-24 w-24 rounded-full object-cover bg-muted" />
            <p class="text-sm text-muted-foreground">Drag and drop an image here, or choose from your system.</p>
            <button type="button" id="faculty-pick-btn" class="mt-3 inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-border text-sm font-medium hover:bg-muted transition-colors"><i data-lucide="upload" class="w-4 h-4"></i> Choose Image</button>
            <input type="file" id="faculty-file" accept="image/*" class="hidden" />
          </div>
        </div>
      </div>
      <div class="flex gap-3">
        <button type="submit" id="faculty-submit-btn" class="inline-flex items-center gap-2 px-6 py-2 rounded-lg bg-gold text-secondary-foreground text-sm font-semibold hover:bg-gold-dark transition-colors"><i data-lucide="save" class="w-4 h-4"></i> Add</button>
        <button type="button" id="faculty-cancel-edit" class="hidden px-6 py-2 rounded-lg border border-border text-sm font-medium hover:bg-muted transition-colors">Cancel Edit</button>
      </div>
    </form>

    <div class="bg-card rounded-xl border border-border overflow-hidden">
      <?php if (count($list) === 0): ?>
        <p class="text-center py-8 text-muted-foreground">No faculty members yet.</p>
      <?php else: ?>
        <div class="md:hidden p-4 space-y-3">
          <?php foreach ($list as $faculty): ?>
            <article class="rounded-lg border border-border bg-background p-4">
              <div class="flex items-start justify-between gap-3">
                <div class="flex items-center gap-3 min-w-0">
                  <?php if (!empty($faculty['image'])): ?>
                    <img src="<?= h($faculty['image']) ?>" alt="<?= h($faculty['name']) ?>" class="w-12 h-12 rounded-full object-cover bg-muted" width="48" height="48" loading="lazy" decoding="async" />
                  <?php else: ?>
                    <div class="w-12 h-12 rounded-full bg-muted flex items-center justify-center"><i data-lucide="user" class="w-5 h-5 text-muted-foreground"></i></div>
                  <?php endif; ?>
                  <div class="min-w-0">
                    <p class="text-sm font-semibold text-foreground truncate"><?= h($faculty['name']) ?></p>
                    <p class="text-xs text-gold mt-0.5"><?= h($faculty['role']) ?></p>
                  </div>
                </div>
                <div class="flex items-center gap-1 shrink-0">
                  <button data-edit-faculty="1" data-faculty-id="<?= h((string) ($faculty['id'] ?? '')) ?>" data-faculty-name="<?= h((string) ($faculty['name'] ?? '')) ?>" data-faculty-role="<?= h((string) ($faculty['role'] ?? '')) ?>" data-faculty-subject="<?= h((string) ($faculty['subject'] ?? '')) ?>" data-faculty-experience="<?= h((string) ($faculty['experience'] ?? '')) ?>" data-faculty-image="<?= h((string) ($faculty['image'] ?? '')) ?>" class="p-1.5 rounded text-muted-foreground hover:text-gold"><i data-lucide="edit-2" class="w-4 h-4"></i></button>
                  <button data-delete-faculty="<?= h((string) $faculty['id']) ?>" class="p-1.5 rounded text-muted-foreground hover:text-destructive"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                </div>
              </div>
              <div class="mt-3 grid grid-cols-1 gap-1 text-sm">
                <p><span class="text-muted-foreground">Subject:</span> <span class="text-foreground"><?= h($faculty['subject']) ?></span></p>
                <p><span class="text-muted-foreground">Experience:</span> <span class="text-foreground"><?= h($faculty['experience']) ?></span></p>
              </div>
            </article>
          <?php endforeach; ?>
        </div>

        <table class="hidden md:table w-full text-sm">
          <thead class="bg-muted"><tr><th class="text-left px-4 py-3 text-muted-foreground font-medium">Pic</th><th class="text-left px-4 py-3 text-muted-foreground font-medium">Name</th><th class="text-left px-4 py-3 text-muted-foreground font-medium">Role</th><th class="text-left px-4 py-3 text-muted-foreground font-medium">Subject</th><th class="text-left px-4 py-3 text-muted-foreground font-medium">Experience</th><th class="text-right px-4 py-3 text-muted-foreground font-medium">Actions</th></tr></thead>
          <tbody class="divide-y divide-border">
            <?php foreach ($list as $faculty): ?>
              <tr class="hover:bg-muted/50">
                <td class="px-4 py-3"><?php if (!empty($faculty['image'])): ?><img src="<?= h($faculty['image']) ?>" alt="<?= h($faculty['name']) ?>" class="w-10 h-10 rounded-full object-cover bg-muted" width="40" height="40" loading="lazy" decoding="async" /><?php else: ?><div class="w-10 h-10 rounded-full bg-muted flex items-center justify-center"><i data-lucide="user" class="w-5 h-5 text-muted-foreground"></i></div><?php endif; ?></td>
                <td class="px-4 py-3 text-foreground font-medium"><?= h($faculty['name']) ?></td>
                <td class="px-4 py-3 text-gold"><?= h($faculty['role']) ?></td>
                <td class="px-4 py-3 text-muted-foreground"><?= h($faculty['subject']) ?></td>
                <td class="px-4 py-3 text-muted-foreground"><?= h($faculty['experience']) ?></td>
                <td class="px-4 py-3 text-right">
                  <button data-edit-faculty="1" data-faculty-id="<?= h((string) ($faculty['id'] ?? '')) ?>" data-faculty-name="<?= h((string) ($faculty['name'] ?? '')) ?>" data-faculty-role="<?= h((string) ($faculty['role'] ?? '')) ?>" data-faculty-subject="<?= h((string) ($faculty['subject'] ?? '')) ?>" data-faculty-experience="<?= h((string) ($faculty['experience'] ?? '')) ?>" data-faculty-image="<?= h((string) ($faculty['image'] ?? '')) ?>" class="p-1.5 rounded text-muted-foreground hover:text-gold"><i data-lucide="edit-2" class="w-4 h-4"></i></button>
                  <button data-delete-faculty="<?= h((string) $faculty['id']) ?>" class="p-1.5 rounded text-muted-foreground hover:text-destructive"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>
  </main>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
  const form = document.getElementById('faculty-form');
  const formTitle = document.getElementById('faculty-form-title');
  const submitBtn = document.getElementById('faculty-submit-btn');
  const cancelEditBtn = document.getElementById('faculty-cancel-edit');
  const idInput = document.getElementById('faculty-id');
  const imageInput = document.getElementById('faculty-image');
  const fileInput = document.getElementById('faculty-file');
  const uploadBox = document.getElementById('faculty-upload-box');
  const pickBtn = document.getElementById('faculty-pick-btn');
  const preview = document.getElementById('faculty-preview');

  const postToApi = async function(data) {
    const response = await fetch(window.appUrl('/api/update-data.php'), { method: 'POST', body: data });
    const rawText = await response.text();
    let parsed = null;
    try {
      parsed = rawText ? JSON.parse(rawText) : null;
    } catch (error) {
      throw new Error(rawText || 'Invalid server response');
    }

    if (!response.ok || !parsed || parsed.success !== true) {
      throw new Error((parsed && parsed.message) || `Request failed (${response.status})`);
    }

    return parsed;
  };

  const setPreview = function(value) {
    if (!preview) return;
    if (value) {
      preview.src = value;
      preview.classList.remove('hidden');
    } else {
      preview.src = '';
      preview.classList.add('hidden');
    }
  };

  const readSelectedFile = function(file) {
    if (!file || !file.type.startsWith('image/')) return;
    const reader = new FileReader();
    reader.onload = function(event) {
      const value = event.target && event.target.result ? String(event.target.result) : '';
      imageInput.value = value;
      setPreview(value);
    };
    reader.readAsDataURL(file);
  };

  if (pickBtn && fileInput) {
    pickBtn.addEventListener('click', function() {
      fileInput.click();
    });
  }

  if (fileInput) {
    fileInput.addEventListener('change', function() {
      const file = fileInput.files && fileInput.files[0];
      readSelectedFile(file);
    });
  }

  if (uploadBox) {
    ['dragenter', 'dragover'].forEach((eventName) => {
      uploadBox.addEventListener(eventName, function(event) {
        event.preventDefault();
        uploadBox.classList.add('border-gold', 'bg-gold/5');
      });
    });

    ['dragleave', 'drop'].forEach((eventName) => {
      uploadBox.addEventListener(eventName, function(event) {
        event.preventDefault();
        uploadBox.classList.remove('border-gold', 'bg-gold/5');
      });
    });

    uploadBox.addEventListener('drop', function(event) {
      const file = event.dataTransfer && event.dataTransfer.files ? event.dataTransfer.files[0] : null;
      readSelectedFile(file);
    });
  }

  const resetFormMode = function() {
    formTitle.textContent = 'Add New Faculty';
    submitBtn.innerHTML = '<i data-lucide="save" class="w-4 h-4"></i> Add';
    cancelEditBtn.classList.add('hidden');
    idInput.value = '';
    imageInput.value = '';
    if (fileInput) fileInput.value = '';
    setPreview('');
    if (window.lucide) window.lucide.createIcons();
  };

  if (cancelEditBtn) {
    cancelEditBtn.addEventListener('click', function() {
      form.reset();
      resetFormMode();
    });
  }

  form.addEventListener('submit', async function(event) {
    event.preventDefault();
    if (!idInput.value && !imageInput.value) {
      fileInput && fileInput.click();
      return;
    }
    try {
      const data = new FormData(form);
      data.append('action', idInput.value ? 'update_faculty' : 'add_faculty');
      await postToApi(data);
      location.reload();
    } catch (error) {
      alert(error && error.message ? error.message : 'Server error');
    }
  });

  document.querySelectorAll('[data-edit-faculty]').forEach((button) => {
    button.addEventListener('click', function() {
      const id = button.getAttribute('data-faculty-id') || '';
      const name = button.getAttribute('data-faculty-name') || '';
      const role = button.getAttribute('data-faculty-role') || '';
      const subject = button.getAttribute('data-faculty-subject') || '';
      const experience = button.getAttribute('data-faculty-experience') || '';
      const image = button.getAttribute('data-faculty-image') || '';

      idInput.value = id;
      form.querySelector('[name="name"]').value = name;
      form.querySelector('[name="role"]').value = role;
      form.querySelector('[name="subject"]').value = subject;
      form.querySelector('[name="experience"]').value = experience;
      imageInput.value = image;
      setPreview(image);
      formTitle.textContent = 'Edit Faculty';
      submitBtn.innerHTML = '<i data-lucide="save" class="w-4 h-4"></i> Update';
      cancelEditBtn.classList.remove('hidden');
      if (window.lucide) window.lucide.createIcons();
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  });

  document.querySelectorAll('[data-delete-faculty]').forEach((button) => {
    button.addEventListener('click', async function() {
      if (!confirm('Delete this faculty member?')) return;
      try {
        const data = new FormData();
        data.append('action', 'delete_faculty');
        data.append('id', button.getAttribute('data-delete-faculty'));
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
