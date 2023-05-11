function addPreviewSupport(inputId, previewId) {
  const preview = document.getElementById(previewId);
  const input = document.getElementById(inputId);
  input.addEventListener("change", () => {
    if (input.files && input.files[0]) {
      const reader = new FileReader();
      reader.onload = (e) => {
        preview.src = e.target.result;
      };
      reader.readAsDataURL(input.files[0]);
    }
  });
}

//javascript function SpawnDialog() to spawn a diglog with title, link, info, color, and thumbnail of the entry clicked in the tree
function SpawnDialog(title, link, info, color, thumbnail) {
  var escapedPath = link.replace(/\\/g, "\\\\");

  var dialog = document.createElement("div");
  dialog.className = "dialog";
  //dialog on click event to delete the dialog
  dialog.onclick = function (e) {
    deleteDialog(e.target);
  };
  dialog.innerHTML =
    '<div class="dialog__container">' +
    '<svg onclick="deleteDialog(this)" class="dialog__container__close" width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">' +
    '<path d="M12.5 0C5.5875 0 0 5.5875 0 12.5C0 19.4125 5.5875 25 12.5 25C19.4125 25 25 19.4125 25 12.5C25 5.5875 19.4125 0 12.5 0ZM12.5 22.5C6.9875 22.5 2.5 18.0125 2.5 12.5C2.5 6.9875 6.9875 2.5 12.5 2.5C18.0125 2.5 22.5 6.9875 22.5 12.5C22.5 18.0125 18.0125 22.5 12.5 22.5ZM16.9875 6.25L12.5 10.7375L8.0125 6.25L6.25 8.0125L10.7375 12.5L6.25 16.9875L8.0125 18.75L12.5 14.2625L16.9875 18.75L18.75 16.9875L14.2625 12.5L18.75 8.0125L16.9875 6.25Z" />' +
    "</svg>" +
    '<div class="dialog__container__title">' +
    "<h3>" +
    title +
    "</h3>" +
    "</div>" +
    '<img src="' +
    thumbnail +
    '" alt="' +
    title +
    '" class="dialog__container__thumbnail">' +
    '<p class="dialog__container__info">' +
    info +
    "</p>" +
    '<div class="dialog__container__actions">' +
    `<button class="dialog__container__actions__open" onclick="copyToClipboard('${String.raw`${escapedPath}`}')">Dateipfad kopieren</button>` +
    "</div>" +
    "</div>";

  //get .tree element and append the dialog to it
  var tree = document.getElementsByClassName("navSearch")[0];
  tree.appendChild(dialog);
}

// javascript function to delete .dialog element when onclick on this is clicked
function deleteDialog(e) {
  if (e.classList.contains("dialog__container__close")) {
    e.parentElement.parentElement.remove();
  } else if (e.classList.contains("dialog")) {
    e.remove();
  }
}
function copyToClipboard(value) {
  navigator.clipboard.writeText(value);
  alert("Dateipfad wurde kopiert!");
}
