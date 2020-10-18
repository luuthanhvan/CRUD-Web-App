function validateForm(){
    var checked = false;
    var searchContent = document.forms['form-search']['DSTrieuchung'].value;
    // window.alert(searchContent);
    if(searchContent.length == 0){
        document.getElementById("emptyError").innerHTML = "Bạn phải nhập các triệu chứng trước khi bấm nút tìm kiếm.";
        checked = true;
    }
    if(searchContent.search(", ") == -1 && searchContent.search(" ") > -1){
        document.getElementById("emptyError").innerHTML = "Các triệu chứng phải phân cách nhau bởi dấu phẩy";
        checked = true;
    }
    return !checked;
}

function search(content){
    if(content.length == 0){
        document.getElementById("showContent").innerHTML = "";
        return;
    }

    var listTC = content.split(", ");
    
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