function toggleTheme(value) {
  let sheet = document.getElementById("themeStylesheet");
  console.log(`Original location: ${sheet.href}`);
  sheet.href = `/3340/assets/css/${value}.css`;
  console.log(`Theme changed to ${sheet.href}`);
}
