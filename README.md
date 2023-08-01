### Simple API for PDF documents

## Definition
This application was built in PHP/Laravel and allows a complete file management, including:
- manage document types;
- manage columns in documents by type;
- create documents based on a type and their columns (the application validates the columns based on document type);
- download the document in PDF format;

Libs and packages:
- Laravel Jetstream;
- barryvdh/laravel-dompdf;
- darkaonline/l5-swagger;

## Instalation
- git clone;
- composer install;
- npm install;
- npm run build;
- cp .env.example .env;
- php artisa key:generate;
- update env vars;
- php artisan migrate;

## Usage

- Create Document Type using the endpoint /api/types;
- Create Document Columns using the endpoint /api/columns;
- Create Documents using the endpoint /api/documents;
- Download documents using the endpoint /api/documents/{id}/download;

## License

This application is an open-sourced software licensed under the MIT license.