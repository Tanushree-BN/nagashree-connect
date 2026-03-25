<?php
require_once __DIR__ . '/../functions/helpers.php';
require_admin_auth();

$pageTitle = 'Gallery Management';
$currentPath = '/admin/gallery';
$isAdminLayout = true;
require_once __DIR__ . '/../includes/header.php';
$adminPath = '/admin/gallery';
$images = get_gallery_images();
?>
<div class="min-h-screen bg-muted flex admin-layout-mobile-stack">
  <?php include __DIR__ . '/../includes/sidebar.php'; ?>
  <main class="flex-1 p-8 overflow-auto">
    <div class="flex items-center justify-between mb-6">
      <div>
        <h1 class="font-display text-2xl font-bold text-foreground">Gallery Management</h1>
        <p class="text-sm text-muted-foreground mt-1">Gallery Usage: <span class="text-foreground font-medium"><?= count($images) ?></span> / 50 images</p>
      </div>
    </div>

    <form id="gallery-form" class="bg-card rounded-xl p-6 border border-border mb-6 space-y-4">
      <h3 id="gallery-form-title" class="font-semibold text-foreground">Add New Image</h3>
      <input type="hidden" id="gallery-id" name="id" value="" />
      <input type="hidden" id="gallery-src" name="src" value="" />
      <div class="grid sm:grid-cols-2 gap-4">
        <div class="sm:col-span-2">
          <label class="block text-sm font-medium text-foreground mb-1">Image Upload *</label>
          <div id="gallery-upload-box" class="rounded-lg border border-dashed border-input bg-background p-5 text-center transition-colors">
            <img id="gallery-preview" alt="Selected gallery preview" class="hidden mx-auto mb-3 h-24 w-24 rounded-lg object-cover bg-muted" />
            <p class="text-sm text-muted-foreground">Drag and drop an image here, or choose from your system.</p>
            <button type="button" id="gallery-pick-btn" class="mt-3 inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-border text-sm font-medium hover:bg-muted transition-colors"><i data-lucide="upload" class="w-4 h-4"></i> Choose Image</button>
            <input type="file" id="gallery-file" accept="image/*" class="hidden" />
          </div>
        </div>
        <div>
          <label class="block text-sm font-medium text-foreground mb-1">Title *</label>
          <input name="title" required class="w-full px-3 py-2 rounded-lg border border-input bg-background text-foreground text-sm" />
        </div>
        <div>
          <label class="block text-sm font-medium text-foreground mb-1">Alt Text *</label>
          <input name="alt" required class="w-full px-3 py-2 rounded-lg border border-input bg-background text-foreground text-sm" />
        </div>
        <div>
          <label class="block text-sm font-medium text-foreground mb-1">Category *</label>
          <select name="category" class="w-full px-3 py-2 rounded-lg border border-input bg-background text-foreground text-sm">
            <option value="events">Events</option>
            <option value="classroom">Classroom</option>
            <option value="sports">Sports</option>
            <option value="facilities">Facilities</option>
          </select>
        </div>
      </div>
      <div class="flex gap-3">
        <button type="submit" id="gallery-submit-btn" class="inline-flex items-center gap-2 px-6 py-2 rounded-lg bg-gold text-secondary-foreground text-sm font-semibold hover:bg-gold-dark transition-colors"><i data-lucide="save" class="w-4 h-4"></i> Add</button>
        <button type="button" id="gallery-cancel-edit" class="hidden px-6 py-2 rounded-lg border border-border text-sm font-medium hover:bg-muted transition-colors">Cancel Edit</button>
      </div>
    </form>

    <div class="bg-card rounded-xl border border-border overflow-hidden">
      <table class="w-full text-sm">
        <thead class="bg-muted">
          <tr>
            <th class="text-left px-4 py-3 text-muted-foreground font-medium">Preview</th>
            <th class="text-left px-4 py-3 text-muted-foreground font-medium">Title</th>
            <th class="text-left px-4 py-3 text-muted-foreground font-medium">Category</th>
            <th class="text-right px-4 py-3 text-muted-foreground font-medium">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-border">
          <?php foreach ($images as $img): ?>
            <tr class="hover:bg-muted/50">
              <td class="px-4 py-3"><img src="<?= h($img['src']) ?>" alt="<?= h($img['alt']) ?>" class="w-12 h-12 rounded object-cover bg-muted" /></td>
              <td class="px-4 py-3 text-foreground"><?= h($img['title']) ?></td>
              <td class="px-4 py-3 capitalize text-muted-foreground"><?= h($img['category']) ?></td>
              <td class="px-4 py-3 text-right">
                <button data-edit-gallery='<?= h(json_encode($img, JSON_HEX_APOS | JSON_HEX_QUOT)) ?>' class="p-1.5 rounded text-muted-foreground hover:text-gold"><i data-lucide="edit-2" class="w-4 h-4"></i></button>
                <button data-delete-gallery="<?= h((string) $img['id']) ?>" class="p-1.5 rounded text-muted-foreground hover:text-destructive"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <?php if (count($images) === 0): ?><p class="text-center py-8 text-muted-foreground">No images yet.</p><?php endif; ?>
    </div>
  </main>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
  const form = document.getElementById('gallery-form');
  const formTitle = document.getElementById('gallery-form-title');
  const submitBtn = document.getElementById('gallery-submit-btn');
  const cancelEditBtn = document.getElementById('gallery-cancel-edit');
  const idInput = document.getElementById('gallery-id');
  const srcInput = document.getElementById('gallery-src');
  const fileInput = document.getElementById('gallery-file');
  const uploadBox = document.getElementById('gallery-upload-box');
  const pickBtn = document.getElementById('gallery-pick-btn');
  const preview = document.getElementById('gallery-preview');

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
      srcInput.value = value;
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
    formTitle.textContent = 'Add New Image';
    submitBtn.innerHTML = '<i data-lucide="save" class="w-4 h-4"></i> Add';
    cancelEditBtn.classList.add('hidden');
    idInput.value = '';
    srcInput.value = '';
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
    if (!idInput.value && !srcInput.value) {
      fileInput && fileInput.click();
      return;
    }
    try {
      const data = new FormData(form);
      data.append('action', idInput.value ? 'update_gallery' : 'add_gallery');
      await postToApi(data);
      location.reload();
    } catch (error) {
      alert(error && error.message ? error.message : 'Server error');
    }
  });

  document.querySelectorAll('[data-edit-gallery]').forEach((button) => {
    button.addEventListener('click', function() {
      const row = JSON.parse(button.getAttribute('data-edit-gallery'));
      idInput.value = row.id;
      srcInput.value = row.src || '';
      setPreview(row.src || '');
      form.querySelector('[name="title"]').value = row.title || '';
      form.querySelector('[name="alt"]').value = row.alt || '';
      form.querySelector('[name="category"]').value = row.category || 'events';
      formTitle.textContent = 'Edit Image';
      submitBtn.innerHTML = '<i data-lucide="save" class="w-4 h-4"></i> Update';
      cancelEditBtn.classList.remove('hidden');
      if (window.lucide) window.lucide.createIcons();
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  });

  document.querySelectorAll('[data-delete-gallery]').forEach((button) => {
    button.addEventListener('click', async function() {
      if (!confirm('Delete this image?')) return;
      try {
        const data = new FormData();
        data.append('action', 'delete_gallery');
        data.append('id', button.getAttribute('data-delete-gallery'));
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
