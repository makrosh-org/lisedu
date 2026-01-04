# Local Setup Steps for Admission Form

## ✅ What's Done:

- ✅ Form created with ID: **137** (recreated to fix encoding issues)
- ✅ Form has all fields (parent info, student info, file upload, textarea, reCAPTCHA)
- ✅ Contact Form 7 is active
- ✅ Flamingo is active
- ✅ All quote characters verified as straight quotes (no curly quotes)

---

## 🔧 What You Need to Do:

### Step 1: Update Admissions Page with New Shortcode

1. **Open your browser** and go to: http://lisedu.test/wp-admin
2. **Login** to WordPress
3. Go to **Pages** > **All Pages**
4. Find **Admissions** page
5. Click **Edit with Elementor**
6. Find the **Shortcode widget** with the old form
7. **Update the shortcode** to:
   ```
   [contact-form-7 id="137" title="Lumina Admission Inquiry Form"]
   ```
8. Click **Update** (green button, bottom left)

---

### Step 2: Configure reCAPTCHA (Optional for Local Testing)

For local testing, you can skip reCAPTCHA or use test keys:

#### Option A: Skip reCAPTCHA for Local Testing
1. Go to **Contact** > **Contact Forms**
2. Click on **Lumina Admission Inquiry Form** (ID: 137)
3. In the **Form** tab, find this line:
   ```
   <div class="captcha-row">
   [recaptcha]
   </div>
   ```
4. **Comment it out** temporarily:
   ```
   <!-- <div class="captcha-row">
   [recaptcha]
   </div> -->
   ```
5. Click **Save**

#### Option B: Use Test reCAPTCHA Keys
1. Go to https://www.google.com/recaptcha/admin/create
2. Register a site with:
   - **Label:** Lumina Local Test
   - **Type:** reCAPTCHA v2 "I'm not a robot"
   - **Domains:** `lisedu.test` and `localhost`
3. Copy the Site Key and Secret Key
4. In WordPress, go to **Contact** > **Integration**
5. Click **Configure** under reCAPTCHA
6. Paste your keys
7. Click **Save Changes**

---

### Step 3: Test the Form

1. **Visit:** http://lisedu.test/admissions/
2. **Scroll to the form**
3. **Check that you see:**
   - ✅ All text fields
   - ✅ Dropdown for grade level
   - ✅ Date picker
   - ✅ File upload field
   - ✅ **Textarea** (should be a text box, not showing as `[textarea...]`)
   - ✅ **reCAPTCHA** checkbox (if configured)
   - ✅ Submit button

4. **Fill out the form** with test data:
   - Parent Name: Test Parent
   - Email: test@example.com
   - Phone: +880 1234-567890
   - Student Name: Test Student
   - Age: 5
   - Grade: Grade 1
   - Start Date: Any future date
   - Upload a small image (optional)
   - Comments: This is a test

5. **Submit the form**

6. **Check for:**
   - ✅ Success message appears
   - ✅ No errors
   - ✅ Form clears after submission

---

### Step 4: Verify Submission Storage

1. Go to **Flamingo** > **Inbound Messages**
2. You should see your test submission
3. Click on it to view details

---

## 🐛 Troubleshooting:

### If Textarea Still Shows as Text:

1. Go to **Contact** > **Contact Forms**
2. Click on your form (ID: 137)
3. In the **Form** tab, find the textarea line
4. Make sure it looks EXACTLY like this (no extra spaces, straight quotes):
   ```
   [textarea comments id:comments class:form-control placeholder "Please share any additional information or questions you may have..." rows:5]
   ```
5. If it looks different, **delete that line** and use the form tag generator:
   - Click the **[textarea]** button above the form field
   - Fill in the fields
   - Click **Insert Tag**
6. Click **Save**
7. Clear browser cache (Ctrl+Shift+R)
8. Test again

### If reCAPTCHA Doesn't Show:

1. Make sure you configured the keys in **Contact** > **Integration**
2. Make sure `lisedu.test` is in your Google reCAPTCHA domains
3. Clear browser cache
4. Try in incognito window

### If Form Doesn't Display at All:

1. Check the shortcode ID matches: `[contact-form-7 id="137"...]`
2. Make sure you're using the **Shortcode widget** in Elementor (not Text Editor)
3. Clear Elementor cache: **Elementor** > **Tools** > **Regenerate CSS**

---

## 📋 Quick Checklist:

- [ ] Update Admissions page with shortcode `[contact-form-7 id="137"...]`
- [ ] Configure reCAPTCHA (or comment it out for testing)
- [ ] Visit http://lisedu.test/admissions/
- [ ] Verify textarea shows as a text box (not `[textarea...]`)
- [ ] Verify reCAPTCHA shows (if configured)
- [ ] Fill out and submit test form
- [ ] Check success message
- [ ] Verify submission in Flamingo
- [ ] Test file upload works
- [ ] Test on mobile view (responsive)

---

## ✅ Once Working Locally:

After everything works on http://lisedu.test/admissions/:

1. **Export the form:**
   - Go to **Contact** > **Contact Forms**
   - Click on your form
   - Copy the entire **Form** tab content
   - Save it to a text file

2. **Note the configuration:**
   - reCAPTCHA keys (if using)
   - Email settings
   - Any customizations

3. **Deploy to production:**
   - Upload `create-admission-form-fixed.php` to production
   - Run it on production server
   - Configure reCAPTCHA with production domain
   - Update Admissions page with new form ID
   - Test on production

---

## 🎯 Current Status:

**Form ID:** 137 (recreated with clean encoding)
**Shortcode:** `[contact-form-7 id="137" title="Lumina Admission Inquiry Form"]`
**Local URL:** http://lisedu.test/admissions/

**Next:** Update the Admissions page with the new shortcode and test!
