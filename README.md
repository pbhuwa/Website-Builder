# Website Builder

## Features Implemented

### Core Functionality
- **Dynamic Element Preview**: Renders all website elements (header, homepage, services, about-us, contact, footer) in a preview canvas
- **Position-Accurate Rendering**: Maintains exact element positioning from the editor using absolute positioning
- **Element Controls**: Property editors for each element type (text, colors, etc.)

### Technical Features
- **Vue 3 Composition API**: Modern Vue implementation
- **TypeScript Support**: Type-safe component architecture
- **Element Plus Integration**: UI components for consistent design
- **Dynamic Component Loading**: Loads element components based on type
- **Responsive Design**: Currently adapts only for labtop

## Time Spent

| Task                      | Hours |
|---------------------------|-------|
| Components Setup           | 7     |
| Position Handling          | 6     |
| Core Preview Functionality | 8     |
| Bug Fixes & Optimization   | 5     |
| **Total**                 | **26**|

## Key Decisions

1. **Absolute Positioning for Elements**
   - Chose to maintain absolute positioning from editor to preserve exact layouts
   - Why: Critical for WYSIWYG accuracy between editor and preview

2. **Device Simulation Approach**
   - Used CSS transforms for device scaling rather than viewport meta
   - Why: Maintained consistent behavior across all elements

3. **Dynamic Component System**
   - Created component map system for element rendering
   - Why: Allowed flexible addition of new element types

## If I Had More Time...

### Immediate Improvements
- [ ] Add element hover states in preview mode
- [ ] Add more device size presets (e.g., landscape tablet)

### Future Enhancements
- [ ] Interactive element editing in preview mode
- [ ] Preview performance optimizations for complex pages
- [ ] Settings/configuration features improvements

## System Requirements

- PHP 8.1+
- MySQL 5.8
- Node.js 16+
- Composer 2+
- NPM 8+
- Git

## Backend (Laravel) Installation

### 1. Clone the Repository

```
git clone https://github.com/pbhuwa/Website-Builder.git
cd website-builder
```

### 2. Install Dependencies

```
composer install
```

### 3. Configure Environment

```
cp .env.example .env
```

Edit `.env` with your database credentials:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=website_builder
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate Application Key

```
php artisan key:generate
```

### 5. Run Database Migrations

```
php artisan migrate
```

### 6. Set Up Storage

```
php artisan storage:link
```

### 7. Start Development Server

```
php artisan serve
```

## Frontend Installation & Usage

```
npm install
npm run dev
```

## Component Structure
```
/js
  /components
    HeaderElement.vue
    HomeElement.vue
    ServicesElement.vue
    AboutUsElement.vue
    ContactElement.vue
    FooterElement.vue
    PreviewPage.vue
    ...
```

## Dependencies
- Vue 3
- Element Plus
- TypeScript
- Tailwind Css
```
