# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

A **Joomla site module** (`mod_thoughtoftd`, "Thought for Today"), targeting **Joomla 4, 5 and 6 on PHP 8.1+**, that fetches a daily inspirational thought from the Brahma Kumaris remote API and renders it through one of several Bootstrap 5 layouts. There is no application server here — the code runs inside a host Joomla installation. You cannot run it standalone; you build a ZIP and install it into Joomla to test end to end. It uses the legacy entry-point pattern (`mod_thoughtoftd.php` + a namespaced static helper), not the `services/provider.php` dispatcher — still supported in J6, but the eventual modernisation target.

## Build & validate

The build copies the runtime files (PHP, `Helper/`, `language/`, `media/`, `tmpl/`) into a staging dir and zips them as `mod_thoughtoftd_v<VERSION>.zip`, where VERSION comes from the `<version>` tag in `mod_thoughtoftd.xml`. Build tooling and docs (`build.*`, `*.md`) are deliberately excluded from the package.

```bash
./build.sh          # build the installable ZIP (reads VERSION from the manifest)
build.bat           # Windows equivalent (uses PowerShell for zipping)
```

There is no unit test suite. Quick local sanity checks (the same ones CI runs):

```bash
for f in mod_thoughtoftd.php Helper/ThoughtoftdHelper.php tmpl/*.php; do php -l "$f"; done   # PHP lint
```

Real verification means installing the ZIP into a Joomla site (Extensions → Install). When bumping the version, edit `<version>` in `mod_thoughtoftd.xml`; everything else (build output name, release tag check, `update.xml`) derives from it.

## Release & update flow

Two GitHub Actions workflows under `.github/workflows/`:

- **`ci.yml`** — on every PR and push to `main`/`master`: lints PHP across a 8.1/8.2/8.3 matrix, validates the XML manifest and language INIs, runs `build.sh`, and uploads the ZIP as a build artifact. Gatekeeper only; publishes nothing.
- **`release.yml`** — on a `v*` tag (or manual dispatch): lints, **verifies the tag matches `<version>` in the manifest** (e.g. tag `v5.1.0` ⇒ manifest `5.1.0`, else it fails), builds, creates a GitHub Release with the ZIP attached, then rewrites `update.xml` to the new version/download URL and commits it back to `main`.

To cut a release: bump `<version>` in `mod_thoughtoftd.xml`, merge, then `git tag vX.Y.Z && git push origin vX.Y.Z`.

`update.xml` (repo root) is Joomla's update feed. The manifest's `<updateservers>` points at it via `raw.githubusercontent.com/BKWSU-UK/mod_thoughtoftd/main/update.xml`, and its `<downloadurl>` points at the release asset. **Do not hand-edit `update.xml`'s version/URL** — `release.yml` keeps it in sync; the `release.yml` auto-commit assumes `main` is pushable by `GITHUB_TOKEN` (breaks under branch protection). `<targetplatform>` there advertises Joomla 4/5/6 and `<php_minimum>` is 8.1.

## Architecture

The request flow is a straightforward Joomla module pipeline:

1. **`mod_thoughtoftd.php`** (entry point) — reads module params, assembles the API URL from `base_url` + `orgids` + `lang` + `specificday`, calls the helper to fetch, then `require`s the selected layout from `tmpl/`.
2. **`Helper/ThoughtoftdHelper.php`** (`Joomla\Module\Thoughtoftd\Site\Helper\ThoughtoftdHelper`) — does the network fetch (`getth2`) via Joomla's `HttpFactory` HTTP client with a timeout, returning a decoded `stdClass` or `false` on any failure. It also holds the **shared view logic** the layouts call so they stay thin: `isValidResponse()` (the `statusCode == 0` guard), `loadAssets()` (Web Asset Manager registration), `getThoughtImage()` (the whole `show_image` mode switch, returning rendered `<img>` HTML), and `getReadMoreAttributes()`. Plus image enumeration (`getImageOfTheDay`, `getImages`) and folder sanitisation (`getFolder`).
3. **`tmpl/*.php`** (layouts) — four interchangeable views: `default.php`, `card.php`, `cardhorizontal.php`, `cardoverlay.php`. Selected via the standard Joomla "Alternative Layout" advanced param. They share the helper methods above, so they differ only in markup/CSS classes — **edit shared behaviour in the helper, not per-template**. Each calls `ThoughtoftdHelper::isValidResponse($answ)` and falls back to the `defaultmsg` param when the fetch failed.

Key cross-cutting conventions:

- **Graceful degradation is the contract.** The helper never lets a network/JSON error surface as a PHP warning — it logs and returns `false`, and every layout renders the configured default message instead. Preserve this when editing fetch/render code.
- **The API response shape** is `{ statusCode, text, topic, image }`; `statusCode == 0` means success. `text` is rendered as raw HTML (the API is trusted to return safe markup); `topic` is escaped.
- **Image modes** (`show_image` param): `none`, `random` (rotates daily over files in `folder`), `static` (`default_img_link`), or `database` (uses `image` from the API response). Image selection lives entirely in the helper.
- **Assets** load via Joomla's Web Asset Manager, not direct `<script>`/`<link>` tags. The read-more collapse JS (`media/js/thoughtoftd.js`) and `bootstrap.collapse` are only registered when the `read_more` param is on.
- **Read-more / collapsible text** is opt-in (`read_more` param). Layouts emit `.thought-text-collapsible` with `data-collapsed-height`/`data-more-text`/`data-less-text`; the JS wraps it in a Bootstrap collapse at runtime.

## Diagnostics

The module logs to Joomla's logger under the `mod_thoughtoftd` category → `administrator/logs/mod_thoughtoftd.php`. **ERROR logs (fetch/JSON failures) are always written.** The verbose INFO logs (request URL, truncated raw response, response dump) only fire when the `debug` module param is enabled — off by default, so production stays quiet. `getth2()` takes a `$debug` flag the entry point passes through from that param. See `DEBUGGING.md` for the message catalogue and common API failure modes.

## Localisation

Strings live in `language/<locale>/` for `en-GB`, `es-ES`, `fi-FI`, `pt-PT`, `ru-RU`. User-facing text uses `MOD_THOUGHTOFTD_*` keys via `Text::_()`; add new keys to every locale's `.ini`.

## Reference docs

- `BUILD.md` / `BUILD_QUICK_REFERENCE.md` — build system details (note: these still document a since-removed `Makefile`; use `build.sh`/`build.bat`).
- `LAYOUTS.md` — visual descriptions, use-cases, and image recommendations for each layout.
- `DEBUGGING.md` — logging locations, log message reference, and API troubleshooting.
