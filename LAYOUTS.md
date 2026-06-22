# Bootstrap 5 Card Layouts

## Overview

The Thought of the Day module now includes **four Bootstrap 5 compliant layouts**:

1. **Default** - Simple, flexible layout
2. **Card** - Vertical card with image on top
3. **Card Horizontal** - Side-by-side image and content
4. **Card Overlay** - Dramatic image with text overlay

## Quick Start

### Selecting a Layout

1. Navigate to **Extensions → Modules** in Joomla Administrator
2. Open your Thought of the Day module
3. Go to the **Advanced** tab
4. Select your preferred layout from the **Alternative Layout** dropdown
5. Save and view on your site

## Layout Details

### 1. Default Layout
**File:** `default.php`

Simple, clean layout with minimal Bootstrap styling. Perfect for sidebars or when you want full control over styling.

**Use Cases:**
- Sidebar modules
- Custom-styled implementations
- Minimal design requirements

---

### 2. Card Layout
**File:** `card.php`

Modern Bootstrap 5 card with image on top, title, content, and button.

**Features:**
- Elevated card design with subtle shadow
- Hover effect (lifts slightly)
- Image at top with `card-img-top`
- Structured content area
- Professional appearance

**Use Cases:**
- Main content areas
- Featured sections
- Grid layouts (multiple modules)
- Modern, clean designs

**Visual Structure:**
```
┌─────────────────────┐
│                     │
│       Image         │
│                     │
├─────────────────────┤
│  Topic Title        │
│                     │
│  Thought text that  │
│  can be quite long  │
│  and collapsible... │
│                     │
│  [Subscribe Button] │
└─────────────────────┘
```

---

### 3. Card Horizontal Layout
**File:** `card_horizontal.php`

Bootstrap 5 card with image on left (desktop) or top (mobile).

**Features:**
- Responsive grid layout
- Image: 33% width on desktop
- Content: 67% width on desktop
- Stacks vertically on mobile
- Rounded corners on image

**Use Cases:**
- Wide content areas
- Landscape images
- Blog-style layouts
- Featured content sections

**Visual Structure (Desktop):**
```
┌──────────┬────────────────────┐
│          │  Topic Title       │
│          │                    │
│  Image   │  Thought text that │
│          │  flows alongside   │
│          │  the image...      │
│          │                    │
│          │  [Subscribe]       │
└──────────┴────────────────────┘
```

**Visual Structure (Mobile):**
```
┌─────────────────────┐
│       Image         │
├─────────────────────┤
│  Topic Title        │
│                     │
│  Thought text...    │
│                     │
│  [Subscribe]        │
└─────────────────────┘
```

---

### 4. Card Overlay Layout
**File:** `card_overlay.php`

Dramatic design with text overlaid on image background.

**Features:**
- Full-width background image
- Gradient overlay for text readability
- White text with shadow
- Content positioned at bottom
- Light button for contrast
- Falls back to standard card if no image

**Use Cases:**
- Hero sections
- Featured/highlighted content
- Atmospheric presentations
- High-quality images
- Homepage features

**Visual Structure:**
```
┌─────────────────────┐
│                     │
│                     │
│    Background       │
│      Image          │
│                     │
│  ┌───────────────┐  │
│  │ Topic Title   │  │
│  │               │  │
│  │ Thought text  │  │
│  │               │  │
│  │ [Subscribe]   │  │
│  └───────────────┘  │
└─────────────────────┘
```

## Features Common to All Layouts

### Responsive Design
- All layouts are fully responsive
- Mobile-first approach
- Proper breakpoints for tablets and phones
- Touch-friendly buttons

### Bootstrap 5 Compliance
- Uses `img-fluid` (not deprecated `img-responsive`)
- No jQuery dependencies
- Native Bootstrap 5 components
- Modern utility classes
- Proper grid system

### Module Parameters Support
All layouts respect these module settings:
- **Show Topic** - Display/hide the topic title
- **Show Image** - None, Random, Static, or Database
- **Read More** - Collapsible text functionality
- **Show Button** - Display/hide subscribe button
- **Module Class Suffix** - Custom CSS classes

### Accessibility
- Semantic HTML5 elements
- Proper heading hierarchy
- Alt text on images
- ARIA attributes for interactive elements
- Keyboard navigation support

## Styling & Customisation

### Module CSS
The module includes `media/css/thoughtoftd.css` with:
- Card hover effects
- Button styling
- Responsive adjustments
- Print styles
- Overlay gradients

### Custom Styling
Add custom CSS using the Module Class Suffix:

**Example 1: Custom border colour**
```css
.mod-thoughtoftd.my-custom-class.card {
    border-left: 4px solid #0d6efd;
}
```

**Example 2: Different card background**
```css
.mod-thoughtoftd.light-bg .card-body {
    background-color: #f8f9fa;
}
```

**Example 3: Custom button style**
```css
.mod-thoughtoftd.custom-btn .btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
}
```

## Technical Details

### Web Asset Manager
All layouts use Joomla's Web Asset Manager for:
- CSS loading (`thoughtoftd.css`)
- JavaScript loading (`thoughtoftd.js`)
- Bootstrap 5 collapse component
- Proper dependency management
- Deferred script loading

### Performance
- Minimal CSS (< 5KB)
- Lightweight JavaScript
- No external dependencies
- Optimised images with `object-fit`
- Efficient Bootstrap components

### Browser Support
- All modern browsers (Chrome, Firefox, Safari, Edge)
- IE11 not supported (Bootstrap 5 requirement)
- Progressive enhancement approach
- Graceful degradation

## Tips & Best Practices

### Image Recommendations

**Card Layout:**
- Portrait or square images work best
- Recommended: 800×600px or larger
- Aspect ratio: 4:3 or 1:1

**Card Horizontal Layout:**
- Landscape images work best
- Recommended: 1200×800px or larger
- Aspect ratio: 3:2 or 16:9

**Card Overlay Layout:**
- High-quality, atmospheric images
- Recommended: 1600×900px or larger
- Ensure good contrast for text readability
- Avoid busy/cluttered images

### Layout Selection Guide

| Scenario | Recommended Layout |
|----------|-------------------|
| Sidebar widget | Default or Card |
| Main content area | Card or Card Horizontal |
| Hero section | Card Overlay |
| Multiple modules in grid | Card |
| Blog-style listing | Card Horizontal |
| Minimal design | Default |
| Maximum impact | Card Overlay |

### Module Position Suggestions

- **Card Layout**: Works well in any position
- **Card Horizontal**: Best in wide positions (not sidebars)
- **Card Overlay**: Ideal for top positions, hero areas
- **Default**: Flexible, works anywhere

## Troubleshooting

### Layout not showing correctly
1. Clear Joomla cache
2. Check template is loading Bootstrap 5
3. Verify Web Asset Manager is enabled
4. Check for CSS conflicts

### Images not displaying
1. Verify image paths in module settings
2. Check file permissions
3. Ensure images exist in specified folder
4. Check browser console for errors

### Collapsible text not working
1. Ensure "Enable read more" is set to "Yes"
2. Check Bootstrap 5 is loaded
3. Verify JavaScript is enabled
4. Clear browser cache

## Support

For issues or questions:
1. Check the Joomla documentation
2. Review Bootstrap 5 documentation
3. Inspect browser console for errors
4. Test with default Joomla template

## Version History

- **5.0.0** - Initial Joomla 5 release with Bootstrap 5 card layouts
  - Added Card layout
  - Added Card Horizontal layout
  - Added Card Overlay layout
  - Bootstrap 5 compliance
  - Removed jQuery dependencies
  - Modern Web Asset Manager implementation

