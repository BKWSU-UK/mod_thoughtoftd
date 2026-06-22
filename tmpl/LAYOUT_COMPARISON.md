# Layout Comparison Guide

## Quick Visual Reference

### Layout Comparison Table

| Feature | Default | Card | Card Horizontal | Card Overlay |
|---------|---------|------|-----------------|--------------|
| **Image Position** | Flexible | Top | Left (Desktop) | Background |
| **Best For** | Sidebars | Main content | Wide areas | Hero sections |
| **Visual Impact** | ⭐⭐ | ⭐⭐⭐⭐ | ⭐⭐⭐ | ⭐⭐⭐⭐⭐ |
| **Space Efficiency** | ⭐⭐⭐⭐⭐ | ⭐⭐⭐ | ⭐⭐⭐⭐ | ⭐⭐ |
| **Mobile Friendly** | ⭐⭐⭐⭐⭐ | ⭐⭐⭐⭐⭐ | ⭐⭐⭐⭐ | ⭐⭐⭐⭐ |
| **Complexity** | Simple | Medium | Medium | Advanced |
| **Requires Image** | No | Optional | Optional | Recommended |

---

## Layout Previews

### 1. Default Layout
```
Simple text-based layout
─────────────────────────
[Optional Image]

Topic Title
─────────────────────────
Thought text flows naturally
without any special container.
Perfect for simple displays.

[Subscribe Button]
```

**Pros:**
- Minimal markup
- Maximum flexibility
- Works anywhere
- Easy to customise

**Cons:**
- Less visual impact
- No built-in structure
- Requires custom styling for polish

---

### 2. Card Layout
```
┌───────────────────────┐
│   ╔═════════════╗     │
│   ║   Image     ║     │
│   ╚═════════════╝     │
├───────────────────────┤
│                       │
│  Topic Title          │
│  ─────────────        │
│                       │
│  Thought text in a    │
│  clean, structured    │
│  card format with     │
│  subtle elevation.    │
│                       │
│  [Subscribe Button]   │
│                       │
└───────────────────────┘
```

**Pros:**
- Professional appearance
- Clear content hierarchy
- Hover effects included
- Works in grids

**Cons:**
- Takes more vertical space
- Fixed structure
- Best with portrait images

---

### 3. Card Horizontal Layout

**Desktop View:**
```
┌─────────────────────────────────────┐
│  ╔═══════╗  │                       │
│  ║       ║  │  Topic Title          │
│  ║ Image ║  │  ─────────────        │
│  ║       ║  │                       │
│  ╚═══════╝  │  Thought text flows   │
│             │  alongside the image  │
│             │  in a side-by-side    │
│             │  layout.              │
│             │                       │
│             │  [Subscribe Button]   │
│             │                       │
└─────────────────────────────────────┘
```

**Mobile View:**
```
┌───────────────────────┐
│   ╔═════════════╗     │
│   ║   Image     ║     │
│   ╚═════════════╝     │
├───────────────────────┤
│  Topic Title          │
│  ─────────────        │
│                       │
│  Thought text stacks  │
│  vertically on mobile │
│                       │
│  [Subscribe Button]   │
└───────────────────────┘
```

**Pros:**
- Efficient use of space
- Great for landscape images
- Blog-style appearance
- Responsive stacking

**Cons:**
- Needs wider positions
- Not ideal for sidebars
- Image size limited on desktop

---

### 4. Card Overlay Layout
```
┌───────────────────────────────┐
│░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░│
│░░░░░░ Background Image ░░░░░░░│
│░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░│
│░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░│
│░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░│
│▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓│ ← Gradient
│▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓│   overlay
│██ Topic Title ████████████████│
│██                    ██████████│
│██ Thought text with  ██████████│
│██ white text overlay ██████████│
│██                    ██████████│
│██ [Subscribe Button] ██████████│
└───────────────────────────────┘
```

**Pros:**
- Maximum visual impact
- Modern, dramatic design
- Great for hero sections
- Memorable presentation

**Cons:**
- Requires quality images
- More complex styling
- Image must have good contrast
- Takes significant vertical space

---

## Use Case Scenarios

### Scenario 1: Sidebar Widget
**Recommended:** Default or Card
**Why:** Limited width, needs vertical efficiency

### Scenario 2: Homepage Hero
**Recommended:** Card Overlay
**Why:** Maximum impact, sets the tone

### Scenario 3: Blog Post Sidebar
**Recommended:** Card
**Why:** Professional, contained, doesn't compete with content

### Scenario 4: Full-Width Content Area
**Recommended:** Card Horizontal
**Why:** Efficient use of wide space, blog-style

### Scenario 5: Grid of Multiple Modules
**Recommended:** Card
**Why:** Consistent sizing, works well in rows

### Scenario 6: Mobile-First Site
**Recommended:** Default or Card
**Why:** Simple, fast, efficient on small screens

### Scenario 7: Portfolio/Gallery Site
**Recommended:** Card Overlay
**Why:** Image-focused, artistic presentation

### Scenario 8: News/Magazine Site
**Recommended:** Card Horizontal
**Why:** Editorial style, efficient content display

---

## Responsive Behaviour

### Desktop (> 768px)
- **Default**: Single column, natural flow
- **Card**: Vertical card, full width
- **Card Horizontal**: 33% image / 67% content split
- **Card Overlay**: Full-width background

### Tablet (768px - 992px)
- **Default**: Same as desktop
- **Card**: Same as desktop
- **Card Horizontal**: Same as desktop
- **Card Overlay**: Same as desktop

### Mobile (< 768px)
- **Default**: Same layout, smaller text
- **Card**: Same layout, optimised spacing
- **Card Horizontal**: **Stacks vertically** (image on top)
- **Card Overlay**: Smaller gradient area

---

## Performance Considerations

### Load Time Impact
1. **Default**: Fastest (minimal CSS)
2. **Card**: Fast (standard Bootstrap)
3. **Card Horizontal**: Fast (standard Bootstrap)
4. **Card Overlay**: Medium (gradient overlay)

### Image Optimisation
- **Default**: Any size works
- **Card**: Optimise for 800×600px
- **Card Horizontal**: Optimise for 600×400px
- **Card Overlay**: Optimise for 1600×900px

---

## Accessibility Comparison

All layouts are accessible, but with different considerations:

### Screen Readers
- **Default**: Simplest structure, easiest to navigate
- **Card**: Clear semantic structure
- **Card Horizontal**: Logical reading order maintained
- **Card Overlay**: Ensure sufficient contrast

### Keyboard Navigation
- All layouts support full keyboard navigation
- Tab order is logical in all layouts
- Focus indicators visible

### Contrast
- **Default**: Depends on template
- **Card**: Good default contrast
- **Card Horizontal**: Good default contrast
- **Card Overlay**: **Requires careful image selection**

---

## Customisation Difficulty

### Easy to Customise
- **Default**: Very easy (minimal structure)
- **Card**: Easy (standard Bootstrap classes)

### Moderate to Customise
- **Card Horizontal**: Moderate (grid system)
- **Card Overlay**: Moderate (overlay positioning)

---

## Decision Tree

```
Start: What's your primary goal?
│
├─ Maximum visual impact?
│  └─ Card Overlay
│
├─ Efficient space usage?
│  ├─ Wide area? → Card Horizontal
│  └─ Narrow area? → Default
│
├─ Professional appearance?
│  └─ Card
│
└─ Maximum flexibility?
   └─ Default
```

---

## Testing Recommendations

Before deciding, test your chosen layout with:

1. ✅ Different text lengths (short and long)
2. ✅ With and without images
3. ✅ Various screen sizes
4. ✅ Different module positions
5. ✅ Multiple instances on same page
6. ✅ Your actual content

---

## Migration Guide

### Switching Between Layouts

**From Default to Card:**
- No issues, direct switch
- Consider image sizing

**From Default to Card Horizontal:**
- Ensure position is wide enough
- Use landscape images

**From Default to Card Overlay:**
- **Requires quality images**
- Test text readability

**Between Card Layouts:**
- Test image aspect ratios
- Verify spacing/positioning
- Check mobile appearance

---

## Summary Recommendations

| If you want... | Choose |
|----------------|--------|
| Simplicity | Default |
| Professionalism | Card |
| Space Efficiency | Card Horizontal |
| Visual Impact | Card Overlay |
| Flexibility | Default |
| Modern Design | Card or Card Overlay |
| Blog Style | Card Horizontal |
| Hero Section | Card Overlay |

---

**Still unsure?** Start with **Card** layout - it's the most versatile and works well in most scenarios.

