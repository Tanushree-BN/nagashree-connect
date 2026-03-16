<?php
$pageTitle = 'Our Faculty - Nagashree English School';
$currentPath = '/faculties';
require_once __DIR__ . '/includes/header.php';
$heroTitle = 'Our Faculty';
$heroBreadcrumb = 'Faculties';
include __DIR__ . '/includes/hero-banner.php';
$faculties = get_faculties();
?>
<main class="section-padding bg-background">
  <div class="container mx-auto">
    <div class="text-center mb-14">
      <h2 class="section-title">Meet Our Dedicated Team</h2>
      <p class="section-subtitle mx-auto">Our experienced educators are passionate about nurturing each student's potential and guiding them towards success.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
      <?php foreach ($faculties as $faculty): ?>
        <div class="bg-card rounded-xl p-6 card-hover border border-border text-center">
          <?php if (!empty($faculty['image'])): ?>
            <img src="<?= h($faculty['image']) ?>" alt="<?= h($faculty['name']) ?>" class="w-20 h-20 rounded-full object-cover mx-auto mb-4 shadow-sm border border-border" />
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
  </div>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>
