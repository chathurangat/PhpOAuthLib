<?php

//die();
/**
 * Logiciel : exemple d'utilisation de HTML2PDF
 *
 * Convertisseur HTML => PDF
 * Distribu� sous la licence LGPL.
 *
 * @author		Laurent MINGUET <webmaster@html2pdf.fr>
 *
 * isset($_GET['vuehtml']) n'est pas obligatoire
 * il permet juste d'afficher le r�sultat au format HTML
 * si le param�tre 'vuehtml' est pass� en param�tre _GET
 */

// r�cup�ration du contenu HTML
ob_start();

if($_REQUEST['type']=='active'){
    include(dirname(__FILE__).'/res/active-pdf.php');
}

if($_REQUEST['type']=='expired'){
    include(dirname(__FILE__).'/res/expired-pdf.php');
}

if($_REQUEST['type']=='notused'){
    include(dirname(__FILE__).'/res/not_used-pdf.php');
}

if($_REQUEST['type']=='room_wifi_usage'){

    include(dirname(__FILE__).'/res/room_wifi_usage-pdf.php');
}

if($_REQUEST['type']=='hotel_wifi_usage'){

    include(dirname(__FILE__).'/res/hotel_wifi_usage-pdf.php');
}


$content = ob_get_clean();

// conversion HTML => PDF
require_once(dirname(__FILE__).'/../html2pdf.class.php');
try
{
    $html2pdf = new HTML2PDF('P','A3','fr', false, 'ISO-8859-15');
    //		$html2pdf->setModeDebug();
    $html2pdf->setDefaultFont('Arial');
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    $html2pdf->Output('lankacom_wifi_usage"'.time().'".pdf');
}
catch(HTML2PDF_exception $e) { echo $e."sssss"; }
	