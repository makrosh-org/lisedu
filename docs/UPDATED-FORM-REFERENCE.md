# Updated Admission Form Reference

## What's New

The `create-admission-form-fixed.php` has been updated to include:

✅ **File Upload Field** - Student photo upload (optional)
✅ **File Validation** - 2MB limit, JPG/PNG/PDF only
✅ **Email Integration** - File attached to admin notification
✅ **Enhanced Styling** - Dashed border for file input
✅ **Error Messages** - File upload specific errors

---

## Updated Form Fields

### 1. Parent/Guardian Information
- Parent/Guardian Name * (text)
- Email Address * (email)
- Phone Number * (tel)

### 2. Student Information
- Student Name * (text)
- Student Age * (number, 2-12)
- Grade Level Interested * (select)
- Preferred Start Date * (date)

### 3. Additional Information
- **Student Photo (file) - NEW!** ⭐
  - Optional field
  - Max size: 2MB
  - Formats: JPG, JPEG, PNG, PDF
- Additional Comments or Questions (textarea)

### 4. Security
- reCAPTCHA (required)

---

## File Upload Specifications

### Field Configuration:
```
[file student-photo id:student-photo class:form-control limit:2mb filetypes:jpg|jpeg|png|pdf]
```

### Settings:
- **Field Name:** student-photo
- **Required:** No (optional)
- **Max Size:** 2MB (2097152 bytes)
- **Allowed Types:** JPG, JPEG, PNG, PDF
- **Multiple Files:** No (single file only)

### Validation Messages:
- File too large: "The file is too large. Maximum size is 2MB."
- Invalid type: "This file type is not allowed."
- Upload failed: "There was an error uploading the file."

---

## How to Use

### Method 1: Create New Form (Recommended)

If you haven't created the form yet or want to recreate it:

```bash
# Upload the updated file to your server
# Then run:
php create-admission-form-fixed.php
```

This will:
1. Delete old form (if exists)
2. Create new form with file upload
3. Configure email templates
4. Set up validation messages
5. Display form ID and shortcode

### Method 2: Update Existing Form Manually

If you already have a form and want to add file upload:

1. Go to **Contact** > **Contact Forms**
2. Edit your **Lumina Admission Inquiry Form**
3. In the **Form** tab, add this code after the comments field:

```html
<div class="form-row">
    <label for="student-photo">Student Photo (Optional)</label>
    [file student-photo id:student-photo class:form-control limit:2mb filetypes:jpg|jpeg|png|pdf]
    <small style="color: #666; font-size: 0.85rem; display: block; margin-top: 5px;">Maximum file size: 2MB. Accepted formats: JPG, PNG, PDF</small>
</div>
```

4. In the **Mail** tab, add this line to the body:
```
Student Photo: [student-photo]
```

5. Save the form

---

## Email Template Updates

### Admin Notification Email:

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
Student Photo: [student-photo]          ← NEW!

ADDITIONAL COMMENTS:
[comments]

---
Submitted on: [_date] at [_time]
From IP: [_remote_ip]
User Agent: [_user_agent]
```

The `[student-photo]` tag will:
- Show file name if uploaded
- Show download link in email
- Attach file to email (if email server supports)
- Show "No file uploaded" if field left empty

---

## CSS Styling Updates

The `admission-form.css` has been updated with:

```css
/* File Upload Styling */
.lumina-admission-form input[type="file"] {
    padding: 10px;
    border: 2px dashed #e0e0e0;
    background-color: #fafafa;
    cursor: pointer;
}

.lumina-admission-form input[type="file"]:hover {
    border-color: var(--base-accent-teal);
    background-color: rgba(126, 190, 197, 0.05);
}

.lumina-admission-form input[type="file"]:focus {
    border-color: var(--base-accent-teal);
    border-style: solid;
}

.lumina-admission-form .form-row small {
    display: block;
    margin-top: 5px;
    color: #666;
    font-size: 0.85rem;
}
```

---

## Testing the File Upload

### Test Checklist:

1. **Valid File Upload:**
   - [ ] Upload JPG file (< 2MB)
   - [ ] Upload PNG file (< 2MB)
   - [ ] Upload PDF file (< 2MB)
   - [ ] Form submits successfully
   - [ ] File appears in email

2. **File Size Validation:**
   - [ ] Try uploading file > 2MB
   - [ ] Should show error: "The file is too large"
   - [ ] Form should not submit

3. **File Type Validation:**
   - [ ] Try uploading .exe file
   - [ ] Try uploading .zip file
   - [ ] Should show error: "This file type is not allowed"
   - [ ] Form should not submit

4. **Optional Field:**
   - [ ] Submit form without file
   - [ ] Should submit successfully
   - [ ] Email should show "No file uploaded" or empty

5. **Email Delivery:**
   - [ ] Check admin email received
   - [ ] Check file is attached or linked
   - [ ] Check file can be downloaded
   - [ ] Check confirmation email sent to parent

---

## File Storage

### Where Files Are Stored:

Contact Form 7 stores uploaded files temporarily in:
```
wp-content/uploads/wpcf7_uploads/
```

**Important Notes:**
- Files are **temporary** by default
- Files are deleted after email is sent
- For permanent storage, use **Flamingo** plugin
- Flamingo stores files in database and keeps them

### To Keep Files Permanently:

1. Install **Flamingo** plugin
2. Activate it
3. Files will be stored with each submission
4. Access via: **Flamingo** > **Inbound Messages**
5. Download files from there anytime

---

## Security Considerations

### File Upload Security:

✅ **File Size Limit:** Prevents server overload
✅ **File Type Restriction:** Only images and PDFs allowed
✅ **Server-Side Validation:** Contact Form 7 validates on server
✅ **Temporary Storage:** Files deleted after processing
✅ **No Direct Access:** Files not publicly accessible

### Recommended Additional Security:

1. **Install Security Plugin:**
   - Wordfence
   - Sucuri Security
   - iThemes Security

2. **Scan Uploaded Files:**
   Most security plugins scan uploads automatically

3. **Limit Upload Directory Permissions:**
   ```bash
   chmod 755 wp-content/uploads/
   ```

4. **Add .htaccess Protection:**
   ```apache
   <Files *.php>
   deny from all
   </Files>
   ```

---

## Troubleshooting

### File Upload Not Working:

**Problem:** File field doesn't appear
**Solution:**
- Clear browser cache
- Clear WordPress cache
- Regenerate form (run script again)

**Problem:** "Upload failed" error
**Solution:**
- Check PHP upload_max_filesize setting
- Check PHP post_max_size setting
- Check server disk space
- Check folder permissions

**Problem:** File not in email
**Solution:**
- Check Mail tab has [student-photo] tag
- Some email servers block attachments
- Check spam folder
- Try different email address

**Problem:** File too large error (but file is small)
**Solution:**
- Check server PHP settings:
  ```
  upload_max_filesize = 10M
  post_max_size = 10M
  ```
- Contact hosting support to increase limits

---

## Server Requirements

### PHP Settings Required:

```ini
file_uploads = On
upload_max_filesize = 10M
post_max_size = 10M
max_execution_time = 300
memory_limit = 256M
```

### Check Your Settings:

Create a file `phpinfo.php`:
```php
<?php phpinfo(); ?>
```

Upload to server and visit: `yourdomain.com/phpinfo.php`

Look for:
- file_uploads
- upload_max_filesize
- post_max_size

**Delete the file after checking!**

---

## Customization Options

### Change File Size Limit:

```
[file student-photo limit:5mb ...]
                          ^^^
                     Change this
```

### Change Allowed File Types:

```
[file student-photo ... filetypes:jpg|png|gif|pdf|doc|docx]
                                  ^^^^^^^^^^^^^^^^^^^^^^^^^^^
                                  Add or remove types
```

### Make File Required:

```
[file* student-photo ...]
     ^
     Add asterisk
```

### Allow Multiple Files:

```
[file student-photo ... multiple]
                        ^^^^^^^^
                        Add this
```

### Change Field Label:

```html
<label for="student-photo">Upload Documents *</label>
                           ^^^^^^^^^^^^^^^^^^
                           Change this
```

---

## Complete Form Code

The complete updated form code is in `create-admission-form-fixed.php`

To view just the form HTML:
```bash
grep -A 100 "form_html = <<<'FORM'" create-admission-form-fixed.php
```

---

## Quick Commands

### Create/Recreate Form:
```bash
php create-admission-form-fixed.php
```

### Test Form:
```bash
php test-admission-form.php
```

### Check PHP Upload Settings:
```bash
php -i | grep upload
```

### Check Folder Permissions:
```bash
ls -la wp-content/uploads/
```

---

## Support Resources

### Documentation:
- Contact Form 7: https://contactform7.com/file-uploading-and-attachment/
- Flamingo: https://wordpress.org/plugins/flamingo/
- reCAPTCHA: https://www.google.com/recaptcha/

### Related Files:
- `create-admission-form-fixed.php` - Form creation script
- `admission-form-handler.php` - Form validation handler
- `admission-form.css` - Form styling
- `ADD-FILE-UPLOAD-AND-RECAPTCHA-GUIDE.md` - Detailed guide

---

## Version History

### Version 2.0 (Current)
- ✅ Added file upload field
- ✅ Updated email templates
- ✅ Added file validation messages
- ✅ Enhanced CSS styling
- ✅ Updated documentation

### Version 1.0
- Initial release
- Basic form fields
- Email notifications
- reCAPTCHA support

---

**Your admission form now supports file uploads! 🎉**

Run `php create-admission-form-fixed.php` to create/update the form.
