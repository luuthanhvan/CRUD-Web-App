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
    document.getElementById("btn-them").style.visibility = "hidden";
}

// kiểm tra tính hợp lệ của form nhập bệnh
function validateForm(){
    var checked = false;
    var diseaseId = document.forms['form-nhap']['mabenh'].value;
    var diseaseName = document.forms['form-nhap']['tenbenh'].value;

    if(diseaseId.length == 0){
        document.getElementById("error1").innerHTML = "* Trường mã bệnh không được bỏ trống";
        checked = true;
    }
    if(diseaseName.length == 0){
        document.getElementById("error2").innerHTML = "* Trường tên bệnh không được bỏ trống";
        checked = true;
    }
    return !checked;
}