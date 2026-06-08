# Nusa Data Indonesia (NDI) — Portal & CMS

## Tech Stack
- **Frontend:** Tailwind CSS (via CDN `<script src="https://cdn.tailwindcss.com">`, no build step)
- **Backend:** Native PHP (no Composer, no autoloader, raw `require`)
- **Database:** MySQL (raw mysqli/PDO, prepared statements wajib)

## Branch Architecture

Empat branch paralel, masing-masing untuk satu peran. Direktori `dhika/`,
`ridha/`, `tama/`, `raja/` adalah `git worktree` — setiap folder terikat ke
branch sendiri dan bisa diedit simultan.

| Branch | Worktree Folder | Owner | Domain |
|---|---|---|---|
| `branch/dhika-frontend` | `dhika/` | Dhika | Public pages (Landing, About, Services, Contact) |
| `branch/ridha-core` | `ridha/` | Ridha | DB schema, admin auth, visitor stats |
| `branch/tama-cms` | `tama/` | Tama | Article CRUD, image upload |
| `branch/raja-pages` | `raja/` | Raja | Public article pages, contact email |

Setiap branch hanya berisi file milik peran tersebut. Tidak ada file asing.

---

## Dhika — Frontend (`branch/dhika-frontend`)

```
public/
├── index.php               # Entrypoint + routing front controller
├── css/
│   └── style.css           # Full brutalist animations
└── js/
    └── main.js             # Lenis smooth scroll + NDIAnimator class
app/
├── controllers/
│   └── PageController.php
├── views/
│   ├── landing.php
│   ├── about.php
│   ├── services.php
│   ├── contact.php
│   └── partials/
│       ├── header.php
│       └── footer.php
├── helpers/
│   └── functions.php
├── helpers/
│   └── Visitor.php         # Visitor tracking (null-safe DB)
├── models/
│   └── Visitor.php         # Visitor model
config/
└── database.php            # Null-safe getDB()
```

### Aturan
- Responsive wajib 3 breakpoint: `lg:` (≥1024px), `md:` (768–1023px), `


- Tidak boleh horizontal scroll di breakpoint manapun
- Contact form handler: POST ke /contact dengan validasi + DB insert
- Header/footer konsisten via partials
- Animasi via CSS clip-path + class NDIAnimator

---

## Ridha — Core & Database (`branch/ridha-core`)

```
config/
└── database.php             # DB connection (mysqli)
app/
├── controllers/
│   └── AuthController.php   # Login / logout / session / requireAuth
├── models/
│   ├── User.php
│   ├── Visitor.php
│   └── Contact.php
├── helpers/
│   └── Visitor.php          # Page view tracker (middleware-style)
└── views/
    └── admin/
        └── login.php        # Brutalist dark login form
database/
└── schema.sql               # Tabel: users, visitors, pages, contacts, articles
public/
└── index.php                # Minimal admin router (login/logout/mini dashboard)
setup.php                    # DB initialization script
```

### Aturan
- Semua query: prepared statement — zero string concatenation
- Password: `password_hash()` (bcrypt) + `password_verify()`
- Session-based auth (native `$_SESSION`)
- Visitor stats: insert per request — IP, User-Agent, page, timestamp
- Contact model: create + getAll + count

---

## Tama — CMS (`branch/tama-cms`)

```
app/
├── controllers/
│   └── ArticleController.php
├── models/
│   └── Article.php
├── helpers/
│   └── Uploader.php
└── views/
    └── admin/
        ├── login.php                 # Auth for standalone testing
        ├── partials/
        │   ├── admin_header.php
        │   └── admin_footer.php
        └── articles/
            ├── index.php
            ├── create.php
            ├── edit.php
            └── show.php
public/
├── index.php                # Article admin router + login
└── uploads/                 # Gambar per artikel
config/
└── database.php             # Template constants
setup.php                    # DB initialization
```

### Aturan
- Validasi upload: ekstensi (`jpg/png/gif/webp`), MIME type, max 2MB
- Nama file unik: `{timestamp}_{random6}.{ext}`
- Direktori: `public/uploads/articles/{YYYY}/{MM}/` (auto-buat dengan `mkdir()`)
- CRUD: prepared statement + `htmlspecialchars()` untuk output
- Hanya published articles yang tampil di publik (raja domain)

---

## Raja — Public Article Pages & Contact Email (`branch/raja-pages`)

```
public/
├── index.php               # Router: /articles, /articles/{slug}, /contact POST
├── css/
│   └── style.css           # Copy of brutalist animations
└── js/
    └── main.js             # Copy of NDIAnimator class
app/
├── controllers/
│   └── ArticlePublicController.php  # Listing + detail + 404
├── helpers/
│   └── Mailer.php          # SMTP email sending (template, isi nanti)
└── views/
    ├── articles/
    │   ├── index.php       # Public article listing grid
    │   └── show.php        # Public article detail
    └── partials/
        ├── header.php      # Minimal NDI navbar with ARTICLES link
        └── footer.php      # Minimal footer with Lenis + JS
config/
├── database.php            # Null-safe getDB()
└── mail.php                # SMTP config template (isi nanti)
database/
└── schema.sql              # No additional tables (uses articles + contacts)
```

### Aturan
- Public article listing: grid 3 kolom, thumbnail, excerpt, pagination
- Public article detail: hero image, content, meta (date, author)
- Contact POST: simpan ke DB + (nanti) kirim email via Mailer
- Hanya published articles yang ditampilkan
- Query via ArticlePublicController (tidak duplicate Article model — panggil via controller langsung)

---

## Commit Workflow

| Pekerjaan | Folder kerja | Branch tujuan |
|---|---|---|
| Kerjaan Dhika (dari laptop ini) | `dhika/` → `git commit` | `branch/dhika-frontend` |
| Kerjaan Ridha | `ridha/` → salin ke laptop Ridha → Ridha commit | `branch/ridha-core` |
| Kerjaan Tama | `tama/` → salin ke laptop Tama → Tama commit | `branch/tama-cms` |
| Kerjaan Raja | `raja/` → salin ke laptop Raja → Raja commit | `branch/raja-pages` |

Setelah clone ulang, setup ulang worktree dengan:
```
git worktree add dhika branch/dhika-frontend
git worktree add ridha branch/ridha-core
git worktree add tama   branch/tama-cms
git worktree add raja   branch/raja-pages
```
