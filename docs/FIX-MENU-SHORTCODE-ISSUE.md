# Fix Shortcode Appearing in Navigation Menu

## Problem
The navigation menu shows the shortcode text `[contact-form-7 id="XX" title="..."]` instead of "Admissions" or the proper menu label.

## Why This Happens
- Shortcode was accidentally pasted in the menu label field
- Menu item was created with shortcode as the label
- Someone confused the menu editor with the page editor

## Solution

### Method 1: Edit Existing Menu Item (Recommended)

#### Step 1: Go to Menu Editor
1. WordPress Admin Dashboard
2. Click **Appearance** > **Menus**
3. Select your primary navigation menu

#### Step 2: Find the Problem Menu Item
Look for the menu item showing the shortcode text

#### Step 3: Expand Menu Item
1. Click the **dropdown arrow** (▼) on the right side
2. The menu item will expand showing fields

#### Step 4: Fix the Label
1. Find the **Navigation Label** field
2. Clear the shortcode text
3. Type the correct label: `Admissions`
4. Optionally add **Title Attribute**: `View Admissions Information`

#### Step 5: Verify URL
Make sure the **URL** field shows:
```
/admissions/
```
or
```
https://yourdomain.com/admissions/
```

#### Step 6: Save Menu
1. Scroll to bottom
2. Click **Save Menu** button
3. Wait for "Menu saved" message

#### Step 7: Test
1. Visit your website
2. Check the navigation menu
3. Should now show "Admissions" instead of shortcode
4. Click it to verify it goes to the Admissions page

---

### Method 2: Delete and Recreate Menu Item

If editing doesn't work:

#### Step 1: Delete Bad Menu Item
1. Go to **Appearance** > **Menus**
2. Find the menu item with shortcode
3. Click dropdown arrow to expand
4. Click **Remove** link
5. Click **Save Menu**

#### Step 2: Add Admissions Page
1. On the left side, find **Pages** section
2. Click **View All** if needed
3. Find **Admissions** page
4. Check the checkbox next to it
5. Click **Add to Menu** button

#### Step 3: Position Menu Item
1. The Admissions item appears in your menu
2. Drag it to the correct position
3. Drop it where you want it

#### Step 4: Configure Label (Optional)
1. Click dropdown arrow on the new item
2. Verify **Navigation Label** says: `Admissions`
3. Add **Title Attribute** if desired
4. Click **Save Menu**

---

### Method 3: Create Custom Link (If Page Doesn't Exist)

If Admissions page isn't showing in Pages list:

#### Step 1: Use Custom Links
1. On the left side, find **Custom Links** section
2. Click to expand it

#### Step 2: Add Link Details
```
URL: /admissions/
Link Text: Admissions
```

#### Step 3: Add to Menu
1. Click **Add to Menu**
2. Position it correctly
3. Click **Save Menu**

---

## Detailed Menu Editor Guide

### Menu Editor Layout:

```
┌─────────────────────────────────────────────────────────┐
│ Appearance > Menus                                      │
├─────────────────────────────────────────────────────────┤
│                                                         │
│ Left Side:                    Right Side:               │
│ ┌─────────────────┐          ┌──────────────────────┐  │
│ │ Pages           │          │ Menu Structure       │  │
│ │ ☐ Home          │          │                      │  │
│ │ ☑ Admissions    │          │ ▼ Home               │  │
│ │ ☐ Gallery       │          │ ▼ Admissions ←Fix    │  │
│ │                 │          │ ▼ Gallery            │  │
│ │ [Add to Menu]   │          │                      │  │
│ │                 │          │ [Save Menu]          │  │
│ └─────────────────┘          └──────────────────────┘  │
└─────────────────────────────────────────────────────────┘
```

### Expanded Menu Item:

```
┌─────────────────────────────────────────────────────────┐
│ ▼ Admissions                                    Remove  │
├─────────────────────────────────────────────────────────┤
│                                                         │
│ Navigation Label                                        │
│ ┌─────────────────────────────────────────────────────┐│
│ │ Admissions                                          ││ ← Fix here
│ └─────────────────────────────────────────────────────┘│
│                                                         │
│ Title Attribute                                         │
│ ┌─────────────────────────────────────────────────────┐│
│ │ View Admissions Information                         ││
│ └─────────────────────────────────────────────────────┘│
│                                                         │
│ URL                                                     │
│ ┌─────────────────────────────────────────────────────┐│
│ │ https://yourdomain.com/admissions/                  ││
│ └─────────────────────────────────────────────────────┘│
│                                                         │
│ ☐ Open link in a new tab                               │
│                                                         │
│ CSS Classes (optional)                                  │
│ ┌─────────────────────────────────────────────────────┐│
│ │                                                     ││
│ └─────────────────────────────────────────────────────┘│
│                                                         │
│                                          [Move] [Cancel]│
└─────────────────────────────────────────────────────────┘
```

---

## Field Explanations

### Navigation Label
- **What it is:** The text that appears in the menu
- **What to put:** `Admissions`
- **NOT:** The shortcode!

### Title Attribute
- **What it is:** Tooltip text when hovering over menu item
- **What to put:** `View Admissions Information` (optional)
- **Can leave blank**

### URL
- **What it is:** Where the link goes
- **What to put:** `/admissions/` or full URL
- **Should NOT contain shortcode**

### CSS Classes
- **What it is:** Custom styling classes
- **Usually leave blank**
- **Advanced users only**

---

## Troubleshooting

### Issue: Can't Find Menus Option

**Solution 1: Check User Permissions**
- You need Administrator or Editor role
- Contact site admin if you don't have access

**Solution 2: Theme Doesn't Support Menus**
- Unlikely with modern themes
- Check theme documentation

**Solution 3: Menu Location Not Set**
1. Go to **Appearance** > **Menus**
2. At bottom, check **Display location**
3. Check **Primary Menu** or **Main Menu**
4. Save Menu

---

### Issue: Admissions Page Not in Pages List

**Solution 1: Search for It**
1. In Pages section, use the search box
2. Type "Admissions"
3. Should appear

**Solution 2: Check Page Status**
1. Go to **Pages** > **All Pages**
2. Find Admissions page
3. Make sure it's **Published** (not Draft)
4. Go back to Menus and try again

**Solution 3: Use Custom Link**
1. Use Custom Links section
2. Add URL manually: `/admissions/`
3. Add to menu

---

### Issue: Changes Don't Save

**Solution 1: Click Save Menu**
- Must click **Save Menu** button
- Wait for confirmation message

**Solution 2: Check for JavaScript Errors**
- Open browser console (F12)
- Look for errors
- Try different browser

**Solution 3: Disable Plugins**
- Deactivate all plugins
- Try saving menu
- Reactivate plugins one by one

---

### Issue: Shortcode Still Shows After Fix

**Solution 1: Clear Cache**
```bash
# WordPress cache
wp cache flush

# Browser cache
Ctrl+Shift+R (Windows)
Cmd+Shift+R (Mac)
```

**Solution 2: Check Multiple Menus**
- You might have multiple menus
- Check all menu locations
- Fix each one

**Solution 3: Check Theme Header**
- Some themes have custom menu code
- Check with theme support

---

## Prevention Tips

### To Avoid This in Future:

1. **Never paste shortcodes in menu labels**
   - Shortcodes go on pages, not in menus
   - Menu labels are just text

2. **Use descriptive labels**
   - "Admissions" not "[contact-form-7...]"
   - Keep it simple and clear

3. **Add pages to menu properly**
   - Use the Pages section in menu editor
   - Don't create custom links unless necessary

4. **Test after changes**
   - Always check the frontend
   - Verify menu looks correct

---

## Menu Best Practices

### Good Menu Labels:
```
✅ Home
✅ Admissions
✅ Programs
✅ Gallery
✅ Contact
```

### Bad Menu Labels:
```
❌ [contact-form-7 id="68"...]
❌ Click here to view admissions
❌ https://yourdomain.com/admissions/
❌ Page ID: 123
```

### Menu Structure Example:
```
Home
Programs
  ├─ Play Group
  ├─ Nursery
  └─ Kindergarten
Admissions
Gallery
Contact
```

---

## Quick Reference

### Fix Shortcode in Menu:
```
1. Appearance > Menus
2. Find menu item with shortcode
3. Click dropdown arrow
4. Change Navigation Label to: Admissions
5. Save Menu
6. Clear cache
7. Test
```

### Add New Menu Item:
```
1. Appearance > Menus
2. Pages section > Find Admissions
3. Check checkbox
4. Add to Menu
5. Position it
6. Save Menu
```

---

## Alternative: Check Theme Header

If the shortcode appears in the header but NOT in the menu editor, check:

### Step 1: Check Theme Customizer
1. Go to **Appearance** > **Customize**
2. Look for **Header** or **Navigation** section
3. Check if shortcode is there
4. Remove it

### Step 2: Check Header Template
1. Go to **Appearance** > **Theme File Editor**
2. Find `header.php`
3. Search for the shortcode
4. Remove it (be careful!)

### Step 3: Check Elementor Header
1. Go to **Templates** > **Theme Builder**
2. Check Header template
3. Edit and remove shortcode

---

## Summary

**Problem:** Shortcode showing in navigation menu
**Cause:** Shortcode pasted in menu label field
**Solution:** Edit menu item, change label to "Admissions"
**Time:** 1 minute

**Steps:**
1. Appearance > Menus
2. Expand menu item
3. Change label to "Admissions"
4. Save Menu
5. Clear cache

**Done! ✅**

---

## Need More Help?

### Check These:
- WordPress Codex: https://codex.wordpress.org/WordPress_Menu_User_Guide
- Your theme documentation
- Contact theme support

### Or Contact:
- WordPress Support Forums
- Your web developer
- Hosting support

---

**Your menu should now show "Admissions" instead of the shortcode! 🎉**
