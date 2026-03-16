<?php
require_once __DIR__ . '/../functions/helpers.php';
require_admin_auth();

$pageTitle = 'Admission Forms';
$currentPath = '/admin/admissions';
$isAdminLayout = true;
require_once __DIR__ . '/../includes/header.php';
$adminPath = '/admin/admissions';
$admissions = get_admissions();
$unseen = count(array_filter($admissions, static fn($a) => (int) $a['seen'] === 0));
?>
<div class="min-h-screen bg-muted flex admin-layout-mobile-stack">
  <?php include __DIR__ . '/../includes/sidebar.php'; ?>
  <main class="flex-1 p-8 overflow-auto">
    <div class="flex items-center justify-between mb-6">
      <div>
        <h1 class="font-display text-2xl font-bold text-foreground">Admission Forms</h1>
        <?php if ($unseen > 0): ?><p class="text-gold text-sm mt-1"><?= $unseen ?> new submission<?= $unseen > 1 ? 's' : '' ?></p><?php endif; ?>
      </div>
    </div>

    <?php if (count($admissions) === 0): ?>
      <div class="bg-card rounded-xl border border-border p-12 text-center"><i data-lucide="file-text" class="w-12 h-12 text-muted-foreground mx-auto mb-3"></i><p class="text-muted-foreground">No admission forms submitted yet.</p></div>
    <?php else: ?>
      <div class="space-y-3">
        <?php foreach ($admissions as $form): ?>
          <div class="bg-card rounded-xl border <?= (int) $form['seen'] === 1 ? 'border-border' : 'border-gold' ?> overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4">
              <div class="flex items-center gap-3"><i data-lucide="<?= (int) $form['seen'] === 1 ? 'check-circle' : 'clock' ?>" class="w-4 h-4 <?= (int) $form['seen'] === 1 ? 'text-muted-foreground' : 'text-gold' ?>"></i><div><span class="font-medium text-sm text-foreground"><?= h($form['student_name']) ?></span><span class="text-muted-foreground text-xs ml-3">Class: <?= h($form['class_applying']) ?></span><?php if ((int) $form['seen'] === 0): ?><span class="ml-2 px-2 py-0.5 rounded-full bg-gold/10 text-gold text-xs font-medium">New</span><?php endif; ?></div></div>
              <div class="flex items-center gap-2"><span class="text-muted-foreground text-xs"><?= h(date('d/m/Y', strtotime($form['created_at']))) ?></span><button data-download-admission='<?= h(json_encode($form, JSON_HEX_APOS | JSON_HEX_QUOT)) ?>' class="p-1 text-muted-foreground hover:text-gold" title="Download PDF"><i data-lucide="download" class="w-4 h-4"></i></button><button data-delete-admission="<?= h((string) $form['id']) ?>" class="p-1 text-muted-foreground hover:text-destructive"><i data-lucide="trash-2" class="w-4 h-4"></i></button></div>
            </div>
            <div class="px-5 pb-5 border-t border-border pt-4 text-sm">
              <div class="grid sm:grid-cols-2 gap-3">
                <div><span class="text-muted-foreground">Student Name:</span> <span class="text-foreground font-medium"><?= h($form['student_name']) ?></span></div>
                <div><span class="text-muted-foreground">Parent/Guardian:</span> <span class="text-foreground font-medium"><?= h($form['parent_name']) ?></span></div>
                <div><span class="text-muted-foreground">Date of Birth:</span> <span class="text-foreground font-medium"><?= h($form['dob']) ?></span></div>
                <div><span class="text-muted-foreground">Gender:</span> <span class="text-foreground font-medium"><?= h($form['gender']) ?></span></div>
                <div><span class="text-muted-foreground">Class Applied:</span> <span class="text-foreground font-medium"><?= h($form['class_applying']) ?></span></div>
                <div><span class="text-muted-foreground">Phone:</span> <span class="text-foreground font-medium"><?= h($form['phone']) ?></span></div>
                <div><span class="text-muted-foreground">Email:</span> <span class="text-foreground font-medium"><?= h($form['email'] ?: 'N/A') ?></span></div>
                <div><span class="text-muted-foreground">Previous School:</span> <span class="text-foreground font-medium"><?= h($form['previous_school'] ?: 'N/A') ?></span></div>
                <div><span class="text-muted-foreground">Previous Grade:</span> <span class="text-foreground font-medium"><?= h($form['previous_grade'] ?: 'N/A') ?></span></div>
                <div><span class="text-muted-foreground">Aadhaar:</span> <span class="text-foreground font-medium"><?= h($form['aadhaar'] ?: 'N/A') ?></span></div>
              </div>
              <div class="mt-3"><span class="text-muted-foreground">Address:</span> <span class="text-foreground"><?= h($form['address']) ?></span></div>
              <?php if ((int) $form['seen'] === 0): ?><button data-mark-admission="<?= h((string) $form['id']) ?>" class="mt-2 text-gold text-sm font-medium hover:text-gold-dark">Mark as read</button><?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </main>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('[data-download-admission]').forEach((button) => {
    button.addEventListener('click', function() {
      if (!window.jspdf || !window.jspdf.jsPDF) return;
      const form = JSON.parse(button.getAttribute('data-download-admission'));
      const doc = new window.jspdf.jsPDF();
      doc.setFontSize(18);
      doc.text('Nagashree English School - Admission Form', 20, 20);
      doc.setFontSize(11);
      const fields = [
        ['Student Name', form.student_name],
        ['Parent/Guardian', form.parent_name],
        ['Date of Birth', form.dob],
        ['Gender', form.gender],
        ['Class Applied', form.class_applying],
        ['Phone', form.phone],
        ['Email', form.email || 'N/A'],
        ['Address', form.address],
        ['Previous School', form.previous_school || 'N/A'],
        ['Previous Grade', form.previous_grade || 'N/A'],
        ['Aadhaar', form.aadhaar || 'N/A'],
        ['Submitted On', form.created_at]
      ];
      let y = 35;
      fields.forEach((item) => {
        const label = item[0];
        const value = String(item[1]);
        doc.setFont('helvetica', 'bold');
        doc.text(label + ':', 20, y);
        doc.setFont('helvetica', 'normal');
        doc.text(value, 75, y);
        y += 8;
      });
      doc.save('admission_' + String(form.student_name || 'form').replace(/\s+/g, '_') + '.pdf');
    });
  });

  document.querySelectorAll('[data-mark-admission]').forEach((button) => {
    button.addEventListener('click', async function() {
      const data = new FormData();
      data.append('action', 'mark_admission_seen');
      data.append('id', button.getAttribute('data-mark-admission'));
      const result = await fetch(window.appUrl('/api/update-data.php'), { method: 'POST', body: data }).then((r) => r.json());
      if (result.success) location.reload();
    });
  });

  document.querySelectorAll('[data-delete-admission]').forEach((button) => {
    button.addEventListener('click', async function() {
      if (!confirm('Delete this admission form?')) return;
      const data = new FormData();
      data.append('action', 'delete_admission');
      data.append('id', button.getAttribute('data-delete-admission'));
      const result = await fetch(window.appUrl('/api/update-data.php'), { method: 'POST', body: data }).then((r) => r.json());
      if (result.success) location.reload();
    });
  });
});
</script>
<script src="https://cdn.jsdelivr.net/npm/jspdf@2.5.1/dist/jspdf.umd.min.js"></script>
<script src="https://unpkg.com/lucide@latest"></script>
<script>window.lucide && window.lucide.createIcons();</script>
</body></html>
