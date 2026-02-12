# Custom Font Feature for Minimalio Theme

This feature allows you to upload and use custom fonts in your Minimalio WordPress theme, alongside the existing Google Fonts functionality.

## Unified Font Upload Interface

**Location:** Appearance → Font Upload

The unified interface provides two upload methods in tabbed format, with a shared uploaded fonts section below.

### 1. Simple Upload Tab (Recommended)
**Best for:** Most users, quick setup, single font files

Upload a single font file and automatically generate standard weights (Regular 400, Bold 700, and their italic versions). The browser handles weight variations.

### 2. Advanced Upload Tab
**Best for:** Advanced users, specific font variants, complete control

Upload multiple font variants (Regular, Bold, Italic, etc.) for precise control over different weights and styles.

---

## How to Use

### 1. Access Font Upload

1. Go to **Appearance > Font Upload** in your WordPress admin dashboard
2. Choose between **Simple Upload** or **Advanced Upload** tabs

### 2. Simple Upload (Recommended)

1. Click the **Simple Upload** tab
2. Enter a font name (e.g., "My Custom Font")
3. Upload a single font file (WOFF, WOFF2, TTF, or OTF)
4. Click "Upload Font"

### 3. Advanced Upload

1. Click the **Advanced Upload** tab
2. Enter a font name (e.g., "My Custom Font")
3. Upload multiple font files for different variants:
   - Regular (400)
   - Bold (700)
   - Italic (400)
   - Bold Italic (700)
   - Light (300)
   - Light Italic (300)
4. Click "Upload Font"

### 4. Use Fonts in Customizer

1. Go to **Appearance > Customize**
2. Navigate to **Minimalio Options > Typography**
3. In the "Main Google Font" dropdown, fonts are organized as:
   - **Your Custom Fonts** (uploaded fonts appear first)
   - **Default Fonts** (Arial, Verdana, etc.)
   - **Google Fonts** (extensive Google library)
4. Select your uploaded font
5. Configure typography settings:
   - **Font Weight**: Choose available weights (400, 700, etc.)
   - **Font Style**: Choose Normal or Italic
   - **Size, Line Height, Spacing**: Adjust as needed
6. Click "Publish"

---

## Features

### Unified Interface
- **Single Admin Page**: One location for all font management
- **Tabbed Navigation**: Easy switching between Simple and Advanced upload
- **Shared Font List**: See all uploaded fonts in one table
- **Type Badges**: Visual indicators for Simple vs Advanced fonts

### Font Management
- **Two Upload Methods**: Choose between simple (single file) or advanced (multiple variants)
- **File Format Support**: WOFF, WOFF2, TTF, and OTF formats
- **Font Deletion**: Remove unwanted fonts with one click
- **Organized Display**: Custom fonts shown first in dropdown

### Typography Integration
- **Organized Dropdown**: Custom fonts first, then defaults, then Google fonts
- **Visual Separators**: Clear divisions between font categories
- **Performance**: Uses `font-display: swap` for better loading
- **Automatic Weight Generation**: Simple approach generates standard weights

---

## Technical Details

### File Storage
Custom fonts are stored in: `/wp-content/uploads/minimalio-fonts/`

### Data Storage
- Simple fonts: `minimalio_simple_custom_fonts` option
- Advanced fonts: `minimalio_custom_fonts` option

### CSS Generation
- **Simple**: Generates `@font-face` declarations for 400, 700 weights (normal and italic) from a single file
- **Advanced**: Generates `@font-face` for each uploaded variant

### Font Organization in Customizer
```
Your Custom Fonts:
├── My Custom Font (Simple)
├── Another Font (Advanced)
--- Default Fonts ---
├── Arial
├── Verdana
├── Times New Roman
--- Google Fonts ---
├── Open Sans
├── Roboto
├── Lato
└── [500+ more fonts]
```

### Font Weight Mapping (Advanced)
- `regular` → `400`
- `italic` → `400` (italic style)
- `700` → `700`
- `700italic` → `700` (italic style)
- `300` → `300`
- `300italic` → `300` (italic style)

### Font Weight Availability (Simple)
- 400 (Regular)
- 700 (Bold)
- Both available in Normal and Italic styles

---

## Troubleshooting

### Font Not Showing Up
1. Ensure the font files were uploaded successfully
2. Check that the font is selected in the Customizer
3. Clear your browser cache and any caching plugins

### Font Files Not Uploading
1. Check file permissions on the uploads directory
2. Ensure the files are in supported formats (WOFF, WOFF2, TTF, OTF)
3. Verify the file size is within upload limits

### Font Not Applying Correctly
1. Make sure you've published your Customizer changes
2. Check that the font weight/style settings match your expectations
3. Verify CSS is loading correctly in browser developer tools

### Only Regular Weight Available
- This is normal for the **Simple Upload** approach
- Use the Customizer to apply Bold (700) weight - the browser will synthesize it
- For true bold variants, use the **Advanced Upload** approach

### Can't Find Uploaded Font in Customizer
1. Check the **Uploaded Fonts** section at the bottom of the Font Upload page
2. Ensure the font was successfully uploaded (no error messages)
3. Look in the **Your Custom Fonts** section at the top of the font dropdown

---

## Security Notes

- All file uploads are validated for file type
- Only users with `edit_theme_options` capability can upload fonts
- Font file names are sanitized to prevent directory traversal
- All data is properly escaped in CSS output

---

## Browser Compatibility

The custom font system supports all modern browsers:
- Chrome 4+
- Firefox 3.5+
- Safari 3.1+
- Edge 12+
- IE 9+ (limited format support)

WOFF and WOFF2 formats provide the best browser compatibility and file size optimization.

---

## Recommendations

**For most users:** Use the **Simple Upload** tab. It's easier, faster, and provides excellent results for most use cases.

**For advanced users:** Use the **Advanced Upload** tab when you need:
- Specific font variants (Light, Black, etc.)
- True bold and italic fonts (not browser-synthesized)
- Complete control over font rendering

**Interface Benefits:**
- **Unified Location**: All font management in one place
- **Easy Navigation**: Tabs make switching between methods simple
- **Shared Management**: See and manage all uploaded fonts from either tab
- **Organized Selection**: Custom fonts appear first in the customizer dropdown

---

## Additional Typography Features

### Blog Text Alignment

The theme now includes text alignment options for blog posts:

**Location:** Appearance → Customize → Minimalio Options → Blog Options → Blog Text Alignment

**Options:**
- **Left (Normal)** - Standard left-aligned text
- **Center** - Centered text content
- **Right** - Right-aligned text content  
- **Justified** - Text with justified alignment (even left and right edges)

**Affected Areas:**
- Single post content (`.single-post .entry-content`)
- Blog post card excerpts (`.blog-post-type .post-card__excerpt`)

**Use Cases:**
- **Justified**: Traditional newspaper/magazine style for formal content
- **Center**: Artistic or poetic content
- **Right**: Creative layouts or specific design requirements
- **Left**: Standard web content (recommended for most blogs)

### Content Width Behavior

Control how featured images and Gutenberg blocks are displayed:

**Location:** Appearance → Customize → Minimalio Options → Blog Options → Content Width Behavior

**Options:**
- **Constrained** - All content (featured image + text) same width for consistency
- **Full-Width Gutenberg (Default)** - Allow Gutenberg blocks to break out to full browser width  

**Behavior Details:**

#### Constrained
- Featured image: Constrained to container width (1240px max), left-aligned
- Gutenberg blocks: All blocks constrained to same width, left-aligned
- Classic editor: Perfect consistency
- **Best for:** Bloggers, traditional content, consistent layouts

#### Full-Width Gutenberg (Default)
- Featured image: Full viewport width
- Gutenberg blocks: `.alignfull` blocks break out to full viewport width
- Classic editor: No effect (no alignment classes)
- **Best for:** Designers, creative content, full-width layouts

**Technical Notes:**
- Uses CSS overrides to control `.alignfull` block behavior
- JavaScript full-width handling is disabled when needed
- Maintains consistency between Classic Editor and Gutenberg
- Responsive design preserved across all options
- Content is left-aligned (not centered) to match full-width positioning
