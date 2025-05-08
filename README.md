# MEMetadata plugin for OctoberCMS

This plugin extends the default Media Library in OctoberCMS by enabling the assignment and display of **metadata for media files**, especially images. It provides:

- the ability to **edit metadata** (title, description, author, source, keywords)
- a **Twig filter** `|metadata`
- a **frontend component** `ImageBlock`
- **integration into the Media Library UI** (popup + sidebar)
- output compliant with **WAI/WCAG accessibility standards**

---

## Editing metadata

In the Media section (`Media > Library`), every file includes an ✎ icon. Clicking it opens a modal where you can define:

- Title
- Description
- Keywords
- Author + URL
- Source + URL

These values are stored in the database and can be reused on the frontend.

---

## Component: ImageBlock

Renders an image with its metadata according to layout settings.

### Available properties:

- `image`: string – Media file path (e.g. `/content/myimage.jpg`)
- `showTitle`: checkbox – Display the title (default: true)
- `showDescription`: checkbox – Display description (default: true)
- `showKeywords`: checkbox – Display keywords (default: true)
- `layout`: dropdown – Layout mode: `meta-in-image` or `meta-below-image`
- `textAlign`: dropdown – Text alignment: `left`, `center`, `right`
- `useDefaultStyles`: checkbox – Use bundled styles (default: true)

---

## HTML structure (output)

The generated HTML follows this pattern:

Figure container: `figure.image-block`

Depending on selected layout:

- `meta-in-image` → metadata overlaps the image
- `meta-below-image` → metadata placed below image

Inside the figure:

- `img` with alt text and lazy loading
- `figcaption` containing:
  - `h2.image-title` (if `showTitle`)
  - `p.image-description` (if `showDescription`)
  - `p.image-author` (with optional link)
  - `p.image-source` (with optional link)
  - `p.image-keywords` (if `showKeywords`)

---

## CSS classes (for custom styling)

If you disable the built-in styles via `useDefaultStyles`, you are expected to define styles for the following classes:

- `image-block` – wrapper for the entire block
- `meta-in-image` – layout modifier (text over image)
- `meta-below-image` – layout modifier (text under image)
- `image-title` – title heading
- `image-description` – paragraph text
- `image-author` – author row
- `image-source` – source row
- `image-keywords` – list of keywords/tags
- `external-link` – class for links pointing outside (optionally styled with an icon)

---

## Twig filter: `|metadata`

If you want to access metadata in Twig without using a component, use the `|metadata` filter:

Example:

- `{% set meta = '/content/example.jpg' | metadata %}`
- `{{ meta.title }}`
- `{{ meta.description }}`

---

## Media Library sidebar integration

When a media file is clicked in the Media Library, this plugin automatically injects the related metadata into the right-hand sidebar, below the default file info table.

If metadata exists, it will display:

- A `Media Metadata` heading
- Author (with link if available)
- Source (with link if available)

This block is injected dynamically and does not duplicate on repeated clicks.

---

## Installation

1. Copy plugin to `plugins/snipi/memetadata`
2. (Optional) Run `php artisan october:up` if you use migrations
3. Use the component or Twig filter in your layout

---

## Accessibility

This plugin aims to follow [WAI-ARIA](https://www.w3.org/WAI/standards-guidelines/) and WCAG best practices:

- semantic HTML
- alt text
- lazy loading
- external links use `rel="noopener"` and `target="_blank"`

---

## License

MIT. Use at your own risk.
