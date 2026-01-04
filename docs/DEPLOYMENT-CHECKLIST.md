# Admission Form Fix - Deployment Checklist

## Pre-Deployment

### 1. Backup Everything
- [ ] Database backup created
- [ ] Files backup created
- [ ] Backup stored safely off-server

### 2. Local Testing (if applicable)
- [ ] Form created successfully locally
- [ ] Form submits without errors
- [ ] Emails are received
- [ ] Validation works correctly
- [ ] Currency displays as Taka (৳)

---

## Files to Upload

### Required Files:
- [ ] `create-admission-form-fixed.php` → Root directory
- [ ] `wp-content/themes/lumina-child-theme/inc/admission-form-handler.php`
- [ ] `wp-content/themes/lumina-child-theme/functions.php` (updated)

### Optional Files (for reference):
- [ ] `test-admission-form.php` → Root directory
- [ ] `ADMISSION-FORM-FIX-GUIDE.md`
- [ ] `TAKA-CURRENCY-REFERENCE.md`

---

## Deployment Steps

### Step 1: Upload Files
- [ ] Files uploaded via FTP/SFTP or cPanel
- [ ] File permissions set correctly (644 for files, 755 for directories)
- [ ] Verify files are in correct locations

### Step 2: Verify Prerequisites
- [ ] Contact Form 7 plugin is active
- [ ] Flamingo plugin is active (or install it)
- [ ] WordPress version is up to date
- [ ] PHP version is 7.4 or higher

### Step 3: Create Admission Form
- [ ] Run `php create-admission-form-fixed.php` via SSH
  OR
- [ ] Run via browser (then delete the runner file)
  OR
- [ ] Run via WP-CLI
- [ ] Note the Form ID from output
- [ ] Verify form appears in Contact > Contact Forms

### Step 4: Configure reCAPTCHA
- [ ] Get reCAPTCHA keys from Google
- [ ] Add keys in Contact > Integration
- [ ] Test reCAPTCHA is working

### Step 5: Update Admissions Page
- [ ] Edit Admissions page
- [ ] Add/update form shortcode with correct Form ID
- [ ] Save and publish page
- [ ] Preview page to verify form displays

### Step 6: Update Currency to Taka
- [ ] Edit Admissions page in Elementor
- [ ] Find fee structure section
- [ ] Replace all currency symbols with ৳
- [ ] Update all amounts to Taka
- [ ] Save and publish
- [ ] Verify Taka symbol displays correctly

### Step 7: Configure Email Settings
- [ ] Verify admin email in Settings > General
- [ ] Install WP Mail SMTP (recommended)
- [ ] Configure SMTP settings
- [ ] Send test email
- [ ] Verify test email received

### Step 8: Test Form Submission
- [ ] Visit Admissions page on live site
- [ ] Fill out form with test data
- [ ] Submit form
- [ ] Verify success message appears
- [ ] Check confirmation email received
- [ ] Check admin notification email received
- [ ] Verify submission in Flamingo > Inbound Messages
- [ ] Verify submission in Contact > Admission Submissions

### Step 9: Test Validation
- [ ] Try submitting with empty required fields
- [ ] Try invalid email format
- [ ] Try invalid phone format
- [ ] Try age outside 2-12 range
- [ ] Try past date for start date
- [ ] Verify all validation messages work

### Step 10: Final Checks
- [ ] Form displays correctly on desktop
- [ ] Form displays correctly on mobile
- [ ] Form displays correctly on tablet
- [ ] All currency shows as Taka (৳)
- [ ] reCAPTCHA works
- [ ] No console errors in browser
- [ ] Page loads quickly

---

## Post-Deployment Testing

### Functional Testing
- [ ] Submit real test inquiry
- [ ] Verify email delivery within 1 minute
- [ ] Check email formatting is correct
- [ ] Verify data stored in database
- [ ] Test from different devices
- [ ] Test from different browsers

### Email Testing
- [ ] Admin receives notification
- [ ] Parent receives confirmation
- [ ] Emails not in spam folder
- [ ] Email formatting is correct
- [ ] All merge tags work correctly
- [ ] Reply-to address is correct

### Security Testing
- [ ] reCAPTCHA prevents spam
- [ ] Form validates all inputs
- [ ] No SQL injection possible
- [ ] No XSS vulnerabilities
- [ ] CSRF protection active

### Performance Testing
- [ ] Page loads in under 3 seconds
- [ ] Form submits in under 2 seconds
- [ ] No JavaScript errors
- [ ] No PHP errors in logs

---

## Monitoring (First Week)

### Daily Checks:
- [ ] Check for new submissions in Flamingo
- [ ] Verify emails are being delivered
- [ ] Check for spam submissions
- [ ] Monitor error logs
- [ ] Respond to inquiries promptly

### Weekly Checks:
- [ ] Review all submissions
- [ ] Check email delivery rate
- [ ] Review spam submissions
- [ ] Update FAQ if needed
- [ ] Test form functionality

---

## Troubleshooting Reference

### Form Not Displaying
1. Check shortcode ID matches form ID
2. Clear cache (browser and WordPress)
3. Verify Contact Form 7 is active
4. Check for JavaScript errors

### Emails Not Sending
1. Check spam folder
2. Verify admin email is correct
3. Install WP Mail SMTP
4. Test with WP Mail SMTP test feature
5. Check server email logs

### Validation Not Working
1. Clear browser cache
2. Check JavaScript console for errors
3. Verify form handler is loaded
4. Check functions.php includes handler

### Currency Not Displaying
1. Check UTF-8 encoding
2. Install Bengali font support
3. Use HTML entity: &#2547;
4. Clear browser cache

---

## Rollback Plan

If something goes wrong:

### Immediate Rollback:
1. Restore database from backup
2. Restore files from backup
3. Clear all caches
4. Test site functionality

### Partial Rollback:
1. Deactivate form handler (comment out in functions.php)
2. Revert to old form (if exists)
3. Keep new files for later debugging

---

## Success Criteria

Form is considered successfully deployed when:

- ✅ Form displays on Admissions page
- ✅ Form submits without errors
- ✅ Confirmation email received by parent
- ✅ Notification email received by admin
- ✅ Submission stored in Flamingo
- ✅ Submission stored in Admission Submissions
- ✅ All validation works correctly
- ✅ reCAPTCHA prevents spam
- ✅ All currency displays as Taka (৳)
- ✅ Form works on all devices
- ✅ No errors in logs

---

## Documentation

### Update These Documents:
- [ ] Internal wiki/documentation
- [ ] Staff training materials
- [ ] Admissions team procedures
- [ ] Email templates reference
- [ ] FAQ for common issues

### Share With Team:
- [ ] Admissions staff
- [ ] IT support team
- [ ] Customer service team
- [ ] Management

---

## Maintenance Schedule

### Daily:
- Monitor new submissions
- Respond to inquiries

### Weekly:
- Review spam submissions
- Check email delivery
- Test form functionality

### Monthly:
- Update reCAPTCHA keys if needed
- Review and update FAQ
- Check for plugin updates
- Test after any updates

### Quarterly:
- Review fee structure
- Update currency amounts if needed
- Review email templates
- Audit form submissions

---

## Contact Information

### For Technical Issues:
- Developer: [Your contact]
- Hosting Support: [Hosting provider]
- WordPress Support: [Support contact]

### For Content Updates:
- Admissions Director: [Contact]
- Marketing Team: [Contact]

---

## Sign-Off

### Deployment Completed By:
- Name: ___________________
- Date: ___________________
- Time: ___________________

### Tested By:
- Name: ___________________
- Date: ___________________
- Result: ☐ Pass ☐ Fail

### Approved By:
- Name: ___________________
- Date: ___________________
- Signature: ___________________

---

## Notes

Use this space for any deployment-specific notes:

```
[Add your notes here]
```

---

**Deployment Complete! 🎉**

The admission form is now live and ready to accept inquiries!
