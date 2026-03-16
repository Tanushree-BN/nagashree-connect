<?php
$pageTitle = 'About Us - Nagashree English School';
$currentPath = '/about';
require_once __DIR__ . '/includes/header.php';
$heroTitle = 'About Us';
$heroBreadcrumb = 'About';
$stats = get_stats();
include __DIR__ . '/includes/hero-banner.php';
?>
<main>
  <section class="section-padding bg-background">
    <div class="container mx-auto">
      <div class="grid lg:grid-cols-2 gap-12 items-center">
        <div><img src="/assets/images/clg2.JPG" alt="Nagashree English School campus" class="rounded-2xl shadow-lg w-full object-cover aspect-[4/3]" loading="lazy" decoding="async" /></div>
        <div>
          <span class="text-gold font-semibold text-sm uppercase tracking-widest">What Makes Us Unique</span>
          <h2 class="section-title mt-3 mb-6">What is unique about Nagashree English School</h2>
          <p class="text-muted-foreground leading-relaxed mb-4">Nagashree English School is an awesome place of learning in many aspects. The beautiful, serene campus with state-of-the-art facilities, vast playgrounds, amazing Management and Staff, outstanding students and parents set it apart and it is indeed a wonderful place.</p>
          <p class="text-muted-foreground leading-relaxed">But what makes it unique is its belief system which has enabled it to evolve as the most child-friendly atmosphere.</p>
        </div>
      </div>
    </div>
  </section>

  <section class="section-padding bg-muted">
    <div class="container mx-auto">
      <div class="text-center mb-14"><h2 class="section-title">Our Vision & Mission</h2></div>
      <div class="grid md:grid-cols-2 gap-8">
        <div class="bg-card rounded-xl p-10 card-hover border border-border">
          <h3 class="font-display text-2xl font-bold text-foreground mb-4">Our Vision</h3>
          <p class="text-muted-foreground leading-relaxed">To be a center of academic excellence that nurtures every child's potential, instills strong moral values, and prepares globally competent citizens who contribute positively to society.</p>
        </div>
        <div class="bg-card rounded-xl p-10 card-hover border border-border">
          <h3 class="font-display text-2xl font-bold text-foreground mb-4">Our Mission</h3>
          <p class="text-muted-foreground leading-relaxed">To provide a holistic, inclusive, and student-centered learning experience through innovative teaching methods, a rich curriculum, and a supportive community that empowers each student to achieve their best.</p>
        </div>
      </div>
    </div>
  </section>

  <section class="gradient-navy section-padding">
    <div class="container mx-auto">
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

  <section class="section-padding bg-background text-center">
    <div class="container mx-auto max-w-2xl">
      <h2 class="section-title mb-4">Join Our School Family</h2>
      <p class="text-muted-foreground text-lg mb-8">Discover what makes Nagashree English School the right choice for your child's education.</p>
      <a href="/admission" class="inline-flex items-center gap-2 px-8 py-4 rounded-lg bg-gold text-secondary-foreground font-semibold hover:bg-gold-dark transition-colors">Apply for Admission <i data-lucide="arrow-right" class="w-4 h-4"></i></a>
    </div>
  </section>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>
