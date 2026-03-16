<?php
require_once __DIR__ . '/../functions/helpers.php';
$pageTitle = $pageTitle ?? SITE_NAME;
$currentPath = $currentPath ?? '/';
$isAdminLayout = $isAdminLayout ?? false;

$basePath = app_base_path();
if ($basePath !== '' && !defined('NAGASHREE_OUTPUT_REWRITE')) {
  define('NAGASHREE_OUTPUT_REWRITE', true);
  ob_start(static function (string $buffer) use ($basePath): string {
    $trimmedBase = ltrim($basePath, '/');

    return preg_replace_callback('/\b(href|src|action)=(["\'])\/(?!\/)([^"\']*)\2/i', static function (array $match) use ($basePath, $trimmedBase): string {
      $attribute = $match[1];
      $quote = $match[2];
      $path = $match[3];

      if ($trimmedBase !== '' && ($path === $trimmedBase || starts_with($path, $trimmedBase . '/'))) {
        return $match[0];
      }

      return $attribute . '=' . $quote . $basePath . '/' . $path . $quote;
    }, $buffer) ?? $buffer;
  });
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= h($pageTitle) ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    window.APP_BASE = <?= json_encode(rtrim(app_url('/'), '/')) ?>;
    window.appUrl = function (path) {
      var value = String(path || '');
      if (/^https?:\/\//i.test(value) || /^\/\//.test(value)) {
        return value;
      }

      var clean = '/' + value.replace(/^\/+/, '');
      return (window.APP_BASE || '') + clean;
    };

    tailwind.config = {
      theme: {
        extend: {
          container: {
            center: true,
            padding: '2rem',
            screens: { '2xl': '1400px' }
          },
          fontFamily: {
            display: ['Playfair Display', 'serif'],
            body: ['Inter', 'sans-serif']
          },
          colors: {
            border: 'hsl(var(--border))',
            input: 'hsl(var(--input))',
            ring: 'hsl(var(--ring))',
            background: 'hsl(var(--background))',
            foreground: 'hsl(var(--foreground))',
            primary: { DEFAULT: 'hsl(var(--primary))', foreground: 'hsl(var(--primary-foreground))' },
            secondary: { DEFAULT: 'hsl(var(--secondary))', foreground: 'hsl(var(--secondary-foreground))' },
            destructive: { DEFAULT: 'hsl(var(--destructive))', foreground: 'hsl(var(--destructive-foreground))' },
            muted: { DEFAULT: 'hsl(var(--muted))', foreground: 'hsl(var(--muted-foreground))' },
            accent: { DEFAULT: 'hsl(var(--accent))', foreground: 'hsl(var(--accent-foreground))' },
            card: { DEFAULT: 'hsl(var(--card))', foreground: 'hsl(var(--card-foreground))' },
            navy: { DEFAULT: 'hsl(var(--navy))', light: 'hsl(var(--navy-light))', dark: 'hsl(var(--navy-dark))' },
            gold: { DEFAULT: 'hsl(var(--gold))', light: 'hsl(var(--gold-light))', dark: 'hsl(var(--gold-dark))' }
          },
          borderRadius: {
            lg: 'var(--radius)',
            md: 'calc(var(--radius) - 2px)',
            sm: 'calc(var(--radius) - 4px)'
          }
        }
      }
    };
  </script>
  <link rel="stylesheet" href="<?= h(app_url('/assets/css/styles.css')) ?>" />
</head>
<body class="bg-background text-foreground">
<?php if (!$isAdminLayout): ?>
  <?php include __DIR__ . '/navbar.php'; ?>
<?php endif; ?>
