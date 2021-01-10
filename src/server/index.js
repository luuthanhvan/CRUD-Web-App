// ẩn form nhập bệnh
let attribute = document.getElementsByClassName('form-nhap');// đối tượng form 
for (let i = 0; i < attribute.length; i++) { // duyệt hết tất cả phần tử bên trong form rồi cho display thành none
    attribute[i].style.display = 'none'; // thuộc tính css display thay đổi form là ẩn đi "none"
}

// hiện form nhập bệnh
function show() {
    let attribute = document.getElementsByClassName('form-nhap');
    for (let i = 0; i < attribute.length; i++) {
        attribute[i].style.display = 'block'; // tương tự thằng trên nhưng sẽ làm cho nó hiện ra bằng thuộc tính css display là block
    }
    document.getElementById("btn-them1").style.visibility = "hidden";
}// ẩn đi nút thêm bằng thuộc tính css visibility là hidden, tức là nhấn cho form thêm bệnh sẽ mất nút này.

// kiểm tra tính hợp lệ của form nhập bệnh
function validateForm(){
    var checked = false;
    // lấy giá trị mã bệnh
    var diseaseId = document.forms['form-nhap']['mabenh'].value;
    // lấy giá trị tên bệnh 
    var diseaseName = document.forms['form-nhap']['tenbenh'].value;
// kiểm tra độ dài của các hàng mã bệnh và tên bệnh
    if(diseaseId.length == 0){
        document.getElementById("error1").innerHTML = "* Trường mã bệnh không được bỏ trống";
        checked = true;
    }
    if(diseaseId.length > 10){
        document.getElementById("error1").innerHTML = "* Trường mã bệnh có độ dài tối đa là 10";
        checked = true;
    }
    if(diseaseName.length == 0){
        document.getElementById("error2").innerHTML = "* Trường tên bệnh không được bỏ trống";
        checked = true;
    }
    return !checked;
}