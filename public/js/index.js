// Image Preview
const img_preview = document.querySelector(".img-preview");
const input_img = document.getElementById("foto");
input_img.addEventListener("change", function (e) {
	img_preview.src = URL.createObjectURL(this.files[0]);
	img_preview.classList.remove("d-none");
});
