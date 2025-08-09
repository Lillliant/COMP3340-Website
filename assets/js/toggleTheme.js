// Toggles between the different CSS themes
function toggleTheme(value) {
  let sheet = document.getElementById("themeStylesheet");
  //console.log(`Original location:${sheet.href}`);
  sheet.href = `/3340/assets/css/${value}.css`;
  //console.log(`Theme changed to ${sheet.href}`);
  // For theme to persist across pages, store in cookie
  const d = new Date();
  d.setTime(d.getTime() + 24 * 60 * 60 * 1000); // persist for 1 day
  document.cookie = `theme=${value}; path=/3340/; expires=${d.toUTCString()}`;
  //console.log(`Cookie set: theme=${value}`);
}
