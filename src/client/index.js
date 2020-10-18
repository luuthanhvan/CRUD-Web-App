// kiểm tra form hợp lệ
function validateForm(){
    var checked = false;
    // lấy nội dung bên trong thẻ input, type = search
    var searchContent = document.forms['form-search']['DSTrieuchung'].value;

    // kiểm tra nếu độ dài chuỗi = 0, tức là chưa nhập gì
    if(searchContent.length == 0){
        // hiển thị thông báo lỗi
        document.getElementById("emptyError").innerHTML = "* Bạn phải nhập các triệu chứng trước khi bấm nút tìm kiếm.";
        checked = true;
    }
    // tìm trong chuỗi người dùng nhập nếu không chứa dấu , và chứa ký tự khoảng trắng
    if(searchContent.search(", ") == -1 && searchContent.search(" ") > -1){
        // hiển thị thông báo lỗi
        document.getElementById("emptyError").innerHTML = "* Các triệu chứng phải phân cách nhau bởi dấu phẩy";
        checked = true;
    }
    return !checked;
}

// giao tiếp với server và tìm những keyword ứng với từng ký tự mà ng dùng nhập
function search(content){
    // nếu người dùng chưa nhập thì không hiển thị gì cả
    if(content.length == 0){
        document.getElementById("showContent").innerHTML = "";
        return;
    }

    // tách chuỗi thành những sub string
    var listTC = content.split(", ");
    
    // lấy từng giá trị trong mảng và gửi lên server xử lý
    for(var value of listTC){
        console.log(value);
        var xmlHTTP;
        if(window.XMLHttpRequest){
            xmlHTTP = new XMLHttpRequest();
        }
        else{
            xmlHTTP = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlHTTP.onreadystatechange = function(){
            if(xmlHTTP.readyState == 4 && xmlHTTP.status == 200){
                console.log(xmlHTTP.responseText);
                document.getElementById("showContent").innerHTML = xmlHTTP.responseText;
            }
        }
        xmlHTTP.open("GET", `../server/handleSearching.php?content=${value}`, true);
        xmlHTTP.send();
    }
}