<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.0/jquery.min.js"></script>

<script>
/*
  $("#submit").click(function() {
	  console.log("-------------- submit");
	  alert("----------------");
                var name= $("#txtusermame").val();
                var password= $("#txtpassword").val();
	  console.log("-------------- submit: " + name);

alert("name: " + name); return;

				$.ajax({
                    type: "POST",
                    url: "insert.php",
                    data: "name=" + name+ "&password=" + password,
                    success: function(data) {
                       alert("sucess");
                    }
                });


            });
*/

jQuery(document).ready(function ($) {

    $("#insert_form").submit(function (event) {
                var name= $("#txtusermame").val();
                var password= $("#txtpassword").val();
alert("name:  ----------" + name + ", pw:" + password); // return;
//	  console.log("-------------- submit: " + name);

				event.preventDefault();
                //validation for login form
        $("#progress").html('Inserting <i class="fa fa-spinner fa-spin" aria-hidden="true"></i></span>');

            var formData = new FormData($(this)[0]);
            $.ajax({
                url: 'insert.php',
                type: 'POST',
                data: formData,
                async: true,
                cache: false,
                contentType: false,
                processData: false,
                success: function (returndata) 
                {
                    //show return answer
                    alert(returndata);
                },
                error: function(){
                alert("error in ajax form submission");
                                    }
        });
        return false;
    });
});
</script> 

<!-- 
<script>
  $("frmrecord").submit(function() {
                var name= $("#txtusermame").val();
                var password= $("#txtpassword").val();
alert("name: " + name); return;
                $.ajax({
                    type: "POST",
                    url: "ulink_ajax.php",
                    data: "name=" + name+ "&password=" + password,
                    success: function(data) {
                       alert("sucess");
                    }
                });


            });
</script>
 -->


<form id="insert_form" method="post">
    <input type="text" id="txtusermame" name="txtusermame" />
    <input type="password" id="txtpassword" name="txtpassword" />
    <input type="submit" value="Insert" />
</form>

