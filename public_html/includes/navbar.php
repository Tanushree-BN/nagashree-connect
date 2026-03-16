<?php
$contactInfo = CONTACT_INFO;
$navLinks = [
    ['label' => 'Home', 'path' => '/'],
    ['label' => 'About', 'path' => '/about'],
    ['label' => 'Admission', 'path' => '/admission'],
    ['label' => 'Gallery', 'path' => '/gallery'],
    ['label' => 'Faculties', 'path' => '/faculties'],
    ['label' => 'Facilities', 'path' => '/facilities'],
    ['label' => 'Contact', 'path' => '/contact'],
];
?>
<div class="gradient-navy text-primary-foreground text-sm py-2 px-4 hidden md:block">
  <div class="container mx-auto flex justify-between items-center">
    <div class="flex items-center gap-6">
      <a href="mailto:<?= h($contactInfo['email']) ?>" class="flex items-center gap-1.5 hover:text-gold transition-colors">
        <i data-lucide="mail" class="w-3.5 h-3.5"></i>
        <?= h($contactInfo['email']) ?>
      </a>
      <a href="tel:<?= h($contactInfo['phones']['office']) ?>" class="flex items-center gap-1.5 hover:text-gold transition-colors">
        <i data-lucide="phone" class="w-3.5 h-3.5"></i>
        <?= h($contactInfo['phones']['office']) ?>
      </a>
    </div>
    <div class="flex items-center gap-4">
      <a href="<?= h($contactInfo['socialLinks']['facebook']) ?>" target="_blank" rel="noopener noreferrer" class="hover:text-gold transition-colors">Facebook</a>
      <a href="<?= h($contactInfo['socialLinks']['instagram']) ?>" target="_blank" rel="noopener noreferrer" class="hover:text-gold transition-colors">Instagram</a>
      <a href="<?= h($contactInfo['socialLinks']['youtube']) ?>" target="_blank" rel="noopener noreferrer" class="hover:text-gold transition-colors">YouTube</a>
    </div>
  </div>
</div>

<header id="site-header" class="sticky top-0 z-50 transition-all duration-300 bg-card/95 backdrop-blur-md">
  <div class="container mx-auto flex items-center justify-between py-3 px-4">
    <a href="/" class="flex items-center gap-3">
      <img src="/assets/images/nag-logo.png" alt="Nagashree English School logo" class="w-12 h-12 object-contain" />
      <div>
        <span class="font-display font-bold text-lg text-primary leading-tight block">Nagashree English School</span>
        <span class="text-xs text-muted-foreground">Channarayapatna, Hassan</span>
      </div>
    </a>

    <nav class="hidden lg:flex items-center gap-1" aria-label="Main navigation">
      <?php foreach ($navLinks as $link): ?>
        <a href="<?= h($link['path']) ?>" class="px-4 py-2 rounded-lg text-sm font-medium transition-colors <?= $currentPath === $link['path'] ? 'bg-secondary text-secondary-foreground' : 'text-foreground hover:bg-muted' ?>">
          <?= h($link['label']) ?>
        </a>
      <?php endforeach; ?>

      <?php if (is_admin_logged_in()): ?>
        <div class="flex items-center ml-2 border-l pl-2 border-primary-foreground/20">
          <a href="/admin/dashboard" class="px-4 py-2 rounded-lg text-sm font-medium transition-colors <?= starts_with($currentPath, '/admin') ? 'bg-gold text-secondary-foreground' : 'text-gold hover:text-gold-dark hover:bg-muted' ?>">
            Admin Dashboard
          </a>
          <a href="/logout" class="px-4 py-2 ml-1 rounded-lg text-sm font-medium text-destructive hover:bg-destructive/10 transition-colors">Logout</a>
        </div>
      <?php else: ?>
        <a href="/admin/login" class="px-4 py-2 ml-2 rounded-lg text-sm font-medium transition-colors <?= $currentPath === '/admin/login' ? 'bg-gold text-secondary-foreground' : 'text-gold hover:text-gold-dark hover:bg-muted' ?>">
          Admin Login
        </a>
      <?php endif; ?>
    </nav>

    <button id="mobile-menu-toggle" class="lg:hidden p-2 text-foreground" aria-label="Open menu">
      <i data-lucide="menu" class="w-6 h-6" id="menu-open-icon"></i>
      <i data-lucide="x" class="w-6 h-6 hidden" id="menu-close-icon"></i>
    </button>
  </div>

  <nav id="mobile-menu" class="lg:hidden border-t border-border bg-card px-4 pb-4 hidden" aria-label="Mobile navigation">
    <?php foreach ($navLinks as $link): ?>
      <a href="<?= h($link['path']) ?>" class="block px-4 py-3 rounded-lg text-sm font-medium transition-colors <?= $currentPath === $link['path'] ? 'bg-secondary text-secondary-foreground' : 'text-foreground hover:bg-muted' ?>">
        <?= h($link['label']) ?>
      </a>
    <?php endforeach; ?>

    <div class="mt-2 pt-2 border-t border-border">
      <?php if (is_admin_logged_in()): ?>
        <a href="/admin/dashboard" class="block px-4 py-3 rounded-lg text-sm font-medium transition-colors <?= starts_with($currentPath, '/admin') ? 'bg-gold text-secondary-foreground' : 'text-gold hover:text-gold-dark hover:bg-muted' ?>">Admin Dashboard</a>
        <a href="/logout" class="w-full text-left block px-4 py-3 rounded-lg text-sm font-medium text-destructive hover:bg-destructive/10 transition-colors">Logout</a>
      <?php else: ?>
        <a href="/admin/login" class="block px-4 py-3 rounded-lg text-sm font-medium transition-colors <?= $currentPath === '/admin/login' ? 'bg-gold text-secondary-foreground' : 'text-gold hover:text-gold-dark hover:bg-muted' ?>">Admin Login</a>
      <?php endif; ?>
    </div>
  </nav>
</header>
