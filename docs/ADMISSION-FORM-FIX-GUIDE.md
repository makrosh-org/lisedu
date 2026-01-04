# Admission Form Fix Guide
## Fixing Form Submission Issues & Converting to Taka Currency

### Overview
This guide will help you fix the admission form submission issues on your production server and ensure all currency is displayed in Taka (৳).

---

## Problem Summary
1. **Form not submitting** - Contact Form 7 form may not exist or is misconfigured
2. **Currency not in Taka** - Fee structure shows other currencies
3. **Email delivery issues** - Emails may not be sent properly

---

## Solution Files Created

### 1. `create-admission-form-fixed.php`
Creates a new admission form with proper configuration

### 2. `wp-content/themes/lumina-child-theme/inc/admission-form-handler.php`
Handles form validation, submission logging, and email delivery

### 3. Updated `functions.php`
Includes the form handler automatically

---

## Step-by-Step Fix Instructions

### STEP 1: Backup Your Site
```bash
# Backup database
mysqldump -u username -p database_name > backup_$(date +%Y%m%d).sql

# Backup files
tar -czf site_backup_$(date +%Y%m%d).tar.gz /path/to/wordpress
```

### STEP 2: Verify Prerequisites

#### Check Contact Form 7 Plugin
1. Login to WordPress Admin
2. Go to **Plugins** > **Installed Plugins**
3. Ensure **Contact Form 7** is installed and activated
4. If not installed:
   - Go to **Plugins** > **Add New**
   - Search for "Contact Form 7"
   - Install and activate

#### Check Flamingo Plugin (for storing submissions)
1. Go to **Plugins** > **Installed Plugins**
2. Ensure **Flamingo** is installed and activated
3. If not installed:
   - Go to **Plugins** > **Add New**
   - Search for "Flamingo"
   - Install and activate

### STEP 3: Upload Files to Production Server

#### Via FTP/SFTP:
```bash
# Upload the form creation script
upload: create-admission-form-fixed.php → /public_html/

# Upload the form handler
upload: wp-content/themes/lumina-child-theme/inc/admission-form-handler.php 
     → /public_html/wp-content/themes/lumina-child-theme/inc/

# Upload updated functions.php
upload: wp-content/themes/lumina-child-theme/functions.php
     → /public_html/wp-content/themes/lumina-child-theme/
```

#### Via cPanel File Manager:
1. Login to cPanel
2. Open **File Manager**
3. Navigate to `public_html`
4. Upload `create-admission-form-fixed.php`
5. Navigate to `public_html/wp-content/themes/lumina-child-theme/inc/`
6. Create `inc` folder if it doesn't exist
7. Upload `admission-form-handler.php`
8. Navigate to `public_html/wp-content/themes/lumina-child-theme/`
9. Upload `functions.php` (replace existing)

### STEP 4: Create the Admission Form

#### Option A: Via SSH (Recommended)
```bash
# SSH into your server
ssh username@your-server.com

# Navigate to WordPress root
cd /path/to/public_html

# Run the script
php create-admission-form-fixed.php
```

#### Option B: Via Browser (if SSH not available)
1. Create a file `run-form-creation.php` in your WordPress root:
```php
<?php
require_once 'create-admission-form-fixed.php';
```
2. Visit: `https://your-domain.com/run-form-creation.php`
3. **IMPORTANT**: Delete `run-form-creation.php` after running!

#### Option C: Via WP-CLI
```bash
wp eval-file create-admission-form-fixed.php
```

### STEP 5: Configure reCAPTCHA (Important for spam protection)

1. Get reCAPTCHA keys from Google:
   - Visit: https://www.google.com/recaptcha/admin
   - Register your site
   - Choose reCAPTCHA v2 "I'm not a robot" checkbox
   - Get Site Key and Secret Key

2. Configure in WordPress:
   - Go to **Contact** > **Integration**
   - Click **Configure** under reCAPTCHA
   - Enter your Site Key
   - Enter your Secret Key
   - Click **Save**

### STEP 6: Update Admissions Page

1. Go to **Pages** > **All Pages**
2. Find and edit the **Admissions** page
3. Find the admission form section
4. Replace the old shortcode with the new one:
   ```
   [contact-form-7 id="XX" title="Lumina Admission Inquiry Form"]
   ```
   (Replace XX with the form ID shown after running the creation script)

5. **Save** the page

### STEP 7: Fix Currency to Taka

#### Update Fee Structure on Admissions Page

1. Edit the **Admissions** page in Elementor
2. Find the **Fee Structure** section
3. Update all currency symbols to **৳** (Taka symbol)
4. Example fee structure:

```
Grade Level          | Registration Fee | Annual Tuition
---------------------|------------------|----------------
Play Group (2-3)     | ৳ 10,000        | ৳ 150,000
Nursery (3-4)        | ৳ 10,000        | ৳ 160,000
Kindergarten (4-5)   | ৳ 12,000        | ৳ 180,000
Grade 1 (5-6)        | ৳ 12,000        | ৳ 200,000
Grade 2 (6-7)        | ৳ 12,000        | ৳ 210,000
Grade 3 (7-8)        | ৳ 15,000        | ৳ 220,000
Grade 4 (8-9)        | ৳ 15,000        | ৳ 230,000
Grade 5 (9-10)       | ৳ 15,000        | ৳ 240,000
```

#### Additional Fees (in Taka):
- Books & Materials: ৳ 15,000 - ৳ 25,000 per year
- Uniform: ৳ 8,000 - ৳ 12,000
- Transportation (optional): ৳ 30,000 - ৳ 50,000 per year
- Lunch Program (optional): ৳ 25,000 per year
- Extracurricular Activities: ৳ 10,000 - ৳ 20,000 per year

5. **Update** and **Publish** the page

### STEP 8: Configure Email Settings

#### Option A: Use SMTP Plugin (Recommended)
1. Install **WP Mail SMTP** plugin
2. Go to **WP Mail SMTP** > **Settings**
3. Configure with your email provider:
   - Gmail
   - SendGrid
   - Mailgun
   - Your hosting SMTP

#### Option B: Use Default WordPress Mail
The form handler already includes fixes for default WordPress mail.

### STEP 9: Test the Form

1. **Visit the Admissions page** on your live site
2. **Fill out the form** with test data:
   - Parent Name: Test Parent
   - Email: your-test-email@example.com
   - Phone: +880 1XXX-XXXXXX
   - Student Name: Test Student
   - Age: 5
   - Grade Level: Grade 1
   - Start Date: Future date
   - Comments: This is a test submission

3. **Submit the form**

4. **Verify**:
   - ✓ Success message appears
   - ✓ Confirmation email received at parent's email
   - ✓ Notification email received at admin email
   - ✓ Submission appears in **Flamingo** > **Inbound Messages**
   - ✓ Submission appears in **Contact** > **Admission Submissions**

### STEP 10: Monitor Submissions

#### View in Flamingo:
1. Go to **Flamingo** > **Inbound Messages**
2. See all form submissions with full details

#### View in Custom Admin Page:
1. Go to **Contact** > **Admission Submissions**
2. See table of all submissions

#### Check Debug Log:
If WP_DEBUG_LOG is enabled, check `wp-content/debug.log` for submission logs

---

## Troubleshooting

### Issue 1: Form doesn't display
**Solution:**
- Check that Contact Form 7 plugin is active
- Verify the shortcode ID matches the created form
- Clear cache (browser and WordPress cache plugins)

### Issue 2: Form submits but no emails received
**Solutions:**
1. Check spam folder
2. Install WP Mail SMTP plugin
3. Test email with WP Mail SMTP test feature
4. Check server email logs
5. Verify admin email in **Settings** > **General**

### Issue 3: reCAPTCHA not working
**Solutions:**
- Verify reCAPTCHA keys are correct
- Check domain is registered in Google reCAPTCHA
- Clear browser cache
- Try different browser

### Issue 4: Validation errors
**Solutions:**
- Phone format: Use +880 1XXX-XXXXXX or 01XXX-XXXXXX
- Age: Must be between 2-12
- Start date: Must be future date
- All required fields must be filled

### Issue 5: Submissions not stored
**Solutions:**
- Activate Flamingo plugin
- Check database permissions
- View submissions in **Contact** > **Admission Submissions**

### Issue 6: Currency symbol not showing
**Solutions:**
- Use HTML entity: `&#2547;` for ৳
- Or copy-paste: ৳
- Ensure UTF-8 encoding in database and files

---

## Phone Number Format for Bangladesh

The form accepts these formats:
- `+880 1XXX-XXXXXX` (with country code)
- `01XXX-XXXXXX` (without country code)
- `+8801XXXXXXXXX` (no spaces)
- `01XXXXXXXXX` (no spaces)

Valid prefixes: 013, 014, 015, 016, 017, 018, 019

---

## Email Templates

### Admin Notification Email
```
New Admission Inquiry Received

PARENT/GUARDIAN INFORMATION:
Name: [parent-name]
Email: [parent-email]
Phone: [parent-phone]

STUDENT INFORMATION:
Student Name: [student-name]
Age: [student-age] years
Grade Level: [grade-level]
Preferred Start Date: [start-date]

ADDITIONAL COMMENTS:
[comments]
```

### Parent Confirmation Email
```
Dear [parent-name],

Thank you for your interest in Lumina International School!

We have received your admission inquiry for [student-name].

NEXT STEPS:
1. Our admissions team will review your inquiry
2. You will receive a response within 1-2 business days
3. We may contact you to schedule a campus tour

Best regards,
Lumina International School Admissions Team
```

---

## Security Features

✓ reCAPTCHA spam protection
✓ Server-side validation
✓ Input sanitization
✓ CSRF protection via WordPress nonces
✓ SQL injection prevention
✓ XSS prevention
✓ Phone number format validation
✓ Age range validation
✓ Date validation

---

## Maintenance Tasks

### Weekly:
- Check **Flamingo** > **Inbound Messages** for new submissions
- Respond to inquiries within 1-2 business days

### Monthly:
- Review spam submissions
- Update reCAPTCHA keys if needed
- Test form functionality
- Check email delivery rates

### After WordPress/Plugin Updates:
- Test form submission
- Verify email delivery
- Check reCAPTCHA functionality

---

## Additional Customization

### Change Admin Email:
1. Go to **Contact** > **Contact Forms**
2. Click **Lumina Admission Inquiry Form**
3. Go to **Mail** tab
4. Update **To** field
5. **Save**

### Add Multiple Recipients:
In the **To** field, separate emails with commas:
```
admin@school.com, admissions@school.com, principal@school.com
```

### Customize Messages:
1. Go to **Contact** > **Contact Forms**
2. Click **Lumina Admission Inquiry Form**
3. Go to **Messages** tab
4. Edit any message
5. **Save**

### Add More Fields:
1. Edit the form in **Contact** > **Contact Forms**
2. Add field tags in the **Form** tab
3. Update email templates in **Mail** tab
4. **Save**

---

## Support

If you encounter issues:
1. Check WordPress debug.log
2. Check server error logs
3. Test with WP Mail SMTP test feature
4. Verify all plugins are updated
5. Check file permissions (644 for files, 755 for directories)

---

## Success Checklist

- [ ] Contact Form 7 plugin installed and activated
- [ ] Flamingo plugin installed and activated
- [ ] Form creation script executed successfully
- [ ] Form handler uploaded and included in functions.php
- [ ] reCAPTCHA configured
- [ ] Admissions page updated with new shortcode
- [ ] All currency changed to Taka (৳)
- [ ] Test submission completed successfully
- [ ] Confirmation email received
- [ ] Admin notification email received
- [ ] Submission visible in Flamingo
- [ ] Submission visible in Admission Submissions page

---

## Form is Now Ready! 🎉

Your admission form should now be working properly with:
- ✓ Proper form submission
- ✓ Email notifications
- ✓ Database storage
- ✓ Spam protection
- ✓ Taka currency (৳)
- ✓ Bangladesh phone format
- ✓ Comprehensive validation
