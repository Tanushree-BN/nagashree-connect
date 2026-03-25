<?php
$pageTitle = 'Gallery - Nagashree English School';
$currentPath = '/gallery';
require_once __DIR__ . '/includes/header.php';
$heroTitle = 'Gallery';
$heroBreadcrumb = 'Gallery';
include __DIR__ . '/includes/hero-banner.php';
$galleryCategories = get_gallery_categories();
$images = get_gallery_images();
?>
<main class="section-padding bg-background">
  <div class="container mx-auto">
    <div class="flex flex-wrap justify-center gap-3 mb-12">
      <?php foreach ($galleryCategories as $index => $cat): ?>
        <button data-gallery-filter="<?= h($cat) ?>" class="px-5 py-2.5 rounded-lg text-sm font-medium capitalize transition-colors <?= $index === 0 ? 'bg-secondary text-secondary-foreground' : 'bg-muted text-muted-foreground hover:bg-border' ?>"><?= h($cat) ?></button>
      <?php endforeach; ?>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
      <?php foreach ($images as $img): ?>
        <button data-gallery-item="<?= h($img['category']) ?>" data-lightbox-src="<?= h($img['src']) ?>" data-lightbox-alt="<?= h($img['alt']) ?>" data-lightbox-title="<?= h($img['title']) ?>" class="aspect-square rounded-xl overflow-hidden bg-muted group relative focus:outline-none focus:ring-2 focus:ring-ring">
          <img src="<?= h($img['src']) ?>" alt="<?= h($img['alt']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy" />
          <div class="absolute inset-0 bg-navy-dark/0 group-hover:bg-navy-dark/50 transition-colors flex items-end p-4">
            <span class="text-primary-foreground font-medium text-sm opacity-0 group-hover:opacity-100 transition-opacity"><?= h($img['title']) ?></span>
          </div>
        </button>
      <?php endforeach; ?>
    </div>
  </div>
</main>

<div id="gallery-lightbox" class="fixed inset-0 z-[100] bg-navy-dark/95 hidden items-center justify-center p-4">
  <button id="gallery-lightbox-close" class="absolute top-6 right-6 text-primary-foreground/70 hover:text-primary-foreground" aria-label="Close lightbox"><i data-lucide="x" class="w-8 h-8"></i></button>
  <img id="gallery-lightbox-image" src="" alt="" class="max-w-full max-h-[85vh] rounded-xl object-contain" />
  <p id="gallery-lightbox-title" class="absolute bottom-8 text-primary-foreground font-display text-lg"></p>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
