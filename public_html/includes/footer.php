<?php
$contactInfo = CONTACT_INFO;
$admissionEnquiryPhoneDisplay = '+91-9901181966';
$admissionEnquiryPhoneDial = preg_replace('/\D+/', '', $admissionEnquiryPhoneDisplay);
$admissionWhatsappNumber = $admissionEnquiryPhoneDial;
$admissionWhatsappText = rawurlencode('Hi, I want admission details for my child at Nagashree English School. Please guide me.');
?>
<div id="admission-popup" class="fixed inset-0 z-[120] hidden items-center justify-center p-3 md:p-4 bg-navy-dark/75 admission-popup-overlay">
  <div class="relative w-full max-w-2xl rounded-2xl bg-card border border-border shadow-xl overflow-hidden admission-popup-card">
    <button id="admission-popup-close" type="button" class="absolute top-3 right-3 z-20 w-9 h-9 rounded-full bg-background/85 text-muted-foreground hover:text-foreground transition-colors flex items-center justify-center" aria-label="Close admission popup">
      <i data-lucide="x" class="w-5 h-5"></i>
    </button>
    <div class="p-5 md:p-8 admission-popup-content">
        <span class="inline-flex w-fit items-center gap-2 px-3 py-1 rounded-full bg-gold/15 text-gold text-xs font-semibold uppercase tracking-wide border border-gold/30">Admission Open</span>
        <h3 class="font-display text-2xl md:text-3xl font-bold text-foreground leading-tight">Admissions Are Open for 2026-27</h3>
        <p class="text-muted-foreground mt-3 text-sm md:text-base leading-relaxed">Give your child the best start with quality education, strong values, and personal attention at Nagashree English School.</p>

        <ul class="mt-4 space-y-2 text-sm text-foreground/85">
          <li class="flex items-start gap-2"><i data-lucide="check-circle-2" class="w-4 h-4 text-gold mt-0.5 shrink-0"></i>Holistic growth with academics, sports, and values</li>
          <li class="flex items-start gap-2"><i data-lucide="check-circle-2" class="w-4 h-4 text-gold mt-0.5 shrink-0"></i>Personal attention from qualified educators</li>
          <li class="flex items-start gap-2"><i data-lucide="check-circle-2" class="w-4 h-4 text-gold mt-0.5 shrink-0"></i>Simple and quick admission process</li>
        </ul>

        <div class="mt-6 flex flex-wrap gap-3">
          <a href="<?= h(app_url('/admission')) ?>" class="inline-flex w-full sm:w-auto justify-center items-center gap-2 px-6 py-3 rounded-lg bg-gold text-secondary-foreground font-semibold hover:bg-gold-dark transition-colors">Apply for Admission <i data-lucide="arrow-right" class="w-4 h-4"></i></a>
          <a href="tel:<?= h($admissionEnquiryPhoneDial) ?>" class="inline-flex w-full sm:w-auto justify-center items-center gap-2 px-5 py-3 rounded-lg border border-border text-foreground font-medium hover:bg-muted transition-colors"><i data-lucide="phone-call" class="w-4 h-4"></i>Call Now for Admission</a>
          <a href="https://wa.me/<?= h($admissionWhatsappNumber) ?>?text=<?= h($admissionWhatsappText) ?>" target="_blank" rel="noopener noreferrer" class="inline-flex w-full sm:w-auto justify-center items-center gap-2 px-5 py-3 rounded-lg border border-border text-foreground font-medium hover:bg-muted transition-colors"><i data-lucide="message-circle" class="w-4 h-4"></i>Chat With Us for Admission</a>
        </div>
        <p class="text-xs text-muted-foreground mt-3">Need help? Call us at <?= h($admissionEnquiryPhoneDisplay) ?></p>
    </div>
  </div>
</div>
<footer class="gradient-navy text-primary-foreground">
  <div class="container mx-auto px-4 py-16">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
      <div>
        <h3 class="font-display text-xl font-bold mb-4 text-gold"><?= h($contactInfo['schoolName']) ?></h3>
        <p class="text-primary-foreground/70 text-sm leading-relaxed">
          Empowering young minds with quality education, strong values, and holistic development. Your child's bright future starts here.
        </p>
      </div>

      <div>
        <h4 class="font-display text-lg font-semibold mb-4">Quick Links</h4>
        <ul class="space-y-2.5">
          <li><a href="/" class="text-primary-foreground/70 hover:text-gold transition-colors text-sm">Home</a></li>
          <li><a href="/about" class="text-primary-foreground/70 hover:text-gold transition-colors text-sm">About Us</a></li>
          <li><a href="/admission" class="text-primary-foreground/70 hover:text-gold transition-colors text-sm">Admission</a></li>
          <li><a href="/gallery" class="text-primary-foreground/70 hover:text-gold transition-colors text-sm">Gallery</a></li>
          <li><a href="/faculties" class="text-primary-foreground/70 hover:text-gold transition-colors text-sm">Our Faculty</a></li>
          <li><a href="/facilities" class="text-primary-foreground/70 hover:text-gold transition-colors text-sm">Facilities</a></li>
          <li><a href="/contact" class="text-primary-foreground/70 hover:text-gold transition-colors text-sm">Contact</a></li>
        </ul>
      </div>

      <div>
        <h4 class="font-display text-lg font-semibold mb-4">Contact Us</h4>
        <div class="space-y-4 text-sm">
          <div class="flex gap-3">
            <i data-lucide="map-pin" class="w-4 h-4 text-gold shrink-0 mt-1"></i>
            <span class="text-primary-foreground/70"><?= h($contactInfo['address']) ?></span>
          </div>
          <div class="flex gap-3">
            <i data-lucide="phone" class="w-4 h-4 text-gold shrink-0 mt-0.5"></i>
            <div class="text-primary-foreground/70">
              <p>Office: <a href="tel:<?= h($contactInfo['phones']['office']) ?>" class="hover:text-gold transition-colors"><?= h($contactInfo['phones']['office']) ?></a></p>
              <p>Principal: <a href="tel:<?= h($contactInfo['phones']['principal']) ?>" class="hover:text-gold transition-colors"><?= h($contactInfo['phones']['principal']) ?></a></p>
              <p>Admin: <a href="tel:<?= h($contactInfo['phones']['admin']) ?>" class="hover:text-gold transition-colors"><?= h($contactInfo['phones']['admin']) ?></a></p>
            </div>
          </div>
          <div class="flex gap-3">
            <i data-lucide="mail" class="w-4 h-4 text-gold shrink-0 mt-0.5"></i>
            <a href="mailto:<?= h($contactInfo['email']) ?>" class="text-primary-foreground/70 hover:text-gold transition-colors"><?= h($contactInfo['email']) ?></a>
          </div>
        </div>
      </div>

      <div>
        <h4 class="font-display text-lg font-semibold mb-4">Connect With Us</h4>
        <ul class="space-y-2.5 text-sm">
          <li><a href="<?= h($contactInfo['socialLinks']['youtube']) ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 text-primary-foreground/70 hover:text-gold transition-colors">YouTube <i data-lucide="youtube" class="w-4 h-4"></i></a></li>
          <li><a href="<?= h($contactInfo['socialLinks']['facebook']) ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 text-primary-foreground/70 hover:text-gold transition-colors">Facebook <i data-lucide="facebook" class="w-4 h-4"></i></a></li>
          <li><a href="<?= h($contactInfo['socialLinks']['instagram']) ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 text-primary-foreground/70 hover:text-gold transition-colors">Instagram <i data-lucide="instagram" class="w-4 h-4"></i></a></li>
        </ul>
      </div>
    </div>

    <div class="border-t border-primary-foreground/10 mt-12 pt-8 text-center text-primary-foreground/50 text-sm">
      <p>© <?= date('Y') ?> <?= h($contactInfo['schoolName']) ?>. All rights reserved.</p>
      <p class="mt-2">Designed by <a href="https://mitrasoftwares.in/" target="_blank" rel="noopener noreferrer" class="text-gold hover:text-gold-light transition-colors">Mitra Softwares</a></p>
    </div>
  </div>
</footer>
<script src="https://unpkg.com/lucide@latest"></script>
<script src="<?= h(app_url('/assets/js/main.js?v=' . (is_file(__DIR__ . '/../assets/js/main.js') ? (string) filemtime(__DIR__ . '/../assets/js/main.js') : (string) time()))) ?>"></script>
</body>
</html>
