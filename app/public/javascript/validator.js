function valida(){
      messageEmpty="Este campo es requerido";
      messageCampNum="El valor debe de ser numerico";

      var name = document.getElementById('inputUsername1').value;     
      var password = document.getElementById('inputPassword1').value;     
      //var age = document.getElementById('inputAge1').value;     

      
      var divFailN = document.getElementById("requiredCampName");
      var divFailP = document.getElementById("requiredCampPassword");
    //  var divFailA = document.getElementById("requiredCampAge");

      divFailN.innerText=messageEmpty;
      divFailP.innerText=messageEmpty;
    //  divFailA.innerText=messageEmpty;

          if(name=="")
          {
               divFailN.style.display ="block";
          }else{
                divFailN.style.display ="none";
          }

          if(password=="")
          {
               divFailP.style.display ="block";
          }else{
                divFailP.style.display ="none";
          }
         
          if(age=="")
          {
               divFailA.style.display ="block";
          }else{
                divFailA.style.display ="none";

                if(isNaN(age))
                {
                     divFailA.style.display ="block";
                }
                else
                {
                      divFailA.style.display ="none";
                }
          }
          
      }     