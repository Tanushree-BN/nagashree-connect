# WebP Image Conversion Script
# This script converts JPG/JPEG images to WebP format with compression
# 
# Prerequisites: ImageMagick installed (https://imagemagick.org/script/download.php)
#
# Usage: Set-ExecutionPolicy -ExecutionPolicy Bypass -Scope Process
#        .\convert-to-webp.ps1

param(
    [string]$ImagePath = "D:\PROJECTS\nagashree-connect\public_html\assets\images",
    [int]$Quality = 85,
    [switch]$DeleteOriginals = $false,
    [switch]$DryRun = $false
)

# Color output helpers
function Write-Success {
    param([string]$Message)
    Write-Host $Message -ForegroundColor Green
}

function Write-Error {
    param([string]$Message)
    Write-Host $Message -ForegroundColor Red
}

function Write-Info {
    param([string]$Message)
    Write-Host $Message -ForegroundColor Cyan
}

function Write-Warning {
    param([string]$Message)
    Write-Host $Message -ForegroundColor Yellow
}

# Check prerequisites
Write-Info "Checking prerequisites..."

# Verify ImageMagick is installed
$magickCmd = Get-Command magick -ErrorAction SilentlyContinue
if (-not $magickCmd) {
    Write-Error "ImageMagick not found! Please install it from https://imagemagick.org/script/download.php"
    exit 1
}

$magickVersion = & magick --version | Select-Object -First 1
Write-Success "✓ ImageMagick found: $magickVersion"

# Verify image directory
if (-not (Test-Path $ImagePath)) {
    Write-Error "Image directory not found: $ImagePath"
    exit 1
}

Write-Info "`nImage directory: $ImagePath"
Write-Info "Quality setting: $Quality (1-100, higher = better quality)"
Write-Info "Delete originals: $DeleteOriginals"

# Find images
$jpgFiles = @(Get-ChildItem -Path $ImagePath -Filter "*.jpg" -Recurse -ErrorAction SilentlyContinue)
$jpegFiles = @(Get-ChildItem -Path $ImagePath -Filter "*.jpeg" -Recurse -ErrorAction SilentlyContinue)
$allImages = $jpgFiles + $jpegFiles

if ($allImages.Count -eq 0) {
    Write-Warning "No JPG/JPEG images found in $ImagePath"
    exit 0
}

Write-Info "`nFound $($allImages.Count) images to convert"
Write-Info "Scanning for existing WebP versions..."

# Scan for already converted images
$alreadyConverted = 0
$alreadyConvertedSize = 0
$toConvert = @()

foreach ($file in $allImages) {
    $webpPath = $file.FullName -replace '\.(jpg|jpeg)$', '.webp'
    
    if (Test-Path $webpPath) {
        $alreadyConverted += 1
        $alreadyConvertedSize += (Get-Item $webpPath).Length
    } else {
        $toConvert += $file
    }
}

if ($alreadyConverted -gt 0) {
    $alreadyConvertedMB = [math]::Round($alreadyConvertedSize / 1MB, 2)
    Write-Info "✓ $alreadyConverted images already converted (saved: ~$alreadyConvertedMB MB)"
    Write-Info "  Proceeding to convert remaining $($toConvert.Count) images..."
}

if ($toConvert.Count -eq 0) {
    Write-Success "`nAll images have already been converted to WebP!"
    exit 0
}

# Create conversion log file
$logFile = Join-Path (Split-Path $ImagePath) "conversion-log.txt"
"WebP Conversion Log - $(Get-Date)" | Set-Content $logFile

Write-Info "`nStarting conversion... (log: $logFile)"
Write-Info "===============================================`n"

# Conversion statistics
$successCount = 0
$failureCount = 0
$originalTotalSize = 0
$newTotalSize = 0
$convertedFiles = @()

# Convert images
foreach ($file in $toConvert) {
    $webpPath = $file.FullName -replace '\.(jpg|jpeg)$', '.webp'
    $originalSize = $file.Length
    $originalSizeMB = [math]::Round($originalSize / 1MB, 2)
    
    $statusMsg = "Converting: $($file.Name) ($originalSizeMB MB)"
    
    if ($DryRun) {
        Write-Info "[DRY RUN] $statusMsg"
        $successCount += 1
        continue
    }
    
    Write-Host -NoNewline "$statusMsg ... "
    
    try {
        # Convert with ImageMagick
        & magick convert "$($file.FullName)" -quality $Quality -define "webp:method=6" "$webpPath" 2>&1 | Out-Null
        
        if (Test-Path $webpPath) {
            $newSize = (Get-Item $webpPath).Length
            $newSizeMB = [math]::Round($newSize / 1MB, 2)
            
            $savings = if ($originalSize -gt 0) {
                [math]::Round(($originalSize - $newSize) / $originalSize * 100, 2)
            } else {
                0
            }
            
            Write-Success "✓ ($newSizeMB MB, saved $savings%)"
            
            # Log the conversion
            "$($file.Name) -> $(Split-Path -Leaf $webpPath) | Original: $originalSizeMB MB | New: $newSizeMB MB | Saved: $savings%" | Add-Content $logFile
            
            $successCount += 1
            $originalTotalSize += $originalSize
            $newTotalSize += $newSize
            $convertedFiles += @{
                Original = $file.FullName
                WebP = $webpPath
                Size = $newSize
            }
            
            # Optionally delete original
            if ($DeleteOriginals) {
                Remove-Item $file.FullName -Force -ErrorAction SilentlyContinue | Out-Null
            }
        } else {
            Write-Error "✗ Failed to create WebP file"
            $failureCount += 1
            "FAILED: $($file.Name)" | Add-Content $logFile
        }
    } catch {
        Write-Error "✗ Error: $_"
        $failureCount += 1
        "ERROR: $($file.Name) - $_" | Add-Content $logFile
    }
}

# Summary
Write-Info "`n==============================================="
Write-Success "Conversion Complete!`n"
Write-Info "Summary:"
Write-Info "  Successfully converted: $successCount images"
if ($failureCount -gt 0) {
    Write-Error "  Failed: $failureCount images"
}
if ($successCount -gt 0) {
    $originalTotalMB = [math]::Round($originalTotalSize / 1MB, 2)
    $newTotalMB = [math]::Round($newTotalSize / 1MB, 2)
    $totalSavings = if ($originalTotalSize -gt 0) {
        [math]::Round(($originalTotalSize - $newTotalSize) / $originalTotalSize * 100, 2)
    } else {
        0
    }
    
    Write-Info "  Original total size: $originalTotalMB MB"
    Write-Info "  WebP total size: $newTotalMB MB"
    Write-Success "  Total space saved: $([math]::Round($originalTotalMB - $newTotalMB, 2)) MB ($totalSavings%)`n"
}

# Update recommendation
Write-Info "Next steps:"
Write-Info "1. Review the converted WebP files in your images directory"
Write-Info "2. Test your website to ensure all images display correctly"
Write-Info "3. Check browser DevTools (Network tab) to verify WebP images are being used"

if (-not $DeleteOriginals) {
    Write-Warning "`n⚠ Original JPG files are still present."
    Write-Info "   You can manually delete them after verifying the WebP versions work correctly."
    Write-Info "   Or re-run with -DeleteOriginals `$true to remove originals automatically."
}

if ($DryRun) {
    Write-Info "`n[DRY RUN MODE] - No actual conversions were performed."
    Write-Info "Re-run without -DryRun to perform actual conversions."
}

Write-Success "`nConversion log saved to: $logFile"
