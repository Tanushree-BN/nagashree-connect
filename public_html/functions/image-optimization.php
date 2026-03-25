<?php
/**
 * Image Optimization Utilities
 * Provides server-side image optimization and caching functions
 */

require_once __DIR__ . '/../config/db.php';

/**
 * Generate responsive image srcset for modern browsers
 * Supports both WebP and fallback formats
 */
function get_image_srcset(string $imagePath, bool $webpSupport = true): array
{
    $basePath = dirname($imagePath);
    $filename = basename($imagePath);
    $filenameParts = pathinfo($filename);
    $nameWithoutExt = $filenameParts['filename'];
    
    $srcset = [
        'src' => $imagePath,
        'webp' => null,
        'sizes' => '(max-width: 680px) 95vw, (max-width: 1024px) 90vw, 87vw',
    ];
    
    // Check if WebP version exists
    if ($webpSupport) {
        $webpPath = "{$basePath}/{$nameWithoutExt}.webp";
        $fullPath = __DIR__ . '/../../' . ltrim($webpPath, '/');
        
        if (is_file($fullPath)) {
            $srcset['webp'] = $webpPath;
        }
    }
    
    return $srcset;
}

/**
 * Get image with responsive srcset HTML
 */
function render_responsive_image(
    string $src,
    string $alt,
    string $class = '',
    int $width = 0,
    int $height = 0,
    string $loading = 'lazy'
): string
{
    $srcset = get_image_srcset($src, true);
    
    // Build HTML string
    $html = '<picture>';
    
    // WebP source for modern browsers
    if ($srcset['webp']) {
        $html .= '<source srcset="' . h($srcset['webp']) . '" type="image/webp">';
    }
    
    // Fallback for non-WebP browsers
    $html .= '<img';
    $html .= ' src="' . h($src) . '"';
    $html .= ' alt="' . h($alt) . '"';
    if ($class) {
        $html .= ' class="' . h($class) . '"';
    }
    if ($width > 0) {
        $html .= ' width="' . intval($width) . '"';
    }
    if ($height > 0) {
        $html .= ' height="' . intval($height) . '"';
    }
    $html .= ' loading="' . h($loading) . '"';
    $html .= ' decoding="async"';
    $html .= ' />';
    
    $html .= '</picture>';
    
    return $html;
}

/**
 * Calculate image statistics
 */
function get_image_optimization_stats(): array
{
    $imagesDir = __DIR__ . '/../../assets/images';
    
    $stats = [
        'total_files' => 0,
        'jpg_count' => 0,
        'webp_count' => 0,
        'png_count' => 0,
        'jpg_size_mb' => 0.0,
        'webp_size_mb' => 0.0,
        'total_original_mb' => 0.0,
        'total_optimized_mb' => 0.0,
        'savings_percent' => 0.0,
        'conversions_complete' => false,
    ];
    
    if (!is_dir($imagesDir)) {
        return $stats;
    }
    
    // Scan all images
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($imagesDir, RecursiveDirectoryIterator::SKIP_DOTS)
    );
    
    $jpgFiles = [];
    $webpFiles = [];
    $pngFiles = [];
    
    foreach ($files as $file) {
        if (!$file->isFile()) {
            continue;
        }
        
        $ext = strtolower($file->getExtension());
        $size = $file->getSize();
        
        if ($ext === 'jpg' || $ext === 'jpeg') {
            $jpgFiles[] = $file;
            $stats['jpg_count']++;
            $stats['jpg_size_mb'] += $size / (1024 * 1024);
            $stats['total_original_mb'] += $size / (1024 * 1024);
        } elseif ($ext === 'webp') {
            $webpFiles[] = $file;
            $stats['webp_count']++;
            $stats['webp_size_mb'] += $size / (1024 * 1024);
            $stats['total_optimized_mb'] += $size / (1024 * 1024);
        } elseif ($ext === 'png') {
            $pngFiles[] = $file;
            $stats['png_count']++;
            $stats['total_original_mb'] += $size / (1024 * 1024);
        }
        
        $stats['total_files']++;
    }
    
    // Calculate savings
    if ($stats['total_original_mb'] > 0 && $stats['total_optimized_mb'] > 0) {
        $stats['savings_percent'] = round(
            ($stats['total_original_mb'] - $stats['total_optimized_mb']) / $stats['total_original_mb'] * 100,
            2
        );
    }
    
    // Check if conversions are complete
    $stats['conversions_complete'] = $stats['webp_count'] > 0 && $stats['jpg_count'] === $stats['webp_count'];
    
    // Round values
    $stats['jpg_size_mb'] = round($stats['jpg_size_mb'], 2);
    $stats['webp_size_mb'] = round($stats['webp_size_mb'], 2);
    $stats['total_original_mb'] = round($stats['total_original_mb'], 2);
    $stats['total_optimized_mb'] = round($stats['total_optimized_mb'], 2);
    
    return $stats;
}

/**
 * Cache optimization statistics (5 minute cache)
 */
function get_cached_optimization_stats(): array
{
    $cacheKey = 'image_optimization_stats';
    $cacheFile = __DIR__ . '/../../storage/' . $cacheKey . '.json';
    $cacheTTL = 300; // 5 minutes
    
    // Check if cached version is valid
    if (is_file($cacheFile)) {
        $mtime = filemtime($cacheFile);
        if (time() - $mtime < $cacheTTL) {
            $cached = json_decode(file_get_contents($cacheFile), true);
            if (is_array($cached)) {
                return $cached;
            }
        }
    }
    
    // Generate fresh stats
    $stats = get_image_optimization_stats();
    
    // Cache it
    @mkdir(dirname($cacheFile), 0755, true);
    @file_put_contents($cacheFile, json_encode($stats, JSON_PRETTY_PRINT));
    
    return $stats;
}
