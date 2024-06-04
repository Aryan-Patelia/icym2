

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>icymadbad.com</title>
  <link rel="canonical" href="https://getbootstrap.com/docs/5.2/examples/navbars-offcanvas/">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.min.js"
    integrity="sha512-WW8/jxkELe2CAiE4LvQfwm1rajOS8PHasCCx+knHG0gBHt8EXxS6T6tJRTGuDQVnluuAvMxWF4j8SNFDKceLFg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap-grid.min.css"
    integrity="sha512-ZuRTqfQ3jNAKvJskDAU/hxbX1w25g41bANOVd1Co6GahIe2XjM6uVZ9dh0Nt3KFCOA061amfF2VeL60aJXdwwQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css"
    integrity="sha512-b2QcS5SsA8tZodcDtGRELiGv5SaKSk1vDHDaQRda0htPYWZ6046lr3kJ5bAAQdpV2mmA/4v0wQF9MyU6/pDIAg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="style.css">


  <style>
    .language_choose {
      padding: 30px;
      font-size: medium;
      background-attachment: fixed;
      color: black;
      text-align: center;
      border-radius: 30px;
      justify-content: center;
      margin-top: 60px;
    }
    .form-control{
        font-size: larger;
        font-family: 'Times New Roman', Times, serif;
        box-shadow: 15px 15px 15px solid black;
    }
    .content{
      background-color : white;
      padding : 25px;
      color : black;
      border-radius : 25px;
      
    }
  </style>
  <script>
    function changeLanguage() {
      var selectedLanguage = document.getElementById("languageSelect").value;

      if (selectedLanguage === "en") {
        document.getElementById("englishContent").style.display = "block";
        document.getElementById("gujaratiContent").style.display = "none";
      } else if (selectedLanguage === "gu") {
        document.getElementById("englishContent").style.display = "none";
        document.getElementById("gujaratiContent").style.display = "block";
      }
    }
  </script>


</head>
 
<body style="background-image: url(images/bg-1.jpg) ; background-attachment: fixed;">
 <nav class="navbar navbar-expand-lg bg-body-tertiary text-center  fs-5">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="icym_25.png" alt="Logo" id="navbar-logo" style="max-height: 100px; max-width: 100px;" onerror="this.onerror=null;this.src='alternative_logo.png';">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="posts/">Posts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="news/">YouCat</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="news/">Daily News</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="calendar/">Coming Events Calendar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="jobs/">Job Offers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="magazines/">Magazines</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="gallery/">Gallery</a>
                </li>
            </ul>
        </div>
    </div>
</nav>



  <div class="container" style="margin-top: 160px;">
    <div class="row justify-content-center">
      <div class="col-md-6 text-center">
        <img src="images/logo-2.png" class="img-fluid" alt="Image" style="border-radius: 50%;">
      </div>
    </div>

  </div>
  <div class="container">

    <div class="container" style="justify-content: center;">
      <div class="form-group glassmorphism language_choose" style="width: 100%;">
        <label for="languageSelect"><b>Select Language:</b></label>
        <select class="form-control" id="languageSelect" onchange="changeLanguage()">
          <option value="en"><b>English</b></option>
          <option value="gu"><b>ગુજરાતી</b></option>
        </select>
      </div>
    </div>

    <div id="englishContent">
      <div class="container mt-5 content p-5"
        style="border-radius: 20px;margin-top: 50px;background: circular-gradient(to bottom, #bdc3c7, #2c3e50);        ">
        
        <h1 style="color: black;margin-top: 10px;margin-bottom: 20px;">I.C.Y.M (Indian Catholic Youth Moment)</h1>
        <p class="mob-text" style="color: rgb(0, 0, 0);font-size: 20px;">
     
        ICYM INDIA 

“ The Indian Catholic Youth Movement” (ICYM) is a parochial youth movement under the aegis of the CCBI Commission for Youth, focused at animating a holistic growth of all the youth under the Latin rite parishes in India. It works as the National Youth Animating Organization that enables young people be protagonists to build a “Synodal” or co-responsible church and a better society. (Cfr. Synod on Youth 2018)

 Goal of ICYM To foster and promote Christian Youth Leadership for a New India. Movement functions around 14 Regions and 132 latin rite diocese in india
                
        </p>
        <br><hr>

        
        <h1 style="color: black;margin-top: 10px;margin-bottom: 20px;">VISION</h1>
        <p class="mob-text" style="color: rgb(0, 0, 0);font-size: 20px;">
     
                We the Latin Catholic Youth of India are in the midst of a changing world. At this juncture, with hope and courage, we unite to remove all obstacles that come in our way to achieving a renewed society in faith and love. With our firm catholic faith, we give ourselves wholeheartedly for the formation of a better India and a world.
                The scope and the key areas of the work of ICYM is the promotion and encouragement of Catholic youth in Catholic Faith and Vocation, their personal commitment to Catholic values, and inspired by it, enable the youth to build a society transformed in God. In particular, the ICYM focuses on the holistic growth of the Catholic youth and on their ensuing commitment towards the Church and the larger society in India.
                We dedicate this vision to the young people of India as we join hands in uplifting the ICYM Movement.
        </p>
        <br><hr>

        <h1 style="color: black;margin-top: 10px;margin-bottom: 20px;">MISSION</h1>
        <p class="mob-text" style="color: rgb(0, 0, 0);font-size: 20px;">
        “We the Latin Catholic Youth Representatives of India, motivated by the Gospel values, commit ourselves to empower youth to learn, lead and serve each other and the society in faith, hope and love.
                It is our firm conviction that our mission is to lead all the Youth to empowerment, employment, economic welfare, personal and societal wholeness and to preserve the national integrity through dialogue and respect for all religions irrespective of caste and creed.
       
        </p>
        <br><hr>
      </div>
    </div>







    <div id="gujaratiContent" style="display: none;">
      <div class="container mt-5 content p-5"
        style="border-radius: 20px;margin-top: 50px;background: circular-gradient(to bottom, #bdc3c7, #2c3e50);        ">
      
          
        <h1 style="color: black;margin-top: 10px;margin-bottom: 20px;">I.C.Y.M (Indian Catholic Youth Moment)</h1>
        <p class="mob-text" style="color: rgb(0, 0, 0);font-size: 20px;">
     
        ICYM INDIA 

        “ધ ઈન્ડિયન કેથોલિક યુથ મૂવમેન્ટ” (ICYM) એ CCBI કમિશન ફોર યુથના નેજા હેઠળ એક સંકુચિત યુવા ચળવળ છે, જે ભારતમાં લેટિન વિધિ પરગણા હેઠળ તમામ યુવાનોની સર્વગ્રાહી વૃદ્ધિને એનિમેટ કરવા પર કેન્દ્રિત છે. તે નેશનલ યુથ એનિમેટીંગ ઓર્ગેનાઈઝેશન તરીકે કામ કરે છે જે યુવાનોને "સિનોડલ" અથવા સહ-જવાબદાર ચર્ચ અને વધુ સારા સમાજનું નિર્માણ કરવા માટે નાયક બનવા સક્ષમ બનાવે છે. (યુવા 2018 પર Cfr. સિનોડ)
        ICYM નો ધ્યેય નવા ભારત માટે ખ્રિસ્તી યુવા નેતૃત્વને પ્રોત્સાહન આપવા અને પ્રોત્સાહન આપવા માટે. આ ચળવળ ભારતમાં 14 પ્રદેશો અને 132 લેટિન વિધિ પંથકની આસપાસ કાર્ય કરે છે  
      </p>
        <br><hr>

        
        <h1 style="color: black;margin-top: 10px;margin-bottom: 20px;">VISION</h1>
        <p class="mob-text" style="color: rgb(0, 0, 0);font-size: 20px;">
     
        "અમે ભારતના લેટિન કેથોલિક યુવાઓ બદલાતી દુનિયાની વચ્ચે છીએ. આ સમયે, આશા અને હિંમત સાથે, અમે વિશ્વાસ અને પ્રેમમાં નવેસરથી સમાજને પ્રાપ્ત કરવાના અમારા માર્ગમાં આવતા તમામ અવરોધોને દૂર કરવા માટે એક થઈએ છીએ. અમારી દ્રઢ કેથોલિક શ્રદ્ધા સાથે, અમે બહેતર ભારત અને વિશ્વની રચના માટે પૂરા દિલથી અમારી જાતને આપીએ છીએ.
            ICYM ના કાર્યનો અવકાશ અને મુખ્ય ક્ષેત્રો કેથોલિક વિશ્વાસ અને વ્યવસાયમાં કેથોલિક યુવાનોને પ્રોત્સાહન અને પ્રોત્સાહન, કેથોલિક મૂલ્યો પ્રત્યેની તેમની વ્યક્તિગત પ્રતિબદ્ધતા, અને તેનાથી પ્રેરિત થઈને, યુવાનોને ઈશ્વરમાં રૂપાંતરિત સમાજનું નિર્માણ કરવા સક્ષમ બનાવે છે. ખાસ કરીને, ICYM કેથોલિક યુવાનોની સર્વગ્રાહી વૃદ્ધિ અને ભારતમાં ચર્ચ અને મોટા સમાજ પ્રત્યેની તેમની આગામી પ્રતિબદ્ધતા પર ધ્યાન કેન્દ્રિત કરે છે.
            અમે આ વિઝન ભારતના યુવાનોને સમર્પિત કરીએ છીએ કારણ કે અમે ICYM ચળવળના ઉત્થાનમાં હાથ મિલાવીએ છીએ."
        </p>
        <br><hr>

        <h1 style="color: black;margin-top: 10px;margin-bottom: 20px;">MISSION</h1>
        <p class="mob-text" style="color: rgb(0, 0, 0);font-size: 20px;">
        “અમે ભારતના લેટિન કેથોલિક યુવા પ્રતિનિધિઓ, Gospel મૂલ્યોથી પ્રેરિત, વિશ્વાસ, આશા અને પ્રેમથી એકબીજાને અને સમાજને શીખવા, નેતૃત્વ કરવા અને સેવા આપવા માટે યુવાનોને સશક્ત કરવા માટે પ્રતિબદ્ધ છીએ.
                અમારો દ્રઢ વિશ્વાસ છે કે અમારું મિશન તમામ યુવાનોને સશક્તિકરણ, રોજગાર, આર્થિક કલ્યાણ, વ્યક્તિગત અને સામાજિક સંપૂર્ણતા તરફ દોરી જવાનું છે અને જાતિ અને સંપ્રદાયને ધ્યાનમાં લીધા વિના સંવાદ અને તમામ ધર્મોના આદર દ્વારા રાષ્ટ્રીય અખંડિતતા જાળવવાનું છે."
       
        </p>
        <br><hr>

      </div>
    </div>

  </div>
  <?php include('assests/footer.php'); ?>
</body>

</html>