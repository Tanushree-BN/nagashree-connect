<?php $contactInfo = CONTACT_INFO; ?>
<footer class="gradient-navy text-primary-foreground">
  <div class="container mx-auto px-4 py-16">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
      <div>
        <h3 class="font-display text-xl font-bold mb-4 text-gold"><?= h($contactInfo['schoolName']) ?></h3>
        <p class="text-primary-foreground/70 text-sm leading-relaxed">
          Empowering young minds with quality education, strong values, and holistic development. Your child's bright future starts here.
        </p>
        <div class="flex gap-3 mt-6">
          <a href="<?= h($contactInfo['socialLinks']['facebook']) ?>" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-full bg-primary-foreground/10 flex items-center justify-center hover:bg-gold hover:text-secondary-foreground transition-colors" aria-label="Facebook"><i data-lucide="facebook" class="w-4 h-4"></i></a>
          <a href="<?= h($contactInfo['socialLinks']['instagram']) ?>" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-full bg-primary-foreground/10 flex items-center justify-center hover:bg-gold hover:text-secondary-foreground transition-colors" aria-label="Instagram"><i data-lucide="instagram" class="w-4 h-4"></i></a>
          <a href="<?= h($contactInfo['socialLinks']['youtube']) ?>" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-full bg-primary-foreground/10 flex items-center justify-center hover:bg-gold hover:text-secondary-foreground transition-colors" aria-label="YouTube"><i data-lucide="youtube" class="w-4 h-4"></i></a>
        </div>
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
          <li><a href="<?= h($contactInfo['socialLinks']['youtube']) ?>" target="_blank" rel="noopener noreferrer" class="text-primary-foreground/70 hover:text-gold transition-colors">YouTube</a></li>
          <li><a href="<?= h($contactInfo['socialLinks']['facebook']) ?>" target="_blank" rel="noopener noreferrer" class="text-primary-foreground/70 hover:text-gold transition-colors">Facebook</a></li>
          <li><a href="<?= h($contactInfo['socialLinks']['instagram']) ?>" target="_blank" rel="noopener noreferrer" class="text-primary-foreground/70 hover:text-gold transition-colors">Instagram</a></li>
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
<script src="/assets/js/main.js"></script>
</body>
</html>
