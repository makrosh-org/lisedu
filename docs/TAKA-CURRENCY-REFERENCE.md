# Taka Currency Reference Guide
## Converting All Currency to Bangladesh Taka (৳)

### Taka Symbol Options

#### Option 1: Unicode Character (Recommended)
```
৳
```
Copy and paste this symbol directly into your content.

#### Option 2: HTML Entity
```html
&#2547;
```
Use this in HTML/Elementor text widgets.

#### Option 3: HTML Named Entity
```html
&bdt;
```
Less common, but works in some contexts.

---

## Fee Structure in Taka

### Registration & Tuition Fees

| Grade Level          | Registration Fee | Annual Tuition | Total First Year |
|---------------------|------------------|----------------|------------------|
| Play Group (2-3)    | ৳ 10,000        | ৳ 150,000     | ৳ 160,000       |
| Nursery (3-4)       | ৳ 10,000        | ৳ 160,000     | ৳ 170,000       |
| Kindergarten (4-5)  | ৳ 12,000        | ৳ 180,000     | ৳ 192,000       |
| Grade 1 (5-6)       | ৳ 12,000        | ৳ 200,000     | ৳ 212,000       |
| Grade 2 (6-7)       | ৳ 12,000        | ৳ 210,000     | ৳ 222,000       |
| Grade 3 (7-8)       | ৳ 15,000        | ৳ 220,000     | ৳ 235,000       |
| Grade 4 (8-9)       | ৳ 15,000        | ৳ 230,000     | ৳ 245,000       |
| Grade 5 (9-10)      | ৳ 15,000        | ৳ 240,000     | ৳ 255,000       |

### Additional Fees

| Item                        | Cost Range (Annual)    |
|----------------------------|------------------------|
| Books & Materials          | ৳ 15,000 - ৳ 25,000   |
| School Uniform             | ৳ 8,000 - ৳ 12,000    |
| Transportation (Optional)  | ৳ 30,000 - ৳ 50,000   |
| Lunch Program (Optional)   | ৳ 25,000              |
| Extracurricular Activities | ৳ 10,000 - ৳ 20,000   |

### Payment Options

#### Option 1: Full Payment (5% Discount)
Pay entire annual tuition upfront and receive 5% discount.

**Example for Grade 1:**
- Regular: ৳ 200,000
- With discount: ৳ 190,000
- **You save: ৳ 10,000**

#### Option 2: Two Installments
Pay in two equal installments:
- 50% at admission
- 50% at mid-year (January)

#### Option 3: Three Installments
Pay in three equal installments:
- 33.3% at admission
- 33.3% at mid-year (January)
- 33.3% at end of year (May)

#### Option 4: Monthly Payment Plan
Pay in 10 monthly installments (September - June)

**Example for Grade 1:**
- Monthly payment: ৳ 20,000
- Total: ৳ 200,000

---

## How to Update Currency in Elementor

### Method 1: Edit Text Widget
1. Open page in Elementor
2. Click on the text widget with currency
3. Select the old currency symbol (e.g., $, €, £)
4. Delete it
5. Paste the Taka symbol: ৳
6. Update the page

### Method 2: Find and Replace
1. Open page in Elementor
2. Press `Ctrl+F` (Windows) or `Cmd+F` (Mac)
3. Search for old currency symbol (e.g., $)
4. Replace with: ৳
5. Update the page

### Method 3: Edit HTML
1. Open page in Elementor
2. Click on widget
3. Switch to HTML editing mode
4. Replace currency symbols
5. Use `&#2547;` for HTML
6. Update the page

---

## Number Formatting in Bangladesh

### Comma Placement
Bangladesh uses the Indian numbering system:

```
1,00,000 = One Lakh (100,000)
10,00,000 = Ten Lakh (1,000,000)
1,00,00,000 = One Crore (10,000,000)
```

### Examples:
- ৳ 1,50,000 (One lakh fifty thousand)
- ৳ 2,00,000 (Two lakh)
- ৳ 10,00,000 (Ten lakh)

### For International Audience
You can also use standard international format:
- ৳ 150,000
- ৳ 200,000
- ৳ 1,000,000

---

## CSS for Taka Symbol

If you need to style the Taka symbol:

```css
.taka-symbol {
    font-family: 'Noto Sans Bengali', 'Kalpurush', sans-serif;
    font-weight: 600;
}

.price {
    font-size: 24px;
    color: #003d70;
}

.price::before {
    content: '৳ ';
    font-weight: bold;
}
```

---

## PHP Code for Taka Formatting

```php
/**
 * Format number as Taka currency
 */
function format_taka($amount) {
    return '৳ ' . number_format($amount, 0, '.', ',');
}

// Usage
echo format_taka(150000); // Output: ৳ 150,000
```

---

## WordPress Shortcode for Taka

Add this to your functions.php:

```php
/**
 * Shortcode to display Taka amount
 * Usage: [taka amount="150000"]
 */
function taka_shortcode($atts) {
    $atts = shortcode_atts(array(
        'amount' => 0,
    ), $atts);
    
    $formatted = number_format(intval($atts['amount']), 0, '.', ',');
    return '<span class="taka-amount">৳ ' . $formatted . '</span>';
}
add_shortcode('taka', 'taka_shortcode');
```

Usage in content:
```
[taka amount="150000"]
```
Output: ৳ 150,000

---

## Elementor Dynamic Tags for Taka

If using Elementor Pro with custom fields:

1. Create custom field for price
2. Add dynamic tag
3. Add prefix: ৳
4. Format: Number with commas

---

## Common Mistakes to Avoid

### ❌ Wrong:
- $ 150,000 (Dollar sign)
- BDT 150,000 (Currency code)
- Tk 150,000 (Abbreviation)
- 150,000 Taka (Text after number)

### ✓ Correct:
- ৳ 150,000 (Taka symbol before number)
- ৳ 1,50,000 (Indian numbering system)

---

## Testing Taka Display

### Browser Test:
1. Open page in browser
2. Check if ৳ symbol displays correctly
3. If shows as box or ?, install Bengali font

### Font Requirements:
Ensure your site uses fonts that support Bengali characters:
- Noto Sans Bengali
- Kalpurush
- SolaimanLipi
- Mukti

Add to your CSS:
```css
@import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@400;600;700&display=swap');

body {
    font-family: 'Poppins', 'Noto Sans Bengali', sans-serif;
}
```

---

## Quick Copy-Paste Values

### Common Amounts:
```
৳ 10,000
৳ 12,000
৳ 15,000
৳ 25,000
৳ 50,000
৳ 100,000
৳ 150,000
৳ 200,000
৳ 250,000
৳ 500,000
৳ 1,000,000
```

### With Indian Numbering:
```
৳ 10,000
৳ 12,000
৳ 15,000
৳ 25,000
৳ 50,000
৳ 1,00,000
৳ 1,50,000
৳ 2,00,000
৳ 2,50,000
৳ 5,00,000
৳ 10,00,000
```

---

## Checklist for Currency Conversion

- [ ] Homepage - Update all prices to Taka
- [ ] Admissions Page - Fee structure in Taka
- [ ] Programs Page - Program fees in Taka
- [ ] Contact Page - Any pricing mentions
- [ ] Footer - Any pricing information
- [ ] Widgets - Sidebar pricing widgets
- [ ] Forms - Update currency in form labels
- [ ] Email Templates - Update currency in emails
- [ ] PDF Documents - Update any downloadable fee schedules
- [ ] Meta Descriptions - Update SEO descriptions with Taka

---

## Support Resources

### Unicode Information:
- Character: ৳
- Unicode: U+09F3
- HTML Entity: &#2547;
- Name: BENGALI RUPEE SIGN

### Font Resources:
- Google Fonts: https://fonts.google.com/noto/specimen/Noto+Sans+Bengali
- Font Awesome: Does not include ৳ symbol

---

## Need Help?

If Taka symbol doesn't display:
1. Check browser encoding (should be UTF-8)
2. Check database encoding (should be utf8mb4)
3. Install Bengali font support
4. Use HTML entity: &#2547;
5. Check CSS font-family includes Bengali font

---

**All currency is now in Bangladesh Taka (৳)!**
