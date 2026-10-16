### Установка

Добавить в `tailwind.admin.config.js`, созданный в пакете `tailwindcss-theme`.

    "./vendor/4geo35/product-collection/src/resources/views/components/**/*.blade.php",
    "./vendor/4geo35/product-collection/src/resources/views/admin/**/*.blade.php",
    "./vendor/4geo35/product-collection/src/resources/views/livewire/admin/**/*.blade.php",

Добавить в `tailwind.config.js`, созданный в пакете `tailwindcss-theme`.

    "./vendor/4geo35/product-collection/src/resources/views/components/**/*.blade.php",
    "./vendor/4geo35/product-collection/src/resources/views/web/**/*.blade.php",
    "./vendor/4geo35/product-collection/src/resources/views/livewire/web/**/*.blade.php",

Запустить миграции для создания таблиц `php artisan migrate`

#### Views

Сокращение для представлений: `pct`  
Меню для панели администрирования: `<x-pct::menu-item/>`  

#### Livewire Components

- `pct-web-collection-product-teaser-choose-variation`
- `pct-web-collection-product-teaser-variation-to-cart`

#### Config

Название файла: `product-collection`

- `useShufflePreview` => `false`: По умолчанию сортируется по заголовку
- `previewItemCount` => `3`
