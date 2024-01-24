# MOD_COUNTGHSVS. Joomla site module.

## DE
Joomla-Frontend-Modul. Zählt Zahlen aufwärts von einem Startwert bis zu einem Endwert. Beginnt mit dem Zählen, wenn in den Seitenbereich gescrollt wird, in dem das Modul positioniert ist. Verwendet JQuery JavaScript. Für mich nutzloses, Ressourcen-fressendes Webseiten-Kokolores, aber mancher Kunde will so was.

## EN
Joomla frontend module. Counts numbers up from a start value to an end value. Starts counting when scrolling into the page area where the module is positioned. Uses JQuery JavaScript. For me, useless, resource-guzzling website rubbish, but some customers want something like this.

## Releases/Downloads
- https://github.com/GHSVS-de/mod_countghsvs/releases

-----------------------------------------------------

# My personal build procedure (WSL 1 or 2, Debian, Win 10)
- Prepare/adapt `./package.json`.
- `cd /mnt/z/git-kram/mod_countghsvs`

## node/npm updates/installation
- `npm run updateCheck` or (faster) `npm outdated`
- `npm run update` (if needed) or (faster) `npm update --save-dev`
- `npm install` (if needed)

## Build installable ZIP package
- `node build.js`
- New, installable ZIP is in `./dist` afterwards.
- All packed files for this ZIP can be seen in `./package`. **But only if you disable deletion of this folder at the end of `build.js`**.s

### For Joomla update and changelog server
- Create new release with new tag.
  - See release description in `dist/release_no-changelog.txt`.
- Extracts(!) of the update XML for update servers are in `./dist` as well. Copy/paste and necessary additions.
