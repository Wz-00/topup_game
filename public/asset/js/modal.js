// select image
const selectImage = document.querySelector('.select-image');
const inputFile = document.querySelector('#image');
const imgArea = document.querySelector('.img-area');


selectImage.addEventListener('click', function (e) {
  e.preventDefault(); // Mencegah default behavior dari tag <input type="file">
  inputFile.click();
})

inputFile.addEventListener('change', function () {
const image = this.files[0]
if(image.size < 20971520) {
  const reader = new FileReader();
  reader.onload = ()=> {
    const allImg = imgArea.querySelectorAll('img');
    allImg.forEach(item=> item.remove());
    const imgUrl = reader.result;
    const img = document.createElement('img');
    img.src = imgUrl;
    imgArea.appendChild(img);
    imgArea.classList.add('active');
    imgArea.dataset.img = image.name;
  }
  reader.readAsDataURL(image);
} else {
  alert("Image size more than 20MB");
}
})

function submitForm() {
  var form = document.getElementById("uploadForm");
  var formData = new FormData(form);

  var xhr = new XMLHttpRequest();
  xhr.open("POST", "process_upload.php", true);
  xhr.onreadystatechange = function () {
      if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
              // Respon sukses dari server, Anda dapat menambahkan logika atau respons tambahan di sini
              console.log("Upload berhasil.");
              // Misalnya, Anda dapat menampilkan pesan sukses kepada pengguna
              alert("Upload berhasil.");
          } else {
              // Terjadi kesalahan saat mengirim permintaan ke server
              console.error("Terjadi kesalahan: " + xhr.statusText);
              // Misalnya, Anda dapat menampilkan pesan kesalahan kepada pengguna
              alert("Terjadi kesalahan saat mengunggah gambar.");
          }
      }
  };
  xhr.send(formData);
}