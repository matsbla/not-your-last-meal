<script>
    function validateForm(){

        var name=document.forms["logForm"]["name"].value;
        var pass=document.forms["logForm"]["password"].value;
        var count= 0;

        if(name==""){
            document.getElementById("nameSp").innerHTML="Required area";
            count++;
        }

        if(pass.length<7){
            document.getElementById("passSp").innerHTML="7 characters minimum";
            count++;
        }   
        
        if(count==0)
            return true;
        else
            return false;
    }

</script>

<form name="logForm" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" onsubmit="return validateForm()">

    Username<br><input type="text" name="name"> <span id="nameSp"></span>
  <br><br>
    
  Password<br><input type="password" name="password"> <span id="passSp"></span>
  <br><br>
  <input type="submit" value="Sign In">
</form>

<!-- action must be modified!! -->
