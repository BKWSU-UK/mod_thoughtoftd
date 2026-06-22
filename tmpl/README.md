# Thought of the Day - Template Layouts

This module includes multiple Bootstrap 5 compliant layout options. You can select the layout in the module settings under the "Advanced" tab.

## Available Layouts

### 1. Default Layout (`default.php`)
The standard layout with minimal styling. Content flows naturally with optional image placement.

**Features:**
- Simple, clean design
- Flexible image positioning
- Responsive images with `img-fluid` class
- Optional collapsible text
- Optional subscribe button

**Best for:** Simple implementations, sidebar modules, or when you want to apply custom CSS.

---

### 2. Card Layout (`card.php`)
A modern Bootstrap 5 card with image on top and content below.

**Features:**
- Bootstrap 5 card component
- Image displayed at top of card (`card-img-top`)
- Topic as card title
- Thought text as card body
- Subscribe button in card footer area
- Fully responsive

**Best for:** Featured content areas, main content columns, or when you want a contained, elevated design.

**Example:**
```
┌─────────────────┐
│     Image       │
├─────────────────┤
│ Topic Title     │
│                 │
│ Thought text... │
│                 │
│ [Subscribe]     │
└─────────────────┘
```

---

### 3. Card Horizontal Layout (`card_horizontal.php`)
A Bootstrap 5 card with image on the left and content on the right (responsive).

**Features:**
- Horizontal card layout using Bootstrap grid
- Image on left (4 columns on medium+ screens)
- Content on right (8 columns on medium+ screens)
- Stacks vertically on mobile devices
- Rounded corners on image (`rounded-start`)

**Best for:** Wide content areas, featured sections, or when you have landscape-oriented images.

**Example (Desktop):**
```
┌───────┬─────────────────┐
│       │ Topic Title     │
│ Image │                 │
│       │ Thought text... │
│       │                 │
│       │ [Subscribe]     │
└───────┴─────────────────┘
```

**Example (Mobile):**
```
┌─────────────────┐
│     Image       │
├─────────────────┤
│ Topic Title     │
│                 │
│ Thought text... │
│                 │
│ [Subscribe]     │
└─────────────────┘
```

---

### 4. Card Overlay Layout (`card_overlay.php`)
A dramatic Bootstrap 5 card with text overlaid on the image.

**Features:**
- Image as background with text overlay
- Dark text background for readability
- White text on image
- Content positioned at bottom of image
- Light-coloured subscribe button for contrast
- Falls back to standard card if no image

**Best for:** Hero sections, featured content, or when you have high-quality, atmospheric images.

**Example:**
```
┌─────────────────┐
│                 │
│   Image with    │
│   gradient      │
│                 │
│ Topic Title     │
│ Thought text... │
│ [Subscribe]     │
└─────────────────┘
```

---

## How to Select a Layout

1. Go to **Extensions → Modules** in your Joomla administrator
2. Open your Thought of the Day module
3. Click on the **Advanced** tab
4. In the **Alternative Layout** field, select your preferred layout:
   - `default` - Standard layout
   - `card` - Vertical card layout
   - `card_horizontal` - Horizontal card layout
   - `card_overlay` - Image overlay card layout
5. Save the module

## Customisation

All layouts support the module's standard parameters:
- Show/hide topic
- Show/hide image (random, static, or from database)
- Enable read more (collapsible text)
- Show/hide subscribe button
- Module class suffix for additional styling

## CSS Classes

Each layout uses Bootstrap 5 classes and includes a `.mod-thoughtoftd` class for custom styling:

```css
/* Example custom styling */
.mod-thoughtoftd.card {
    border-radius: 1rem;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.mod-thoughtoftd .card-title {
    color: #2c3e50;
    font-weight: 600;
}
```

## Bootstrap 5 Compliance

All layouts are fully compliant with Bootstrap 5:
- Use `img-fluid` instead of deprecated `img-responsive`
- No jQuery dependencies
- Use native Bootstrap 5 collapse component
- Responsive grid system (where applicable)
- Modern card components
- Proper utility classes

## Accessibility

All layouts include:
- Proper semantic HTML
- Alt text on images
- ARIA attributes for collapsible content
- Keyboard-accessible controls

