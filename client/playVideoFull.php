<?php
if(isset($_GET["v"]))
{
	include_once("coneccion/conn.php");
	$link = conn();
	/* Seleccionar un dron y ejecutar rutina de verificacion de funcionalidad. */
	$videoFeedURL = "";
	$typeVideo = "video/ogg";													// Agregar nuevo campo a la tabla acerca del formato de video.
	/* Obtener el identifcador de la empresa ala que pertenece $_GET['v'] y apartir del id
	 * de la empresa obtener lalista de drones que estan disponibles y online. */
	
	$query = 'SELECT
			dronOnline.idDronOnline,
			dronOnline.IPAddr,
			dronOnline.wsURL,
			dronOnline.videoURL
		FROM
			dronOnline
		WHERE
			dronOnline.isOnline = true AND
			dronOnline.isLibre = true AND
			dronOnline.idEmpresa = (SELECT vuelo.idEmpresa FROM vuelo WHERE vuelo.idVuelo ='.$_GET['v'].')
		LIMIT 2';
		
	$result= mysql_query ($querySelect, $link) or die(mysql_error());
	
	if( mysql_num_rows ( $result ) ){				// False si no hay resultado, int si hay registros.
		$row = mysql_fetch_assoc($result);			//Tomar el primero.
		
		//obtener el id del cliente. ¿cookie? ¿session?
		
		/////Pediente id clente.
		$idCliente = 2;															//Debug. Borrar.
		
		
		// Modificar estado del dron a ocupado (0).
		//$query = 'UPDATE dronOnline SET isLibre=false WHERE idDronOnline ='.$row['idDronOnline'];		//Funciona 
		
		//Insertar en la tabla vueloRecorrido
		 //PENDIENTE
		 
		 
		$videoFeedURL = $row['videoURL'];
		//$typeVideo = $row['videoType'];		//Pendiente crear coampo en la tabla. !!!!!!!!!!!!
		$typeVideo = "video/ogg"; 
	}
	else{
		//No se devolvio ningun resultado. Significa que ningun dron esta online y esta disponible, o todos estan ocupado.
		echo "Porfavor intente mas tarde. Todos los drones estan ocupados. Reservar, calcular tiempo de espera.";
	}
}
else {
	$videoFeedURL = "http://video-js.zencoder.com/oceans-clip.ogv";				//DEBUG. Borrar
	$typeVideo = "video/ogg";
}

?>
<!DOCTYPE html>
<html>
<head>
    <title></title>

    <link rel="stylesheet" media="screen" type="text/css" title="Design" href="css/playVideoFull.css">
	
	<!-- Chang URLs to wherever Video.js files will be hosted -->
	<link href="players/video-js/video-js.css" rel="stylesheet" type="text/css">
	<!-- video.js must be in the <head> for older IEs to work. -->
	<script type="text/javascript" src="players/video-js/video.js"></script>

    <link href="bootstrap/bootstrap.css" rel="stylesheet" type="text/css">
</head>
<body>
    <!-- **************************************************************************************************************************** -->
    <header>
        <img src="images/logo/HackBotsLogoBlanco_150x37px.png">

    <!--
        <div id="lang">
            <div id="around">&nbsp;</div>
            <ul style="float:left;">
                <li><a href="http://www.paris-26-gigapixels.com/index-fr.html" title="Français"><img src="./Paris26Gigapixels_files/flag-fr.gif" alt="Français" width="17" height="17"></a></li>
                <li><a href="./Paris26Gigapixels_files/Paris26Gigapixels.htm" title="English"><img src="./Paris26Gigapixels_files/flag-uk.gif" alt="English" width="17" height="17"></a></li>
            </ul>
        </div>
    -->
    <!--
        <div id="hdview">
            <a href="http://www.paris-26-gigapixels.com/HDView/index-en.php" title="View Paris 26 Gigapixels with HD View"><img src="./Paris26Gigapixels_files/hdview.png" width="50" height="38" alt="View Paris 26 Gigapixels with HD View"></a>
        </div>
        <div id="realisation"><img src="./Paris26Gigapixels_files/project.png" width="112" height="25" alt="A project by"><br>
            <a href="http://www.kolor.com/" title="Kolor" target="_blank"><img src="./Paris26Gigapixels_files/kolor.png" width="133" height="39" alt="Kolor"></a>&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="http://www.arnaudfrichphoto.com/" title="Arnaud Frich" target="_blank"><img src="./Paris26Gigapixels_files/arnaud-frich.png" width="133" height="39" alt="Arnaud Frich"></a>&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="http://www.martinloyer.fr/en/" title="Martin Loyer" target="_blank"><img src="./Paris26Gigapixels_files/martin-loyer.png" width="133" height="39" alt="Martin Loyer"></a>
        </div>
    -->
    </header>



    <!-- **************************************************************************************************************************** -->
    
    <section id="videoPlayer">
        <!--
        <embed type="application/x-shockwave-flash" src="Paris20GP.swf" width="100%" height="100%" style="undefined" id="krpanoSWFObject" name="krpanoSWFObject" bgcolor="#000000" quality="high" allowfullscreen="true" flashvars="xml=Paris20GP-en.xml">
        -->
        <video id="videoMain_1" class="video-js vjs-default-skin" controls preload="none" width="100%" height="100%"
            data-setup="{}">
            <!--
            <source src="http://video-js.zencoder.com/oceans-clip.mp4" type='video/mp4' />
            <source src="http://video-js.zencoder.com/oceans-clip.webm" type='video/webm' />
            <source src="http://video-js.zencoder.com/oceans-clip.ogv" type='video/ogg' />
            <source src="<?php echo $sourceVideo ?>"  type="<?php echo $typeVideo; ?>"/></source>
            -->
            <source src="<?php echo $videoFeedURL; ?>" type="<?php echo $typeVideo; ?>" />
        </video>
    </section>

    














    <!-- **************************************************************************************************************************** -->
    <footer>
        Hola
        <!-- Los anuncios flotantes que parecen en la parte de abajo -->

        <div id="cadres">
            <!-- Cuadro 1 -->
            <!--
            <div id="cadre1">
                <table class="cadre">
                    <tbody><tr>
                        <td class="topLeft corner">&nbsp;</td>
                        <td class="centerTop side1">&nbsp;</td>
                        <td class="topRight corner">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="centerLeft side2">&nbsp;</td>
                        <td class="contain"><div class="titreCadre">Welcome to Paris!</div>
                        <div class="textCadre">
                            Paris 26 Gigapixels is a stitching of 2346 single photos showing a very high-resolution panoramic view of the French capital (354159x75570 px). Dive in the image and visit Paris like never before!<br>
                            <br>
                            <img src="./Paris26Gigapixels_files/arrow.gif" width="6" height="5" alt=""> <a href="http://blog.paris-26-gigapixels.com/en/?page_id=2" title="En savoir plus" target="_blank">Learn more about the project</a><br>
                            <img src="./Paris26Gigapixels_files/arrow.gif" width="6" height="5" alt=""> <a href="http://blog.paris-26-gigapixels.com/en/" title="Le blog" target="_blank">Visit the project's blog</a>
                        </div>
                        </td>
                        <td class="centerRight side2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="bottomLeft corner">&nbsp;</td>
                        <td class="centerBottom side1">&nbsp;</td>
                        <td class="bottomRight corner">&nbsp;</td>
                    </tr>
                </tbody></table>
            </div>
            -->
            <!-- Cuadro 2 -->
            <!--
            <div id="cadre2">
                <table class="cadre">
                    <tbody><tr>
                        <td class="topLeft corner">&nbsp;</td>
                        <td class="centerTop side1">&nbsp;</td>
                        <td class="topRight corner">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="centerLeft side2">&nbsp;</td>
                        <td class="contain"><div class="titreCadre">Switch to the panoramic format!</div>
                        <div class="textCadre">
                            <p align="center"><a href="http://www.kolor.com/" target="_blank"><img src="./Paris26Gigapixels_files/autopano.png" alt="autopano" width="132" height="30" border="0"></a><br>
                              Autopano: <a href="http://www.kolor.com/panorama-software-autopano-pro.html" target="_blank">panorama software</a><br>
                            Panotour: <a href="http://www.kolor.com/panotour-pro-profesionnal-360-virtual-tour-software-home.html" target="_blank">virtual tour software</a></p>
                          <p>&nbsp;</p>
                          <div class="titreCadre">About technics</div>
                            <p>&nbsp;</p>
                            <p><img src="./Paris26Gigapixels_files/arrow.gif" width="6" height="5" alt=""> <a href="http://blog.paris-26-gigapixels.com/en/?p=115" title="Making of: step 1, the shooting" target="_blank">Shooting</a> <img src="./Paris26Gigapixels_files/arrow.gif" width="6" height="5" alt=""> <a href="http://blog.paris-26-gigapixels.com/en/?p=110" title="Making of: step 2, the stitching of Paris" target="_blank">Stitching</a> <img src="./Paris26Gigapixels_files/arrow.gif" width="6" height="5" alt=""> <a href="http://blog.paris-26-gigapixels.com/en/?p=114" title="Making of: step 3, the rendering" target="_blank">Rendering</a><br>
                            </p>
                        </div>
                        </td>
                        <td class="centerRight side2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="bottomLeft corner">&nbsp;</td>
                        <td class="centerBottom side1">&nbsp;</td>
                        <td class="bottomRight corner">&nbsp;</td>
                    </tr>
                </tbody></table>
            </div>
            -->
            <!-- Cuadro 3 -->
            <!--
            <div id="cadre3">
                <table class="cadre">
                    <tbody>
                        <tr>
                            <td class="topLeft corner">&nbsp;</td>
                            <td class="centerTop side1">&nbsp;</td>
                            <td class="topRight corner">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="centerLeft side2">&nbsp;</td>
                            <td class="contain">
                                <div class="titreCadre">Make the buzz!</div>
                                <div class="textCadre">
                                    <center>
                                    <a href="http://www.facebook.com/share.php?u=http://www.paris-26-gigapixels.com/&t=" title="Share on Facebook" target="_blank"><img src="./Paris26Gigapixels_files/en-share-on-facebook.png" width="85" height="27" alt="Share on Facebook"></a>
                                    
                                    <a href="http://www.facebook.com/pages/Paris-26-Gigapixels/251682104919" title="Paris 26 Gigapixels on Facebook" target="_blank"><img src="./Paris26Gigapixels_files/en-become-a-fan-facebook.png" width="85" height="27" alt="Paris 26 Gigapixels on Facebook"></a>
                                    
                                    <a href="http://twitter.com/home/?status=Dive%20into%20the%20world's%20largest%20image%20ever%20http%3A%2F%2Fwww.paris-26-gigapixels.com%2F" title="Share on Twitter" target="_blank"><img src="./Paris26Gigapixels_files/en-share-on-twitter.png" width="85" height="27" alt="Share on Twitter"></a>
                                    
                                    <a href="http://www.paris-26-gigapixels.com/index-en.html#" title="Share my position" onclick="return showHTML(&#39;Share my current position in the image&#39;, &#39;share-en&#39;, 500, 100);"><img src="./Paris26Gigapixels_files/en-share-my-position.png" width="85" height="27" alt="Share my position"></a><br>
                                    <br>
                                    <br>
                                    
                                    
                                    <div class="addthis_toolbox addthis_default_style">
                                        <center>
                                            <a href="http://www.addthis.com/bookmark.php?v=250&username=xa-4b87cd9c1a98f365" class="addthis_button_compact at300m" target="_blank"><span class="at16nc at300bs at15nc at15t_compact at16t_compact"><span class="at_a11y">More Sharing Services</span></span>Share</a>
                                            <span class="addthis_separator">|</span>
                                            <a class="addthis_button_facebook at300b" title="Facebook" href="http://www.paris-26-gigapixels.com/index-en.html#"><span class="at16nc at300bs at15nc at15t_facebook at16t_facebook"><span class="at_a11y">Share on facebook</span></span></a>
                                            <a class="addthis_button_myspace at300b" href="http://www.addthis.com/bookmark.php?v=300&winname=addthis&pub=xa-4b87cd9c1a98f365&source=tbx-300&lng=en-US&s=myspace&url=http%3A%2F%2Fwww.paris-26-gigapixels.com%2Findex-en.html&title=Paris%2026%20Gigapixels%20-%20Interactive%20virtual%20tour%20of%20the%20most%20beautiful%20monuments%20of%20Paris&ate=AT-xa-4b87cd9c1a98f365/-/-/51bbdaee73a959d1/2&frommenu=1&uid=51bbdaee79d96778&ct=1&pre=http%3A%2F%2Fwww.google.com%2Furl%3Fsa%3Df%26rct%3Dj%26url%3Dhttp%3A%2F%2Fwww.paris-26-gigapixels.com%2F%26q%3Dhttp%3A%2F%2Fwww.paris-26-gigapixels.com%2Findex-en.html%26ei%3Dzcy7UazxCMbcqAHL8ICQDg%26usg%3DAFQjCNErvmBnMpV00mCDObbOT0dzGGMsVg&tt=0&captcha_provider=nucaptcha" target="_blank" title="MySpace"><span class="at16nc at300bs at15nc at15t_myspace at16t_myspace"><span class="at_a11y">Share on myspace</span></span></a>
                                            <a class="addthis_button_google at300b" href="http://www.addthis.com/bookmark.php?v=300&winname=addthis&pub=xa-4b87cd9c1a98f365&source=tbx-300&lng=en-US&s=google&url=http%3A%2F%2Fwww.paris-26-gigapixels.com%2Findex-en.html&title=Paris%2026%20Gigapixels%20-%20Interactive%20virtual%20tour%20of%20the%20most%20beautiful%20monuments%20of%20Paris&ate=AT-xa-4b87cd9c1a98f365/-/-/51bbdaee73a959d1/3&frommenu=1&uid=51bbdaee88969272&ct=1&pre=http%3A%2F%2Fwww.google.com%2Furl%3Fsa%3Df%26rct%3Dj%26url%3Dhttp%3A%2F%2Fwww.paris-26-gigapixels.com%2F%26q%3Dhttp%3A%2F%2Fwww.paris-26-gigapixels.com%2Findex-en.html%26ei%3Dzcy7UazxCMbcqAHL8ICQDg%26usg%3DAFQjCNErvmBnMpV00mCDObbOT0dzGGMsVg&tt=0&captcha_provider=nucaptcha" target="_blank" title="Google"><span class="at16nc at300bs at15nc at15t_google at16t_google"><span class="at_a11y">Share on google</span></span></a>
                                            <a class="addthis_button_twitter at300b" title="Tweet" href="http://www.paris-26-gigapixels.com/index-en.html#"><span class="at16nc at300bs at15nc at15t_twitter at16t_twitter"><span class="at_a11y">Share on twitter</span></span></a>
                                        </center>
                                        <div class="atclear"></div>
                                    </div>
                                    <script type="text/javascript" src="./Paris26Gigapixels_files/addthis_widget.js"></script>
                                    
                                    
                                    </center>
                                </div>
                            </td>
                            <td class="centerRight side2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="bottomLeft corner">&nbsp;</td>
                            <td class="centerBottom side1">&nbsp;</td>
                            <td class="bottomRight corner">&nbsp;</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            -->
            <!-- Cuadro 4 -->
            <!--
            <div id="cadre4">
                <table class="cadre">
                    <tbody><tr>
                        <td class="topLeft corner">&nbsp;</td>
                        <td class="centerTop side1">&nbsp;</td>
                        <td class="topRight corner">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="centerLeft side2">&nbsp;</td>
                        <td class="contain"><div class="titreCadre">Making &amp; Partners</div>
                      <div class="textCadre partner">
                            <img src="./Paris26Gigapixels_files/arrow.gif" width="6" height="5" alt=""> Spotting : <a href="http://www.martinloyer.fr/en/" title="Martin Loyer" target="_blank">Martin Loyer</a><br>
                            <img src="./Paris26Gigapixels_files/arrow.gif" width="6" height="5" alt=""> Shooting : <a href="http://www.arnaudfrichphoto.com/" title="Arnaud Frich" target="_blank">Arnaud Frich</a><br>
                            <img src="./Paris26Gigapixels_files/arrow.gif" width="6" height="5" alt=""> Image-stiching : <a href="http://www.kolor.com/" title="Kolor" target="_blank">Kolor</a><br>
                            <img src="./Paris26Gigapixels_files/arrow.gif" width="6" height="5" alt=""> Interaction : <a href="http://www.kolor.com/" title="Kolor" target="_blank">Kolor</a> &amp; <a href="http://www.visites-interactives.eu/" title="Arrêts sur Images" rel="nofollow" target="_blank">Arrêts sur Images</a><br><br>
                            
                            <center><a href="http://www.intel.com/" title="Intel" target="_blank"><img src="./Paris26Gigapixels_files/intel.png" width="45" height="30" alt="Intel"></a>&nbsp;&nbsp;
                            <a href="http://www.sfr.fr/" title="SFR" target="_blank"><img src="./Paris26Gigapixels_files/sfr.png" width="30" height="30" alt="SFR"></a>&nbsp;&nbsp;
                                <a href="http://www.ipsyn.net/" title="IPSyn" target="_blank"><img src="./Paris26Gigapixels_files/ipsyn.png" width="29" height="30" alt="IPSyn"></a><br>
                            <br>
                            <a href="http://blog.paris-26-gigapixels.com/en/?page_id=106" title="Contact-us" target="_blank">Contact</a> - <a href="http://blog.paris-26-gigapixels.com/en/?page_id=5" title="Press" target="_blank">Press</a> - <a href="http://www.paris-26-gigapixels.com/index-en.html#" onclick="return showHTML(&#39;Legal notice&#39;, &#39;mentions-en&#39;, 500, 340);">Legal notice</a></center>
                        </div>
                        </td>
                        <td class="centerRight side2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="bottomLeft corner">&nbsp;</td>
                        <td class="centerBottom side1">&nbsp;</td>
                        <td class="bottomRight corner">&nbsp;</td>
                    </tr>
                </tbody></table>
            </div>
            -->
        </div>
    </footer>

    <script type="text/javascript" src="js/jquery-1.10.1.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>
	
</body>
</html>
<?php
	mysql_free_result($result);
	mysql_close($link);
?>