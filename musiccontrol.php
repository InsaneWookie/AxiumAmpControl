<?php

$config = require('musiccontrolconfig.php');
?>
<!DOCTYPE html>

<html>
   <head>

      <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0;">
      <meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1" />

      <script type="text/javascript" src="/jquery.js" ></script>

      <title>Music control</title>

      <script type='text/javascript'>
	
         $(document).ready(function(){
            $('#btn_savesettings').click(function(){
               $.getJSON('/musiccontrol.ajax.php?action=changezone', $('#form_zonechange').serializeArray(), function(data){
                  // alert(data);
               });
            });
                
            $('.mute').click(function(){
               $.getJSON('/musiccontrol.ajax.php?action=mute', {'zone' : $(this).attr('name')}, function(data){
                  // alert(data);
               });
            });
                
            $('.unmute').click(function(){
               $.getJSON('/musiccontrol.ajax.php?action=unmute', {'zone' : $(this).attr('name')}, function(data){
                  // alert(data);
               });
            });
                
            $('.volume').change(function(){
               $.getJSON('/musiccontrol.ajax.php?action=changevolume', {'zone' : $(this).attr('name'), 'volume' : $(this).val()}, function(data){
                  // alert(data);
               });
            });
                
            $('#alloff').click(function(){
               $.getJSON('/musiccontrol.ajax.php?action=alloff', {}, function(data){
                  // alert(data);
               });
            });
                
            $('#allon').click(function(){
               $.getJSON('/musiccontrol.ajax.php?action=allon', {}, function(data){
                  // alert(data);
               });
            });
         });
        
      </script>

      <style type="text/css">

         /*
         Colours
         
         Purple: #494259
         Light purple: #BCB4D9
         Dark green: #5E7332
         Light green: #91A644
         Lime green: #B1BF41
         
         */
         /* -- Reset default style -- */
         body { 
            margin: 0px;
            padding: 0px;
            font-size: 1.2em; 
            font-family: Arial;
            background-color: #494259;

         }

         table{
            width: 100%;
            border: none;
            
         }
         
         table, tr, td {
            border: none;
            -webkit-border-horizontal-spacing: 0px;
            -webkit-border-vertical-spacing: 0px;
            padding: 0;
         }

         #content{
            width: 800px;
         }
         
         @media only screen and (max-device-width: 800px) {
            #content{
               width: 100%
            }
         }

         
         

         #layout_title{
            background-color: #494259;
            border-bottom: 2px solid #B1BF41;
            text-align: center;
            padding: .2em;
            font-weight: bold;
            color: whitesmoke;
            text-transform: uppercase;
            

         }

         #global_control, .zone-options{
            /* IE10 Consumer Preview */ 
           
         }

         .zone{
            background-color: #BCB4D9;
/*            border: 2px solid #494259;*/
            border-left: 10px solid #5E7332;
            padding: .3em
         }

         input, select, button {
           
            
            color: #494259;
            font-size: 1.3em;
            margin: 0;
            padding: 0;
            height: 40px;
            width: 100%;
            box-sizing: border-box;
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
         }

      </style>



   </head>
   <body id="page-body">
      <div id="content">
         <div id="layout_title">Kereru 15 Amp Control</div>
         <div id="global_control">
            <table>
               <tr>
                  <td><input id="alloff" type="button" value="all off"></td>
                  <td><input id="allon" type="button" value="all on"></td>
               </tr>
            </table>
         </div>

         <?php foreach ($config['areas'] as $area): ?>

            <?php
            $zoneNames = array();
            foreach ($area['speakers'] as $speaker)
            {
               $zoneNames[] = $speaker['name'];
            }
            ?>

            <div class="zone">
               <div><?php echo "Zone {$area['zone']} (" . implode(', ', $zoneNames) . ")"; ?></div>
               <div class="zone-options">
                  <table>
                     <tr>
                        <td>
                           <select class="volume" name='<?php echo $area['zone']; ?>'>
                              <?php for ($i = 0; $i < 100; $i += 10): ?>
                                 <option value="<?php echo $i; ?>"><?php echo $i; ?>%</option>
                              <?php endfor; ?>
                           </select>
                        </td>
                        <td><input class="mute" name="<?php echo $area['zone']; ?>" type="button" value="mute"></td>                  
                        <td><input class="unmute" name="<?php echo $area['zone']; ?>" type="button" value="unmute"> </td>
                     </tr>
                  </table>

               </div>
            </div>

         <?php endforeach; ?>
      </div>
   </body>
</html>
