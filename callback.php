  <? Php
   // Set account information.
   // to Channels> Basic information of LINE developers site
   / / We will set the information described.
   $ ChannelId = " 	
ee1655e16f059647f9e25bb8a267c5e1 "; // Channel ID
   $ ChannelSecret = "wnSEoGyt8FGC6wpwEs5Mnb3xqeuKLWbtr1tNtEEiyTjf0cm/rIrjAff3JzZkMDY8Di87XAMMZlbGKHym/DvJxBMbTgfMx6Kvg9itSXDrmMhz4J1VUu5nA5y3xB4n1IcRHf4F3OLqe21tMeRuLs167QdB04t89/1O/w1cDnyilFU=" "; // Channel Secret
   $ Mid = "U263b51adffaa8dce7bc11c20d7ab4fbc " // MID

   // Get the message (body part of POST request) sent from LINE.
   // The following JSON formatted character string is sent.
   // {"result": [
   // {
   // ...
   // "content": {
   // "contentType": 1,
   // "from": "uff2aec188e58752ee1fb0f9507c6529a",
   // "text": "Hello, BOT API Server!"
   // ...
   //}
   //},
   // ...
   //]}
   $ RequestBodyString = file_get_contents ( ' php: // input ' ) ;
   $ RequestBodyObject = json_decode ( $ requestBodyString ) ;
   $ RequestContent = $ requestBodyObject -> result { 0 } -> content ;
   $ RequestText = $ requestContent -> text; // text sent from the user
   $ RequestFrom = $ requestContent -> from; // MID of sending user
   $ ContentType = $ requestContent -> contentType; // data type (1 is text)

   // header of the request to the LINE BOT API
   $ Headers = array (
     " Content-Type: application / json; charset = UTF-8 ",
     " X-Line-ChannelID: { $ channelId } ", // Channel ID
     " X-Line-ChannelSecret: { $ channelSecret } ", // Channel Secret
     " X-Line-Trusted-User-With-ACL: { $ mid } ", // MID
   ) ;

   // Text to return to the user.
   / / Be sure to recommend Umama noodle with Yamagoe.
   $ ResponseText = <<< EOM
 It is " { $ requestText } ".  understood.  In such a case, Yamagoe's Keta Udon udon.  Http : // yamagoeudon.com
 EOM;

   // Create JSON data that will be passed to the user via the LINE BOT API.
   // to designate the MID of the response destination user in the form of an array.
   // toChannel, eventType specifies a fixed numeric value / character string.
   // contentType is 1 if it returns text.
   // toType is 1 in the case of a response to the user.
   // text specifies the text to return to the user.
   $ ResponseMessage = <<< EOM
     {
       " To " : [ " { $ requestFrom } " ] ,
       " ToChannel " : 1383378250 ,
       " EventType " : " 138311608800106203 ",
       " Content " : {
         " ContentType " : 1 ,
         " ToType " : 1 ,
         ' Text ' : " { $ responseText } "
       }
     }
 EOM;

   / / Create and execute a request to the LINE BOT API
   $ Curl = curl_init ( ' https://trialbot-api.line.me/v1/events ' ) ;
   Curl_setopt ( $ curl , CURLOPT_POST, true ) ;
   Curl_setopt ( $ curl , CURLOPT_HTTPHEADER, $ headers ) ;
   Curl_setopt ( $ curl , CURLOPT_POSTFIELDS, $ responseMessage ) ;
   Curl_setopt ( $ curl , CURLOPT_RETURNTRANSFER, true ) ;
   // Specify the proxy URL of Fixie of Heroku Addon.  Details are described below.
   Curl_setopt ( $ curl , CURLOPT_HTTPPROXYTUNNEL, 1 ) ;
   Curl_setopt ( $ curl , CURLOPT_PROXY, getenv ( ' FIXIE_URL ' ))) ;
   $ Output = curl_exec ( $ curl ) ;
 ?>