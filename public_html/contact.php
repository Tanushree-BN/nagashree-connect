<?php
$pageTitle = 'Contact - Nagashree English School';
$currentPath = '/contact';
require_once __DIR__ . '/includes/header.php';
$contactInfo = CONTACT_INFO;
?>
<div class="relative">
  <div class="absolute inset-0 h-[40vh] md:h-[50vh] min-h-[300px]">
    <img src="/assets/images/bg3.JPG" alt="Nagashree Contact Background" class="w-full h-full object-cover" width="1920" height="1080" loading="eager" fetchpriority="high" />
    <div class="absolute inset-0 bg-navy-dark/80 backdrop-blur-[2px]"></div>
  </div>
  <div class="relative z-10">
    <?php $heroTitle = 'Contact Us'; $heroBreadcrumb = 'Contact'; include __DIR__ . '/includes/hero-banner.php'; ?>
  </div>
</div>

<main>
  <section class="section-padding bg-background">
    <div class="container mx-auto">
      <div class="grid md:grid-cols-3 gap-6 mb-16">
        <div class="bg-card rounded-xl p-8 card-hover border border-border text-center">
          <div class="w-14 h-14 rounded-full bg-gold/10 text-gold flex items-center justify-center mx-auto mb-4"><i data-lucide="map-pin" class="w-6 h-6"></i></div>
          <h3 class="font-display text-lg font-semibold text-foreground mb-2">Visit Us</h3>
          <p class="text-muted-foreground text-sm whitespace-pre-line"><?= h($contactInfo['address']) ?></p>
        </div>
        <div class="bg-card rounded-xl p-8 card-hover border border-border text-center">
          <div class="w-14 h-14 rounded-full bg-gold/10 text-gold flex items-center justify-center mx-auto mb-4"><i data-lucide="phone" class="w-6 h-6"></i></div>
          <h3 class="font-display text-lg font-semibold text-foreground mb-2">Call Us</h3>
          <p class="text-muted-foreground text-sm whitespace-pre-line">Office: <?= h($contactInfo['phones']['office']) ?>
Principal: <?= h($contactInfo['phones']['principal']) ?>
Admin: <?= h($contactInfo['phones']['admin']) ?></p>
        </div>
        <div class="bg-card rounded-xl p-8 card-hover border border-border text-center">
          <div class="w-14 h-14 rounded-full bg-gold/10 text-gold flex items-center justify-center mx-auto mb-4"><i data-lucide="mail" class="w-6 h-6"></i></div>
          <h3 class="font-display text-lg font-semibold text-foreground mb-2">Email Us</h3>
          <p class="text-muted-foreground text-sm whitespace-pre-line"><?= h($contactInfo['email']) ?></p>
        </div>
      </div>

      <div class="grid lg:grid-cols-2 gap-10">
        <div>
          <h2 class="section-title mb-2">Send Us a Message</h2>
          <p class="text-muted-foreground mb-8">Fill in the form below and we'll get back to you shortly.</p>
          <div id="contact-success" class="hidden items-center gap-3 bg-gold/10 text-gold rounded-lg p-4 mb-6"><i data-lucide="check-circle" class="w-5 h-5"></i><span class="font-medium text-sm">Thank you! Your message has been sent successfully.</span></div>
          <div id="contact-error" class="hidden items-center gap-3 bg-destructive/10 text-destructive rounded-lg p-4 mb-6"><i data-lucide="alert-circle" class="w-5 h-5"></i><span class="font-medium text-sm">Unable to send your message right now. Please try again.</span></div>

          <form id="contact-form" class="space-y-5">
            <div class="grid sm:grid-cols-2 gap-5">
              <div>
                <label for="name" class="block text-sm font-medium text-foreground mb-1.5">Full Name *</label>
                <input id="name" name="name" type="text" required maxlength="100" class="w-full px-4 py-3 rounded-lg border border-input bg-background text-foreground text-sm focus:outline-none focus:ring-2 focus:ring-ring" placeholder="Your full name" />
              </div>
              <div>
                <label for="email" class="block text-sm font-medium text-foreground mb-1.5">Email *</label>
                <input id="email" name="email" type="email" required maxlength="255" class="w-full px-4 py-3 rounded-lg border border-input bg-background text-foreground text-sm focus:outline-none focus:ring-2 focus:ring-ring" placeholder="your@email.com" />
              </div>
            </div>
            <div class="grid sm:grid-cols-2 gap-5">
              <div>
                <label for="phone" class="block text-sm font-medium text-foreground mb-1.5">Phone</label>
                <input id="phone" name="phone" type="tel" maxlength="15" class="w-full px-4 py-3 rounded-lg border border-input bg-background text-foreground text-sm focus:outline-none focus:ring-2 focus:ring-ring" placeholder="+91-XXXXXXXXXX" />
              </div>
              <div>
                <label for="subject" class="block text-sm font-medium text-foreground mb-1.5">Subject</label>
                <select id="subject" name="subject" class="w-full px-4 py-3 rounded-lg border border-input bg-background text-foreground text-sm focus:outline-none focus:ring-2 focus:ring-ring">
                  <option>General Enquiry</option>
                  <option>Admissions</option>
                  <option>Transport</option>
                  <option>Fee Structure</option>
                  <option>Other</option>
                </select>
              </div>
            </div>
            <div>
              <label for="message" class="block text-sm font-medium text-foreground mb-1.5">Message *</label>
              <textarea id="message" name="message" required maxlength="1000" rows="5" class="w-full px-4 py-3 rounded-lg border border-input bg-background text-foreground text-sm focus:outline-none focus:ring-2 focus:ring-ring resize-none" placeholder="How can we help you?"></textarea>
            </div>
            <button type="submit" class="inline-flex items-center gap-2 px-8 py-3.5 rounded-lg bg-gold text-secondary-foreground font-semibold hover:bg-gold-dark transition-colors"><i data-lucide="send" class="w-4 h-4"></i> Send Message</button>
          </form>
        </div>

        <div>
          <div class="rounded-2xl overflow-hidden h-full min-h-[400px] border border-border">
            <iframe src="<?= h($contactInfo['mapEmbedUrl']) ?>" width="100%" height="100%" style="border:0;min-height:400px" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Nagashree English School location on Google Maps"></iframe>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>
