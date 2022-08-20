function addPreviewSupport(inputId, previewId) {
    const preview = document.getElementById(previewId);
    const input = document.getElementById(inputId);
    input.addEventListener('change', () => {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = (e) => {
                preview.src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    })
}