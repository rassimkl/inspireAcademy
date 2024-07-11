<!-- Free to use, HTML email template designed & built by FullSphere. Learn more about us at www.fullsphere.co.uk -->

<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">

<head>

  <!--[if gte mso 9]>
  <xml>
    <o:OfficeDocumentSettings>
      <o:AllowPNG/>
      <o:PixelsPerInch>96</o:PixelsPerInch>
    </o:OfficeDocumentSettings>
  </xml>
  <![endif]-->

  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="x-apple-disable-message-reformatting">
  <!--[if !mso]><!--><meta http-equiv="X-UA-Compatible" content="IE=edge"><!--<![endif]-->

    <!-- Your title goes here -->
    <title>Newsletter</title>
    <!-- End title -->

    <!-- Start stylesheet -->
    <style type="text/css">
      a,a[href],a:hover, a:link, a:visited {
        /* This is the link colour */
        text-decoration: none!important;
        color: #0000EE;
      }
      .link {
        text-decoration: underline!important;
      }
      p, p:visited {
        /* Fallback paragraph style */
        font-size:15px;
        line-height:24px;
        font-family:'Helvetica', Arial, sans-serif;
        font-weight:300;
        text-decoration:none;
        color: #000000;
      }
      h1 {
        /* Fallback heading style */
        font-size:22px;
        line-height:24px;
        font-family:'Helvetica', Arial, sans-serif;
        font-weight:normal;
        text-decoration:none;
        color: #000000;
      }
      .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td {line-height: 100%;}
      .ExternalClass {width: 100%;}


      .class-info {
    background-color: #f0f0f0;
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 10px;
}

.class-info p {
    margin: 0;
}

.class-info .class-date {
    font-weight: bold;
    color: #007bff; /* Blue color */
}

.class-info .class-hour {
    font-weight: bold;
    color: #007bff; /* Blue color */
}
    </style>
    <!-- End stylesheet -->

</head>

  <!-- You can change background colour here -->
  <body style="text-align: center; margin: 0; padding-top: 10px; padding-bottom: 10px; padding-left: 0; padding-right: 0; -webkit-text-size-adjust: 100%;background-color: #f2f4f6; color: #000000" align="center">
  
  <!-- Fallback force center content -->
  <div style="text-align: center;">

    <!-- Email not displaying correctly -->
    <table align="center" style="text-align: center; vertical-align: middle; width: 600px; max-width: 600px;" width="600">
      <tbody>
        <tr>
          <td style="width: 596px; vertical-align: middle;" width="596">


          </td>
        </tr>
      </tbody>
    </table>
    <!-- Email not displaying correctly -->
    
    <!-- Start container for logo -->
    <table align="center" style="text-align: center; vertical-align: top; width: 600px; max-width: 600px; background-color: #ffffff;" width="600">
      <tbody>
        <tr>
          <td style="width: 596px; vertical-align: top; padding-left: 0; padding-right: 0; padding-top: 15px; padding-bottom: 15px;" width="596">

            <!-- Your logo is here -->
              <img style="width: 180px; max-width: 180px; height: 85px; max-height: 85px; text-align: center; color: #ffffff;" alt="Logo" src="https://www.inspireacademy.fr/wp-content/uploads/2016/04/titlelogodesign-01.png" align="center" width="180" height="85">

          </td>
        </tr>
      </tbody>
    </table>
    <!-- End container for logo -->

    <!-- Hero image -->
    <!-- Hero image -->

    <!-- Start single column section -->
    <table align="center" style="text-align: center; vertical-align: top; width: 600px; max-width: 600px; background-color: #ffffff;" width="600">
        <tbody>
          <tr>
            <td style="width: 596px; vertical-align: top; padding-left: 30px; padding-right: 30px; padding-top: 10px; padding-bottom: 40px;" width="596">

              <h1 style="font-size: 20px; line-height: 24px; font-family: 'Helvetica', Arial, sans-serif; font-weight: 600; text-decoration: none; color: #000000;">Your Next class Is schedueled</h1>

<div class="class-info">
    <p>You have a class on <span class="class-date">{{$date}}</span> at <span class="class-hour">{{$start_time}}</span> for <span class="class-hour">
     @php
        // Extract hours and minutes
        $hours = floor($class->hours);
        $minutes = ($class->hours - $hours) * 60;

        // Format minutes to two digits
        $formatted_minutes = str_pad($minutes, 2, '0', STR_PAD_LEFT);

        // Output the time format
        echo "$hours:$formatted_minutes";
    @endphp {{Str::plural("Hour", $hours);}}</span>.</p>


</div>            

<p></p>
              <!-- Start button (You can change the background colour by the hex code below) -->
           
              <!-- End button here -->

            </td>
          </tr>
        </tbody>
      </table>
   
      <!-- End image -->

      <!-- Start footer -->
      <table align="center" style="text-align: center; vertical-align: top; width: 600px; max-width: 600px; background-color: #000000;" width="600">
        <tbody>
          <tr>
            <td style="width: 596px; vertical-align: top; padding-left: 30px; padding-right: 30px; padding-top: 30px; padding-bottom: 30px;" width="596">

              <!-- Your inverted logo is here -->
              <img style="width: 180px; max-width: 180px; height: 85px; max-height: 85px; text-align: center; color: #ffffff;" alt="Logo" src="https://www.inspireacademy.fr/wp-content/uploads/2016/04/titlelogodesign-01.png" align="center" width="180" height="85">

              <p style="font-size: 13px; line-height: 24px; font-family: 'Helvetica', Arial, sans-serif; font-weight: 400; text-decoration: none; color: #ffffff;">
               25 All. du Moura, 64200 Biarritz
              </p>

              <p style="margin-bottom: 0; font-size: 13px; line-height: 24px; font-family: 'Helvetica', Arial, sans-serif; font-weight: 400; text-decoration: none; color: #ffffff;">
                <a target="_blank" style="text-decoration: underline; color: #ffffff;" href="www.Inspireacademy.fr">
                  www.Inspireacademy.fr
                </a>
              </p>

            </td>
          </tr>
        </tbody>
      </table>
      <!-- End footer -->
    
      <!-- Start unsubscribe section -->
   
      <!-- End unsubscribe section -->
  
  </div>

  </body>

</html>