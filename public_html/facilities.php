<?php
$pageTitle = 'Facilities - Nagashree English School';
$currentPath = '/facilities';
require_once __DIR__ . '/includes/header.php';
$heroTitle = 'Our Facilities';
$heroBreadcrumb = 'Facilities';
include __DIR__ . '/includes/hero-banner.php';
$facilities = get_facilities_list();
?>
<main class="section-padding bg-background">
  <div class="container mx-auto">
    <div class="text-center mb-14">
      <h2 class="section-title">World-Class Infrastructure</h2>
      <p class="section-subtitle mx-auto">Our campus is designed to provide a modern, safe, and inspiring learning environment for every student.</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <?php foreach ($facilities as $facility): ?>
        <button data-facility-open="<?= h($facility['id']) ?>" class="bg-card rounded-xl overflow-hidden card-hover border border-border text-left focus:outline-none focus:ring-2 focus:ring-ring group flex flex-col">
          <div class="h-48 w-full overflow-hidden relative">
            <img src="<?= h($facility['image']) ?>" alt="<?= h($facility['title']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy" />
            <div class="absolute top-4 right-4 w-12 h-12 rounded-xl bg-card/90 backdrop-blur-sm text-gold flex items-center justify-center shadow-lg"><i data-lucide="<?= h($facility['icon']) ?>" class="w-8 h-8"></i></div>
          </div>
          <div class="p-6 flex-1 flex flex-col">
            <h3 class="font-display text-xl font-semibold text-foreground mb-2"><?= h($facility['title']) ?></h3>
            <p class="text-muted-foreground text-sm leading-relaxed flex-1"><?= h($facility['shortDesc']) ?></p>
            <span class="inline-block mt-4 text-gold text-sm font-medium">Learn more →</span>
          </div>
        </button>
      <?php endforeach; ?>
    </div>
  </div>
</main>

<?php foreach ($facilities as $facility): ?>
  <div id="facility-modal-<?= h($facility['id']) ?>" class="facility-modal-overlay fixed inset-0 z-[100] bg-navy-dark/60 backdrop-blur-sm hidden items-center justify-center p-4">
    <div class="bg-card rounded-2xl p-8 max-w-lg w-full shadow-xl relative" role="dialog" aria-label="<?= h($facility['title']) ?>">
      <button data-facility-close="<?= h($facility['id']) ?>" class="absolute top-4 right-4 text-muted-foreground hover:text-foreground z-10 bg-card rounded-full p-1 shadow-md" aria-label="Close"><i data-lucide="x" class="w-5 h-5"></i></button>
      <div class="h-48 -mt-8 -mx-8 mb-6 overflow-hidden rounded-t-2xl relative">
        <img src="<?= h($facility['image']) ?>" alt="<?= h($facility['title']) ?>" class="w-full h-full object-cover" />
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
        <div class="absolute bottom-4 left-6 flex items-center gap-3">
          <div class="w-10 h-10 rounded-lg bg-gold text-secondary-foreground flex items-center justify-center shadow-lg"><i data-lucide="<?= h($facility['icon']) ?>" class="w-6 h-6"></i></div>
          <h3 class="font-display text-2xl font-bold text-white"><?= h($facility['title']) ?></h3>
        </div>
      </div>
      <ul class="space-y-3">
        <?php foreach ($facility['details'] as $detail): ?>
          <li class="flex items-start gap-3 text-muted-foreground text-sm"><i data-lucide="check-circle" class="w-4 h-4 text-gold shrink-0 mt-0.5"></i><?= h($detail) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
<?php endforeach; ?>
<?php include __DIR__ . '/includes/footer.php'; ?>
