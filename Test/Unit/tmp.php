<?php

// API

$document = new HtmlDocument($html);

$pdf = new PdfBuilder();
$pdf->addPage($document->printTo(new PdfPage()));
