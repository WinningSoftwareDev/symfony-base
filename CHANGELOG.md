# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/), and this project adheres to 
[Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [2.0.2] - 2026-03-28
### Changed
- Updated default Favicon
- Updated default icon logo displayed on app index

### Fixed
- Fix to ensure that `vite.config.template.ts` is deleted on correctly app install

## [2.0.1] - 2026-03-28
### Added
- Added new `VITE_SERVER_PORT` and `VITE_LOCAL_PORT` environmental variables

### Fixed
- Fixed critical path issue in `Installer.php`

## [2.0.0] - 2026-03-28
### Added
- Added Vue.js
- Added HMR support
- Added initial database setup command `bin/console app:database:setup`
- Added `ErrorController` and custom error pages
- Added `CHANGELOG` for tracking changes to the project
- Added ESLint and configured for TypeScript/Vue
- Added a Bitbucket pipeline script including PHP Stan, PHP CS Fixer and ESLint steps

### Changed
- Swapped Webpack for Vite
- Refactored database setup SQL to allow processing with PHP
- Renamed `Auth` schema to `Authentication`
- Renamed '_Core' schema to 'Core'
- Refactored Authentication system to use Vue
- Improved default styling

### Removed
- Removed Webpack
- Removed unnecessary custom CSS

---

Versions 1.0.0 and below are not included here since this CHANGELOG was created in a later version.