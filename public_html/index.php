<?php
$pageTitle = 'Nagashree English School';
$currentPath = '/';
require_once __DIR__ . '/includes/header.php';

$features = get_features();
$offerings = get_offerings();
$stats = get_stats();
$galleryImages = array_slice(get_gallery_images(), 0, 4);
?>
<main>
  <section class="relative min-h-[85vh] flex items-center overflow-hidden">
    <div class="absolute inset-0">
      <img src="/assets/images/clg1.JPG" alt="Nagashree English School campus" class="w-full h-full object-cover" loading="eager" fetchpriority="high" />
      <div class="absolute inset-0 bg-gradient-to-r from-navy-dark/90 via-navy-dark/70 to-navy-dark/40"></div>
    </div>
    <div class="container mx-auto px-4 relative z-10">
      <div class="max-w-2xl">
        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-gold/20 text-gold text-sm font-medium mb-6 border border-gold/30">
          <i data-lucide="graduation-cap" class="w-4 h-4"></i>
          Welcome To
        </span>
        <h1 class="font-display text-4xl md:text-6xl lg:text-7xl font-bold text-primary-foreground leading-tight mb-6">Nagashree <span class="text-gold">English</span> School</h1>
        <p class="text-primary-foreground/80 text-lg md:text-xl mb-8 leading-relaxed">At Nagashree English School, we nurture young minds with quality education, strong values, and holistic development in a safe, inspiring environment.</p>
        <div class="flex flex-wrap gap-4">
          <a href="/admission" class="inline-flex items-center gap-2 px-8 py-4 rounded-lg bg-gold text-secondary-foreground font-semibold hover:bg-gold-dark transition-colors">Admission Open <i data-lucide="arrow-right" class="w-4 h-4"></i></a>
          <a href="/about" class="inline-flex items-center gap-2 px-8 py-4 rounded-lg border-2 border-primary-foreground/30 text-primary-foreground font-semibold hover:bg-primary-foreground/10 transition-colors">Explore Our School</a>
        </div>
      </div>
    </div>
  </section>

  <section class="section-padding bg-background">
    <div class="container mx-auto">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <?php foreach ($features as $feature): ?>
          <div class="bg-card rounded-xl p-8 card-hover border border-border">
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
          <img src="/assets/images/RKP_9725.JPG" alt="What we offer at Nagashree English School" class="rounded-2xl shadow-lg w-full object-cover aspect-[4/3] object-top" loading="lazy" decoding="async" />
        </div>
        <div>
          <span class="text-gold font-semibold text-sm uppercase tracking-widest">What We Offer</span>
          <h2 class="section-title mt-3 mb-6">Quality Education & Holistic Growth</h2>
          <p class="text-muted-foreground leading-relaxed mb-6">On her way she met a copy. The copy warned the Little Blind Text, that where it came from it would have been rewritten a thousand times and everything that was left from its origin would be the word.</p>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <?php foreach ($offerings as $item): ?>
              <div class="flex items-start gap-3">
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

  <section class="gradient-navy section-padding">
    <div class="container mx-auto">
      <div class="grid lg:grid-cols-2 gap-12 items-center mb-16">
        <div id="school-video-container" class="relative aspect-video rounded-2xl overflow-hidden bg-navy-light">
          <button id="video-trigger" class="w-full h-full flex items-center justify-center group">
            <img src="/assets/images/bg2.JPG" alt="School video thumbnail" class="absolute inset-0 w-full h-full object-cover opacity-60" loading="lazy" decoding="async" />
            <div class="relative w-20 h-20 rounded-full bg-gold flex items-center justify-center group-hover:scale-110 transition-transform shadow-lg"><i data-lucide="play" class="w-8 h-8 text-secondary-foreground ml-1"></i></div>
            <span class="absolute bottom-6 left-6 text-primary-foreground font-display text-xl font-bold">Nagashree English School</span>
          </button>
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
          <div class="aspect-square rounded-xl overflow-hidden bg-muted">
            <img src="<?= h($img['src']) ?>" alt="<?= h($img['alt']) ?>" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500" loading="lazy" />
          </div>
        <?php endforeach; ?>
      </div>
      <a href="/gallery" class="inline-flex items-center gap-2 mt-8 text-gold font-semibold hover:text-gold-dark transition-colors">View Full Gallery <i data-lucide="arrow-right" class="w-4 h-4"></i></a>
    </div>
  </section>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>
