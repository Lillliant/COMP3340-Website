function toggleTheme(value) {
  let sheet = document.getElementById("themeStylesheet");
  sheet.href = `assets/css/${value}.css`;
  console.log(`Theme changed to ${sheet.href}`);
}
