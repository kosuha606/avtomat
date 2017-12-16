<?php

$xml = new \DOMDocument();
$xml_album = $xml->createElement("Album");
$xml_track = $xml->createElement("Track");
$xml_album->appendChild( $xml_track );
$xml->appendChild( $xml_album );

$xml->save("code.xml");
