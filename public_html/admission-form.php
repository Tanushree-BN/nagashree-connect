<?php
$pageTitle = 'Admission Form - Nagashree English School';
$currentPath = '/admission';
require_once __DIR__ . '/includes/header.php';
$heroTitle = 'Admission Form';
$heroBreadcrumb = 'Admission Form';
include __DIR__ . '/includes/hero-banner.php';
?>
<main>
  <section class="section-padding bg-muted">
    <div class="container mx-auto max-w-3xl">
      <div class="text-center mb-10">
        <h2 class="section-title mb-2">Online Admission Form</h2>
        <p class="text-muted-foreground">Fill in the details below and submit your application.</p>
      </div>

      <div id="admission-success" class="hidden bg-gold/10 text-gold rounded-lg p-4 mb-6">
        <div class="flex items-start gap-3">
          <i data-lucide="check-circle" class="w-5 h-5 mt-0.5"></i>
          <div class="space-y-3">
            <span class="font-medium text-sm block">Admission submitted successfully. We will contact you soon.</span>
            <p id="admission-whatsapp-prompt" class="text-sm text-foreground">Would you also like to send these details through WhatsApp for faster process?</p>
            <div class="flex flex-col sm:flex-row gap-2">
              <button id="admission-whatsapp-send-btn" type="button" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-gold text-secondary-foreground text-sm font-semibold hover:bg-gold-dark transition-colors">
                <i data-lucide="message-circle" class="w-4 h-4"></i> Send Information Through WhatsApp
              </button>
              <button id="admission-submit-another-btn" type="button" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg border border-border bg-card text-foreground text-sm font-semibold hover:bg-muted transition-colors">
                <i data-lucide="refresh-ccw" class="w-4 h-4"></i> Submit Another Application
              </button>
              <a href="/admission" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg border border-border bg-card text-foreground text-sm font-semibold hover:bg-muted transition-colors">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Back to Admission Page
              </a>
            </div>
          </div>
        </div>
      </div>
      <div id="admission-error" class="hidden items-center gap-3 bg-destructive/10 text-destructive rounded-lg p-4 mb-6"><i data-lucide="alert-circle" class="w-5 h-5"></i><span class="font-medium text-sm">Unable to submit the admission form right now. Please try again.</span></div>

      <form id="admission-form" class="bg-card rounded-xl p-8 border border-border space-y-5">
        <div class="grid sm:grid-cols-2 gap-5">
          <div>
            <label class="block text-sm font-medium text-foreground mb-1.5">Student Full Name *</label>
            <input name="studentName" required maxlength="100" class="w-full px-4 py-3 rounded-lg border border-input bg-background text-foreground text-sm focus:outline-none focus:ring-2 focus:ring-ring" placeholder="Student's full name" />
          </div>
          <div>
            <label class="block text-sm font-medium text-foreground mb-1.5">Father's Name *</label>
            <input name="parentName" required maxlength="100" class="w-full px-4 py-3 rounded-lg border border-input bg-background text-foreground text-sm focus:outline-none focus:ring-2 focus:ring-ring" placeholder="Father's full name" />
          </div>
          <div>
            <label class="block text-sm font-medium text-foreground mb-1.5">Mother's Name *</label>
            <input name="motherName" required maxlength="100" class="w-full px-4 py-3 rounded-lg border border-input bg-background text-foreground text-sm focus:outline-none focus:ring-2 focus:ring-ring" placeholder="Mother's full name" />
          </div>
        </div>

        <div class="grid sm:grid-cols-3 gap-5">
          <div>
            <label class="block text-sm font-medium text-foreground mb-1.5">Date of Birth *</label>
            <input name="dob" type="date" required class="w-full px-4 py-3 rounded-lg border border-input bg-background text-foreground text-sm focus:outline-none focus:ring-2 focus:ring-ring" />
          </div>
          <div>
            <label class="block text-sm font-medium text-foreground mb-1.5">Gender *</label>
            <select name="gender" required class="w-full px-4 py-3 rounded-lg border border-input bg-background text-foreground text-sm focus:outline-none focus:ring-2 focus:ring-ring">
              <option value="">Select</option>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
              <option value="Other">Other</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-foreground mb-1.5">Class Applying For *</label>
            <select name="classApplying" required class="w-full px-4 py-3 rounded-lg border border-input bg-background text-foreground text-sm focus:outline-none focus:ring-2 focus:ring-ring">
              <option value="">Select Class</option>
              <option>Nursery</option>
              <option>LKG</option>
              <option>UKG</option>
              <?php for ($i = 1; $i <= 10; $i++): ?>
                <option>Class <?= $i ?></option>
              <?php endfor; ?>
            </select>
          </div>
        </div>

        <div class="grid sm:grid-cols-2 gap-5">
          <div>
            <label class="block text-sm font-medium text-foreground mb-1.5">Father's Phone Number *</label>
            <input name="phone" type="tel" required maxlength="15" class="w-full px-4 py-3 rounded-lg border border-input bg-background text-foreground text-sm focus:outline-none focus:ring-2 focus:ring-ring" placeholder="+91-XXXXXXXXXX" />
          </div>
          <div>
            <label class="block text-sm font-medium text-foreground mb-1.5">Mother's Phone Number *</label>
            <input name="motherPhone" type="tel" required maxlength="15" class="w-full px-4 py-3 rounded-lg border border-input bg-background text-foreground text-sm focus:outline-none focus:ring-2 focus:ring-ring" placeholder="+91-XXXXXXXXXX" />
          </div>
          <div>
            <label class="block text-sm font-medium text-foreground mb-1.5">Email</label>
            <input name="email" type="email" maxlength="255" class="w-full px-4 py-3 rounded-lg border border-input bg-background text-foreground text-sm focus:outline-none focus:ring-2 focus:ring-ring" placeholder="parent@email.com" />
          </div>
        </div>

        <div>
          <label class="block text-sm font-medium text-foreground mb-1.5">Address *</label>
          <textarea name="address" required maxlength="500" rows="3" class="w-full px-4 py-3 rounded-lg border border-input bg-background text-foreground text-sm focus:outline-none focus:ring-2 focus:ring-ring resize-none" placeholder="Full residential address"></textarea>
        </div>

        <div class="grid sm:grid-cols-3 gap-5">
          <div>
            <label class="block text-sm font-medium text-foreground mb-1.5">Previous School</label>
            <input name="previousSchool" maxlength="200" class="w-full px-4 py-3 rounded-lg border border-input bg-background text-foreground text-sm focus:outline-none focus:ring-2 focus:ring-ring" placeholder="Previous school name" />
          </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-3">
          <button type="submit" class="inline-flex items-center gap-2 px-8 py-3.5 rounded-lg bg-gold text-secondary-foreground font-semibold hover:bg-gold-dark transition-colors w-full justify-center">Submit Application <i data-lucide="arrow-right" class="w-4 h-4"></i></button>
          <a href="/admission" class="inline-flex items-center gap-2 px-8 py-3.5 rounded-lg border border-border text-foreground font-semibold hover:bg-muted transition-colors w-full justify-center"><i data-lucide="arrow-left" class="w-4 h-4"></i> Cancel</a>
        </div>
      </form>
    </div>
  </section>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>
