<?php
$pageTitle = 'Gallery - Nagashree English School';
$currentPath = '/gallery';
require_once __DIR__ . '/includes/header.php';
$heroTitle = 'Gallery';
$heroBreadcrumb = 'Gallery';
include __DIR__ . '/includes/hero-banner.php';

// Pagination
$page = max(1, (int) ($_GET['page'] ?? 1));
$galleryData = get_gallery_images_paginated($page, 15);
$images = $galleryData['images'];
?>
<main class="section-padding bg-background">
  <div class="container mx-auto">
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
      <?php foreach ($images as $img): ?>
        <button data-lightbox-src="<?= h($img['src']) ?>" data-lightbox-alt="<?= h($img['alt']) ?>" data-lightbox-title="<?= h($img['title']) ?>" class="aspect-square rounded-xl overflow-hidden bg-muted group relative focus:outline-none focus:ring-2 focus:ring-ring">
          <img src="<?= h($img['src']) ?>" alt="<?= h($img['alt']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" width="300" height="300" loading="lazy" decoding="async" />
          <div class="absolute inset-0 bg-navy-dark/0 group-hover:bg-navy-dark/50 transition-colors flex items-end p-4">
            <span class="text-primary-foreground font-medium text-sm opacity-0 group-hover:opacity-100 transition-opacity"><?= h($img['title']) ?></span>
          </div>
        </button>
      <?php endforeach; ?>
    </div>

    <?php if (count($images) === 0): ?>
      <div class="text-center py-12">
        <p class="text-muted-foreground mb-4">No images found.</p>
        <a href="?page=1" class="inline-flex items-center gap-2 text-gold font-semibold hover:text-gold-dark transition-colors">View All Gallery <i data-lucide="arrow-right" class="w-4 h-4"></i></a>
      </div>
    <?php endif; ?>

    <!-- Pagination -->
    <?php if ($galleryData['pages'] > 1): ?>
      <div class="mt-12 flex justify-center items-center gap-2">
        <?php if ($galleryData['page'] > 1): ?>
          <a href="?page=1" class="px-3 py-2 rounded-lg border border-border text-sm font-medium hover:bg-muted transition-colors">First</a>
          <a href="?page=<?= $galleryData['page'] - 1 ?>" class="px-3 py-2 rounded-lg border border-border text-sm font-medium hover:bg-muted transition-colors">Previous</a>
        <?php endif; ?>

        <div class="flex gap-1">
          <?php for ($i = max(1, $galleryData['page'] - 2); $i <= min($galleryData['pages'], $galleryData['page'] + 2); $i++): ?>
            <a href="?page=<?= $i ?>" class="w-9 h-9 rounded-lg text-sm font-medium transition-colors flex items-center justify-center <?= $i === $galleryData['page'] ? 'bg-gold text-secondary-foreground' : 'border border-border hover:bg-muted' ?>">
              <?= $i ?>
            </a>
          <?php endfor; ?>
        </div>

        <?php if ($galleryData['page'] < $galleryData['pages']): ?>
          <a href="?page=<?= $galleryData['page'] + 1 ?>" class="px-3 py-2 rounded-lg border border-border text-sm font-medium hover:bg-muted transition-colors">Next</a>
          <a href="?page=<?= $galleryData['pages'] ?>" class="px-3 py-2 rounded-lg border border-border text-sm font-medium hover:bg-muted transition-colors">Last</a>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  </div>
</main>

<div id="gallery-lightbox" class="fixed inset-0 z-[100] bg-navy-dark/95 hidden items-center justify-center p-4">
  <button id="gallery-lightbox-close" class="absolute top-6 right-6 text-primary-foreground/70 hover:text-primary-foreground" aria-label="Close lightbox"><i data-lucide="x" class="w-8 h-8"></i></button>
  <img id="gallery-lightbox-image" src="" alt="" class="max-w-full max-h-[85vh] rounded-xl object-contain" />
  <p id="gallery-lightbox-title" class="absolute bottom-8 text-primary-foreground font-display text-lg"></p>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
