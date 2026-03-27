# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/), and this project adheres to 
[Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]
### Added
- Add Vue.js
- Add initial database setup command `bin/console app:database:setup`
- Add `ErrorController` and custom error pages

### Changed
- Swap Webpack to Vite for asset builds (+ HMR)
- Refactor database setup SQL to allow processing with PHP
- Rename `Auth` schema to `Authentication`
- Refactored Authentication system to use Vue
- Improved default styling

### Removed
- Remove Webpack
- Remove unnecessary custom CSS

---

Versions 1.0.0 and below are not included here since this CHANGELOG was created in a later version.