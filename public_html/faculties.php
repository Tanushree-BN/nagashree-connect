<?php
$pageTitle = 'Our Faculty - Nagashree English School';
$currentPath = '/faculties';
require_once __DIR__ . '/includes/header.php';
$heroTitle = 'Our Faculty';
$heroBreadcrumb = 'Faculties';
include __DIR__ . '/includes/hero-banner.php';

// Pagination
$page = max(1, (int) ($_GET['page'] ?? 1));
$facultyData = get_faculties_paginated($page, 12);
?>
<main class="section-padding bg-background">
  <div class="container mx-auto">
    <div class="text-center mb-14">
      <h2 class="section-title">Meet Our Dedicated Team</h2>
      <p class="section-subtitle mx-auto">Our experienced educators are passionate about nurturing each student's potential and guiding them towards success.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
      <?php foreach ($facultyData['faculties'] as $faculty): ?>
        <div class="bg-card rounded-xl p-6 card-hover border border-border text-center">
          <?php if (!empty($faculty['image'])): ?>
            <img src="<?= h($faculty['image']) ?>" alt="<?= h($faculty['name']) ?>" class="w-20 h-20 rounded-full object-cover mx-auto mb-4 shadow-sm border border-border" width="80" height="80" loading="lazy" decoding="async" />
          <?php else: ?>
            <div class="w-20 h-20 rounded-full bg-muted flex items-center justify-center mx-auto mb-4"><i data-lucide="user" class="w-10 h-10 text-muted-foreground"></i></div>
          <?php endif; ?>
          <h3 class="font-display text-lg font-semibold text-foreground"><?= h($faculty['name']) ?></h3>
          <p class="text-gold font-medium text-sm mt-1"><?= h($faculty['role']) ?></p>
          <p class="text-muted-foreground text-sm mt-2"><?= h($faculty['subject']) ?></p>
          <p class="text-muted-foreground/60 text-xs mt-1"><?= h($faculty['experience']) ?> experience</p>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Pagination -->
    <?php if ($facultyData['pages'] > 1): ?>
      <div class="mt-12 flex justify-center items-center gap-2">
        <?php if ($facultyData['page'] > 1): ?>
          <a href="?page=1" class="px-3 py-2 rounded-lg border border-border text-sm font-medium hover:bg-muted transition-colors">First</a>
          <a href="?page=<?= $facultyData['page'] - 1 ?>" class="px-3 py-2 rounded-lg border border-border text-sm font-medium hover:bg-muted transition-colors">Previous</a>
        <?php endif; ?>

        <div class="flex gap-1">
          <?php for ($i = max(1, $facultyData['page'] - 2); $i <= min($facultyData['pages'], $facultyData['page'] + 2); $i++): ?>
            <a href="?page=<?= $i ?>" class="w-9 h-9 rounded-lg text-sm font-medium transition-colors flex items-center justify-center <?= $i === $facultyData['page'] ? 'bg-gold text-secondary-foreground' : 'border border-border hover:bg-muted' ?>">
              <?= $i ?>
            </a>
          <?php endfor; ?>
        </div>

        <?php if ($facultyData['page'] < $facultyData['pages']): ?>
          <a href="?page=<?= $facultyData['page'] + 1 ?>" class="px-3 py-2 rounded-lg border border-border text-sm font-medium hover:bg-muted transition-colors">Next</a>
          <a href="?page=<?= $facultyData['pages'] ?>" class="px-3 py-2 rounded-lg border border-border text-sm font-medium hover:bg-muted transition-colors">Last</a>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  </div>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>
