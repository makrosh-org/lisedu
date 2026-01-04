# Adding File Upload & reCAPTCHA to Admission Form

## Part 1: Adding File Upload Field

### Step 1: Edit Your Form

1. Go to **Contact** > **Contact Forms**
2. Click on **Lumina Admission Inquiry Form**
3. You'll see the **Form** tab (should be selected by default)

### Step 2: Add File Upload Code

Find this section in your form:
```
<div class="form-row">
    <label for="comments">Additional Comments or Questions</label>
    [textarea comments id:comments class:form-control ...]
</div>
```

**Right after that section**, add this code:

```html
<div class="form-row">
    <label for="student-photo">Student Photo (Optional)</label>
    [file student-photo id:student-photo class:form-control limit:2mb filetypes:jpg|jpeg|png|pdf]
    <small style="color: #666; font-size: 0.85rem;">Max file size: 2MB. Accepted formats: JPG, PNG, PDF</small>
</div>
```

### File Upload Options Explained:

```
[file student-photo limit:2mb filetypes:jpg|jpeg|png|pdf]
      │            │         │
      │            │         └─ Allowed file types
      │            └─ Maximum file size
      └─ Field name
```

**To make it required:**
```
[file* student-photo ...]
     ^
     Add asterisk
```

**To allow multiple files:**
```
[file student-photo limit:2mb filetypes:jpg|jpeg|png|pdf multiple]
                                                              ^
                                                              Add this
```

**To change file size limit:**
```
limit:5mb    (5 megabytes)
limit:1mb    (1 megabyte)
limit:500kb  (500 kilobytes)
```

### Step 3: Update Email Template

1. Click the **Mail** tab
2. Find the **Message Body** field
3. Add this line where you want the file link to appear:

```
Student Photo: [student-photo]
```

**Complete Email Body Example:**
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
Student Photo: [student-photo]

ADDITIONAL COMMENTS:
[comments]

---
Submitted on: [_date] at [_time]
From IP: [_remote_ip]
```

### Step 4: Configure File Upload Settings (Optional)

Go to **Contact** > **Contact Forms** > **Settings** (if available)

Or add this to your form's **Additional Settings** tab:

```
# Maximum file size (in bytes)
# 2MB = 2097152 bytes
# 5MB = 5242880 bytes
file_size_limit: 2097152

# Allowed file types
file_types: jpg jpeg png gif pdf doc docx
```

### Step 5: Save the Form

Click **Save** button at the bottom

---

## Part 2: Setting Up reCAPTCHA

### Step 1: Get reCAPTCHA Keys from Google

#### A. Visit Google reCAPTCHA Admin
Go to: https://www.google.com/recaptcha/admin/create

#### B. Fill Out the Registration Form

```
┌─────────────────────────────────────────────┐
│ Register a new site                         │
├─────────────────────────────────────────────┤
│                                             │
│ Label:                                      │
│ ┌─────────────────────────────────────┐    │
│ │ Lumina School Admission Form        │    │
│ └─────────────────────────────────────┘    │
│                                             │
│ reCAPTCHA type:                            │
│ ○ reCAPTCHA v3                             │
│ ● reCAPTCHA v2                             │
│   ☑ "I'm not a robot" Checkbox             │ ← Select this
│   ☐ Invisible reCAPTCHA badge              │
│                                             │
│ Domains:                                    │
│ ┌─────────────────────────────────────┐    │
│ │ yourdomain.com                      │    │ ← Your actual domain
│ │ www.yourdomain.com                  │    │
│ │ lisedu.test                         │    │ ← If testing locally
│ └─────────────────────────────────────┘    │
│                                             │
│ Owners:                                     │
│ ┌─────────────────────────────────────┐    │
│ │ your-email@gmail.com                │    │
│ └─────────────────────────────────────┘    │
│                                             │
│ ☑ Accept the reCAPTCHA Terms of Service    │
│                                             │
│ [ Submit ]                                  │
└─────────────────────────────────────────────┘
```

#### C. Copy Your Keys

After submitting, you'll see:

```
┌─────────────────────────────────────────────┐
│ Adding reCAPTCHA to your site               │
├─────────────────────────────────────────────┤
│                                             │
│ Site Key                                    │
│ ┌─────────────────────────────────────┐    │
│ │ 6LcXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX │    │ ← Copy this
│ └─────────────────────────────────────┘    │
│                                             │
│ Secret Key                                  │
│ ┌─────────────────────────────────────┐    │
│ │ 6LcYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYY │    │ ← Copy this
│ └─────────────────────────────────────┘    │
└─────────────────────────────────────────────┘
```

**Important:** Keep these keys safe! Don't share them publicly.

### Step 2: Add Keys to WordPress

#### A. Go to Integration Page

In WordPress Admin:
1. Go to **Contact** > **Integration**
2. Find **reCAPTCHA** section
3. Click **Configure** (or **Setup Integration**)

#### B. Enter Your Keys

```
┌─────────────────────────────────────────────┐
│ reCAPTCHA                                   │
├─────────────────────────────────────────────┤
│                                             │
│ Site Key                                    │
│ ┌─────────────────────────────────────┐    │
│ │ [Paste Site Key here]               │    │
│ └─────────────────────────────────────┘    │
│                                             │
│ Secret Key                                  │
│ ┌─────────────────────────────────────┐    │
│ │ [Paste Secret Key here]             │    │
│ └─────────────────────────────────────┘    │
│                                             │
│ [ Save Changes ]                            │
└─────────────────────────────────────────────┘
```

#### C. Save Changes

Click **Save Changes** button

### Step 3: Add reCAPTCHA to Your Form

Your form already has `[recaptcha]` tag, so you're good!

If not, add this before the submit button:

```html
<div class="captcha-row">
    [recaptcha]
</div>
```

### Step 4: Test reCAPTCHA

1. **Visit your Admissions page**
2. **Scroll to the form**
3. **You should see:**
   ```
   ┌─────────────────────────────────┐
   │ ☐ I'm not a robot               │
   │                                 │
   │    [reCAPTCHA logo]             │
   └─────────────────────────────────┘
   ```

4. **Test without checking:**
   - Fill out form
   - Don't check reCAPTCHA
   - Click Submit
   - Should show error: "Please complete the CAPTCHA"

5. **Test with checking:**
   - Fill out form
   - Check the reCAPTCHA box
   - Click Submit
   - Should submit successfully

---

## Troubleshooting

### File Upload Issues

#### Problem: File upload field doesn't appear
**Solution:**
- Clear browser cache
- Clear WordPress cache
- Check form code is saved correctly

#### Problem: File too large error
**Solution:**
- Increase limit in form: `limit:5mb`
- Or check server PHP settings:
  ```
  upload_max_filesize = 10M
  post_max_size = 10M
  ```

#### Problem: File type not allowed
**Solution:**
- Add file type to allowed list:
  ```
  filetypes:jpg|jpeg|png|gif|pdf|doc|docx
  ```

#### Problem: Files not received in email
**Solution:**
- Check Mail tab has `[student-photo]` tag
- Files are sent as attachments
- Check email spam folder
- Some email servers block attachments

### reCAPTCHA Issues

#### Problem: reCAPTCHA doesn't appear
**Solutions:**
1. Check keys are entered correctly
2. Check domain is registered in Google reCAPTCHA
3. Clear browser cache
4. Check browser console for errors
5. Verify `[recaptcha]` tag is in form

#### Problem: "ERROR for site owner: Invalid site key"
**Solution:**
- Site Key is incorrect
- Re-copy from Google reCAPTCHA admin
- Make sure no extra spaces

#### Problem: "ERROR for site owner: Invalid domain"
**Solution:**
- Add your domain to Google reCAPTCHA admin
- Include both www and non-www versions
- For local testing, add: localhost or lisedu.test

#### Problem: reCAPTCHA shows but doesn't validate
**Solution:**
- Secret Key is incorrect
- Re-enter Secret Key in WordPress
- Check for typos or extra spaces

#### Problem: reCAPTCHA in wrong language
**Solution:**
- reCAPTCHA auto-detects language from browser
- Or add to Additional Settings:
  ```
  recaptcha_lang: "en"
  ```

---

## File Upload Best Practices

### Recommended Settings:

```
[file student-photo limit:2mb filetypes:jpg|jpeg|png|pdf]
```

**Why these settings?**
- **2MB limit:** Good balance between quality and upload speed
- **JPG/PNG:** Standard image formats
- **PDF:** For scanned documents

### Security Considerations:

1. **Limit file size** - Prevents server overload
2. **Restrict file types** - Prevents malicious uploads
3. **Scan uploaded files** - Use security plugin
4. **Store securely** - WordPress handles this automatically

### File Storage:

- Files are stored in: `wp-content/uploads/wpcf7_uploads/`
- Files are temporary (deleted after email sent)
- For permanent storage, use Flamingo plugin

---

## reCAPTCHA Best Practices

### Version Comparison:

**reCAPTCHA v2 (Recommended for forms):**
- ✓ User clicks "I'm not a robot"
- ✓ Clear visual feedback
- ✓ Good spam protection
- ✓ Works with Contact Form 7

**reCAPTCHA v3 (Not recommended for CF7):**
- Invisible to users
- Scores user behavior
- Requires custom integration

### Privacy Considerations:

- reCAPTCHA collects user data
- Add to Privacy Policy:
  ```
  "This site uses Google reCAPTCHA to protect against spam.
  Google's Privacy Policy and Terms of Service apply."
  ```

---

## Complete Form Code with File Upload

Copy this entire code to your Form tab:

```html
<div class="lumina-admission-form">
    <div class="form-section">
        <h3 class="form-section-title">Parent/Guardian Information</h3>
        
        <div class="form-row">
            <label for="parent-name">Parent/Guardian Name *</label>
            [text* parent-name id:parent-name class:form-control placeholder "Full Name"]
        </div>
        
        <div class="form-row">
            <label for="parent-email">Email Address *</label>
            [email* parent-email id:parent-email class:form-control placeholder "your.email@example.com"]
        </div>
        
        <div class="form-row">
            <label for="parent-phone">Phone Number *</label>
            [tel* parent-phone id:parent-phone class:form-control placeholder "+880 1XXX-XXXXXX"]
        </div>
    </div>
    
    <div class="form-section">
        <h3 class="form-section-title">Student Information</h3>
        
        <div class="form-row">
            <label for="student-name">Student Name *</label>
            [text* student-name id:student-name class:form-control placeholder "Student's Full Name"]
        </div>
        
        <div class="form-row">
            <label for="student-age">Student Age *</label>
            [number* student-age id:student-age class:form-control min:2 max:12 placeholder "Age"]
        </div>
        
        <div class="form-row">
            <label for="grade-level">Grade Level Interested *</label>
            [select* grade-level id:grade-level class:form-control "Select Grade Level" "Play Group (Ages 2-3)" "Nursery (Ages 3-4)" "Kindergarten (Ages 4-5)" "Grade 1 (Ages 5-6)" "Grade 2 (Ages 6-7)" "Grade 3 (Ages 7-8)" "Grade 4 (Ages 8-9)" "Grade 5 (Ages 9-10)"]
        </div>
        
        <div class="form-row">
            <label for="start-date">Preferred Start Date *</label>
            [date* start-date id:start-date class:form-control]
        </div>
        
        <div class="form-row">
            <label for="student-photo">Student Photo (Optional)</label>
            [file student-photo id:student-photo class:form-control limit:2mb filetypes:jpg|jpeg|png|pdf]
            <small style="color: #666; font-size: 0.85rem; display: block; margin-top: 5px;">Max file size: 2MB. Accepted formats: JPG, PNG, PDF</small>
        </div>
    </div>
    
    <div class="form-section">
        <h3 class="form-section-title">Additional Information</h3>
        
        <div class="form-row">
            <label for="comments">Additional Comments or Questions</label>
            [textarea comments id:comments class:form-control placeholder "Please share any additional information or questions you may have..." rows:5]
        </div>
    </div>
    
    <div class="captcha-row">
        [recaptcha]
    </div>
    
    <div class="submit-row">
        [submit class:btn-primary "SUBMIT INQUIRY"]
    </div>
</div>
```

---

## Testing Checklist

### File Upload Testing:
- [ ] Upload field appears on form
- [ ] Can select file
- [ ] File size validation works (try >2MB file)
- [ ] File type validation works (try .exe file)
- [ ] File appears in email as attachment
- [ ] Form submits successfully with file

### reCAPTCHA Testing:
- [ ] reCAPTCHA checkbox appears
- [ ] Cannot submit without checking
- [ ] Can submit after checking
- [ ] Error message shows if not checked
- [ ] Works on mobile devices
- [ ] Works in different browsers

---

## Quick Reference

### File Upload Tag:
```
[file field-name limit:2mb filetypes:jpg|png|pdf]
[file* field-name ...]  (required)
[file field-name ... multiple]  (multiple files)
```

### reCAPTCHA Tag:
```
[recaptcha]
```

### Get reCAPTCHA Keys:
https://www.google.com/recaptcha/admin/create

### Add Keys:
Contact > Integration > reCAPTCHA > Configure

---

**Your form is now complete with file upload and spam protection! 🎉**
