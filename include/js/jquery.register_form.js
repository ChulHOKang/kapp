var reg_mb_id_check = function() {
    //alert("js_url : " + js_url); // js_url : https://modumodu.net/kapp/include/js
    var result = "";
    $.ajax({
        type: "POST",
        url: js_url+"/ajax.mb_id.php",
        data: {
            "reg_mb_id": encodeURIComponent($("#reg_mb_id").val())
        },
        cache: false,
        async: false,
        success: function(data) {
            result = data;
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert("데이터 타입, 또는 URL이 올바르지 않습니다.-- ajax.mb_id.php");
            console.log(jqXHR);
            console.log(textStatus);
            console.log(errorThrown);
            return;
        }
    });
    return result;
}


// 추천인 검사
var reg_mb_recommend_check = function() {
    var result = "";
    $.ajax({
        type: "POST",
        url: js_url+"/ajax.mb_recommend.php",
        data: {
            "reg_mb_recommend": encodeURIComponent($("#reg_mb_recommend").val())
        },
        cache: false,
        async: false,
        success: function(data) {
            result = data;
        }
    });
    return result;
}


var reg_mb_nick_check = function() {
    var result = "";
    $.ajax({
        type: "POST",
        url: js_url+"/ajax.mb_nick.php",
        data: {
            "reg_mb_nick": ($("#reg_mb_nick").val()),
            "reg_mb_id": encodeURIComponent($("#reg_mb_id").val())
        },
        cache: false,
        async: false,
        success: function(data) {
            result = data;
        }
    });
    return result;
}


var reg_mb_email_check = function() {
	//alert('-------- jquery.register_form.js - js_url: ' + js_url);
	//-------- jquery.register_form.js - js_url: http://urllinkcoin.com/t/include/js
    var result = "";
    $.ajax({
        type: "POST",
        url: js_url+"/ajax.mb_email.php",
        data: {
            "reg_mb_email": $("#reg_mb_email").val(),
            "reg_mb_id": encodeURIComponent($("#reg_mb_id").val())
        },
        cache: false,
        async: false,
        success: function(data) {
            result = data;
        }
    });
    return result;
}


var reg_mb_hp_check = function() {
    var result = "";
    $.ajax({
        type: "POST",
        url: js_url+"/ajax.mb_hp.php",
        data: {
            "reg_mb_hp": $("#reg_mb_hp").val(),
            "reg_mb_id": encodeURIComponent($("#reg_mb_id").val())
        },
        cache: false,
        async: false,
        success: function(data) {
            result = data;
        }
    });
    return result;
}