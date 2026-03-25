<?php
$heroTitle = $heroTitle ?? '';
$heroBreadcrumb = $heroBreadcrumb ?? '';
?>
<section class="relative py-16 md:py-20 px-4 overflow-hidden">
  <div class="absolute inset-0">
    <img src="/assets/images/bg1.JPG" alt="Background" class="w-full h-full object-cover" width="1920" height="1080" loading="eager" fetchpriority="high" />
    <div class="absolute inset-0 bg-navy-dark/80 backdrop-blur-[2px]"></div>
  </div>
  <div class="container mx-auto text-center relative z-10">
    <h1 class="font-display text-3xl md:text-5xl font-bold text-primary-foreground mb-4"><?= h($heroTitle) ?></h1>
    <div class="flex items-center justify-center gap-2 text-primary-foreground/60 text-sm">
      <a href="/" class="hover:text-gold transition-colors">Home</a>
      <span>/</span>
      <span class="text-gold"><?= h($heroBreadcrumb) ?></span>
    </div>
  </div>
</section>
