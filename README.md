# Oneguy — Child Theme for Minimalio

![WordPress](https://img.shields.io/badge/WordPress-6.0%2B-21759B?style=flat&logo=wordpress&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-7.4%2B-777BB4?style=flat&logo=php&logoColor=white)
![Parent Theme](https://img.shields.io/badge/Parent_Theme-Minimalio-333333?style=flat)
![Child Theme](https://img.shields.io/badge/Child_Theme-Oneguy-D90368?style=flat)
![License](https://img.shields.io/badge/License-GPL--2.0%2B-blue?style=flat)
![Customizer](https://img.shields.io/badge/Customizer-Ready-brightgreen?style=flat)
![Responsive](https://img.shields.io/badge/Responsive-Yes-success?style=flat)

**Oneguy** is a carefully crafted WordPress child theme built on top of [Minimalio](https://developer.developer.developer). It extends the parent theme with a rich set of customization options — from custom font uploads and granular typography controls to flexible blog and portfolio layouts — all manageable through the WordPress Customizer without touching code.

---

## Installation

1. Install and activate the **Minimalio** parent theme.
2. Upload the `oneguy` folder to `wp-content/themes/`.
3. Activate **Oneguy** from Appearance → Themes.

---

## Features

### Custom Font Upload

Upload and use your own fonts alongside Google Fonts.

- **Simple Upload** — Upload a single font file; standard weights (400, 700 + italics) are generated automatically.
- **Advanced Upload** — Upload multiple font variants for precise control over weights and styles.
- Uploaded fonts appear in the theme's font dropdown under a **Custom Fonts** section with clear dividers.
- **Location:** Appearance → Font Upload

> See `CUSTOM_FONTS_README.md` for detailed usage instructions.

---

### Typography

All typography controls are found in **Customizer → Typography Settings**.

| Control | Description |
|---|---|
| **Text Transform** | Apply `uppercase`, `lowercase`, `capitalize`, or `none` globally. |
| **Font Size — Body** | Set the base body font size (px or any CSS unit). |
| **Font Size — Paragraph (p)** | Override paragraph font size. |
| **Font Size — Headings (H1–H6)** | Individual font size for each heading level. |
| **Font Size — Blockquote** | Font size for `<blockquote>` elements. |
| **Font Size — List Items (li)** | Font size for list items. |

- Enter a plain number (e.g. `16`) and `px` is appended automatically, or specify a unit (e.g. `1.2rem`).
- Leave empty to use the theme default.

---

### Site Identity

| Control | Description |
|---|---|
| **Show Tagline** | Toggle the site tagline visibility (yes/no). |
| **Tagline Color** | Color picker for the tagline (only visible when tagline is enabled). |

---

### Header

| Control | Description |
|---|---|
| **Header Extra Text** | Add custom text below the navigation in the vertical header layout. |
| **Extra Text Font Size** | Control the font size of the extra text. |
| **Extra Text Font** | Choose a font for the extra text (supports custom uploaded fonts). |

> These controls are only visible when the **Vertical** header layout is selected.

---

### Blog Options

| Control | Description |
|---|---|
| **Blog Display Type** | Choose between **Grid**, **Masonry**, or **List** layout. |
| **Blog List Style** | When List is selected: **Style 1 — Compact** or **Style 2 — Editorial** (see below). |
| **Excerpt Word Count** | Number of words shown in the blog list excerpt (default: 40, range: 5–100). |
| **Blog Text Alignment** | Align blog content left, center, or right. |
| **Content Width Behavior** | `Full` (default) or `Constrained` (caps content at 1240px). |
| **Single Post Title Color** | Color picker for the blog post title on single post pages. |
| **Blog List Title Color** | Color picker for post titles on the blog archive/list page. |
| **Title Bottom Spacing** | Adjust spacing below the single post title. |
| **Show Comments** | Enable or disable comments on blog posts. |
| **Comments Title Color** | Color for the "Leave a Reply" heading. |
| **Comments Reply Color** | Color for the "Comments" heading. |

#### Blog List Styles

When **List** is selected as the display type, two styles are available via the **Blog List Style** dropdown:

**Style 1 — Compact**
- **170×170px thumbnail** on the left, **title, date, and excerpt** on the right.
- Constrained to **1000px max-width** for comfortable reading.

**Style 2 — Editorial**
- **Large landscape featured image** on top (full width of the first two columns).
- Below the image: **3-column layout** — post title (left), excerpt (center), and meta info with date, author, and comment count (right, uppercase).

Both styles share these behaviors:
- **Blog List Style** and **Excerpt Word Count** controls appear only when List is selected.
- Card-related controls (card style, image aspect ratio, card gap, hover color, columns) are automatically hidden.
- Fully responsive — stacks vertically on mobile (≤480px).

---

### Portfolio Options

| Control | Description |
|---|---|
| **Featured Image Size** | Proportional width scaling for the single portfolio featured image (Original, 90%, 80%, 75%, 66%, 50%, 33%, 25%). |
| **Content Width Behavior** | `Full` or `Constrained` for portfolio single pages. |
| **Portfolio Title Color** | Color for portfolio titles on the archive/grid page. |
| **Single Portfolio Title Color** | Color for the title on single portfolio pages. |
| **Show Comments** | Enable or disable comments on portfolio posts. |
| **Comments Title Color** | Color for the "Leave a Reply" heading. |
| **Comments Reply Color** | Color for the "Comments" heading. |

---

### Social Media

| Control | Description |
|---|---|
| **Social Icons Brand Colors** | Toggle between inheriting the text color or using official brand colors for social icons and share buttons. |
| **Social Links** | Accepts full HTML (SVG icons supported) via `wp_kses_post` sanitization. |

The brand colors control appears in both the Social Media and Portfolio Options sections for discoverability.

---

## File Structure

```
oneguy/
├── README.md                  ← This file
├── CUSTOM_FONTS_README.md     ← Detailed custom font documentation
├── style.css                  ← Theme header + CSS overrides
├── functions.php              ← All customizer settings, dynamic CSS, hooks
├── index.php                  ← Blog home template (list mode support)
├── archive.php                ← Archive template (list mode support)
├── screenshot.png             ← Theme screenshot
├── inc/
│   └── unified-font-upload.php ← Font upload admin page
├── js/
│   ├── customizer-controls.js  ← Customizer UI logic (visibility toggles, font dropdown)
│   └── content-width.js        ← Gutenberg constrained width override
└── templates/
    ├── blocks/
    │   └── blog-list.php       ← Blog list display template
    ├── loop-templates/
    │   ├── content-single.php  ← Single blog post template
    │   └── content-portfolio.php ← Single portfolio template
    └── pages/
        ├── blog-template.php   ← Blog Template page override
        └── blog-list-page.php  ← Standalone list page (loaded via template_include)
```

---

## Requirements

- WordPress 6.0+
- Minimalio parent theme (with premium plugin - for portfolio options)
- PHP 7.4+

---

## Author

**Sriram Govindan**
[oneguy.net](https://oneguy.net)

---

## License

GNU General Public License v2 or later
