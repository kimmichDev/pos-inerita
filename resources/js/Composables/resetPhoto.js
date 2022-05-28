let resetPhoto = () => {
    document.querySelector(
        "[selectPhotoContainer]"
    ).innerHTML = `
                <p class="p-3 mb-0 border-1 border text-center rounded shadow"  style="cursor: pointer">
                    Click to upload image
                </p>
                `;
}
export { resetPhoto };