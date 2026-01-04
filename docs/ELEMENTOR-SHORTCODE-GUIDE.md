# How to Add Admission Form Shortcode in Elementor

## Step-by-Step Visual Guide

### Step 1: Open Page in Elementor
```
WordPress Admin → Pages → All Pages → Admissions → Edit with Elementor
```

### Step 2: Locate the Form Section
Look for a section titled "Start Your Application" or "Admission Form"

### Step 3: Add Shortcode Widget

#### Option A: Replace Existing Content
If there's already a placeholder or old form:
1. Click on the existing widget
2. Delete it (trash icon)
3. Add new Shortcode widget

#### Option B: Add to New Section
1. Click the **"+"** icon (Add New Section)
2. Choose column layout (1 column recommended)
3. Click **"+"** inside the column

### Step 4: Find Shortcode Widget
```
┌─────────────────────────────────┐
│  Search widgets...              │
│  ┌───────────────────────────┐  │
│  │ shortcode                 │  │
│  └───────────────────────────┘  │
│                                 │
│  📄 Shortcode                   │  ← Click this
│  📝 Text Editor                 │
│  🔤 HTML                        │
└─────────────────────────────────┘
```

### Step 5: Configure Shortcode Widget

Left panel will show:
```
┌─────────────────────────────────┐
│  SHORTCODE                      │
│  ─────────────────────────────  │
│                                 │
│  Shortcode                      │
│  ┌───────────────────────────┐  │
│  │ [contact-form-7 id="68"   │  │ ← Paste here
│  │ title="Lumina Admission   │  │
│  │ Inquiry Form"]            │  │
│  └───────────────────────────┘  │
│                                 │
└─────────────────────────────────┘
```

### Step 6: Style the Section (Optional)

#### Add Section Title
1. Above the shortcode widget, add a **Heading** widget
2. Set text: "Start Your Application"
3. Style: H2, Center aligned, Dark Blue color

#### Add Description
1. Add a **Text Editor** widget
2. Add description text
3. Center align

#### Section Styling
Click on the section handle (top) and style:
- Background: White or Light Gray
- Padding: 60px top, 60px bottom
- Content Width: 1140px

### Step 7: Preview and Update

1. Click the **eye icon** (Preview) to see how it looks
2. Test the form in preview mode
3. If satisfied, click **Update** (green button, bottom left)

---

## Complete Section Structure

Here's how your Admission Form section should look in Elementor:

```
┌─────────────────────────────────────────────────┐
│  SECTION: Admission Form                        │
│  ├─ Background: #f7f7f7                        │
│  ├─ Padding: 60px 0                            │
│  │                                              │
│  └─ COLUMN (100%)                               │
│      │                                           │
│      ├─ HEADING Widget                          │
│      │   Text: "Start Your Application"         │
│      │   Tag: H2                                 │
│      │   Color: #003d70                         │
│      │   Align: Center                          │
│      │                                           │
│      ├─ TEXT EDITOR Widget                      │
│      │   Text: "Complete the form below..."     │
│      │   Align: Center                          │
│      │                                           │
│      └─ SHORTCODE Widget                        │
│          Shortcode: [contact-form-7 id="68"     │
│                     title="Lumina Admission     │
│                     Inquiry Form"]              │
│                                                  │
└─────────────────────────────────────────────────┘
```

---

## Finding Your Form ID

If you don't know your form ID:

### Method 1: From Form Creation Output
When you ran `create-admission-form-fixed.php`, it showed:
```
Form ID: 68
Shortcode: [contact-form-7 id="68" title="Lumina Admission Inquiry Form"]
```

### Method 2: From WordPress Admin
1. Go to **Contact** > **Contact Forms**
2. Find "Lumina Admission Inquiry Form"
3. Hover over the title
4. Look at the URL in browser status bar:
   ```
   .../wp-admin/admin.php?page=wpcf7&post=68&action=edit
                                          ^^
                                       This is your ID
   ```

### Method 3: Run Test Script
```bash
php test-admission-form.php
```
It will show the form ID and shortcode.

---

## Troubleshooting

### Form Doesn't Display
**Problem:** Shortcode shows as text `[contact-form-7 id="68"...]`

**Solutions:**
1. Make sure you used the **Shortcode** widget (not Text Editor in Visual mode)
2. Check that Contact Form 7 plugin is active
3. Verify the form ID is correct
4. Clear Elementor cache: Elementor > Tools > Regenerate CSS

### Form Displays But Looks Broken
**Problem:** Form has no styling or looks plain

**Solutions:**
1. Check that `admission-form.css` is enqueued
2. Clear browser cache
3. Clear Elementor cache
4. Check browser console for CSS errors

### Can't Find Shortcode Widget
**Problem:** Shortcode widget not in widget list

**Solutions:**
1. Update Elementor to latest version
2. Use HTML widget instead
3. Use Text Editor widget in Text mode

---

## Alternative: Using Elementor Pro Form

If you have **Elementor Pro**, you can also use Elementor's native form builder:

### Pros:
- Visual form builder
- Better integration with Elementor
- More styling options

### Cons:
- Requires Elementor Pro (paid)
- Need to recreate form fields
- Different email configuration

**Recommendation:** Stick with Contact Form 7 shortcode for now since it's already configured.

---

## Styling the Form in Elementor

After adding the shortcode, you can style the section:

### Section Styling
```
Style Tab:
├─ Background Type: Classic
├─ Background Color: #f7f7f7
├─ Padding: 60px 0 60px 0
└─ Border: None
```

### Column Styling
```
Advanced Tab:
├─ Width: 100%
├─ Padding: 0 20px
└─ Content Position: Top
```

### Additional CSS (if needed)
```
Advanced Tab > Custom CSS:
selector .lumina-admission-form {
    max-width: 800px;
    margin: 0 auto;
}
```

---

## Complete Example

Here's the complete shortcode with all options:

```
[contact-form-7 id="68" title="Lumina Admission Inquiry Form" html_class="lumina-admission-form-wrapper"]
```

Or if you want to add an anchor for smooth scrolling:

```html
<div id="admission-form">
[contact-form-7 id="68" title="Lumina Admission Inquiry Form"]
</div>
```

---

## Quick Reference Card

```
┌──────────────────────────────────────────┐
│  QUICK STEPS                             │
├──────────────────────────────────────────┤
│  1. Edit with Elementor                  │
│  2. Click "+" to add widget              │
│  3. Search "Shortcode"                   │
│  4. Drag to location                     │
│  5. Paste shortcode                      │
│  6. Update page                          │
└──────────────────────────────────────────┘

┌──────────────────────────────────────────┐
│  YOUR SHORTCODE                          │
├──────────────────────────────────────────┤
│  [contact-form-7 id="68"                 │
│   title="Lumina Admission Inquiry Form"] │
└──────────────────────────────────────────┘

┌──────────────────────────────────────────┐
│  WIDGET TO USE                           │
├──────────────────────────────────────────┤
│  ✓ Shortcode Widget (Best)               │
│  ✓ HTML Widget (Alternative)             │
│  ✓ Text Editor - Text mode (Alternative) │
└──────────────────────────────────────────┘
```

---

## Video Tutorial Steps

If you prefer video instructions, here's what to look for:

1. Search YouTube: "How to add shortcode in Elementor"
2. Key points to watch:
   - Finding the Shortcode widget
   - Pasting the shortcode
   - Styling the section

---

## Need Help?

### Can't find the section?
- Use Elementor Navigator (bottom left icon)
- Shows page structure
- Click to jump to any section

### Form not working after adding?
1. Preview the page (eye icon)
2. Try submitting the form
3. Check browser console for errors
4. Verify Contact Form 7 is active

### Want to move the form?
- Click and drag the Shortcode widget
- Or use the up/down arrows in widget settings
- Or cut and paste to different section

---

**You're ready to add the form! 🎉**

Just follow Step 1-7 above and your admission form will be live!
