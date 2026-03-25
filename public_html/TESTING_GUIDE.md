# Image Optimization Testing Guide

## Pre-Testing Checklist

- [ ] All PHP files have been updated
- [ ] .htaccess has been updated with caching rules
- [ ] Image optimization functions exist
- [ ] Pagination helpers created
- [ ] WebP conversion script ready

## Testing Points

### 1. Homepage Testing (index.php)

**Load Time:**

- [ ] Page loads in under 3 seconds on 4G
- [ ] Images display correctly

**Images to Check:**

- [ ] Hero banner (clg1.JPG) - with `loading="eager"` (should load first)
- [ ] "What We Offer" section (RKP_9725.JPG) - with `loading="lazy"`
- [ ] Video thumbnail (bg2.JPG) - with `loading="lazy"`
- [ ] Gallery preview (4 images) - with correct dimensions

**DevTools Network Tab:**

- [ ] Check that hero image loads first
- [ ] Gallery images should not load until scrolled into view
- [ ] Verify Width/Height attributes prevent layout shift

**Lazy Loading Test:** 1. Open DevTools (F12) 2. Go to Network tab 3. Scroll down slowly 4. Verify gallery images load when reaching that section

### 2. Gallery Page Testing (gallery.php)

**Pagination:**

- [ ] Only 15 images showing on first load
- [ ] "Page 1 of X" shows correct number of pages
- [ ] Page numbers are clickable
- [ ] First/Previous/Next/Last buttons work
- [ ] URLs change correctly: `?page=1`, `?page=2`, etc.

**Category Filtering:**

- [ ] Clicking "all" shows all images
- [ ] Clicking "events" shows only events
- [ ] Clicking "classroom" shows only classroom images
- [ ] Clicking "sports" shows only sports images
- [ ] Clicking "facilities" shows only facilities images
- [ ] Pagination resets to page 1 when filtering

**Image Loading:**

- [ ] All 15 images load correctly
- [ ] No broken images (red X icon)
- [ ] Lightbox opens when clicking images
- [ ] Title overlay appears on hover
- [ ] All images have proper alt text

**Performance:**

- [ ] Page loads faster than before (fewer images loaded)
- [ ] No console errors

### 3. Faculty Page Testing (faculties.php)

**Pagination:**

- [ ] Only 12 faculty members showing
- [ ] Pagination controls visible
- [ ] Page navigation works correctly
- [ ] URLs update: `?page=1`, `?page=2`, etc.

**Faculty Card Display:**

- [ ] Faculty images display correctly
- [ ] Names, roles, subjects visible
- [ ] Experience displays properly
- [ ] Missing images show placeholder icon

**Performance:**

- [ ] Faster initial load than before
- [ ] No console errors

### 4. Facilities Page Testing (facilities.php)

**Image Display:**

- [ ] All facility images load lazily
- [ ] Images have correct dimensions (400x300, 600x300)
- [ ] Hover effect works (scale-105)
- [ ] Modal opens when clicking facilities
- [ ] Modal images display correctly

### 5. About Page Testing (about.php)

**Image:**

- [ ] Campus image (clg2.JPG) displays correctly
- [ ] Image has width/height attributes
- [ ] Loading="lazy" is applied

### 6. Contact Page Testing (contact.php)

**Background Image:**

- [ ] Contact background image (bg3.JPG) displays
- [ ] Forms are functional
- [ ] Image loads eagerly (high priority)

### 7. Admin Pages Testing

**Admin Gallery (admin/gallery.php):**

- [ ] Image upload works
- [ ] Previews display correctly
- [ ] Edit functionality works
- [ ] Delete functionality works
- [ ] Images have width/height attributes

**Admin Faculties (admin/faculties.php):**

- [ ] Faculty image upload works
- [ ] Faculty previews display correctly
- [ ] Edit functionality works
- [ ] Delete functionality works
- [ ] Images have width/height attributes in table

### 8. .htaccess Caching Testing

**Using Browser DevTools:**

1. Open DevTools (F12)
2. Network tab
3. Reload page
4. Check Response Headers for images:
   - Should include: `Cache-Control: public, max-age=31536000, immutable`
   - Should include: `Expires` header (1 year from now)

**Second Visit Test:**

1. Reload page again
2. With browser cache enabled, images should load from cache
3. Status code should show "304" or come from cache

### 9. Broken Links Testing

**Check for 404 Errors:**

1. Open DevTools (F12)
2. Network tab
3. Reload each page
4. Filter by "Img" in DevTools
5. Look for any status 404 (not found)
6. All images should be 200 or cached

### 10. Browser Compatibility Testing

Test on different browsers:

**Chrome/Edge:**

- [ ] Page loads correctly
- [ ] All images display
- [ ] WebP images will be used (if converted)
- [ ] Pagination works

**Firefox:**

- [ ] Page loads correctly
- [ ] All images display
- [ ] WebP images will be used (if converted)
- [ ] Pagination works

**Safari:**

- [ ] Page loads correctly
- [ ] All images display
- [ ] WebP images will be used (v16+)
- [ ] Pagination works

**Mobile (iOS/Android):**

- [ ] Pages load quickly
- [ ] Images are properly sized
- [ ] Pagination is usable on small screens
- [ ] Touch interactions work

### 11. Performance Metrics Testing

**Google PageSpeed Insights:**

1. Go to: https://pagespeed.web.dev/
2. Enter each URL:
   - Homepage: `/`
   - Gallery: `/gallery`
   - Faculty: `/faculties`
   - Facilities: `/facilities`
   - Admin Gallery: `/admin/gallery`

3. Compare metrics:
   - Largest Contentful Paint (LCP) - should improve
   - First Input Delay (FID) - should stay good
   - Cumulative Layout Shift (CLS) - should be near 0

**Chrome Lighthouse:**

1. In DevTools, go to Lighthouse
2. Run "Performance" audit
3. Check scores:
   - Performance: Should be > 70
   - Best Practices: Should be > 90
   - SEO: Should be > 90

### 12. Responsive Design Testing

**Mobile (375px width):**

- [ ] Gallery shows 2 columns
- [ ] Faculty shows 1 column
- [ ] Images scale properly
- [ ] Pagination is readable

**Tablet (768px width):**

- [ ] Gallery shows 3 columns
- [ ] Faculty shows 2 columns
- [ ] Images scale properly
- [ ] Layout looks good

**Desktop (1024px+ width):**

- [ ] Gallery shows 4 columns
- [ ] Faculty shows 4 columns
- [ ] Images scale properly
- [ ] Full layout displays correctly

### 13. Database Integrity Testing

**Check Gallery Images:**

```sql
SELECT COUNT(*) as total,
       SUM(LENGTH(src)) as total_path_size
FROM gallery_images;
```

**Check Faculty Images:**

```sql
SELECT COUNT(*) as total,
       COUNT(CASE WHEN image != '' THEN 1 END) as with_images
FROM faculties;
```

### 14. Layout Shift (CLS) Testing

**Visual Stability Test:**

1. Disable JavaScript in DevTools
2. Reload page
3. Verify no layout shift occurs
4. Re-enable JavaScript
5. Verify layout remains stable

**Tools:**

- Chrome DevTools: Check "Cumulative Layout Shift" in metrics
- Target: < 0.1 (excellent), < 0.25 (good)

### 15. Bandwidth Usage Testing

**Before Optimization (if available):**

- Total requests
- Total size downloaded
- Number of images loaded

**After Optimization:**

- Total requests should be similar
- Total size downloaded should be significantly less
- Number of images loaded per page should be lower

## Test Reports

### Test Report Template

```
Page: [URL]
Date: [YYYY-MM-DD]
Browser: [Browser Name/Version]

Pagination:
- [ ] Shows correct number of items per page
- [ ] Page numbers work correctly
- [ ] URL updates properly
- [ ] No console errors

Image Loading:
- [ ] All images display correctly
- [ ] No 404 errors
- [ ] Lazy loading works (scroll test)
- [ ] Width/height attributes present

Performance:
- [ ] Page loads quickly
- [ ] No layout shift
- [ ] Responsive design works
- [ ] Browser caching active

Overall Status: [PASS/FAIL]
Notes: [Any issues found]
```

## Common Issues and Solutions

### Issue: Images Not Loading

**Solution:**

- Check file paths in database match actual files
- Verify permissions: `chmod 755 assets/images`
- Check browser console for specific errors

### Issue: Pagination Not Working

**Solution:**

- Clear browser cache
- Check URL parameters: `?page=1`, `?page=2`
- Verify PHP error logs for database errors

### Issue: Layout Shift/Flicker

**Solution:**

- Ensure all images have width/height attributes
- Check CSS isn't overriding dimensions
- Verify responsive images are loading correctly

### Issue: Images Loading Too Slowly

**Solution:**

- Enable browser caching in .htaccess
- Consider WebP conversion for smaller files
- Use PNG compression for transparency images
- Consider CDN for static assets

### Issue: Admin Upload Not Working

**Solution:**

- Check server error logs
- Verify directory permissions: `chmod 755 assets/images/uploads`
- Ensure disk space available
- Check max upload size in php.ini

## Performance Optimization Validation

After all tests pass, verify optimization effectiveness:

**Metrics to Measure:**

1. **Page Load Time**: Should decrease by 30-50%
2. **Total Page Size**: Should decrease by 20-40%
3. **Largest Contentful Paint**: Should improve by 20-30%
4. **Cumulative Layout Shift**: Should be < 0.1
5. **First Contentful Paint**: Should be < 2 seconds

**Tools for Measurement:**

- Chrome DevTools (Network, Performance tabs)
- WebPageTest: https://www.webpagetest.org/
- GTmetrix: https://gtmetrix.com/
- PageSpeed Insights: https://pagespeed.web.dev/

## Sign-Off

Once all tests pass:

- [ ] All pages load correctly
- [ ] Pagination works as expected
- [ ] Images display properly
- [ ] No broken links
- [ ] Performance improved
- [ ] Browser caching configured
- [ ] Responsive design works
- [ ] Admin functionality preserved
- [ ] Database integrity verified
- [ ] No console errors

**Status:** [READY FOR PRODUCTION/NEEDS FIXES]
