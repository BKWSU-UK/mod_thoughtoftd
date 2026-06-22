# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

A **Joomla 5 site module** (`mod_thoughtoftd`, "Thought for Today") that fetches a daily inspirational thought from the Brahma Kumaris remote API and renders it through one of several Bootstrap 5 layouts. There is no application server here — the code runs inside a host Joomla installation. You cannot run it standalone; you build a ZIP and install it into Joomla to test end to end.

## Build & validate

The build copies the runtime files (PHP, `Helper/`, `language/`, `media/`, `tmpl/`) into a staging dir and zips them as `mod_thoughtoftd_v<VERSION>.zip`, where VERSION comes from the `<version>` tag in `mod_thoughtoftd.xml`. Build tooling and docs (`build.*`, `Makefile`, `*.md`) are deliberately excluded from the package.

```bash
make build          # build the installable ZIP (alias: make package, or ./build.sh)
make test           # validate required files exist + XML/PHP syntax
make clean          # remove build/ and generated ZIPs
make info           # show version, file counts, available layouts
make clean build    # clean rebuild
```

On Windows use `build.bat` (uses PowerShell for zipping). There is no unit test suite — `make test` is a structural/syntax sanity check only. Real verification means installing the ZIP into a Joomla site (Extensions → Install).

When bumping the version, edit `<version>` in `mod_thoughtoftd.xml`; the build scripts read it automatically.

## Architecture

The request flow is a straightforward Joomla module pipeline:

1. **`mod_thoughtoftd.php`** (entry point) — reads module params, assembles the API URL from `base_url` + `orgids` + `lang` + `specificday`, calls the helper to fetch, then `require`s the selected layout from `tmpl/`.
2. **`Helper/ThoughtoftdHelper.php`** (`Joomla\Module\Thoughtoftd\Site\Helper\ThoughtoftdHelper`) — does the network fetch (`getth2`) via Joomla's `HttpFactory` HTTP client with a timeout, returning a decoded `stdClass` or `false` on any failure. Also owns image selection (`getRandomImage`, `getImageOfTheDay`, `getImages`) and folder path sanitisation (`getFolder`).
3. **`tmpl/*.php`** (layouts) — four interchangeable views: `default.php`, `card.php`, `cardhorizontal.php`, `cardoverlay.php`. Selected via the standard Joomla "Alternative Layout" advanced param. Each guards on `$answ && is_object($answ) && $answ->statusCode == 0` and falls back to the `defaultmsg` param when the fetch failed.

Key cross-cutting conventions:

- **Graceful degradation is the contract.** The helper never lets a network/JSON error surface as a PHP warning — it logs and returns `false`, and every layout renders the configured default message instead. Preserve this when editing fetch/render code.
- **The API response shape** is `{ statusCode, text, topic, image }`; `statusCode == 0` means success. `text` is rendered as raw HTML (the API is trusted to return safe markup); `topic` is escaped.
- **Image modes** (`show_image` param): `none`, `random` (rotates daily over files in `folder`), `static` (`default_img_link`), or `database` (uses `image` from the API response). Image selection lives entirely in the helper.
- **Assets** load via Joomla's Web Asset Manager, not direct `<script>`/`<link>` tags. The read-more collapse JS (`media/js/thoughtoftd.js`) and `bootstrap.collapse` are only registered when the `read_more` param is on.
- **Read-more / collapsible text** is opt-in (`read_more` param). Layouts emit `.thought-text-collapsible` with `data-collapsed-height`/`data-more-text`/`data-less-text`; the JS wraps it in a Bootstrap collapse at runtime.

## Diagnostics

The module logs verbosely to Joomla's logger under the `mod_thoughtoftd` category → `administrator/logs/mod_thoughtoftd.php`. INFO logs include the request URL and a truncated raw response; ERROR logs cover fetch/JSON failures. See `DEBUGGING.md` for the full catalogue of log messages and common API failure modes. These INFO logs are noisy by design for first-install troubleshooting and are candidates to gate or trim for production.

## Localisation

Strings live in `language/<locale>/` for `en-GB`, `es-ES`, `fi-FI`, `pt-PT`, `ru-RU`. User-facing text uses `MOD_THOUGHTOFTD_*` keys via `Text::_()`; add new keys to every locale's `.ini`.

## Reference docs

- `BUILD.md` / `BUILD_QUICK_REFERENCE.md` — full build system details and CI examples.
- `LAYOUTS.md` — visual descriptions, use-cases, and image recommendations for each layout.
- `DEBUGGING.md` — logging locations, log message reference, and API troubleshooting.
