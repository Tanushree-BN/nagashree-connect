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
      <h2 class="font-display text-3xl md:text-5xl font-bold text-primary-foreground mt-4 mb-4">Admissions Open for 2025-26</h2>
      <p class="text-primary-foreground/70 text-lg max-w-xl mx-auto">Give your child the gift of quality education. Limited seats available — apply now!</p>
    </div>
  </section>

  <section class="section-padding bg-muted">
    <div class="container mx-auto max-w-3xl">
      <div class="text-center mb-10">
        <h2 class="section-title mb-2">Online Admission Form</h2>
        <p class="text-muted-foreground">Fill in the details below to apply for admission.</p>
      </div>

      <div id="admission-success" class="hidden items-center gap-3 bg-gold/10 text-gold rounded-lg p-4 mb-6"><i data-lucide="check-circle" class="w-5 h-5"></i><span class="font-medium text-sm">Admission submitted successfully. We will contact you soon.</span></div>
      <div id="admission-error" class="hidden items-center gap-3 bg-destructive/10 text-destructive rounded-lg p-4 mb-6"><i data-lucide="alert-circle" class="w-5 h-5"></i><span class="font-medium text-sm">Unable to submit the admission form right now. Please try again.</span></div>

      <form id="admission-form" class="bg-card rounded-xl p-8 border border-border space-y-5">
        <div class="grid sm:grid-cols-2 gap-5">
          <div>
            <label class="block text-sm font-medium text-foreground mb-1.5">Student Full Name *</label>
            <input name="studentName" required maxlength="100" class="w-full px-4 py-3 rounded-lg border border-input bg-background text-foreground text-sm focus:outline-none focus:ring-2 focus:ring-ring" placeholder="Student's full name" />
          </div>
          <div>
            <label class="block text-sm font-medium text-foreground mb-1.5">Parent/Guardian Name *</label>
            <input name="parentName" required maxlength="100" class="w-full px-4 py-3 rounded-lg border border-input bg-background text-foreground text-sm focus:outline-none focus:ring-2 focus:ring-ring" placeholder="Parent/Guardian name" />
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
            <label class="block text-sm font-medium text-foreground mb-1.5">Phone Number *</label>
            <input name="phone" type="tel" required maxlength="15" class="w-full px-4 py-3 rounded-lg border border-input bg-background text-foreground text-sm focus:outline-none focus:ring-2 focus:ring-ring" placeholder="+91-XXXXXXXXXX" />
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
          <div>
            <label class="block text-sm font-medium text-foreground mb-1.5">Previous Grade/Marks</label>
            <input name="previousGrade" maxlength="50" class="w-full px-4 py-3 rounded-lg border border-input bg-background text-foreground text-sm focus:outline-none focus:ring-2 focus:ring-ring" placeholder="e.g. A Grade / 85%" />
          </div>
          <div>
            <label class="block text-sm font-medium text-foreground mb-1.5">Aadhaar Number</label>
            <input name="aadhaar" maxlength="14" class="w-full px-4 py-3 rounded-lg border border-input bg-background text-foreground text-sm focus:outline-none focus:ring-2 focus:ring-ring" placeholder="XXXX-XXXX-XXXX" />
          </div>
        </div>

        <button type="submit" class="inline-flex items-center gap-2 px-8 py-3.5 rounded-lg bg-gold text-secondary-foreground font-semibold hover:bg-gold-dark transition-colors w-full justify-center">Submit Application <i data-lucide="arrow-right" class="w-4 h-4"></i></button>
      </form>
    </div>
  </section>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>
