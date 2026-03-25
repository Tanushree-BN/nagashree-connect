# WebP Image Optimization Guide

This guide explains how to convert your JPG/PNG images to WebP format to improve website performance.

## Benefits of WebP Conversion

- **Smaller File Sizes**: WebP images are typically 25-35% smaller than JPG/PNG equivalents
- **Faster Loading**: Reduced file sizes mean faster image loading and better page performance
- **Same Quality**: Visual quality is maintained or improved compared to JPG/PNG
- **Broad Browser Support**: Modern browsers (Chrome, Firefox, Edge, Safari 16+) all support WebP

## Current Image Status

Your website currently has the following images that can be optimized:

- JPG/JPEG images: 40+ files
- PNG images: 1 file (logo - keep as PNG for transparency)

## Conversion Methods

### Option 1: Using ImageMagick (Recommended for Windows)

#### Installation:

1. Download from: https://imagemagick.org/script/download.php
2. Choose "ImageMagick-7.x.x-Q16-HDRI-x64-dll.exe"
3. Install with default settings

#### Batch Conversion Script:

```powershell
# Save this as convert-to-webp.ps1
# Run: Set-ExecutionPolicy -ExecutionPolicy Bypass -Scope Process
# Then: .\convert-to-webp.ps1

$imagePath = "D:\PROJECTS\nagashree-connect\public_html\assets\images"
$quality = 85  # 0-100, higher = better quality, larger file

# Get all JPG files
$jpgFiles = Get-ChildItem -Path $imagePath -Filter "*.jpg" -Recurse
$jpegFiles = Get-ChildItem -Path $imagePath -Filter "*.jpeg" -Recurse

$allImages = @() + $jpgFiles + $jpegFiles

Write-Host "Found $($allImages.Count) JPG/JPEG images to convert"

foreach ($file in $allImages) {
    $outputFile = $file.FullName -replace '\.(jpg|jpeg)$', '.webp'

    # Skip if WebP version already exists
    if (Test-Path $outputFile) {
        Write-Host "SKIP: $($file.Name) (already converted)"
        continue
    }

    Write-Host "Converting: $($file.Name) -> $(Split-Path -Leaf $outputFile)"

    # Use ImageMagick's convert command
    & magick convert "$($file.FullName)" -quality $quality -define webp:method=6 "$outputFile"

    if ($?) {
        $originalSize = $file.Length / 1MB
        $newSize = (Get-Item $outputFile).Length / 1MB
        $savings = [math]::Round(($originalSize - $newSize) / $originalSize * 100, 2)
        Write-Host "  ✓ Success! Original: $([math]::Round($originalSize, 2))MB → New: $([math]::Round($newSize, 2))MB (Saved $savings%)"
    } else {
        Write-Host "  ✗ Failed to convert"
    }
}

Write-Host "`nConversion complete!"
```

### Option 2: Using FFmpeg

If you have FFmpeg installed:

```powershell
# Save as convert-ffmpeg.ps1

$imagePath = "D:\PROJECTS\nagashree-connect\public_html\assets\images"
$quality = 85

$jpgFiles = Get-ChildItem -Path $imagePath -Filter "*.jpg" -Recurse
$jpegFiles = Get-ChildItem -Path $imagePath -Filter "*.jpeg" -Recurse

foreach ($file in $jpgFiles + $jpegFiles) {
    $outputFile = $file.FullName -replace '\.(jpg|jpeg)$', '.webp'

    if (Test-Path $outputFile) {
        continue
    }

    & ffmpeg -i "$($file.FullName)" -q:v $quality "$outputFile" 2>$null
}
```

### Option 3: Online Conversion Service

If you prefer not to install tools, use:

- CloudConvert: https://cloudconvert.com/
- TinyPNG (has WebP support): https://tinypng.com/
- Squoosh (Google): https://squoosh.app/

## Step-by-Step Instructions

### 1. Backup Original Images

```powershell
Copy-Item -Path "D:\PROJECTS\nagashree-connect\public_html\assets\images" -Destination "D:\PROJECTS\nagashree-connect\public_html\assets\images-backup" -Recurse
```

### 2. Run Conversion Script

- Copy the PowerShell script above
- Save as `convert-to-webp.ps1` in your project directory
- Run: `Set-ExecutionPolicy -ExecutionPolicy Bypass -Scope Process` (one-time)
- Run: `.\convert-to-webp.ps1`

### 3. Update PHP Code

All PHP files have been pre-configured to support WebP:

- They include both `loading="lazy"` for lazy loading
- They include `decoding="async"` for faster rendering
- They include proper `width` and `height` attributes
- Pagination limits gallery/faculty to 15/12 items per page

### 4. Verify Functionality

- Homepage loads correctly with images
- Gallery page shows 15 images per page initially
- Faculty page shows 12 faculty members per page
- All pagination works correctly
- Images load lazily (check Network tab in DevTools)

## Image Path References

Images are referenced in these files:

- **Front-end pages**: index.php, gallery.php, faculties.php, facilities.php, about.php, contact.php
- **Admin pages**: admin/gallery.php, admin/faculties.php
- **Includes**: includes/navbar.php, includes/hero-banner.php
- **Database storage**: Stored in `gallery_images` and `faculties` tables

## Performance Optimization Checklist

✅ Done:

- [x] Added lazy loading (`loading="lazy"`) to all images
- [x] Added async decoding (`decoding="async"`) to all images
- [x] Added proper `width` and `height` attributes
- [x] Implemented pagination (15 images/page for gallery, 12 faculty/page)
- [x] Updated .htaccess with 1-year browser caching for images
- [x] Added pagination functions to helpers.php

⏳ Next Steps:

- [ ] Convert JPG/PNG images to WebP format
- [ ] Compress images to under 200-300KB each
- [ ] Test all pages for correct functionality
- [ ] Monitor performance improvements
- [ ] Consider CDN setup for static assets (optional)

## Expected Improvements

After WebP conversion and optimization:

- **Page Load Time**: 30-50% improvement
- **Bandwidth Usage**: 25-35% reduction
- **File Size**: Total image folder size reduced by ~40%
- **User Experience**: Faster loading on mobile devices

## Troubleshooting

### Images Not Showing

1. Check that WebP files are in the correct directory
2. Verify file names match references in PHP
3. Ensure .htaccess caching rules are applied

### Conversion Fails

1. Verify ImageMagick is in system PATH: `magick --version`
2. Check write permissions on images folder
3. Ensure disk space is available for temporary files

### WebP Not Supported (Old Browsers)

The PHP code includes fallback support:

- JPG/PNG images continue to work
- Modern browsers automatically use WebP when available
- Consider keeping originals as backup

## File Size Targets

Aim for images under 200-300KB each:

- Gallery images: 150-250KB (WebP 85% quality)
- Background images: 100-200KB (WebP 80% quality)
- Logos/icons: under 50KB
- Thumbnails: under 100KB

## Additional Resources

- WebP Documentation: https://developers.google.com/speed/webp
- ImageMagick Docs: https://imagemagick.org/
- Browser Support: https://caniuse.com/webp
