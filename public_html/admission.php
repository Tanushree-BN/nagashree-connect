<?php
$pageTitle = 'Admission - Nagashree English School';
$currentPath = '/admission';
require_once __DIR__ . '/includes/header.php';
$heroTitle = 'Admission';
$heroBreadcrumb = 'Admission';
include __DIR__ . '/includes/hero-banner.php';
?>
<main>
  <section class="section-padding bg-background">
    <div class="container mx-auto max-w-4xl text-center">
      <i data-lucide="graduation-cap" class="w-12 h-12 text-gold mx-auto mb-4"></i>
      <h2 class="section-title mb-6">About Nagashree English School</h2>
      <p class="text-muted-foreground leading-relaxed"><?= h(SCHOOL_DESCRIPTION) ?></p>
    </div>
  </section>

  <section class="gradient-navy py-12">
    <div class="container mx-auto text-center">
      <span class="text-gold font-semibold text-sm uppercase tracking-widest">Now Enrolling</span>
      <h2 class="font-display text-3xl md:text-5xl font-bold text-primary-foreground mt-4 mb-4">Admissions Open for 2026-2027</h2>
      <p class="text-primary-foreground/70 text-lg max-w-xl mx-auto">Give your child the gift of quality education. Limited seats available — apply now!</p>
    </div>
  </section>

  <section class="section-padding bg-muted">
    <div class="container mx-auto max-w-3xl">
      <div class="text-center mb-10">
        <h2 class="section-title mb-2">Online Admission Form</h2>
        <p class="text-muted-foreground">Click Apply Now to open the admission form on a separate page.</p>
        <div class="mt-5 flex flex-col sm:flex-row items-center justify-center gap-3">
          <a href="/admission-form" class="inline-flex items-center gap-2 px-7 py-3 rounded-lg bg-gold text-secondary-foreground font-semibold hover:bg-gold-dark transition-colors">
            <i data-lucide="file-plus-2" class="w-4 h-4"></i> Apply Now
          </a>
          <a href="tel:+919901181966" class="inline-flex items-center gap-2 px-5 py-3 rounded-lg border border-border bg-card text-foreground text-sm font-medium hover:bg-muted transition-colors">
            <i data-lucide="phone-call" class="w-4 h-4 text-gold"></i> Call Now
          </a>
          <a href="https://wa.me/919901181966" target="_blank" rel="noopener" class="inline-flex items-center gap-2 px-5 py-3 rounded-lg border border-border bg-card text-foreground text-sm font-medium hover:bg-muted transition-colors">
            <i data-lucide="message-circle" class="w-4 h-4 text-gold"></i> Enquire Now (Chat on WhatsApp)
          </a>
        </div>
      </div>

      <div class="grid md:grid-cols-2 gap-4 mb-8">
        <div class="bg-card rounded-xl border border-border p-5">
          <h3 class="font-display text-xl font-semibold text-foreground mb-3">Admission Information</h3>
          <ul class="space-y-2 text-sm text-muted-foreground">
            <li class="flex items-start gap-2"><i data-lucide="calendar-days" class="w-4 h-4 text-gold mt-0.5"></i><span>Admissions are open for the current academic year.</span></li>
            <li class="flex items-start gap-2"><i data-lucide="file-check" class="w-4 h-4 text-gold mt-0.5"></i><span>Fill the form with accurate parent and student details.</span></li>
            <li class="flex items-start gap-2"><i data-lucide="phone-call" class="w-4 h-4 text-gold mt-0.5"></i><span>Our team will contact you after reviewing the submission.</span></li>
          </ul>
        </div>
        <div class="bg-card rounded-xl border border-border p-5">
          <h3 class="font-display text-xl font-semibold text-foreground mb-3">What We Offer</h3>
          <ul class="space-y-2 text-sm text-muted-foreground">
            <li class="flex items-start gap-2"><i data-lucide="graduation-cap" class="w-4 h-4 text-gold mt-0.5"></i><span>Experienced teachers and student-focused learning.</span></li>
            <li class="flex items-start gap-2"><i data-lucide="monitor-smartphone" class="w-4 h-4 text-gold mt-0.5"></i><span>Smart classrooms, labs, and digital learning support.</span></li>
            <li class="flex items-start gap-2"><i data-lucide="dumbbell" class="w-4 h-4 text-gold mt-0.5"></i><span>Sports, co-curricular activities, and holistic development.</span></li>
          </ul>
        </div>
      </div>
      <div class="bg-card rounded-xl border border-border p-6 sm:p-8 text-center">
        <i data-lucide="file-check-2" class="w-10 h-10 text-gold mx-auto mb-3"></i>
        <h3 class="font-display text-2xl font-semibold text-foreground mb-2">Ready to Apply?</h3>
        <p class="text-muted-foreground mb-5">Open the online form  and submit your admission details.</p>
        <a href="/admission-form" class="inline-flex items-center gap-2 px-7 py-3 rounded-lg bg-gold text-secondary-foreground font-semibold hover:bg-gold-dark transition-colors">
          Open Application Form <i data-lucide="arrow-right" class="w-4 h-4"></i>
        </a>
      </div>
    </div>
  </section>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>
