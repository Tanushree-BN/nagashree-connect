<?php
$pageTitle = 'Nagashree English School';
$currentPath = '/';
require_once __DIR__ . '/includes/header.php';

$features = get_features();
$offerings = array_values(array_filter(get_offerings(), static function ($item) {
  return strtolower((string) ($item['title'] ?? '')) !== 'certified teachers';
}));
$stats = get_stats();
$dailyUpdates = get_daily_updates();
$galleryImages = array_slice(get_gallery_images(), 0, 4);
?>
<main>
  <section class="relative min-h-[74vh] md:min-h-[85vh] flex items-center overflow-hidden hero-lively">
    <div class="absolute inset-0">
      <img src="/assets/images/clg1.JPG" alt="Nagashree English School campus" class="w-full h-full object-cover" width="1920" height="1080" loading="eager" fetchpriority="high" />
      <div class="absolute inset-0 bg-gradient-to-r from-navy-dark/90 via-navy-dark/70 to-navy-dark/40"></div>
    </div>
    <div class="hidden md:block absolute -top-20 -left-16 w-64 h-64 rounded-full bg-gold/15 blur-3xl hero-float-slow"></div>
    <div class="hidden md:block absolute -bottom-20 right-0 w-72 h-72 rounded-full bg-primary-foreground/10 blur-3xl hero-float-fast"></div>
    <div class="container mx-auto px-4 relative z-10">
      <div class="max-w-2xl">
        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-gold/20 text-gold text-sm font-medium mb-6 border border-gold/30 hero-pill-shine">
          <i data-lucide="graduation-cap" class="w-4 h-4"></i>
          Welcome To
        </span>
        <h1 class="font-display text-4xl md:text-6xl lg:text-7xl font-bold text-primary-foreground leading-tight mb-6">Nagashree <span class="text-gold">English</span> School</h1>
        <p class="text-primary-foreground/80 text-lg md:text-xl mb-8 leading-relaxed">At Nagashree English School, we nurture young minds with quality education, strong values, and holistic development in a safe, inspiring environment.</p>
        <div class="flex flex-wrap gap-3 md:gap-4">
          <a href="/admission" class="inline-flex w-full sm:w-auto justify-center items-center gap-2 px-6 md:px-8 py-3.5 md:py-4 rounded-lg bg-gold text-secondary-foreground font-semibold hover:bg-gold-dark transition-colors">Admission Open <i data-lucide="arrow-right" class="w-4 h-4"></i></a>
          <a href="/about" class="inline-flex w-full sm:w-auto justify-center items-center gap-2 px-6 md:px-8 py-3.5 md:py-4 rounded-lg border-2 border-primary-foreground/30 text-primary-foreground font-semibold hover:bg-primary-foreground/10 transition-colors">Explore Our School</a>
        </div>
        
      </div>
    </div>
  </section>

  <section class="section-padding bg-background">
    <div class="container mx-auto">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <?php foreach ($features as $feature): ?>
          <div class="bg-card rounded-xl p-8 card-hover border border-border lively-card">
            <div class="w-14 h-14 rounded-xl bg-gold/10 text-gold flex items-center justify-center mb-5"><i data-lucide="<?= h($feature['icon']) ?>" class="w-8 h-8"></i></div>
            <h3 class="font-display text-xl font-semibold text-foreground mb-3"><?= h($feature['title']) ?></h3>
            <p class="text-muted-foreground text-sm leading-relaxed"><?= h($feature['description']) ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <section class="section-padding bg-muted">
    <div class="container mx-auto">
      <div class="grid lg:grid-cols-2 gap-12 items-center">
        <div>
          <img src="/assets/images/RKP_9725.JPG" alt="What we offer at Nagashree English School" class="rounded-2xl shadow-lg w-full object-cover aspect-[4/3] object-top" width="600" height="450" loading="lazy" decoding="async" />
        </div>
        <div>
          <span class="text-gold font-semibold text-sm uppercase tracking-widest">What We Offer</span>
          <h2 class="section-title mt-3 mb-6">Quality Education & Holistic Growth</h2>
          <p class="text-muted-foreground leading-relaxed mb-6">Quality education supports students' academic and social development. It provides a positive learning environment where students gain knowledge, build important skills, and grow with confidence. Holistic growth helps them develop creativity, critical thinking, discipline, and strong values for the future.</p>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <?php foreach ($offerings as $item): ?>
              <div class="flex items-start gap-3 offering-row">
                <div class="w-10 h-10 rounded-lg bg-gold/10 text-gold flex items-center justify-center shrink-0 mt-0.5"><i data-lucide="<?= h($item['icon']) ?>" class="w-6 h-6"></i></div>
                <div>
                  <h4 class="font-semibold text-foreground text-sm"><?= h($item['title']) ?></h4>
                  <p class="text-muted-foreground text-xs leading-relaxed mt-1"><?= h($item['description']) ?></p>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="section-padding bg-background">
    <div class="container mx-auto">
      <div class="text-center mb-12">
        <span class="text-gold font-semibold text-sm uppercase tracking-widest">Daily Updates</span>
        <h2 class="section-title mt-3">What’s Happening at School</h2>
        <p class="section-subtitle mx-auto">Stay connected with regular activities and student milestones from our campus.</p>
      </div>
      <div id="daily-updates-list" class="grid md:grid-cols-2 gap-6">
        <?php foreach ($dailyUpdates as $index => $item): ?>
          <?php $updateIcon = strtolower((string) ($item['type'] ?? 'activity')) === 'highlight' ? 'star' : 'calendar-days'; ?>
          <div class="bg-card rounded-xl border border-border p-6 card-hover<?= $index >= 4 ? ' hidden daily-update-older' : '' ?>">
            <div class="w-12 h-12 rounded-lg bg-gold/10 text-gold flex items-center justify-center mb-4"><i data-lucide="<?= h($updateIcon) ?>" class="w-6 h-6"></i></div>
            <h3 class="font-display text-xl font-semibold text-foreground mb-2"><?= h($item['title'] ?? '') ?></h3>
            <p class="text-muted-foreground text-sm leading-relaxed"><?= h($item['description'] ?? '') ?></p>
          </div>
        <?php endforeach; ?>
      </div>
      <?php if (count($dailyUpdates) > 4): ?>
        <div class="mt-8 flex justify-center">
          <button id="daily-updates-toggle" type="button" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-border text-foreground hover:bg-muted transition-colors" aria-expanded="false" aria-controls="daily-updates-list">
            <span id="daily-updates-toggle-text">Show Older Updates</span>
            <i id="daily-updates-toggle-icon" data-lucide="chevron-down" class="w-4 h-4 transition-transform"></i>
          </button>
        </div>
      <?php endif; ?>
    </div>
  </section>

  <section class="gradient-navy section-padding">
    <div class="container mx-auto">
      <div class="grid lg:grid-cols-2 gap-12 items-center mb-16">
        <div class="space-y-4">
          <div id="school-video-container" class="relative aspect-video rounded-2xl overflow-hidden bg-navy-light">
            <button id="video-trigger" class="w-full h-full flex items-center justify-center group">
              <img src="/assets/images/bg2.JPG" alt="School video thumbnail" class="absolute inset-0 w-full h-full object-cover opacity-60" width="800" height="450" loading="lazy" decoding="async" />
              <div class="relative w-20 h-20 rounded-full bg-gold flex items-center justify-center group-hover:scale-110 transition-transform shadow-lg"><i data-lucide="play" class="w-8 h-8 text-secondary-foreground ml-1"></i></div>
              <span class="absolute bottom-6 left-6 text-primary-foreground font-display text-xl font-bold">Nagashree English School</span>
            </button>
          </div>
          <!-- <div class="rounded-xl border border-primary-foreground/15 bg-primary-foreground/5 p-4 flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-gold/15 text-gold flex items-center justify-center shrink-0">
              <i data-lucide="graduation-cap" class="w-5 h-5"></i>
            </div>
           
          </div> -->
        </div>
        <div>
          <span class="text-gold font-semibold text-sm uppercase tracking-widest">About Our School</span>
          <h2 class="font-display text-3xl md:text-4xl font-bold text-primary-foreground mt-3 mb-6">Nagashree English School</h2>
          <p class="text-primary-foreground/80 leading-relaxed text-sm"><?= h(SCHOOL_DESCRIPTION) ?></p>
        </div>
      </div>
      <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
         <?php foreach ($stats as $stat): ?>
          <div class="text-center">
            <div class="stat-value text-4xl md:text-5xl font-bold text-gold" data-stat="<?= h((string) $stat['value']) ?>" data-suffix="<?= h($stat['suffix']) ?>">0<?= h($stat['suffix']) ?></div>
            <p class="text-primary-foreground/70 mt-2 text-sm font-medium"><?= h($stat['label']) ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <section class="section-padding bg-background">
    <div class="container mx-auto text-center">
      <h2 class="section-title mb-4">Campus Life</h2>
      <p class="section-subtitle mx-auto mb-10">A glimpse into the vibrant life at Nagashree English School.</p>
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <?php foreach ($galleryImages as $img): ?>
          <div class="aspect-square rounded-xl overflow-hidden bg-muted campus-card-lively relative">
            <img src="<?= h($img['src']) ?>" alt="<?= h($img['alt']) ?>" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500" width="300" height="300" loading="lazy" decoding="async" />
            <div class="absolute inset-0 bg-gradient-to-t from-navy-dark/35 to-transparent opacity-0 hover:opacity-100 transition-opacity"></div>
          </div>
        <?php endforeach; ?>
      </div>
      <a href="/gallery" class="inline-flex w-full sm:w-auto justify-center items-center gap-2 mt-8 text-gold font-semibold hover:text-gold-dark transition-colors">View Full Gallery <i data-lucide="arrow-right" class="w-4 h-4"></i></a>
    </div>
  </section>

  <section class="px-4 pb-16 md:pb-24 bg-background">
    <div class="container mx-auto">
      <div class="rounded-2xl gradient-navy p-8 md:p-12 flex flex-col md:flex-row md:items-center md:justify-between gap-6 cta-lively-wrap">
        <div>
          <p class="text-gold text-sm uppercase tracking-wider font-semibold">Admissions 2026-27</p>
          <h3 class="font-display text-2xl md:text-4xl font-bold text-primary-foreground mt-2">Give your child the right start at Nagashree.</h3>
          <p class="text-primary-foreground/75 mt-3 text-sm md:text-base">Limited seats available. Begin your admission process today.</p>
        </div>
        <div class="shrink-0 w-full md:w-auto">
          <a href="/admission" class="inline-flex w-full md:w-auto justify-center items-center gap-2 px-7 py-3 rounded-lg bg-gold text-secondary-foreground font-semibold hover:bg-gold-dark transition-colors">Start Admission <i data-lucide="arrow-right" class="w-4 h-4"></i></a>
        </div>
      </div>
    </div>
  </section>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>
