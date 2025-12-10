# Finlo Test Task

A simple yet powerful Laravel-based products management application that allows users to view, search, and add products to a SQLite database.

## Features

- **Search**: Search products by title using a keyword search
- **Sorting**: Sort products by creation date (newest first or oldest first)
- **Creation**: Form to add new products
- **Pagination**: Products are paginated with 10 items per page


## Installation

1. **Clone the repository**:
```bash
git clone https://github.com/tooruu/finlo-intro
cd finlo-intro
```

2. **Set up environment and database**:
```bash
composer run-script setup
```

## Features Explained

### Search Implementation
- Uses SQL `LIKE` operator for flexible title matching
- Case-insensitive search
- Searches across product titles only
- Results maintain the current sort order

### Sorting Implementation
- Sorts by `created_at` timestamp
- Default sort order: newest first (descending)
- Click the table header to toggle between ascending/descending
- Sort order is preserved when searching

### Pagination
- 10 products per page
- Navigation links appear when results exceed 10 items
- Search and sort parameters are maintained across pages
