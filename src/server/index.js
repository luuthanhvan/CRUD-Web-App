// ẩn form nhập bệnh
let attribute = document.getElementsByClassName('form-nhap');
for (let i = 0; i < attribute.length; i++) {
    attribute[i].style.display = 'none';
}

// hiện form nhập bệnh
function show() {
    let attribute = document.getElementsByClassName('form-nhap');
    for (let i = 0; i < attribute.length; i++) {
        attribute[i].style.display = 'block';
    }
}