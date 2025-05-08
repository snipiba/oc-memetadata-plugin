# MEMetadata plugin for OctoberCMS

This plugin extends the default Media Library in OctoberCMS by enabling the assignment and display of **metadata for media files**, especially images. It provides:

- ability to **edit metadata** (title, description, author, source, keywords),
- a **Twig filter** `|metadata`,
- a **frontend component** `ImageBlock`,
- **integration into the Media Library UI** (popup + sidebar),
- and **accessibility-ready output** (WAI/WCAG).

---

## ✏️ Editing metadata

Inside `Media > Library`, each file row includes an ✎ icon. Clicking it opens a modal where you can define:

- Title
- Description
- Keywords
- Author + URL
- Source + URL

These values are stored in the database and can be displayed in the frontend.

---

## 🧩 Component: `ImageBlock`

Renders an image along with its metadata based on selected layout and settings.

### ✅ Available properties:

| Property             | Type      | Description                                        |
|----------------------|-----------|----------------------------------------------------|
| `image`              | string    | Media file path (e.g., `/content/myimage.jpg`)    |
| `showTitle`          | checkbox  | Display title (default: ✅)                        |
| `showDescription`    | checkbox  | Display description                               |
| `showKeywords`       | checkbox  | Display keywords                                  |
| `layout`             | dropdown  | `meta-in-image` or `meta-below-image`             |
| `textAlign`          | dropdown  | `left`, `center`, `right`                         |
| `useDefaultStyles`   | checkbox  | Add default styles for layout (default: ✅)        |

---

## 🎨 HTML structure output

```html
<figure class="image-block meta-in-image imageblock-default text-center">
    <img src="/storage/app/media/content/example.jpg" alt="Alt text" loading="lazy" />
    <figcaption>
        <h2 class="image-title">Title</h2>
        <p class="image-description">Image description...</p>
        <div class="meta">
            <p class="image-author">
                <span>Author:</span> <a href="..." class="external-link" target="_blank">John Doe</a>
            </p>
            <p class="image-source">
                <span>Source:</span> ChatGPT
            </p>
            <p class="image-keywords">
                <strong>Keywords:</strong> scam,fraud,pirate
            </p>
        </div>
    </figcaption>
</figure>
