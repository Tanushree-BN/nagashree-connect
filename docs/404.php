<?php
http_response_code(404);
$pageTitle = '404 - Page Not Found';
$currentPath = '/404';
require_once __DIR__ . '/includes/header.php';
?>
<div class="flex min-h-screen items-center justify-center bg-muted">
  <div class="text-center">
    <h1 class="mb-4 text-4xl font-bold">404</h1>
    <p class="mb-4 text-xl text-muted-foreground">Oops! Page not found</p>
    <a href="/" class="text-primary underline hover:text-primary/90">Return to Home</a>
  </div>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
